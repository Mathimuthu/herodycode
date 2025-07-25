@extends('admin.master')

@section('title', 'Admin | withdraw log')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Withdraw Log</h2>
        
        <!--<div class="input-group mb-3">-->
        <!--    <form action="{{ route('admin.withdraw.filterupi') }}" method="GET">-->
        <!--        <input type="text" class="form-control" name="filter_upi" placeholder="Filter by UPI..."><br>-->
        <!--        <input type="text" class="form-control" name="filter_email" placeholder="Filter by Email..."><br>-->
        <!--        <button type="submit" class="btn btn-primary">Filter</button>-->
        <!--    </form>-->
        <!--</div>-->
        
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="liveSearch" placeholder="Search...">
        </div>

        <div class="card mb-4">
            <div class="card-header">
                {{$withdrawRequest->links()}}
            </div>
            
            <div class="card-body">
                <table class="table-striped table-bordered table" >
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <!--<th scope="col">UserId</th>-->
                        <th scope="col">User</th>
                        <th scope="col">User Email/phone</th>
                        <th scope="col">Payment Detail</th>
                        <th scope="col">Payable Amount</th>
                        <th scope="col">Requested At</th>
                        <th scope="col">Updated At</th>
                        <th scope="col">Status</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($withdrawRequest as $withdrawRe)
                    <?php $user = \App\User::find($withdrawRe->user_id); 
                    ?>
                        <tr class="campaignRow">
                            <th>{{$loop->iteration}}</th>
                            <!--<th scope="row">{{$withdrawRe->user_id}}</th>-->
                            <td>
                                @if($withdrawRe->user)
                                    {{ $withdrawRe->user->name }} <br>
                                    <a href="{{ route('admin.member.details', ['id' => $withdrawRe->user->id]) }}" class="btn btn-primary btn-sm customs-btn-bd text-white">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                @else
                                    User not found
                                @endif
                            </td>
                            <td>
                                @if($withdrawRe->user)
                                    {{ $withdrawRe->user->email }} <br>{{ $withdrawRe->user->phone }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $withdrawRe->payment_details }}</td>
                            <td>{{ $withdrawRe->payable_amount }}</td>
                            <td>{{ $withdrawRe->created_at->format('d M, Y') }}</td>
                            <td>{{ $withdrawRe->updated_at->format('d M, Y') }}</td>
                            <td>
                                @if($withdrawRe->status == 1)
                                    Approved
                                @elseif($withdrawRe->status == 2)
                                    Rejected
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                {{$withdrawRequest->links()}}
            </div>
        </div>
    </div>



    {{--<!-- order Approve Alert Modal -->--}}
    <div class="modal modal-danger fade" id="withdrawApprove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash"></i> Approve !</h4>
                </div>
                <form action="{{route('admin.withdraw.approve','Approved')}}"
                      method="post">
                    @csrf
                    <div class="modal-body">
                        <input class="form-control form-control-lg mb-3" type="hidden" name="id" id="id">
                        <strong>Are you sure you want to Approved ?</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--<!-- order reject Alert Modal -->--}}
    <div class="modal modal-danger fade" id="withdrawReject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-trash"></i> Reject !</h4>
                </div>
                <form action="{{route('admin.withdraw.reject','delete')}}"
                      method="post">
                    @csrf
                    <div class="modal-body">
                        <input class="form-control form-control-lg mb-3" type="hidden" name="id" id="id">
                        <strong>Are you sure you want to Delete ?</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--dropdown active--}}
    <script>
        $('#Withdraw li:nth-child(3)').addClass('active');
        $('#Withdraw').addClass('show');
    </script>
@endsection


@section('scripts')

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#liveSearch').on('keyup', function () {
                var searchText = $(this).val().toLowerCase();
    
                $('.campaignRow').hide(); // Hide all rows initially
    
                // Iterate over all table rows, including those on different pages
                $('.campaignRow').filter(function () {
                    return $(this).text().toLowerCase().includes(searchText);
                }).show();
            });
        });
    </script>

    {{--Approve script--}}
    <script>
        $('#withdrawReject').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script>

    {{--Reject script--}}
    <script>
        $('#withdrawApprove').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })
    </script>
    
    <style>
    .table-container {
        max-height: 500px; /* Adjust as needed */
        overflow-y: auto;
    }
</style>

@endsection
