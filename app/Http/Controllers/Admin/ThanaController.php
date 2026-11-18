<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Thana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ThanaController extends Controller
{
    public function index(Request $request): View
    {
        $districtId = $request->integer('district') ?: null;

        $thanas = Thana::with('district')
            ->when($districtId, fn ($q) => $q->where('district_id', $districtId))
            ->orderBy('district_id')
            ->orderBy('name_bn')
            ->get();

        $districts = District::orderBy('name_en')->get();

        return view('admin.thanas.index', compact('thanas', 'districts', 'districtId'));
    }

    public function create(Request $request): View
    {
        return view('admin.thanas.form', [
            'thana' => new Thana(),
            'districts' => District::orderBy('name_en')->get(),
            'selectedDistrict' => $request->integer('district') ?: null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Thana::create($this->validated($request));

        return redirect()->route('admin.thanas.index')->with('success', 'উপজেলা যোগ হয়েছে।');
    }

    public function edit(Thana $thana): View
    {
        return view('admin.thanas.form', [
            'thana' => $thana,
            'districts' => District::orderBy('name_en')->get(),
            'selectedDistrict' => $thana->district_id,
        ]);
    }

    public function update(Request $request, Thana $thana): RedirectResponse
    {
        $thana->update($this->validated($request));

        return redirect()->route('admin.thanas.index')->with('success', 'উপজেলা আপডেট হয়েছে।');
    }

    public function destroy(Thana $thana): RedirectResponse
    {
        $thana->delete();

        return back()->with('success', 'উপজেলা মুছে ফেলা হয়েছে।');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'district_id' => ['required', 'exists:districts,id'],
            'name_bn' => ['required', 'string', 'max:80'],
            'name_en' => ['required', 'string', 'max:80'],
        ]);
    }
}
