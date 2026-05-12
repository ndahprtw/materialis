@extends('layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>{{ $title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active"> {{ $title }} </li>
                <li class="breadcrumb-item active"> Detail Permintaan </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>Tanggal Permintaan</th>
                                    <th>Staff Gudang</th>
                                    <th>Staff Proyek</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($data->tanggal_permintaan)->translatedFormat('d F Y') }}</td>
                                        <td>{{ $data->staff_gudang->name }}</td>
                                        <td>{{ $data->staff_proyek->name ?? '-' }}</td>
                                        <td>{{ $data->status }}</td>
                                        <td>{{ $data->catatan ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            <a href="{{ route('permintaan.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>

                
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

                <div class="card">
                    <div class="card-body">

                        <div class="d-flex align-items-center justify-content-between m-3">
                            <h5 class="card-title">Total : {{ $detail_data->count() }}  Bahan Material</h5>

                            @if (auth()->user()->role == 'Staff Proyek')
                                {{-- tambah data baru --}}
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-data"> <i class="bi bi-plus-square"></i> Data Baru </button>
                                <div class="modal fade" id="tambah-data" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('detail-permintaan.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Permintaan Material</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                                <div class="modal-body">

                                                <input type="hidden" name="id_permintaan" value="{{ old('id_permintaan', $data->id) }}">
                                                <div class="mb-3">
                                                    <label for="material" class="form-label">Material</label>
                                                    <select name="material" id="material" class="form-select shadow-none @error('material') is-invalid @enderror">
                                                        <option value="">Pilih Material</option>
                                                        @foreach ($materials as $item)
                                                            <option value="{{ $item->id }}"{{ old('material') == $item->id ? 'selected' : '' }}>{{ $item->nama_produk }} | stok : {{ $item->stok_produk }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('material')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jumlah" class="form-label">Jumlah Permintaan</label>
                                                    <input type="number" min="0" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" class="form-control shadow-none @error('jumlah') is-invalid @enderror" placeholder="Masukkan jumlah material">
                                                    @error('jumlah')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Batalkan</button>
                                                <button type="submit" class="btn btn-primary text-white shadow-none">Kirim</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="table-responsive">
                            <table class="table" id="pegawai">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Bahan Material</th>
                                        <th>Jumlah Yang Diajukan</th>
                                        @if (auth()->user()->role == 'Staff Gudang')
                                            <th colspan="2"> Stok Tersedia </th>
                                        @endif
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($detail_data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->produk->nama_produk }}</td>
                                        <td>{{ $item->jumlah_permintaan }}</td>
                                        @if (auth()->user()->role == 'Staff Gudang')
                                            @if ($item->status != null)
                                                <td colspan="2"> {{ $item->pesan }} </td>
                                            @else 
                                                <td> {{ $item->produk->stok_produk }} </td>
                                                <td>
                                                    @if ($item->produk->stok_produk >= $item->jumlah_permintaan)
                                                        <span class="badge bg-success">Cukup</span>
                                                    @else
                                                        <span class="badge bg-danger">Tidak Cukup</span>
                                                    @endif
                                                </td>
                                                @endif
                                            <td>
                                                @if ($item->status == null)
                                                    @if ($item->produk->stok_produk >= $item->jumlah_permintaan)
                                                        {{-- setujui data --}}
                                                        <button type="button" class="btn btn-success shadow-none" data-bs-toggle="modal" data-bs-target="#setujui-data{{ $item->id }}">setujui</button>
                                                        <div class="modal fade" id="setujui-data{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"> Setujui Data </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                    <div class="modal-body text-center">
                                                                        <p style="color: black">Apakah anda yakin untuk menyetujui permintaan material <b>{{ $item->produk->nama_produk }}</b> sebanyak {{ $item->jumlah_permintaan }} dari {{ $item->produk->stok_produk }} ?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Tidak</button>
                                                                        <form action="{{ route('detail-permintaan.update', $item->id) }}" method="POST" style="display: inline;">
                                                                            @method('PUT')
                                                                            @csrf
                                                                            <input type="hidden" name="status" value="stok tersedia">
                                                                            <input type="submit" value="Setujui" class="btn btn-success shadow-none">
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        {{-- tolak data --}}
                                                        <button type="button" class="btn btn-danger shadow-none" data-bs-toggle="modal" data-bs-target="#tolak-data{{ $item->id }}">Tolak</button>
                                                        <div class="modal fade" id="tolak-data{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"> Tolak Data </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                    <div class="modal-body text-center">
                                                                        <p style="color: black">Apakah anda yakin untuk menolak permintaan material <b>{{ $item->produk->nama_produk }}</b> sebanyak {{ $item->jumlah_permintaan }} dari {{ $item->produk->stok_produk }} ?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Tidak</button>
                                                                        <form action="{{ route('detail-permintaan.update', $item->id) }}" method="POST" style="display: inline;">
                                                                            @method('PUT')
                                                                            @csrf
                                                                            <input type="hidden" name="status" value="stok tidak tersedia">
                                                                            <input type="submit" value="Tolak" class="btn btn-danger shadow-none">
                                                                        </form> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <a href="{{ route('inventory.create') }}" class="btn btn-primary"> Restock </a>
                                                    @endif
                                                @else
                                                    @if ($item->status == 'stok tersedia')
                                                        <span class="badge bg-success">disetujui</span>
                                                    @else
                                                        <span class="badge bg-danger">ditolak</span>
                                                    @endif
                                                @endif
                                            </td>
                                        @else
                                            <td>
                                                @if ($item->status != null)
                                                    @if ($item->status == 'stok tersedia')
                                                        <span class="badge bg-success"> {{ $item->status }} </span>
                                                    @else
                                                        <span class="badge bg-danger"> {{ $item->status }} </span>   
                                                    @endif <br>
                                                    <b>note</b> : {{ $item->pesan ?? '-' }}
                                                @else
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
                                                                    <p style="color: black">Apakah anda yakin untuk menghapus material <b>{{ $item->produk->nama_produk }}</b> dari daftar permintaan ?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Tidak</button>
                                                                    <form action="{{ route('detail-permintaan.destroy', $item->id) }}" method="POST" style="display: inline;">
                                                                        @method('delete')
                                                                        @csrf
                                                                        <input type="submit" value="Hapus" class="btn btn-danger shadow-none">
                                                                    </form> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        @endif
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