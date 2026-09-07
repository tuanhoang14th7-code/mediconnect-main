@extends('admin/AdminLayout')

@section('admin-content')
    <div class="container">

        <!-- Appointments Table -->
        <div class="card shadow">
            <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0  text-white">Appointments</h5>
                <span class=" text-white">Total: {{ $appointments->total() }}</span>
            </div>

            <div class="card-body">
                <form action="{{ url('Admin/Appointments') }}" method="GET" class="row g-2 mb-3">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="Search by appointment number or patient name"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            @foreach (['Pending', 'Confirmed', 'Rejected', 'Cancelled', 'Completed', 'NoShow'] as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-info">Search</button>
                        <a href="{{ url('Admin/Appointments') }}" class="btn btn-warning">Clear</a>
                    </div>
                </form>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-hover align-middle text-center m-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Appointment No.</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($appointments as $index => $app)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $app->appointment_number }}</td>
                                <td>{{ $app->patient_name }}</td>
                                <td>{{ $app->doctorAssignment->doctor->user->name ?? 'N/A' }}</td>
                                <td>{{ $app->appointment_date->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($app->start_time)->format('h:i A') }}</td>

                                <td>
                                    @if ($app->status == 'Pending')
                                        <span class="badge bg-warning text-black">Pending</span>
                                    @elseif($app->status == 'Confirmed')
                                        <span class="badge bg-success">Confirmed</span>
                                    @elseif($app->status == 'Rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @elseif($app->status == 'Cancelled')
                                        <span class="badge bg-secondary">Cancelled</span>
                                    @elseif($app->status == 'NoShow')
                                        <span class="badge bg-dark">No Show</span>
                                    @else
                                        <span class="badge bg-primary">Completed</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($app->status == 'Pending')
                                        <form action="{{ url('Admin/Appointment/UpdateStatus') }}" method="POST"
                                            class="d-flex gap-1 justify-content-center">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $app->id }}">
                                            <button name="status" value="Confirmed" class="btn btn-success btn-sm">
                                                ✔ Confirm
                                            </button>

                                            <button name="status" value="Rejected" class="btn btn-danger btn-sm">
                                                ✖ Reject
                                            </button>
                                        </form>
                                    @elseif($app->status == 'Confirmed')
                                        <form action="{{ url('Admin/Appointment/UpdateStatus') }}" method="POST">
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
            <div class="card-footer d-flex justify-content-between">
                {{ $appointments->links() }}
            </div>
        </div>

    </div>
@endsection
