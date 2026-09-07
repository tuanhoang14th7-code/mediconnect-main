@extends('admin/AdminLayout')

@section('admin-content')
    <!--Appointment Section Start -->
    <section class="appointment-section fix cmn-bg my-4">
        <div class="container">
            <div class="appointment-wrapper position-relative d-center w-100">
                <div class="row gx-0 gy-5">
                    <div class="section-title">
                        @if (session('DoctorRegisterOKay'))
                            <div style="color: green; margin: 10px;">{{ session('DoctorRegisterOKay') }}</div>
                        @endif
                        @if (session('DoctorDetailsNotFound'))
                            <div style="color: rgb(114, 83, 2); margin: 10px;">{{ session('DoctorDetailsNotFound') }} Fill
                                This Form</div>
                        @endif
                        <h2 class="wow fadeInUp black" data-wow-delay=".3s">
                            <span class="position-relative z-1 w-100">
                                Collect Doctor Details From
                                <img src="{{ asset('assets/img/element/title-badge1.png') }}"
                                    style="bottom: -5px;left: 250px;" alt="img"
                                    class="title-badge1 d-md-block d-none w-90">
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

                    Doctor name: {{ $doctor['name'] }} &nbsp;&nbsp; | &nbsp;&nbsp; Email: {{ $doctor['email'] }}
                    &nbsp;&nbsp; | &nbsp;&nbsp; Number: {{ $doctor['number'] }}
                    <form action="{{ url('Admin/AddThisDoctorDetailsNow') }}" method="post" enctype="multipart/form-data"
                        class="appointment-forms mt-2">
                        @csrf
                        {{-- ['user_id', 'image', 'expertise', 'experience', 'education', 'profession', 'available_days', 'available_time']; --}}
                        <input type="hidden" name="user_id" value="{{ $doctor->id }}" id="user_id">
                        <div class="row gx-0 gy-5">
                            <div class="col-lg-8 pe-4">
                                <div class="row g-lg-3 g-3">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-8">
                                                <input type="file" name="image" id="image" required>
                                            </div>
                                            <div class="col-4">
                                                <img id="preview" src="" style="width:120px;display:none;"
                                                    alt="Preview">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="text" name="expertise" id="expertise" placeholder="Your expertise"
                                            required>
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="number" name="experience" id="experience"
                                            placeholder="Your experience in year's" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="text" name="education" id="education" placeholder="Your education"
                                            required>
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="text" name="profession" id="profession"
                                            placeholder="Your profession" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="form-label">City:</label>
                                        <select name="city_id" id="city_id" class="form-select">
                                            <option value="">Select City</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 ps-2">
                                <div class="row g-lg-3 g-3">
                                    <div class="col-lg-12">
                                        <label class="form-label">Select Available Days:</label><br>
                                        <input type="checkbox" name="days[]" value="Monday"> Monday<br>
                                        <input type="checkbox" name="days[]" value="Tuesday"> Tuesday<br>
                                        <input type="checkbox" name="days[]" value="Wednesday"> Wednesday<br>
                                        <input type="checkbox" name="days[]" value="Thursday"> Thursday<br>
                                        <input type="checkbox" name="days[]" value="Friday"> Friday<br>
                                        <input type="checkbox" name="days[]" value="Saturday"> Saturday<br>
                                        <input type="checkbox" name="days[]" value="Sunday"> Sunday<br>
                                    </div>

                                    <div class="col-lg-12">
                                        <label class="form-label">Start Time:</label>
                                        <input type="time" name="start_time" id="start_time" required>
                                    </div>

                                    <div class="col-lg-12">
                                        <label class="form-label">End Time:</label>
                                        <input type="time" name="end_time" id="end_time" required>
                                    </div>

                                    <div class="col-lg-12">
                                        <label class="form-label">Slot Duration (minutes):</label>
                                        <input type="number" name="slot_duration_minutes" id="slot_duration_minutes"
                                            min="5" max="480" value="30">
                                    </div>

                                    <div class="col-lg-12">
                                        <label class="form-label">Valid From:</label>
                                        <input type="date" name="valid_from" id="valid_from">
                                    </div>

                                    <div class="col-lg-12">
                                        <label class="form-label">Valid Until:</label>
                                        <input type="date" name="valid_until" id="valid_until">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <button type="submit"
                                    class="common-btn box-style p2-bg w-100 text-nowrap d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold white overflow-hidden rounded100 wow fadeInRight"
                                    data-wow-delay="0.8s">
                                    Save
                                    <img src="{{ asset('assets/img/icon/arrow-right-white.png') }}" alt="icon">
                                </button>
                            </div>
                            {{-- <div class="col-lg-12">
                                    <input type="text" name="available_days" id="available_days"
                                        placeholder="Ex. Mon-Sat" required>
                                </div>
                                <div class="col-lg-12">
                                    <input type="text" name="available_time" id="available_time"
                                        placeholder="Ex. 10:00 AM - 4:00 PM" required>
                                </div> --}}
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
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
