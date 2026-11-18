<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Course;
use App\Models\Gallery;
use App\Models\Notice;
use App\Models\ShowcaseCertificate;
use App\Models\Staff;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function home(): View
    {
        $courses = Course::where('is_active', true)->orderBy('sort_order')->get();
        $staff = Staff::where('is_active', true)->orderBy('sort_order')->get();
        $branches = Branch::where('is_active', true)->orderBy('sort_order')->take(4)->get();
        $notices = Notice::where('is_active', true)->orderByDesc('published_at')->take(3)->get();
        $gallery = Gallery::where('is_active', true)->orderBy('sort_order')->get();
        $showcaseCertificates = ShowcaseCertificate::active()->orderBy('sort_order')->get();

        $stats = [
            'courses' => $courses->count(),
            'seats' => $courses->sum('seats_total'),
            'branches' => Branch::where('is_active', true)->count(),
            'stipend' => (int) ($courses->max('stipend_female') ?? 7200),
        ];

        return view('public.home', compact('courses', 'staff', 'branches', 'notices', 'stats', 'gallery', 'showcaseCertificates'));
    }

    public function courses(): View
    {
        $courses = Course::where('is_active', true)->orderBy('sort_order')->get();

        return view('public.courses', compact('courses'));
    }

    public function course(Course $course): View
    {
        $course->load('batches');

        return view('public.course', compact('course'));
    }

    public function branches(): View
    {
        $branches = Branch::where('is_active', true)->orderBy('sort_order')->get();

        return view('public.branches', compact('branches'));
    }

    public function notices(): View
    {
        $notices = Notice::where('is_active', true)->orderByDesc('published_at')->get();

        return view('public.notices', compact('notices'));
    }

    public function about(): View
    {
        $staff = Staff::where('is_active', true)->orderBy('sort_order')->get();

        return view('public.about', compact('staff'));
    }

    public function contact(): View
    {
        $branches = Branch::where('is_active', true)->orderBy('sort_order')->get();

        return view('public.contact', compact('branches'));
    }

    public function privacy(): View
    {
        return view('public.privacy');
    }

    public function terms(): View
    {
        return view('public.terms');
    }

    public function faq(): View
    {
        return view('public.faq');
    }
}
