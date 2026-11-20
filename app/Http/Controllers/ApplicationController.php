<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Batch;
use App\Models\Course;
use App\Models\District;
use App\Models\Thana;
use App\Services\TransactionalMailer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function create(Request $request): View
    {
        $courses = Course::where('is_active', true)->orderBy('sort_order')->get();
        $districts = District::orderBy('name_en')->get();
        $selectedCourse = $request->integer('course') ?: null;

        $thanasByDistrict = Thana::query()
            ->with('district')
            ->whereHas('district')
            ->get()
            ->groupBy(fn (Thana $thana) => $thana->district?->name_bn ?? '')
            ->reject(fn ($group, $districtName) => $districtName === '')
            ->map(fn ($group) => $group->pluck('name_bn')->filter()->values())
            ->toArray();

        $batches = Batch::query()
            ->with('course')
            ->where('is_active', true)
            ->whereHas('course')
            ->orderBy('name_bn')
            ->get();

        return view('student.apply', compact('courses', 'districts', 'selectedCourse', 'thanasByDistrict', 'batches'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'batch_id' => ['nullable', 'exists:batches,id'],
            'full_name' => ['required', 'string', 'max:120'],
            'nid' => ['required', 'string', 'max:30'],
            'mobile' => ['required', 'regex:/^01[3-9]\d{8}$/'],
            'email' => ['required', 'email', 'max:120'],
            'district' => ['required', 'string', 'max:60'],
            'thana' => ['required', 'string', 'max:60'],
            'bank_name' => ['required', 'string', 'max:80'],
            'bank_account' => ['required', 'string', 'max:40'],
            'bank_branch' => ['required', 'string', 'max:80'],
            'consent' => ['accepted'],
        ], [
            'mobile.regex' => 'সঠিক মোবাইল নম্বর দিন (যেমন: 017XXXXXXXX)।',
            'consent.accepted' => 'শর্তাবলীতে সম্মতি দিন।',
        ]);

        unset($data['consent']);

        $user = $request->user();

        $duplicate = $user->applications()
            ->where('course_id', $data['course_id'])
            ->whereIn('status', ['pending', 'verified', 'approved'])
            ->exists();

        if ($duplicate) {
            return back()->withInput()->withErrors([
                'course_id' => 'এই কোর্সে আপনার একটি সক্রিয় আবেদন ইতিমধ্যে আছে।',
            ]);
        }

        $data['user_id'] = $user->id;
        $data['application_no'] = $this->generateApplicationNo();
        $data['status'] = 'pending';

        $application = Application::create($data);
        $application->load('course');

        app(TransactionalMailer::class)->applicationReceived($application);

        return redirect()->route('applications.show', $application)
            ->with('success', 'আবেদন সফলভাবে জমা হয়েছে। আপনার আবেদন নম্বর: '.$application->application_no);
    }

    public function show(Request $request, Application $application): View
    {
        $user = $request->user();
        $isOwner = $application->user_id === $user->id;
        $isStaff = in_array($user->role, ['admin', 'trainer'], true);

        if (! $isOwner && ! $isStaff) {
            abort(403);
        }

        $application->load(['course', 'batch']);

        return view('student.application', compact('application'));
    }

    public function trackForm(): View
    {
        return view('public.track', ['application' => null, 'searched' => false]);
    }

    public function track(Request $request): View
    {
        $data = $request->validate([
            'application_no' => ['required', 'string', 'max:40'],
        ]);

        $application = Application::where('application_no', trim($data['application_no']))
            ->with(['course', 'batch'])
            ->first();

        return view('public.track', ['application' => $application, 'searched' => true]);
    }

    private function generateApplicationNo(): string
    {
        $year = now()->format('Y');
        $count = Application::whereYear('created_at', now()->year)->count() + 1;

        do {
            $no = sprintf('SMTTI-%s-%05d', $year, $count);
            $count++;
        } while (Application::where('application_no', $no)->exists());

        return $no;
    }
}
