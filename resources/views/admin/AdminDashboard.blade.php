@extends('admin/AdminLayout')

@section('admin-content')
    <section class="container-fluid px-0">

        @include('admin.partials.flash')

        {{-- Appointment pipeline --}}
        <h6 class="text-uppercase small fw-bold text-muted mb-2">Appointments</h6>
        <div class="row g-3 mb-4">
            @php
                $tiles = [
                    ['label' => 'Pending',   'value' => $appointments['pending'],   'tone' => 'warning'],
                    ['label' => 'Confirmed', 'value' => $appointments['confirmed'], 'tone' => 'primary'],
                    ['label' => 'Completed', 'value' => $appointments['completed'], 'tone' => 'success'],
                    ['label' => 'Cancelled', 'value' => $appointments['cancelled'], 'tone' => 'secondary'],
                    ['label' => 'Rejected',  'value' => $appointments['rejected'],  'tone' => 'danger'],
                    ['label' => 'No show',   'value' => $appointments['no_show'],   'tone' => 'dark'],
                ];
            @endphp

            @foreach ($tiles as $tile)
                <div class="col-6 col-md-4 col-xl-2">
                    <div class="card h-100">
                        <div class="card-body py-3">
                            <div class="small text-muted">{{ $tile['label'] }}</div>
                            <div class="fs-3 fw-bold text-{{ $tile['tone'] }}">{{ $tile['value'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-body py-3">
                        <div class="small text-muted">Total appointments</div>
                        <div class="fs-3 fw-bold">{{ $appointments['total'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-body py-3">
                        <div class="small text-muted">Scheduled today</div>
                        <div class="fs-3 fw-bold">{{ $appointments['today'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-body py-3">
                        <div class="small text-muted">Doctors</div>
                        <div class="fs-3 fw-bold">
                            {{ $accounts['doctors_active'] }}
                            <span class="fs-6 text-muted">/ {{ $accounts['doctors_total'] }} active</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card h-100">
                    <div class="card-body py-3">
                        <div class="small text-muted">Patients</div>
                        <div class="fs-3 fw-bold">
                            {{ $accounts['patients_active'] }}
                            <span class="fs-6 text-muted">/ {{ $accounts['patients_total'] }} active</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Things that need attention --}}
        @if ($accounts['doctors_no_profile'] > 0 || $masterData['assignments'] === 0 || $masterData['open_slots'] === 0)
            <div class="alert alert-warning">
                <strong>Needs attention</strong>
                <ul class="mb-0 mt-2">
                    @if ($accounts['doctors_no_profile'] > 0)
                        <li>
                            {{ $accounts['doctors_no_profile'] }} doctor account(s) have no professional profile yet &mdash;
                            <a href="{{ url('Admin/Doctors') }}">review them</a>.
                        </li>
                    @endif
                    @if ($masterData['assignments'] === 0)
                        <li>
                            No active doctor assignment exists, so patient search returns nothing &mdash;
                            <a href="{{ url('Admin/DoctorAssignments') }}">assign a doctor</a>.
                        </li>
                    @endif
                    @if ($masterData['open_slots'] === 0)
                        <li>No available slot exists, so patients cannot book any appointment.</li>
                    @endif
                </ul>
            </div>
        @endif

        <div class="row g-4">

            {{-- Pending queue --}}
            <div class="col-lg-7">
                <div class="card shadow h-100">
                    <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">Waiting for approval</h5>
                        <a href="{{ url('Admin/Appointments') }}" class="btn btn-sm btn-light">View all</a>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered m-0">
                            <thead>
                                <tr>
                                    <th>Number</th>
                                    <th>Patient</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendingQueue as $row)
                                    <tr>
                                        <td>{{ $row->appointment_number }}</td>
                                        <td>{{ $row->patient_name }}</td>
                                        <td>{{ $row->appointment_date }}</td>
                                        <td>{{ \Illuminate\Support\Str::of($row->start_time)->substr(0, 5) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            Nothing waiting for approval.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Master data health --}}
            <div class="col-lg-5">
                <div class="card shadow h-100">
                    <div class="card-header bg-dark">
                        <h5 class="mb-0 text-white">Master data (active)</h5>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered m-0">
                            <tbody>
                                <tr>
                                    <th>Cities</th>
                                    <td class="text-end">{{ $masterData['cities'] }}</td>
                                    <td style="width:1%"><a href="{{ url('Admin/Cities') }}">Manage</a></td>
                                </tr>
                                <tr>
                                    <th>Facilities</th>
                                    <td class="text-end">{{ $masterData['facilities'] }}</td>
                                    <td><a href="{{ url('Admin/Facilities') }}">Manage</a></td>
                                </tr>
                                <tr>
                                    <th>Specializations</th>
                                    <td class="text-end">{{ $masterData['specializations'] }}</td>
                                    <td><a href="{{ url('Admin/Specializations') }}">Manage</a></td>
                                </tr>
                                <tr>
                                    <th>Doctor assignments</th>
                                    <td class="text-end">{{ $masterData['assignments'] }}</td>
                                    <td><a href="{{ url('Admin/DoctorAssignments') }}">Manage</a></td>
                                </tr>
                                <tr>
                                    <th>Available slots</th>
                                    <td class="text-end">{{ $masterData['open_slots'] }}</td>
                                    <td>&mdash;</td>
                                </tr>
                                <tr>
                                    <th>New contact messages</th>
                                    <td class="text-end">{{ $newContactMessages }}</td>
                                    <td>&mdash;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
