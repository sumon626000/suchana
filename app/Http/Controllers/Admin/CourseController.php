<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        $courses = Course::orderBy('sort_order')->get();

        return view('admin.courses.index', compact('courses'));
    }

    public function create(): View
    {
        return view('admin.courses.form', ['course' => new Course]);
    }

    public function store(Request $request): RedirectResponse
    {
        Course::create($this->validated($request));

        return redirect()->route('admin.courses.index')->with('success', 'কোর্স যোগ হয়েছে।');
    }

    public function edit(Course $course): View
    {
        return view('admin.courses.form', compact('course'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $course->update($this->validated($request, $course));

        return redirect()->route('admin.courses.index')->with('success', 'কোর্স আপডেট হয়েছে।');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $this->deleteLocalImage($course->image);
        $course->delete();

        return back()->with('success', 'কোর্স মুছে ফেলা হয়েছে।');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?Course $course = null): array
    {
        $data = $request->validate([
            'name_bn' => ['required', 'string', 'max:120'],
            'name_en' => ['required', 'string', 'max:120'],
            'level' => ['required', 'string', 'max:40'],
            'duration_bn' => ['nullable', 'string', 'max:40'],
            'duration_en' => ['nullable', 'string', 'max:40'],
            'eligibility_bn' => ['nullable', 'string'],
            'eligibility_en' => ['nullable', 'string'],
            'description_bn' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'seats_total' => ['required', 'integer', 'min:0'],
            'seats_available' => ['required', 'integer', 'min:0'],
            'fee' => ['nullable', 'numeric', 'min:0'],
            'stipend_male' => ['nullable', 'numeric', 'min:0'],
            'stipend_female' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'string', 'max:500'],
            'application_deadline' => ['nullable', 'date'],
            'image_file' => ['nullable', 'image', 'max:5120'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) $request->input('sort_order', 0);
        $data['fee'] = $data['fee'] ?? 0;
        $data['stipend_male'] = $data['stipend_male'] ?? 0;
        $data['stipend_female'] = $data['stipend_female'] ?? 0;

        unset($data['image_file'], $data['remove_image']);

        if ($request->boolean('remove_image') && $course) {
            $this->deleteLocalImage($course->image);
            $data['image'] = null;
        }

        if ($request->hasFile('image_file')) {
            if ($course) {
                $this->deleteLocalImage($course->image);
            }

            $data['image'] = $this->storeCourseImage($request->file('image_file'));
        }

        return $data;
    }

    private function storeCourseImage(UploadedFile $file): string
    {
        $directory = public_path('uploads/courses');
        File::ensureDirectoryExists($directory);

        $filename = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'uploads/courses/'.$filename;
    }

    private function deleteLocalImage(?string $path): void
    {
        if (! $path || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return;
        }

        if (str_starts_with($path, 'uploads/') && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
