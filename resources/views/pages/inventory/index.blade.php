@extends('layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active"> {{ $title }} </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-12">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif (session()->has('error'))
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
                       <form action="{{ route('inventory.index') }}" method="GET" id="filterForm">
    <div class="row align-items-center g-2 mb-3">

        {{-- Tombol tambah --}}
        @if (auth()->user()->role == 'Staff Gudang')
        <div class="col-auto">
            <a href="{{ route('inventory.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus me-1"></i> Tambah Material
            </a>
        </div>
        @endif

        {{-- Tanggal dari --}}
        <div class="col-md-2">
            <input type="date" name="tanggal_dari"
                class="form-control form-control-sm"
                value="{{ request('tanggal_dari') }}"
                onchange="document.getElementById('filterForm').submit();">
        </div>

        {{-- Tanggal sampai --}}
        <div class="col-md-2">
            <input type="date" name="tanggal_sampai"
                class="form-control form-control-sm"
                value="{{ request('tanggal_sampai') }}"
                onchange="document.getElementById('filterForm').submit();">
        </div>

        {{-- Jenis --}}
        <div class="col-md-2">
            <select name="jenis"
                class="form-control form-control-sm"
                onchange="document.getElementById('filterForm').submit();">
                <option value="">Semua Jenis</option>
                <option value="barang masuk" {{ request('jenis') == 'barang masuk' ? 'selected' : '' }}>
                    Barang Masuk
                </option>
                <option value="barang keluar" {{ request('jenis') == 'barang keluar' ? 'selected' : '' }}>
                    Barang Keluar
                </option>
            </select>
        </div>

        {{-- Produk --}}
        <div class="col-md-3">
            <select name="produk"
                class="form-control form-control-sm"
                onchange="document.getElementById('filterForm').submit();">
                <option value="">Semua Material</option>
                @foreach($produk as $product)
                    <option value="{{ $product->id }}"
                        {{ request('produk') == $product->id ? 'selected' : '' }}>
                        {{ $product->nama_produk }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tombol export --}}
        <div class="col-auto">
            <a href="/laporan" class="btn btn-warning btn-sm">
                <i class="bi bi-download"></i>
            </a>
        </div>

        {{-- Tombol reset --}}
        <div class="col-auto">
            <a href="{{ route('inventory.index') }}" class="btn btn-secondary btn-sm">
                Reset
            </a>
        </div>

    </div>
</form>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> Tanggal </th>
                                        <th> Jenis </th>
                                        <th> Material </th>
                                        <th> Jumlah </th>
                                        <th> Total Harga </th>
                                        <th> Penanggung Jawab </th>
                                        <th class="w-25"> Pesan </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            @if($item->jenis == 'barang masuk')
                                                <span class="badge rounded-pill bg-success">{{ $item->jenis }}</span>
                                            @elseif($item->jenis == 'barang keluar')
                                                <span class="badge rounded-pill bg-danger">{{ $item->jenis }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->produk->nama_produk }} </td>
                                        <td>{{ $item->jumlah_barang }}</td>
                                        <td> {{ number_format($item->pembayaran, 0, ',', '.') }} </td>
                                        <td>{{ $item->staff->name }} ( {{ $item->staff->email }} ) </td>
                                        <td class="w-25">
                                            @if($item->pesan == null)
                                                -
                                            @else
                                                {{ $item->pesan }}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </section>
@endsection