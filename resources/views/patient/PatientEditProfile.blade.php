@extends('patient.PatientLayout')

@section('patient-content')
    <div class="container mt-5">
        <div class="appointment-wrapper position-relative d-center w-100">
            <div class="row gx-0 gy-5">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2 class="wow fadeInUp black" data-wow-delay=".3s">
                            <span class="position-relative z-1 w-100">
                                Edit Profile Info
                                <img src="{{ asset('assets/img/element/title-badge1.png') }}" style="bottom: -8px;"
                                    alt="img" class="title-badge1 d-md-block d-none w-100">
                            </span>
                        </h2>
                    </div>
                    <form
                        action="{{ url('Patient/EditProfile') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="appointment-forms"
                    >

                        @csrf


                        {{-- Validation Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">

                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach

                                </ul>
                            </div>
                        @endif


                        <div class="row g-lg-3 g-3">

                            {{-- Name --}}
                            <div class="col-lg-12">

                                <label class="mb-2">
                                    Full Name
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name', $user->name) }}"
                                    placeholder="Your Name"
                                    required
                                >

                            </div>


                            {{-- Address --}}
                            <div class="col-lg-12">

                                <label class="mb-2">
                                    Address
                                </label>

                                <input
                                    type="text"
                                    name="address"
                                    id="address"
                                    value="{{ old('address', $user->address) }}"
                                    placeholder="Your Address"
                                    required
                                >

                            </div>


                            {{-- Email --}}
                            <div class="col-lg-12">

                                <label class="mb-2">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email', $user->email) }}"
                                    placeholder="Your Email"
                                    required
                                >

                            </div>


                            {{-- Phone --}}
                            <div class="col-lg-12">

                                <label class="mb-2">
                                    Phone Number
                                </label>

                                <input
                                    type="tel"
                                    name="number"
                                    id="number"
                                    value="{{ old('number', $user->number) }}"
                                    maxlength="20"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    placeholder="Your Mobile Number"
                                    required
                                >

                            </div>


                            {{-- Date of Birth --}}
                            <div class="col-lg-6">

                                <label class="mb-2">
                                    Date of Birth
                                </label>

                                <input
                                    type="date"
                                    name="date_of_birth"
                                    id="date_of_birth"
                                    value="{{ old(
                                        'date_of_birth',
                                        $user->date_of_birth
                                            ? $user->date_of_birth->format('Y-m-d')
                                            : ''
                                    ) }}"
                                >

                            </div>


                            {{-- Gender --}}
                            <div class="col-lg-6">

                                <label class="mb-2">
                                    Gender
                                </label>

                                <select
                                    name="gender"
                                    id="gender"
                                >

                                    <option value="" disabled
                                        {{ old('gender', $user->gender) ? '' : 'selected' }}>
                                        Select Gender
                                    </option>

                                    <option
                                        value="Male"
                                        {{ old('gender', $user->gender) === 'Male'
                                            ? 'selected'
                                            : '' }}
                                    >
                                        Male
                                    </option>

                                    <option
                                        value="Female"
                                        {{ old('gender', $user->gender) === 'Female'
                                            ? 'selected'
                                            : '' }}
                                    >
                                        Female
                                    </option>

                                    <option
                                        value="Other"
                                        {{ old('gender', $user->gender) === 'Other'
                                            ? 'selected'
                                            : '' }}
                                    >
                                        Other
                                    </option>

                                    <option
                                        value="Prefer not to say"
                                        {{ old('gender', $user->gender) === 'Prefer not to say'
                                            ? 'selected'
                                            : '' }}
                                    >
                                        Prefer not to say
                                    </option>

                                </select>

                            </div>


                            {{-- Profile Picture --}}
                            <div class="col-lg-12">

                                <label class="mb-2">
                                    Profile Picture
                                </label>

                                <input
                                    type="file"
                                    name="profile_picture"
                                    id="profile_picture"
                                    accept=".jpg,.jpeg,.png,.webp"
                                >

                                <small class="text-muted">
                                    JPG, JPEG, PNG or WEBP. Maximum 2 MB.
                                </small>

                            </div>


                            {{-- Current Picture --}}
                            @if ($user->profile_picture)

                                <div class="col-lg-12">

                                    <p class="mb-2">
                                        Current Picture
                                    </p>

                                    <img
                                        src="{{ asset('storage/' . $user->profile_picture) }}"
                                        alt="Profile Picture"
                                        style="
                                            width: 100px;
                                            height: 100px;
                                            object-fit: cover;
                                            border-radius: 50%;
                                        "
                                    >

                                </div>

                            @endif


                            {{-- Save --}}
                            <div class="col-lg-12">

                                <button
                                    type="submit"
                                    class="common-btn box-style p2-bg w-100
                                        text-nowrap d-inline-flex
                                        justify-content-center align-items-center
                                        gap-xxl-2 gap-2 fs18 fw-semibold
                                        white overflow-hidden rounded100"
                                >

                                    Save Changes

                                    <img
                                        src="{{ asset('assets/img/icon/arrow-right-white.png') }}"
                                        alt="icon"
                                    >

                                </button>

                            </div>

                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
