@extends('admin/AdminLayout')

@section('admin-content')
    <section class="container">

        @include('admin.partials.flash')

        <div class="row g-4">

            <div class="col-lg-7">
                <div class="card shadow">
                    <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">{{ $patient->name }}</h5>
                        <span class="badge {{ $patient->account_status === 'Active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $patient->account_status }}
                        </span>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered m-0">
                            <tbody>
                                <tr><th style="width:200px;">Email</th><td>{{ $patient->email }}</td></tr>
                                <tr><th>Mobile number</th><td>{{ $patient->number }}</td></tr>
                                <tr><th>Address</th><td>{{ $patient->address ?: '—' }}</td></tr>
                                <tr><th>City</th><td>{{ $cityName ?: '—' }}</td></tr>
                                <tr>
                                    <th>Date of birth</th>
                                    <td>{{ optional($patient->date_of_birth)->format('Y-m-d') ?: '—' }}</td>
                                </tr>
                                <tr><th>Gender</th><td>{{ $patient->gender ?: '—' }}</td></tr>
                                <tr>
                                    <th>Last login</th>
                                    <td>{{ optional($patient->last_login_at)->format('Y-m-d H:i') ?: 'Never' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card shadow mt-4">
                    <div class="card-header bg-dark">
                        <h5 class="mb-0 text-white">Medical profile</h5>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered m-0">
                            <tbody>
                                <tr>
                                    <th style="width:200px;">Blood group</th>
                                    <td>{{ $profile->blood_group ?? 'Unknown' }}</td>
                                </tr>
                                <tr>
                                    <th>Emergency contact</th>
                                    <td>
                                        {{ $profile->emergency_contact_name ?? '—' }}
                                        @if (!empty($profile?->emergency_contact_number))
                                            &nbsp;&mdash;&nbsp; {{ $profile->emergency_contact_number }}
                                        @endif
                                    </td>
                                </tr>
                                <tr><th>Allergies</th><td>{{ $profile->allergies ?? '—' }}</td></tr>
                                <tr><th>Medical notes</th><td>{{ $profile->medical_notes ?? '—' }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                    @unless ($profile)
                        <div class="card-footer text-muted small">
                            No medical profile recorded yet. Use Edit to add one.
                        </div>
                    @endunless
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow">
                    <div class="card-body d-grid gap-2">
                        <a href="{{ url('Admin/Patients/Edit', $patient->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit patient
                        </a>
                        <a href="{{ url('Admin/Patients') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to patients
                        </a>
                        <form method="POST" action="{{ url('Admin/User/ToggleAccountStatus', $patient->id) }}"
                            onsubmit="return confirm('{{ $patient->account_status === 'Active' ? 'Deactivate' : 'Reactivate' }} the account of {{ $patient->name }}?')">
                            @csrf
                            <button
                                class="btn w-100 {{ $patient->account_status === 'Active' ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                <i class="bi {{ $patient->account_status === 'Active' ? 'bi-lock' : 'bi-unlock' }}"></i>
                                {{ $patient->account_status === 'Active' ? 'Deactivate account' : 'Reactivate account' }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card shadow mt-4">
                    <div class="card-header bg-dark">
                        <h5 class="mb-0 text-white">Recent appointments</h5>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered m-0">
                            <thead>
                                <tr>
                                    <th>Number</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($appointments as $a)
                                    <tr>
                                        <td>{{ $a->appointment_number }}</td>
                                        <td>{{ $a->appointment_date }}</td>
                                        <td>{{ \Illuminate\Support\Str::of($a->start_time)->substr(0, 5) }}</td>
                                        <td>{{ $a->status }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No appointments yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
