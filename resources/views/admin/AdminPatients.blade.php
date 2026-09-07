@extends('admin/AdminLayout')

@section('admin-content')
    {{-- Patients --}}
    <section class="container">
        <div class="card shadow">
            <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">Patients</h5>
                <span class=" text-white">Total: {{ $patients->count() }}</span>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered align-middle m-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Number</th>
                            <th class="text-center" style="width: 1%;">Delete</th>
                            {{-- <th class="text-center" style="width: 1%;">Activity</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $index => $p)
                            <tr>
                                <th>{{ $index + 1 }}</th>
                                <td>{{ $p['name'] }}</td>
                                <td>{{ $p['email'] }}</td>
                                <td>{{ $p['number'] }}</td>

                                <td class="text-center text-nowrap">
                                    <a href="{{ url('Admin/Patient/DeleteThis', $p['id']) }}"
                                        onclick="return confirm('Are you sure? You want to delete {{ $p['name'] }} account?')">
                                        <i class="bi bi-trash"
                                            style="color:#6c757d; display:contents; position:absolute; font-size:18px; font-weight:bold; cursor:pointer; transition:0.2s;"
                                            onmouseover="this.style.color='red'; this.style.fontSize='22px'"
                                            onmouseout="this.style.color='#6c757d'; this.style.fontSize='18px'">
                                        </i>
                                    </a>
                                </td>

                                {{-- <td class="text-center text-nowrap">
                                    <a href="#">
                                        <i class="bi bi-activity"
                                            style="color:#6c757d; display:contents; position:absolute; font-size:18px; font-weight:bold; cursor:pointer; transition:0.2s;"
                                            onmouseover="this.style.color='green'; this.style.fontSize='22px'"
                                            onmouseout="this.style.color='#6c757d'; this.style.fontSize='18px'">
                                        </i>
                                    </a>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-between">
                {{ $patients->links() }}
            </div>
        </div>
    </section>
@endsection
