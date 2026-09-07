@extends('patient.PatientLayout')

@section('patient-content')

<div class="container my-5 min-vh-100">

    {{-- Header --}}
    <div class="d-flex
                justify-content-between
                align-items-center
                flex-wrap
                gap-3
                mb-4">

        <div>

            <h2 class="black mb-2">
                Notifications
            </h2>

            <p class="pra mb-0">
                View updates about your appointments.
            </p>

        </div>


        @if ($notifications->whereNull('read_at')->count() > 0)

            <form
                action="{{ route(
                    'patient.notifications.readAll'
                ) }}"
                method="POST"
            >

                @csrf

                <button
                    type="submit"
                    class="btn btn-outline-success rounded-pill px-4"
                >
                    Mark All as Read
                </button>

            </form>

        @endif

    </div>


    {{-- Success --}}
    @if (session('success'))

        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>

    @endif


    {{-- No Notifications --}}
    @if ($notifications->isEmpty())

        <div class="bg-white
                    rounded-4
                    shadow-sm
                    p-5
                    text-center">

            <h4 class="black mb-2">
                No Notifications
            </h4>

            <p class="pra mb-0">
                You do not have any notifications yet.
            </p>

        </div>

    @else

        <div class="d-flex flex-column gap-3">

            @foreach ($notifications as $notification)

                @php
                    $data = $notification->data;

                    $isUnread =
                        is_null($notification->read_at);
                @endphp


                <div
                    class="rounded-4 p-4
                           {{ $isUnread
                               ? 'border border-success bg-white shadow-sm'
                               : 'border bg-light' }}"
                >

                    <div class="d-flex
                                justify-content-between
                                align-items-start
                                gap-3">

                        <div class="flex-grow-1">

                            {{-- Unread marker --}}
                            @if ($isUnread)

                                <span
                                    class="badge bg-success mb-2"
                                >
                                    New
                                </span>

                            @endif


                            <h5 class="black mb-2">

                                {{ $data['title']
                                    ?? 'Notification' }}

                            </h5>


                            <p class="pra mb-2">

                                {{ $data['message']
                                    ?? 'You have a new notification.' }}

                            </p>


                            <small class="text-muted">

                                {{ $notification->created_at
                                    ? $notification->created_at
                                        ->format('d/m/Y H:i')
                                    : '' }}

                            </small>

                        </div>


                        @if ($isUnread)

                            <form
                                action="{{ route(
                                    'patient.notifications.read',
                                    $notification->id
                                ) }}"
                                method="POST"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="btn btn-sm
                                           btn-outline-success
                                           rounded-pill"
                                >
                                    Mark as Read
                                </button>

                            </form>

                        @else

                            <span class="text-muted small">
                                Read
                            </span>

                        @endif

                    </div>


                    {{-- Appointment link --}}
                    @if (!empty($data['appointment_id']))

                        <div class="mt-3">

                            <a
                                href="{{ route(
                                    'patient.appointments.show',
                                    $data['appointment_id']
                                ) }}"
                                class="text-decoration-none fw-semibold"
                            >
                                View Appointment →
                            </a>

                        </div>

                    @endif

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection