@extends('admin/AdminLayout')

@section('admin-content')
    <div class="container mb-5 mt-3">
        <div class="appointment-wrapper position-relative d-center w-100">
            <div class="row gx-0 gy-5">
                <div class="section-title mb-3">
                    <h2 class="wow fadeInUp black" data-wow-delay=".3s">
                        <span class="position-relative z-1 w-100">
                            Edit Information
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
                <form action="{{ url('Admin/Doctor/SaveThisEditedDetailsNow') }}" method="post" enctype="multipart/form-data"
                    class="appointment-forms mt-0">
                    @csrf
                    <input type="hidden" id="userType" value="Doctor" name="userType">
                    <input type="hidden" id="user_id" value="{{ $doctor->user_id }}" name="user_id">
                    <input type="hidden" id="id" value="{{ $doctor->id }}" name="id">
                    <div class="row gx-0 gy-5">
                        <div class="col-lg-4 pe-1">
                            <div class="row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <input type="text" value="{{ $user->name }}" name="name" id="name"
                                        placeholder="Your Name" required>
                                </div>
                                <div class="col-lg-12">
                                    <input type="email" value="{{ $user->email }}" name="email" id="email"
                                        placeholder="Your Email" required>
                                </div>
                                <div class="col-lg-12">
                                    <input type="tel" value="{{ $user->number }}" name="number" id="number"
                                        pattern="[0-9]{10}" maxlength="10"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        placeholder="Your Mobile Number" required>
                                </div>
                                <div class="col-lg-12">
                                    <img src="{{ asset('upload/doctors/' . $doctor->image) }}" alt="img"
                                        class="rounded-4" style="width: 45%;" id="preview">
                                </div>
                                <div class="col-lg-12">
                                    <input type="file" name="image" id="image" placeholder="Choice you image">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 ps-1">
                            <div class="row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <input type="text" value="{{ $doctor->expertise }}" name="expertise" id="expertise"
                                        placeholder="Your expertise" required>
                                </div>
                                <div class="col-lg-12">
                                    <input type="number" value="{{ $doctor->experience }}" name="experience"
                                        id="experience" placeholder="Your experience in year's" required>
                                </div>
                                <div class="col-lg-12">
                                    <input type="text" value="{{ $doctor->education }}" name="education" id="education"
                                        placeholder="Your education" required>
                                </div>
                                <div class="col-lg-12">
                                    <input type="text" value="{{ $doctor->profession }}" name="profession"
                                        id="profession" placeholder="Your profession" required>
                                </div>
                                <div class="col-lg-12">
                                    <label class="form-label">City:</label>
                                    <select name="city_id" id="city_id" class="form-select">
                                        <option value="">Select City</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ $user->city_id == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-4 ps-2">
                                    <div class="row g-lg-3 g-3">
                                        <div class="col-lg-12">
                                            <label class="form-label">Select Available Days:</label><br>
                                            <input type="checkbox" name="days[]" value="Monday"
                                                {{ in_array('Monday', $days) ? 'checked' : '' }}> Monday<br>
                                            <input type="checkbox" name="days[]" value="Tuesday"
                                                {{ in_array('Tuesday', $days) ? 'checked' : '' }}> Tuesday<br>
                                            <input type="checkbox" name="days[]" value="Wednesday"
                                                {{ in_array('Wednesday', $days) ? 'checked' : '' }}> Wednesday<br>
                                            <input type="checkbox" name="days[]" value="Thursday"
                                                {{ in_array('Thursday', $days) ? 'checked' : '' }}> Thursday<br>
                                            <input type="checkbox" name="days[]" value="Friday"
                                                {{ in_array('Friday', $days) ? 'checked' : '' }}> Friday<br>
                                            <input type="checkbox" name="days[]" value="Saturday"
                                                {{ in_array('Saturday', $days) ? 'checked' : '' }}> Saturday<br>
                                            <input type="checkbox" name="days[]" value="Sunday"
                                                {{ in_array('Sunday', $days) ? 'checked' : '' }}> Sunday<br>
                                        </div>

                                        <div class="col-lg-12">
                                            <label class="form-label">Start Time:</label>
                                            <input type="time" name="start_time" id="start_time"
                                                value="{{ $doctor->schedules[0]->start_time }}" required>
                                        </div>

                                        <div class="col-lg-12">
                                            <label class="form-label">End Time:</label>
                                            <input type="time" name="end_time" id="end_time"
                                                value="{{ $doctor->schedules[0]->end_time }}" required>
                                        </div>

                                        <div class="col-lg-12">
                                            <label class="form-label">Slot Duration (minutes):</label>
                                            <input type="number" name="slot_duration_minutes"
                                                id="slot_duration_minutes" min="5" max="480"
                                                value="{{ $doctor->schedules[0]->slot_duration_minutes ?? 30 }}">
                                        </div>

                                        <div class="col-lg-12">
                                            <label class="form-label">Valid From:</label>
                                            <input type="date" name="valid_from" id="valid_from"
                                                value="{{ optional($doctor->schedules[0]->valid_from ?? null)->format('Y-m-d') }}">
                                        </div>

                                        <div class="col-lg-12">
                                            <label class="form-label">Valid Until:</label>
                                            <input type="date" name="valid_until" id="valid_until"
                                                value="{{ optional($doctor->schedules[0]->valid_until ?? null)->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <button type="submit"
                                        class="common-btn box-style p2-bg w-100 text-nowrap d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold white overflow-hidden rounded100 wow fadeInRight"
                                        data-wow-delay="0.8s">
                                        Save Details
                                        <img src="{{ asset('assets/img/icon/arrow-right-white.png') }}" alt="icon">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.querySelector("form").addEventListener("submit", function(e) {
            let checked = document.querySelectorAll('input[name="days[]"]:checked');

            if (checked.length === 0) {
                e.preventDefault();
                alert("Please select at least one day");
            }
        });
        document.getElementById("image").addEventListener("change", function(event) {
            const file = event.target.files[0];

            if (file) {
                const preview = document.getElementById("preview");

                preview.src = URL.createObjectURL(file);
                preview.style.display = "block";
            }
        });
    </script>
@endsection
