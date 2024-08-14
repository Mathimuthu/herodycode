@extends('layouts.app')

@section('title', 'Internships List')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Internships List</h2>

    <a href="{{ route('internships.export') }}" class="btn btn-primary mb-3">Export to Excel</a>

    <div class="card mb-4">
        <div class="card-header bg-white font-weight-bold">
            Approved Internships
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($internships as $internship)
                        <tr>
                            <th scope="row">{{ $internship->id }}</th>
                            <td>{{ $internship->title }}</td>
                            <td>{{ $internship->category }}</td>
                            <td>{{ $internship->start_date }}</td>
                            <td>{{ $internship->end_date }}</td>
                            <td>{{ $internship->stipend }}</td>
                            <td>{{ $internship->place }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $internships->links() }}
        </div>
    </div>
</div>
@endsection
