<?php

namespace App\Http\Controllers;

use App\Services\NextSmsService;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    protected $smsService;

    public function __construct(NextSmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function showForm()
    {
        return view('send-sms');
    }

    // Web route for single SMS (Blade response)
    public function sendSingle(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string|max:160',
            'reference' => 'nullable|string',
        ]);

        $response = $this->smsService->sendSms(
            $request->phone,
            $request->message,
            $request->reference
        );

        if (isset($response['error']) && $response['error']) {
            return back()->with('error', $response['message']);
        }

        return back()->with([
            'success' => 'Single SMS queued successfully!',
            'sms_response' => $response['messages'],
        ]);
    }

    // Web route for bulk SMS (Blade response)
    public function sendBulk(Request $request)
    {
        $request->validate([
            'phones' => 'required|string',
            'message' => 'required|string|max:160',
            'reference' => 'nullable|string',
        ]);

        $recipients = array_filter(array_map('trim', explode(',', $request->phones)));

        if (empty($recipients)) {
            return back()->with('error', 'No valid phone numbers provided.');
        }

        $response = $this->smsService->sendSms(
            $recipients,
            $request->message,
            $request->reference
        );

        if (isset($response['error']) && $response['error']) {
            return back()->with('error', $response['message']);
        }

        return back()->with([
            'success' => 'Bulk SMS queued successfully to ' . count($recipients) . ' recipients!',
            'sms_response' => $response['messages'],
        ]);
    }

    // API route for single SMS (JSON response)
    public function sendSingleApi(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string|max:160',
            'reference' => 'nullable|string',
        ]);

        $response = $this->smsService->sendSms(
            $request->phone,
            $request->message,
            $request->reference
        );

        if (isset($response['error']) && $response['error']) {
            return response()->json(['error' => $response['message']], 400);
        }

        return response()->json($response);
    }

    // API route for bulk SMS (JSON response)
    public function sendBulkApi(Request $request)
    {
        $request->validate([
            'phones' => 'required|string',
            'message' => 'required|string|max:160',
            'reference' => 'nullable|string',
        ]);

        $recipients = array_filter(array_map('trim', explode(',', $request->phones)));

        if (empty($recipients)) {
            return response()->json(['error' => 'No valid phone numbers provided.'], 400);
        }

        $response = $this->smsService->sendSms(
            $recipients,
            $request->message,
            $request->reference
        );

        if (isset($response['error']) && $response['error']) {
            return response()->json(['error' => $response['message']], 400);
        }

        return response()->json($response);
    }
}