@extends('admin/AdminLayout')

@section('admin-content')
    <section class="container">

        @include('admin.partials.flash')

        <div class="card shadow">
            <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">City</h5>
                <a href="{{ url('Admin/Cities/Create') }}" class="btn btn-sm btn-light">
                    <i class="bi bi-plus-lg"></i> Add City
                </a>
            </div>

            <div class="card-body border-bottom">
                <form method="GET" action="{{ url('Admin/Cities') }}" class="row g-2">
                    <div class="col-md-5">
                        <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control"
                            placeholder="Search by city name...">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">-- All statuses --</option>
                            <option value="Active" @selected(request('status') === 'Active')>Active</option>
                            <option value="Inactive" @selected(request('status') === 'Inactive')>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary"><i class="bi bi-search"></i> Filter</button>
                        <a href="{{ url('Admin/Cities') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-bordered align-middle m-0">
                    <thead>
                        <tr>
                            <th style="width:1%">#</th>
                            <th>City name</th>
                            <th>State</th>
                            <th>Country</th>
                            <th class="text-center">Facilities</th>
                            <th class="text-center">Status</th>
                            <th class="text-center text-nowrap" style="width:1%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cities as $index => $city)
                            <tr>
                                <th>{{ $cities->firstItem() + $index }}</th>
                                <td>{{ $city->name }}</td>
                                <td>{{ $city->state ?? '—' }}</td>
                                <td>{{ $city->country }}</td>
                                <td class="text-center">{{ $city->facilities_count }}</td>
                                <td class="text-center">
                                    <form method="POST" action="{{ url('Admin/Cities/ToggleStatus', $city->id) }}"
                                        class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm status-pill {{ $city->status === 'Active' ? 'btn-success' : 'btn-secondary' }}"
                                            title="Click to toggle status">
                                            {{ $city->status }}
                                        </button>
                                    </form>
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="{{ url('Admin/Cities/Edit', $city->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ url('Admin/Cities/Delete', $city->id) }}" class="d-inline"
                                        onsubmit="return confirm('Delete city {{ $city->name }}?')">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No cities yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $cities->links() }}
            </div>
        </div>
    </section>
@endsection
