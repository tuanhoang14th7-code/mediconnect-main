<!DOCTYPE html>
<html lang="en">
<!--<< Header Area >>-->


<!-- Mirrored from etorisoft.com/html/medizen/{{ url('index') }} by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 11 Sep 2025 03:58:23 GMT -->

<!-- Mirrored from thememxpro.com/demo/medizen/index3.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 17 Feb 2026 14:10:27 GMT -->
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
    <title>Home Three || Medizen || Medizen PHP Template</title>
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
    <!-- End Cursor Pointer --><!-- Header Section Start -->
    <header id="header-sticky" class="header-3 bg-transparent sticky-header1">
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
                    <div class="author-icon">
                        <div class="icon">
                            <i class="fa-light fa-phone-volume"></i>
                        </div>
                        <div class="content">
                            <h5>
                                <a href="tel:+1(345)678-910">+1(345)678-910</a>
                            </h5>
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
    <section class="banner-section3 fix bg-cover" style="background-image: url('assets/img/banner/bg-color3.jpg');">
        <div class="container">
            <div class="row g-5 justify-content-between">
                <div class="col-xxl-7 col-xl-7 col-md-11 order-2 order-lg-1">
                    <div class="hero-content-version3">
                        <span class="cmn-tag p1-bg heading-font mb-xxl-1 mb-3">Madical Care</span>
                        <h1 class="black wow fadeInUp" data-wow-delay="0.6s">
                            We Provide<br>
                            <span class="position-relative z-1 w-100">
                                Dental
                                <img src="{{ asset('assets/img/element/title-badge1.png') }}" alt="img"
                                    class="title-badge1 d-md-block d-none w-100">
                            </span>
                            Services<br> & Surgery
                            <img src="{{ asset('assets/img/banner/icon3_1.svg') }}" alt="icon" class="img-icon">
                        </h1>
                        <p>Dental care focuses on maintaining oral health through practices such as<br> regular check-,
                            and treatments
                            for
                            teeth and gums It includes</p>
                    </div>
                </div>
                <div class="col-xxl-5 col-xl-5 col-md-7 order-1 order-lg-2">
                    <div class="banner-thumb-items">
                        <div class="thumb-shape-1">
                            <img src="{{ asset('assets/img/banner/shape3_2.png') }}" alt="shape-img">
                        </div>
                        <div class="thumb-shape-2">
                            <img src="{{ asset('assets/img/banner/shape3_1.png') }}" alt="shape-img">
                        </div>
                        <div class="thumb-shape-3">
                            <img src="{{ asset('assets/img/banner/search-shape.png') }}" alt="shape-img">
                        </div>
                        <div class="thumb">
                            <img src="{{ asset('assets/img/banner/hero3-thumb.png') }}" alt="thumb">
                        </div>
                        <div class="counter-area-1">
                            <div class="counter-content d-center">
                                <h3><span>1k</span>+</h3>
                                <h4>Patients</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- TextSlide System Section Start -->
    <div class="sponsor-text-slide p1-bg swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide w-fit">
                <div class="text-slide-item">
                    Quality Care Service
                </div>
            </div>
            <div class="swiper-slide w-fit">
                <div class="text-slide-item">
                    <img src="{{ asset('assets/img/icon/star-text.png') }}" alt="icon">
                </div>
            </div>
            <div class="swiper-slide w-fit">
                <div class="text-slide-item">
                    Your Wellness Priority
                </div>
            </div>
            <div class="swiper-slide w-fit">
                <div class="text-slide-item">
                    <img src="{{ asset('assets/img/icon/star-text.png') }}" alt="icon">
                </div>
            </div>
            <div class="swiper-slide w-fit">
                <div class="text-slide-item">
                    Caring for You Always
                </div>
            </div>
            <div class="swiper-slide w-fit">
                <div class="text-slide-item">
                    <img src="{{ asset('assets/img/icon/star-text.png') }}" alt="icon">
                </div>
            </div>
            <div class="swiper-slide w-fit">
                <div class="text-slide-item">
                    Quality Care Service
                </div>
            </div>
            <div class="swiper-slide w-fit">
                <div class="text-slide-item">
                    <img src="{{ asset('assets/img/icon/star-text.png') }}" alt="icon">
                </div>
            </div>
            <div class="swiper-slide w-fit">
                <div class="text-slide-item">
                    Your Wellness Priority
                </div>
            </div>
            <div class="swiper-slide w-fit">
                <div class="text-slide-item">
                    <img src="{{ asset('assets/img/icon/star-text.png') }}" alt="icon">
                </div>
            </div>
        </div>
    </div>
    <!-- About Section Start -->
    <section class="about-section3 cmn-bg fix">
        <div class="container">
            <div class="about-wrapper3">
                <div class="row g-5 justify-content-between">
                    <div class="col-xl-6 col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="about-content3">
                            <div class="section-title">
                                <span class="cmn-tag p1-bg heading-font">About Us</span>
                                <h2 class="wow fadeInUp black visible-slowly-right mb-xxl-4 mb-3"
                                    data-wow-delay=".3s">
                                    Compassionate Dental There
                                    <span class="position-relative z-1">
                                        Health
                                        <img src="{{ asset('assets/img/element/title-badge1.png') }}" alt="img"
                                            class="title-badge1 d-md-block d-none w-100">
                                    </span>
                                    First
                                </h2>
                                <p class="pra mb-sm-4 mb-3 position-relative syle-pra d-flex align-items-center gap-3">
                                    <img src="{{ asset('assets/img/element/pra-element.png') }}" alt="element"
                                        class="d-sm-block d-none">
                                    Over 30 year’s experience providing top quality country'sacross world. The energy
                                    that
                                    is
                                    sourceable , free and healthy.
                                </p>
                            </div>
                            <div class="progress-wrap">
                                <div class="pro-items wow fadeInUp" data-wow-delay=".5s">
                                    <div class="pro-head">
                                        <h4 class="title">
                                            Dental and Mouth Care
                                        </h4>
                                        <span class="point style">
                                            87%
                                        </span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-value"></div>
                                    </div>
                                </div>
                                <div class="pro-items wow fadeInUp" data-wow-delay=".7s">
                                    <div class="pro-head">
                                        <h4 class="title">
                                            Cosmetic Treatment
                                        </h4>
                                        <span class="point">
                                            95%
                                        </span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-value style-two"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="about-btn-inner mt-5">
                                <a href="{{ url('about') }}"
                                    class="common-btn box-style first-box d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold black overflow-hidden rounded100">
                                    Read More
                                    <img src="{{ asset('assets/img/icon/arrow-right-black.png') }}" alt="icon">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="about-schedule rounded-4">
                            <div class="about-content">
                                <h1>Schedule</h1>
                                <p>Dental care focuses on maintaining oral health through practices such as regular
                                    check-ups,
                                    cleanings, and treatments for teeth and gums. It includes preventive care to avoid
                                    dental issues</p>
                                <div class="time-schedule">
                                    <ul>
                                        <li><span class="text">Monday - wednesday</span> <span>8AM - 10PM</span></li>
                                        <li><span class="text">Satuday - Sunday</span> <span>10AM - 2PM</span></li>
                                        <li><span class="text">Friday</span> <span>2PM - 8PM</span></li>
                                        <li><span class="text">thusday</span> <span>Off</span< /li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Team Section Start -->
    <section class="team-section3 fix cmn-bg section-padding pb-0">
        <div class="container">
            <div class="section-title text-center mb-60">
                <span class="cmn-tag p1-bg heading-font">Our Team Member</span>
                <h2 class="wow fadeInUp black visible-slowly-right" data-wow-delay=".3s">
                    Compassionate Dental<br>Exceptional
                    <span class="position-relative z-1">
                        Results
                        <img src="{{ asset('assets/img/element/title-badge1.png') }}" alt="img"
                            class="title-badge1 d-md-block d-none w-100">
                    </span>
                </h2>
            </div>
            <div class="team-wrapper3">
                <div class="row g-4 justify-content-between">
                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="team-items-info3">
                            <div class="thumb">
                                <img src="{{ asset('assets/img/team/teamThumb3_1.jpg') }}" alt="thumb">
                            </div>
                            <div class="team-content align-items-end">
                                <h3><a href="doctor-details.html">Dr.Alvin Eclair</a></h3>
                                <p>Dental Care</p>
                                <div class="social-wrapper d-flex align-items-center">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" class=" black"><i class="fa-brands fa-x"></i></a>
                                    <a href="#" class=" black"><i class="fa-brands fa-linkedin-in"></i></a>
                                    <a href="#" class=" black"><i class="fa-brands fa-pinterest-p"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="team-items-info3">
                            <div class="thumb">
                                <img src="{{ asset('assets/img/team/teamThumb3_2.jpg') }}" alt="thumb">
                            </div>
                            <div class="team-content align-items-end">
                                <h3><a href="doctor-details.html">Dr.Alan Jelly</a></h3>
                                <p>Eye Expert</p>
                                <div class="social-wrapper d-flex align-items-center">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" class=" black"><i class="fa-brands fa-x"></i></a>
                                    <a href="#" class=" black"><i class="fa-brands fa-linkedin-in"></i></a>
                                    <a href="#" class=" black"><i class="fa-brands fa-pinterest-p"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="team-items-info3">
                            <div class="thumb">
                                <img src="{{ asset('assets/img/team/teamThumb3_3.jpg') }}" alt="thumb">
                            </div>
                            <div class="team-content align-items-end">
                                <h3><a href="doctor-details.html">Dr. R. Chassay</a></h3>
                                <p>Neurology Expert</p>
                                <div class="social-wrapper d-flex align-items-center">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" class=" black"><i class="fa-brands fa-x"></i></a>
                                    <a href="#" class=" black"><i class="fa-brands fa-linkedin-in"></i></a>
                                    <a href="#" class=" black"><i class="fa-brands fa-pinterest-p"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial Section Start -->
    <section class="testimonial-section3 section-padding cmn-bg fix">
        <div class="container">
            <div class="testimonial-wrapper3">
                <div class="swiper testimonial-slider3">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testimonial-items3">
                                <div class="testimonial-content">
                                    <div class="section-title text-center mb-60">
                                        <span class="cmn-tag p1-bg heading-font">Clients Reviews</span>
                                        <h2 class="wow fadeInUp visible-slowly-right" data-wow-delay=".3s">
                                            What Our
                                            <span class="position-relative z-1">
                                                Present
                                                <img src="{{ asset('assets/img/element/title-badge1.png') }}"
                                                    alt="img" class="title-badge1 d-md-block d-none w-100">
                                            </span>
                                            Says?
                                        </h2>
                                    </div>
                                    <div class="thumb">
                                        <img src="{{ asset('assets/img/testimonial/testimonialthumb3_1.png') }}"
                                            alt="thumb">
                                    </div>
                                    <div class="author-details">
                                        <h3>Michael Ramirez</h3>
                                        <div class="icon">
                                            <img src="{{ asset('assets/img/testimonial/quote-icons3.png') }}"
                                                alt="icon">
                                        </div>
                                        <span>Ceo</span>
                                    </div>
                                    <p>Dental is wealth, and in the realm of medical heal every life matters. It
                                        encompasses a wide range
                                        of specialties aimed at diagnosing and preventing diseases and maintaining </p>
                                    <div class="star">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star color-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-items3">
                                <div class="testimonial-content">
                                    <div class="section-title text-center mb-60">
                                        <span class="cmn-tag p1-bg heading-font">Clients Reviews</span>
                                        <h2 class="wow fadeInUp visible-slowly-right" data-wow-delay=".3s">
                                            What Our
                                            <span class="position-relative z-1">
                                                Present
                                                <img src="{{ asset('assets/img/element/title-badge1.png') }}"
                                                    alt="img" class="title-badge1 d-md-block d-none w-100">
                                            </span>
                                            Says?
                                        </h2>
                                    </div>
                                    <div class="thumb">
                                        <img src="{{ asset('assets/img/testimonial/testimonialthumb3_1.png') }}"
                                            alt="thumb">
                                    </div>
                                    <div class="author-details">
                                        <h3>Michael Ramirez</h3>
                                        <div class="icon">
                                            <img src="{{ asset('assets/img/testimonial/quote-icons3.png') }}"
                                                alt="icon">
                                        </div>
                                        <span>Ceo</span>
                                    </div>
                                    <p>Dental is wealth, and in the realm of medical heal every life matters. It
                                        encompasses a wide range
                                        of specialties aimed at diagnosing and preventing diseases and maintaining </p>
                                    <div class="star">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star color-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-items3">
                                <div class="testimonial-content">
                                    <div class="section-title text-center mb-60">
                                        <span class="cmn-tag p1-bg heading-font">Clients Reviews</span>
                                        <h2 class="wow fadeInUp visible-slowly-right" data-wow-delay=".3s">
                                            What Our
                                            <span class="position-relative z-1">
                                                Present
                                                <img src="{{ asset('assets/img/element/title-badge1.png') }}"
                                                    alt="img" class="title-badge1 d-md-block d-none w-100">
                                            </span>
                                            Says?
                                        </h2>
                                    </div>
                                    <div class="thumb">
                                        <img src="{{ asset('assets/img/testimonial/testimonialthumb3_1.png') }}"
                                            alt="thumb">
                                    </div>
                                    <div class="author-details">
                                        <h3>Michael Ramirez</h3>
                                        <div class="icon">
                                            <img src="{{ asset('assets/img/testimonial/quote-icons3.png') }}"
                                                alt="icon">
                                        </div>
                                        <span>Ceo</span>
                                    </div>
                                    <p>Dental is wealth, and in the realm of medical heal every life matters. It
                                        encompasses a wide range
                                        of specialties aimed at diagnosing and preventing diseases and maintaining </p>
                                    <div class="star">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star color-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="array-button d-flex align-items-between">
                        <button class="array-prev"><i class="fal fa-arrow-left"></i></button>
                        <button class="array-next"><i class="fal fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Counter Care Section Start -->
    <section class="care-counter3 cmn-bg fix section-padding">
        <div class="container">
            <div class="care-counter-wrap3">
                <div class="row g-3 justify-content-center">
                    <div class="col-lg-3 col-md-6 col-sm-6 wow fadeIn" data-wow-delay="0.4s">
                        <div class="counter-items3">
                            <div class="content3">
                                <h2><span class="count">600</span>+</h2>
                                <p>Complte Project</p>
                            </div>
                            <div class="icon">
                                <svg width="11" height="107" viewBox="0 0 11 107" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <line x1="0.5" y1="0.164063" x2="0.499995" y2="106.164"
                                        stroke="#CCCCCC" />
                                    <line x1="10.5" y1="0.164063" x2="10.5" y2="106.164"
                                        stroke="#CCCCCC" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                        <div class="counter-items3">
                            <div class="content3">
                                <h2><span class="count">200</span>+</h2>
                                <p>Complte Project</p>
                            </div>
                            <div class="icon">
                                <svg width="11" height="107" viewBox="0 0 11 107" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <line x1="0.5" y1="0.164063" x2="0.499995" y2="106.164"
                                        stroke="#CCCCCC" />
                                    <line x1="10.5" y1="0.164063" x2="10.5" y2="106.164"
                                        stroke="#CCCCCC" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 wow fadeIn" data-wow-delay="0.6s">
                        <div class="counter-items3">
                            <div class="content3">
                                <h2><span class="count">500</span>+</h2>
                                <p>Complte Project</p>
                            </div>
                            <div class="icon">
                                <svg width="11" height="107" viewBox="0 0 11 107" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <line x1="0.5" y1="0.164063" x2="0.499995" y2="106.164"
                                        stroke="#CCCCCC" />
                                    <line x1="10.5" y1="0.164063" x2="10.5" y2="106.164"
                                        stroke="#CCCCCC" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                        <div class="counter-items3">
                            <div class="content3">
                                <h2><span class="count">500</span>+</h2>
                                <p>Complte Project</p>
                            </div>
                            <div class="icon">
                                <svg width="11" height="107" viewBox="0 0 11 107" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <line x1="0.5" y1="0.164063" x2="0.499995" y2="106.164"
                                        stroke="#CCCCCC" />
                                    <line x1="10.5" y1="0.164063" x2="10.5" y2="106.164"
                                        stroke="#CCCCCC" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Feature Section Start -->
    <section class="feature-section3 fix cmn-bg">
        <div class="container">
            <div class="feature-wrapper3">
                <div class="row g-4 mb-30">
                    <div class="col-xl-6 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="feature-items1">
                            <div class="content">
                                <h2>Compassionate care a exceptional results</h2>
                                <p>Dental care focuses on maintaining oral health through practices such as regular </p>
                            </div>
                            <div class="icon">
                                <img src="{{ asset('assets/img/feature/featureIcon3_1.png') }}" alt="icon">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="feature-thumb">
                            <img src="{{ asset('assets/img/feature/featureThumb3_1.png') }}" alt="thumb">
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="feature-content">
                            <span>10</span>
                            <h4>years of experiences</h4>
                            <p>Dental care focuses maintaining oral health through practices such as regular check-ups,
                                cleanings, and
                                treatments</p>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-xl-9 col-lg-8 wow fadeInUp" data-wow-delay="0.9s">
                        <div class="feature-inner-items2 reveal-left bg-cover rounded-4"
                            style="background-image: url('assets/img/feature/featureThumb3_2.png');">
                            <div class="content">
                                <h1>A healthy tomorrow starts today</h1>
                                <p>Dental care focuses on maintaining oral health through practices such as regular
                                    Dental care focuses
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 wow fadeInUp" data-wow-delay="1.3s">
                        <div class="feature-inner-items3">
                            <h3>Caring for You Always</h3>
                            <ul class="list-area d-flex flex-column pb-xl-3">
                                <li class="d-flex align-items-center gap-lg-2 gap-1 fs-six">
                                    <i class="fa-solid fa-angles-right"></i> Health Harmony
                                </li>
                                <li class="d-flex align-items-center gap-lg-2 gap-1 fs-six">
                                    <i class="fa-solid fa-angles-right"></i> Vitality Visions
                                </li>
                                <li class="d-flex align-items-center gap-lg-2 gap-1 fs-six">
                                    <i class="fa-solid fa-angles-right"></i> Care Connect Well
                                </li>
                                <li class="d-flex align-items-center gap-lg-2 gap-1 fs-six">
                                    <i class="fa-solid fa-angles-right"></i> Mindful Moments
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Appointment Section Start -->
    <section class="appointment-section fix cmn-bg">
        <div class="container">
            <div class="appointment-wrapper">
                <div class="row gx-0 gy-5 align-items-end">
                    <div class="col-lg-6 order-lg-0 order-1">
                        <div class="appointment-thumb reveal-left">
                            <img src="{{ asset('assets/img/appiontment/appiontmentThumb3_1.png') }}" alt="img"
                                class="w-100 rounded-2">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="section-title">
                            <span class="cmn-tag p1-bg heading-font">Contact Us</span>
                            <h2 class="wow fadeInUp black visible-slowly-right" data-wow-delay=".3s">
                                Get an Appointment
                            </h2>
                        </div>
                        <form action="#" class="appointment-forms">
                            <div class="row g-lg-3 g-3">
                                <div class="col-lg-6">
                                    <input type="text" placeholder="Your Name">
                                </div>
                                <div class="col-lg-6">
                                    <input type="email" placeholder="Your Email">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" placeholder="location">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" placeholder="MM/dd/yyy">
                                </div>
                                <div class="col-lg-12">
                                    <textarea name="message" placeholder="Message" rows="5"></textarea>
                                </div>
                                <div class="col-lg-12">
                                    <a href="doctor-details.html"
                                        class="common-btn box-style p2-bg w-100 text-nowrap d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold white overflow-hidden rounded100 wow fadeInRight"
                                        data-wow-delay="0.8s">
                                        Book An Appointment
                                        <img src="{{ asset('assets/img/icon/arrow-right-white.png') }}"
                                            alt="icon">
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!--<< Footer News Appinment Start >>-->
    <div class="footer-new-appoinment3 position-relative cmn-bg">
        <div class="container">
            <div class="newsletter-appoinment-wrap3 p2-bg">
                <div class="row">
                    <div class="col-xl-7 col-lg-7">
                        <div class="newsletter-appoinment3">
                            <div class="section-title">
                                <h2 class="wow fadeInUp mb-xxl-4 mb-3 visible-slowly-right" data-wow-delay=".3s">
                                    Ready To Turn Dreams Into Reality Subscribe to Our Newsletter
                                </h2>
                                <div class="btn-button">
                                    <div class="appoinment-btn">
                                        <a href="doctor-details.html"
                                            class="common-btn box-style first-box p1-bg d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold overflow-hidden rounded100 wow fadeInRight"
                                            data-wow-delay="0.8s">
                                            Book An Appointment
                                            <img src="{{ asset('assets/img/icon/arrow-right-black.png') }}"
                                                alt="icon">
                                        </a>
                                    </div>
                                    <div class="author-icon">
                                        <div class="icon">
                                            <svg width="49" height="48" viewBox="0 0 49 48" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect x="1.5" y="1" width="46" height="46" rx="23"
                                                    stroke="white" stroke-opacity="0.4" stroke-width="2" />
                                                <g clip-path="url(#clip0_6226_134)">
                                                    <path
                                                        d="M36.7308 30.9874L31.4528 27.4774C31.1235 27.2521 30.7595 27.1741 30.3608 27.2434C29.9622 27.3127 29.6415 27.5034 29.3988 27.8154L27.8648 29.7914C27.7782 29.9127 27.6525 29.9951 27.4878 30.0384C27.3232 30.0817 27.1715 30.0601 27.0328 29.9734L26.6428 29.7654C25.9668 29.3841 25.3862 29.0114 24.9008 28.6474C24.0862 28.0407 23.1675 27.2261 22.1448 26.2034C21.1222 25.1807 20.3075 24.2621 19.7008 23.4474C19.3368 22.9621 18.9642 22.3814 18.5828 21.7054L18.3748 21.3154C18.2882 21.1767 18.2665 21.0251 18.3098 20.8604C18.3532 20.6957 18.4355 20.5701 18.5568 20.4834L20.5328 18.9494C20.8448 18.7067 21.0355 18.3861 21.1048 17.9874C21.1742 17.5887 21.0962 17.2247 20.8708 16.8954L17.3608 11.6174C17.1182 11.2707 16.7975 11.0541 16.3988 10.9674C16.0002 10.8807 15.6275 10.9414 15.2808 11.1494L13.0968 12.4754C12.3862 12.8914 11.9095 13.5067 11.6668 14.3214C11.3722 15.4307 11.3288 16.6267 11.5368 17.9094C11.8142 19.5041 12.4815 21.1941 13.5388 22.9794C14.7695 25.0594 16.5288 27.2434 18.8168 29.5314C21.5208 32.2354 24.0775 34.2027 26.4868 35.4334C28.4455 36.4387 30.2828 36.9414 31.9988 36.9414C32.7268 36.9414 33.4028 36.8547 34.0268 36.6814C34.8415 36.4387 35.4568 35.9621 35.8728 35.2514L37.1988 33.0674C37.4068 32.7207 37.4675 32.3481 37.3808 31.9494C37.2941 31.5507 37.0775 31.2301 36.7308 30.9874ZM36.4448 32.6254L35.1188 34.8094C34.8068 35.3467 34.3648 35.6934 33.7928 35.8494C32.7702 36.1267 31.6608 36.1614 30.4648 35.9534C28.9742 35.6761 27.3882 35.0261 25.7068 34.0034C23.7308 32.8074 21.6422 31.1087 19.4408 28.9074C16.2515 25.7181 14.1195 22.7714 13.0448 20.0674C12.2302 18.0221 12.0482 16.1847 12.4988 14.5554C12.6895 13.9661 13.0362 13.5241 13.5388 13.2294L15.7488 11.9034C15.8875 11.8167 16.0435 11.7907 16.2168 11.8254C16.3902 11.8601 16.5288 11.9554 16.6328 12.1114L18.5308 14.9714L20.1428 17.3634C20.2295 17.5021 20.2598 17.6581 20.2338 17.8314C20.2078 18.0047 20.1255 18.1434 19.9868 18.2474L18.0108 19.7814C17.7162 20.0067 17.5298 20.3057 17.4518 20.6784C17.3738 21.0511 17.4302 21.4021 17.6208 21.7314L17.7768 22.0174C18.1582 22.7281 18.5395 23.3434 18.9208 23.8634C19.5448 24.7301 20.4115 25.7181 21.5208 26.8274C22.6302 27.9367 23.6182 28.8034 24.4848 29.4274C25.0048 29.8087 25.6202 30.1901 26.3308 30.5714L26.6168 30.7274C26.9462 30.9181 27.2972 30.9744 27.6698 30.8964C28.0425 30.8184 28.3415 30.6321 28.5668 30.3374L30.0748 28.3614C30.1961 28.2227 30.3435 28.1404 30.5168 28.1144C30.6902 28.0884 30.8462 28.1187 30.9848 28.2054L36.2368 31.7154C36.3928 31.8194 36.4881 31.9581 36.5228 32.1314C36.5575 32.3047 36.5315 32.4694 36.4448 32.6254ZM26.1488 15.2834C27.4835 15.2834 28.7228 15.6214 29.8668 16.2974C30.9762 16.9387 31.8515 17.8141 32.4928 18.9234C33.1688 20.0674 33.5068 21.3067 33.5068 22.6414C33.5068 22.7627 33.5501 22.8667 33.6368 22.9534C33.7235 23.0401 33.8275 23.0834 33.9488 23.0834C34.0702 23.0834 34.1698 23.0401 34.2478 22.9534C34.3258 22.8667 34.3648 22.7627 34.3648 22.6414C34.3648 21.1507 33.9922 19.7641 33.2468 18.4814C32.5188 17.2507 31.5308 16.2714 30.2828 15.5434C29.0175 14.7807 27.6395 14.3994 26.1488 14.3994C26.0275 14.3994 25.9235 14.4427 25.8368 14.5294C25.7502 14.6161 25.7068 14.7201 25.7068 14.8414C25.7068 14.9627 25.7502 15.0667 25.8368 15.1534C25.9235 15.2401 26.0275 15.2834 26.1488 15.2834ZM26.1488 17.8834C27.0155 17.8834 27.8128 18.0957 28.5408 18.5204C29.2688 18.9451 29.8451 19.5214 30.2698 20.2494C30.6945 20.9774 30.9068 21.7747 30.9068 22.6414C30.9068 22.7627 30.9502 22.8667 31.0368 22.9534C31.1235 23.0401 31.2275 23.0834 31.3488 23.0834C31.4701 23.0834 31.5698 23.0401 31.6478 22.9534C31.7258 22.8667 31.7648 22.7627 31.7648 22.6414C31.7648 21.6187 31.5135 20.6741 31.0108 19.8074C30.5082 18.9407 29.8278 18.2561 28.9698 17.7534C28.1118 17.2507 27.1715 16.9994 26.1488 16.9994C26.0275 16.9994 25.9235 17.0427 25.8368 17.1294C25.7502 17.2161 25.7068 17.3201 25.7068 17.4414C25.7068 17.5627 25.7502 17.6667 25.8368 17.7534C25.9235 17.8401 26.0275 17.8834 26.1488 17.8834ZM26.1488 20.4834C26.7555 20.4834 27.2668 20.6914 27.6828 21.1074C28.0988 21.5234 28.3068 22.0347 28.3068 22.6414C28.3068 22.7627 28.3502 22.8667 28.4368 22.9534C28.5235 23.0401 28.6275 23.0834 28.7488 23.0834C28.8702 23.0834 28.9698 23.0401 29.0478 22.9534C29.1258 22.8667 29.1648 22.7627 29.1648 22.6414C29.1648 22.0867 29.0305 21.5797 28.7618 21.1204C28.4932 20.6611 28.1248 20.2927 27.6568 20.0154C27.1888 19.7381 26.6862 19.5994 26.1488 19.5994C26.0275 19.5994 25.9235 19.6427 25.8368 19.7294C25.7502 19.8161 25.7068 19.9201 25.7068 20.0414C25.7068 20.1627 25.7502 20.2667 25.8368 20.3534C25.9235 20.4401 26.0275 20.4834 26.1488 20.4834Z"
                                                        fill="white" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_6226_134">
                                                        <rect width="26" height="26" fill="white"
                                                            transform="matrix(1 0 0 -1 11.4067 36.9414)" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </div>
                                        <div class="content">
                                            <h5>
                                                <a href="tel:+1(345)678-910">+1(345)678-910</a>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5">
                        <div class="appoinment-thumb">
                            <div class="thumb">
                                <img src="{{ asset('assets/img/appiontment/appiontmentThumb3_3.png') }}"
                                    alt="thumb">
                            </div>
                            <div class="shape">
                                <img src="{{ asset('assets/img/appiontment/appiontmenticon3_1.png') }}"
                                    alt="icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--<< Footer Section Start >>-->
    <footer class="footer-section3 footer-style3 z-1 position-relative blackbg">
        <div class="container">
            <div class="footer-widgets-wrapper3">
                <div class="row g-4 justify-content-between">
                    <div class="col-lg-3 col-md-6 col-sm-5 d-flex justify-content-lg-center">
                        <div class="single-footer-widget3 wow fadeInUp" data-wow-delay="0.7s">
                            <div class="widget-head">
                                <a href="{{ url('index') }}">
                                    <img src="{{ asset('assets/img/logo/logo-white.png') }}" alt="logo-img">
                                </a>
                            </div>
                            <ul class="footer-info d-flex flex-column gpa-xxl-4 gap-3">
                                <li class="d-flex align-items-center gap-xl-3 gap-2">
                                    <div class="cont">
                                        <span class="fs-seven d-block">Address</span>
                                        <a href="javascript:void(0)" class="fs-six fw_500 white sub-font">66
                                            Broklyant,India</a>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center gap-xl-3 gap-2">
                                    <div class="cont">
                                        <span class="fs-seven d-block">Phone Number</span>
                                        <a href="javascript:void(0)" class="fs-six fw_500 white sub-font">012 345
                                            678 9101</a>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center gap-xl-3 gap-2">
                                    <div class="cont">
                                        <span class="fs-seven d-block">Email</span>
                                        <a href="javascript:void(0)"
                                            class="fs-six fw_500 white sub-font">abcd@gmail.com</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-5 d-flex justify-content-lg-center">
                        <div class="single-footer-widget3 wow fadeInUp" data-wow-delay="0.6s">
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
                        <div class="single-footer-widget3 wow fadeInUp" data-wow-delay="0.6s">
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
                </div>
            </div>
        </div>
        <div class="footer-bottom3">
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


<!-- Mirrored from thememxpro.com/demo/medizen/index3.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 17 Feb 2026 14:10:33 GMT -->

</html>
