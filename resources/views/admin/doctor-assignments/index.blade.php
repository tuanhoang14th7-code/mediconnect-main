@extends('admin/AdminLayout')

@section('admin-content')
    <section class="container">

        @include('admin.partials.flash')

        <div class="helper-note">
                        An assignment defines <strong>which facility and specialization a doctor works in, the room number and the
            consultation fee</strong>. A doctor without an assignment will not appear in patient search results and cannot
            have a working schedule.
        </div>

        <div class="card shadow">
            <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">Doctor Assignments</h5>
                <a href="{{ url('Admin/DoctorAssignments/Create') }}" class="btn btn-sm btn-light">
                    <i class="bi bi-plus-lg"></i> New Assignment
                </a>
            </div>

            <div class="card-body border-bottom">
                <form method="GET" action="{{ url('Admin/DoctorAssignments') }}" class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control"
                            placeholder="Search by doctor name or email...">
                    </div>
                    <div class="col-md-3">
                        <select name="facility_id" class="form-select">
                            <option value="">-- All facilities --</option>
                            @foreach ($facilities as $f)
                                <option value="{{ $f->id }}" @selected(request('facility_id') == $f->id)>{{ $f->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">-- Status --</option>
                            <option value="Active" @selected(request('status') === 'Active')>Active</option>
                            <option value="Inactive" @selected(request('status') === 'Inactive')>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary"><i class="bi bi-search"></i> Filter</button>
                        <a href="{{ url('Admin/DoctorAssignments') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-bordered align-middle m-0">
                    <thead>
                        <tr>
                            <th style="width:1%">#</th>
                            <th>Doctor</th>
                            <th>Facility</th>
                            <th>Specialization</th>
                            <th>Room</th>
                            <th class="text-end">Fee</th>
                            <th class="text-center">Slots</th>
                            <th class="text-center">Status</th>
                            <th class="text-center text-nowrap" style="width:1%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($assignments as $index => $a)
                            @php($fs = $a->facilitySpecialization)
                            <tr>
                                <th>{{ $assignments->firstItem() + $index }}</th>
                                <td>
                                    {{ $a->doctor->user->name ?? '—' }}
                                    <div class="small text-muted">{{ $a->doctor->expertise ?? '' }}</div>
                                </td>
                                <td>
                                    {{ $fs->facility->name ?? '—' }}
                                    <div class="small text-muted">{{ $fs->facility->city->name ?? '' }}</div>
                                </td>
                                <td>{{ $fs->specialization->name ?? '—' }}</td>
                                <td>{{ $a->room_number ?? '—' }}</td>
                                <td class="text-end">{{ number_format($a->consultation_fee, 2) }}</td>
                                <td class="text-center">{{ $a->appointment_slots_count }}</td>
                                <td class="text-center">
                                    <form method="POST" action="{{ url('Admin/DoctorAssignments/ToggleStatus', $a->id) }}"
                                        class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm status-pill {{ $a->status === 'Active' ? 'btn-success' : 'btn-secondary' }}"
                                            title="Click to toggle status">
                                            {{ $a->status }}
                                        </button>
                                    </form>
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="{{ url('Admin/DoctorAssignments/Edit', $a->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ url('Admin/DoctorAssignments/Delete', $a->id) }}"
                                        class="d-inline"
                                        onsubmit="return confirm('Deleting this assignment also removes its schedules and generated slots. Continue?')">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">No assignments yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $assignments->links() }}
            </div>
        </div>
    </section>
@endsection
