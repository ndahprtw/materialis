@extends('layouts.main')

@section('content')

        <div class="pagetitle">
            <h1>Produk</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Produk</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->


        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
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
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between m-3">
                        <h5 class="card-title">Total : {{ $data_product->count() }} Data</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah-product">
                            <i class="bi bi-plus-square"></i> Tambah
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> No. </th>
                                    <th> Nama Product </th>
                                    <th> Nama Sales </th>
                                    <th> Harga Product </th>
                                    <th> Stock Product</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_product as $data)
                                    <tr>
                                        <td> {{ $no++ }} </td>
                                        <td> {{ $data->nama_produk}} </td>
                                        <td> {{ $data->sales->nama}} </td>
                                        <td>Rp. {{ number_format($data->harga_produk, 0, ',', '.') }}</td>
                                        <td>{{ $data->stok_produk }}</td>
                                        <td>
                                             {{-- edit data --}}
                                        <button type="button" class="btn btn-primary shadow-none" data-bs-toggle="modal" data-bs-target="#edit{{ $data->id }}"><i class="ri-pencil-fill"></i></button>
                                        <div class="modal fade" id="edit{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <form action="{{ route('data-product.update', $data->id) }}" method="post" enctype="multipart/form-data">
                                              @csrf
                                              @method('put')
                                              <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title">Edit Data</h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                              </div>
                                              <div class="modal-body">
                                                <div class="m-2">
                                                    <label for="nama_produk" class="form-label">Nama Product</label>
                                                    <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror shadow-none" id="nama_produk" value="{{ $data->nama_produk }}">
                                                    @error('nama_produk') 
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div> 
                                                    @enderror
                                                </div>
                                                <div class="m-2">
                                                    <label for="nama_sales" class="form-label">Sales</label>
                                                    <select name="nama_sales" id="nama_sales" class="form-select @error('nama_sales') is-invalid @enderror">
                                                      <option selected disabled>Pilih Informasi Sales</option>
                                                      @foreach ($sales as $item)
                                                        <option value="{{ $item->id }}" {{ $data->id_sales == $item->id ? 'selected' : '' }}> {{ $item->nama }} </option>  
                                                      @endforeach
                                                    </select>
                                                    @error('nama_sales') 
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div> 
                                                    @enderror
                                                </div>
                                                <div class="m-2">
                                                    <label for="harga_produk" class="form-label">Harga Product</label>
                                                    <input type="text" name="harga_produk" class="form-control @error('harga_produk') is-invalid @enderror shadow-none" id="harga_produk" value="{{ $data->harga_produk }}">
                                                    @error('harga_produk') 
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div> 
                                                    @enderror
                                                </div>
                                                <div class="m-2">
                                                    <label for="stok_produk" class="form-label">Stok Product</label>
                                                    <input type="text" name="stok_produk" class="form-control @error('stok_produk') is-invalid @enderror shadow-none" id="stok_produk" value="{{ $data->stok_produk }}">
                                                    @error('stok_produk') 
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
                                        <button type="button" class="btn btn-danger shadow-none" data-bs-toggle="modal" data-bs-target="#hapus-jurusan{{ $data->id }}"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <div class="d-flex gap-2">

                                      

                                        {{-- hapus data --}}
                                        
                                        <div class="modal fade" id="hapus-jurusan{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title"> Hapus Informasi Produk </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>
                                                    <div class="modal-body text-center">
                                                        <p style="color: black">Apakah anda yakin untuk menghapus produk {{ $data->nama_produk }}?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary shadow-none" data-bs-dismiss="modal">Tidak</button>
                                                        <form action="{{ route('data-product.destroy', $data->id) }}" method="POST" style="display: inline;">
                                                            @method('delete')
                                                            @csrf
                                                            <input type="submit" value="Hapus" class="btn btn-danger shadow-none">
                                                        </form> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        

        </section>
        <!-- /.content -->
    </div>
{{-- tambah jurusan --}}
<div class="modal fade" id="tambah-product" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('data-product.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="m-2">
                    <label for="nama_produk" class="form-label">Nama Product</label>
                    <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror shadow-none" id="nama_produk" value="{{ old('nama_produk') }}">
                    @error('nama_produk') 
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div> 
                    @enderror
                </div>
                <div class="m-2">
                    <label for="nama_sales" class="form-label">Sales</label>
                    <select name="nama_sales" id="nama_sales" class="form-select @error('nama_sales') is-invalid @enderror">
                      <option selected disabled>Pilih Informasi Sales</option>
                      @foreach ($sales as $item)
                        <option value="{{ $item->id }}" {{ old('nama_sales') == $item->id ? 'selected' : '' }}> {{ $item->nama }} </option>  
                      @endforeach
                    </select>
                    @error('nama_sales') 
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div> 
                    @enderror
                </div>
                <div class="m-2">
                    <label for="harga_produk" class="form-label">Harga Product</label>
                    <input type="text" name="harga_produk" class="form-control @error('harga_produk') is-invalid @enderror shadow-none" id="harga_produk" value="{{ old('harga_produk') }}">
                    @error('harga_produk') 
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div> 
                    @enderror
                </div>  
                <div class="m-2">
                    <label for="stok_produk" class="form-label">Stock Product</label>
                    <input type="text" name="stok_produk" class="form-control @error('stok_produk') is-invalid @enderror shadow-none" id="stok_produk" value="{{ old('stok_produk') }}">
                    @error('stok_produk') 
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
    

@endsection