@extends('patient.PatientLayout')

@section('patient-content')

@php

    $assignment =
        $appointment->doctorAssignment;

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
                        Reschedule Appointment
                    </h2>

                    <p class="pra mb-0">
                        Select a new available date and time.
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


                {{-- Current Appointment --}}
                <div class="border rounded-4 p-4 mb-4">

                    <h5 class="black mb-3">
                        Current Appointment
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
                            Current Date:
                        </strong>

                        {{ $appointment->appointment_date
                            ->format('d/m/Y') }}

                    </p>

                    <p class="mb-0">

                        <strong>
                            Current Time:
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
                        'patient.appointments.reschedule.update',
                        $appointment->id
                    ) }}"
                    method="POST"
                >

                    @csrf


                    {{-- New Date --}}
                    <div class="mb-4">

                        <label
                            for="new_appointment_date"
                            class="fw-semibold mb-2"
                        >
                            New Appointment Date
                        </label>

                        <select
                            id="new_appointment_date"
                            class="appointment-date-select"
                        >

                            <option
                                value=""
                                disabled
                                selected
                            >
                                Select Date
                            </option>

                        </select>

                    </div>


                    {{-- New Time --}}
                    <div class="mb-4">

                        <label class="fw-semibold mb-2">
                            New Appointment Time
                        </label>

                        <div
                            id="new-available-slots"
                            class="d-flex flex-wrap gap-2"
                        >

                            <span class="text-muted">
                                Select a date first.
                            </span>

                        </div>

                    </div>


                    <input
                        type="hidden"
                        name="slot_id"
                        id="new_slot_id"
                        value=""
                    >


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
                            id="confirm-reschedule"
                            class="common-btn box-style p2-bg
                                   flex-grow-1
                                   d-inline-flex
                                   justify-content-center
                                   align-items-center
                                   fs18 fw-semibold white
                                   overflow-hidden rounded100"
                            disabled
                        >
                            Confirm Reschedule
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const assignmentId =
        {{ $appointment->doctor_assignment_id }};

    const dateSelect =
        document.getElementById(
            'new_appointment_date'
        );

    const slotsContainer =
        document.getElementById(
            'new-available-slots'
        );

    const selectedSlotInput =
        document.getElementById(
            'new_slot_id'
        );

    const confirmButton =
        document.getElementById(
            'confirm-reschedule'
        );


    function refreshDateSelect() {

        if (
            window.jQuery &&
            jQuery.fn.niceSelect
        ) {

            $('#new_appointment_date')
                .niceSelect('update');
        }
    }


    // =========================
    // LOAD AVAILABLE DATES
    // =========================
    async function loadAvailableDates() {

        try {

            const response = await fetch(
                `/doctors/${assignmentId}/available-dates`
            );

            const dates =
                await response.json();


            if (dates.length === 0) {

                dateSelect.innerHTML = `
                    <option value="">
                        No available dates
                    </option>
                `;

                dateSelect.disabled = true;

                refreshDateSelect();

                slotsContainer.innerHTML = `
                    <div class="alert alert-info w-100 mb-0">
                        No alternative appointment slots are currently available.
                    </div>
                `;

                return;
            }


            dateSelect.innerHTML = `
                <option value="" disabled selected>
                    Select Date
                </option>
            `;


            dates.forEach(function (date) {

                const formattedDate =
                    new Date(
                        date + 'T00:00:00'
                    )
                    .toLocaleDateString(
                        'en-GB',
                        {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        }
                    );


                dateSelect.innerHTML += `
                    <option value="${date}">
                        ${formattedDate}
                    </option>
                `;
            });


            refreshDateSelect();

        } catch (error) {

            slotsContainer.innerHTML = `
                <div class="alert alert-danger w-100 mb-0">
                    Unable to load available dates.
                </div>
            `;
        }
    }


    // =========================
    // DATE CHANGE
    // =========================
    $('#new_appointment_date').on(
        'change',
        async function () {

            const selectedDate =
                $(this).val();


            selectedSlotInput.value = '';

            confirmButton.disabled = true;


            if (!selectedDate) {

                slotsContainer.innerHTML = `
                    <span class="text-muted">
                        Select a date first.
                    </span>
                `;

                return;
            }


            slotsContainer.innerHTML = `
                <span class="text-muted">
                    Loading available slots...
                </span>
            `;


            try {

                const response = await fetch(
                    `/doctors/${assignmentId}/slots?date=${selectedDate}`
                );


                if (!response.ok) {
                    throw new Error(
                        'Unable to load slots'
                    );
                }


                const slots =
                    await response.json();


                if (slots.length === 0) {

                    slotsContainer.innerHTML = `
                        <div class="alert alert-info w-100 mb-0">
                            No available slots for this date.
                        </div>
                    `;

                    return;
                }


                slotsContainer.innerHTML = '';


                slots.forEach(function (slot) {

                    const button =
                        document.createElement(
                            'button'
                        );


                    button.type =
                        'button';


                    button.className =
                        'appointment-slot-btn';


                    button.dataset.slotId =
                        slot.id;


                    button.textContent =
                        `${slot.start_time} - ${slot.end_time}`;


                    button.addEventListener(
                        'click',
                        function () {

                            document
                                .querySelectorAll(
                                    '.appointment-slot-btn'
                                )
                                .forEach(
                                    function (item) {

                                        item.classList
                                            .remove(
                                                'selected'
                                            );
                                    }
                                );


                            this.classList.add(
                                'selected'
                            );


                            selectedSlotInput.value =
                                this.dataset.slotId;


                            confirmButton.disabled =
                                false;
                        }
                    );


                    slotsContainer.appendChild(
                        button
                    );
                });

            } catch (error) {

                console.error(error);

                slotsContainer.innerHTML = `
                    <div class="alert alert-danger w-100 mb-0">
                        Unable to load appointment slots.
                    </div>
                `;
            }
        }
    );


    loadAvailableDates();

});
</script>

@endsection