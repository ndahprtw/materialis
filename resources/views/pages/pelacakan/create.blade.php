@extends('layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ url('pelacakan') }}"> {{ $title }} </a></li>
                <li class="breadcrumb-item active"> Tambah Data </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-12">
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <form action="{{ route('pelacakan.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <label for="produk" class="form-label">Produk</label>
                                    <select name="produk" id="produk" class="form-select @error('produk') is-invalid @enderror">
                                        <option selected disabled>Pilih Informasi Produk</option>
                                        @foreach ($produk as $item)
                                            <option value="{{ $item->id }}" data-harga="{{ $item->harga_produk }}" {{ old('produk') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama_produk }} | {{ $item->sales->nama }} | Stok: {{ $item->stok_produk }} | Harga: Rp{{ number_format($item->harga_produk, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('produk')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mt-3">
                                    <label for="jumlah_barang" class="form-label">Qty</label>
                                    <input type="number" name="jumlah_barang" class="form-control @error('jumlah_barang') is-invalid @enderror shadow-none" id="jumlah_barang" value="{{ old('jumlah_barang') }}">
                                    @error('jumlah_barang')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mt-3">
                                    <label for="total" class="form-label">Total</label>
                                    <input type="number" name="total" class="form-control @error('total') is-invalid @enderror shadow-none" id="total" value="{{ old('total') }}" readonly>
                                    @error('total')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label for="customer" class="form-label">Customer</label>
                                    <select name="customer" id="customer" class="form-select @error('customer') is-invalid @enderror">
                                        <option selected disabled>Pilih Customer</option>
                                        @foreach ($customer as $item)
                                            <option value="{{ $item->id }}" {{ old('customer') == $item->id ? 'selected' : '' }}>
                                                Nama : {{ $item->nama_pelanggan }} | Alamat: {{ $item->alamat_pelanggan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="my-3 d-flex justify-content-between align-items-center">
                                <a class="btn btn-secondary" href="{{ url('pelacakan') }}">Kembali</a>
                                <button type="submit" class="btn btn-primary">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const produkSelect = document.getElementById('produk');
            const jumlahBarangInput = document.getElementById('jumlah_barang');
            const totalInput = document.getElementById('total');

            // Fungsi untuk menghitung total
            function hitungTotal() {
                const selectedOption = produkSelect.options[produkSelect.selectedIndex];
                const hargaProduk = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
                const jumlahBarang = parseFloat(jumlahBarangInput.value) || 0;

                // Menghitung total harga
                const total = hargaProduk * jumlahBarang;
                totalInput.value = total.toFixed(2); // Update nilai total
            }

            // Event listener ketika produk atau jumlah barang berubah
            produkSelect.addEventListener('change', hitungTotal);
            jumlahBarangInput.addEventListener('input', hitungTotal);
        });
    </script>
@endsection
