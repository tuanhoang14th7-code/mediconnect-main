@extends('admin/AdminLayout')

@section('admin-content')
    <!--Appointment Section Start -->
    <section class="appointment-section fix cmn-bg my-4">
        <div class="container">
            <div class="appointment-wrapper position-relative d-center w-100">
                <div class="row gx-0 gy-5">
                    <div class="col-lg-8">
                        <div class="section-title">
                            <h2 class="wow fadeInUp black" data-wow-delay=".3s">
                                <span class="position-relative z-1 w-100">
                                    New Doctor Registration
                                    <img src="{{ asset('assets/img/element/title-badge1.png') }}" style="bottom: -25px;"
                                        alt="img" class="title-badge1 d-md-block d-none w-100">
                                </span>
                            </h2>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ url('Admin/RegisterThisDoctorNow') }}" method="post" enctype="multipart/form-data"
                            class="appointment-forms">
                            @csrf
                            <input type="hidden" id="userType" value="Doctor" name="userType">
                            <div class="row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <input type="text" name="name" id="name" placeholder="Your Name" required>
                                </div>
                                <div class="col-lg-12">
                                    <input type="email" name="email" id="email" placeholder="Your Email" required>
                                </div>
                                <div class="col-lg-12">
                                    <input type="tel" name="number" id="number" pattern="[0-9]{10}" maxlength="10"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        placeholder="Your Mobile Number" required>
                                </div>
                                <div class="col-lg-12">
                                    <input type="password" name="password" id="password" placeholder="Make Your Password"
                                        required>
                                </div>

                                <div class="col-lg-12">
                                    <button type="submit"
                                        class="common-btn box-style p2-bg w-100 text-nowrap d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold white overflow-hidden rounded100 wow fadeInRight"
                                        data-wow-delay="0.8s">
                                        Register
                                        <img src="{{ asset('assets/img/icon/arrow-right-white.png') }}" alt="icon">
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
