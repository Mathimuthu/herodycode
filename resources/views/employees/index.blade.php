@extends('layouts.app')

@section('title', 'Employees')

@section('content')
    <div class="container mt-5">
        <h1>Employees</h1>

        @if($employees->isEmpty())
            <div class="alert alert-info">
                No employees found.
            </div>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>
                                <a href="{{ route('employer.dashboard', $employee->id) }}" class="btn btn-primary">Login</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
