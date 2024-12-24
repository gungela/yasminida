@extends('layouts.app')
@section('title', 'Tambah User')
@section('page-title')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
            Tambah Admin
        </h1>
    </div>
@endsection
@push('styles')
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush
@section('content')
    <div class="card card-docs flex-row-fluid mb-2">
        <div class="card-body fs-6 text-gray-700">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center text-center my-0">
                
                </h1>
            </div>
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-9">
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="name" class="fs-6 fw-bold mt-2 mb-3">Nama</label>
                        </div>
                        <div class="col-lg">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror "
                                placeholder="Nama User " />
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="email" class="fs-6 fw-bold mt-2 mb-3">Email</label>
                        </div>
                        <div class="col-lg">
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror "
                                placeholder="Email" />
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>


                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="password" class="fs-6 fw-bold mt-2 mb-3">Password</label>
                        </div>
                        <div class="col-lg">
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror " placeholder="Password" />
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Konfirmasi Password -->
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="password_confirmation" class="fs-6 fw-bold mt-2 mb-3">Konfirmasi Password</label>
                        </div>
                        <div class="col-lg">
                            <input type="password" name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="Konfirmasi Password" />
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="gender" class="fs-6 fw-bold mt-2 mb-3">Jenis Kelamin</label>
                        </div>
                        <div class="col-lg">
                            <select name="gender"
                                class="form-select custom-placeholder  @error('gender') is-invalid @enderror "
                                data-control="select2" data-placeholder="Pilih Gender">
                                <option value="" disabled selected>Pilih Jenis kelamin</option>
                                <option {{ $user->gender == 'Laki-laki' ? 'selected' : '' }} value="Laki-laki">Laki-laki
                                </option>
                                <option {{ $user->gender == 'Perempuan' ? 'selected' : '' }} value="Perempuan">Perempuan
                                </option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="role" class="fs-6 fw-bold mt-2 mb-3">Role</label>
                        </div>
                        <div class="col-lg">
                            <select name="role"
                                class="form-select custom-placeholder  @error('role') is-invalid @enderror "
                                data-control="select2" data-placeholder="Pilih Status">
                                <option value="" disabled selected>Pilih Status</option>
                                <option {{ $user->role == 'manager' ? 'selected' : '' }} value="manager">Manager</option>
                                <option {{ $user->role == 'admin' ? 'selected' : '' }} value="admin">Admin</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="alamat" class="fs-6 fw-bold mt-2 mb-3">Alamat</label>
                        </div>
                        <div class="col-lg">
                            <input type="text" name="alamat"
                                class="form-control @error('alamat') is-invalid @enderror " placeholder="Alamat " />
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('user.index') }}" type="reset"
                        class="btn btn-light btn-active-light-primary me-2">Batalkan</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const inputs = document.querySelectorAll('.custom-placeholder');

        inputs.forEach(function(input) {
            const originalPlaceholder = input.getAttribute('data-placeholder');

            input.addEventListener('focus', function() {
                this.setAttribute('placeholder', originalPlaceholder);
            });

            input.addEventListener('blur', function() {
                this.removeAttribute('placeholder');
            });
        });
    </script>
@endpush
