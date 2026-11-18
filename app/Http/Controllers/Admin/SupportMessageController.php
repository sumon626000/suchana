<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SupportMessageController extends Controller
{
    public function index(): View
    {
        $messages = SupportMessage::latest()->get();

        return view('admin.support.index', compact('messages'));
    }

    public function destroy(SupportMessage $message): RedirectResponse
    {
        $message->delete();

        return back()->with('success', 'বার্তা মুছে ফেলা হয়েছে।');
    }
}
