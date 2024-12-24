@extends('layouts.app')
@section('title', 'Tambah User')
@section('page-title')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
            Tambah Supplier
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
            <form action="{{ route('supplier.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-9">
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="name" class="fs-6 fw-bold mt-2 mb-3">Nama</label>
                        </div>
                        <div class="col-lg">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror "
                                placeholder="Nama Supplier " />
                            @error('name')
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
                            <label for="nohandphone" class="fs-6 fw-bold mt-2 mb-3">No handphone    </label>
                        </div>
                        <div class="col-lg">
                            <input type="text" name="nohandphone"
                                class="form-control @error('nohandphone') is-invalid @enderror " placeholder="nohandphone " />
                            @error('nohandphone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('supplier.index') }}" type="reset"
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
