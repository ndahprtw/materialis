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
                            <div class="row text-center mb-3">
                                <div class="col-md-1 my-1">
                                    <a href="{{ route('inventory.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> </a>
                                </div>
                                <div class="col-md-5 my-1">
                                    <input type="date" name="tanggal" id="tanggal" class="form-control" onchange="document.getElementById('filterForm').submit();" value="{{ request('tanggal') }}"> 
                                </div>
                                <div class="col-md-5 my-1">
                                    <select onchange="document.getElementById('filterForm').submit();" name="jenis" id="jenis" class="form-control">
                                        <option value="" selected disabled>Filter Jenis Informasi</option>
                                        <option value="barang masuk">Barang Masuk</option>
                                        <option value="barang keluar">Barang Keluar</option>
                                    </select>
                                </div>
                                <div class="col-md-1 my-1">
                                    <a href="/laporan" class="btn btn-warning"><i class="bi bi-download"></i> </a>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> Tanggal </th>
                                        <th> Jenis </th>
                                        <th> Produk </th>
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