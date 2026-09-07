@extends('admin/AdminLayout')

@section('admin-content')
    <section class="container">

        @include('admin.partials.flash')

        <div class="helper-note">
            Editing the account details and professional profile. Facility, room and consultation fee are managed
            under <a href="{{ url('Admin/DoctorAssignments') }}">Doctor Assignments</a>.
        </div>

        <div class="card shadow">
            <div class="card-header bg-dark">
                <h5 class="mb-0 text-white">Edit Doctor &mdash; {{ $user->name }}</h5>
            </div>

            <form action="{{ url('Admin/Doctor/SaveThisEditedDetailsNow') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $doctor->id }}">
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <div class="card-body">

                    <h6 class="text-uppercase small fw-bold text-muted mb-3">Account</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Full name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Mobile number <span class="text-danger">*</span></label>
                            <input type="tel" name="number" class="form-control"
                                value="{{ old('number', $user->number) }}" pattern="[0-9]{10}" maxlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">City</label>
                            <select name="city_id" class="form-select">
                                <option value="">-- Not set --</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" @selected(old('city_id', $user->city_id) == $city->id)>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label class="form-label">Personal address</label>
                            <input type="text" name="address" class="form-control"
                                value="{{ old('address', $user->address) }}">
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="text-uppercase small fw-bold text-muted mb-3">Professional profile</h6>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expertise <span class="text-danger">*</span></label>
                                    <input type="text" name="expertise" class="form-control"
                                        value="{{ old('expertise', $doctor->expertise) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Years of experience <span class="text-danger">*</span></label>
                                    <input type="number" name="experience" class="form-control" min="0" max="80"
                                        value="{{ old('experience', $doctor->experience) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Education <span class="text-danger">*</span></label>
                                    <input type="text" name="education" class="form-control"
                                        value="{{ old('education', $doctor->education) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Profession title <span class="text-danger">*</span></label>
                                    <input type="text" name="profession" class="form-control"
                                        value="{{ old('profession', $doctor->profession) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">License number</label>
                                    <input type="text" name="license_number" class="form-control"
                                        value="{{ old('license_number', $doctor->license_number) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select" required>
                                        <option value="Active" @selected(old('status', $doctor->status) === 'Active')>Active</option>
                                        <option value="Inactive" @selected(old('status', $doctor->status) === 'Inactive')>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Qualifications</label>
                                <textarea name="qualifications" class="form-control" rows="2">{{ old('qualifications', $doctor->qualifications) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Bio</label>
                                <textarea name="bio" class="form-control" rows="3">{{ old('bio', $doctor->bio) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Profile photo</label>
                            <img id="preview" src="{{ asset('upload/doctors/' . $doctor->image) }}" alt="Doctor photo"
                                class="img-fluid rounded mb-2" style="border:1px solid #e4e9f0;">
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            <small class="text-muted">Leave empty to keep the current photo.</small>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex gap-2">
                    <button class="btn btn-primary"><i class="bi bi-save"></i> Save changes</button>
                    <a href="{{ url('Admin/DoctorProfile', $user->id) }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.getElementById("image").addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (file) {
                document.getElementById("preview").src = URL.createObjectURL(file);
            }
        });
    </script>
@endsection
