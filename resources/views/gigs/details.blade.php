@extends('layouts.app')
@section('title', config('app.name').' | Gig Details')
@section('content')
<?php
    $employerId = Auth::guard('employer')->id();
    $user1 = DB::table('employers')->find($employerId);

    if($campaign->user_id=="Admin"){
        $user = "Admin";
    }
    else{
        $usere = DB::table('employers')->find($campaign->user_id);
        $user = $usere->name;
    }
    $cats = explode(", ",$campaign->cats);
    $count = 0;
    foreach($cats as $cat){
        $count++;
    }
    $statuses = [1,3,5];
    $tasks = App\Task::where('cid',$campaign->id)->get();
    $i=0;
?>

<!-- Header Section -->
<div class="mb-4">
    <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div class="card-body d-flex justify-content-between align-items-center py-3">
            <div>
                <h1 class="h3 font-weight-bold text-dark mb-1">Hi, {{ $user1->name }}</h1>
                <p class="mb-0 text-muted small">Gig Details</p>
            </div>
            <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="img-fluid" style="width: 100px; height: auto;"/>
        </div>
    </div>
</div>

<div class="container-fluid px-lg-4 px-md-3 px-2">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <!-- Gig Header -->
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start mb-4">
                <div class="d-flex align-items-start mb-3 mb-lg-0">
                    <img src="@if($user=='Admin') {{asset('assets/admin/img/gig-brand-logo/'.$campaign->logo)}} @else {{asset('assets/employer/profile_images/'.$usere->profile_photo)}} @endif"
                         alt="Company Logo"
                         class="rounded mr-4"
                         style="width: 80px; height: 80px; object-fit: contain;">
                    <div>
                        <h2 class="h3 font-weight-bold text-dark mb-1">{{$campaign->campaign_title}}</h2>
                        <p class="mb-2 text-muted">{{$campaign->brand}}</p>
                        <div class="d-flex flex-wrap">
                            <span class="badge badge-light text-primary border mr-2 mb-2">
                                <i class="fas fa-coins mr-1"></i> ₹{{$campaign->per_cost}}
                            </span>
                            <span class="badge badge-light text-muted border mr-2 mb-2">
                                <i class="fas fa-tasks mr-1"></i> {{$count-1}} Tasks
                            </span>
                            <span class="badge badge-light text-muted border mb-2">
                                <i class="fas fa-calendar mr-1"></i> {{\Carbon\Carbon::parse($campaign->created_at)->format('d M Y')}}
                            </span>
                        </div>
                    </div>
                </div>

                @if(Auth::check())
                    @if(DB::table('gig_apps')->where(['uid' => Auth::user()->id,'cid' => $campaign->id])->exists())
                        <a href="{{route('user.gigs.show')}}" class="btn btn-success px-4">
                            <i class="fas fa-check-circle mr-2"></i>Applied
                        </a>
                    @else
                    <form action="{{route('campaign.apply')}}" method="POST" class="w-100 w-lg-auto">
                        @csrf
                        <input type="hidden" name="id" value="{{$campaign->id}}">
                        <button class="btn btn-primary btn-block px-4" type="submit">
                            <i class="fas fa-paper-plane mr-2"></i>Apply Now
                        </button>
                    </form>
                    @endif
                @else
                <a href="{{route('employer.login')}}" class="btn btn-outline-primary px-4">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login to Apply
                </a>
                @endif
            </div>

            <hr class="my-4">

            <!-- Tasks Section -->
            <div class="mb-5">
                <h4 class="font-weight-bold mb-4 d-flex align-items-center">
                    <i class="fas fa-tasks text-primary mr-2"></i> Available Tasks
                </h4>

                @if($count-1 == 0)
                <div class="alert alert-info">
                    No tasks available for this gig yet.
                </div>
                @else
                <div class="row">
                    @foreach($cats as $cat)
                        @if($cat!="")
                        <?php
                            $cate = DB::table('gig_categories')->find($cat);
                            if($cate->id==1) $type = "Type: Facebook";
                            if($cate->id==2) $type = "Type: Whatsapp";
                            if($cate->id==3) $type = "Type: Instagram Story";
                            if($cate->id==4) $type = "Type: Youtube";
                            if($cate->id==5) $type = "Type: Instagram Post";
                            if($cate->id==6) $type = "Type: Online Survey";
                            if($cate->id==7) $type = "Type: Download App";
                            if($cate->id==8) $type = "Type: Social Media";
                        ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{asset('assets/admin/img/cate_img/'.$cate->c_photo)}}"
                                             alt="Task Icon"
                                             class="rounded mr-3"
                                             style="width: 50px; height: 50px; object-fit: contain;">
                                        <h5 class="mb-0 font-weight-bold">{{$cate->name}}</h5>
                                    </div>
                                    <p class="small text-muted mb-3">{{$type}}</p>

                                    @if(Auth::check())
                                    @if(DB::table('gig_apps')->where(['uid'=>Auth::user()->id,'cid'=>$campaign->id])->wherein('status',$statuses)->exists() and DB::table('completed_gigs')->where(['user_id'=>Auth::user()->id,'job_id'=>$campaign->id])->where('proof_text','LIKE','%'.$type.'%')->doesntExist())
                                    <button type="button"
                                            onclick="openm('{{$cate->id}}')"
                                            class="btn btn-outline-primary btn-block">
                                        <i class="fas fa-play-circle mr-2"></i>Start Task
                                    </button>
                                    <?php $i=$i+1; ?>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
                @endif
            </div>

            <!-- About Section -->
            <div class="mb-4">
                <h4 class="font-weight-bold mb-3 d-flex align-items-center">
                    <i class="fas fa-info-circle text-primary mr-2"></i> About This Gig
                </h4>
                <div class="bg-light rounded p-4">
                    {!!$campaign->description!!}
                </div>
            </div>

            <!-- Tasks List -->
            @if($tasks->count() > 0)
            <div class="mb-4">
                <h4 class="font-weight-bold mb-3 d-flex align-items-center">
                    <i class="fas fa-list-check text-primary mr-2"></i> Task Details
                </h4>
                <ul class="list-group">
                    @foreach($tasks as $task)
                        @if($task->task!="")
                        <li class="list-group-item border-0 bg-light mb-2 rounded">{!!$task->task!!}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Social Media Links -->
            @if($user!="Admin")
            <div class="mb-4">
                <h4 class="font-weight-bold mb-3 d-flex align-items-center">
                    <i class="fas fa-share-alt text-primary mr-2"></i> Social Links
                </h4>
                <div class="row">
                    @if($usere->facebook!=NULL)
                    <div class="col-12 col-md-6 col-lg-4 mb-3">
                        <a href="{{$usere->facebook}}" class="d-flex align-items-center p-3 bg-light rounded text-dark" target="_blank">
                            <i class="fab fa-facebook-f text-primary mr-3 fa-lg"></i>
                            <span class="text-truncate">{{$usere->facebook}}</span>
                        </a>
                    </div>
                    @endif
                    @if($usere->twitter!=NULL)
                    <div class="col-12 col-md-6 col-lg-4 mb-3">
                        <a href="{{$usere->twitter}}" class="d-flex align-items-center p-3 bg-light rounded text-dark" target="_blank">
                            <i class="fab fa-twitter text-info mr-3 fa-lg"></i>
                            <span class="text-truncate">{{$usere->twitter}}</span>
                        </a>
                    </div>
                    @endif
                    @if($usere->gplus!=NULL)
                    <div class="col-12 col-md-6 col-lg-4 mb-3">
                        <a href="{{$usere->gplus}}" class="d-flex align-items-center p-3 bg-light rounded text-dark" target="_blank">
                            <i class="fab fa-google text-danger mr-3 fa-lg"></i>
                            <span class="text-truncate">{{$usere->gplus}}</span>
                        </a>
                    </div>
                    @endif
                    @if($usere->youtube!=NULL)
                    <div class="col-12 col-md-6 col-lg-4 mb-3">
                        <a href="{{$usere->youtube}}" class="d-flex align-items-center p-3 bg-light rounded text-dark" target="_blank">
                            <i class="fab fa-youtube text-danger mr-3 fa-lg"></i>
                            <span class="text-truncate">{{$usere->youtube}}</span>
                        </a>
                    </div>
                    @endif
                    @if($usere->vimeo!=NULL)
                    <div class="col-12 col-md-6 col-lg-4 mb-3">
                        <a href="{{$usere->vimeo}}" class="d-flex align-items-center p-3 bg-light rounded text-dark" target="_blank">
                            <i class="fab fa-vimeo-v text-info mr-3 fa-lg"></i>
                            <span class="text-truncate">{{$usere->vimeo}}</span>
                        </a>
                    </div>
                    @endif
                    @if($usere->linkedin!=NULL)
                    <div class="col-12 col-md-6 col-lg-4 mb-3">
                        <a href="{{$usere->linkedin}}" class="d-flex align-items-center p-3 bg-light rounded text-dark" target="_blank">
                            <i class="fab fa-linkedin-in text-primary mr-3 fa-lg"></i>
                            <span class="text-truncate">{{$usere->linkedin}}</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .modal-content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .modal-header {
        border-bottom: 1px solid #eee;
        background-color: #f8f9fa;
        border-radius: 12px 12px 0 0;
    }
    .modal-title {
        font-weight: 600;
        color: #333;
    }
    .file-upload-btn {
        transition: all 0.3s;
    }
    .file-upload-btn:hover {
        transform: translateY(-2px);
    }
    .badge-light {
        background-color: #f8f9fa;
    }
</style>


<!-- FB proof -->
<div class="modal fade" id="1" tabindex="-1" role="dialog" aria-labelledby="FBModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Share a post on facebook</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('campaign.prooffb')}}" enctype="multipart/form-data">
          @csrf
      <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="id" value="{{$campaign->id}}">
              <span for="username">FB Username</span>
              <input type="text" name="username" class="form-control">
          </div>
          <div class="form-group">
              <span for="username">Link to the post</span>
              <input type="text" name="link" class="form-control">
          </div>
          <div class="form-group">
              <span for="ss">Screenshot</span><br>
              <input type="file" name="ss" id="ss" accept=".jpg,.jpeg,.png,.bmp,.gif" onchange="getn(this.value,'fb')" style="display:none">
              <button type="button" class="btn btn-warning btn-lg float-left" onclick="document.getElementById('ss').click();">Upload Screenshot</button>
          </div>
          <div id="getnfb"></div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
</div>

<!-- WA proof -->
<div class="modal fade" id="2" tabindex="-1" role="dialog" aria-labelledby="WAModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Share a message on whatsapp</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('campaign.proofwa')}}" enctype="multipart/form-data">
          @csrf
      <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="id" value="{{$campaign->id}}">
              <span for="phone">Mobile Number</span>
              <input type="text" name="phone" class="form-control">
          </div>
          <div class="form-group">
              <span for="ss">Screenshot</span><br>
              <input type="file" name="ss" id="wass" onchange="getn(this.value,'wa')" accept=".jpg,.jpeg,.png,.bmp,.gif" style="display:none">
              <button type="button" class="btn btn-warning btn-lg float-left" onclick="document.getElementById('wass').click();">Upload Screenshot</button>
          </div>
          <div id="getnwa"></div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Insta proof -->
<div class="modal fade" id="3" tabindex="-1" role="dialog" aria-labelledby="InstaModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Post an instagram story</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('campaign.proofinsta')}}" enctype="multipart/form-data">
          @csrf
      <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="id" value="{{$campaign->id}}">
              <span for="username">Instagram Username</span>
              <input type="text" name="username" class="form-control">
          </div>
          <div class="form-group">
              <span for="link">Link to the post</span>
              <input type="text" name="link" class="form-control">
          </div>
          <div class="form-group">
              <span for="ss">Screenshot</span><br>
              <input type="file" name="ss" id="instass" onchange="getn(this.value,'insta')" accept=".jpg,.jpeg,.png,.bmp,.gif" style="display:none">
              <button type="button" class="btn btn-warning btn-lg float-left" onclick="document.getElementById('instass').click();">Upload Screenshot</button>
          </div>
          <div id="getninsta"></div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Youtube proof -->
<div class="modal fade" id="4" tabindex="-1" role="dialog" aria-labelledby="YtModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Youtube Like, Comment, Subscribe</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('campaign.proofyt')}}" enctype="multipart/form-data">
          @csrf
      <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="id" value="{{$campaign->id}}">
              <span for="username">Youtube Username/Name</span>
              <input type="text" name="username" class="form-control">
          </div>
          <div class="form-group">
              <span for="ss">Screenshot</span><br>
              <input type="file" name="ss" id="ytss" onchange="getn(this.value,'yt')" accept=".jpg,.jpeg,.png,.bmp,.gif" style="display:none">
              <button type="button" class="btn btn-warning btn-lg float-left" onclick="document.getElementById('ytss').click();">Upload Screenshot</button>
          </div>
          <div id="getnyt"></div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Instagram Post proof -->
<div class="modal fade" id="5" tabindex="-1" role="dialog" aria-labelledby="DtModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Make an instagram post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('campaign.proofinstap')}}" enctype="multipart/form-data">
          @csrf
      <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="id" value="{{$campaign->id}}">
              <span for="username">Instagram Username</span>
              <input type="text" name="username" class="form-control">
          </div>
          <div class="form-group">
              <span for="link">Link to the post</span>
              <input type="text" name="link" class="form-control">
          </div>
          <div class="form-group">
              <span for="ss">Screenshot</span><br>
              <input type="file" name="ss" id="instapss" onchange="getn(this.value,'instap')" accept=".jpg,.jpeg,.png,.bmp,.gif" style="display:none">
              <button type="button" class="btn btn-warning btn-lg float-left" onclick="document.getElementById('instapss').click();">Upload Screenshot</button>
          </div>
          <div id="getninstap"></div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Online Survey proof -->
<div class="modal fade" id="6" tabindex="-1" role="dialog" aria-labelledby="OSModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Online Survey</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('campaign.proofos')}}" enctype="multipart/form-data">
          @csrf
      <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="id" value="{{$campaign->id}}">
              <span for="email">Email</span>
              <input type="email" name="email" class="form-control">
          </div>
          <div class="form-group">
              <span for="ss">Screenshot</span><br>
              <input type="file" name="ss" id="osss" onchange="getn(this.value,'os')" accept=".jpg,.jpeg,.png,.bmp,.gif" style="display:none">
              <button type="button" class="btn btn-warning btn-lg float-left" onclick="document.getElementById('osss').click();">Upload Screenshot</button>
          </div>
          <div id="getnos"></div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- App proof -->
<div class="modal fade" id="7" tabindex="-1" role="dialog" aria-labelledby="ARModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Download an app and register</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('campaign.proofar')}}" enctype="multipart/form-data">
          @csrf
      <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="id" value="{{$campaign->id}}">
              <span for="cred">Your credentials</span>
              <input type="text" name="cred" class="form-control">
          </div>
          <div class="form-group">
              <span for="ss">Screenshot</span><br>
              <input type="file" name="ss" id="appss" onchange="getn(this.value,'os')" accept=".jpg,.jpeg,.png,.bmp,.gif" style="display:none" multiple>
              <button type="button" class="btn btn-warning btn-lg float-left" onclick="document.getElementById('appss').click();">Upload Screenshot</button>
          </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Social media proof -->
<div class="modal fade" id="8" tabindex="-1" role="dialog" aria-labelledby="LSModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Like/Follow Social media page</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="{{route('campaign.proofls')}}" enctype="multipart/form-data">
          @csrf
      <div class="modal-body">
          <div class="form-group">
              <input type="hidden" name="id" value="{{$campaign->id}}">
              <span for="cred">Your credentials</span>
              <input type="text" name="cred" class="form-control">
          </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
    function openm(id){
        $('#'+id).modal('show');
    }
    function getn(str,d){
        str = str.split(/(\\|\/)/g).pop();
        $('#getn'+d).html('<small class="text-muted">Selected: </small>' + str);
    }
</script>
@endsection
