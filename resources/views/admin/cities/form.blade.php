@extends('admin/AdminLayout')

@section('admin-content')
    @php($isEdit = (bool) $city->id)

    <section class="container">

        @include('admin.partials.flash')

        <div class="card shadow">
            <div class="card-header bg-dark">
                <h5 class="mb-0 text-white">{{ $isEdit ? 'Edit City' : 'Add New City' }}</h5>
            </div>

            <form method="POST"
                action="{{ $isEdit ? url('Admin/Cities/Update', $city->id) : url('Admin/Cities/Store') }}">
                @csrf

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">City name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $city->name) }}"
                            placeholder="e.g. Hanoi" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control" value="{{ old('state', $city->state) }}"
                            placeholder="Optional">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Country <span class="text-danger">*</span></label>
                        <input type="text" name="country" class="form-control"
                            value="{{ old('country', $city->country ?? 'Vietnam') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="Active" @selected(old('status', $city->status) === 'Active')>Active</option>
                            <option value="Inactive" @selected(old('status', $city->status) === 'Inactive')>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="card-footer d-flex gap-2">
                    <button class="btn btn-primary">
                        <i class="bi bi-save"></i> {{ $isEdit ? 'Save changes' : 'Create' }}
                    </button>
                    <a href="{{ url('Admin/Cities') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection
