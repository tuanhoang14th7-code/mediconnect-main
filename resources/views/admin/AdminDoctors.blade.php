@extends('admin/AdminLayout')

@section('admin-content')
    {{-- Doctor's --}}
    <section class="container">
        <div class="card shadow">
            <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0  text-white">Doctor's</h5>
                <span class=" text-white">Total: {{ $doctors->count() }}</span>
            </div>

            @if (session('DoctorDeletedDone'))
                <div style="color: green; margin: 10px;">{{ session('DoctorDeletedDone') }}</div>
            @endif
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-hover align-middle text-center m-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Number</th>
                            <th>Status</th>
                            <th>Delete</th>
                            <th>Profile</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($doctors as $index => $d)
                            <tr>
                                <th>{{ $index + 1 }}</th>
                                <td>{{ $d['name'] }}</td>
                                <td>{{ $d['email'] }}</td>
                                <td>{{ $d['number'] }}</td>

                                <td>
                                    <form action="{{ url('Admin/Doctor/updateStatus') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $d->doctorDetails->id }}">
                                        <input type="hidden" name="name" value="{{ $d['name'] }}">
                                        <button type="submit" name="status" value="{{ $d->doctorDetails->status }}"
                                            class="btn btn-sm {{ $d->doctorDetails->status == 'Active' ? 'btn-success' : 'btn-danger' }}"
                                            style="transition: all 0.2s ease;"
                                            onmouseover="this.style.transform='scale(1.1)';"
                                            onmouseout="this.style.transform='scale(1)';">
                                            {{ $d->doctorDetails->status }}
                                        </button>
                                    </form>
                                </td>

                                <td class="text-center text-nowrap">
                                    <a href="{{ url('Admin/Doctor/DeleteThis', $d['id']) }}"
                                        onclick="return confirm('Are you sure? You want to delete {{ $d['name'] }} account?')">
                                        <i class="bi bi-trash"
                                            style="color:#6c757d; display:contents; position:absolute; font-size:18px; font-weight:bold; cursor:pointer; transition:0.2s;"
                                            onmouseover="this.style.color='red'; this.style.fontSize='22px'"
                                            onmouseout="this.style.color='#6c757d'; this.style.fontSize='18px'">
                                        </i>
                                    </a>
                                </td>

                                <td class="text-center text-nowrap">
                                    {{-- <a href="{{ url('Admin/AdminDoctorDetailsForm', $d['id']) }}"> --}}
                                    <a href="{{ url('Admin/DoctorProfile', $d['id']) }}">
                                        <i class="bi bi-person-lines-fill"
                                            style="color:#6c757d; cursor:pointer; display:contents; position:absolute; font-size:18px; font-weight:bold; cursor:pointer; transition:0.2s;"
                                            onmouseover="this.style.color='green'; this.style.fontSize='22px'"
                                            onmouseout="this.style.color='#6c757d'; this.style.fontSize='18px'">
                                        </i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-between">
                {{ $doctors->links() }}
            </div>
        </div>

    </section>
@endsection
