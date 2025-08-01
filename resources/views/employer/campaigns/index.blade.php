@extends('layouts.app')

@section('title', 'Employer | All Projects')

@section('content')
<?php
    $employerId = Auth::guard('employer')->id();
    $user = DB::table('employers')->find($employerId);
?>
<!-- Header Section -->
<div class="mb-4">
    <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 30px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $user->name }}</h1>
            <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" style="width: 200px; height: 120px; object-fit: contain;" />
        </div>
    </div>
</div>
    <div class="container-fluid">
         <div class="card-header bg-white border-bottom">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-3">
            <h2 class="h3 font-weight-bold text-dark text-center flex-fill text-sm-left mb-2 mb-sm-0 table-title">
                Project List
            </h2>
        </div>
  </div>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                Projects
            </div>
            <div class="card-body">
                @if(count($missions)==0)
                    <h2 class="text-center">@lang('No Data Available')</h2>
                @else
                    <table class="table  table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Reward</th>
                            <th scope="col">City</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($missions as $mission)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <th scope="row">{{$mission->title}}</th>
                                <th scope="row">{{$mission->brand}}</th>
                                <th scope="row">{{$mission->reward}}</th>
                                <th scope="row">{{$mission->city}}</th>
                                <th scope="row">
                                    <form action="{{route('employer.mission.delete')}}" method="post">
                                    @csrf
                                        <input type="hidden" name="id" value="{{$mission->id}}">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </th>
                                <th scope="row"><a href="{{route('employer.mission.applications',$mission->id)}}" class="btn btn-primary btn-sm">View Applications</a></th>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                @endif
                {{$missions->links()}}
            </div>
        </div>
    </div>
@endsection
