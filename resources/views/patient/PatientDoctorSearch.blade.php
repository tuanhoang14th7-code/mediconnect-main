@extends('patient.PatientLayout')

@section('patient-content')

<div class="container my-5">

    <div class="text-center mb-5">
        <h2 class="black mb-2">
            Find a Doctor
        </h2>

        <p class="pra">
            Select your location and specialization to find
            available doctors.
        </p>
    </div>


    <div class="bg-white rounded-4 p-4 shadow-sm mb-5">

        <div class="row g-4">

            {{-- City --}}
            <div class="col-lg-4">

                <label for="city_id" class="mb-2 fw-semibold">
                    City
                </label>

                <select
                    id="city_id"
                    class="form-select doctor-search-select"
                >

                    <option value="">
                        Select City
                    </option>

                    @foreach ($cities as $city)

                        <option value="{{ $city->id }}">
                            {{ $city->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Facility --}}
            <div class="col-lg-4">

                <label for="facility_id" class="mb-2 fw-semibold">
                    Facility
                </label>

                <select
                    id="facility_id"
                    class="form-select doctor-search-select"
                    disabled
                >

                    <option value="">
                        Select Facility
                    </option>

                </select>

            </div>


            {{-- Specialization --}}
            <div class="col-lg-4">

                <label for="specialization_id" class="mb-2 fw-semibold">
                    Specialization
                </label>

                <select
                    id="specialization_id"
                    class="form-select doctor-search-select"
                    disabled
                >

                    <option value="">
                        Select Specialization
                    </option>

                </select>

            </div>

        </div>

    </div>


    {{-- Doctor Results --}}
    <div id="doctor-results">

        <div class="text-center text-muted">
            Select City, Facility and Specialization
            to find doctors.
        </div>

    </div>

</div>


<script>
window.addEventListener('load', function () {

    const citySelect =
        document.getElementById('city_id');

    const facilitySelect =
        document.getElementById('facility_id');

    const specializationSelect =
        document.getElementById('specialization_id');

    const doctorResults =
        document.getElementById('doctor-results');


    /*
     * This page uses native Bootstrap selects.
     * Main.js automatically applies Nice Select to every select,
     * so remove it only for these three search fields.
     */
    if (window.jQuery && jQuery.fn.niceSelect) {

        $('.doctor-search-select').niceSelect('destroy');
    }


    function resetSelect(select, text) {

        select.innerHTML =
            `<option value="">${text}</option>`;

        select.disabled = true;
    }


    // ==========================
    // CITY CHANGE
    // ==========================
    citySelect.addEventListener('change', async function () {

        resetSelect(
            facilitySelect,
            'Select Facility'
        );

        resetSelect(
            specializationSelect,
            'Select Specialization'
        );

        doctorResults.innerHTML =
            '<div class="text-center text-muted">Select a facility.</div>';


        if (!this.value) {
            return;
        }


        const response = await fetch(
            `/doctors/facilities/${this.value}`
        );

        const facilities = await response.json();


        facilitySelect.innerHTML =
            '<option value="">Select Facility</option>';


        facilities.forEach(function (facility) {

            facilitySelect.innerHTML +=
                `<option value="${facility.id}">
                    ${facility.name}
                </option>`;
        });


        facilitySelect.disabled = false;
    });


    // ==========================
    // FACILITY CHANGE
    // ==========================
    facilitySelect.addEventListener(
        'change',
        async function () {

            resetSelect(
                specializationSelect,
                'Select Specialization'
            );

            doctorResults.innerHTML =
                '<div class="text-center text-muted">Select a specialization.</div>';


            if (!this.value) {
                return;
            }


            const response = await fetch(
                `/doctors/specializations/${this.value}`
            );

            const specializations =
                await response.json();


            specializationSelect.innerHTML =
                '<option value="">Select Specialization</option>';


            specializations.forEach(
                function (specialization) {

                    specializationSelect.innerHTML +=
                        `<option value="${specialization.id}">
                            ${specialization.name}
                        </option>`;
                }
            );


            specializationSelect.disabled = false;
        }
    );


    // ==========================
    // SPECIALIZATION CHANGE
    // ==========================
    specializationSelect.addEventListener(
        'change',
        async function () {

            const facilityId =
                facilitySelect.value;

            const specializationId =
                this.value;


            if (!facilityId || !specializationId) {

                doctorResults.innerHTML =
                    '<div class="text-center text-muted">Select a specialization.</div>';

                return;
            }


            doctorResults.innerHTML =
                '<div class="text-center">Searching doctors...</div>';


            const response = await fetch(
                `/doctors/results?facility_id=${facilityId}&specialization_id=${specializationId}`
            );

            const doctors = await response.json();


            if (doctors.length === 0) {

                doctorResults.innerHTML = `
                    <div class="alert alert-info text-center">
                        No doctors found for this selection.
                    </div>
                `;

                return;
            }


            let html = `
                <div class="row g-4">
            `;


            doctors.forEach(function (doctor) {

                html += `
                    <div class="col-lg-6">

                        <div class="bg-white rounded-4
                                    shadow-sm p-4 h-100">

                            <h4 class="black mb-2">
                                ${doctor.name}
                            </h4>

                            <p class="mb-2">
                                <strong>Profession:</strong>
                                ${doctor.profession}
                            </p>

                            <p class="mb-2">
                                <strong>Expertise:</strong>
                                ${doctor.expertise}
                            </p>

                            <p class="mb-2">
                                <strong>Experience:</strong>
                                ${doctor.experience} years
                            </p>

                            <p class="mb-0">
                                <strong>Education:</strong>
                                ${doctor.education}
                            </p>
                            
                            <div class="mt-4">
                                <a
                                    href="/doctors/${doctor.assignment_id}"
                                    class="common-btn box-style p2-bg
                                        d-inline-flex justify-content-center
                                        align-items-center gap-2
                                        fs16 fw-semibold white
                                        overflow-hidden rounded100"
                                    style="padding: 10px 18px;"
                                >
                                    View Details
                                </a>
                            </div>

                        </div>

                    </div>
                `;
            });


            html += '</div>';

            doctorResults.innerHTML = html;
        }
    );

});
</script>

@endsection