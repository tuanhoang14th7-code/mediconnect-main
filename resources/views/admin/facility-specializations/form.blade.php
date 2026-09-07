@extends('admin/AdminLayout')

@section('admin-content')
    @php($isEdit = (bool) $item->id)

    <section class="container">

        @include('admin.partials.flash')

        <div class="card shadow">
            <div class="card-header bg-dark">
                <h5 class="mb-0 text-white">
                    {{ $isEdit ? 'Edit Facility Specialization' : 'Assign Specialization to Facility' }}
                </h5>
            </div>

            <form method="POST"
                action="{{ $isEdit ? url('Admin/FacilitySpecializations/Update', $item->id) : url('Admin/FacilitySpecializations/Store') }}">
                @csrf

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Facilities <span class="text-danger">*</span></label>
                        <select name="facility_id" class="form-select" required>
                            <option value="">-- Select a facility --</option>
                            @foreach ($facilities as $f)
                                <option value="{{ $f->id }}" @selected(old('facility_id', $item->facility_id) == $f->id)>
                                    {{ $f->name }} ({{ $f->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Specialization <span class="text-danger">*</span></label>
                        <select name="specialization_id" class="form-select" required>
                            <option value="">-- Select a specialization --</option>
                            @foreach ($specializations as $sp)
                                <option value="{{ $sp->id }}" @selected(old('specialization_id', $item->specialization_id) == $sp->id)>
                                    {{ $sp->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Each specialization can be assigned to a facility only once.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="Active" @selected(old('status', $item->status) === 'Active')>Active</option>
                            <option value="Inactive" @selected(old('status', $item->status) === 'Inactive')>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="card-footer d-flex gap-2">
                    <button class="btn btn-primary">
                        <i class="bi bi-save"></i> {{ $isEdit ? 'Save changes' : 'Assign Specialization' }}
                    </button>
                    <a href="{{ url('Admin/FacilitySpecializations') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection
