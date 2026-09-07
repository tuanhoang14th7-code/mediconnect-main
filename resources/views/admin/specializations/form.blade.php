@extends('admin/AdminLayout')

@section('admin-content')
    @php($isEdit = (bool) $specialization->id)

    <section class="container">

        @include('admin.partials.flash')

        <div class="card shadow">
            <div class="card-header bg-dark">
                <h5 class="mb-0 text-white">{{ $isEdit ? 'Edit Specialization' : 'Add New Specialization' }}</h5>
            </div>

            <form method="POST"
                action="{{ $isEdit ? url('Admin/Specializations/Update', $specialization->id) : url('Admin/Specializations/Store') }}">
                @csrf

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Specialization name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $specialization->name) }}" placeholder="e.g. Cardiology" required>
                        <small class="text-muted">The slug is generated automatically from the name.</small>
                    </div>

                    @if ($isEdit)
                        <div class="mb-3">
                            <label class="form-label">Current slug</label>
                            <input type="text" class="form-control" value="{{ $specialization->slug }}" disabled>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"
                            placeholder="Short description of the specialization">{{ old('description', $specialization->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="Active" @selected(old('status', $specialization->status) === 'Active')>Active</option>
                            <option value="Inactive" @selected(old('status', $specialization->status) === 'Inactive')>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="card-footer d-flex gap-2">
                    <button class="btn btn-primary">
                        <i class="bi bi-save"></i> {{ $isEdit ? 'Save changes' : 'Create' }}
                    </button>
                    <a href="{{ url('Admin/Specializations') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection
