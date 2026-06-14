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

                        <div class="d-flex align-items-center justify-content-between m-3">
                            <h5 class="card-title">Total : {{ $data->count() }} Permintaan</h5>

                            @if (auth()->user()->role == 'Staff Proyek')
                                {{-- tambah data baru --}}
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-data"> Data Baru </button>
                                <div class="modal fade" id="tambah-data" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('permintaan.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Permintaan Material</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center">
                                                    Apakah benar Anda akan mengajukan permintaan material baru?    
                                                </p>       

                                                <input type="hidden" name="id_staff_gudang" value="{{ auth()->user()->id }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Tidak</button>
                                                <button type="submit" class="btn btn-primary text-white shadow-none">Yakin</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            @endif
                        </div>


                        @if (auth()->user()->role == 'Staff Proyek')
                            <div class="row">
                                @foreach ($data as $item)
                                    <div class="col-md-4">
                                        <div class="card border pt-3">
                                            <div class="card-body">
                                                <table style="width: 100%">
                                                    <tr>
                                                        <td><b>Tanggal Permintaan</b></td>
                                                        <td>: {{ \Carbon\Carbon::parse($item->tanggal_permintaan)->translatedFormat('d F Y') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Status</b></td>
                                                        <td>: {{ $item->status }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Total Material</b></td>
                                                        @if ($item->detailPermintaan->isNotEmpty())
                                                            <td>: {{ $item->detailPermintaan->count() }}</td>
                                                        @else
                                                            <td>: 0</td>
                                                        @endif
                                                    </tr>
                                                </table>
                                                <hr>
                                                @if ($item->status == "dalam pengajuan")
                                                    <div class="d-flex align-items-center justify-content-between">

                                                        {{-- hapus data --}}
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus-data-{{ $item->id }}"> <i class="bi bi-trash"></i> </button>
                                                        <div class="modal fade" id="hapus-data-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form action="{{ route('permintaan.destroy', $item->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <p class="text-center">
                                                                                Apakah benar Anda akan menghapus permintaan material ini?
                                                                            </p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Tidak</button>
                                                                            <button type="submit" class="btn btn-danger text-white shadow-none">Yakin</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        @if ($item->detailPermintaan->isNotEmpty())
                                                            {{-- ajukan data --}}
                                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ajukan-data-{{ $item->id }}"> <i class="bi bi-send"></i> </button>
                                                            <div class="modal fade" id="ajukan-data-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <form action="{{ route('permintaan.update', $item->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Konfirmasi Pengajuan Data</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name="status" value="diajukan">
                                                                                <p class="text-center">
                                                                                    Apakah bahan material yang anda ajukan sudah benar? Setelah diajukan, data tidak dapat diubah atau dihapus lagi.
                                                                                </p>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Tidak</button>
                                                                                <button type="submit" class="btn btn-success text-white shadow-none">Ya</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <a href="{{ route('permintaan.show', $item->id) }}" class="btn btn-primary shadow-none">
                                                            <i class="bi bi-plus-circle"></i> material
                                                        </a>
                                                    </div>
                                                @else
                                                <p class="text-center">
                                                    @if ($item->status == 'diajukan')
                                                        <span class="badge bg-secondary"> {{ $item->status }} </span>
                                                    @elseif ($item->status == 'diproses')
                                                        <span class="badge bg-primary"> {{ $item->status }} </span>
                                                    @elseif ($item->status == 'selesai')
                                                        <a href="{{ route('permintaan.show', $item->id) }}" class="btn btn-success"><i class="bi bi-eye"></i></a>
                                                    @endif
                                                </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @elseif (auth()->user()->role == 'Staff Gudang')
                            @if ($data->count() == 0)
                               <p class="text-danger text-center my-3"> Belum ada permintaan material </p> 
                            @else
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <th>No.</th>
                                            <th>Tanggal Permintaan</th>
                                            <th>Staff Proyek</th>
                                            <th>Staff Gudang</th>
                                            <th>Status</th>
                                            <th>Total jenis material</th>
                                            <th>Catatan</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->tanggal_permintaan)->translatedFormat('d F Y') }}</td>
                                                    <td>{{ $item->staff_proyek->name ?? '-' }}</td>
                                                    <td>{{ $item->staff_gudang->name ?? '-' }}</td>
                                                    <td>{{ $item->status }}</td>
                                                    <td>{{ $item->detailPermintaan->whereNotNull('status')->count() }} dari {{ $item->detailPermintaan->count() }} telah diproses</td>
                                                    <td>{{ $item->catatan ?? '-' }}</td>
                                                    <td>
                                                        @if ($item->status == 'diajukan')
                                                            {{-- proses data --}}
                                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#proses-data-{{ $item->id }}"> <i class="bi bi-check-circle"></i> </button>
                                                            <div class="modal fade" id="proses-data-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <form action="{{ route('permintaan.update', $item->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Konfirmasi Pemrosesan Data</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name="status" value="diproses">
                                                                                <p class="text-center">
                                                                                    <b>{{ auth()->user()->name }}</b>. Anda akan memproses data permintaan material ini.
                                                                                </p>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Tidak</button>
                                                                                <button type="submit" class="btn btn-success text-white shadow-none">Ya</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @elseif ($item->status == 'diproses')

                                                            @php
                                                                $diproses = $item->detailPermintaan->whereNotNull('status')->count();
                                                                $total = $item->detailPermintaan->count();
                                                            @endphp

                                                            @if ($diproses == $total && $total > 0)
                                                                {{-- selesai data --}}
                                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#selesai-data-{{ $item->id }}"> <i class="bi bi-check"></i> </button>
                                                                <div class="modal fade" id="selesai-data-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <form action="{{ route('permintaan.update', $item->id) }}" method="POST">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Konfirmasi Selesai Proses Permintaan Data</h5>
                                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <input type="hidden" name="status" value="selesai">
                                                                                    <p class="text-center">
                                                                                        {{ $item->detailPermintaan->whereNotNull('status')->count() }} dari {{ $item->detailPermintaan->count() }} telah selesai diproses.
                                                                                    </p>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Tidak</button>
                                                                                    <button type="submit" class="btn btn-success text-white shadow-none">Ya</button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>                                             
                                                            @else
                                                                <a href="{{ route('permintaan.show', $item->id) }}" class="btn btn-primary shadow-none">
                                                                    <i class="bi bi-eye"></i> 
                                                                </a>
                                                            @endif
                                                        @else 
                                                            <span class="badge bg-success">selesai</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </section>
@endsection