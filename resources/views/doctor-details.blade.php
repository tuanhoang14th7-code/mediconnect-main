@extends('layout')

@section('main-content')
    {{-- @if (auth()->user()) --}}

    <!-- Banner Section Start -->
    <section class="breadcrumb-section position-relative fix">
        <div class="container">
            <div
                class="bread-content px-3 d-flex flex-wrap gap-3 align-items-center justify-content-md-between justify-content-center">
                <h2 class="black">Doctor Details</h2>
                <ul class="d-flex align-items-center gap-3">
                    @if (auth()->user() && auth()->user()->user_type == 'Patient')
                        <li><a href="{{ url('Patient/PatientDashboard') }}">Home</a></li>
                    @else
                        <li><a href="{{ url('index') }}">Home</a></li>
                    @endif
                    <li>/</li>
                    <li><a href="{{ url('doctors') }}">Doctor</a></li>
                    <li>/</li>
                    <li>Doctor Details</li>
                </ul>
            </div>
        </div>
        <!-- Bread Ele -->
        <img src="{{ asset('assets/img/about/breadcrumnd-shap.png') }}" alt="img" class="bread-ele">
    </section>
    <!-- === doctor details Section === -->
    <section class="doctor-details-section py-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="doctor-details-wraping">
                        <div class="mb-40">
                            <div class="d-flex justify-content-between">
                                <h2 class="black mb-1">{{ $user->name }}</h2>
                                <form action="{{ url('getAppointment') }}" method="post" class="my-auto">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <button type="submit"
                                        class="common-btn box-style p2-bg text-nowrap d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold white overflow-hidden rounded100 wow fadeInRight my-1 mx-3"
                                        data-wow-delay="0.8s" style="padding: 10px 15px">
                                        Get Appointment
                                        <img src="{{ asset('assets/img/icon/arrow-right-white.png') }}" alt="icon">
                                    </button>
                                </form>
                            </div>
                            <p class="pt-xl-3 pt-2">
                                Medical services are an essential part of our lives, offering care and treatment for
                                various health conditions. Th
                                services encompass a wide range of specialties, including primary care, pediatrics,
                                cardiology, dermatology, and more.
                                Whether it's a routine check-up or a complex surgical procedure, medical professionals
                                work tirelessly to ensure the
                                well-being of their patients Medical services are an essential part of our lives,
                                offering care and treatment for
                                various
                            </p>
                        </div>
                        <ul class="doctor-professional mb-40">
                            <li class="d-flex align-items-center">
                                <span class="names shift-colon">Expertise</span>
                                <span class="pra ms-3">{{ $doctor->expertise }}</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="names shift-colon">Education</span>
                                <span class="pra ms-3">{{ $doctor->education }}</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="names shift-colon">Experience</span>
                                <span class="pra ms-3">{{ $doctor->experience }} Years Of Experience In
                                    Madicine</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="names shift-colon">Profession</span>
                                <span class="pra ms-3">{{ $doctor->profession }}</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="names shift-colon">Available Days</span>
                                <span class="pra ms-3">
                                    @foreach ($doctor->schedules as $schedule)
                                        <span> {{ $schedule->day }} &nbsp;|&nbsp; </span>
                                    @endforeach
                                </span>
                            </li>
                            <li class="d-flex align-items-center">
                                <span class="names shift-colon">Available Time</span>
                                <span class="pra ms-3">
                                    {{ \Carbon\Carbon::parse($doctor->schedules[0]->start_time)->format('h:i A') }} -
                                    {{ \Carbon\Carbon::parse($doctor->schedules[0]->end_time)->format('h:i A') }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-details-right">
                        <div class="details-common pt-3 px-3 pb-4">
                            <div class="thumb rounded-circle m-auto w-100">
                                <img src="{{ asset('upload/doctors/' . $doctor->image) }}" alt="img"
                                    class="rounded-4 w-100">
                            </div>
                            <div class="cont mt-xl-3 mt-2 text-center mb-3">
                                <h4 class="black mb-1">{{ $user->name }}</h4>
                                <span class="pra">{{ $user->email }}</span><br>
                                <span class="pra">+91 {{ $user->number }}</span>
                            </div>
                            <div class="social-wrapper d-flex justify-content-center align-items-center">
                                <a href="#" class=" black"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class=" black"><i class="fab fa-instagram"></i></a>
                                <a href="#" class=" black">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_5855_218)">
                                            <path
                                                d="M8.30314 5.92804L13.4029 0H12.1944L7.7663 5.14724L4.22958 0H0.150391L5.4986 7.78354L0.150391 14H1.35894L6.03514 8.56434L9.77017 14H13.8494L8.30284 5.92804H8.30314ZM6.64787 7.85211L6.10598 7.07705L1.79439 0.909771H3.65065L7.13015 5.88696L7.67204 6.66202L12.195 13.1316H10.3387L6.64787 7.85241V7.85211Z"
                                                fill="#090A0B" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_5855_218">
                                                <rect width="14" height="14" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                                <a href="#" class=" black"><i class="fa-brands fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





    {{-- @else
        <!-- Banner Section Start -->
        <section class="breadcrumb-section position-relative fix">
            <div class="container">
                <div class="bread-content px-3 d-flex flex-wrap gap-3 align-items-center justify-content-md-between justify-content-center"
                    style="padding: 150px 0 130px !important">
                    <h2 class="black">Service</h2>
                    <ul class="d-flex align-items-center gap-3">
                        <li>
                            <a href="{{ url('login') }}" style="color:red">Login</a>
                            &nbsp;OR&nbsp;
                            <a href="{{ url('register') }}" style="color:red">Register</a>
                            &nbsp;To See Doctors Details
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Bread Ele -->
            <img src="{{ asset('assets/img/about/breadcrumnd-shap.png') }}" alt="img" class="bread-ele"
                style="max-width: 280px !important">
        </section>
    @endif --}}
@endsection
