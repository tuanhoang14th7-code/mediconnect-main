@extends('layout')

@section('main-content')
    @if (auth()->check() && auth()->user()->user_type === 'Patient')
        <div class="container mt-4">
            <div class="alert alert-success">
                Welcome, {{ auth()->user()->name }}!
            </div>
        </div>
    @endif
    <!-- Helth Compassionate -->
    <section class="helth-compassionate cmn-bg my-5">
        <div class="container">
            <div class="row g-4 justify-content-between align-items-center mb-5">
                <div class="col-xxl-7 col-xl-8 col-lg-8">
                    <div class="section-title">
                        <h3 class="wow fadeInUp black mb-2" data-wow-delay=".3s">Consult top doctors online for any health
                            concern</h3>
                        <p class="pra mb-2">Private online consultations with verified doctors in all specialists</p>
                    </div>
                </div>
                <div class="col-xxl-2 col-xl-2 col-lg-2">
                    <span class="cmn-tag p1-bg heading-font mb-3">All Specialities</span>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-7 h-100">
                    <div class="compassionate-left-content">
                        <div class="box">
                            <h4 class="black mb-md-3 mb-2">Compassionate Care There Health First</h4>
                            <p class="black mb-40 pb-2">Health care is a vital aspect of maintaining overall well-being
                                encompassing a range of services from preventive</p>
                            <button
                                onclick="return confirm('Please register or login for Appointment Booking!') ? window.location.href = '/login' : 0"
                                {{-- onclick="@if (!auth()->user()) userExist() @else window.location.href=href='/FilterDoctors' @endif" --}}
                                class="common-btn box-style first-box d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold black overflow-hidden rounded100">
                                Book An Appointment
                                <img src="{{ asset('assets/img/icon/arrow-right-black.png') }}" alt="icon">
                            </button>
                        </div>
                        <div class="thumb d-md-block d-none">
                            <img src="{{ asset('assets/img/global/compassionate.png') }}" alt="img">
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 h-100">
                    <div class="compassionate-right">
                        <div class="compassionate-item">
                            <div class="icon d-center rounded-circle"><img src="{{ asset('assets/img/icon/compasi1.png') }}"
                                    alt="icon"></div>
                            <div class="cont">
                                <h4 class="white mb-2">Your health our priority</h4>
                                <p class="white">
                                    Medical care encompasses a range of services aimed at the a promoting health,
                                    preventing
                                </p>
                            </div>
                        </div>
                        <div class="compassionate-item">
                            <div class="icon d-center rounded-circle"><img src="{{ asset('assets/img/icon/compasi2.png') }}"
                                    alt="icon"></div>
                            <div class="cont">
                                <h4 class="white mb-2">wellness Healing with heart</h4>
                                <p class="white">
                                    Medical care encompasses a range of services aimed at the a promoting health,
                                    preventing
                                </p>
                            </div>
                        </div>
                        <div class="compassionate-item">
                            <div class="icon d-center rounded-circle"><img src="{{ asset('assets/img/icon/compasi3.png') }}"
                                    alt="icon"></div>
                            <div class="cont">
                                <h4 class="white mb-2">Care Point Health Institute</h4>
                                <p class="white">
                                    Medical care encompasses a range of services aimed at the a promoting health,
                                    preventing
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <script>
        function userExist() {
            if (confirm('Please register or login for Appointment Booking!')) {
                window.location.href = '/login'
            } else {
                return 0;
            }
        }
    </script> --}}

    <!-- Servie Section Start -->
    <section class="services-section main-style cmn-bg fix p-4">
        <div class="container">
            <div class="row g-4 justify-content-between align-items-center">
                <div class="col-xxl-7 col-xl-8 col-lg-8">
                    <div class="section-title">
                        <h3 class="wow fadeInUp black mb-2" data-wow-delay=".3s">Choose Your specialists</h3>
                        {{-- <p class="pra mb-2">Private online consultations with verified doctors in all specialists</p> --}}
                    </div>
                </div>
            </div>

            {{-- category's --}}
            <div class="row">
                <div class="col-lg-4 col-md-6 mt-0 p-3">
                    <a href="{{ url('doctors') }}" class="common-btn p-0 m-0">
                        <div class="service-item overflow-hidden white-bg rounded-4 position-relative">
                            <div class="icon-area d-flex align-items-center gap-2">
                                <div class="icon d-center">
                                    <img src="{{ asset('assets/img/icon/ser1.png') }}" alt="icon">
                                </div>
                                <h5 class="black">General Consultation</h5>
                            </div>
                            <p class="pra">Consult a doctor for common health concerns like fever, cold, infections, body
                                pain, or general medical advice.</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-0 p-3">
                    <a href="{{ url('doctors') }}" class="common-btn p-0 m-0">
                        <div class="service-item overflow-hidden white-bg rounded-4 position-relative">
                            <div class="icon-area d-flex align-items-center gap-2">
                                <div class="icon d-center">
                                    <img src="{{ asset('assets/img/icon/ser2.png') }}" alt="icon">
                                </div>
                                <h5 class="black">Annual Health Check-up</h5>
                            </div>
                            <p class="pra">Comprehensive physical examination and routine health screening to monitor
                                overall wellness and prevent future illness.</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-0 p-3">
                    <a href="{{ url('doctors') }}" class="common-btn p-0 m-0">
                        <div class="service-item overflow-hidden white-bg rounded-4 position-relative">
                            <div class="icon-area d-flex align-items-center gap-2">
                                <div class="icon d-center">
                                    <img src="{{ asset('assets/img/icon/ser3.png') }}" alt="icon">
                                </div>
                                <h5 class="black">Sick Visit Consultation</h5>
                            </div>
                            <p class="pra">Get timely medical attention for sudden health issues like fever, cough,
                                infections, stomach problems, and general discomfort.</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-0 p-3">
                    <a href="{{ url('doctors') }}" class="common-btn p-0 m-0">
                        <div class="service-item overflow-hidden white-bg rounded-4 position-relative">
                            <div class="icon-area d-flex align-items-center gap-2">
                                <div class="icon d-center">
                                    <img src="{{ asset('assets/img/icon/ser4.png') }}" alt="icon">
                                </div>
                                <h5 class="black">Specialist Consultation</h4>
                            </div>
                            <p class="pra">Book appointments with expert specialists like cardiologists, dermatologists,
                                neurologists, and more.</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-0 p-3">
                    <a href="{{ url('doctors') }}" class="common-btn p-0 m-0">
                        <div class="service-item overflow-hidden white-bg rounded-4 position-relative">
                            <div class="icon-area d-flex align-items-center gap-2">
                                <div class="icon d-center">
                                    <img src="{{ asset('assets/img/icon/ser5.png') }}" alt="icon">
                                </div>
                                <h5 class="black">Pediatric Care</h4>
                            </div>
                            <p class="pra">Dedicated healthcare services for infants, children, and adolescents
                                including
                                routine and emergency visits.</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-0 p-3">
                    <a href="{{ url('doctors') }}" class="common-btn p-0 m-0">
                        <div class="service-item overflow-hidden white-bg rounded-4 position-relative">
                            <div class="icon-area d-flex align-items-center gap-2">
                                <div class="icon d-center">
                                    <img src="{{ asset('assets/img/icon/ser6.png') }}" alt="icon">
                                </div>
                                <h5 class="black">Women’s Health Services</h4>
                            </div>
                            <p class="pra">Consult OB-GYN specialists for pregnancy care, menstrual issues, hormonal
                                concerns, and general women’s wellness.</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-0 p-3">
                    <a href="{{ url('doctors') }}" class="common-btn p-0 m-0">
                        <div class="service-item overflow-hidden white-bg rounded-4 position-relative">
                            <div class="icon-area d-flex align-items-center gap-2">
                                <div class="icon d-center">
                                    <img src="{{ asset('assets/img/icon/ser3.png') }}" alt="icon">
                                </div>
                                <h5 class="black">Follow-up Appointment</h5>
                            </div>
                            <p class="pra">Review your recovery progress, test reports, or ongoing treatment plan with
                                your doctor.</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-0 p-3">
                    <a href="{{ url('doctors') }}" class="common-btn p-0 m-0">
                        <div class="service-item overflow-hidden white-bg rounded-4 position-relative">
                            <div class="icon-area d-flex align-items-center gap-2">
                                <div class="icon d-center">
                                    <img src="{{ asset('assets/img/icon/ser6.png') }}" alt="icon">
                                </div>
                                <h4 class="black">Vaccination & Immunization</h5>
                            </div>
                            <p class="pra">Get recommended vaccines for children and adults to stay protected against
                                preventable diseases.</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 mt-0 p-3">
                    <a href="{{ url('doctors') }}" class="common-btn p-0 m-0">
                        <div class="service-item overflow-hidden white-bg rounded-4 position-relative">
                            <div class="icon-area d-flex align-items-center gap-2">
                                <div class="icon d-center">
                                    <img src="{{ asset('assets/img/icon/ser6.png') }}" alt="icon">
                                </div>
                                <h5 class="black">Diagnostic Tests & Lab Services</h5>
                            </div>
                            <p class="pra">Schedule blood tests, scans, and other diagnostic procedures with reliable
                                laboratory services.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Medical Contents Section -->
    <section class="services-section main-style cmn-bg fix p-4">
        <div class="container">

            <div class="section-title mb-4">
                <h3 class="black">
                    Medical Knowledge
                </h3>

                <p class="pra">
                    Latest health information from MediConnect
                </p>
            </div>

            <div class="row g-4">

                {{-- Diseases --}}
                @foreach ($diseases as $content)
                    <div class="col-lg-4 col-md-6">
                        <div class="service-item white-bg rounded-4 h-100">

                            <span class="cmn-tag p1-bg heading-font mb-3">
                                Disease
                            </span>

                            <h5 class="black mb-2">
                                {{ $content->title }}
                            </h5>

                            <p class="pra">
                                {{ $content->summary }}
                            </p>

                        </div>
                    </div>
                @endforeach


                {{-- Preventions --}}
                @foreach ($preventions as $content)
                    <div class="col-lg-4 col-md-6">
                        <div class="service-item white-bg rounded-4 h-100">

                            <span class="cmn-tag p1-bg heading-font mb-3">
                                Prevention
                            </span>

                            <h5 class="black mb-2">
                                {{ $content->title }}
                            </h5>

                            <p class="pra">
                                {{ $content->summary }}
                            </p>

                        </div>
                    </div>
                @endforeach


                {{-- Cures --}}
                @foreach ($cures as $content)
                    <div class="col-lg-4 col-md-6">
                        <div class="service-item white-bg rounded-4 h-100">

                            <span class="cmn-tag p1-bg heading-font mb-3">
                                Cure
                            </span>

                            <h5 class="black mb-2">
                                {{ $content->title }}
                            </h5>

                            <p class="pra">
                                {{ $content->summary }}
                            </p>

                        </div>
                    </div>
                @endforeach


                {{-- Medical News --}}
                @foreach ($medicalNews as $content)
                    <div class="col-lg-4 col-md-6">
                        <div class="service-item white-bg rounded-4 h-100">

                            <span class="cmn-tag p1-bg heading-font mb-3">
                                Medical News
                            </span>

                            <h5 class="black mb-2">
                                {{ $content->title }}
                            </h5>

                            <p class="pra">
                                {{ $content->summary }}
                            </p>

                        </div>
                    </div>
                @endforeach


                {{-- Medical Inventions --}}
                @foreach ($medicalInventions as $content)
                    <div class="col-lg-4 col-md-6">
                        <div class="service-item white-bg rounded-4 h-100">

                            <span class="cmn-tag p1-bg heading-font mb-3">
                                Medical Invention
                            </span>

                            <h5 class="black mb-2">
                                {{ $content->title }}
                            </h5>

                            <p class="pra">
                                {{ $content->summary }}
                            </p>

                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </section>

    <!-- Banner Section Start -->
    <section class="banner-section white-bg fix  mb-30">
        <div class="banner-adjust-thumb">
            <div class="container">
                <div class="hero-thumbs1 position-relative w-100 wow fadeInUp" data-wow-delay="0.5s">
                    <img src="{{ asset('assets/img/banner/hero1-thumb.jpg') }}" alt="img" class="rounded-4 w-100">
                    <!-- Circle -->
                    <div class="text-circle-inner d-center p1-bg">
                        <img src="{{ asset('assets/img/element/circle-copy.png') }}" alt="img" class="copy">
                        <!-- Ele -->
                        <img src="{{ asset('assets/img/element/circle-element.png') }}" alt="circle"
                            class="text-circle">
                    </div>
                    <!-- Ele -->
                    <img src="{{ asset('assets/img/element/dots-element.png') }}" alt="img"
                        class="hero-dot-element">
                </div>
            </div>
            <!-- Element -->
            <img src="{{ asset('assets/img/element/hero-shape-elemenet.png') }}" alt="img"
                class="hero-shape-element">
        </div>
        <!-- Element -->
        <img src="{{ asset('assets/img/element/feature-element.png') }}" alt="img" class="hero-element1">
    </section>

    <!-- Feature Section Start -->
    <section class="feature-section fix space-top">
        <div class="container">
            <div class="featue-wrapper position-relative white-bg">
                <div class="section-title mb-60">
                    <span class="cmn-tag p1-bg heading-font">Our Feature</span>
                    <h2 class="wow fadeInUp black visible-slowly-right" data-wow-delay=".3s">
                        Compassionate Care <br> Health
                        <span class="position-relative z-1">
                            Exceptional
                            <img src="{{ asset('assets/img/element/title-badge1.png') }}" alt="img"
                                class="title-badge1 d-md-block d-none w-100">
                        </span>
                        Results
                    </h2>
                </div>
                <div class="feature-inner">
                    <div class="feature-items">
                        <div
                            class="feature-left d-lg-flex d-grid gap-3 flex-lg-nowrap flex-wrap justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-xxl-4 gap-xl-3 gap-2">
                                <div class="icons d-center rounded-circle p1-bg">
                                    <img src="{{ asset('assets/img/icon/f-icon1.png') }}" alt="icon">
                                </div>
                                <h4><a href="doctor.html" class="black fw_600">Quality Care <br> Exceptional
                                        Service</a>
                                </h4>
                            </div>
                            <ul class="feature-list d-flex flex-column gap-1">
                                <li>
                                    Your Health, Our Priority
                                </li>
                                <li>
                                    Harmony Health
                                </li>
                            </ul>
                        </div>
                        <a href="doctor.html"
                            class="common-btn cmn-border text-nowrap d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold black overflow-hidden rounded100 wow fadeInRight"
                            data-wow-delay="0.8s">
                            <img src="{{ asset('assets/img/icon/arrow-right-black.png') }}" alt="icon">
                        </a>
                        <!-- Extra Hover -->
                        {{-- <img src="{{ asset('assets/img/choose/feature1.jpg') }}" alt="img" class="extra-feature"> --}}
                    </div>
                    <div class="line"></div>
                    <div class="feature-items">
                        <div
                            class="feature-left d-lg-flex d-grid gap-3 flex-lg-nowrap flex-wrap justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-xxl-4 gap-xl-3 gap-2">
                                <div class="icons d-center rounded-circle p1-bg">
                                    <img src="{{ asset('assets/img/icon/f-icon2.png') }}" alt="icon">
                                </div>
                                <h4><a href="doctor.html" class="black fw_600">Healing Lives One <br> Patient at a
                                        Time</a></h4>
                            </div>
                            <ul class="feature-list d-flex flex-column gap-1">
                                <li>
                                    Your Health, Our Priority
                                </li>
                                <li>
                                    Harmony Health
                                </li>
                            </ul>
                        </div>
                        <a href="doctor.html"
                            class="common-btn cmn-border text-nowrap d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold black overflow-hidden rounded100 wow fadeInRight"
                            data-wow-delay="0.8s">
                            <img src="{{ asset('assets/img/icon/arrow-right-black.png') }}" alt="icon">
                        </a>
                        <!-- Extra Hover -->
                        {{-- <img src="{{ asset('assets/img/choose/feature2.jpg') }}" alt="img" class="extra-feature"> --}}
                    </div>
                    <div class="line"></div>
                    <div class="feature-items">
                        <div
                            class="feature-left d-lg-flex d-grid gap-3 flex-lg-nowrap flex-wrap justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-xxl-4 gap-xl-3 gap-2">
                                <div class="icons d-center rounded-circle p1-bg">
                                    <img src="{{ asset('assets/img/icon/f-icon3.png') }}" alt="icon">
                                </div>
                                <h4><a href="doctor.html" class="black fw_600">Caring for You Caring <br> for
                                        Tomorrow</a></h4>
                            </div>
                            <ul class="feature-list d-flex flex-column gap-1">
                                <li>
                                    Your Health, Our Priority
                                </li>
                                <li>
                                    Harmony Health
                                </li>
                            </ul>
                        </div>
                        <a href="doctor.html"
                            class="common-btn cmn-border text-nowrap d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold black overflow-hidden rounded100 wow fadeInRight"
                            data-wow-delay="0.8s">
                            <img src="{{ asset('assets/img/icon/arrow-right-black.png') }}" alt="icon">
                        </a>
                        <!-- Extra Hover -->
                        {{-- <img src="{{ asset('assets/img/choose/feature3.jpg') }}" alt="img" class="extra-feature"> --}}
                    </div>
                    <div class="line"></div>
                </div>
                <!-- Element-->
                <a href="doctor.html" class="feature-element">
                    <img src="{{ asset('assets/img/element/feature-element.png') }}" alt="img" class="rounded-4">
                </a>
            </div>
        </div>
    </section>

    <!-- Choose Section Start -->
    <section class="choose-section mb-30">
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
                        <a href="doctor.html" class="w-100 rounded-4 overflow-hidden">
                            <img src="{{ asset('assets/img/choose/choose1.jpg') }}" alt="img"
                                class="rounded-4 w-100">
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="chosse-middle">
                        <a href="doctor.html" class="w-100 rounded-4 overflow-hidden mb-xxl-4 mb-3 d-block">
                            <img src="{{ asset('assets/img/choose/choose2.jpg') }}" alt="img"
                                class="rounded-4 w-100">
                        </a>
                        <h4 class="mb-xxl-3 mb-2">
                            <a href="#" class="black fw_700">
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
                        <a href="doctor.html" class="video-choose d-center rounded-circle p1-bg video-popup">
                            <i class="fa-solid fa-play black"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Counter Care Section Start -->
    <section class="care-counter fix mb-30">
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
