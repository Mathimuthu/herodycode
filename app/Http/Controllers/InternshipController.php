<?php

namespace App\Http\Controllers;

use App\Exports\InternshipsExport;
use Illuminate\Http\Request;
use App\Models\Internship;
use App\Models\Employee;
use Maatwebsite\Excel\Facades\Excel;

class InternshipController extends Controller
{
    public function create($employeeId)
    {
        $employee = Employee::findOrFail($employeeId);

        // You might want to fetch categories or other necessary data here
        $categories = ['Category1', 'Category2', 'Category3']; // Replace with actual categories

        return view('internships.create', compact('employee', 'categories'));
    }
    public function index()
    {
        // Fetch all approved internships
        $internships = Internship::orderBy('created_at', 'asc')->paginate(15);
        return view('internships.index', compact('internships'));
    }

    public function export()
    {
        return Excel::download(new InternshipsExport, 'internships.xlsx');
    }
    
}
