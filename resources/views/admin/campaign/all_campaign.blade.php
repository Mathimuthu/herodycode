@extends('admin.master')

@section('title', 'Admin | All Gigs')

@section('body')

    <div class="container-fluid">
        <h2 class="mb-4">Gigs List</h2>

        <div class="input-group mb-3">
            <input type="text" class="form-control" id="liveSearch" placeholder="Search...">
        </div>

        <div class="card mb-4">
            <div class="card-header bg-white font-weight-bold">
                Gigs
            <div class="float-right">
                <a href="{{route('admin.campaign.create')}}" class="btn btn-primary btn-sm">Create Gig</a>
            </div>
            </div>
            <div class="card-body">
                {{-- {{$campaigns->links()}} --}}
                <table id="allcampaign" class="table  table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Per job cost</th>
                        <th scope="col">User</th>
                        <th scope="col">Publish Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Show Status</th> <!-- New column -->
                        <th scope="col">View Status</th> <!-- New column -->
                        <th scope="col">Priority</th>
                        <th scope="col">Show Slot</th>
                        <th scope="col">Action</th>
                        <th scope="col" style="width:100px">Timing</th>
                        <th scope="col">Show</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($campaigns as $campaign)
                    <?php
                        if($campaign->user_id=="Admin"){
                            $user = "Admin";
                        }
                        else{
                            $user = DB::table('employers')->find($campaign->user_id);
                            $user = $user->name;
                        }
                    ?>
                        <tr class="campaignRow">
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$campaign->campaign_title}}</td>
                            <td>{{$campaign->per_cost}}</td>
                            <td>{{$user}}</td>
                            <td>{{ \Carbon\Carbon::parse($campaign->created_at)->format('Y-m-d') }}</td>
                            <td><a href="{{route('admin.campaign.status',$campaign->id)}}" class="btn btn-{{$campaign->gigstatus ? 'success' : 'danger'}} btn-sm">
                                {{$campaign->gigstatus ? 'Active' : 'Inactive'}}
                            </a></td>
                             <td>
                                <a href="{{ route('admin.campaign.showstatus', $campaign->id) }}" class="btn btn-sm
                                    @if($campaign->show_status == 0) btn-primary
                                    @elseif($campaign->show_status == 1) btn-secondary
                                    @elseif($campaign->show_status == 2) btn-warning
                                    @else btn-danger
                                    @endif">
                                    @if($campaign->show_status == 0)
                                        New
                                    @elseif($campaign->show_status == 1)
                                        Normal
                                     @elseif($campaign->show_status == 2)
                                        Old
                                    @else
                                        Expires Soon
                                    @endif
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('admin.campaign.toggleStatus', $campaign->id) }}" method="POST" id="toggleStatusForm-{{ $campaign->id }}">
                                    @csrf
                                    <input type="hidden" name="view_status" value="{{ $campaign->view_status == 1 ? 0 : 1 }}">
                                    <button type="submit" class="btn btn-info btn-sm">
                                        {{ $campaign->view_status == 1 ? 'Show Approved Applicants' : 'Show Total Applicants' }}
                                    </button>
                                </form>
                            </td>
                            <!--<td>@if($user=="Admin")<a href="{{route('admin.campaign.app',$campaign->id)}}">View Applications</a>@endif</td>-->
                            <td>
                                <form action="{{route('admin.campaign.set-priority')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$campaign->id}}">
                                    <div class="input-group">
                                        <input type="text" name="priority" class="form-control" value="{{$campaign->priority}}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary btn-sm">Set Priority</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                             <td>
                            <form action="{{ route('admin.campaign.showfirst', $campaign->id) }}" method="POST" class="d-inline">
                                @csrf
                                <div class="input-group input-group-sm">
                                    <!-- Input Field -->
                                    <input type="number" name="set_slot" id="slotNumber-{{ $campaign->id }}" class="form-control form-control-sm"
                                           placeholder="Slot #" min="0" value="{{ $campaign->set_slot }}" style="max-width: 60px;" oninput="updateSlotDisplay({{ $campaign->id }})" >

                                    <!-- Display Selected Slot -->
                                    <span class="input-group-text" id="slotDisplay-{{ $campaign->id }}">{{ $campaign->set_slot ?? '-' }}</span>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn {{ $campaign->set_slot ? 'btn-success' : 'btn-secondary' }}">
                                        {{ $campaign->set_slot ? 'Update Slot' : 'Set Slot' }}
                                    </button>
                                </div>
                            </form>
                            <form action="{{ route('admin.campaign.showsecond', $campaign->id) }}" method="POST" class="d-inline">
                                @csrf
                                <div class="input-group input-group-sm mt-2">
                                    <!-- Second Slot Field -->
                                    <input type="number" name="second_slot" id="secondSlotNumber-{{ $campaign->id }}" class="form-control form-control-sm"
                                           placeholder="Second Slot #" min="0" value="{{ $campaign->second_slot }}" style="max-width: 60px;" oninput="updateSecondSlotDisplay({{ $campaign->id }})">

                                    <!-- Display Second Slot -->
                                    <span class="input-group-text" id="secondSlotDisplay-{{ $campaign->id }}">{{ $campaign->second_slot ?? '-' }}</span>

                                    <!-- Submit Button for Second Slot -->
                                    <button type="submit" class="btn {{ $campaign->second_slot ? 'btn-success' : 'btn-secondary' }}">
                                        {{ $campaign->second_slot ? 'Update Slot' : 'Set Slot' }}
                                    </button>
                                </div>
                            </form>
                        </td>
                            <td>
                                @if($campaign->mobile==0)
                                <form action="{{route('admin.campaign.make-mobile')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$campaign->id}}">
                                    <button type="submit" class="btn btn-success btn-sm">Make mobile specific</button>
                                </form>
                                @else
                                <form action="{{route('admin.campaign.undo-mobile')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$campaign->id}}">
                                    <button type="submit" class="btn btn-danger btn-sm">Undo mobile specific</button>
                                </form>
                                @endif
                            </td>
                            <td>{{ $campaign->timing ?? 'N/A' }}</td>
                            <td>
                                <a href="{{route('admin.campaign.gig-details',$campaign->id)}}" class="btn btn-info btn-sm customs-btn-bd text-white" style="float:left;margin:5px 5px"> <i class="fa fa-eye"></i></a>
                                <a href="{{route('admin.campaign.edit',$campaign->id)}}" class="btn btn-primary btn-sm customs-btn-bd text-white" style="float:left;margin:0px 5px"> <i class="fa fa-edit"></i></a>

                                <form action="{{route("admin.campaign.delete")}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$campaign->id}}"/>
                                    <button onClick ="return confirm('Are You sure want to delete the gigs ?')" type="submit" class="btn btn-sm btn-danger" style="float:left;margin:0px 5px"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                {{-- {{$campaigns->links()}} --}}
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        // $(document).ready(function() {
        //     $('#allcampaign').DataTable();
        // });
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

    {{--dropdown active--}}
    <script>
        $('#Campaigns li:nth-child(3)').addClass('active');
        $('#Campaigns').addClass('show');
    </script>
@endsection
