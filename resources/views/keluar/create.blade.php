@extends('layouts.app')
@section('title', 'Tambah produksi')
@section('page-title')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
            Tambah Data Produk Keluar
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
            <form action="{{ route('keluar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body p-9">
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="date" class="fs-6 fw-bold mt-2 mb-3">Tanggal</label>
                        </div>
                        <div class="col-lg">
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror "
                                placeholder="date " max="{{ date('Y-m-d') }}"/>
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
                            <label for="customer_id" class="fs-6 fw-bold mt-2 mb-3">Pelanggan</label>
                        </div>
                        <div class="col-lg">
                            <select name="customer_id" class="form-control @error('customer_id') is-invalid @enderror">
                                <option value="">Pilih Pelanggan</option>
                                @foreach($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id }}">{{ $pelanggan->name }}</option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="product" class="fs-6 fw-bold mt-2 mb-3">Product</label>
                        </div>
                        <div class="col-lg">
                            <select name="product" class="form-control @error('product') is-invalid @enderror">
                                <option value="">Pilih Produk</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->product }}">{{ $product->product }}</option>
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
                            <label for="harga" class="fs-6 fw-bold mt-2 mb-3">Harga</label>
                        </div>
                        <div class="col-lg">
                            <input type="text" name="harga" class="form-control @error('harga') is-invalid @enderror "
                                readonly placeholder="" />
                            @error('harga')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="jumlah" class="fs-6 fw-bold mt-2 mb-3">Stok Barang</label>
                        </div>
                        <div class="col-lg">
                            <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror "
                             readonly   placeholder="Stok Barang" />
                            @error('jumlah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-xl-3">
                            <label for="jumlah_beli" class="fs-6 fw-bold mt-2 mb-3">Jumlah Beli</label>
                        </div>
                        <div class="col-lg">
                            <input type="number" name="jumlah_beli" class="form-control @error('jumlah_beli') is-invalid @enderror "
                                placeholder="Stok Barang" />
                            @error('jumlah_beli')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('keluar.index') }}" type="reset"
                        class="btn btn-light btn-active-light-primary me-2">Batalkan</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const productSelect = document.querySelector('select[name="product"]');
            const jumlahInput = document.querySelector('input[name="jumlah"]');
            const hargaInput = document.querySelector('input[name="harga"]');

            productSelect.addEventListener('change', function() {
                const selectedProduct = this.value;

                if (selectedProduct) {
                    // Mengirim request AJAX untuk mengambil jumlah produk
                    fetch(`/get-jumlah-product/${selectedProduct}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Menampilkan jumlah produk yang didapat dari server
                                jumlahInput.value = data.jumlah;
                                hargaInput.value = data.harga;
                            } else {
                                jumlahInput.value = ''; // Kosongkan jika tidak ada data
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            jumlahInput.value = ''; // Kosongkan jika ada error
                        });
                } else {
                    jumlahInput.value = ''; // Kosongkan jika tidak ada produk yang dipilih
                }
            });
        });
    </script>
@endpush
