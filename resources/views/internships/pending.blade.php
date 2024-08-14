@extends('layouts.app')

@section('title', 'Pending Internships')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Pending Internships List</h2>

    <div class="card mb-4">
        <div class="card-header bg-white font-weight-bold">
            Pending Internships
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Stipend</th>
                    <th scope="col">Place</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($pendingInternships as $pendingInternship)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $pendingInternship->title }}</td>
                        <td>{{ $pendingInternship->category }}</td>
                        <td>{{ $pendingInternship->start_date }}</td>
                        <td>{{ $pendingInternship->end_date }}</td>
                        <td>{{ $pendingInternship->stipend }}</td>
                        <td>{{ $pendingInternship->place }}</td>
                        <td>
                            <form action="{{ route('pending-internships.approve', $pendingInternship->id) }}" method="post" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>

                            <form action="{{ route('pending-internships.destroy', $pendingInternship->id) }}" method="post" style="display:inline;">
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
    </div>
</div>
@endsection
