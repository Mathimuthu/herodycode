@extends('layouts.app')

@section('title', 'Add Gig')

@section('content')
    <div class="container mt-5">
        <h1>Add Gig</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('gigs.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Gig Name</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="brand_name">Brand Name</label>
                <input type="text" name="brand_name" class="form-control" id="brand_name" value="{{ old('brand_name') }}" required>
            </div>
            <div class="form-group">
                <label for="about">About</label>
                <textarea name="about" class="form-control" id="about" required>{{ old('about') }}</textarea>
            </div>
            <div class="form-group">
                <label for="amount_per_user">Amount Per User</label>
                <input type="number" name="amount_per_user" class="form-control" id="amount_per_user" value="{{ old('amount_per_user') }}" required>
            </div>
            <div class="form-group">
                <label for="link_description">Link Description</label>
                <textarea name="link_description" class="form-control" id="link_description" required>{{ old('link_description') }}</textarea>
            </div>
            <div class="form-group">
                <label for="link_locator">Link Locator</label>
                <input type="text" name="link_locator" class="form-control" id="link_locator" value="{{ old('link_locator') }}" required>
            </div>
            <div class="form-group">
                <label for="employee_id">Assign Employee</label>
                <select name="employee_id" class="form-control" id="employee_id" required>
                    <option value="">Select Employee</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Gig</button>
        </form>
    </div>
@endsection
