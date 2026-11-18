<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BatchController extends Controller
{
    public function index(): View
    {
        $batches = Batch::with(['course', 'trainer'])->orderBy('id')->get();

        return view('admin.batches.index', compact('batches'));
    }

    public function create(): View
    {
        return view('admin.batches.form', $this->formData(new Batch()));
    }

    public function store(Request $request): RedirectResponse
    {
        Batch::create($this->validated($request));

        return redirect()->route('admin.batches.index')->with('success', 'ব্যাচ যোগ হয়েছে।');
    }

    public function edit(Batch $batch): View
    {
        return view('admin.batches.form', $this->formData($batch));
    }

    public function update(Request $request, Batch $batch): RedirectResponse
    {
        $batch->update($this->validated($request));

        return redirect()->route('admin.batches.index')->with('success', 'ব্যাচ আপডেট হয়েছে।');
    }

    public function destroy(Batch $batch): RedirectResponse
    {
        $batch->delete();

        return back()->with('success', 'ব্যাচ মুছে ফেলা হয়েছে।');
    }

    private function formData(Batch $batch): array
    {
        return [
            'batch' => $batch,
            'courses' => Course::orderBy('sort_order')->get(),
            'trainers' => User::where('role', 'trainer')->orderBy('name')->get(),
        ];
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'trainer_id' => ['nullable', 'exists:users,id'],
            'name_bn' => ['required', 'string', 'max:80'],
            'name_en' => ['required', 'string', 'max:80'],
            'time_bn' => ['nullable', 'string', 'max:120'],
            'time_en' => ['nullable', 'string', 'max:120'],
            'seats' => ['required', 'integer', 'min:0'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
