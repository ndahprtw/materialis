@extends('layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Data Pelanggan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Data Pelanggan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-12">
                {{-- Pesan Sukses atau Error --}}
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
                        <div class="d-flex align-items-center justify-content-between m-3">
                            <h5 class="card-title">Total : {{ $data_pelanggan->count() }} Data</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="bi bi-plus"></i> Data Baru
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table datatable" id="pegawai">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Loop data pelanggan --}}
                                    @forelse ($data_pelanggan as $pelanggan)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $pelanggan->nama_pelanggan }}</td>
                                            <td>{{ $pelanggan->alamat_pelanggan }}</td>
                                            <td>
                                                {{-- Aksi Edit dan Delete --}}
                                                <button type="button" class="btn btn-primary shadow-none" data-bs-toggle="modal" data-bs-target="#editModal{{ $pelanggan->id }}">
                                                    <i class="bi bi-pencil"></i> <!-- Menggunakan ikon pensil -->
                                                </button>
                                                <button type="button" class="btn btn-danger shadow-none" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $pelanggan->id }}">
                                                    <i class="bi bi-trash"></i> <!-- Menggunakan ikon tong sampah -->
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit Pelanggan -->
                                        <div class="modal fade" id="editModal{{ $pelanggan->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $pelanggan->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $pelanggan->id }}">Edit Data Pelanggan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{-- Form untuk mengedit data pelanggan --}}
                                                        <form action="{{ route('pelanggan.update', $pelanggan->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="nama_pelanggan{{ $pelanggan->id }}" class="form-label">Nama Pelanggan</label>
                                                                <input type="text" class="form-control" id="nama_pelanggan{{ $pelanggan->id }}" name="nama_pelanggan" value="{{ $pelanggan->nama_pelanggan }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="alamat_pelanggan{{ $pelanggan->id }}" class="form-label">Alamat</label>
                                                                <input type="text" class="form-control" id="alamat_pelanggan{{ $pelanggan->id }}" name="alamat_pelanggan" value="{{ $pelanggan->alamat_pelanggan }}" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal Edit Pelanggan -->

                                        <!-- Modal Hapus Pelanggan -->
                                        <div class="modal fade" id="deleteModal{{ $pelanggan->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $pelanggan->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $pelanggan->id }}">Hapus Data Pelanggan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus pelanggan <strong>{{ $pelanggan->nama_pelanggan }}</strong>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('pelanggan.destroy', $pelanggan->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal Hapus Pelanggan -->

                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data pelanggan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Create Pelanggan -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Pelanggan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Form untuk menambah pelanggan baru --}}
                    <form action="{{ route('pelanggan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_pelanggan" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat_pelanggan" name="alamat_pelanggan" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal Create Pelanggan -->
@endsection
