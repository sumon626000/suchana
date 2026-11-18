<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoticeController extends Controller
{
    public function index(): View
    {
        $notices = Notice::orderByDesc('published_at')->get();

        return view('admin.notices.index', compact('notices'));
    }

    public function create(): View
    {
        return view('admin.notices.form', ['notice' => new Notice()]);
    }

    public function store(Request $request): RedirectResponse
    {
        Notice::create($this->validated($request));

        return redirect()->route('admin.notices.index')->with('success', 'নোটিশ যোগ হয়েছে।');
    }

    public function edit(Notice $notice): View
    {
        return view('admin.notices.form', compact('notice'));
    }

    public function update(Request $request, Notice $notice): RedirectResponse
    {
        $notice->update($this->validated($request));

        return redirect()->route('admin.notices.index')->with('success', 'নোটিশ আপডেট হয়েছে।');
    }

    public function destroy(Notice $notice): RedirectResponse
    {
        $notice->delete();

        return back()->with('success', 'নোটিশ মুছে ফেলা হয়েছে।');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title_bn' => 'required|string|max:200',
            'title_en' => 'required|string|max:200',
            'body_bn' => 'nullable|string',
            'body_en' => 'nullable|string',
            'type' => 'required|string|max:40',
            'published_at' => 'nullable|date',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['published_at'] = $data['published_at'] ?? now();

        return $data;
    }
}
