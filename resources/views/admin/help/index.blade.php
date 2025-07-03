@extends('admin.master')

@section('title', 'Admin | Help Links')

@section('body')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <div class="container">
        <h2 class="mb-4">Manage Help Links</h2>

        <form method="POST" action="{{ route('admin.help.index') }}">
            @csrf
            <div class="form-group">
                <label for="whatsapp">WhatsApp Link</label>
                <input type="url" name="whatsapp" class="form-control" value="" placeholder="https://wa.me/1234567890">
            </div>

            <div class="form-group">
                <label for="email">Support Email</label>
                <input type="email" name="email" class="form-control" value="" placeholder="support@example.com">
            </div>

            <div class="form-group">
                <label for="google">Google Help Link</label>
                <input type="url" name="google" class="form-control" value="" placeholder="https://support.google.com/">
            </div>

            <button type="submit" class="btn btn-primary mt-3">Save Links</button>
        </form>
    </div>
@endsection
