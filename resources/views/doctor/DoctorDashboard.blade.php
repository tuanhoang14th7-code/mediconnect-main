@extends('doctor/DoctorLayout')

@section('doctor-content')
    <section class="container my-4">

        <div class="card shadow mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4 class="mb-1">{{ $user->name }}</h4>
                <span class="badge bg-success">{{ $doctor->status }}</span>
            </div>
        </div>

        @if (session('infoSave'))
            <div style="color: green; margin: 10px;">{{ session('infoSave') }}</div>
        @endif


        <!-- Appointments Table -->
        <div class="card shadow">
            <div class="card-header bg-dark">
                <h5 class="mb-0 text-white">Appointments</h5>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Patient</th>
                            <th>Contact</th>
                            <th>Day</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($doctor->appointment as $index => $app)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $app->name }}</td>
                                <td>{{ $app->number }}</td>
                                <td>{{ $app->day }}</td>
                                <td>{{ $app->date }}</td>
                                <td>{{ \Carbon\Carbon::parse($app->time)->format('h:i A') }}</td>

                                <!-- Status Badge -->
                                <td>
                                    @if ($app->status == 'Pending')
                                        <span class="badge bg-warning text-black">Pending</span>
                                    @elseif($app->status == 'Approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($app->status == 'Rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @elseif($app['status'] == 'Cancel')
                                        <span class="badge bg-info">Cancel</span>
                                    @else
                                        <span class="badge bg-primary">Completed</span>
                                    @endif
                                </td>

                                <!-- Action Buttons -->
                                <td>
                                    @if ($app->status == 'Pending')
                                        <form action="{{ url('Doctor/Appointment/UpdateStatus') }}" method="POST"
                                            class="d-flex gap-1 justify-content-center">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $app->id }}">
                                            <button name="status" value="Approved" class="btn btn-success btn-sm">
                                                ✔ Approve
                                            </button>

                                            <button name="status" value="Rejected" class="btn btn-danger btn-sm">
                                                ✖ Reject
                                            </button>
                                        </form>
                                    @elseif($app->status == 'Approved')
                                        <form action="{{ url('Doctor/Appointment/UpdateStatus') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $app->id }}">
                                            <button name="status" value="Completed" class="btn btn-primary btn-sm">
                                                ✔ Complete
                                            </button>

                                            <button name="status" value="Rejected" class="btn btn-danger btn-sm">
                                                ✖ Reject
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">No Action</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">No appointments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
