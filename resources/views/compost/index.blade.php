@extends('layouts.admin.app')

@section('content')

    <div class="container-fluid">

        <!-- Page Title -->
        <div class="page-title-head d-flex align-items-center">
            <div class="flex-grow-1">
                <h4 class="fs-xl fw-bold m-0">{{ $title }}</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item">ICOMS</li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>

        <!-- Add Button -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card border p-3">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" onclick="setAction('INSERT')" data-bs-toggle="modal"
                            data-bs-target="#compostModal" class="btn btn-sm btn-primary">
                            Start New Production
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success text-bg-success alert-dismissible">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                {{ session('success') }}
            </div>
        @endif
        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Compost Production List</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Group</th>
                                    <th>Season</th>
                                    <th>Material</th>
                                    <th>Qty Produced (kg)</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($CompostGroupProductions as $i => $item)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $item->group->name ?? '-' }}</td>
                                        <td>{{ $item->season->name ?? '-' }}</td>
                                        <td>{{ $item->material_type }}</td>
                                        <td>{{ $item->qty_produced_kg }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            <!-- VIEW -->
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#compostModal" onclick="setAction('VIEW',this)"
                                                data-id="{{ $item->id }}" data-group_id="{{ $item->group_id }}"
                                                data-season_id="{{ $item->season_id }}"
                                                data-material_type="{{ $item->material_type }}"
                                                data-qty_produced_kg="{{ $item->qty_produced_kg }}"
                                                data-estimated_value="{{ $item->estimated_value }}"
                                                data-production_start="{{ $item->production_start }}"
                                                data-production_end="{{ $item->production_end }}"
                                                data-status="{{ $item->status }}">
                                                View
                                            </button>
                                            <!-- UPDATE -->
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#compostModal" onclick="setAction('UPDATE',this)"
                                                data-id="{{ $item->id }}" data-group_id="{{ $item->group_id }}"
                                                data-season_id="{{ $item->season_id }}"
                                                data-material_type="{{ $item->material_type }}"
                                                data-qty_produced_kg="{{ $item->qty_produced_kg }}"
                                                data-estimated_value="{{ $item->estimated_value }}"
                                                data-production_start="{{ $item->production_start }}"
                                                data-production_end="{{ $item->production_end }}"
                                                data-status="{{ $item->status }}">
                                                Edit
                                            </button>
                                            <!-- DELETE -->
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#compostModal" onclick="setAction('DELETE',this)"
                                                data-id="{{ $item->id }}" data-group_id="{{ $item->group_id }}"
                                                data-season_id="{{ $item->season_id }}"
                                                data-material_type="{{ $item->material_type }}"
                                                data-qty_produced_kg="{{ $item->qty_produced_kg }}"
                                                data-estimated_value="{{ $item->estimated_value }}"
                                                data-production_start="{{ $item->production_start }}"
                                                data-production_end="{{ $item->production_end }}"
                                                data-status="{{ $item->status }}">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            No production records found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL -->

    <div class="modal fade" id="compostModal">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="compostModalTitle">
                        Start Production
                    </h4>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('compost.store') }}">
                        @csrf
                        <input type="hidden" name="id" id="compost_id">
                        <input type="hidden" name="action" id="compost_action">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Group</label>
                                <select name="group_id" id="group_id" class="form-select">
                                    <option value="">Select Group</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Season</label>
                                <select name="season_id" id="season_id" class="form-select">
                                    <option value="">Select Season</option>
                                    @foreach ($seasons as $season)
                                        <option value="{{ $season->id }}">
                                            {{ $season->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Material Type</label>
                                {{-- <input type="text" name="material_type" id="material_type" class="form-control"> --}}
                                <select name="material_type" id="material_type" class="form-select">
                                    <option value="">Select Material Type</option>
                                    <option value="grass">Grass</option>
                                    <option value="manure">Manure</option>
                                    <option value="rice_husks">Rice Husks</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Qty Produced (kg)</label>
                                <input type="number" name="qty_produced_kg" id="qty_produced_kg" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Estimated Value</label>
                                <input type="number" name="estimated_value" id="estimated_value" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="production_start" id="production_start"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">End Date</label>
                                <input type="date" name="production_end" id="production_end" class="form-control">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Status</label>
                                <select name="status" id="status1" class="form-select">
                                    <option value="IN_PROGRESS">IN_PROGRESS</option>
                                    <option value="READY">READY</option>
                                    <option value="SOLD">SOLD</option>
                                    <option value="USED">USED</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 d-grid mb-4">
                            <button type="submit" id="compostMainActionBtn" class="btn btn-primary">
                                Save Production
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function setAction(action, el = null) {
            const btn = document.getElementById('compostMainActionBtn');
            const actionInput = document.getElementById("compost_action");
            const title = document.getElementById('compostModalTitle');
            actionInput.value = action;
            btn.classList.remove("btn-info", "btn-success", "btn-danger", "btn-primary");
            if (action === 'INSERT') {
                document.querySelector('#compostModal form').reset();
                document.getElementById('compost_id').value = '';
                btn.innerText = "Start Production";
                title.innerText = "Start New Production";
                btn.disabled = false;
                disableForm(false);
                btn.classList.add("btn-primary");
            }
            if (el) {
                document.getElementById('compost_id').value = el.dataset.id || '';
                document.getElementById('group_id').value = el.dataset.group_id || '';
                document.getElementById('season_id').value = el.dataset.season_id || '';
                document.getElementById('material_type').value = el.dataset.material_type || '';
                document.getElementById('qty_produced_kg').value = el.dataset.qty_produced_kg || '';
                document.getElementById('estimated_value').value = el.dataset.estimated_value || '';
                document.getElementById('production_start').value = el.dataset.production_start || '';
                document.getElementById('production_end').value = el.dataset.production_end || '';
                document.getElementById('status1').value = el.dataset.status || '';
            }
            if (action === 'VIEW') {
                btn.innerText = "View Production";
                title.innerText = "View Production";
                btn.disabled = true;
                disableForm(true);
                btn.classList.add("btn-info");
            }
            if (action === 'UPDATE') {
                btn.innerText = "Update Production";
                title.innerText = "Update Production";
                btn.disabled = false;
                disableForm(false);
                btn.classList.add("btn-success");
            }
            if (action === 'DELETE') {
                btn.innerText = "Delete Production";
                title.innerText = "Delete Production";
                btn.disabled = false;
                disableForm(true);
                btn.classList.add("btn-danger");
            }
        }
        function disableForm(disabled) {
            document.getElementById('group_id').disabled = disabled;
            document.getElementById('season_id').disabled = disabled;
            document.getElementById('material_type').disabled = disabled;
            document.getElementById('qty_produced_kg').disabled = disabled;
            document.getElementById('estimated_value').disabled = disabled;
            document.getElementById('production_start').disabled = disabled;
            document.getElementById('production_end').disabled = disabled;
            document.getElementById('status1').disabled = disabled;
        }
    </script>

@endsection
