@extends('layout')

@section('main-content')
    <!--Appointment Section Start -->
    <section class="appointment-section fix cmn-bg my-5">
        <div class="container">
            <div class="appointment-wrapper position-relative d-center w-100">
                <div class="row gx-0 gy-5">
                    <div class="col-lg-8">
                        <div class="section-title">
                            <h2 class="wow fadeInUp black" data-wow-delay=".3s">
                                <span class="position-relative z-1 w-100">
                                    Login
                                    <img src="{{ asset('assets/img/element/title-badge1.png') }}" alt="img"
                                        class="title-badge1 d-md-block d-none w-100">
                                </span>
                            </h2>
                        </div>
                        @if (session('loginFail'))
                            <div id="loginFail" class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-square-fill me-3"></i>
                                <div>{{ session('loginFail') }}</div>
                            </div>
                        @endif
                        @if (session('success'))
                            <div id="passwordReset" class="alert alert-success d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-square-fill me-3"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ url('loginNow') }}" method="post" class="appointment-forms">
                            @csrf
                            <div class="row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <input type="email"
                                        name="email"
                                        id="email"
                                        value="{{ old('email') }}"
                                        placeholder="Your Email"
                                        required>
                                </div>
                                <div class="col-lg-12">
                                    <input type="password" name="password" id="password" placeholder="Your Password"
                                        required>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit"
                                        class="common-btn box-style p2-bg w-100 text-nowrap d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold white overflow-hidden rounded100 wow fadeInRight"
                                        data-wow-delay="0.8s">
                                        Login
                                        <img src="{{ asset('assets/img/icon/arrow-right-white.png') }}" alt="icon">
                                    </button>
                                </div>
                                <a href="/forgot-password">Forgot Password?</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
