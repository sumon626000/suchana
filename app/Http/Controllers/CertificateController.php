<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class CertificateController extends Controller
{
    public function index(): View
    {
        $certificates = Certificate::with(['user', 'course'])->latest()->get();
        $students = User::where('role', 'student')->orderBy('name')->get();
        $courses = Course::orderBy('sort_order')->get();

        return view('admin.certificates.index', compact('certificates', 'students', 'courses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'course_id' => ['required', 'exists:courses,id'],
            'pdf_file' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $exists = Certificate::where('user_id', $data['user_id'])
            ->where('course_id', $data['course_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'এই শিক্ষার্থীর এই কোর্সের সার্টিফিকেট আগেই তৈরি হয়েছে।');
        }

        $certificate = $this->createCertificate($data['user_id'], $data['course_id'], $request->user()->id);

        if ($request->hasFile('pdf_file')) {
            $certificate->update([
                'pdf_path' => $this->storeCertificatePdf($request->file('pdf_file'), $certificate),
            ]);
        }

        return back()->with('success', 'সার্টিফিকেট তৈরি হয়েছে।'.($request->hasFile('pdf_file') ? ' PDF আপলোড হয়েছে।' : ''));
    }

    public function uploadPdf(Request $request, Certificate $certificate): RedirectResponse
    {
        $request->validate([
            'pdf_file' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        if ($certificate->hasUploadedPdf()) {
            File::delete($certificate->pdfPublicPath());
        }

        $certificate->update([
            'pdf_path' => $this->storeCertificatePdf($request->file('pdf_file'), $certificate),
        ]);

        return back()->with('success', 'সার্টিফিকেট PDF আপলোড হয়েছে।');
    }

    public function auto(Request $request): RedirectResponse
    {
        $applications = Application::where('status', 'approved')->get();
        $created = 0;

        foreach ($applications as $application) {
            $exists = Certificate::where('user_id', $application->user_id)
                ->where('course_id', $application->course_id)
                ->exists();

            if (! $exists) {
                $this->createCertificate($application->user_id, $application->course_id, $request->user()->id);
                $created++;
            }
        }

        return back()->with('success', "{$created} টি সার্টিফিকেট স্বয়ংক্রিয়ভাবে তৈরি হয়েছে।");
    }

    public function destroy(Certificate $certificate): RedirectResponse
    {
        if ($certificate->hasUploadedPdf()) {
            File::delete($certificate->pdfPublicPath());
        }

        $certificate->delete();

        return back()->with('success', 'সার্টিফিকেট মুছে ফেলা হয়েছে।');
    }

    public function show(string $no): View
    {
        $certificate = Certificate::with(['user', 'course'])
            ->where('certificate_no', $no)
            ->orWhere('verification_code', $no)
            ->firstOrFail();

        $qr = $this->qrDataUri(route('verify.code', $certificate->certificate_no));

        return view('certificates.show', compact('certificate', 'qr'));
    }

    public function pdf(string $no): Response|BinaryFileResponse
    {
        $certificate = Certificate::with(['user', 'course'])
            ->where('certificate_no', $no)
            ->orWhere('verification_code', $no)
            ->firstOrFail();

        if ($certificate->hasUploadedPdf()) {
            $filename = Str::slug($certificate->user?->name ?? 'certificate').'-'.$certificate->certificate_no.'.pdf';

            return response()->file($certificate->pdfPublicPath(), [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$filename.'"',
            ]);
        }

        $logo1 = 'data:image/jpeg;base64,'.base64_encode(file_get_contents(public_path('images/logo-suchana.jpg')));
        $logo2 = 'data:image/jpeg;base64,'.base64_encode(file_get_contents(public_path('images/logo-sfdb.jpg')));
        $qr = $this->qrDataUri(route('verify.code', $certificate->certificate_no), 160);
        $verifyUrl = route('verify.code', $certificate->certificate_no);

        $options = new Options;
        $options->setChroot(realpath(base_path()));
        $options->setIsRemoteEnabled(true);
        $options->setIsHtml5ParserEnabled(true);
        $options->setFontDir(storage_path('fonts'));
        $options->setFontCache(storage_path('fonts'));
        // Dompdf's explode_url returns an empty protocol for file:// URIs,
        // so '' must be allowed for local font registration to work.
        $options->setAllowedProtocols([
            '' => ['rules' => []],
            'data://' => ['rules' => []],
            'file://' => ['rules' => []],
            'http://' => ['rules' => []],
            'https://' => ['rules' => []],
        ]);

        $dompdf = new Dompdf($options);
        $fontMetrics = $dompdf->getFontMetrics();
        $fontMetrics->registerFont(
            ['family' => 'Hind', 'weight' => 'normal', 'style' => 'normal'],
            storage_path('app/fonts/HindSiliguri-Regular.ttf')
        );
        $fontMetrics->registerFont(
            ['family' => 'Hind', 'weight' => 'bold', 'style' => 'normal'],
            storage_path('app/fonts/HindSiliguri-Bold.ttf')
        );

        $html = view('certificates.pdf', compact('certificate', 'logo1', 'logo2', 'qr', 'verifyUrl'))->render();

        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('a4', 'landscape');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$certificate->certificate_no.'.pdf"',
        ]);
    }

    public function verifyCode(string $code): View
    {
        $certificate = Certificate::with(['user', 'course'])
            ->where('certificate_no', $code)
            ->orWhere('verification_code', $code)
            ->first();

        return view('public.verify', ['certificate' => $certificate, 'searched' => true]);
    }

    private function qrDataUri(string $text, int $size = 240): string
    {
        $result = (new Builder)->build(data: $text, size: $size, margin: 6);

        return 'data:'.$result->getMimeType().';base64,'.base64_encode($result->getString());
    }

    public function verifyForm(): View
    {
        return view('public.verify', ['certificate' => null, 'searched' => false, 'query' => null]);
    }

    public function verify(Request $request): View
    {
        $data = $request->validate(['code' => ['required', 'string', 'max:60']]);

        $certificate = Certificate::with(['user', 'course'])
            ->where('certificate_no', trim($data['code']))
            ->orWhere('verification_code', trim($data['code']))
            ->first();

        return view('public.verify', ['certificate' => $certificate, 'searched' => true]);
    }

    private function createCertificate(int $userId, int $courseId, int $issuedBy): Certificate
    {
        return Certificate::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'certificate_no' => $this->uniqueCertificateNo(),
            'verification_code' => strtoupper(Str::random(10)),
            'issued_at' => now(),
            'issued_by' => $issuedBy,
            'status' => 'issued',
        ]);
    }

    private function storeCertificatePdf(UploadedFile $file, Certificate $certificate): string
    {
        $directory = public_path('uploads/certificates');
        File::ensureDirectoryExists($directory);

        $filename = $certificate->certificate_no.'-'.Str::uuid()->toString().'.pdf';
        $file->move($directory, $filename);

        return 'uploads/certificates/'.$filename;
    }

    private function uniqueCertificateNo(): string
    {
        $year = now()->format('Y');
        $count = Certificate::whereYear('created_at', now()->year)->count() + 1;

        do {
            $no = sprintf('SUCHANA-CERT-%s-%05d', $year, $count);
            $count++;
        } while (Certificate::where('certificate_no', $no)->exists());

        return $no;
    }
}
