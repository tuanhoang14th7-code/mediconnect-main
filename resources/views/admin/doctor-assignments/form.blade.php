@extends('admin/AdminLayout')

@section('admin-content')
    @php($isEdit = (bool) $assignment->id)

    <section class="container">

        @include('admin.partials.flash')

        <div class="card shadow">
            <div class="card-header bg-dark">
                <h5 class="mb-0 text-white">
                    {{ $isEdit ? 'Edit Assignment' : 'Assign Doctor to Facility' }}
                </h5>
            </div>

            <form method="POST"
                action="{{ $isEdit ? url('Admin/DoctorAssignments/Update', $assignment->id) : url('Admin/DoctorAssignments/Store') }}">
                @csrf

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Doctor <span class="text-danger">*</span></label>
                        <select name="doctor_id" class="form-select" required>
                            <option value="">-- Select a doctor --</option>
                            @foreach ($doctors as $d)
                                <option value="{{ $d->id }}" @selected(old('doctor_id', $assignment->doctor_id) == $d->id)>
                                    {{ $d->user->name ?? 'Doctor #' . $d->id }} — {{ $d->expertise }}
                                </option>
                            @endforeach
                        </select>
                        @if ($doctors->isEmpty())
                            <small class="text-danger">
                                No active doctor profile found. Create a doctor account and fill in the professional
                                profile first.
                            </small>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Facility &amp; Specialization <span class="text-danger">*</span></label>
                        <select name="facility_specialization_id" class="form-select" required>
                            <option value="">-- Select facility and specialization --</option>
                            @foreach ($facilitySpecializations as $fs)
                                <option value="{{ $fs->id }}"
                                    @selected(old('facility_specialization_id', $assignment->facility_specialization_id) == $fs->id)>
                                    {{ $fs->facility->name ?? '?' }}
                                    ({{ $fs->facility->city->name ?? '?' }})
                                    — {{ $fs->specialization->name ?? '?' }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">
                            Pair not listed? Add it under
                            <a href="{{ url('Admin/FacilitySpecializations') }}">Facility Specializations</a> first.
                        </small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Room number</label>
                            <input type="text" name="room_number" class="form-control"
                                value="{{ old('room_number', $assignment->room_number) }}" placeholder="e.g. HN-101">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Consultation fee <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" name="consultation_fee" class="form-control"
                                value="{{ old('consultation_fee', $assignment->consultation_fee ?? 0) }}" required>
                            <small class="text-muted">The fee belongs to this facility, not to the doctor globally.</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="Active" @selected(old('status', $assignment->status) === 'Active')>Active</option>
                            <option value="Inactive" @selected(old('status', $assignment->status) === 'Inactive')>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="card-footer d-flex gap-2">
                    <button class="btn btn-primary">
                        <i class="bi bi-save"></i> {{ $isEdit ? 'Save changes' : 'Assign' }}
                    </button>
                    <a href="{{ url('Admin/DoctorAssignments') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection
