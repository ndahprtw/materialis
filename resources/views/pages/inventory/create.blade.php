@extends('layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active"> <a href="{{ url('inventory') }}"> {{ $title }} </a> </li>
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
                        <form action="{{ route('inventory.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @if (request()->routeIs('inventory.create'))
                                    <div>
                                        <label for="produk" class="form-label">Material</label>
                                        <select name="produk" id="produk" class="form-select @error('produk') is-invalid @enderror">
                                            <option selected disabled>Pilih Informasi Material</option>
                                            @foreach ($produk as $item)
                                                <option value="{{ $item->id }}" {{ old('produk') == $item->id ? 'selected' : '' }} data-harga="{{ $item->harga_produk }}"> {{ $item->nama_produk }} | Stok : {{ $item->stok_produk }} | Harga : {{ number_format($item->harga_produk, 2) }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @elseif(request()->routeIs('inventory.show'))
                                    <div>
                                        <label for="produk" class="form-label">Material</label>
                                        <input type="text" class="form-control" value="{{ $produk->nama_produk }} | Stok : {{ $produk->stok_produk }} | Harga : {{ number_format($produk->harga_produk, 2) }}" disabled>
                                        <input type="hidden" class="form-control" name="produk" value="{{ $produk->id }}">
                                        <input type="hidden" id="harga_produk" value="{{ $produk->harga_produk }}">
                                    </div>
                                @endif

                                <div class="col-md-4 mt-3">
                                    <label for="jumlah_barang" class="form-label">Stok</label>
                                    <input type="number" name="jumlah_barang" id="jumlah_barang" class="form-control @error('jumlah_barang') is-invalid @enderror shadow-none" value="{{ old('jumlah_barang') }}">
                                    @error('jumlah_barang') 
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div> 
                                    @enderror
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label for="total_harga" class="form-label">Total Harga</label>
                                    <input type="text" id="total_harga_tampil" class="form-control" placeholder="Rp. 0" readonly>
                                    <input type="hidden" name="total_harga" id="total_harga">
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label for="jenis" class="form-label">Jenis Informasi</label>
                                    <input type="text" class="form-control" name="jenis" value="barang masuk" id="jenis" readonly>
                                    @error('jenis') 
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div> 
                                    @enderror
                                </div>
                                <div class="col-md-12 mt-3">
                                    <label for="pesan" class="form-label">Catatan Tambahan</label>
                                    <textarea class="form-control @error('pesan') is-invalid @enderror" name="pesan" id="pesan">{{ old('pesan') }}</textarea>
                                    @error('pesan') 
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div> 
                                    @enderror
                                </div>           
                            </div>
                            <div class="my-3 d-flex justify-content-between align-items-center">
                                @if (request()->routeIs('inventory.store'))
                                    <a class="btn btn-secondary" href="{{ url('inventory') }}">Kembali</a>
                                @elseif (request()->routeIs('inventory.show'))
                                    <a class="btn btn-secondary" href="/permintaan">Kembali</a>
                                @endif
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
            const hargaProdukInput = document.getElementById('harga_produk');
            const jumlahBarangInput = document.getElementById('jumlah_barang');
            const totalHargaInput = document.getElementById('total_harga');
            const totalHargaTampil = document.getElementById('total_harga_tampil');

            function calculateTotal() {
                let hargaProduk = 0;

                if (produkSelect && produkSelect.tagName === 'SELECT') {
                    const selectedOption = produkSelect.options[produkSelect.selectedIndex];
                    hargaProduk = parseFloat(selectedOption.dataset.harga) || 0;
                } else if (hargaProdukInput) {
                    hargaProduk = parseFloat(hargaProdukInput.value) || 0;
                }

                const jumlahBarang = parseFloat(jumlahBarangInput.value) || 0;
                const total = hargaProduk * jumlahBarang;

                // angka
                totalHargaInput.value = total;

                // tampilkan rupiah
                totalHargaTampil.value = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(total);
            }

            if (produkSelect) {
                produkSelect.addEventListener('change', calculateTotal);
            }

            jumlahBarangInput.addEventListener('input', calculateTotal);

            calculateTotal();
        });
    </script>
@endsection
