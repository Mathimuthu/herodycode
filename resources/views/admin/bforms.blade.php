@extends('admin.master')

@section('title', 'Admin | All Internships')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Business Form Responses</h2>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                List
            </div>
            <div class="card-body">
                @if(count($bforms)==0)
                    <h2 class="text-center">@lang('No Data Available')</h2>
                @else
                    <table class="table  table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Contact Name</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Email Address</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Area of Work</th>
                            <th scope="col">Requirement</th>
                          <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($bforms as $bform)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$bform->vname}}</td>
                                <td>{{$bform->cname}}</td>
                                <td>{{$bform->vemail}}</td>
                                <td>{{$bform->vmobile}}</td>
                                <td>{{$bform->area}}</td>
                                <td>{{$bform->msg}}</td>
                                <td><form action="{{route('admin.bform.delete')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$bform->id}}">
                                    <button class="btn btn-danger" id="submit" name="submit" type="submit" onclick="return confirm('Are you sure want to delete this?')">Delete</button>
                                </form></td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    
                    {{$bforms->links()}}
                @endif
                
            </div>
        </div>
    </div>



    {{--dropdown active--}}
    <script>
        $('#pending li:nth-child(2)').addClass('active');
        $('#pending').addClass('show');
    </script>
@endsection