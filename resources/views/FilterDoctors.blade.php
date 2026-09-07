@extends('layout')

@section('main-content')
    <div class="container-fluid mx-3">
        <div class="row my-5">

            <!-- LEFT FILTER -->
            <div id="desktop-filter" class="col-xl-3 d-none d-xl-block pe-3" style="border-right:1px solid #e5e5e5;">

                <div class="p-3 bg-white rounded shadow-sm" style="border:1px solid #eee;">

                    <h4 style="font-weight:600; margin-bottom:15px;">
                        <i class="bi bi-funnel"></i> Filters
                    </h4>

                    <div style="display: flex; gap:15px;" class="mb-2">
                        <form action="{{ url('FilterDoctors') }}" method="get" id="filterForm">
                            <button type="submit" class="btn btn-sm btn-info">Apply filter</button>
                        </form>
                        <a href="{{ url('FilterDoctors') }}" class="btn btn-warning btn-sm">Clear All</a>
                    </div>

                    <!-- SELECTED FILTERS -->
                    <div class="selected-filters" style="margin-bottom:15px;"></div>

                    <!-- Expertise -->
                    <div style="margin-bottom:25px;">
                        <h6 style="font-weight:600; margin-bottom:10px;">Expertise</h6>

                        <!-- class instead of id -->
                        <div class="expertise-list" style="max-height:220px; overflow:hidden; transition:0.3s;">

                            <!-- Visible -->
                            <div class="form-check ms-1" style="margin-bottom:6px;">
                                <input data-type="expertise" class="form-check-input filter-checkbox" type="checkbox"
                                    value="Dermatology">
                                Dermatology
                            </div>
                            <div class="form-check ms-1" style="margin-bottom:6px;">
                                <input data-type="expertise" class="form-check-input filter-checkbox" type="checkbox"
                                    value="Cardiology">
                                Cardiology
                            </div>
                            <div class="form-check ms-1" style="margin-bottom:6px;">
                                <input data-type="expertise" class="form-check-input filter-checkbox" type="checkbox"
                                    value="Dentistry">
                                Dentistry
                            </div>
                            <div class="form-check ms-1" style="margin-bottom:6px;">
                                <input data-type="expertise" class="form-check-input filter-checkbox" type="checkbox"
                                    value="Neurology"> Neurology
                            </div>
                            <div class="form-check ms-1" style="margin-bottom:6px;">
                                <input data-type="expertise" class="form-check-input filter-checkbox" type="checkbox"
                                    value="Orthopedics">
                                Orthopedics
                            </div>

                            <!-- Hidden -->
                            <div class="more-items" style="display:none;">
                                <div class="form-check ms-1"><input data-type="expertise"
                                        class="form-check-input filter-checkbox" type="checkbox" value="Pediatrics">
                                    Pediatrics</div>
                                <div class="form-check ms-1"><input data-type="expertise"
                                        class="form-check-input filter-checkbox" type="checkbox" value="Oncology">
                                    Oncology</div>
                                {{-- <div class="form-check ms-1"><input data-type="expertise"
                                        class="form-check-input filter-checkbox" type="checkbox" value="Cardiac Sciences">
                                    Cardiac Sciences</div>
                                <div class="form-check ms-1"><input data-type="expertise"
                                        class="form-check-input filter-checkbox" type="checkbox" value="Neurologist">
                                    Neurologist</div> --}}
                            </div>

                        </div>

                        <!-- class instead of id -->
                        <button class="toggleMore btn btn-sm btn-link p-0" style="font-size:13px; text-decoration:none;">
                            Show More
                        </button>
                    </div>

                    <!-- Experience -->
                    <div>
                        <h6 style="font-weight:600; margin-bottom:10px;">Experience (Years)</h6>

                        <div class="form-check ms-1">
                            <input data-type="experience" class="form-check-input filter-checkbox" type="checkbox"
                                value="0-5"> 0 - 5
                        </div>
                        <div class="form-check ms-1">
                            <input data-type="experience" class="form-check-input filter-checkbox" type="checkbox"
                                value="6-10"> 6 - 10
                        </div>
                        <div class="form-check ms-1">
                            <input data-type="experience" class="form-check-input filter-checkbox" type="checkbox"
                                value="11-15"> 11 - 15
                        </div>
                        <div class="form-check ms-1">
                            <input data-type="experience" class="form-check-input filter-checkbox" type="checkbox"
                                value="16+"> 16+
                        </div>
                    </div>


                    <!-- Profession -->
                    <div style="margin-bottom:25px;">
                        <h6 style="font-weight:600; margin-bottom:10px;">Profession</h6>
                        <!-- class instead of id -->
                        <div class="profession-list" style="max-height:220px; overflow:hidden; transition:0.3s;">


                            <!-- Visible -->
                            <div class="form-check ms-1" style="margin-bottom:6px;">
                                <input data-type="profession" class="form-check-input filter-checkbox" type="checkbox"
                                    value="Consultant">Consultant
                            </div>
                            <div class="form-check ms-1" style="margin-bottom:6px;">
                                <input data-type="profession" class="form-check-input filter-checkbox" type="checkbox"
                                    value="Dentist">Dentist
                            </div>
                            <div class="form-check ms-1" style="margin-bottom:6px;">
                                <input data-type="profession" class="form-check-input filter-checkbox" type="checkbox"
                                    value="Skin Specialist">Skin Specialist
                            </div>
                            <div class="form-check ms-1" style="margin-bottom:6px;">
                                <input data-type="profession" class="form-check-input filter-checkbox" type="checkbox"
                                    value="Cancer Specialist"> Cancer Specialist
                            </div>
                            <div class="form-check ms-1" style="margin-bottom:6px;">
                                <input data-type="profession" class="form-check-input filter-checkbox" type="checkbox"
                                    value="Child Specialist">Child Specialist
                            </div>

                            <!-- Hidden -->
                            <div class="more-items" style="display:none;">
                                <div class="form-check ms-1"><input data-type="profession"
                                        class="form-check-input filter-checkbox" type="checkbox"
                                        value="Heart Specialist">Heart Specialist
                                </div>
                                <div class="form-check ms-1"><input data-type="profession"
                                        class="form-check-input filter-checkbox" type="checkbox"
                                        value="Weight Loss Specialist">Weight Loss Specialist
                                </div>
                                <div class="form-check ms-1"><input data-type="profession"
                                        class="form-check-input filter-checkbox" type="checkbox" value="Bone Specialist">
                                    Bone Specialist
                                </div>
                                <div class="form-check ms-1"><input data-type="profession"
                                        class="form-check-input filter-checkbox" type="checkbox"
                                        value="Brain Specialist">Brain Specialist
                                </div>
                                {{-- <div class="form-check ms-1"><input data-type="profession"
                                        class="form-check-input filter-checkbox" type="checkbox"
                                        value="Child Specialist"> Child Specialist</div> --}}
                            </div>

                        </div>
                        <button class="toggleMore btn btn-sm btn-link p-0" style="font-size:13px; text-decoration:none;">
                            Show More
                        </button>
                    </div>



                </div>
            </div>

            <!-- RIGHT CONTENT -->
            <div class="col-xl-9">

                <!-- FILTER BUTTON (mobile only) -->
                <div class="header__hamburger d-xl-none my-auto ms-2">
                    <div class="filter__toggle">
                        <h3 class="m-3 btn btn-outline-success">
                            <i class="bi bi-funnel"></i> Filters
                        </h3>
                    </div>
                </div>

                <div class="row">
                    @foreach ($doctors as $d)
                        <div class="col-12 col-md-6 col-xl-6" style="border-right:1px solid #cccaca;">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ asset('upload/doctors/' . $d['image']) }}" class="img-fluid"
                                        alt="logo-img" style="max-height: 200px">
                                </div>
                                <div class="col-8">

                                    <div style="line-height:1.6;">
                                        <h5 style="margin-bottom:5px; font-weight:600;"> {{ $d['name'] }} </h5>
                                        <div style="color:#555;">{{ $d['expertise'] }}</div>
                                        <div style="color:#555;">{{ $d['profession'] }}</div>
                                        <div style="color:#777;">{{ $d['experience'] }} Years Experience</div>
                                        <div style="color:#555;">{{ $d['education'] }}</div>
                                        <div style="color:#777;">
                                            Available Day:
                                            <span style="color:#28a745; font-weight:500;">
                                                @foreach ($d['days'] as $day)
                                                    {{ substr($day, 0, 3) . ',  ' }}
                                                @endforeach
                                            </span>
                                        </div>
                                        <div style="color:#777;">
                                            Available Time:
                                            <span style="color:#28a745; font-weight:500;">
                                                {{ \Carbon\Carbon::parse($d['start_time'])->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::parse($d['end_time'])->format('h:i A') }}
                                            </span>
                                        </div>

                                    </div>
                                    <form action="getAppointment" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $d['id'] }}">
                                        <button type="submit"
                                            class="common-btn box-style p2-bg text-nowrap d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold white overflow-hidden rounded100 wow fadeInRight my-1 mx-3"
                                            data-wow-delay="0.8s" style="padding: 10px 15px">
                                            Book An Appointment
                                            <img src="{{ asset('assets/img/icon/arrow-right-white.png') }}"
                                                alt="icon">
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <hr class="my-4">
                        </div>
                    @endforeach
                </div>

                {{-- {{ $users->links() }} --}}

            </div>

        </div>
    </div>
@endsection
