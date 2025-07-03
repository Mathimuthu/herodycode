@extends('admin.master')

@section('title', 'Admin | All Internships')

@section('body')

<div class="container-fluid">
    <h2 class="mb-4">Internships List</h2>

    <div class="card mb-4">
        <div class="card-header bg-white font-weight-bold">
            Internships
        </div>
        <div class="card-body">
            @if(count($jobs) == 0)
                <h2 class="text-center">@lang('No Data Available')</h2>
            @else
            {{$jobs->links()}}
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Category</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Stipend</th>
                            <th scope="col">Publish Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Visibility</th> <!-- New Column -->
                            <th scope="col">Number of candidates Required</th>
                            <th scope="col">Work Place</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $job)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$job->title}}</td>
                                <td>{{$job->cat}}</td>
                                <td>{{$job->end}}</td>
                                <td>{{$job->stipend}}</td>
                                <td>{{ \Carbon\Carbon::parse($job->created_at)->format('Y-m-d') }}</td>
                                <td><a href="{{route('admin.job.campaign_status', $job->id)}}" class="btn btn-{{$job->projectstatus ? 'success' : 'danger'}} btn-sm">
                                    {{$job->projectstatus ? 'Active' : 'Inactive'}}
                                </a></td>
                                <td>
                                    <form action="{{ route('admin.job.toggle_visibility', $job->id) }}" method="get">
                                        <button type="submit" class="btn btn-{{ $job->is_visible ? 'success' : 'warning' }} btn-sm">
                                            {{ $job->is_visible ? 'Hide' : 'Show' }}
                                        </button>
                                    </form>
                                </td>                                
                                <td>{{$job->count}}</td>
                                <td>{{$job->place}}</td>
                                <td>
                                    @if($job->mobile == 0)
                                    <form action="{{route('admin.job.make-mobile')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$job->id}}">
                                        <button type="submit" class="btn btn-success btn-sm">Make mobile specific</button>
                                    </form>
                                    @else
                                    <form action="{{route('admin.job.undo-mobile')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$job->id}}">
                                        <button type="submit" class="btn btn-danger btn-sm">Undo mobile specific</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            {{$jobs->links()}}
        </div>
    </div>
</div>

@endsection
