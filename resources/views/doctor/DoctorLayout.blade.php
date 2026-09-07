<!DOCTYPE html>
<html lang="en">
<!--<< Header Area >>-->


<!-- Mirrored from etorisoft.com/html/medizen/{{ url('doctor/doctordashboard') }} by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 11 Sep 2025 03:58:23 GMT -->

<!-- Mirrored from thememxpro.com/demo/medizen/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 17 Feb 2026 14:09:51 GMT -->
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
    <title>Doctor || Medizen </title>

    <!--<< Favcion >>-->
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/favs.png') }}">
    <!--<< Bootstrap min.css >>-->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!--<< Bootstrap icon add by v8 >>-->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.css') }}">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"> --}}

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

<body class="body-bg">
    {{-- <div style="height:100vh"> --}}
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
    <!-- <div class="mouse-follower">
        <span class="cursor-outline"></span>
        <span class="cursor-dot"></span>
    </div> -->
    <!-- End Cursor Pointer -->


    <!-- Header Section Start -->
    <header id="header-sticky" class="header-1 header-style2" style="border: 1px solid grey; border-radius: 15px;">
        <div class="container">
            <div class="mega-menu-wrapper">
                <div class="header-main style-2">
                    <div class="header-left">
                        <div class="logo">
                            <a href="{{ url('doctor/doctordashboard') }}" class="header-logo">
                                <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo-img">
                            </a>
                        </div>
                    </div>
                    <div class="header-right d-flex justify-content-end align-items-center">
                        <div class="mean__menu-wrapper">
                            <div class="main-menu">
                                <nav id="mobile-menu">
                                    <ul>
                                        <li><a href="{{ url('Doctor/DoctorDashboard') }}">Schedule</a></li>
                                        <li><a href="{{ url('Doctor/MyProfile') }}">Profile</a></li>
                                        {{-- @if (auth()->user()) --}}
                                        <li class="has-dropdown"><a href="{{ url('logout') }}"
                                                style="color:#f98c8c">Logout</a></li>
                                        {{-- @else
                                            <li class="has-dropdown"><a href="{{ url('login') }}">Login</a></li>
                                            <li class="has-dropdown dark"><a href="{{ url('register') }}">Register</a>
                                            </li>
                                        @endif --}}
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="header__hamburger d-xl-none my-auto">
                            <div class="sidebar__toggle">
                                <img src="{{ asset('assets/img/icon/menu.png') }}" alt="icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- <hr style="margin: 0;"> --}}

    @yield('doctor-content')

    {{-- </div> --}}
    <!--<< Footer Section Start >>-->
    <footer class="footer-section z-1 position-relative blackbg fix">
        <div class="container pt-5">
            <div class="footer-space">
                <div class="footer-widgets-wrapper">
                    <div class="row g-4 justify-content-between">
                        <div class="col-lg-3 col-md-6 col-sm-7">
                            <div class="single-footer-widget wow fadeInUp" data-wow-delay="0.4s">
                                <div class="widget-head">
                                    <a href="{{ url('index') }}">
                                        <img src="{{ asset('assets/img/logo/logo-white.png') }}" alt="logo-img">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-7">
                            <div class="footer-content">
                                <p class="pra2">
                                    Medical services are an essential part of our lives, offering care and treatment
                                    for various health conditions
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-7">
                            <div class="social-wrapper d-flex align-items-center">
                                <a href="#" class=" black"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class=" black"><i class="fa-brands fa-linkedin-in"></i></a>
                                <a href="#" class=" black"><i class="fab fa-instagram"></i></a>
                                <a href="#" class=" black"><i class="fa-brands fa-x"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center">
            <div class="container">
                <p class="body-font text-center py-4">
                    &copy; 2025 MediZen | All Rights Reserved
                </p>
            </div>
        </div>
        <!-- Element-->
        <img src="{{ asset('assets/img/element/footer-element.png') }}" alt="element" class="footer-element">
    </footer>

    <!-- Offcanvas Area Start -->
    <div class="fix-area">
        <div class="offcanvas__info">
            <div class="offcanvas__wrapper">
                <div class="offcanvas__content">
                    <div class="offcanvas__top mb-4 d-flex justify-content-between align-items-center">
                        <div class="offcanvas__logo">
                            <a href="{{ url('doctor/doctordashboard') }}">
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
    </div>

    <!--<< All JS Plugins >>-->
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
    <!--<< Split Text Js >>-->
    <script src="{{ asset('assets/js/spilitext-gsap.js') }}"></script>
    <!--<< Vanilla Tilt Js >>-->
    <script src="{{ asset('assets/js/vanilla-tilt.min.js') }}"></script>
    <!--<< Main.js >>-->
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>


<!-- Mirrored from thememxpro.com/demo/medizen/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 17 Feb 2026 14:10:12 GMT -->

</html>
