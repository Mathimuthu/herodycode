@extends('layouts.app')
@section('title',config('app.name').' | ' .$employer->name)
<?php
    $employerId = Auth::guard('employer')->id();
    $user = DB::table('employers')->find($employerId);
    $countries = DB::table('countries')->orderBy('name','asc')->get();
?>
@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {!! session('success') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {!! session('error') !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- Welcome Card -->
<div class="mb-4">
    <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 30px;">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $user->name }}</h1>
            <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" style="width: 200px; height: 120px; object-fit: contain;" />
        </div>
    </div>
</div>

<div class="card shadow-lg border-0">
    <!-- Header with Profile Image and Upload in Same Row -->
    <div class="card-header bg-white border-bottom">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 font-weight-bold text-dark mb-0">Company Profile</h2>
        </div>

        <!-- Profile Image and Upload Section -->
        <div class="d-flex align-items-center p-3 bg-light rounded">
            <div class="flex-shrink-0 mr-4">
                <img src="{{ asset('assets/employer/profile_images/'.$employer->profile_photo) }}"
                     alt="Profile Image"
                     class="rounded shadow"
                     style="width: 96px; height: 96px; object-fit: cover;">
            </div>
            <div class="flex-grow-1">
                <h3 class="h5 font-weight-semibold text-dark mb-2">Profile Photo</h3>
                <form id="profile_image" method="POST" enctype="multipart/form-data" action="{{route('employer.profile_image.update')}}" class="d-inline-block">
                    @csrf
                    <div class="position-relative">
                        <input class="position-absolute w-100 h-100"
                               style="opacity: 0; cursor: pointer; top: 0; left: 0;"
                               id="imageUpload"
                               accept=".png,.jpg,.bpm,.jpeg,.gif"
                               type="file"
                               onchange="document.getElementById('profile_image').submit();"
                               name="profile_image" />
                        <button type="button" class="btn btn-primary d-flex align-items-center">
                            <i class="fas fa-upload mr-2"></i>
                            <span>Upload New Photo</span>
                        </button>
                    </div>
                </form>
                <small class="text-muted mt-2 d-block">Supported formats: PNG, JPG, JPEG, GIF</small>
            </div>
        </div>
    </div>

    <!-- Form Content -->
    <div class="card-body">
        <form method="POST" action="{{route('employer.profile')}}">
            @csrf

            <!-- Personal Information Section -->
            <div class="card mb-4 border">
                <div class="card-header bg-white">
                    <h3 class="h5 font-weight-semibold text-dark mb-0 d-flex align-items-center">
                        <i class="fas fa-building text-primary mr-2"></i>
                        Company Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="cname">Company Name</label>
                            <input type="text" name="cname" id="cname"
                                   class="form-control"
                                   placeholder="Enter company name"
                                   value="{{$employer->cname}}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="email">Email Address</label>
                            <input type="email" name="email" id="email"
                                   class="form-control"
                                   placeholder="Enter email address"
                                   value="{{$employer->email}}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="name">Contact Person Name</label>
                            <input type="text" name="name" id="name"
                                   class="form-control"
                                   placeholder="Enter contact person name"
                                   value="{{$employer->name}}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="phone">Phone Number</label>
                            <input type="text" name="phone" id="phone"
                                   class="form-control"
                                   placeholder="Enter phone number"
                                   value="{{$employer->phone}}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="website">Website</label>
                            <input type="url" name="website" id="website"
                                   class="form-control"
                                   placeholder="https://www.example.com"
                                   value="{{$employer->website}}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="category">Industry Category</label>
                            <input type="text" name="category" id="category"
                                   class="form-control"
                                   placeholder="e.g., Technology, Healthcare"
                                   value="{{$employer->category}}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="founded">Founded Date</label>
                            <input type="date" name="founded" id="founded"
                                   class="form-control"
                                   value="{{\Carbon\Carbon::parse($employer->founded)->format('Y-m-d')}}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="gstin">GSTIN</label>
                            <input type="text" name="gstin" id="gstin"
                                   class="form-control"
                                   placeholder="Enter GSTIN number"
                                   value="{{$employer->gstin}}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="pan">PAN</label>
                            <input type="text" name="pan" id="pan"
                                   class="form-control"
                                   placeholder="Enter PAN number"
                                   value="{{$employer->pan}}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="card mb-4 border">
                <div class="card-header bg-white">
                    <h3 class="h5 font-weight-semibold text-dark mb-0 d-flex align-items-center">
                        <i class="fas fa-map-marker-alt text-success mr-2"></i>
                        Contact Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="font-weight-medium text-dark mb-2" for="address">Address</label>
                        <input name="address" id="address"
                               class="form-control"
                               placeholder="Enter complete address"
                               value="{{$employer->address}}"
                               type="text">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="country">Country</label>
                            <select name="country" id="countries" class="form-control">
                                @foreach($countries as $country)
                                <option value="{{$country->name}}" @if($country->name==$employer->country) selected @endif>{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="state">State</label>
                            <select name="state" id="states" class="form-control">
                                <option value="{{$employer->state}}">{{$employer->state}}</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="city">City</label>
                            <select name="city" id="cities" class="form-control">
                                <option value="{{$employer->city}}">{{$employer->city}}</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="zip_code">Postal Code</label>
                            <input type="text" name="zip_code" id="zip_code"
                                   class="form-control"
                                   placeholder="Enter postal code"
                                   value="{{$employer->zip_code}}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- About Section -->
            <div class="card mb-4 border">
                <div class="card-header bg-white">
                    <h3 class="h5 font-weight-semibold text-dark mb-0 d-flex align-items-center">
                        <i class="fas fa-file-alt text-info mr-2"></i>
                        About Company
                    </h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="font-weight-medium text-dark mb-2">Company Description</label>
                        <textarea name="description" id="description"
                                  class="form-control"
                                  rows="6"
                                  placeholder="Tell us about your company...">{{$employer->description}}</textarea>
                    </div>
                </div>
            </div>

            <!-- Social Networks Section -->
            <div class="card mb-4 border">
                <div class="card-header bg-white">
                    <h3 class="h5 font-weight-semibold text-dark mb-0 d-flex align-items-center">
                        <i class="fas fa-share-alt text-purple mr-2"></i>
                        Social Networks
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="facebook">Facebook</label>
                            <input name="facebook" id="facebook"
                                   class="form-control"
                                   placeholder="https://facebook.com/yourcompany"
                                   value="{{$employer->facebook}}"
                                   type="url">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="twitter">Twitter</label>
                            <input name="twitter" id="twitter"
                                   class="form-control"
                                   placeholder="https://twitter.com/yourcompany"
                                   value="{{$employer->twitter}}"
                                   type="url">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="linkedin">LinkedIn</label>
                            <input name="linkedin" id="linkedin"
                                   class="form-control"
                                   placeholder="https://linkedin.com/company/yourcompany"
                                   value="{{$employer->linkedin}}"
                                   type="url">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="youtube">YouTube</label>
                            <input name="youtube" id="youtube"
                                   class="form-control"
                                   placeholder="https://youtube.com/c/yourcompany"
                                   value="{{$employer->youtube}}"
                                   type="url">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="vimeo">Vimeo</label>
                            <input name="vimeo" id="vimeo"
                                   class="form-control"
                                   placeholder="https://vimeo.com/yourcompany"
                                   value="{{$employer->vimeo}}"
                                   type="url">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="font-weight-medium text-dark mb-2" for="gplus">Google Plus</label>
                            <input name="gplus" id="gplus"
                                   class="form-control"
                                   placeholder="https://plus.google.com/yourcompany"
                                   value="{{$employer->gplus}}"
                                   type="url">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-end pt-3 border-top">
                <button type="submit" class="btn btn-success d-flex align-items-center">
                    <i class="fas fa-check mr-2"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.text-purple {
    color: #6f42c1;
}

@media (max-width: 768px) {
    .manager-avatar {
        max-width: 150px !important;
        margin-top: 1rem;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        align-items: center;
    }

    .card-body .mr-4 {
        margin-right: 1rem !important;
        margin-bottom: 1rem;
    }

    .flex-shrink-0 {
        text-align: center;
    }
}
</style>

@endsection

@section('scripts')
<script src="{{asset('assets/main/js/world.js')}}"></script>
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description', {
        height: 200,
        toolbar: [
            { name: 'document', items: ['Source'] },
            { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'Undo', 'Redo'] },
            { name: 'editing', items: ['Find', 'Replace'] },
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
            { name: 'insert', items: ['Link', 'Unlink'] },
            { name: 'styles', items: ['Format'] }
        ]
    });
</script>
@endsection
