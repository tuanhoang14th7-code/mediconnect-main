@extends('layout')

@section('main-content')
    <section class="breadcrumb-section position-relative fix">
        <div class="container">
            <div
                class="bread-content px-3 d-flex flex-wrap gap-3 align-items-center justify-content-md-between justify-content-center">
                <h2 class="black">Doctors</h2>
                <ul class="d-flex align-items-center gap-3">
                    @if (auth()->user() && auth()->user()->user_type == 'Patient')
                        <li><a href="{{ url('Patient/PatientDashboard') }}">Home</a></li>
                    @else
                        <li><a href="{{ url('index') }}">Home</a></li>
                    @endif
                    <li>/</li>
                    <li>Doctor</li>
                </ul>
            </div>
        </div>
        <!-- Bread Ele -->
        <img src="{{ asset('assets/img/about/breadcrumnd-shap.png') }}" alt="img" class="bread-ele">
    </section>

    <!-- Feature Section Start -->
    <section class="feature-section fix pt-3">
        <div class="container">
            <div class="featue-wrapper feaure-wrapper2 position-relative">
                <div class="feature-inner" style="gap: 0px">
                    @foreach ($doctors as $d)
                        <div class="ins d-flex flex-column" style="width: 80%">
                            <div class="line my-3"></div>
                            <a href="{{ url('doctorDetails', $d->user->id) }}" class="m-0 p-0">
                                <div class="feature-items">
                                    <div
                                        class="feature-left d-lg-flex d-grid flex-lg-nowrap flex-wrap justify-content-between align-items-center">
                                        <h4>{{ $d->user->name }}</h4>
                                        <ul class="feature-list d-flex flex-column gap-1">
                                            <li class="text-nowrap">{{ $d->expertise }}</li>
                                            <li class="text-nowrap">{{ $d->experience }} Years Of Experience</li>
                                        </ul>
                                        <p class="pra fs-seven"></p>
                                        {{-- 
                                            Medical care encompasses a range of services aimed at promoting health,
                                            preventing
                                            disease --}}
                                    </div>
                                    <div class="cmn-arrows d-center">
                                        <img src="{{ asset('assets/img/icon/arrow-right-black.png') }}" alt="icon">
                                    </div>
                                    {{-- <!-- Extra Hover -->
                                <img src="{{ asset('assets/img/choose/feature5.jpg') }}" alt="img"
                                    class="extra-feature"> --}}
                                </div>
                            </a>
                        </div>
                    @endforeach
                    <div class="line my-3"></div>

                </div>
                <div class="mb-5">
                    {{ $doctors->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
