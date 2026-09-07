@extends('layout')

@section('main-content')
    <!-- Banner Section Start -->
    <section class="breadcrumb-section position-relative fix">
        <div class="container">
            <div
                class="bread-content px-3 d-flex flex-wrap gap-3 align-items-center justify-content-md-between justify-content-center">
                <h2 class="black">About Us</h2>
                <ul class="d-flex align-items-center gap-3">
                    @if (auth()->user() && auth()->user()->user_type == 'Patient')
                        <li><a href="{{ url('Patient/PatientDashboard') }}">Home</a></li>
                    @else
                        <li><a href="{{ url('index') }}">Home</a></li>
                    @endif
                    <li>/</li>
                    <li>About</li>
                </ul>
            </div>
        </div>
        <!-- Bread Ele -->
        <img src="{{ asset('assets/img/about/breadcrumnd-shap.png') }}" alt="img" class="bread-ele">
    </section>
    <!-- Banner Section Start -->



    <!-- AboutUs Section Start -->
    <section class="about-section fix space-top">
        <div class="container">
            <div class="row g-4 justify-content-between">
                <div class="col-lg-6">
                    <div class="about-content">
                        <div class="section-title mb-40">
                            <span class="cmn-tag p1-bg heading-font">About Us</span>
                            <h2 class="wow fadeInUp black visible-slowly-right mb-xxl-3 mb-3" data-wow-delay=".3s">
                                Compassionate Care <br> Always There
                                <span class="position-relative z-1">
                                    Health
                                    <img src="{{ asset('assets/img/element/title-badge1.png') }}" alt="img"
                                        class="title-badge1 d-md-block d-none w-100">
                                </span>
                                First
                            </h2>
                            <p class="pra">Health care is a vital aspect of maintaining overall well-being,
                                encompassing
                                a range of services from preventive care
                                to treatment of cuses on promoting</p>
                        </div>
                        <div class="about-steps d-flex flex-column gap-xxl-5 gap-xl-3 gap-3">
                            <div class="about-step-item d-flex gap-sm-3 gap-1 flex-sm-nowrap flex-wrap">
                                <h4 class="fw_700 black">
                                    01
                                </h4>
                                <div class="cont">
                                    <h4 class="black fw_600 mb-2">
                                        Enhancing Lives Through Care
                                    </h4>
                                    <p class="pra fs-seven">
                                        Health care is a vital aspect of maintaining overall well-being, encompassing a
                                        range of services from preventive care
                                        to treatment of cuses on promoting
                                    </p>
                                </div>
                            </div>
                            <div class="about-step-item d-flex gap-sm-3 gap-1 flex-sm-nowrap flex-wrap">
                                <h4 class="fw_700 black">
                                    02
                                </h4>
                                <div class="cont">
                                    <h4 class="black fw_600 mb-2">
                                        Tomorrow's Health, Today's Care
                                    </h4>
                                    <p class="pra fs-seven">
                                        Health care is a vital aspect of maintaining overall well-being, encompassing a
                                        range of services from preventive care
                                        to treatment of cuses on promoting
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="about-thumb-inner">
                        <div class="thumb">
                            <img src="{{ asset('assets/img/about/about1.png') }}" alt="img" class="about-img">
                        </div>
                        <img src="{{ asset('assets/img/element/about1-bg.png') }}" alt="img" class="about1-bg">
                        <!-- Element -->
                        <img src="{{ asset('assets/img/element/about1-element1.png') }}" alt="img"
                            class="about1-element1">
                        <img src="{{ asset('assets/img/element/about1-element2.png') }}" alt="img"
                            class="about1-element2">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Choose Section Start -->
    <section class="choose-section my-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="choose-left">
                        <div class="section-title mb-60">
                            <span class="cmn-tag p1-bg heading-font">Why Chose Us</span>
                            <h2 class="wow fadeInUp black visible-slowly-right" data-wow-delay=".3s">
                                Empower Health <br>
                                Lives
                                <span class="position-relative z-1">
                                    Expert
                                    <img src="{{ asset('assets/img/element/title-badge1.png') }}" alt="img"
                                        class="title-badge1 d-md-block d-none w-100">
                                </span>
                                Care
                            </h2>
                        </div>
                        <a href="doctor-details.html" class="w-100 rounded-4 overflow-hidden">
                            <img src="{{ asset('assets/img/choose/choose1.jpg') }}" alt="img" class="rounded-4 w-100">
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="chosse-middle">
                        <a href="doctor-details.html" class="w-100 rounded-4 overflow-hidden mb-xxl-4 mb-3 d-block">
                            <img src="{{ asset('assets/img/choose/choose2.jpg') }}" alt="img" class="rounded-4 w-100">
                        </a>
                        <h4 class="mb-xxl-3 mb-2">
                            <a href="doctor-details.html" class="black fw_700">
                                The Enhanc Lives care Through Care
                            </a>
                        </h4>
                        <p class="pra fs-seven">
                            Health care is a vital aspect of maintaining overall well-being, encompassing a range of
                            services from preventive
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.8s">
                    <div class="choose-right position-relative d-center overflow-hidden rounded-4 w-100">
                        <img src="{{ asset('assets/img/choose/choose3.jpg') }}" alt="img" class="rounded-4 w-100">
                        <a href="doctor-details.html" class="video-choose d-center rounded-circle p1-bg video-popup">
                            <i class="fa-solid fa-play black"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Counter Care Section Start -->
    <section class="care-counter fix space-bottom">
        <div class="container">
            <div class="care-counter-wrap">
                <div class="row g-4 justify-content-center">
                    <div class="col-lg-5">
                        <div class="care-counter-text">
                            <h3 class="black fw_700 visible-slowly-right">Tomorrow's Health <br> Today's Care</h3>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="care-counter">
                            <div class="counter-items box-style first-box wow fadeIn" data-wow-delay="0.4s">
                                <div class="content">
                                    <h2><span class="count">600</span>+</h2>
                                    <p class="black">Complte Project</p>
                                </div>
                            </div>
                            <div class="counter-items box-style first-box wow fadeIn" data-wow-delay="0.5s">
                                <div class="content">
                                    <h2><span class="count">200</span>+</h2>
                                    <p class="black">Team Member</p>
                                </div>
                            </div>
                            <div class="counter-items box-style first-box wow fadeIn" data-wow-delay="0.6s">
                                <div class="content">
                                    <h2><span class="count">500</span>k+</h2>
                                    <p class="black">Clients Reviews</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
