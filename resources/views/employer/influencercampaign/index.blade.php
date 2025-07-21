@extends('layouts.app')
@section('title',config('app.name').' | Manage Influencer campaign')
@section('heads')
<style>
.btn-postinter{
    display:block;
    padding: 0.3em;
    background: #E28C12;
    cursor: pointer;
    border: 2px solid #E28C12;
    border-radius: 3px;
    color: white;
    font-weight: bold;
    font-size: 1.1em;
    transition: all ease-out 0.5s;
}
.btn-postinter:hover{
    background: #C27910;
    border: 2px solid #C27910;
    color: #ffffff;
}
td {
    vertical-align: middle;
}
</style>
@endsection
@section('content')
<!-- Our Dashbord -->
	<section class="cnddte_fvrt our-dashbord dashbord">
		<div class="container">
			<div class="row">
          @include('includes.emp-sidebar')
				<div class="col-sm-12 col-lg-8 col-xl-9">
					<div class="row">
						<div class="col-lg-12">
							<h4 class="mb30">Manage Influencer Campaign</h4>
						</div>
						<div class="col-lg-12"> 
                          @if($campaigns->count()==0)
                          <div><h1>No data found</h1></div>
                          @else
							<div class="cnddte_fvrt_job candidate_job_reivew style2">
								<div class="table-responsive job_review_table">
									<table class="table">
										<thead class="thead-light">
									    	<tr>
									    		<th scope="col">Campaign Title</th>
									    		<th scope="col">File Upload</th>
									    		<th scope="col">Status</th>
									    		<th scope="col">Action</th>
									    	</tr>
										</thead>
										<tbody>
                                          @foreach($campaigns as $campaign)
                                          <?php
                                              $e = DB::table('employers')->find($campaign->employe_id);
                                              $user = $e->cname;
                                          ?>
									    	<tr>
									    		<th scope="row">
									    			<a href="{{route('campaign.details',$campaign->id)}}"><h4>{{$campaign->title}}</h4></a>
									    			<p><span class="flaticon-location-pin"></span>{{$user}}</p>
									    			<ul>
									    				<li class="list-inline-item"><a href="#created"><span class="flaticon-event"> Created: </span></a></li>
									    				<li class="list-inline-item"><a class="color-black22" href="#createdat">{{\Carbon\Carbon::parse($campaign->created_at)->format('M d,Y')}}</a></li>
                                                    </ul>
									    			 <p><span class="flaticon fa-solid fa-eye"></span>  Status : {{$campaign->status}}</p>
									    		</th>
									    		<td>
                                                    @if($campaign->upload)
                                                        @php
                                                            $isImage = preg_match('/\.(jpg|jpeg|png|gif)$/i', $campaign->upload);
                                                        @endphp
                                                        @if($isImage)
                                                            <button style="float:none;" onclick="window.open('{{ asset($campaign->upload) }}', '_blank')">View Image</button>
                                                        @endif
                                                    @else
                                                        No file uploaded
                                                    @endif
                                                </td>
                                               <td>
                                                    <a href="{{ route('employer.influencercampaign.statushistory', $campaign->id) }}" class="btn btn-info btn-sm">
                                                        View Status
                                                    </a>
                                                </td>
    									    	<td class="d-flex align-items-center gap-2">
                                                    <!-- Edit Button -->
                                                    <a href="{{ route('employer.influencercampaign.editer', $campaign->id) }}" 
                                                       class="btn btn-sm btn-primary ml-2" 
                                                       data-toggle="tooltip" 
                                                       data-placement="bottom" 
                                                       title="Edit Campaign">
                                                       <span class="flaticon-edit"></span>
                                                    </a>
                                                    <!-- Delete Button -->
                                                    <form action="{{route('employer.influencercampaign.delete')}}" method="post" onsubmit="return confirm('Are you sure want to delete this?');">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $campaign->id }}">
                                                        <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Campaign">
                                                            <span class="flaticon-rubbish-bin"></span>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                    					</tbody>
                                     </table>
								</div>
							</div>
                          {{$campaigns->links()}}
                          @endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

