@extends('patient.PatientLayout')

@section('patient-content')

@php

    $doctor = $assignment->doctor;

    $user = $doctor->user;

    $facilitySpecialization =
        $assignment->facilitySpecialization;

    $facility =
        $facilitySpecialization->facility;

    $specialization =
        $facilitySpecialization->specialization;

@endphp


<div class="container my-5">

    @if (session('booking_success'))

        <div class="alert alert-success mb-4">

            <strong>
                {{ session('booking_success') }}
            </strong>

            @if (session('appointment_number'))

                <div class="mt-1">

                    Appointment Number:

                    <strong>
                        {{ session('appointment_number') }}
                    </strong>

                </div>

            @endif

        </div>

    @endif


    @if (session('booking_error'))

        <div class="alert alert-danger mb-4">

            {{ session('booking_error') }}

        </div>

    @endif

    {{-- Back --}}
    <div class="mb-4">

        <a href="{{ url('/doctors') }}"
           class="text-decoration-none">

            ← Back to Doctor Search

        </a>

    </div>


    <div class="row g-4">

        {{-- Doctor main information --}}
        <div class="col-lg-8">

            <div class="bg-white rounded-4 shadow-sm p-4 h-100">

                <div class="d-flex align-items-start
                            justify-content-between
                            flex-wrap gap-3 mb-4">

                    <div>

                        <h2 class="black mb-1">
                            {{ $user->name }}
                        </h2>

                        <p class="pra mb-1">
                            {{ $doctor->profession }}
                        </p>

                        <span class="badge bg-success">
                            {{ $specialization->name }}
                        </span>

                    </div>

                </div>


                {{-- Bio --}}
                <div class="mb-4">

                    <h5 class="black mb-2">
                        About Doctor
                    </h5>

                    <p class="pra mb-0">
                        {{ $doctor->bio ?: 'No biography provided.' }}
                    </p>

                </div>


                {{-- Professional information --}}
                <div class="mb-4">

                    <h5 class="black mb-3">
                        Professional Information
                    </h5>

                    <ul class="doctor-professional">

                        <li class="d-flex align-items-start">

                            <span class="names shift-colon">
                                Expertise
                            </span>

                            <span class="pra ms-3">
                                {{ $doctor->expertise }}
                            </span>

                        </li>


                        <li class="d-flex align-items-start">

                            <span class="names shift-colon">
                                Education
                            </span>

                            <span class="pra ms-3">
                                {{ $doctor->education }}
                            </span>

                        </li>


                        <li class="d-flex align-items-start">

                            <span class="names shift-colon">
                                Qualifications
                            </span>

                            <span class="pra ms-3">
                                {{ $doctor->qualifications
                                    ?: 'Not provided' }}
                            </span>

                        </li>


                        <li class="d-flex align-items-start">

                            <span class="names shift-colon">
                                Experience
                            </span>

                            <span class="pra ms-3">
                                {{ $doctor->experience }} years
                            </span>

                        </li>


                        <li class="d-flex align-items-start">

                            <span class="names shift-colon">
                                License Number
                            </span>

                            <span class="pra ms-3">
                                {{ $doctor->license_number
                                    ?: 'Not provided' }}
                            </span>

                        </li>

                    </ul>

                </div>


                {{-- Practice information --}}
                <div>

                    <h5 class="black mb-3">
                        Practice Information
                    </h5>

                    <ul class="doctor-professional">

                        <li class="d-flex align-items-start">

                            <span class="names shift-colon">
                                Facility
                            </span>

                            <span class="pra ms-3">
                                {{ $facility->name }}
                            </span>

                        </li>


                        <li class="d-flex align-items-start">

                            <span class="names shift-colon">
                                City
                            </span>

                            <span class="pra ms-3">
                                {{ $facility->city->name }}
                            </span>

                        </li>


                        <li class="d-flex align-items-start">

                            <span class="names shift-colon">
                                Address
                            </span>

                            <span class="pra ms-3">
                                {{ $facility->address }}
                            </span>

                        </li>


                        <li class="d-flex align-items-start">

                            <span class="names shift-colon">
                                Specialization
                            </span>

                            <span class="pra ms-3">
                                {{ $specialization->name }}
                            </span>

                        </li>


                        <li class="d-flex align-items-start">

                            <span class="names shift-colon">
                                Room
                            </span>

                            <span class="pra ms-3">
                                {{ $assignment->room_number
                                    ?: 'Not assigned' }}
                            </span>

                        </li>


                        <li class="d-flex align-items-start">

                            <span class="names shift-colon">
                                Consultation Fee
                            </span>

                            <span class="pra ms-3 fw-semibold">
                                {{ number_format(
                                    $assignment->consultation_fee,
                                    0
                                ) }} VND
                            </span>

                        </li>

                    </ul>

                </div>

            </div>

        </div>


        {{-- Doctor card --}}
        <div class="col-lg-4">

            <div class="bg-white rounded-4 shadow-sm p-4 text-center">

                @if ($doctor->image)

                    <img
                        src="{{ asset(
                            'upload/doctors/' . $doctor->image
                        ) }}"
                        alt="{{ $user->name }}"
                        class="rounded-4 mb-3"
                        style="
                            width: 100%;
                            max-height: 320px;
                            object-fit: cover;
                        "
                    >

                @endif


                <h4 class="black mb-1">
                    {{ $user->name }}
                </h4>

                <p class="pra mb-1">
                    {{ $doctor->profession }}
                </p>

                <p class="pra mb-4">
                    {{ $specialization->name }}
                </p>


                {{-- Appointment Date --}}
                <div class="text-start mb-3">

                    <label
                        for="appointment_date"
                        class="fw-semibold mb-2"
                    >
                        Appointment Date
                    </label>

                    <select
                        id="appointment_date"
                        class="appointment-date-select"
                    >
                        <option value="" disabled selected>
                            Select Date
                        </option>
                    </select>

                </div>


                {{-- Available Slots --}}
                <div class="text-start mb-3">

                    <label class="fw-semibold mb-2">
                        Available Time
                    </label>

                    <div
                        id="available-slots"
                        class="d-flex flex-wrap gap-2"
                    >
                        <span class="text-muted">
                            Select a date first.
                        </span>
                    </div>

                </div>


                {{-- Selected slot --}}
                <input
                    type="hidden"
                    id="selected_slot_id"
                    value=""
                >


                {{-- Continue button --}}
                <button
                    type="button"
                    id="continue-booking"
                    class="common-btn box-style p2-bg w-100
                        d-inline-flex justify-content-center
                        align-items-center fs18 fw-semibold
                        white overflow-hidden rounded100"
                    disabled
                >
                    Continue Booking
                </button>

            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const assignmentId = {{ $assignment->id }};

    const dateSelect =
        document.getElementById('appointment_date');

    const slotsContainer =
        document.getElementById('available-slots');

    const selectedSlotInput =
        document.getElementById('selected_slot_id');

    const continueButton =
        document.getElementById('continue-booking');

    function refreshDateSelect() {
        if (
            window.jQuery &&
            jQuery.fn.niceSelect
        ) {
            $('#appointment_date')
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

            const dates = await response.json();


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
                        This doctor currently has no available appointment slots.
                    </div>
                `;

                return;
            }


            dateSelect.disabled = false;

            dateSelect.innerHTML = `
                <option value="" disabled selected>
                    Select Date
                </option>
            `;


            dates.forEach(function (date) {

                const formattedDate =
                    new Date(date + 'T00:00:00')
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
    $('#appointment_date').on(
        'change',
        async function () {

            const selectedDate = $(this).val();

            selectedSlotInput.value = '';
            continueButton.disabled = true;

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
                    throw new Error('Unable to load slots');
                }

                const slots = await response.json();

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
                        document.createElement('button');

                    button.type = 'button';

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
                                .forEach(function (item) {

                                    item.classList.remove(
                                        'selected'
                                    );
                                });

                            this.classList.add(
                                'selected'
                            );

                            selectedSlotInput.value =
                                this.dataset.slotId;

                            continueButton.disabled =
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
    // =========================
    // CONTINUE BOOKING
    // =========================
    continueButton.addEventListener(
        'click',
        function () {

            const slotId =
                selectedSlotInput.value;


            if (!slotId) {
                return;
            }


            window.location.href =
                `/appointments/confirm/${slotId}`;
        }
    );


    loadAvailableDates();

});
</script>

@endsection