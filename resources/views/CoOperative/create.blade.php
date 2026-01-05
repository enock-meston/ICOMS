@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
        <div class="page-title-head d-flex align-items-center">
            <div class="flex-grow-1">
                <h4 class="fs-xl fw-bold m-0">{{ $title }}</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">ICOMS</a></li>

                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                @if (session('success'))
                    <div class="alert alert-success text-bg-success alert-dismissible" role="alert">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                            aria-label="Close"></button>

                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>


        <div class="row">
            <div class="col-md-12 col-xxl-3">
                <div class="card">
                    <div class="card-body text-center">

                        <form method="POST" action="{{ route('cooperative.user.store') }}" id="userForm" aria-multiselectable="">
                            @csrf
                            <div class="row g-3row g-3">
                                <div class=" col-md-6 mb-3">
                                    <label for="userName" class="form-label">Amazina Yombi <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="full_name" class="form-control" id="userName"
                                            placeholder="Geneva K." required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="userEmail" class="form-label">Email ye <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="email" name="email" class="form-control" id="userEmail"
                                            placeholder="you@example.com" required>
                                    </div>
                                </div>
                            </div>
                            {{--  --}}
                            <div class="row g-3row g-3">
                                <div class=" col-md-6 mb-3">
                                    <label for="userName" class="form-label">Nimero ya Telephone <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="phone" class="form-control" id="userName"
                                            placeholder="Geneva K." required>
                                    </div>
                                </div>

                                <div class=" col-md-6 mb-3">
                                    <label for="userName" class="form-label">Username <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="username" class="form-control" id="userName"
                                            placeholder="Geneva K." required>
                                    </div>
                                </div>
                            </div>


                            <div class="row g-3row g-3">
                                <div class="col-md-6 mb-3">
                                    <label for="userName" class="form-label">Department <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <Select class="form-control" name="Department_id">
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                                            @endforeach
                                        </Select>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="userName" class="form-label">Role/Umurimo <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control" name="roles[]" multiple>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                                            @endforeach
                                            </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3row g-3">
                                <div class="col-md-6 mb-3" data-password="bar">
                                    <label for="userPassword" class="form-label" id="passwordLabel">Password <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="password" value="123456" class="form-control" id="userPassword"
                                             required>
                                    </div>
                                    <div class="password-bar my-2"></div>
                                    <p class="text-muted fs-xs mb-0">Use 8+ characters with letters, numbers & symbols.</p>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-semibold py-2"
                                    id="userFormSubmit">Create
                                    Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div> <!-- end row-->

    </div><!-- end row -->



    </div>

@endsection
