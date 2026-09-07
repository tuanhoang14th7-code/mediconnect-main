@extends('admin/AdminLayout')

@section('admin-content')
    @php($isEdit = (bool) $patient->id)

    <section class="container">

        @include('admin.partials.flash')

        <div class="card shadow">
            <div class="card-header bg-dark">
                <h5 class="mb-0 text-white">{{ $isEdit ? 'Edit Patient — ' . $patient->name : 'New Patient' }}</h5>
            </div>

            <form method="POST"
                action="{{ $isEdit ? url('Admin/Patients/Update', $patient->id) : url('Admin/Patients/Store') }}">
                @csrf

                <div class="card-body">

                    <h6 class="text-uppercase small fw-bold text-muted mb-3">Account</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Full name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $patient->name) }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $patient->email) }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Mobile number <span class="text-danger">*</span></label>
                            <input type="tel" name="number" class="form-control"
                                value="{{ old('number', $patient->number) }}" pattern="[0-9]{10}" maxlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control"
                            value="{{ old('address', $patient->address) }}" required>
                        <small class="text-muted">Mandatory for patient accounts (database constraint).</small>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">City</label>
                            <select name="city_id" class="form-select">
                                <option value="">-- Not set --</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" @selected(old('city_id', $patient->city_id) == $city->id)>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Date of birth</label>
                            <input type="date" name="date_of_birth" class="form-control"
                                value="{{ old('date_of_birth', optional($patient->date_of_birth)->format('Y-m-d')) }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">-- Not set --</option>
                                @foreach (['Male', 'Female', 'Other', 'Prefer not to say'] as $g)
                                    <option value="{{ $g }}" @selected(old('gender', $patient->gender) === $g)>{{ $g }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Account status <span class="text-danger">*</span></label>
                            <select name="account_status" class="form-select" required>
                                <option value="Active" @selected(old('account_status', $patient->account_status) === 'Active')>Active</option>
                                <option value="Inactive" @selected(old('account_status', $patient->account_status) === 'Inactive')>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Password @unless ($isEdit)<span class="text-danger">*</span>@endunless
                        </label>
                        <input type="password" name="password" class="form-control" minlength="8"
                            @unless ($isEdit) required @endunless>
                        <small class="text-muted">
                            {{ $isEdit ? 'Leave empty to keep the current password.' : 'At least 8 characters.' }}
                        </small>
                    </div>

                    <hr class="my-4">

                    <h6 class="text-uppercase small fw-bold text-muted mb-3">Medical profile</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Blood group</label>
                            <select name="blood_group" class="form-select">
                                @foreach (\App\Models\PatientProfile::BLOOD_GROUPS as $bg)
                                    <option value="{{ $bg }}" @selected(old('blood_group', $profile->blood_group ?? 'Unknown') === $bg)>
                                        {{ $bg }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Emergency contact name</label>
                            <input type="text" name="emergency_contact_name" class="form-control"
                                value="{{ old('emergency_contact_name', $profile->emergency_contact_name ?? '') }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Emergency contact number</label>
                            <input type="text" name="emergency_contact_number" class="form-control"
                                value="{{ old('emergency_contact_number', $profile->emergency_contact_number ?? '') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Allergies</label>
                        <textarea name="allergies" class="form-control" rows="2">{{ old('allergies', $profile->allergies ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Medical notes</label>
                        <textarea name="medical_notes" class="form-control" rows="3">{{ old('medical_notes', $profile->medical_notes ?? '') }}</textarea>
                    </div>
                </div>

                <div class="card-footer d-flex gap-2">
                    <button class="btn btn-primary">
                        <i class="bi bi-save"></i> {{ $isEdit ? 'Save changes' : 'Create patient' }}
                    </button>
                    <a href="{{ url('Admin/Patients') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection
