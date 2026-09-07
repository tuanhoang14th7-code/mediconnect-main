@extends('patient.PatientLayout')

@section('patient-content')
    <div class="container my-5 min-vh-100">
        @if (session('update'))
            <p style="color: rgb(8, 126, 126); font-weight:bold;">{{ session('update') }}</p>
        @endif
        <div class="card shadow">
            <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">Appointment History</h5>
                {{-- <span class=" text-white">Total: {{ $appointments->count() }}</span> --}}
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-hover align-middle text-center m-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Doctor</th>
                            <th>Day</th>
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
                                <td>{{ $app['name'] }}</td>
                                <td>{{ $app['number'] }}</td>
                                <td>{{ $app['doctor_name'] }}</td>
                                <td>{{ $app['day'] }}</td>
                                <td>{{ $app['date'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($app['time'])->format('h:i A') }}</td>

                                <td>
                                    @if ($app['status'] == 'Pending')
                                        <span class="badge bg-warning text-black">Pending</span>
                                    @elseif($app['status'] == 'Approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($app['status'] == 'Rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @elseif($app['status'] == 'Cancel')
                                        <span class="badge bg-info">Cancel</span>
                                    @else
                                        <span class="badge bg-primary">Completed</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($app['status'] == 'Pending' || $app['status'] == 'Approved')
                                        <form action="{{ url('Patient/Appointment/UpdateStatus') }}" method="POST"
                                            class="d-flex gap-1 justify-content-center">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $app['id'] }}">
                                            <button name="status" value="Cancel" class="btn btn-sm btn-danger">
                                                Cancel
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
                {{-- {{ $appointments->links() }} --}}
            </div>
        </div>
    </div>
@endsection
