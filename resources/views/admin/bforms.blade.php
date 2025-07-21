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
                <form action="{{ route('admin.bform.bulkDelete') }}" method="POST" id="bulkDeleteForm">
                @csrf
                <div class="mb-2">
                    <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete selected entries?')">Delete Selected</button>
                </div>
                    <table class="table  table-striped table-bordered">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
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
                                <td><input type="checkbox" name="ids[]" value="{{ $bform->id }}"></td>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$bform->vname}}</td>
                                <td>{{$bform->cname}}</td>
                                <td>{{$bform->vemail}}</td>
                                <td>{{$bform->vmobile}}</td>
                                <td>{{$bform->area}}</td>
                                <td>{{$bform->msg}}</td>
                                 <td>
                                    <a href="{{ route('admin.bform.delete', ['id' => $bform->id]) }}"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to delete this?')">
                                        Delete
                                    </a>
                                </td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
                    {{$bforms->links()}}
                @endif
                
            </div>
        </div>
    </div>



    {{--dropdown active--}}
    <script>
          $('#select-all').on('click', function() {
            $('input[name="ids[]"]').prop('checked', this.checked);
        });
        $('#pending li:nth-child(2)').addClass('active');
        $('#pending').addClass('show');
    </script>
@endsection