@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title-head d-flex align-items-center">
            <div class="flex-grow-1">
                <h4 class="fs-xl fw-bold m-0">{{ $title }}</h4>
            </div>
            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">ICOMS</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card border p-3">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <button type="button" onclick="setAction('INSERT')" data-bs-toggle="modal"
                            data-bs-target="#compostModal"
                            class="btn btn-sm btn-primary">Start New Production
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Compost Production List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
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
                                    <tr>
                                        <td colspan="7" class="text-center">No production records found.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Compost Modal -->
    <div class="modal fade" id="compostModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="compostModalTitle">Start New Production</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        @csrf
                        <input type="hidden" name="id" id="compost_id">
                        <input type="hidden" name="action" id="compost_action">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Group</label>
                                <select name="group_id" id="group_id" class="form-select" required>
                                    <option value="" disabled selected>Select Group</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Season</label>
                                <select name="season_id" id="season_id" class="form-select" required>
                                    <option value="" disabled selected>Select Season</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Material Type</label>
                                <input type="text" name="material_type" id="material_type" class="form-control" placeholder="e.g. Organic, Bio" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Qty Produced (kg)</label>
                                <input type="number" name="qty_produced_kg" id="qty_produced_kg" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Start Date</label>
                                <input type="date" name="production_start" id="production_start" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">End Date</label>
                                <input type="date" name="production_end" id="production_end" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="IN_PROGRESS">IN_PROGRESS</option>
                                    <option value="COMPLETED">COMPLETED</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button type="button" id="compostMainActionBtn" class="btn btn-primary" onclick="alert('Action placeholder')">Save Production</button>
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
            const form = document.querySelector('#compostModal form');

            actionInput.value = action;
            btn.classList.remove("btn-info", "btn-success", "btn-primary", "btn-danger");
            
            if (action === 'INSERT') {
                form.reset();
                document.getElementById('compost_id').value = '';
                btn.innerText = 'Start Production';
                btn.disabled = false;
                title.innerText = 'Start New Production';
                btn.classList.add("btn-primary");
            }
        }
    </script>
@endsection
