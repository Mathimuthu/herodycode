<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingInternship;
use App\Models\Internship;

class PendingInternshipController extends Controller
{
    public function index()
    {
        // Fetch all pending internships
        $pendingInternships = PendingInternship::orderBy('created_at', 'asc')->paginate(15);
        return view('internships.pending', compact('pendingInternships'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'duration' => 'required|string',
            'stipend' => 'required|numeric',
            'benefits' => 'required|string',
            'place' => 'required|string',
            'count' => 'required|integer',
            'skills' => 'required|string',
            'proofs' => 'nullable|string',
            'employee_id' => 'required|exists:employees,id',
        ]);

        // Create a new pending internship
        PendingInternship::create($validated);

        // Redirect or return a response
        return redirect()->route('internships.create', ['employee' => $request->employee_id])
                         ->with('success', 'Internship created and pending approval.');
    }

    public function approve($id)
    {
        $pendingInternship = PendingInternship::findOrFail($id);

        $internship = new Internship();
        $internship->title = $pendingInternship->title;
        $internship->description = $pendingInternship->description;
        $internship->category = $pendingInternship->category;
        $internship->start_date = $pendingInternship->start_date;
        $internship->end_date = $pendingInternship->end_date;
        $internship->duration = $pendingInternship->duration;
        $internship->stipend = $pendingInternship->stipend;
        $internship->benefits = $pendingInternship->benefits;
        $internship->place = $pendingInternship->place;
        $internship->count = $pendingInternship->count;
        $internship->skills = $pendingInternship->skills;
        $internship->proofs = $pendingInternship->proofs;
        $internship->employee_id = $pendingInternship->employee_id;
        $internship->save();

        $pendingInternship->delete();

        return redirect()->route('pending-internships.index')
                         ->with('success', 'Internship approved and moved to the internships table.');
    }

    public function destroy($id)
    {
        $pendingInternship = PendingInternship::findOrFail($id);
        $pendingInternship->delete();

        return redirect()->route('pending-internships.index')
                         ->with('success', 'Pending internship rejected and removed.');
    }
}
