@extends('layouts.app')
@section('title', 'Edit User')
@section('page-title')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
            Edit Admin
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
            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body p-9">
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="name" class="fs-6 fw-bold mt-2 mb-3">Nama</label>
                        </div>
                        <div class="col-lg">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror "
                                value="{{ old('name') ? old('name') : $user->name ?? '' }}" placeholder="Nama User " />
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
                                value="{{ old('email') ? old('email') : $user->email ?? '' }}" placeholder="Email" />
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="password" class="fs-6 fw-bold mt-2 mb-3">password</label>
                        </div>
                        <div class="col-lg">
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror "
                                placeholder="Password Baru " />
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="pendidikan" class="fs-6 fw-bold mt-2 mb-3">Role</label>
                        </div>
                        <div class="col-lg">
                            <select name="role" class="form-select  @error('role') is-invalid @enderror "
                                value="{{ old('role') ? old('role') : $user->role ?? '' }}" data-control="select2"
                                data-hide-search="true">
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
                            <label for="pendidikan" class="fs-6 fw-bold mt-2 mb-3">Role</label>
                        </div>
                        <div class="col-lg">
                            <select name="gender" class="form-select  @error('gender') is-invalid @enderror "
                                value="{{ old('gender') ? old('gender') : $user->gender ?? '' }}" data-control="select2"
                                data-hide-search="true">
                                <option {{ $user->gender == 'Laki-laki' ? 'selected' : '' }} value="Laki-laki">Laki-laki</option>
                                <option {{ $user->gender == 'Perempuan' ? 'selected' : '' }} value="Perempuan">Perempuan</option>
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
                            <label for="alamat" class="fs-6 fw-bold mt-2 mb-3">Alamat</label>
                        </div>
                        <div class="col-lg">
                            <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror "
                                value="{{ old('alamat') ? old('alamat') : $user->alamat ?? '' }}"
                                placeholder="Alamat " />
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
        $(document).on("click", "#delete-confirm", function(e) {
            Swal.fire({
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-light'
                },
                title: 'Apakah anda yakin?',
                text: "Apakah anda yakin ingin menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.preventDefault();
                    var id = $(this).data("id");
                    var token = $("meta[name='csrf-token']").attr("article");
                    var url = e.target;
                    var route = `articles/${id}/destroy`;
                    $.ajax({
                        url: route,
                        type: 'DELETE',
                        data: {
                            _token: token,
                            id: id
                        },
                    });
                    location.reload();
                    return false;
                }
            })
        });
    </script>
@endpush
