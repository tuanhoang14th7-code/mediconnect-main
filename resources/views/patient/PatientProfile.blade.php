@extends('patient.PatientLayout')

@section('patient-content')

    <div class="container my-5">

        {{-- Success message --}}
        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="bg-white rounded-4 p-4 shadow-sm">

                    {{-- Profile header --}}
                    <div class="text-center mb-4">

                        @if ($user->profile_picture)

                            <img
                                src="{{ asset('storage/' . $user->profile_picture) }}"
                                alt="{{ $user->name }}"
                                style="
                                    width: 130px;
                                    height: 130px;
                                    object-fit: cover;
                                    border-radius: 50%;
                                "
                            >

                        @else

                            <div
                                class="d-flex align-items-center justify-content-center mx-auto"
                                style="
                                    width: 130px;
                                    height: 130px;
                                    border-radius: 50%;
                                    background: #eeeeee;
                                    font-size: 45px;
                                "
                            >
                                <i class="fas fa-user"></i>
                            </div>

                        @endif

                        <h3 class="black mt-3 mb-1">
                            {{ $user->name }}
                        </h3>

                        <p class="pra mb-0">
                            Patient
                        </p>

                    </div>


                    {{-- Patient Information --}}
                    <ul class="doctor-professional">

                        <li class="d-flex align-items-center">
                            <span class="names shift-colon">
                                Name
                            </span>

                            <span class="pra ms-3 fw-bold">
                                {{ $user->name }}
                            </span>
                        </li>


                        <li class="d-flex align-items-center">
                            <span class="names shift-colon">
                                Email
                            </span>

                            <span class="pra ms-3 fw-bold">
                                {{ $user->email }}
                            </span>
                        </li>


                        <li class="d-flex align-items-center">
                            <span class="names shift-colon">
                                Phone
                            </span>

                            <span class="pra ms-3 fw-bold">
                                {{ $user->number }}
                            </span>
                        </li>


                        <li class="d-flex align-items-center">
                            <span class="names shift-colon">
                                Address
                            </span>

                            <span class="pra ms-3 fw-bold">
                                {{ $user->address }}
                            </span>
                        </li>


                        <li class="d-flex align-items-center">
                            <span class="names shift-colon">
                                Date of Birth
                            </span>

                            <span class="pra ms-3 fw-bold">
                                {{ $user->date_of_birth
                                    ? $user->date_of_birth->format('d/m/Y')
                                    : 'Not provided' }}
                            </span>
                        </li>


                        <li class="d-flex align-items-center">
                            <span class="names shift-colon">
                                Gender
                            </span>

                            <span class="pra ms-3 fw-bold">
                                {{ $user->gender ?? 'Not provided' }}
                            </span>
                        </li>

                    </ul>


                    {{-- Actions --}}
                    <div class="mt-4">

                        <a
                            href="{{ url('Patient/EditProfile') }}"
                            class="common-btn box-style p2-bg
                                   d-inline-flex justify-content-center
                                   align-items-center gap-2
                                   fs18 fw-semibold white
                                   overflow-hidden rounded100"
                        >
                            Edit Profile

                            <img
                                src="{{ asset('assets/img/icon/arrow-right-white.png') }}"
                                alt="icon"
                            >
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection