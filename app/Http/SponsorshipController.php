<?php

namespace App\Http\Controllers;

use App\Sponsorship;
use Illuminate\Http\Request;

class SponsorshipController extends Controller
{
    public function create()
    {
        return view('sponsorship.form'); // Make sure the file is stored at resources/views/sponsorship/form.blade.php
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'college_name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'contact_number' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'is_club_member' => 'required|boolean',
            'club_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'has_upcoming_event' => 'required|boolean',
            'event_name' => 'nullable|string|max:255',
            'event_category' => 'nullable|string|max:100',
            'expected_attendance' => 'nullable|integer',
            'event_date' => 'nullable|date',
            'expected_sponsorship' => 'nullable|string|max:255',
        ]);

        Sponsorship::create($validated);

        return redirect()->back()->with('success', 'Sponsorship request submitted successfully!');
    }
    public function index()
    {
        $sponsorships = Sponsorship::latest()->get(); // Fetch all records, latest first
        return view('sponsorship.index', compact('sponsorships'));
    }
    // Bulk Delete
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (is_array($ids) && count($ids)) {
            Sponsorship::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', 'Selected records deleted successfully.');
        }

        return redirect()->back()->with('error', 'No items selected for deletion.');
    }

    // Single delete
    public function destroy($id)
    {
        $sponsor = Sponsorship::find($id);

        if (!$sponsor) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $sponsor->delete();

        return response()->json(['success' => true]);
    }

}
