@extends('patient.PatientLayout')

@section('patient-content')

@php

    $assignment =
        $slot->doctorAssignment;

    $doctor =
        $assignment->doctor;

    $doctorUser =
        $doctor->user;

    $facilitySpecialization =
        $assignment->facilitySpecialization;

    $facility =
        $facilitySpecialization->facility;

    $specialization =
        $facilitySpecialization->specialization;

@endphp


<div class="container my-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="bg-white rounded-4 shadow-sm p-4">

                <div class="mb-4">

                    <h2 class="black mb-2">
                        Confirm Appointment
                    </h2>

                    <p class="pra mb-0">
                        Please review your appointment
                        information before booking.
                    </p>

                </div>


                {{-- Validation --}}
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


                {{-- Doctor Information --}}
                <div class="border rounded-4 p-4 mb-4">

                    <h5 class="black mb-3">
                        Doctor Information
                    </h5>

                    <p class="mb-2">

                        <strong>
                            Doctor:
                        </strong>

                        {{ $doctorUser->name }}

                    </p>

                    <p class="mb-2">

                        <strong>
                            Specialization:
                        </strong>

                        {{ $specialization->name }}

                    </p>

                    <p class="mb-2">

                        <strong>
                            Facility:
                        </strong>

                        {{ $facility->name }}

                    </p>

                    <p class="mb-2">

                        <strong>
                            Address:
                        </strong>

                        {{ $facility->address }}

                    </p>

                    <p class="mb-2">

                        <strong>
                            Room:
                        </strong>

                        {{ $assignment->room_number ?? 'Not assigned' }}

                    </p>

                    <p class="mb-0">

                        <strong>
                            Consultation Fee:
                        </strong>

                        {{ number_format(
                            $assignment->consultation_fee,
                            0
                        ) }}
                        VND

                    </p>

                </div>


                {{-- Appointment Information --}}
                <div class="border rounded-4 p-4 mb-4">

                    <h5 class="black mb-3">
                        Appointment Time
                    </h5>

                    <p class="mb-2">

                        <strong>
                            Date:
                        </strong>

                        {{ $slot->slot_date->format('d/m/Y') }}

                    </p>

                    <p class="mb-0">

                        <strong>
                            Time:
                        </strong>

                        {{ \Carbon\Carbon::parse(
                            $slot->start_time
                        )->format('H:i') }}

                        -

                        {{ \Carbon\Carbon::parse(
                            $slot->end_time
                        )->format('H:i') }}

                    </p>

                </div>


                {{-- Patient Information --}}
                <div class="border rounded-4 p-4 mb-4">

                    <h5 class="black mb-3">
                        Patient Information
                    </h5>

                    <p class="mb-2">

                        <strong>Name:</strong>

                        {{ $user->name }}

                    </p>

                    <p class="mb-2">

                        <strong>Email:</strong>

                        {{ $user->email }}

                    </p>

                    <p class="mb-0">

                        <strong>Phone:</strong>

                        {{ $user->number }}

                    </p>

                </div>


                {{-- Booking Form --}}
                <form
                    action="{{ route(
                        'patient.appointment.store'
                    ) }}"
                    method="POST"
                >

                    @csrf


                    <input
                        type="hidden"
                        name="slot_id"
                        value="{{ $slot->id }}"
                    >


                    {{-- Examination Reason --}}
                    <div class="mb-4">

                        <label
                            for="examination_reason"
                            class="fw-semibold mb-2"
                        >
                            Examination Reason
                        </label>

                        <textarea
                            name="examination_reason"
                            id="examination_reason"
                            rows="3"
                            class="form-control"
                            placeholder="Reason for your appointment"
                        >{{ old('examination_reason') }}</textarea>

                    </div>


                    {{-- Symptoms --}}
                    <div class="mb-4">

                        <label
                            for="symptoms"
                            class="fw-semibold mb-2"
                        >
                            Symptoms
                        </label>

                        <textarea
                            name="symptoms"
                            id="symptoms"
                            rows="3"
                            class="form-control"
                            placeholder="Describe your symptoms if any"
                        >{{ old('symptoms') }}</textarea>

                    </div>


                    <div class="d-flex gap-3">

                        <a
                            href="{{ url(
                                '/doctors/' .
                                $assignment->id
                            ) }}"
                            class="btn btn-outline-secondary
                                   rounded-pill px-4"
                        >
                            Back
                        </a>


                        <button
                            type="submit"
                            class="common-btn box-style p2-bg
                                   flex-grow-1
                                   d-inline-flex
                                   justify-content-center
                                   align-items-center
                                   fs18 fw-semibold white
                                   overflow-hidden rounded100"
                        >
                            Confirm Booking
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection