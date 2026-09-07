@extends('admin/AdminLayout')

@section('admin-content')
    @php($isEdit = (bool) $facility->id)

    <section class="container">

        @include('admin.partials.flash')

        <div class="card shadow">
            <div class="card-header bg-dark">
                <h5 class="mb-0 text-white">{{ $isEdit ? 'Edit Facility' : 'Add New Facility' }}</h5>
            </div>

            <form method="POST"
                action="{{ $isEdit ? url('Admin/Facilities/Update', $facility->id) : url('Admin/Facilities/Store') }}">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <select name="city_id" class="form-select" required>
                                <option value="">-- Select a city --</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" @selected(old('city_id', $facility->city_id) == $city->id)>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Facility code <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control" value="{{ old('code', $facility->code) }}"
                                placeholder="e.g. HNC" required>
                            <small class="text-muted">Short code, must be unique across facilities.</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Facility name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $facility->name) }}"
                            placeholder="e.g. MediConnect Hanoi Central Hospital" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Consultation address <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control"
                            value="{{ old('address', $facility->address) }}" placeholder="e.g. Ba Dinh, Hanoi" required>
                        <small class="text-muted">This address is shown to patients when booking.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $facility->phone) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $facility->email) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $facility->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="Active" @selected(old('status', $facility->status) === 'Active')>Active</option>
                            <option value="Inactive" @selected(old('status', $facility->status) === 'Inactive')>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="card-footer d-flex gap-2">
                    <button class="btn btn-primary">
                        <i class="bi bi-save"></i> {{ $isEdit ? 'Save changes' : 'Create' }}
                    </button>
                    <a href="{{ url('Admin/Facilities') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection
