@extends('admin/AdminLayout')

@section('admin-content')
    <section class="container">

        @include('admin.partials.flash')

        @if (session('DoctorRegisterOKay'))
            <div class="alert alert-success">{{ session('DoctorRegisterOKay') }}</div>
        @endif
        @if (session('DoctorDetailsNotFound'))
            <div class="alert alert-warning">{{ session('DoctorDetailsNotFound') }} Please fill in this form.</div>
        @endif

        <div class="helper-note">
            Step 2 of 3 &mdash; professional profile only. Facility, room and consultation fee are set afterwards
            under <a href="{{ url('Admin/DoctorAssignments') }}">Doctor Assignments</a>; the working schedule is
            managed by the doctor.
        </div>

        <div class="card shadow">
            <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">Doctor Professional Profile</h5>
                <span class="text-white small">
                    {{ $doctor->name }} &nbsp;|&nbsp; {{ $doctor->email }} &nbsp;|&nbsp; {{ $doctor->number }}
                </span>
            </div>

            <form action="{{ url('Admin/AddThisDoctorDetailsNow') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $doctor->id }}">

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expertise <span class="text-danger">*</span></label>
                                    <input type="text" name="expertise" class="form-control"
                                        value="{{ old('expertise') }}" placeholder="e.g. Dermatology" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Years of experience <span class="text-danger">*</span></label>
                                    <input type="number" name="experience" class="form-control" min="0" max="80"
                                        value="{{ old('experience', 0) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Education <span class="text-danger">*</span></label>
                                    <input type="text" name="education" class="form-control"
                                        value="{{ old('education') }}" placeholder="e.g. MBBS, MD Dermatology" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Profession title <span class="text-danger">*</span></label>
                                    <input type="text" name="profession" class="form-control"
                                        value="{{ old('profession') }}" placeholder="e.g. Skin Specialist" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">License number</label>
                                    <input type="text" name="license_number" class="form-control"
                                        value="{{ old('license_number') }}" placeholder="e.g. MED-201">
                                    <small class="text-muted">Must be unique across all doctors.</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select" required>
                                        <option value="Active" @selected(old('status', 'Active') === 'Active')>Active</option>
                                        <option value="Inactive" @selected(old('status') === 'Inactive')>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Qualifications</label>
                                <textarea name="qualifications" class="form-control" rows="2"
                                    placeholder="e.g. MBBS; MD Dermatology">{{ old('qualifications') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Bio</label>
                                <textarea name="bio" class="form-control" rows="3"
                                    placeholder="Short introduction shown to patients">{{ old('bio') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Profile photo <span class="text-danger">*</span></label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                            <img id="preview" src="" alt="Preview"
                                class="img-fluid rounded mt-3" style="display:none; border:1px solid #e4e9f0;">
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex gap-2">
                    <button class="btn btn-primary"><i class="bi bi-save"></i> Save profile</button>
                    <a href="{{ url('Admin/Doctors') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.getElementById("image").addEventListener("change", function (event) {
            const file = event.target.files[0];
            if (file) {
                const preview = document.getElementById("preview");
                preview.src = URL.createObjectURL(file);
                preview.style.display = "block";
            }
        });
    </script>
@endsection
