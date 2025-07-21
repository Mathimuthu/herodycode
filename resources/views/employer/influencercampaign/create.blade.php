@extends('layouts.app')

@section('title', config('app.name').' | Create Influencer Campaign')

@section('content')
  <style>
    .platform-input {
      display: none;
      margin: 10px 0;
    }
    
  </style>

<div class="theme-layout">
	<section class="overlape">
		<div class="block no-padding">
			<div data-velocity="-.1" class="parallax scrolly-invisible no-parallax"></div><!-- PARALLAX BACKGROUND IMAGE -->
			<div class="container fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="inner-header">
							<h3>Welcome {{$employer->cname}}</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="block no-padding">
			<div class="container">
				 <div class="row no-gape">
                        @include('includes.emp-sidebar')
				 	<div class="col-sm-12 col-lg-8 col-xl-9">
				 		<div class="padding-left">
					 		<div class="profile-title">
					 			<h3>Post a New Influencer Campaign</h3>

					 		</div>
					 		<div class="profile-form-edit">
					 			<form action="{{route('employer.influencercampaign.create')}}" method="post" enctype="multipart/form-data">
                                     @csrf
                                     <input type="hidden" name="employer_id" value="{{ $employer->id }}">
					 				<div class="row">
					 					<div class="col-lg-12">
					 						<span class="pf-title">Campaign Title</span>
					 						<div class="pf-field">
                                                <input type="text" name="campaign_title" placeholder="Enter Title" >
					 						</div>
					 					</div>
					 					<div class="col-lg-12">
					 						<span class="pf-title">Campaign Description</span>
					 						<div class="pf-field">
                                                <textarea name="description" id="description" style="font-family: Poppins;"></textarea>
                                            </div>
					 					</div>
					 					  <div class="col-lg-12">
					 						<span class="pf-title">Choose File</span>
					 						<div class="pf-field">
                                                <input type="file" name="upload">
					 						</div>
					 					</div>					 				
                                       <div class="col-lg-12">
                                          <span class="pf-title">Select Platforms</span>
                                          <div class="platform-group">
                                            <label><input type="checkbox" value="Youtube" class="platform-checkbox"> YouTube</label>
                                            <label><input type="checkbox" value="Instagram" class="platform-checkbox"> Instagram</label>
                                            <label><input type="checkbox" value="Linkedin" class="platform-checkbox"> LinkedIn</label>
                                            <label><input type="checkbox" value="Twitter" class="platform-checkbox"> Twitter</label>
                                          </div>
                                        </div>
                                        
                                        <!-- Input fields -->
                                        <div id="YoutubeInput" class="platform-input">
                                          <label>YouTube URL:</label>
                                          <input type="url" name="youtubeUrl" placeholder="Paste your YouTube link">
                                        </div>
                                        
                                        <div id="InstagramInput" class="platform-input ml-2">
                                          <label>Instagram URL:</label>
                                          <input type="url" name="instagramUrl" placeholder="Paste your Instagram link">
                                        </div>
                                        
                                        <div id="LinkedinInput" class="platform-input ml-2">
                                          <label>LinkedIn URL:</label>
                                          <input type="url" name="linkedinUrl" placeholder="Paste your LinkedIn link">
                                        </div>
                                        
                                        <div id="TwitterInput" class="platform-input ml-2">
                                          <label>Twitter URL:</label>
                                          <input type="url" name="twitterUrl" placeholder="Paste your Twitter link">
                                        </div>
										<div class="col-lg-12">
											<span class="pf-title">Collab Type</span>
											<div class="pf-field">
											     <select id="collab_type" name="collab_type">
											        <option>Choose Collab Type</option>
											        <option value="Barter">Barter</option>
											        <option value="paid">Paid</option>
											    </select>
											</div>
										</div>
                                        <div class="col-lg-12">
					 						<button type="submit">Submit</button>
					 					</div>
                                        <br>

					 				</div>
					 			</form>
					 		</div>

					 	</div>
					</div>
				 </div>
			</div>
		</div>
    </section>
</div>
@endsection
@section('scripts')
<script id="taskhtml">
	<span>
	<input type="text" name="tasks[]" placeholder="Enter task description" style="height:1em;" required/>
	<input type="text" name="filess[]" placeholder="Enter link of the file to be shared" style="height:1em;" required/>
	</span>
</script>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<!--<script src="https://cdn.ckeditor.com/4.24.0-lts/full/ckeditor.js"></script>-->
// <script>
//     CKEDITOR.replace('description');
// </script>
<script>
    function newtask(obj){
		var a = $("#taskhtml").html();
		if($(obj).is(":checked")){
			$("#"+$(obj).attr('id').split('customCheck')[1]).append(a);
		}
		else{
			$('#'+$(obj).attr('id').split('customCheck')[1]+' span').remove()
		}
    }
</script>
<script>
  const checkboxes = document.querySelectorAll('.platform-checkbox');

  const platformInputs = {
    Youtube: document.getElementById('YoutubeInput'),
    Instagram: document.getElementById('InstagramInput'),
    Linkedin: document.getElementById('LinkedinInput'),
    Twitter: document.getElementById('TwitterInput'),
  };

  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', () => {
      const platform = checkbox.value;
      platformInputs[platform].style.display = checkbox.checked ? 'block' : 'none';
    });
  });
</script>
@endsection