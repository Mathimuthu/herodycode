@extends('layouts.app')

@section('title', 'Manage Gigs')

@section('content')
    <div class="container mt-5">
        <h1>Manage Gigs</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search Form -->
        <div class="input-group mb-4">
            <input type="text" id="liveSearch" class="form-control" placeholder="Search by name or brand">
            <button type="button" class="btn btn-primary" id="searchButton">
                <i class="fas fa-search"></i> Search
            </button>
        </div>

        <div class="mb-3">
            <button type="button" id="activateAllBtn" class="btn btn-success">
                Activate All on This Page
            </button>
            <button type="button" id="deactivateAllBtn" class="btn btn-warning">
                Deactivate All on This Page
            </button>
            <a href="{{ route('gigs.export') }}" class="btn btn-secondary">Export to Excel</a>
        </div>

        @if ($gigs->isEmpty())
            <p>No gigs available.</p>
        @else
            <div class="d-flex justify-content-end mb-2">
                {{ $gigs->appends(['search' => request()->query('search')])->links('pagination::bootstrap-4') }}
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Brand Name</th>
                        <th>About</th>
                        <th>Amount Per User</th>
                        <th>Employee</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="gigsTableBody">
                    @foreach ($gigs as $gig)
                        <tr class="gigRow" data-id="{{ $gig->id }}">
                            <td>{{ $gig->id }}</td>
                            <td>{{ $gig->name }}</td>
                            <td>{{ $gig->brand_name }}</td>
                            <td>{{ $gig->about }}</td>
                            <td>{{ $gig->amount_per_user }}</td>
                            <td>{{ $gig->employee->name ?? 'N/A' }}</td>
                            <td>
                                <form action="{{ route('gigs.toggleStatus', $gig->id) }}" method="POST" class="statusForm" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="status" value="{{ $gig->status === 'active' ? 'inactive' : 'active' }}">
                                    <button type="submit" class="btn btn-sm {{ $gig->status === 'active' ? 'btn-success' : 'btn-danger' }}">
                                        {{ $gig->status === 'active' ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('gigs.show', $gig->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('gigs.edit', $gig->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#liveSearch').on('keyup', function () {
                var searchText = $(this).val().toLowerCase();
                
                // Filter the table rows based on search input
                $('#gigsTableBody .gigRow').each(function () {
                    var rowText = $(this).text().toLowerCase();
                    $(this).toggle(rowText.indexOf(searchText) !== -1);
                });
            });

            $('#activateAllBtn').on('click', function () {
                toggleStatus('active');
            });

            $('#deactivateAllBtn').on('click', function () {
                toggleStatus('inactive');
            });

            function toggleStatus(status) {
                var gigIds = [];

                $('#gigsTableBody .gigRow:visible').each(function () {
                    var row = $(this);
                    var gigId = row.data('id');
                    gigIds.push(gigId);

                    // Update button status instantly
                    var button = row.find('form button');
                    button.removeClass('btn-success btn-danger').addClass(status === 'active' ? 'btn-success' : 'btn-danger').text(status.charAt(0).toUpperCase() + status.slice(1));
                });

                $.ajax({
                    url: '{{ route("gigs.toggleStatus.bulk") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status,
                        ids: gigIds
                    },
                    success: function () {
                        console.log('Status updated successfully');
                    },
                    error: function () {
                        alert('Failed to update gig status');
                    }
                });
            }

            $('#gigsTableBody').on('submit', '.statusForm', function (e) {
                e.preventDefault();
                var form = $(this);
                var action = form.attr('action');
                var button = form.find('button');

                $.ajax({
                    url: action,
                    method: 'POST',
                    data: form.serialize(),
                    success: function () {
                        if (button.hasClass('btn-success')) {
                            button.removeClass('btn-success').addClass('btn-danger').text('Inactive');
                        } else {
                            button.removeClass('btn-danger').addClass('btn-success').text('Active');
                        }
                    },
                    error: function () {
                        alert('Failed to update gig status');
                    }
                });
            });
        });
    </script>
@endsection
