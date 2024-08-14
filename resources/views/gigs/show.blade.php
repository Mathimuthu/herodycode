@extends('layouts.app')

@section('title', 'Gig Details')

@section('content')
    <div class="container mt-5">
        <h1>Gig Details</h1>

        <div class="card">
            <div class="card-header">
                <h2>{{ $gig->name }}</h2>
            </div>
            <div class="card-body">
                <p><strong>Brand Name:</strong> {{ $gig->brand_name }}</p>
                <p><strong>About:</strong> {{ $gig->about }}</p>
                <p><strong>Amount Per User:</strong> ${{ $gig->amount_per_user }}</p>
                <p><strong>Assigned Employee:</strong> {{ $gig->employee ? $gig->employee->name : 'None' }}</p>
                
                @if($gig->link_description && $gig->link_locator)
                    <div class="mb-4">
                        <p><strong>Link About:</strong></p>
                        <p>{{ $gig->link_description }}</p>
                        <p><strong>Link Description:</strong></p>
                        <p>
                            @php
                                $link = $gig->link_locator;
                                if (!str_starts_with($link, 'http://') && !str_starts_with($link, 'https://')) {
                                    $link = 'http://' . $link;
                                }
                            @endphp
                            <a href="{{ $link }}" target="_blank">{{ $gig->link_locator }}</a>
                        </p>
                    </div>
                @endif

                <a href="{{ route('gigs.edit', $gig->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('gigs.destroy', $gig->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection
