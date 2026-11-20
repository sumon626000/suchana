<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShowcaseCertificate;
use App\Support\PublicUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'certificate' => new ShowcaseCertificate,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title_bn' => ['nullable', 'string', 'max:120'],
            'title_en' => ['nullable', 'string', 'max:120'],
            'subtitle_bn' => ['nullable', 'string', 'max:160'],
            'subtitle_en' => ['nullable', 'string', 'max:160'],
            'image' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'sort_order' => ['nullable', 'integer'],
        ], [
            'image.required' => 'সার্টিফিকেট ছবি আপলোড করুন।',
            'image.image' => 'শুধু JPG, PNG, WebP বা GIF আপলোড করা যাবে।',
            'image.mimes' => 'শুধু JPG, PNG, WebP বা GIF আপলোড করা যাবে।',
            'image.max' => 'ছবি সর্বোচ্চ ৫MB হতে পারবে।',
        ]);

        $data['image'] = PublicUpload::store($request->file('image'), 'showcase-certificates', ['jpg', 'jpeg', 'png', 'webp', 'gif']);
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
            'image' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('image')) {
            PublicUpload::delete($showcase_certificate->image);
            $data['image'] = PublicUpload::store($request->file('image'), 'showcase-certificates', ['jpg', 'jpeg', 'png', 'webp', 'gif']);
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
        PublicUpload::delete($showcase_certificate->image);
        $showcase_certificate->delete();

        return back()->with('success', 'সার্টিফিকেট শোকেস থেকে মুছে ফেলা হয়েছে।');
    }
}
