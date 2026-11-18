<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DistrictController extends Controller
{
    public function index(): View
    {
        $districts = District::withCount('thanas')->orderBy('name_en')->get();

        return view('admin.districts.index', compact('districts'));
    }

    public function create(): View
    {
        return view('admin.districts.form', ['district' => new District()]);
    }

    public function store(Request $request): RedirectResponse
    {
        District::create($this->validated($request));

        return redirect()->route('admin.districts.index')->with('success', 'জেলা যোগ হয়েছে।');
    }

    public function edit(District $district): View
    {
        return view('admin.districts.form', compact('district'));
    }

    public function update(Request $request, District $district): RedirectResponse
    {
        $district->update($this->validated($request));

        return redirect()->route('admin.districts.index')->with('success', 'জেলা আপডেট হয়েছে।');
    }

    public function destroy(District $district): RedirectResponse
    {
        $district->delete();

        return back()->with('success', 'জেলা মুছে ফেলা হয়েছে।');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name_bn' => ['required', 'string', 'max:80'],
            'name_en' => ['required', 'string', 'max:80'],
            'division_bn' => ['required', 'string', 'max:80'],
            'division_en' => ['required', 'string', 'max:80'],
        ]);
    }
}
