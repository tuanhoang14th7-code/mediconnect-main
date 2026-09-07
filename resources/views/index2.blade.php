<!DOCTYPE html>
<html lang="en">
<!--<< Header Area >>-->


<!-- Mirrored from etorisoft.com/html/medizen/{{ url('index') }} by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 11 Sep 2025 03:58:23 GMT -->

<!-- Mirrored from thememxpro.com/demo/medizen/index2.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 17 Feb 2026 14:10:21 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="authorName">
    <meta name="description" content="MediZen - Health & Medical HTML Template">
    <!-- ======== Page title ============ -->
    <title>Home Two || Medizen || Medizen PHP Template</title>
    <!--<< Favcion >>-->
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/favs.png') }}">
    <!--<< Bootstrap min.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!--<< All Min Css >>-->
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <!--<< Animate.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <!--<< Magnific Popup.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <!--<< MeanMenu.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.css') }}">
    <!--<< Swiper Bundle.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <!--<< Nice Select.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <!--<< Main.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body class="body-bg2">
    <!-- Preloader Start -->
    <div id="preloader" class="preloader">
        <div class="animation-preloader">
            <div class="spinner">
            </div>
            <div class="txt-loading">
                <span data-text-preloader="M" class="letters-loading">
                    M
                </span>
                <span data-text-preloader="D" class="letters-loading">
                    D
                </span>
                <span data-text-preloader="I" class="letters-loading">
                    I
                </span>
                <span data-text-preloader="Z" class="letters-loading">
                    Z
                </span>
                <span data-text-preloader="E" class="letters-loading">
                    E
                </span>
                <span data-text-preloader="N" class="letters-loading">
                    N
                </span>
            </div>
            <p class="text-center">Loading</p>
        </div>
        <div class="loader">
            <div class="row">
                <div class="col-3 loader-section section-left">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-left">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-right">
                    <div class="bg"></div>
                </div>
                <div class="col-3 loader-section section-right">
                    <div class="bg"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Cursor Pointer -->
    <div class="mouse-follower">
        <span class="cursor-outline"></span>
        <span class="cursor-dot"></span>
    </div>
    <!-- End Cursor Pointer -->
    <!-- Header Section Start -->
    <header id="header-sticky" class="header-1 bg-transparent sticky-header1">
        <div class="container">
            <div class="mega-menu-wrapper">
                <div class="header-main style-2">
                    <div class="header-left">
                        <div class="logo">
                            <a href="{{ url('index') }}" class="header-logo">
                                <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo-img">
                            </a>
                        </div>
                    </div>
                    <div class="header-right d-flex justify-content-end align-items-center">
                        <div class="mean__menu-wrapper">
                            <div class="main-menu">
                                <nav id="mobile-menu">
                                    <ul>
                                        <li class="has-dropdown active menu-thumb">
                                            <a href="{{ url('index') }}">
                                                Home
                                                <i class="fas fa-angle-down"></i>
                                            </a>
                                            <ul class="submenu has-homemenu">
                                                <li>
                                                    <div class="homemenu-items">
                                                        <div class="homemenu">
                                                            <a href="{{ url('index') }}" class="homemenu-thumb">
                                                                <img src="{{ asset('assets/img/header/home-1.jpg') }}"
                                                                    alt="img">
                                                                <span class="demo-button">
                                                                    <span class="theme-btn p1-bg box-style first-box">
                                                                        <span class="black">Home 01</span>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="homemenu">
                                                            <a href="{{ url('index2') }}" class="homemenu-thumb mb-15">
                                                                <img src="{{ asset('assets/img/header/home-2.jpg') }}"
                                                                    alt="img">
                                                                <span class="demo-button">
                                                                    <span class="theme-btn p1-bg box-style first-box">
                                                                        <span class="black">Home 02</span>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="homemenu">
                                                            <a href="{{ url('index3') }}"
                                                                class="homemenu-thumb mb-15">
                                                                <img src="{{ asset('assets/img/header/home-3.jpg') }}"
                                                                    alt="img">
                                                                <span class="demo-button">
                                                                    <span class="theme-btn p1-bg box-style first-box">
                                                                        <span class="black">Home 03</span>
                                                                    </span>
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="has-dropdown">
                                            <a href="#!">
                                                Pages
                                                <i class="fas fa-angle-down"></i>
                                            </a>
                                            <ul class="submenu">
                                                <li><a href="{{ url('about') }}">About Us</a></li>
                                                <li><a href="doctor.html">Doctor</a></li>
                                                <li><a href="doctor-details.html">Doctor Details</a></li>
                                            </ul>
                                        </li>
                                        <li class="has-dropdown"><a href="{{ url('login') }}">Login</a></li>
                                        <li class="has-dropdown"><a href="{{ url('register') }}">Register</a></li>
                                        <li><a href="{{ url('contact') }}">Contact</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <a href="#0" class="search-trigger search-icon d-none d-xl-block"><i
                                class="fal fa-search"></i>
                        </a>
                        <div class="header__hamburger d-xl-none my-auto">
                            <div class="sidebar__toggle">
                                <img src="{{ asset('assets/img/icon/menu.png') }}" alt="icon">
                            </div>
                        </div>
                    </div>
                    <div class="header-btn d-xl-block d-none">
                        <a href="{{ url('contact') }}"
                            class="common-btn box-style first-box d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold black overflow-hidden p1-bg rounded100">
                            Contact us
                            <img src="{{ asset('assets/img/icon/arrow-right-black.png') }}" alt="icon">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Banner Section Start -->
    <section class="banner-section2 white-bg fix">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-xxl-5 col-xl-5 col-lg-5">
                    <div class="hero-content-version2">
                        <span class="cmn-tag p1-bg heading-font mb-xxl-1 mb-3">Madical Care</span>
                        <h1 class="black wow fadeInUp mb-40" data-wow-delay="0.6s">
                            Quality health <br>
                            <span class="position-relative z-1 w-100">
                                Care
                                <img src="{{ asset('assets/img/element/title-badge1.png') }}" alt="img"
                                    class="title-badge1 d-md-block d-none w-100">
                            </span>
                            <span class="fw-normal">Health Excellence</span>
                        </h1>
                        <div class="hero2-counter-wrap">
                            <div class="hero-count-item d-xl-flex align-items-center gap-2">
                                <h2 class="black">120+</h2>
                                <p class="black">
                                    Winning <br> award
                                </p>
                            </div>
                            <div class="hero-count-item d-xl-flex align-items-center gap-2">
                                <h2 class="black">500+</h2>
                                <p class="black">
                                    Clients <br> Reviews
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-3 col-lg-3 d-lg-block d-none">
                    <div class="hero2-thumb">
                        <img src="{{ asset('assets/img/banner/hero2-thumb.png') }}" alt="img">
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-4">
                    <form action="#" class="hero-appoinment">
                        <h4 class="black mb-xxl-3 mb-2">Appointment</h4>
                        <p class="pra mb-xxl-3 mb-2">Health care is a vital aspect of overall well-being</p>
                        <input type="text" placeholder="Your Name" class="mb-3">
                        <input type="text" placeholder="Your Phone" class="mb-3">
                        <input type="email" placeholder="Your Email" class="mb-3">
                        <select name="selected" class="mb-3">
                            <option value="1">Select One</option>
                            <option value="1">3:25 Am</option>
                            <option value="1">3:25 Am</option>
                            <option value="1">3:25 Pm</option>
                        </select>
                        <a href="doctor-details.html"
                            class="common-btn box-style p2-bg w-100 text-nowrap d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs-seven fw-medium white overflow-hidden rounded100 wow fadeInRight"
                            data-wow-delay="0.8s">
                            Book Appointment
                            <img src="{{ asset('assets/img/icon/arrow-right-white.png') }}" alt="icon">
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section Start -->
    <section class="about-section2 space-bottom cmn-bg fix">
        <div class="container">
            <div class="row g-4 align-items-center justify-content-between flex-row-reverse">
                <div class="col-lg-6">
                    <div class="about-content2">
                        <div class="section-title mb-4">
                            <span class="cmn-tag p1-bg heading-font">About Us</span>
                            <h2 class="wow fadeInUp black visible-slowly-right mb-xxl-4 mb-3" data-wow-delay=".3s">
                                Compassionate Care <br> Always
                                <span class="position-relative z-1">
                                    There
                                    <img src="{{ asset('assets/img/element/title-badge1.png') }}" alt="img"
                                        class="title-badge1 d-md-block d-none w-100">
                                </span>
                                Health First
                            </h2>
                            <p class="pra mb-sm-4 mb-3 position-relative syle-pra d-flex align-items-center gap-3">
                                <img src="{{ asset('assets/img/element/pra-element.png') }}" alt="element"
                                    class="d-sm-block d-none">
                                Over 30 year’s experience providing top quality country'sacross world. The energy that
                                is
                                sourceable , free and healthy.
                            </p>
                            <p class="pra">
                                Health care is a vital aspect of maintaining overall well-being, encompassing a range of
                                services from preventive care
                                to treatment of cuses on promoting Health care is a vital aspect of maintaining overall
                                well-being, encompassing a range
                                of services
                            </p>
                        </div>
                        <div class="about-point mb-40">
                            <div class="about-point-item d-flex align-items-center gap-sm-3 gap-2">
                                <img src="{{ asset('assets/img/icon/about-icon1.png') }}" alt="icon">
                                <h4 class="black">Vitality Clinic <br> Wellness</h4>
                            </div>
                            <div class="about-point-item d-flex align-items-center gap-sm-3 gap-2">
                                <img src="{{ asset('assets/img/icon/about-icon2.png') }}" alt="icon">
                                <h4 class="black">CarePoint <br> Health</h4>
                            </div>
                        </div>
                        <a href="{{ url('about') }}"
                            class="common-btn box-style first-box d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold black overflow-hidden white-bg rounded100">
                            Read More
                            <img src="{{ asset('assets/img/icon/arrow-right-black.png') }}" alt="icon">
                        </a>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6">
                    <div class="about-thumb2 reveal-left rounded-4">
                        <img src="{{ asset('assets/img/about/about2.jpg') }}" alt="img"
                            class="w-100 rounded-4">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Feature Section Start -->
    <section class="feature-section fix section-padding">
        <div class="container">
            <div class="section-title text-center mb-60">
                <span class="cmn-tag p1-bg heading-font">Our Team Member</span>
                <h2 class="wow fadeInUp black visible-slowly-right" data-wow-delay=".3s">
                    Compassionate Care <br> Health Exceptional
                    <span class="position-relative z-1">
                        Results
                        <img src="{{ asset('assets/img/element/title-badge1.png') }}" alt="img"
                            class="title-badge1 d-md-block d-none w-100">
                    </span>
                </h2>
            </div>
            <div class="featue-wrapper feaure-wrapper2 position-relative white-bg">
                <div class="feature-inner">
                    <div class="ins d-flex flex-column gap-xxl-4 gap-3">
                        <div class="line"></div>
                        <div class="feature-items">
                            <div
                                class="feature-left d-lg-flex d-grid gap-3 flex-lg-nowrap flex-wrap justify-content-between align-items-center">
                                <h4><a href="doctor-details.html" class="black fw_600 text-nowrap">Dr.Alvin Eclair</a>
                                </h4>
                                <ul class="feature-list d-flex flex-column gap-1">
                                    <li class="text-nowrap">
                                        Neurology Expert
                                    </li>
                                </ul>
                                <p class="pra fs-seven">
                                    Medical care encompasses a range of services aimed at promoting health, preventing
                                    disease
                                </p>
                            </div>
                            <a href="doctor-details.html" class="cmn-arrows d-center">
                                <img src="{{ asset('assets/img/icon/arrow-right-black.png') }}" alt="icon">
                            </a>
                            <!-- Extra Hover -->
                            <img src="{{ asset('assets/img/choose/feature4.jpg') }}" alt="img"
                                class="extra-feature">
                        </div>
                        <div class="line"></div>
                    </div>
                    <div class="ins d-flex flex-column gap-xxl-4 gap-3">
                        <div class="line"></div>
                        <div class="feature-items">
                            <div
                                class="feature-left d-lg-flex d-grid gap-3 flex-lg-nowrap flex-wrap justify-content-between align-items-center">
                                <h4><a href="doctor-details.html" class="black fw_600 text-nowrap">Dr.Alan
                                        Jellybean</a>
                                </h4>
                                <ul class="feature-list d-flex flex-column gap-1">
                                    <li class="text-nowrap">
                                        Dental Care
                                    </li>
                                </ul>
                                <p class="pra fs-seven">
                                    Medical care encompasses a range of services aimed at promoting health, preventing
                                    disease
                                </p>
                            </div>
                            <a href="doctor-details.html" class="cmn-arrows d-center">
                                <img src="{{ asset('assets/img/icon/arrow-right-black.png') }}" alt="icon">
                            </a>
                            <!-- Extra Hover -->
                            <img src="{{ asset('assets/img/choose/feature1.jpg') }}" alt="img"
                                class="extra-feature">
                        </div>
                        <div class="line"></div>
                    </div>
                    <div class="ins d-flex flex-column gap-xxl-4 gap-3">
                        <div class="line"></div>
                        <div class="feature-items">
                            <div
                                class="feature-left d-lg-flex d-grid gap-3 flex-lg-nowrap flex-wrap justify-content-between align-items-center">
                                <h4><a href="doctor-details.html" class="black fw_600 text-nowrap">Dr.Dean R.
                                        Chassay</a></h4>
                                <ul class="feature-list d-flex flex-column gap-1">
                                    <li class="text-nowrap">
                                        Eye Expert
                                    </li>
                                </ul>
                                <p class="pra fs-seven">
                                    Medical care encompasses a range of services aimed at promoting health, preventing
                                    disease
                                </p>
                            </div>
                            <a href="doctor-details.html" class="cmn-arrows d-center">
                                <img src="{{ asset('assets/img/icon/arrow-right-black.png') }}" alt="icon">
                            </a>
                            <!-- Extra Hover -->
                            <img src="{{ asset('assets/img/choose/feature2.jpg') }}" alt="img"
                                class="extra-feature">
                        </div>
                        <div class="line"></div>
                    </div>
                    <div class="ins d-flex flex-column gap-xxl-4 gap-3">
                        <div class="line"></div>
                        <div class="feature-items">
                            <div
                                class="feature-left d-lg-flex d-grid gap-3 flex-lg-nowrap flex-wrap justify-content-between align-items-center">
                                <h4><a href="doctor-details.html" class="black fw_600 text-nowrap">Dr.Alan
                                        Jellybean</a>
                                </h4>
                                <ul class="feature-list d-flex flex-column gap-1">
                                    <li class="text-nowrap">
                                        Heart Spacialist
                                    </li>
                                </ul>
                                <p class="pra fs-seven">
                                    Medical care encompasses a range of services aimed at promoting health, preventing
                                    disease
                                </p>
                            </div>
                            <a href="doctor-details.html" class="cmn-arrows d-center">
                                <img src="{{ asset('assets/img/icon/arrow-right-black.png') }}" alt="icon">
                            </a>
                            <!-- Extra Hover -->
                            <img src="{{ asset('assets/img/choose/feature3.jpg') }}" alt="img"
                                class="extra-feature">
                        </div>
                        <div class="line"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Helth Compassionate -->
    <section class="helth-compassionate cmn-bg section-padding">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-7 h-100">
                    <div class="compassionate-left-content">
                        <div class="box">
                            <h4 class="black mb-md-3 mb-2">Compassionate Care There Health First</h4>
                            <p class="black mb-40 pb-2">Health care is a vital aspect of maintaining overall well-being
                                encompassing a range of services from preventive</p>
                            <a href="doctor-details.html"
                                class="common-btn box-style first-box d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold black overflow-hidden rounded100">
                                Book An Appointment
                                <img src="{{ asset('assets/img/icon/arrow-right-black.png') }}" alt="icon">
                            </a>
                        </div>
                        <div class="thumb d-md-block d-none">
                            <img src="{{ asset('assets/img/global/compassionate.png') }}" alt="img">
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 h-100">
                    <div class="compassionate-right">
                        <div class="compassionate-item">
                            <div class="icon d-center rounded-circle"><img
                                    src="{{ asset('assets/img/icon/compasi1.png') }}" alt="icon"></div>
                            <div class="cont">
                                <h4 class="white mb-2">Your health our priority</h4>
                                <p class="white">
                                    Medical care encompasses a range of services aimed at the a promoting health,
                                    preventing
                                </p>
                            </div>
                        </div>
                        <div class="compassionate-item">
                            <div class="icon d-center rounded-circle"><img
                                    src="{{ asset('assets/img/icon/compasi2.png') }}" alt="icon"></div>
                            <div class="cont">
                                <h4 class="white mb-2">wellness Healing with heart</h4>
                                <p class="white">
                                    Medical care encompasses a range of services aimed at the a promoting health,
                                    preventing
                                </p>
                            </div>
                        </div>
                        <div class="compassionate-item">
                            <div class="icon d-center rounded-circle"><img
                                    src="{{ asset('assets/img/icon/compasi3.png') }}" alt="icon"></div>
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
    <!-- Video Bg Section Start -->
    <div class="video-section section-padding cmn-bg fix">
        <div class="container">
            <div class="video-uniquewrap position-relative d-center w-100">
                <img src="{{ asset('assets/img/global/video-unique.png') }}" alt="img" class="w-100 rounded-4">
                <a href="https://www.youtube.com/watch?v=0pYoyQCau5k"
                    class="video-choose position-absolute d-center rounded-circle p1-bg video-popup">
                    <i class="fa-solid fa-play white"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Testimonial Section Start -->
    <section class="testimonial-sectio2 cmn-bg fix">
        <div class="container">
            <div class="row g-4 justify-content-between">
                <div class="col-xxl-4 col-xl-5 col-lg-5">
                    <div class="section-title">
                        <span class="cmn-tag p1-bg heading-font mb-3">Clients Reviews</span>
                        <h2 class="wow fadeInUp black visible-slowly-right mb-xxl-4 mb-3" data-wow-delay=".3s">
                            What Our Users Are
                            <span class="position-relative z-1">
                                Saying
                                <img src="{{ asset('assets/img/element/title-badge1.png') }}" alt="img"
                                    class="title-badge1 d-md-block d-none w-100">
                            </span>
                        </h2>
                        <p class="pra mb-40">
                            Health care is a vital aspect of maintaining overall well-being, encompassing a range of
                            services from preventive care
                            to treatment
                        </p>
                        <div class="array-button d-flex align-items-center gap-3 wow fadeInUp" data-wow-delay=".5s">
                            <button class="array-prev"><i class="fal fa-arrow-left"></i></button>
                            <button class="array-next"><i class="fal fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-7 col-xl-7 col-lg-7">
                    <div class="swiper testimonial-slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="testimonial-items style2">
                                    <div class="ratting mb-3">
                                        <i class="fa-solid fa-star p3-clr fs-six"></i>
                                        <i class="fa-solid fa-star p3-clr fs-six"></i>
                                        <i class="fa-solid fa-star p3-clr fs-six"></i>
                                        <i class="fa-solid fa-star p3-clr fs-six"></i>
                                        <i class="fa-solid fa-star p3-clr fs-six"></i>
                                    </div>
                                    <p class="fs-five pra mt-xxl-4 mt-4 mb-4">
                                        Health is wealth, and in the realm of medical heal every life matters. It
                                        encompasses a wide range of specialties aimed
                                        at diagnosing, treating, and preventing diseases and maintaining overall very
                                        famous
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-xxl-4 gap-xl-3 gap-2">
                                            <img src="{{ asset('assets/img/testimonial/testimonial-john.png') }}"
                                                alt="img" class="rounded-circle">
                                            <div class="cont">
                                                <h4 class="black">Michael Ramirez</h4>
                                                <span class="fs-seven pra">Ceo</span>
                                            </div>
                                        </div>
                                        <img src="{{ asset('assets/img/testimonial/quote-icons.png') }}"
                                            alt="img" class="quote">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--<< Footer News Appinment Start >>-->
    <div class="footer-new-appoinment position-relative cmn-bg">
        <div class="container">
            <div class="newsletter-appoinment-wrap p1-bg rounded-4">
                <div class="section-title text-center">
                    <h2 class="wow fadeInUp black mb-xxl-4 mb-3 visible-slowly-right" data-wow-delay=".3s">
                        Ready To Turn Dreams Into Reality Lets Get
                        <span class="position-relative z-1">
                            Started
                            <img src="{{ asset('assets/img/element/newsletter-element.png') }}" alt="img"
                                class="title-badge1 d-md-block d-none w-100">
                        </span>
                        Now
                    </h2>
                    <p class="black mb-4">
                        Health care is a vital aspect of maintaining overall well-being, encompassing a range of
                        services from preventive care
                        to treatment of cuses on promoting Health care is a vital aspect of maintaining
                    </p>
                    <a href="doctor-details.html"
                        class="common-btn box-style first-box d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold white overflow-hidden p2-bg rounded100 wow fadeInRight"
                        data-wow-delay="0.8s">
                        Book An Appointment
                        <img src="{{ asset('assets/img/icon/arrow-right-white.png') }}" alt="icon">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!--<< Footer Section Start >>-->
    <footer class="footer-section footer-style2 z-1 position-relative blackbg">
        <div class="container">
            <div
                class="footer-social-logo d-flex align-items-center justify-content-sm-between justify-content-center">
                <a href="{{ url('index') }}">
                    <img src="{{ asset('assets/img/logo/logo-white.png') }}" alt="logo-img">
                </a>
                <div class="social-wrapper d-flex align-items-center">
                    <a href="#" class=" black"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class=" black"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#" class=" black"><i class="fab fa-instagram"></i></a>
                    <a href="#" class=" black"><i class="fa-brands fa-x"></i></a>
                </div>
            </div>
            <div class="footer-widgets-wrapper">
                <div class="row g-4 justify-content-between">
                    <div class="col-lg-3 col-md-6 col-sm-5 d-flex justify-content-lg-center">
                        <div class="single-footer-widget wow fadeInUp" data-wow-delay="0.7s">
                            <div class="widget-head">
                                <h4 class="white">Contact</h4>
                            </div>
                            <ul class="footer-info d-flex flex-column gpa-xxl-4 gap-3">
                                <li class="d-flex align-items-center gap-xl-3 gap-2">
                                    <span class="icon d-center"><i class="p1-clr fa-solid fa-location-dot"></i></span>
                                    <div class="cont">
                                        <span class="white fs-seven d-block">Address</span>
                                        <a href="javascript:void(0)" class="fs-six fw_500 white sub-font">66
                                            Broklyant,India</a>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center gap-xl-3 gap-2">
                                    <span class="icon d-center"><i class="p1-clr fa-solid fa-phone"></i></span>
                                    <div class="cont">
                                        <span class="white fs-seven d-block">Phone Number</span>
                                        <a href="javascript:void(0)" class="fs-six fw_500 white sub-font">012 345
                                            678 9101</a>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center gap-xl-3 gap-2">
                                    <span class="icon d-center"><i class="p1-clr fa-solid fa-envelope"></i></span>
                                    <div class="cont">
                                        <span class="white fs-seven d-block">Email</span>
                                        <a href="javascript:void(0)"
                                            class="fs-six fw_500 white sub-font">abcd@gmail.com</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-5 d-flex justify-content-lg-center">
                        <div class="single-footer-widget wow fadeInUp" data-wow-delay="0.6s">
                            <div class="widget-head">
                                <h4 class="white fw_600">Page</h4>
                            </div>
                            <ul class="list-area">
                                <li>
                                    <a href="{{ url('about') }}">
                                        About Us
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('contact') }}">
                                        Why Chose Us
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Doctors
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        Blog And News
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 d-flex justify-content-lg-center">
                        <div class="single-footer-widget wow fadeInUp" data-wow-delay="0.6s">
                            <div class="widget-head">
                                <h4 class="white fw_600">Services</h4>
                            </div>
                            <ul class="list-area">
                                <li>
                                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-angles-right"></i> Vitality Vitals Clinic
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-angles-right"></i> MedEx Wellness Center
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-angles-right"></i> HopeHealth Medical Group
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-angles-right"></i> SwiftCare Urgent Center
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-angles-right"></i> WellSpring Women's Clinic
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-7">
                        <div class="single-footer-widget wow fadeInUp" data-wow-delay="0.4s">
                            <div class="widget-head">
                                <h4 class="white fw_600">Newsletter</h4>
                            </div>
                            <div class="footer-content">
                                <p class="white">
                                    Medical services are an essential part of our lives, offering care and treatment for
                                    various
                                </p>
                            </div>
                            <form action="#" class="form-cmn-style1">
                                <input type="text" placeholder="Enter your email">
                                <button type="button"
                                    class="common-btn text-nowrap box-style first-box d-inline-flex justify-content-center align-items-center fs-seven fw_600 gap-xxl-2 gap-2 fs18 fw-semibold black overflow-hidden p1-bg rounded-5">
                                    Subscribe
                                    <svg width="21" height="16" viewBox="0 0 21 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M20.7074 8.79688H0.291016V7.04688H20.7074V8.79688Z" fill="#090A0B" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M19.8338 7.04688C15.7184 7.04688 12.3555 10.666 12.3555 14.5252V15.4002H14.1055V14.5252C14.1055 11.5951 16.7218 8.79688 19.8338 8.79688H20.7083V7.04688H19.8338Z"
                                            fill="#090A0B" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M19.8338 8.79675C15.7184 8.79675 12.3555 5.17759 12.3555 1.31836V0.443359H14.1055V1.31836C14.1055 4.24854 16.7218 7.04675 19.8338 7.04675H20.7083V8.79675H19.8338Z"
                                            fill="#090A0B" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-wrap">
                    <p class="body-font fs-seven">
                        &copy; 2025 MediZen | All Rights Reserved
                    </p>
                    <ul class="privacy">
                        <li><a href="javascript:void(0)" class="fs-seven">Terms & Condition</a></li>
                        <li><a href="javascript:void(0)" class="fs-seven">Privacy Policy</a></li>
                        <li><a href="javascript:void(0)" class="fs-seven">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Offcanvas Area Start -->
    <div class="fix-area">
        <div class="offcanvas__info">
            <div class="offcanvas__wrapper">
                <div class="offcanvas__content">
                    <div class="offcanvas__top mb-4 d-flex justify-content-between align-items-center">
                        <div class="offcanvas__logo">
                            <a href="{{ url('index') }}">
                                <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo-img">
                            </a>
                        </div>
                        <div class="offcanvas__close">
                            <button>
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mobile-menu fix mb-3"></div>
                    <div class="offcanvas__contact">
                        <h4>Contact Info</h4>
                        <ul>
                            <li class="d-flex align-items-center">
                                <div class="offcanvas__contact-icon">
                                    <i class="fal fa-map-marker-alt"></i>
                                </div>
                                <div class="offcanvas__contact-text">
                                    <a target="_blank" href="#">Mirpur,10 Road 1 House 12 Mirpur Dhaka
                                        Bangladesh</a>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <div class="offcanvas__contact-icon mr-15">
                                    <i class="fal fa-envelope"></i>
                                </div>
                                <div class="offcanvas__contact-text">
                                    <a href="mailto:info@example.com"><span
                                            class="mailto:info@example.com">info@example.com</span></a>
                                    <a href="mailto:info@example.com"><span
                                            class="mailto:info@example.com">ex@example.com</span></a>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <div class="offcanvas__contact-icon mr-15">
                                    <i class="fal fa-clock"></i>
                                </div>
                                <div class="offcanvas__contact-text">
                                    <a target="_blank" href="#">Sat-friday, 02am -09pm</a>
                                </div>
                            </li>
                            <li class="d-flex align-items-center">
                                <div class="offcanvas__contact-icon mr-15">
                                    <i class="far fa-phone"></i>
                                </div>
                                <div class="offcanvas__contact-text">
                                    <a href="tel:+11002345909" class="d-block">017 5552-0127</a>
                                    <a href="tel:+11002345909">017458632718</a>
                                </div>
                            </li>
                        </ul>
                        <div class="header-button mt-4">
                            <a href="{{ url('contact') }}"
                                class="common-btn box-style first-box d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold black overflow-hidden p1-bg rounded100">
                                Get Start
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="social-icon d-flex align-items-center">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas__overlay"></div><!-- Search Area Start -->
    <div class="search-wrap">
        <div class="search-inner">
            <i class="fas fa-times search-close" id="search-close"></i>
            <div class="search-cell">
                <form method="get">
                    <div class="search-field-holder">
                        <input type="search" class="main-search-input" placeholder="Search...">
                    </div>
                </form>
            </div>
        </div>
    </div><!--<< All JS Plugins >>-->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <!--<< Viewport Js >>-->
    <script src="{{ asset('assets/js/viewport.jquery.js') }}"></script>
    <!--<< Bootstrap Js >>-->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--<< Nice Select Js >>-->
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <!--<< Waypoints Js >>-->
    <script src="{{ asset('assets/js/jquery.waypoints.js') }}"></script>
    <!--<< Counterup Js >>-->
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <!--<< Swiper Slider Js >>-->
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <!--<< MeanMenu Js >>-->
    <script src="{{ asset('assets/js/jquery.meanmenu.min.js') }}"></script>
    <!--<< Magnific Popup Js >>-->
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!--<< Wow Animation Js >>-->
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <!--<< Gsap Js >>-->
    <script src="{{ asset('assets/js/gsap.min.js') }}"></script>
    <!--<< Lenis Js >>-->
    <script src="{{ asset('assets/js/lenis.min.js') }}"></script>
    <!--<< ScrollSmoother Js >>-->
    <script src="{{ asset('assets/js/scrollSmoother.js') }}"></script>
    <!--<< ScrollTrigger Js >>-->
    <script src="{{ asset('assets/js/ScrollTrigger.min.js') }}"></script>
    <!--<< Spalit Text Js >>-->
    <script src="{{ asset('assets/js/spilitext-gsap.js') }}"></script>
    <!--<< Valina Tilt Js >>-->
    <script src="{{ asset('assets/js/vanilla-tilt.min.js') }}"></script>
    <!--<< Main.js >>-->
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>


<!-- Mirrored from thememxpro.com/demo/medizen/index2.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 17 Feb 2026 14:10:27 GMT -->

</html>
