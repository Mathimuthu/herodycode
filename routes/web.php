<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GigController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\PendingInternshipController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin', [AdminController::class, 'index'])->name('dashbord');
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('gigs', GigController::class)->except(['show']);
Route::post('/gigs/toggleStatus/{id}', [GigController::class, 'toggleStatus'])->name('gigs.toggleStatus');
Route::post('/gigs/toggleStatus/bulk', [GigController::class, 'bulkToggleStatus'])->name('gigs.toggleStatus.bulk');


Route::get('gigs/{gig}', [GigController::class, 'show'])->name('gigs.show');
Route::get('export', [GigController::class, 'export'])->name('gigs.export');

Route::get('/admin/pending-gigs', [GigController::class, 'pendings'])->name('admin.gigs.pendings');
Route::get('/admin/pending-gigs/approve/{id}', [GigController::class, 'approveGig'])->name('admin.gigs.approve');
Route::get('/admin/pending-gigs/reject/{id}', [GigController::class, 'rejectGig'])->name('admin.gigs.reject');


Route::get('sample', [GigController::class, 'sample'])->name('gigs.Sample');
Route::post('gigs/activateAll', [GigController::class, 'activateAll'])->name('gigs.activateAll');

// New route for deactivating all gigs on the current page
Route::post('gigs/deactivateAll', [GigController::class, 'deactivateAll'])->name('gigs.deactivateAll');


Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employer/dashboard/{employee}', [EmployeeController::class, 'dashboard'])->name('employer.dashboard');
Route::get('/employer/gigs/create/{employee}', [EmployeeController::class, 'createGig'])->name('employer.gigs.create');
Route::post('/employer/gigs', [EmployeeController::class, 'storeGig'])->name('employer.gigs.store');

Route::get('/internships/create/{employee}', [InternshipController::class, 'create'])->name('internships.create');
Route::get('/internships', [InternshipController::class, 'index'])->name('internships.index');
Route::get('/internships/export', [InternshipController::class, 'export'])->name('internships.export');


// Route for showing the pending internships
Route::get('/pending-internships', [PendingInternshipController::class, 'index'])->name('pending-internships.index');

// Route for storing a new pending internship
Route::post('/pending-internships', [PendingInternshipController::class, 'store'])->name('pending-internships.store');

// Route for approving a pending internship
Route::post('/pending-internships/{id}/approve', [PendingInternshipController::class, 'approve'])->name('pending-internships.approve');

// Route for rejecting a pending internship
Route::delete('/pending-internships/{id}', [PendingInternshipController::class, 'destroy'])->name('pending-internships.destroy');


Route::get('/images/create', [ImageController::class, 'create'])->name('images.create');
Route::post('/images', [ImageController::class, 'store'])->name('images.store');
Route::get('/images', [ImageController::class, 'index'])->name('images.index');

