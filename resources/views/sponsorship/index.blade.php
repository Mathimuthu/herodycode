@extends('admin.master')

@section('title', 'Admin | Sponsorship List')

@section('body')
<div class="container mt-4">
    <h2 class="text-center">Sponsorship List</h2>

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

    {{-- Bulk Delete Form --}}
    <form id="deleteForm" method="POST" action="{{ route('sponsorships.delete') }}">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <div class="mb-2">
            <button type="button" class="btn btn-danger" id="bulkDeleteBtn">Delete Selected</button>
        </div>

        <div class="table-responsive mt-2">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sponsorships as $sponsor)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="ids[]" value="{{ $sponsor->id }}">
                            </td>
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
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-danger single-delete-btn" data-id="{{ $sponsor->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
</div>

<script>
    // Select all checkboxes
    document.getElementById('selectAll').addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('input[name="ids[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    // Bulk delete
    document.getElementById('bulkDeleteBtn').addEventListener('click', function () {
        const selected = document.querySelectorAll('input[name="ids[]"]:checked');
        if (selected.length === 0) {
            alert('Please select at least one item to delete.');
        } else {
            if (confirm('Are you sure you want to delete selected items?')) {
                document.getElementById('deleteForm').submit();
            }
        }
    });

    // Single row delete (AJAX)
    document.querySelectorAll('.single-delete-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (!confirm('Are you sure you want to delete this record?')) return;

            const sponsorId = this.getAttribute('data-id');
            const row = this.closest('tr');

            fetch(`/sponsorships/${sponsorId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    alert('Deleted successfully!');
                     location.reload();
                } else {
                    alert('Failed to delete.');
                }
            })
            .catch(() => alert('Something went wrong!'));
        });
    });
</script>
@endsection
