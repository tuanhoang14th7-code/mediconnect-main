@extends('admin/AdminLayout')

@section('admin-content')
    <section class="container">

        @include('admin.partials.flash')

        <div class="helper-note">
            Step 1 of 3 &mdash; create the login account. Next you will fill in the professional profile,
            then assign the doctor to a facility.
        </div>

        <div class="card shadow" style="max-width:720px;">
            <div class="card-header bg-dark">
                <h5 class="mb-0 text-white">New Doctor Registration</h5>
            </div>

            <form action="{{ url('Admin/RegisterThisDoctorNow') }}" method="post">
                @csrf

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Full name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mobile number <span class="text-danger">*</span></label>
                            <input type="tel" name="number" class="form-control" value="{{ old('number') }}"
                                pattern="[0-9]{10}" maxlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            <small class="text-muted">Exactly 10 digits.</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" minlength="8" required>
                        <small class="text-muted">At least 8 characters. The doctor can change it later.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <select name="city_id" class="form-select">
                                <option value="">-- Not set --</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" @selected(old('city_id') == $city->id)>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Personal address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                            <small class="text-muted">Home address, not the consultation address.</small>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex gap-2">
                    <button class="btn btn-primary"><i class="bi bi-person-plus"></i> Register</button>
                    <a href="{{ url('Admin/Doctors') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
@endsection
