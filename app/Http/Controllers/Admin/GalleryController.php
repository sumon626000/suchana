<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $images = Gallery::orderBy('sort_order')->get();

        return view('admin.gallery.index', compact('images'));
    }

    public function create(): View
    {
        return view('admin.gallery.form', ['image' => new Gallery()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title_bn' => ['nullable', 'string', 'max:120'],
            'title_en' => ['nullable', 'string', 'max:120'],
            'image' => ['required', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $data['image'] = $request->file('image')->store('gallery', 'public');
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) $request->input('sort_order', 0);

        Gallery::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'ছবি যোগ হয়েছে।');
    }

    public function edit(Gallery $gallery): View
    {
        return view('admin.gallery.form', ['image' => $gallery]);
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $data = $request->validate([
            'title_bn' => ['nullable', 'string', 'max:120'],
            'title_en' => ['nullable', 'string', 'max:120'],
            'image' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('image')) {
            $old = $gallery->image;
            $data['image'] = $request->file('image')->store('gallery', 'public');
            $this->deleteLocalFile($old);
        } else {
            unset($data['image']);
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = (int) $request->input('sort_order', 0);

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'ছবি আপডেট হয়েছে।');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $this->deleteLocalFile($gallery->image);
        $gallery->delete();

        return back()->with('success', 'ছবি মুছে ফেলা হয়েছে।');
    }

    private function deleteLocalFile(?string $path): void
    {
        if (! $path || str_starts_with($path, 'http')) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
