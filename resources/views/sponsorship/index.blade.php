@extends('admin.master')

@section('title', 'Admin | Job List')

@section('body')
<div class="container mt-4">
    <h2 class="text-center">Sponsorship List</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

<div class="table-responsive mt-4">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>Full Name</th>
                <th>College Name</th>
                <th>City</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Club Member</th>
                <th>Club Name</th>
                <th>Position</th>
                <th>Has Event</th>
                <th>Event Name</th>
                <th>Event Category</th>
                <th>Expected Attendance</th>
                <th>Event Date</th>
                <th>Expected Sponsorship</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sponsorships as $sponsor)
                <tr>
                    <td>{{ $sponsor->full_name }}</td>
                    <td>{{ $sponsor->college_name }}</td>
                    <td>{{ $sponsor->city }}</td>
                    <td>{{ $sponsor->contact_number }}</td>
                    <td>{{ $sponsor->email }}</td>
                    <td>{{ $sponsor->is_club_member ? 'Yes' : 'No' }}</td>
                    <td>{{ $sponsor->club_name }}</td>
                    <td>{{ $sponsor->position }}</td>
                    <td>{{ $sponsor->has_upcoming_event ? 'Yes' : 'No' }}</td>
                    <td>{{ $sponsor->event_name }}</td>
                    <td>{{ $sponsor->event_category }}</td>
                    <td>{{ $sponsor->expected_attendance }}</td>
                                        <td>{{ $sponsor->event_date }}</td>

                    <td>{{ $sponsor->expected_sponsorship }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
@endsection
