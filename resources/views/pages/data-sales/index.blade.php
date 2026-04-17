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
                @elseif (session()->has('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        <b> Permintaan Ditolak ! </b> {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <div class="d-flex align-items-center justify-content-between m-3">
                            <h5 class="card-title">Total : {{ $data->count() }} Data</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-data">
                                <i class="bi bi-plus-square"></i> Data Baru
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table datatable" id="pegawai">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th class="w-50">Alamat</th>
                                        <th>WhatsApp</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>
                                            <a href="https://wa.me/{{ $item->telepon }}" target="_blank"> <i class="bi bi-telephone-fill"></i> {{ $item->telepon }} </a>
                                        </td>
                                        <td>
                                            {{-- edit data --}}
                                            <button type="button" class="btn btn-primary shadow-none" data-bs-toggle="modal" data-bs-target="#edit{{ $item->id }}"><i class="ri-pencil-fill"></i></button>
                                            <div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('data-sales.update', $item->id) }}" method="post">
                                                @csrf
                                                @method('put')
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="m-2">
                                                        <label for="nama" class="form-label">Nama Sales</label>
                                                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror shadow-none" id="nama" value="{{ $item->nama }}">
                                                        @error('nama') 
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div> 
                                                        @enderror
                                                    </div>
                                                    <div class="m-2">
                                                        <label for="alamat" class="form-label">Alamat Sales</label>
                                                        <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror shadow-none" id="alamat" value="{{ $item->alamat }}">
                                                        @error('alamat') 
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div> 
                                                        @enderror
                                                    </div>
                                                    <div class="m-2">
                                                        <label for="telepon" class="form-label">Telepon</label>
                                                        <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror shadow-none" id="telepon" value="{{ $item->telepon }}">
                                                        @error('telepon') 
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div> 
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Kembali</button>
                                                    <button type="submit" class="btn btn-primary text-white shadow-none">Kirim</button>
                                                </div>
                                                </div>
                                            </form>
                                            </div>
                                            </div>

                                            {{-- hapus data --}}
                                            <button type="button" class="btn btn-danger shadow-none" data-bs-toggle="modal" data-bs-target="#hapus-data{{ $item->id }}"><i class="bi bi-trash"></i></button>
                                            <div class="modal fade" id="hapus-data{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"> Hapus Data </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                        <div class="modal-body text-center">
                                                            <p style="color: black">Apakah anda yakin untuk menghapus data dari {{ $item->nama }}?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Tidak</button>
                                                            <form action="{{ route('data-sales.destroy', $item->id) }}" method="POST" style="display: inline;">
                                                                @method('delete')
                                                                @csrf
                                                                <input type="submit" value="Hapus" class="btn btn-danger shadow-none">
                                                            </form> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

        {{-- tambah data --}}
        <div class="modal fade" id="tambah-data" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('data-sales.store') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data Sales</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="m-1">
                            <label for="nama" class="form-label">Nama Sales</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror shadow-none" id="nama" value="{{ old('nama') }}">
                            @error('nama') 
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div> 
                            @enderror
                        </div>          
                        <div class="m-1">
                            <label for="alamat" class="form-label">Alamat Sales</label>
                            <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror shadow-none" id="alamat" value="{{ old('alamat') }}">
                            @error('alamat') 
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div> 
                            @enderror
                        </div>          
                        <div class="m-1">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror shadow-none" id="telepon" value="{{ old('telepon') }}" placeholder="Contoh : 628......">
                            @error('telepon') 
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div> 
                            @enderror
                        </div>          
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary text-white shadow-none">Kirim</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </section>
@endsection