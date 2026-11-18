<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use App\Models\NotificationTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $templates = NotificationTemplate::orderBy('key')->get();

        return view('admin.notifications.index', compact('templates'));
    }

    public function edit(NotificationTemplate $template): View
    {
        return view('admin.notifications.edit', compact('template'));
    }

    public function update(Request $request, NotificationTemplate $template): RedirectResponse
    {
        $data = $request->validate([
            'channel' => ['required', 'in:sms,email,both'],
            'subject' => ['nullable', 'string', 'max:150'],
            'body_bn' => ['required', 'string'],
            'body_en' => ['nullable', 'string'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $template->update($data);

        return redirect()->route('admin.notifications.index')->with('success', 'টেমপ্লেট আপডেট হয়েছে।');
    }

    public function logs(): View
    {
        $logs = NotificationLog::latest()->take(200)->get();

        return view('admin.notifications.logs', compact('logs'));
    }
}
