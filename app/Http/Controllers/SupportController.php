<?php

namespace App\Http\Controllers;

use App\Models\SupportMessage;
use App\Services\TransactionalMailer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'mobile' => ['required', 'string', 'max:30'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $message = SupportMessage::create($data + ['status' => 'new']);

        app(TransactionalMailer::class)->supportMessageReceived($message);

        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'id' => $message->id]);
        }

        return back()->with('success', 'আপনার বার্তা পাঠানো হয়েছে।');
    }
}
