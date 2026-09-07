@extends('layout')

@section('main-content')
    <!-- Banner Section Start -->
    <section class="breadcrumb-section position-relative fix">
        <div class="container">
            <div
                class="bread-content px-3 d-flex flex-wrap gap-3 align-items-center justify-content-md-between justify-content-center">
                <h2 class="black">Contact Details</h2>
                <ul class="d-flex align-items-center gap-3">
                    @if (auth()->user() && auth()->user()->user_type == 'Patient')
                        <li><a href="{{ url('Patient/PatientDashboard') }}">Home</a></li>
                    @else
                        <li><a href="{{ url('index') }}">Home</a></li>
                    @endif
                    <li>/</li>
                    <li>Contact Details</li>
                </ul>
            </div>
        </div>
        <!-- Bread Ele -->
        <img src="{{ asset('assets/img/about/breadcrumnd-shap.png') }}" alt="img" class="bread-ele">
    </section>
    <!-- Banner Section Start -->


    <!-- Contact Section Start -->
    <section class="contact-section section-padding fix">
        <div class="container">
            <div class="space-bottom">
                <div class="row g-xl-6 g-4 contact-info-area">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="contact-info wow fadeInUp" data-wow-delay="0.6s">
                            <div class="icon"><i class="fa-solid fa-location-dot"></i></div>
                            <div class="cont">
                                <h4 class="fw-bold black d-block mb-1">Address</h4>
                                <a href="mailto:Company@mail.com" class="pra fs-seven">Mirpur,10 Road 1 House 12
                                    Mirpur
                                    Dhaka Bangladesh</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="contact-info wow fadeInUp" data-wow-delay="0.6s">
                            <div class="icon"><i class="fa-solid fa-envelope"></i></div>
                            <div class="cont">
                                <h4 class="fw-bold black d-block mb-1">Email</h4>
                                <a href="mailto:Company@mail.com" class="pra fs-seven">
                                    chirsbekham12@gmail.com <br>
                                    simmons12@gmail.com
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="contact-info wow fadeInUp" data-wow-delay="0.6s">
                            <div class="icon"><i class="fa-solid fa-phone"></i></div>
                            <div class="cont">
                                <h4 class="fw-bold black d-block mb-1">Phone</h4>
                                <a href="mailto:Company@mail.com" class="pra fs-seven">
                                    017 5552-0127 <br>
                                    017458632718
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- Contact Form --}}
    <section class="pb-5">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-lg-9">

                    <div class="bg-white
                                rounded-4
                                shadow-sm
                                p-4
                                p-lg-5">

                        <div class="text-center mb-4">

                            <h2 class="black mb-2">
                                Contact Us
                            </h2>

                            <p class="pra mb-0">
                                Have a question?
                                Send us a message and we will
                                get back to you.
                            </p>

                        </div>


                        {{-- Success Message --}}
                        @if (session('success'))

                            <div class="alert alert-success">

                                {{ session('success') }}

                            </div>

                        @endif


                        {{-- Validation Errors --}}
                        @if ($errors->any())

                            <div class="alert alert-danger">

                                <ul class="mb-0">

                                    @foreach ($errors->all() as $error)

                                        <li>
                                            {{ $error }}
                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif


                        <form
                            action="{{ route('contact.store') }}"
                            method="POST"
                        >

                            @csrf


                            <div class="row g-4">

                                {{-- Name --}}
                                <div class="col-md-6">

                                    <label
                                        for="name"
                                        class="fw-semibold mb-2"
                                    >
                                        Name
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        class="form-control"
                                        value="{{ old(
                                            'name',
                                            auth()->check()
                                                ? auth()->user()->name
                                                : ''
                                        ) }}"
                                        placeholder="Enter your name"
                                        required
                                    >

                                </div>


                                {{-- Email --}}
                                <div class="col-md-6">

                                    <label
                                        for="email"
                                        class="fw-semibold mb-2"
                                    >
                                        Email
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        class="form-control"
                                        value="{{ old(
                                            'email',
                                            auth()->check()
                                                ? auth()->user()->email
                                                : ''
                                        ) }}"
                                        placeholder="Enter your email"
                                        required
                                    >

                                </div>


                                {{-- Phone --}}
                                <div class="col-md-6">

                                    <label
                                        for="phone"
                                        class="fw-semibold mb-2"
                                    >
                                        Phone
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="phone"
                                        id="phone"
                                        class="form-control"
                                        value="{{ old(
                                            'phone',
                                            auth()->check()
                                                ? auth()->user()->number
                                                : ''
                                        ) }}"
                                        placeholder="Enter your phone number"
                                        required
                                    >

                                </div>


                                {{-- Subject --}}
                                <div class="col-md-6">

                                    <label
                                        for="subject"
                                        class="fw-semibold mb-2"
                                    >
                                        Subject
                                    </label>

                                    <input
                                        type="text"
                                        name="subject"
                                        id="subject"
                                        class="form-control"
                                        value="{{ old('subject') }}"
                                        placeholder="Enter subject"
                                    >

                                </div>


                                {{-- Message --}}
                                <div class="col-12">

                                    <label
                                        for="message"
                                        class="fw-semibold mb-2"
                                    >
                                        Message
                                        <span class="text-danger">*</span>
                                    </label>

                                    <textarea
                                        name="message"
                                        id="message"
                                        rows="6"
                                        class="form-control"
                                        maxlength="2000"
                                        placeholder="Enter your message"
                                        required
                                    >{{ old('message') }}</textarea>

                                    <small class="text-muted">
                                        Maximum 2000 characters.
                                    </small>

                                </div>


                                {{-- Submit --}}
                                <div class="col-12 text-center">

                                    <button
                                        type="submit"
                                        class="common-btn
                                            box-style
                                            p2-bg
                                            d-inline-flex
                                            justify-content-center
                                            align-items-center
                                            fs16
                                            fw-semibold
                                            white
                                            overflow-hidden
                                            rounded100"
                                        style="
                                            padding: 12px 35px;
                                            min-width: 180px;
                                        "
                                    >
                                        Send Message
                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- Map -->
    <div class="space-bottom">
        <div class="map-area">
            <div class="container">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d52816169.558200695!2d-161.49265223136007!3d36.102185713814805!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited%20States!5e0!3m2!1sen!2sbd!4v1726005337075!5m2!1sen!2sbd"
                    style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
    <!-- Map -->
@endsection
