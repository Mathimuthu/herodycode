@extends('layouts.app')

@section('title', config('app.name').' | Edit Influencer Campaign')
<style>
	.platform-input {
		margin: 10px 0;
	}
</style>
@section('content')
<div class="theme-layout">
	<section class="overlape">
		<div class="block no-padding">
			<div data-velocity="-.1" class="parallax scrolly-invisible no-parallax"></div>
			<div class="container fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="inner-header">
							<h3>Welcome {{ $employer->cname }}</h3>
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
								<h3>Edit {{ $camp->title }}</h3>
							</div>
							<div class="profile-form-edit">
								<form action="{{ route('employer.influencercampaign.edit', $camp->id) }}" method="post" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="id" value="{{ $camp->id }}">
									<input type="hidden" name="employer_id" value="{{ $employer->id }}">

									<div class="row">
										<div class="col-lg-12">
											<span class="pf-title">Campaign Title</span>
											<div class="pf-field">
												<input type="text" name="campaign_title" placeholder="Enter Title" value="{{ old('campaign_title', $camp->title) }}">
											</div>
										</div>

										<div class="col-lg-12">
											<span class="pf-title">Campaign Description</span>
											<div class="pf-field">
												<textarea name="description" id="description">{{ old('description', $camp->description) }}</textarea>
											</div>
										</div>

										<div class="col-lg-12">
											<span class="pf-title">Choose File (Leave blank to keep current)</span>
											<div class="pf-field">
												<input type="file" name="upload">
												@if($camp->upload)
													<p>Current file: <a href="{{ asset($camp->upload) }}" target="_blank">View</a></p>
												@endif
											</div>
										</div>

										<div class="col-lg-12">
											<span class="pf-title">Select Platforms</span>
											<div class="platform-group">
												<label><input type="checkbox" value="Youtube" class="platform-checkbox" @if($camp->youtube) checked @endif> YouTube</label>
												<label><input type="checkbox" value="Instagram" class="platform-checkbox" @if($camp->instagram) checked @endif> Instagram</label>
												<label><input type="checkbox" value="Linkedin" class="platform-checkbox" @if($camp->linkedin) checked @endif> LinkedIn</label>
												<label><input type="checkbox" value="Twitter" class="platform-checkbox" @if($camp->twitter) checked @endif> Twitter</label>
											</div>
										</div>

										<!-- Platform URL inputs -->
										<div id="YoutubeInput" class="platform-input" style="display: {{ $camp->youtube ? 'block' : 'none' }};">
											<label>YouTube URL:</label>
											<input type="url" name="youtubeUrl" placeholder="Paste your YouTube link" value="{{ old('youtubeUrl', $camp->youtube) }}">
										</div>

										<div id="InstagramInput" class="platform-input" style="display: {{ $camp->instagram ? 'block' : 'none' }};">
											<label>Instagram URL:</label>
											<input type="url" name="instagramUrl" placeholder="Paste your Instagram link" value="{{ old('instagramUrl', $camp->instagram) }}">
										</div>

										<div id="LinkedinInput" class="platform-input" style="display: {{ $camp->linkedin ? 'block' : 'none' }};">
											<label>LinkedIn URL:</label>
											<input type="url" name="linkedinUrl" placeholder="Paste your LinkedIn link" value="{{ old('linkedinUrl', $camp->linkedin) }}">
										</div>

										<div id="TwitterInput" class="platform-input" style="display: {{ $camp->twitter ? 'block' : 'none' }};">
											<label>Twitter URL:</label>
											<input type="url" name="twitterUrl" placeholder="Paste your Twitter link" value="{{ old('twitterUrl', $camp->twitter) }}">
										</div>

										<div class="col-lg-12">
											<span class="pf-title">Collab Type</span>
											<div class="pf-field">
												<select id="collab_type" name="collab_type">
													<option value="">Choose Collab Type</option>
													<option value="Barter" @if(old('collab_type', $camp->collab_type) == 'barter') selected @endif>Barter</option>
													<option value="paid" @if(old('collab_type', $camp->collab_type) == 'paid') selected @endif>Paid</option>
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
<!--<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>-->
<script>
// 	CKEDITOR.replace('description');

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
			if (platformInputs[platform]) {
				platformInputs[platform].style.display = checkbox.checked ? 'block' : 'none';
			}
		});
	});
</script>
@endsection
