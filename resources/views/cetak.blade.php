@extends('layouts.app')
@section('title')
    {{ Route::is('admin.*') ? 'Super Admin' : 'User' }}
@endsection
@section('page-title')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
            Cetak Laporan
        </h1>
    </div>
@endsection
@section('content')
    <div class="card card-docs flex-row-fluid mb-2">
        <div class="card-body fs-6 text-gray-700">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center text-center my-0">

                </h1>
            </div>
            <form action="{{ route('cetak.pdf') }}" method="POST" target="_blank">
                @csrf
                <div class="row mb-5">
                    <div class="col-xl-3">
                        <label for="start_date" class="fs-6 fw-bold mt-2 mb-3">Tanggal Awal</label>
                    </div>
                    <div class="col-lg">
                        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" />
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            
                <div class="row mb-5">
                    <div class="col-xl-3">
                        <label for="end_date" class="fs-6 fw-bold mt-2 mb-3">Tanggal Akhir</label>
                    </div>
                    <div class="col-lg">
                        <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" />
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            
                <div class="row mb-5">
                    <div class="col-xl-3">
                        <label for="status" class="fs-6 fw-bold mt-2 mb-3">Status Laporan</label>
                    </div>
                    <div class="col-lg">
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="">Pilih Status</option>
                            <option value="tersedia">Barang Tersedia</option>
                            <option value="masuk">Barang Masuk</option>
                            <option value="keluar">Barang Keluar</option>
                            <option value="rusak">Barang Rusak</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-secondary">Cetak PDF</button>
                </div>
            </form>
            
        </div>
    </div>
@endsection

