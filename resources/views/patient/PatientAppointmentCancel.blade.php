@extends('patient.PatientLayout')

@section('patient-content')

@php

    $assignment =
        $appointment->doctorAssignment;

    $doctor =
        $assignment?->doctor;

    $doctorUser =
        $doctor?->user;

    $facilitySpecialization =
        $assignment?->facilitySpecialization;

    $facility =
        $facilitySpecialization?->facility;

    $specialization =
        $facilitySpecialization?->specialization;

@endphp


<div class="container my-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="bg-white rounded-4 shadow-sm p-4">

                <div class="mb-4">

                    <h2 class="black mb-2">
                        Cancel Appointment
                    </h2>

                    <p class="pra mb-0">
                        Please review the appointment and provide
                        a reason for cancellation.
                    </p>

                </div>


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


                {{-- Appointment information --}}
                <div class="border rounded-4 p-4 mb-4">

                    <h5 class="black mb-3">
                        Appointment Information
                    </h5>


                    <p class="mb-2">

                        <strong>
                            Appointment Number:
                        </strong>

                        {{ $appointment->appointment_number }}

                    </p>


                    <p class="mb-2">

                        <strong>
                            Doctor:
                        </strong>

                        {{ $doctorUser?->name ?? 'N/A' }}

                    </p>


                    <p class="mb-2">

                        <strong>
                            Specialization:
                        </strong>

                        {{ $specialization?->name ?? 'N/A' }}

                    </p>


                    <p class="mb-2">

                        <strong>
                            Facility:
                        </strong>

                        {{ $facility?->name ?? 'N/A' }}

                    </p>


                    <p class="mb-2">

                        <strong>
                            Date:
                        </strong>

                        {{ $appointment->appointment_date
                            ->format('d/m/Y') }}

                    </p>


                    <p class="mb-0">

                        <strong>
                            Time:
                        </strong>

                        {{ \Carbon\Carbon::parse(
                            $appointment->start_time
                        )->format('H:i') }}

                        -

                        {{ \Carbon\Carbon::parse(
                            $appointment->end_time
                        )->format('H:i') }}

                    </p>

                </div>


                <form
                    action="{{ route(
                        'patient.appointments.cancel.update',
                        $appointment->id
                    ) }}"
                    method="POST"
                >

                    @csrf


                    <div class="mb-4">

                        <label
                            for="cancellation_reason"
                            class="fw-semibold mb-2"
                        >
                            Cancellation Reason
                            <span class="text-danger">*</span>
                        </label>


                        <textarea
                            name="cancellation_reason"
                            id="cancellation_reason"
                            rows="4"
                            class="form-control"
                            maxlength="500"
                            placeholder="Please enter your reason for cancelling this appointment"
                            required
                        >{{ old('cancellation_reason') }}</textarea>


                        <small class="text-muted">
                            Maximum 500 characters.
                        </small>

                    </div>


                    <div class="alert alert-warning">

                        Cancelling this appointment will release
                        the selected time slot for other patients.

                    </div>


                    <div class="d-flex gap-3">

                        <a
                            href="{{ route(
                                'patient.appointments.show',
                                $appointment->id
                            ) }}"
                            class="btn btn-outline-secondary
                                   rounded-pill px-4"
                        >
                            Back
                        </a>


                        <button
                            type="submit"
                            class="btn btn-danger
                                   rounded-pill
                                   flex-grow-1"
                        >
                            Confirm Cancellation
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection