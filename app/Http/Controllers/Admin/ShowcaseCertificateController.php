<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShowcaseCertificate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ShowcaseCertificateController extends Controller
{
    public function index(): View
    {
        $certificates = ShowcaseCertificate::orderBy('sort_order')->get();

        return view('admin.showcase-certificates.index', compact('certificates'));
    }

    public function create(): View
    {
        return view('admin.showcase-certificates.form', [
            'certificate' => new ShowcaseCertificate(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title_bn' => ['nullable', 'string', 'max:120'],
            'title_en' => ['nullable', 'string', 'max:120'],
            'subtitle_bn' => ['nullable', 'string', 'max:160'],
            'subtitle_en' => ['nullable', 'string', 'max:160'],
            'image' => ['required', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $data['image'] = $request->file('image')->store('showcase-certificates', 'public');
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) $request->input('sort_order', 0);

        ShowcaseCertificate::create($data);

        return redirect()->route('admin.showcase-certificates.index')
            ->with('success', 'সার্টিফিকেট শোকেসে যোগ হয়েছে।');
    }

    public function edit(ShowcaseCertificate $showcase_certificate): View
    {
        return view('admin.showcase-certificates.form', [
            'certificate' => $showcase_certificate,
        ]);
    }

    public function update(Request $request, ShowcaseCertificate $showcase_certificate): RedirectResponse
    {
        $data = $request->validate([
            'title_bn' => ['nullable', 'string', 'max:120'],
            'title_en' => ['nullable', 'string', 'max:120'],
            'subtitle_bn' => ['nullable', 'string', 'max:160'],
            'subtitle_en' => ['nullable', 'string', 'max:160'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('image')) {
            $old = $showcase_certificate->image;
            $data['image'] = $request->file('image')->store('showcase-certificates', 'public');
            $this->deleteLocalFile($old);
        } else {
            unset($data['image']);
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) $request->input('sort_order', 0);

        $showcase_certificate->update($data);

        return redirect()->route('admin.showcase-certificates.index')
            ->with('success', 'সার্টিফিকেট শোকেস আপডেট হয়েছে।');
    }

    public function destroy(ShowcaseCertificate $showcase_certificate): RedirectResponse
    {
        $this->deleteLocalFile($showcase_certificate->image);
        $showcase_certificate->delete();

        return back()->with('success', 'সার্টিফিকেট শোকেস থেকে মুছে ফেলা হয়েছে।');
    }

    private function deleteLocalFile(?string $path): void
    {
        if (! $path || str_starts_with($path, 'http') || str_starts_with($path, 'images/')) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
