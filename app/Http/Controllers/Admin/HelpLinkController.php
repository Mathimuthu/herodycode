<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\HelpLink;


class HelpLinkController extends Controller
{
    // Get Help Links
    public function index()
    {
        $helpLinks = HelpLink::first();

        return view('admin.help.index', compact('helpLinks'));
    }

    // Store or Update Help Links
   public function store(Request $request)
{
    $request->validate([
        'whatsapp' => 'nullable|url',
        'email' => 'nullable|email',
        'google' => 'nullable|url',
    ]);

    try {
        HelpLink::updateOrCreate(
            ['id' => 1], // Ensure there's only one record
            [
                'whatsapp' => $request->whatsapp,
                'email' => $request->email,
                'google' => $request->google,
            ]
        );

        return redirect()->back()->with('success', 'Help links stored successfully!');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to store help links! Please try again.');
    }
}

    public function apiIndex()
    {
        $helpLinks = HelpLink::first();

        return response()->json([
            'whatsapp' => $helpLinks->whatsapp ?? '',
            'email' => $helpLinks->email ?? '',
            'google' => $helpLinks->google ?? '',
        ], 200);
    }
}
