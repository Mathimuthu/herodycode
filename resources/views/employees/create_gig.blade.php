@extends('layouts.app')

@section('title', 'Create Gig')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="container mt-5">
        <h1>Create a New Gig</h1>

        <form method="POST" action="{{ route('employer.gigs.store') }}">
            @csrf
            <input type="hidden" name="employee_id" value="{{ $employee->id }}">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="brand_name" class="form-label">Brand Name</label>
                <input type="text" class="form-control" id="brand_name" name="brand_name" required>
            </div>
            <div class="mb-3">
                <label for="about" class="form-label">About</label>
                <textarea class="form-control" id="about" name="about" required></textarea>
            </div>
            <div class="mb-3">
                <label for="amount_per_user" class="form-label">Amount Per User</label>
                <input type="number" class="form-control" id="amount_per_user" name="amount_per_user" required>
            </div>
            <div class="mb-3">
                <label for="link_description" class="form-label">Link Description</label>
                <textarea class="form-control" id="link_description" name="link_description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="link_locator" class="form-label">Link Locator</label>
                <input type="text" class="form-control" id="link_locator" name="link_locator" required>
            </div>
            
            <button type="submit" class="btn btn-success">Create</button>
        </form>
    </div>
@endsection
