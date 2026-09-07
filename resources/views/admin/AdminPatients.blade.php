@extends('admin/AdminLayout')

@section('admin-content')
    <section class="container">

        @include('admin.partials.flash')

        <div class="card shadow">
            <div class="card-header bg-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white">Patients</h5>
                <a href="{{ url('Admin/Patients/Create') }}" class="btn btn-sm btn-light">
                    <i class="bi bi-plus-lg"></i> New Patient
                </a>
            </div>

            <div class="card-body border-bottom">
                <form method="GET" action="{{ url('Admin/Patients') }}" class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control"
                            placeholder="Search by name, email or phone...">
                    </div>
                    <div class="col-md-3">
                        <select name="city_id" class="form-select">
                            <option value="">-- All cities --</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" @selected(request('city_id') == $city->id)>{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="account_status" class="form-select">
                            <option value="">-- Account --</option>
                            <option value="Active" @selected(request('account_status') === 'Active')>Active</option>
                            <option value="Inactive" @selected(request('account_status') === 'Inactive')>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary"><i class="bi bi-search"></i> Filter</button>
                        <a href="{{ url('Admin/Patients') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </form>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-bordered align-middle m-0">
                    <thead>
                        <tr>
                            <th style="width:1%">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Number</th>
                            <th>City</th>
                            <th class="text-center">Account</th>
                            <th class="text-center text-nowrap" style="width:1%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($patients as $index => $p)
                            <tr>
                                <th>{{ $patients->firstItem() + $index }}</th>
                                <td>{{ $p->name }}</td>
                                <td>{{ $p->email }}</td>
                                <td>{{ $p->number }}</td>
                                <td>{{ $cityNames[$p->city_id] ?? '—' }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $p->account_status === 'Active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $p->account_status }}
                                    </span>
                                </td>
                                <td class="text-center text-nowrap">
                                    <a href="{{ url('Admin/Patients/Show', $p->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-person-lines-fill"></i> View
                                    </a>
                                    <a href="{{ url('Admin/Patients/Edit', $p->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form method="POST"
                                        action="{{ url('Admin/User/ToggleAccountStatus', $p->id) }}" class="d-inline"
                                        onsubmit="return confirm('{{ $p->account_status === 'Active' ? 'Deactivate' : 'Reactivate' }} the account of {{ $p->name }}?')">
                                        @csrf
                                        <button
                                            class="btn btn-sm {{ $p->account_status === 'Active' ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                            <i class="bi {{ $p->account_status === 'Active' ? 'bi-lock' : 'bi-unlock' }}"></i>
                                            {{ $p->account_status === 'Active' ? 'Deactivate' : 'Reactivate' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No patients found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $patients->links() }}
            </div>
        </div>
    </section>
@endsection
