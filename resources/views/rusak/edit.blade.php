@extends('layouts.app')
@section('title', 'Edit Produk Rusak')
@section('page-title')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
            Edit Produk Rusak
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
            <form action="{{ route('rusak.update', $produksi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Untuk mengirim request PUT -->
                <div class="card-body p-9">
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="date" class="fs-6 fw-bold mt-2 mb-3">Tanggal</label>
                        </div>
                        <div class="col-lg">
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                                value="{{ old('date', $produksi->date) }}" max="{{ date('Y-m-d') }}" placeholder="date" />
                            @error('date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="user_id" class="fs-6 fw-bold mt-2 mb-3">Admin</label>
                        </div>
                        <div class="col-lg">
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly />
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" />
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="product" class="fs-6 fw-bold mt-2 mb-3">Produk</label>
                        </div>
                        <div class="col-lg">
                            <select name="product" class="form-control @error('product') is-invalid @enderror">
                                <option value="">Pilih Produk</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->product }}"
                                        {{ $product->product == $produksi->product ? 'selected' : '' }}>
                                        {{ $product->product }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="jumlah" class="fs-6 fw-bold mt-2 mb-3">Jumlah</label>
                        </div>
                        <div class="col-lg">
                            <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                                value="{{ old('jumlah', $produksi->jumlah) }}" placeholder="jumlah" />
                            @error('jumlah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="keterangan" class="fs-6 fw-bold mt-2 mb-3">Keterangan</label>
                        </div>
                        <div class="col-lg">
                            <input type="text" name="keterangan"
                                class="form-control @error('keterangan') is-invalid @enderror"
                                value="{{ old('keterangan', $produksi->keterangan) }}" placeholder="Keterangan Produk" />
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="tindakan" class="fs-6 fw-bold mt-2 mb-3">Tindakan</label>
                        </div>
                        <div class="col-lg">
                            <select name="tindakan" class="form-control @error('tindakan') is-invalid @enderror">
                                <option value="">Pilih Tindakan</option>
                                <option value="Menunggu" {{ $produksi->tindakan == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Diperbaiki" {{ $produksi->tindakan == 'Diperbaiki' ? 'selected' : '' }}>Diperbaiki</option>
                                <option value="Tuntas" {{ $produksi->tindakan == 'Tuntas' ? 'selected' : '' }}>Tuntas</option>
                            </select>
                            @error('tindakan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('rusak.index') }}" type="reset"
                        class="btn btn-light btn-active-light-primary me-2">Batalkan</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jumlahInput = document.querySelector('input[name="jumlah"]');
            const hargaInput = document.querySelector('input[name="harga"]');
            const totalInput = document.querySelector('input[name="total"]');

            function calculateTotal() {
                const jumlah = parseFloat(jumlahInput.value) || 0;
                const harga = parseFloat(hargaInput.value) || 0;
                const total = jumlah * harga;
                totalInput.value = total;
            }

            jumlahInput.addEventListener('input', calculateTotal);
            hargaInput.addEventListener('input', calculateTotal);
        });
    </script>
@endpush
