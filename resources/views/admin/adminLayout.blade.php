<!DOCTYPE html>
<html lang="en">
<!--<< Header Area >>-->


<!-- Mirrored from etorisoft.com/html/medizen/{{ url('Admin/AdminDashboard') }} by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 11 Sep 2025 03:58:23 GMT -->

<!-- Mirrored from thememxpro.com/demo/medizen/Admin/AdminDashboard.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 17 Feb 2026 14:09:51 GMT -->
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
    <title>Admin || Medizen </title>

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

    <!-- ================== MAIN WRAPPER START ================== -->
    <div id="main-wrapper" class="d-flex">

        <!-- ================== LEFT SIDEBAR ================== -->
        <aside style="width:260px; min-height:100vh; background:#2a3b57;">

            <div class="p-3 text-center">
                <a href="{{ url('Admin/AdminDashboard') }}">
                    <img src="{{ asset('assets/img/logo/logo-white.png') }}" style="max-width:140px;">
                </a>
            </div>

            <nav class="px-3">
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="{{ url('Admin/AdminDashboard') }}" class="nav-link text-white">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ url('Admin/Appointments') }}" class="nav-link text-white">
                            <i class="bi bi-calender-event"></i><i class="bi bi-calender-check"></i> Appointments
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ url('Admin/Patients') }}" class="nav-link text-white">
                            <i class="bi bi-people"></i><i class="bi bi-person"></i> Patients
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ url('Admin/Doctors') }}" class="nav-link text-white">
                            <i class="bi bi-person-badge"></i><i class="bi bi-heart-pulse"></i> Doctors
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ url('Admin/DoctorRegister') }}" class="nav-link text-white">
                            <i class="bi bi-person-plus"></i> New Doctor Register
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a href="{{ url('logout') }}" class="nav-link text-danger">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </nav>

        </aside>
        <!-- ================== END SIDEBAR ================== -->


        <!-- ================== RIGHT CONTENT ================== -->
        <div class="flex-grow-1">

            <!-- ================== TOPBAR (NEW LIKE TEMPLATE) ================== -->
            <div class="d-flex justify-content-between align-items-center p-3 bg-white shadow-sm">
                <h5 class="mb-0" id="current">Admin Dashboard</h5>
                <div class="d-flex align-items-center gap-3">
                    <!-- Search -->
                    <input type="text" class="form-control" placeholder="Search..." style="width:200px;">
                    <!-- User -->
                    <span>{{ auth()->user()->name ?? 'Admin' }}</span>
                </div>
            </div>

            <!-- ================== MAIN CONTENT ================== -->
            <div class="container-fluid p-4">

                {{-- @if (auth()->user() && auth()->user()->user_type == 'Admin') --}}
                @yield('admin-content')
                {{-- @else
                    <div class="text-center py-5">
                        <h3 style="color:red;">
                            <i class="bi bi-exclamation-circle"></i>
                            Admin login required
                        </h3>
                    </div>
                @endif --}}

            </div>
        </div>
        <!-- ================== END CONTENT ================== -->
    </div>
    <!-- ================== END MAIN WRAPPER ================== -->

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
                            <a href="{{ url('Admin/AdminDashboard') }}">
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
    <script>
        $(document).ready(function() {
            let title = window.location.pathname.split('/').filter(Boolean).pop();
            if (title == "AdminDashboard") {
                title = "Admin Dashboard";
            }
            document.getElementById('current').innerHTML = title;
        });
    </script>
</body>


<!-- Mirrored from thememxpro.com/demo/medizen/Admin/AdminDashboard.php by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 17 Feb 2026 14:10:12 GMT -->

</html>
