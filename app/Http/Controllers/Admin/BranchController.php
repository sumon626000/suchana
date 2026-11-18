<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BranchController extends Controller
{
    public function index(): View
    {
        $branches = Branch::orderBy('sort_order')->get();

        return view('admin.branches.index', compact('branches'));
    }

    public function create(): View
    {
        return view('admin.branches.form', ['branch' => new Branch()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Branch::create($this->validated($request));

        return redirect()->route('admin.branches.index')->with('success', 'ব্রাঞ্চ যোগ হয়েছে।');
    }

    public function edit(Branch $branch): View
    {
        return view('admin.branches.form', compact('branch'));
    }

    public function update(Request $request, Branch $branch): RedirectResponse
    {
        $branch->update($this->validated($request));

        return redirect()->route('admin.branches.index')->with('success', 'ব্রাঞ্চ আপডেট হয়েছে।');
    }

    public function destroy(Branch $branch): RedirectResponse
    {
        $branch->delete();

        return back()->with('success', 'ব্রাঞ্চ মুছে ফেলা হয়েছে।');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name_bn' => 'required|string|max:120',
            'name_en' => 'required|string|max:120',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:120',
            'image' => 'nullable|string|max:500',
            'map_url' => 'nullable|string|max:500',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) $request->input('sort_order', 0);

        $request->validate([
            'image_file' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image_file')) {
            $data['image'] = $request->file('image_file')->store('branches', 'public');
        }

        return $data;
    }
}
