@extends('layout')

@section('main-content')
    <!-- Appointment Section Start -->
    <section class="appoentment-section fix my-2 py-4">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-5 order-lg-0 order-1">
                    <div class="apoentment-thumb">
                        <img src="{{ asset('assets/img/blog/apoentment-thumb.jpg') }}" style="width: 120%;" alt="img"
                            class="rounded-4">
                    </div>
                </div>
                <!-- Appointment Form -->
                <div class="col-lg-7">

                    <form action="{{ url('BookAppointmentNow') }}" method="POST" class="appoentment-forms">
                        @csrf
                        <input type="hidden" name="userId" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="doctorId" value="{{ $doctor->id }}">
                        <input type="hidden" name="day" id="selectedDay">
                        <div class="section-title mb-30">
                            <span class="cmn-tag p1-bg heading-font">
                                <h3 class="wow fadeInUp black" data-wow-delay=".3s">
                                    Get an Appointment
                                </h3>
                            </span>
                        </div>
                        <div class="row g-lg-4 g-3">
                            <div class="col-lg-6">
                                <label for="name" class="ps-3 fw-bold">Patient Name: </label>
                                <input type="text" id="name" placeholder="Your Name" name="name" class="py-2"
                                    value="{{ auth()->user()->name }}" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="number" class="ps-3 fw-bold">Mobile Number: </label>
                                <input type="tel" placeholder="Phone Number" name="number" id="number"
                                    class="py-2" value="{{ auth()->user()->number }}" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="appointmentDate" class="ps-3 fw-bold">Select Appointment Date: </label>
                                <input type="text" name="date" id="appointmentDate" placeholder="Select Date"
                                    class="py-2" required>
                                {{-- <input type="date" name="date" id="appointmentDate" placeholder="date" required> --}}
                            </div>
                            <div class="col-lg-6">
                                <label for="day" class="ps-3 fw-bold">Available Days: </label><br>
                                {{-- @foreach ($doctor->schedules as $s)
                                    {{ $s->day[0] . $s->day[1] . $s->day[2] }},
                                @endforeach --}}
                                <input type="text" id="day" class="py-2"
                                    value="@foreach ($doctor->schedules as $s){{ substr($s->day, 0, 3) . ',' }} @endforeach"
                                    disabled>

                            </div>
                            {{-- <div class="col-lg-6 px-5 py-3" style="background: ghostwhite;border-radius: 19px;">
                                <select name="day" required>
                                    @foreach ($doctor->schedules as $schedule)
                                        <option value="{{ $schedule->day }}">{{ $schedule->day }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="col-lg-12 ps-3">
                                <label class="mb-2 ps-2 fw-bold">Select Time</label>

                                <div class="d-flex flex-wrap gap-2">

                                    @php
                                        $start = \Carbon\Carbon::parse($doctor->schedules[0]['start_time']);
                                        $end = \Carbon\Carbon::parse($doctor->schedules[0]['end_time']);
                                        $first = true;
                                    @endphp

                                    @while ($start->copy()->addMinutes(90) <= $end)
                                        <input type="radio" class="btn-check" name="time"
                                            id="time_{{ $start->format('H_i') }}" value="{{ $start->format('H:i') }}"
                                            {{ $first ? 'required' : '' }} autocomplete="off">

                                        <label class="btn btn-outline-primary" for="time_{{ $start->format('H_i') }}">
                                            {{ $start->format('h:i A') }}
                                        </label>

                                        @php
                                            $first = false;
                                            $start->addMinutes(90);
                                        @endphp
                                    @endwhile

                                </div>
                            </div>
                            <script>
                                const availableDays = @json($doctor->schedules->pluck('day'));
                                document.addEventListener("DOMContentLoaded", function() {

                                    const daysMap = {
                                        "Sunday": 0,
                                        "Monday": 1,
                                        "Tuesday": 2,
                                        "Wednesday": 3,
                                        "Thursday": 4,
                                        "Friday": 5,
                                        "Saturday": 6
                                    };

                                    // Convert available days → numbers
                                    const allowedDays = availableDays.map(day => daysMap[day]);

                                    flatpickr("#appointmentDate", {
                                        dateFormat: "Y-m-d",

                                        // ✅ Only next 20 days
                                        minDate: "today",
                                        maxDate: new Date().fp_incr(20),

                                        // ✅ Disable all except allowed days
                                        disable: [
                                            function(date) {
                                                return !allowedDays.includes(date.getDay());
                                            }
                                        ],

                                        // ✅ When date selected
                                        onChange: function(selectedDates, dateStr, instance) {
                                            if (selectedDates.length > 0) {
                                                const selectedDate = selectedDates[0];
                                                const dayName = selectedDate.toLocaleString('en-US', {
                                                    weekday: 'long'
                                                });

                                                document.getElementById("selectedDay").value = dayName;
                                            }
                                        }
                                    });

                                });
                                // $(document).ready(function() {

                                //     const input = $("#appointmentDate");
                                //     const hiddenDay = $("#selectedDay");

                                //     const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

                                //     function formatDate(date) {
                                //         return date.toISOString().split('T')[0];
                                //     }

                                //     function getDayName(date) {
                                //         return days[date.getDay()];
                                //     }

                                //     // ✅ Set min/max
                                //     let today = new Date();
                                //     input.attr("min", formatDate(today));

                                //     let maxDate = new Date();
                                //     maxDate.setDate(today.getDate() + 20);
                                //     input.attr("max", formatDate(maxDate));

                                //     // ✅ When user selects date
                                //     input.on("change", function() {

                                //         let selected = new Date(this.value);

                                //         // 🔥 Loop until valid day found
                                //         while (!availableDays.includes(getDayName(selected))) {
                                //             selected.setDate(selected.getDate() + 1);
                                //         }

                                //         // ✅ Set corrected date
                                //         let validDate = formatDate(selected);
                                //         input.val(validDate);

                                //         // ✅ Set hidden day
                                //         hiddenDay.val(getDayName(selected));
                                //     });

                                // });
                                // document.addEventListener("DOMContentLoaded", function() {

                                //     const input = document.getElementById("appointmentDate");
                                //     const hiddenDay = document.getElementById("selectedDay");

                                //     const availableDays = @json($doctor->schedules->pluck('day'));

                                //     const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

                                //     function formatDate(date) {
                                //         return date.toISOString().split('T')[0];
                                //     }

                                //     function getDayName(date) {
                                //         return days[date.getDay()];
                                //     }

                                //     let today = new Date();
                                //     input.min = formatDate(today);

                                //     let maxDate = new Date();
                                //     maxDate.setDate(today.getDate() + 20);
                                //     input.max = formatDate(maxDate);

                                //     let lastValidDate = "";

                                //     input.addEventListener("change", function() {

                                //         let selected = new Date(this.value);
                                //         let selectedDay = getDayName(selected);

                                //         // ❌ If day not available → revert (like disabled)
                                //         if (!availableDays.includes(selectedDay)) {
                                //             this.value = lastValidDate; // revert back
                                //             return;
                                //         }

                                //         // ✅ valid → save
                                //         lastValidDate = this.value;
                                //         hiddenDay.value = selectedDay;
                                //     });

                                // });
                                // document.addEventListener("DOMContentLoaded", function() {

                                //     const input = document.getElementById("appointmentDate");
                                //     const hiddenDay = document.getElementById("selectedDay");

                                //     const today = new Date();

                                //     function formatDate(date) {
                                //         return date.toISOString().split('T')[0];
                                //     }

                                //     // ✅ Set min & max
                                //     input.min = formatDate(today);

                                //     let maxDate = new Date();
                                //     maxDate.setDate(today.getDate() + 20);
                                //     input.max = formatDate(maxDate);

                                //     // ✅ Convert date → day name
                                //     function getDayName(dateString) {
                                //         const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                                //         const date = new Date(dateString);
                                //         return days[date.getDay()];
                                //     }

                                //     // ✅ Validate date selection
                                //     input.addEventListener("change", function() {

                                //         const selectedDate = input.value;
                                //         const selectedDayName = getDayName(selectedDate);

                                //         // ❌ If not available
                                //         if (!availableDays.includes(selectedDayName)) {
                                //             alert("Doctor is not available on " + selectedDayName);

                                //             input.value = "";
                                //             hiddenDay.value = "";
                                //         } else {
                                //             // ✅ Save day in hidden field
                                //             hiddenDay.value = selectedDayName;
                                //         }
                                //     });

                                // });
                                // document.addEventListener("DOMContentLoaded", function() {
                                //     const input = document.getElementById("appointmentDate");
                                //     const today = new Date();
                                //     // Format date to YYYY-MM-DD
                                //     function formatDate(date) {
                                //         return date.toISOString().split('T')[0];
                                //     }
                                //     // Min = today
                                //     input.min = formatDate(today);
                                //     // Max = today + 20 days
                                //     let maxDate = new Date();
                                //     maxDate.setDate(today.getDate() + 20);
                                //     input.max = formatDate(maxDate);
                                // });
                            </script>
                            <div class="col-lg-12">
                                <textarea name="message" placeholder="Message" rows="5"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit"
                                    class="common-btn box-style p2-bg w-100 text-nowrap d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold white overflow-hidden rounded100 wow fadeInRight"
                                    data-wow-delay="0.8s">
                                    Book An Appointment
                                    <img src="{{ asset('assets/img/icon/arrow-right-white.png') }}" alt="icon">
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
