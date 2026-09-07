@extends('patient.PatientLayout')

@section('patient-content')

<div class="container my-5 min-vh-100">

    <div class="mb-4">
        <h2 class="black mb-2">
            My Appointments
        </h2>

        <p class="pra mb-0">
            View your booked appointments and their current status.
        </p>
    </div>


    @if ($appointments->isEmpty())

        <div class="bg-white rounded-4 shadow-sm p-5 text-center">

            <h4 class="black mb-2">
                No Appointments Yet
            </h4>

            <p class="pra mb-4">
                You have not booked any appointments.
            </p>

            <a
                href="{{ url('/doctors') }}"
                class="common-btn box-style p2-bg
                       d-inline-flex justify-content-center
                       align-items-center gap-2
                       fs18 fw-semibold white
                       overflow-hidden rounded100"
            >
                Find a Doctor
            </a>

        </div>

    @else

        <div class="row g-4">

            @foreach ($appointments as $appointment)

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


                <div class="col-lg-6">

                    <div class="bg-white rounded-4 shadow-sm p-4 h-100">

                        {{-- Header --}}
                        <div class="d-flex justify-content-between
                                    align-items-start gap-3 mb-3">

                            <div>

                                <h4 class="black mb-1">
                                    {{ $doctorUser?->name ?? 'Doctor unavailable' }}
                                </h4>

                                <p class="pra mb-0">
                                    {{ $specialization?->name ?? 'N/A' }}
                                </p>

                            </div>


                            {{-- Status --}}
                            @switch($appointment->status)

                                @case('Pending')
                                    <span class="badge bg-warning text-dark">
                                        Pending
                                    </span>
                                    @break

                                @case('Confirmed')
                                    <span class="badge bg-success">
                                        Confirmed
                                    </span>
                                    @break

                                @case('Rejected')
                                    <span class="badge bg-danger">
                                        Rejected
                                    </span>
                                    @break

                                @case('Cancelled')
                                    <span class="badge bg-secondary">
                                        Cancelled
                                    </span>
                                    @break

                                @case('Completed')
                                    <span class="badge bg-primary">
                                        Completed
                                    </span>
                                    @break

                                @case('NoShow')
                                    <span class="badge bg-dark">
                                        No Show
                                    </span>
                                    @break

                            @endswitch

                        </div>


                        <hr>


                        <p class="mb-2">

                            <strong>
                                Appointment No:
                            </strong>

                            {{ $appointment->appointment_number }}

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


                        <p class="mb-3">

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


                        <a
                            href="{{ route(
                                'patient.appointments.show',
                                $appointment->id
                            ) }}"
                            class="common-btn box-style p2-bg
                                   d-inline-flex justify-content-center
                                   align-items-center
                                   fs16 fw-semibold white
                                   overflow-hidden rounded100"
                            style="padding: 9px 18px;"
                        >
                            View Details
                        </a>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection