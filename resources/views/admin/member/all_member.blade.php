@extends('admin.master')

@section('title', 'Admin | All members')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Member List</h2>
        
        <div class="input-group mb-3">
            <form action="{{ route('admin.member.filter') }}" method="GET">
                <input type="text" class="form-control" name="filter_id" placeholder="Filter by ID..."><br>
                <input type="text" class="form-control" name="filter_email" placeholder="Filter by Email..."><br>
                <input type="text" class="form-control" name="filter_phone" placeholder="Filter by Phone...">
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                members
            </div>
            <div class="card-body">
                <a class="btn btn-primary" href="{{route('admin.member.create')}}">Create Member</a>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Created Date</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Users Referred</th>
                        <th scope="col">Wallet</th>
                        <th scope="col">Status</th>
                        <th scope="col">Block Status</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($users as $user)
                        <tr class="campaignRow">
                            <th scope="row">{{$user->id}}</th>
                            <td>{{\Carbon\Carbon::parse($user->created_at)->format('Y-m-d')}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone}}</td>

                            <td>{{\App\User::where('ref_by',$user->id)->count()}}</td>
                            <td>
                                {{$user->balance}} 
                                <button class="btn btn-info btn-sm edit-balance-btn" data-id="{{$user->id}}" data-balance="{{$user->balance}}">Edit</button>
                            </td>
                            <td>
                                @if ($user->account_status==1)
                                    <span class="badge  badge-pill  badge-success">Active</span>
                                @elseif($user->account_status==0)
                                    <span class="badge  badge-pill  badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <form id="blockForm" action="{{ route("admin.member.isBlocked") }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$user->id}}"/>
                                    <select id="blockSelect" class="form-select form-select-sm" aria-label=".form-select-sm example" name="isBlocked">
                                        <option value="1" {{ $user->isBlocked == '1' ? 'selected' : '' }}>Block</option>
                                        <option value="0" {{ $user->isBlocked == '0' ? 'selected' : '' }}>Unblock</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <a href="{{route('admin.member.details',$user->id)}}" class="btn btn-primary btn-sm customs-btn-bd text-white"> <i class="fa fa-eye"></i> View</a>
                                
                                <form action="{{route("admin.member.delete")}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$user->id}}"/>
                                    <button onClick ="return confirm('Are You sure want to delete this?')" type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach


                    </tbody>
                    <a href="{{route('admin.member.export')}}" class="btn btn-primary">Export all the members</a>
                <a href="{{route('admin.member.export.referrals')}}" class="btn btn-success">Export referral reports</a>
                <a href="{{ route('admin.gigapp.export.status') }}" class="btn btn-success mb-3">Export GigApps with Status</a>
                </table>
                
<br>
                {{$users->links()}}
                
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    {{--dropdown active--}}
     <!-- Modal for editing balance -->
    <div class="modal fade" id="editBalanceModal" tabindex="-1" role="dialog" aria-labelledby="editBalanceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBalanceModalLabel">Edit Balance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editBalanceForm" action="{{ route('admin.member.updateBalance') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="form-group">
                            <label for="balance">Balance</label>
                            <input type="number" class="form-control" id="balance" name="balance" step="0.01">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

   
<script>
    $(document).ready(function() {
        $('#blockSelect').change(function() {
            $('#blockForm').submit(); // Submit the form when select value changes
        });// Open modal and set values
            $('.edit-balance-btn').click(function() {
                var userId = $(this).data('id');
                var balance = $(this).data('balance');
                $('#user_id').val(userId);
                $('#balance').val(balance);
                $('#editBalanceModal').modal('show');
            });
        });
</script>

    
    <script>
        $('#memberSetting li:nth-child(1)').addClass('active');
        $('#memberSetting').addClass('show');
    </script>
@endsection

