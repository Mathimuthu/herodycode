{{-- <!-- resources/views/pending_internships/index.blade.php -->
@extends('layouts.app')

@section('title', 'Pending Internships')

@section('content')
<div class="container mt-5">
    <h1>Pending Internships</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Category</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendingInternships as $pendingInternship)
                <tr>
                    <td>{{ $pendingInternship->id }}</td>
                    <td>{{ $pendingInternship->title }}</td>
                    <td>{{ $pendingInternship->description }}</td>
                    <td>{{ $pendingInternship->category }}</td>
                    <td>{{ $pendingInternship->start_date }}</td>
                    <td>{{ $pendingInternship->end_date }}</td>
                    <td>
                        <form method="POST" action="{{ route('pending-internships.approve', $pendingInternship->id) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('pending-internships.destroy', $pendingInternship->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $pendingInternships->links() }}
</div>
@endsection --}}
