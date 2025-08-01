@extends('layouts.app')

@section('title', config('app.name') . ' | Selected Resumes')

@section('content')
<div class="container-fluid px-0">
    <section class="hero-section bg-light position-relative overflow-hidden">

        <div class="position-absolute w-100 h-100" style="background: url(images/resource/mslider1.jpg) no-repeat center center; background-size: cover; opacity: 0.3;"></div>
        <div class="mb-4">
            <div class="card" style="background: linear-gradient(135deg, #d4edda 0%, #cce7ff 100%); border: none; border-radius: 30px;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h1 class="h2 font-weight-bold text-dark mb-0 ml-2">Hi, {{ $employer->name }}</h1>
                    <img src="{{ asset('assets/images/manager-avatar.png') }}" alt="Manager" class="manager-avatar" style="width: 200px; height: 120px; object-fit: contain;" />
                </div>
            </div>
        </div>
        <div class="container position-relative py-5">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h1 class="text-center mb-4">Responses</h1>

                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row g-4">
                                @foreach($qus as $q)
                                    @php
                                        $answer = \App\QAnswer::where(['qid' => $q->id, 'uid' => $uid])->first();
                                    @endphp

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <h3 class="h5 text-primary">{{ $q->question }}</h3>
                                            <div class="ps-3 mt-2">
                                                <p class="mb-0">{{ $answer->answer ?? 'No answer provided' }}</p>
                                            </div>
                                        </div>
                                        @if(!$loop->last)
                                            <hr class="my-3">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .hero-section {
        padding: 5rem 0;
    }

    .card {
        border-radius: 0.5rem;
        border: none;
    }
</style>
@endpush
