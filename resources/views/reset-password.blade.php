@extends('layout')

@section('main-content')
    <div class="container my-5 h-100">
        <div class="appointment-wrapper position-relative d-center w-100">
            <div style="height: 750px">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="/reset-password" class="appointment-forms">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="row g-lg-3 g-3">
                        <div class="col-lg-12">
                            <input type="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="col-lg-12">
                            <input type="password" id="password" name="password" placeholder="New Password" required>
                        </div>
                        <div class="col-lg-12">
                            <input type="password" id="c_password" name="password_confirmation"
                                placeholder="Confirm Password" required>
                        </div>
                        <div class="col-lg-12" id="password_okay"></div>
                        <div class="col-lg-12">
                            <button type="submit"
                                class="common-btn box-style p2-bg w-100 text-nowrap d-inline-flex justify-content-center align-items-center gap-xxl-2 gap-2 fs18 fw-semibold white overflow-hidden rounded100 wow fadeInRight"
                                data-wow-delay="0.8s">
                                Reset Password
                                <img src="{{ asset('assets/img/icon/arrow-right-white.png') }}" alt="icon">
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('c_password');
        const messageDiv = document.getElementById('password_okay');

        function checkPassword() {
            if (confirmPassword.value === "") {
                messageDiv.innerHTML = "";
                return;
            }

            if (password.value !== confirmPassword.value) {
                messageDiv.innerHTML =
                    '<small class="text-danger">Passwords do not match, Please confirm your password</small>';
            } else {
                messageDiv.innerHTML = '<small class="text-success">Passwords matched ✔</small>';
            }
        }

        password.addEventListener('keyup', checkPassword);
        confirmPassword.addEventListener('keyup', checkPassword);
    </script>
@endsection
