@extends('layouts.app')

@section('title', 'Create Internship')

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
    <h1>Create a New Internship</h1>

    <form method="POST" action="{{ route('pending-internships.store') }}">
        @csrf
        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category" required>
                <option value="" disabled selected>Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" required>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date" required>
        </div>
        <div class="mb-3">
            <label for="duration" class="form-label">Duration</label>
            <input type="text" class="form-control" id="duration" name="duration" required>
        </div>
        <div class="mb-3">
            <label for="stipend" class="form-label">Stipend</label>
            <input type="text" class="form-control" id="stipend" name="stipend" required>
        </div>
        <div class="mb-3">
            <label for="benefits" class="form-label">Benefits</label>
            <textarea class="form-control" id="benefits" name="benefits" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="place" class="form-label">Place</label>
            <input type="text" class="form-control" id="place" name="place" required>
        </div>
        <div class="mb-3">
            <label for="count" class="form-label">Count</label>
            <input type="number" class="form-control" id="count" name="count" required>
        </div>
        <div class="mb-3">
            <label for="skills" class="form-label">Skills</label>
            <textarea class="form-control" id="skills" name="skills" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="proofs" class="form-label">Proofs (optional)</label>
            <input type="text" class="form-control" id="proofs" name="proofs">
        </div>
        <button type="submit" class="btn btn-success">Create</button>
    </form>
</div>
@endsection
