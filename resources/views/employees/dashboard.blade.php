@extends('layouts.app')

@section('title', 'Employer Dashboard')

@section('content')
    <div class="container mt-5">
        <h1>Employer Dashboard</h1>

        <div class="mb-3">
            <a href="{{ route('employer.gigs.create', ['employee' => $employee->id]) }}" class="btn btn-success">Create Gig</a>
        </div>
        <div class="mb-3">
            <a href="{{ route('internships.create', ['employee' => $employee->id]) }}" class="btn btn-success">Create Internship</a>
        </div>

        <div class="card">
            <div class="card-header">
                Employee Information
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $employee->name }}</h5>
                <p class="card-text"><strong>Position:</strong> {{ $employee->position }}</p>
                <p class="card-text"><strong>Email:</strong> {{ $employee->email }}</p>
                <p class="card-text"><strong>Phone:</strong> {{ $employee->phone }}</p>
                <a href="{{ route('employees.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
@endsection
