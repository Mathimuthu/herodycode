<?php

namespace App\Http\Controllers;

use App\Exports\GigsExport;
use Illuminate\Http\Request;
use App\Models\Gig;
use App\Models\Employee;
use App\Models\PendingGig;
use Maatwebsite\Excel\Facades\Excel;

use function PHPUnit\Framework\returnSelf;

class GigController extends Controller
{
    // public function index(Request $request)
    // {
    //     $query = Gig::query();
    
    //     if ($search = $request->query('search')) {
    //         $query->where('name', 'like', "%{$search}%")
    //               ->orWhere('brand_name', 'like', "%{$search}%");
    //     }
    
    //     $gigs = $query->paginate(3); // Adjust the number to control the number of items per page
    
    //     return view('gigs.index', compact('gigs'));
    // }
    public function index(Request $request)
    {
        // Retrieve the search query from the request
        $search = $request->query('search');

        // Query the gigs based on the search term
        $query = Gig::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand_name', 'like', "%{$search}%");
            });
        }

        // Paginate the results
        $gigs = $query->paginate(3);

        // Pass the results to the view
        return view('gigs.index', compact('gigs'));
    }
    

    public function active()
    {
        $gigs = Gig::where('status', 'active')->paginate(10);
        // dd($gigs);  // For debugging
        return view('gigs.active', compact('gigs'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('gigs.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'about' => 'required|string',
            'amount_per_user' => 'required|numeric',
            'employee_id' => 'required|exists:employees,id',
            'link_description' => 'required|string',
            'link_locator' => 'required|string',
            
        ]);

        Gig::create($request->all());

        return redirect()->route('gigs.index')->with('success', 'Gig created successfully.');
    }

    public function show($id)
    {
        $gig = Gig::with('employee')->findOrFail($id);
        return view('gigs.show', compact('gig'));
    }

    public function edit($id)
    {
        $gig = Gig::findOrFail($id);
        $employees = Employee::all();
        return view('gigs.edit', compact('gig', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'about' => 'required|string',
            'amount_per_user' => 'required|numeric',
            'employee_id' => 'required|exists:employees,id',
            'link_description' => 'required|string',
            
        ]);

        $gig = Gig::findOrFail($id);
        $gig->update($request->all());

        return redirect()->route('gigs.index')->with('success', 'Gig updated successfully.');
    }

    public function destroy($id)
    {
        $gig = Gig::findOrFail($id);
        $gig->delete();

        return redirect()->route('gigs.index')->with('success', 'Gig deleted successfully.');
    }

    public function toggleStatus(Request $request, $id)
    {
        $gig = Gig::findOrFail($id);
        $gig->status = $request->status;
        $gig->save();

        return response()->json(['success' => true]);
    }

    public function bulkToggleStatus(Request $request)
    {
        $gigIds = $request->ids;
        $status = $request->status;

        Gig::whereIn('id', $gigIds)->update(['status' => $status]);

        return response()->json(['success' => true]);
    }

 
    public function activateAll(Request $request)
    {
        $page = $request->input('page', 1);

        // Fetch gigs on the given page
        $gigs = Gig::where('status', '!=', 'active')
                    ->paginate(10, ['*'], 'page', $page);

        foreach ($gigs as $gig) {
            $gig->status = 'active';
            $gig->save();
        }

        return response()->json(['success' => true]);
    }

    public function deactivateAll(Request $request)
    {
        $page = $request->input('page', 1);

        // Fetch gigs on the given page
        $gigs = Gig::where('status', '!=', 'inactive')
                    ->paginate(10, ['*'], 'page', $page);

        foreach ($gigs as $gig) {
            $gig->status = 'inactive';
            $gig->save();
        }

        return response()->json(['success' => true]);
    }
    public function sample(){
        return view('sample.sample');
    }

    public function pendings()
{
    $pendingGigs = PendingGig::orderBy('created_at', 'asc')->paginate(15);
    return view('gigs.pending', compact('pendingGigs'));
}

public function approveGig($id)
{
    $pendingGig = PendingGig::find($id);

    if ($pendingGig) {
        $gig = new Gig();
        $gig->name = $pendingGig->name;
        $gig->brand_name = $pendingGig->brand_name;
        $gig->about = $pendingGig->about;
        $gig->amount_per_user = $pendingGig->amount_per_user;
        $gig->employee_id = $pendingGig->employee_id;
        $gig->link_description = $pendingGig->link_description;
        $gig->link_locator = $pendingGig->link_locator;
        $gig->status = 'active'; // Default status
        $gig->save();

        $pendingGig->delete();

        return redirect()->route('admin.gigs.pendings')->with('success', 'Gig approved successfully.');
    }

    return redirect()->route('admin.gigs.pendings')->with('error', 'Gig not found.');
}

public function rejectGig($id)
{
    $pendingGig = PendingGig::find($id);

    if ($pendingGig) {
        $pendingGig->delete();
        return redirect()->route('admin.gigs.pendings')->with('success', 'Gig rejected successfully.');
    }

    return redirect()->route('admin.gigs.pendings')->with('error', 'Gig not found.');
}

public function export()
    {
        return Excel::download(new GigsExport,'gig.xlsx');
    }
    
}
