@extends('layout')

@section('main-content')
    <div class="container my-5 h-100">
        <div class="appointment-wrapper position-relative d-center w-100">
            <div style="height: 750px">
                <p style="color:red;border:2px solid black;margin:10px;">This site run locally. (Not from a remote server)
                    So, the reset link will be working in same system only.</p>
                <form method="POST" action="/forgot-password" class="appointment-forms">
                    @csrf
                    <div class="row g-lg-3 g-3">
                        <div class="col-lg-12">
                            <input type="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit"
                                class="common-btn box-style p2-bg w-100 text-nowrap d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold white overflow-hidden rounded100 wow fadeInRight"
                                data-wow-delay="0.8s">
                                Send Reset Link
                                <img src="{{ asset('assets/img/icon/arrow-right-white.png') }}" alt="icon">
                            </button>
                        </div>
                    </div>
                    <div class="my-2">
                        @if (session('status'))
                            {{ session('status') }}
                        @endif
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
