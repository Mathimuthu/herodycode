<!-- resources/views/gigs/pending.blade.php -->
@extends('layouts.app')

@section('title', 'Pending Gigs')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Pending Gigs List</h2>

    <div class="card mb-4">
        <div class="card-header bg-white font-weight-bold">
            Pending Gigs
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Brand Name</th>
                    <th scope="col">Amount per User</th>
                    <th scope="col">User</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($pendingGigs as $pendingGig)
                    @php
                        $user = DB::table('employees')->find($pendingGig->employee_id);
                    @endphp
                    @if($user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $pendingGig->name }}</td>
                            <td>{{ $pendingGig->brand_name }}</td>
                            <td>{{ $pendingGig->amount_per_user }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                <a href="{{ route('admin.gigs.approve', $pendingGig->id) }}" class="btn btn-success btn-sm">Approve</a>
                                <a href="{{ route('admin.gigs.reject', $pendingGig->id) }}" class="btn btn-danger btn-sm">Reject</a>
                            </td>
                        </tr>
                    @endif
                @endforeach

                </tbody>
            </table>
            {{ $pendingGigs->links() }}
        </div>
    </div>
</div>

{{--dropdown active--}}
<script>
    $('#Campaigns li:nth-child(3)').addClass('active');
    $('#Campaigns').addClass('show');
</script>

@endsection
