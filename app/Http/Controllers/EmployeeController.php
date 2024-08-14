<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Gig;
use App\Models\PendingGig;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function dashboard($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        return view('employees.dashboard', compact('employee'));
    }

    public function createGig($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);
        return view('employees.create_gig', compact('employee'));
    }
    public function storeGig(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'about' => 'required|string',
            'amount_per_user' => 'required|numeric',
            'employee_id' => 'required|exists:employees,id',
            'link_description' => 'required|string',
            'link_locator' => 'required|string', // Temporarily treat as string for custom validation
        ]);
    
        // Ensure link_locator is a valid URL
        $linkLocator = $validatedData['link_locator'];
        if (!preg_match('/^https?:\/\//', $linkLocator)) {
            $linkLocator = 'http://' . $linkLocator;
        }
    
        // Re-validate the updated link_locator
        $validatedData['link_locator'] = $linkLocator;
        $request->merge($validatedData);
        $request->validate([
            'link_locator' => 'url', // Validate the corrected link_locator
        ]);
    
        // Create the pending gig
        PendingGig::create($validatedData);
    
        // Redirect with success message
        return redirect()->route('employer.dashboard', ['employee' => $validatedData['employee_id']])
                         ->with('success', 'Gig created successfully!');
    }

    //Projects

    
    

}
