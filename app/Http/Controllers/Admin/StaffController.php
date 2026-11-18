<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function index(): View
    {
        $staff = Staff::orderBy('sort_order')->get();

        return view('admin.staff.index', compact('staff'));
    }

    public function create(): View
    {
        return view('admin.staff.form', ['person' => new Staff()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Staff::create($this->validated($request));

        return redirect()->route('admin.staff.index')->with('success', 'কর্তৃপক্ষ যোগ হয়েছে।');
    }

    public function edit(Staff $staff): View
    {
        return view('admin.staff.form', ['person' => $staff]);
    }

    public function update(Request $request, Staff $staff): RedirectResponse
    {
        $staff->update($this->validated($request));

        return redirect()->route('admin.staff.index')->with('success', 'তথ্য আপডেট হয়েছে।');
    }

    public function destroy(Staff $staff): RedirectResponse
    {
        $staff->delete();

        return back()->with('success', 'মুছে ফেলা হয়েছে।');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'designation' => 'required|string|max:120',
            'photo' => 'nullable|string|max:500',
            'bio' => 'nullable|string',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:120',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) $request->input('sort_order', 0);

        $request->validate([
            'photo_file' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('photo_file')) {
            $data['photo'] = $request->file('photo_file')->store('staff', 'public');
        }

        return $data;
    }
}
