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

            @if (auth()->user()->role == 'Karyawan' || auth()->user()->role == 'Admin')
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body pt-3">
                            <form aaction="{{ route('pelacakan.index') }}" method="GET" id="filterForm">
                                <div class="row text-center mb-3">
                                    <div class="col-md-2 my-1">
                                        <a href="{{ route('pelacakan.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Data Baru </a>
                                    </div>
                                    <div class="col-md-5 my-1">
                                        <input type="date" name="tanggal" id="tanggal" class="form-control" onchange="document.getElementById('filterForm').submit();" value="{{ request('tanggal') }}"> 
                                    </div>
                                    <div class="col-md-5 my-1">
                                        <select onchange="document.getElementById('filterForm').submit();" name="jenis" id="jenis" class="form-control">
                                            <option value="" selected disabled>Filter Status</option>
                                            <option value="dikirim">Dikirim</option>
                                            <option value="dikemas">Dikemas</option>
                                            <option value="selesai">Selesai</option>
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th> Tanggal </th>
                                            <th> Produk </th>
                                            <th> Qty </th>
                                            <th> Total </th>
                                            <th> Status </th>
                                            <th> Detail Cust </th>
                                            <th> Penanggung Jawab </th>
                                            <th rowspan="2"> Progres </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $item)
                                        <tr>
                                            <td>{{ $item->created_at }}</td>
                                            <td> {{ $item->produk->nama_produk }} </td>
                                            <td>{{ $item->jumlah_barang }} </td>
                                            <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                                            <td>
                                                @if($item->status == 'dikemas')
                                                    <span class="badge rounded-pill bg-secondary">{{ $item->status }}</span>
                                                @elseif($item->status == 'dikirim')
                                                    <span class="badge rounded-pill bg-primary">{{ $item->status }}</span>
                                                @elseif($item->status == 'selesai')
                                                    <span class="badge rounded-pill bg-success">{{ $item->status }}</span>
                                                @elseif($item->status == 'dibatalkan')
                                                    <span class="badge rounded-pill bg-danger">{{ $item->status }}</span>
                                                @endif
                                            </td>
                                            <td> 
                                                <button type="button" class="btn btn-primary shadow-none" data-bs-toggle="modal" data-bs-target="#data-cust{{ $item->id }}"><i class="bi bi-person-vcard"></i></button>
                                                <div class="modal fade" id="data-cust{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Informasi Customer</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table>
                                                            <tr>
                                                                <td> Nama </td>
                                                                <td class="w-25"> : </td>
                                                                <td> {{ $item->customer->nama_pelanggan }} </td>
                                                            </tr>
                                                            <tr>
                                                                <td> Nama </td>
                                                                <td class="w-25"> : </td>
                                                                <td> {{ $item->customer->alamat_pelanggan }} </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                                    </div>
                                                    </div>
                                                </form>
                                                </div>
                                                </div>
                                            </td>
                                            
                                            <td>{{ $item->staff->name }} ( {{ $item->staff->email }} ) </td>
                                            <td>
                                                @if($item->status == 'dikemas')
                                                    <a href="/diantar/{{ $item->id }}" class="btn btn-sm btn-outline-secondary">{{ $item->status }}</a>
                                                @elseif($item->status == 'dikirim')
                                                    <span class="badge rounded-pill bg-primary">Pengiriman oleh kurir</span>
                                                @elseif($item->status == 'dibatalkan')
                                                    <span class="badge rounded-pill bg-danger">{{ $item->status }}</span>
                                                @elseif($item->status == 'selesai')
                                                    <button type="button" class="btn btn-outline-success shadow-none" data-bs-toggle="modal" data-bs-target="#bukti{{ $item->id }}"><i class="bi bi-check-circle-fill"></i></button>
                                                    <div class="modal fade" id="bukti{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Bukti Pengiriman</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset('assets/img/bukti/'.$item->bukti) }}" alt="{{ $item->bukti }}" class="img-fluid">
                                                            <p><b>Kurir = </b> {{ $item->kurir->name }} ( {{ $item->kurir->email }} ) </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                                        </div>
                                                        </div>
                                                    </form>
                                                    </div>
                                                    </div>
                                                @endif
                                            </td>
                                            @if ($item->bukti != null)                                            
                                                <td>
                                                    @if ($item->jumlah_pelunasan == null)
                                                        <button type="button" class="btn btn-secondary shadow-none" data-bs-toggle="modal" data-bs-target="#bayar{{ $item->id }}"><i class="bi bi-coin"></i></button>
                                                        <div class="modal fade" id="bayar{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form action="{{ route('pelacakan.update', $item->id) }}" method="post">
                                                                    @csrf
                                                                    @method('put')
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Pelunasan Barang</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body row">
                                                                            <div class="col-md-12">
                                                                                <label for="total" class="form-label">Total</label>
                                                                                <input type="number" class="form-control @error('total') is-invalid @enderror shadow-none" id="total" value="{{ $item->total }}" readonly>
                                                                                @error('total')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }}
                                                                                    </div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="col-md-6 mt-3">
                                                                                <label for="pembayaran" class="form-label">Jumlah Pembayaran</label>
                                                                                <input type="number" max="{{ $item->total }}" name="pembayaran" class="form-control @error('pembayaran') is-invalid @enderror shadow-none" id="pembayaran" value="{{ old('pembayaran') }}">
                                                                                @error('pembayaran')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }}
                                                                                    </div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="col-md-6 mt-3">
                                                                                <label for="sisa" class="form-label">Sisa Pembayaran</label>
                                                                                <input type="number" name="sisa" class="form-control @error('sisa') is-invalid @enderror shadow-none" id="sisa" value="{{ old('sisa') }}" readonly>
                                                                                @error('sisa')
                                                                                    <div class="invalid-feedback">
                                                                                        {{ $message }}
                                                                                    </div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer d-flex justify-content-between align-items-center">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                                                            <button type="submit" class="btn btn-primary">Kirim</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @else                   
                                                        @if ($item->total == $item->jumlah_pelunasan)
                                                            <span class="badge rounded-pill bg-success"> LUNAS </span>
                                                        @else
                                                            <span class="badge rounded-pill bg-secondary"> - {{ $item->sisa_pelunasan }} </span>
                                                        @endif                                                    
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
            @endif

            @if (auth()->user()->role == 'Kurir')
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th> Tanggal </th>
                                        <th> Produk </th>
                                        <th> Qty </th>
                                        <th> Total </th>
                                        <th> Status </th>
                                        <th> Detail Cust </th>
                                        <th rowspan="2"> Progres </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data_kurir as $item)
                                    <tr>
                                        <td>{{ $item->created_at }}</td>
                                        <td> {{ $item->produk->nama_produk }} </td>
                                        <td>{{ $item->jumlah_barang }} </td>
                                        <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                                        <td>
                                            @if($item->status == 'dikemas')
                                                <span class="badge rounded-pill bg-secondary">{{ $item->status }}</span>
                                            @elseif($item->status == 'dikirim')
                                                <span class="badge rounded-pill bg-primary">{{ $item->status }}</span>
                                            @elseif($item->status == 'selesai')
                                                <span class="badge rounded-pill bg-success">{{ $item->status }}</span>
                                            @elseif($item->status == 'dibatalkan')
                                                <span class="badge rounded-pill bg-danger">{{ $item->status }}</span>
                                            @endif
                                        </td>
                                        <td> 
                                            <button type="button" class="btn btn-primary shadow-none" data-bs-toggle="modal" data-bs-target="#data-cust{{ $item->id }}"><i class="bi bi-person-vcard"></i></button>
                                            <div class="modal fade" id="data-cust{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog">
                                                  <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h5 class="modal-title">Informasi Customer</h5>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>
                                                  <div class="modal-body">
                                                    <table>
                                                        <tr>
                                                            <td> Nama </td>
                                                            <td class="w-25"> : </td>
                                                            <td> {{ $item->customer->nama_pelanggan }} </td>
                                                        </tr>
                                                        <tr>
                                                            <td> Nama </td>
                                                            <td class="w-25"> : </td>
                                                            <td> {{ $item->customer->alamat_pelanggan }} </td>
                                                        </tr>
                                                    </table>
                                                  </div>
                                                  <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                                  </div>
                                                  </div>
                                              </form>
                                              </div>
                                            </div>
                                        </td>
                                        <td> 
                                            @if($item->status == 'dikirim')
                                                {{-- barang ditolak --}}
                                                <button type="button" class="btn btn-outline-danger shadow-none" data-bs-toggle="modal" data-bs-target="#barang-ditolak">ditolak</button>
                                                <div class="modal fade" id="barang-ditolak" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Konfirmasi Pengiriman</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apa benar produk <b>{{ $item->produk->nama_produk }}</b> ini dibatalkan oleh customer?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                                                                <a href="/ditolak/{{ $item->id }}" class="btn btn-primary">Iya</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- barang diterima --}}
                                                <button type="button" class="btn btn-outline-success shadow-none" data-bs-toggle="modal" data-bs-target="#barang-diterima">diterima</button>
                                                <div class="modal fade" id="barang-diterima" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Konfirmasi Pengiriman</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('pelacakan.update', $item->id) }}" method="post" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                @csrf
                                                                @method('put')
                                                                <div class="row">
                                                                    <div>
                                                                        <label for="bukti" class="form-label">Bukti Pengiriman</label>
                                                                        <input type="file" name="bukti" id="bukti" class="form-control @error('bukti') is-invalid @enderror shadow-none" accept="image/*">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                                                <button type="submit" class="btn btn-primary"> Kirim </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                  </div>
                                                </div>
                                            @elseif($item->status == 'selesai')
                                                <button type="button" class="btn btn-outline-success shadow-none" data-bs-toggle="modal" data-bs-target="#bukti{{ $item->id }}"><i class="bi bi-check-circle-fill"></i></button>
                                                <div class="modal fade" id="bukti{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog">
                                                      <div class="modal-content">
                                                      <div class="modal-header">
                                                          <h5 class="modal-title">Bukti Pengiriman</h5>
                                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                      </div>
                                                      <div class="modal-body">
                                                        <img src="{{ asset('assets/img/bukti/'.$item->bukti) }}" alt="{{ $item->bukti }}" class="img-fluid">
                                                      </div>
                                                      <div class="modal-footer">
                                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                                      </div>
                                                      </div>
                                                  </div>
                                                </div>
                                            @elseif($item->status == 'dibatalkan')
                                                <span class="badge rounded-pill bg-danger">{{ $item->status }}</span>
                                            @endif
                                        </td>
                                        @if ($item->bukti != null)                                            
                                            <td>
                                                @if ($item->jumlah_pelunasan == null)
                                                    <button type="button" class="btn btn-secondary shadow-none" data-bs-toggle="modal" data-bs-target="#bayar{{ $item->id }}"><i class="bi bi-coin"></i></button>
                                                    <div class="modal fade" id="bayar{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form action="{{ route('pelacakan.update', $item->id) }}" method="post">
                                                                @csrf
                                                                @method('put')
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Pelunasan Barang</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body row">
                                                                        <div class="col-md-12">
                                                                            <label for="total" class="form-label">Total</label>
                                                                            <input type="number" class="form-control @error('total') is-invalid @enderror shadow-none" id="total" value="{{ $item->total }}" readonly>
                                                                            @error('total')
                                                                                <div class="invalid-feedback">
                                                                                    {{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <label for="pembayaran" class="form-label">Jumlah Pembayaran</label>
                                                                            <input type="number" max="{{ $item->total }}" name="pembayaran" class="form-control @error('pembayaran') is-invalid @enderror shadow-none" id="pembayaran" value="{{ old('pembayaran') }}">
                                                                            @error('pembayaran')
                                                                                <div class="invalid-feedback">
                                                                                    {{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-md-6 mt-3">
                                                                            <label for="sisa" class="form-label">Sisa Pembayaran</label>
                                                                            <input type="number" name="sisa" class="form-control @error('sisa') is-invalid @enderror shadow-none" id="sisa" value="{{ old('sisa') }}" readonly>
                                                                            @error('sisa')
                                                                                <div class="invalid-feedback">
                                                                                    {{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer d-flex justify-content-between align-items-center">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @else                   
                                                    @if ($item->total == $item->jumlah_pelunasan)
                                                        <span class="badge rounded-pill bg-success"> LUNAS </span>
                                                    @else
                                                        <button type="button" class="btn btn-secondary shadow-none" data-bs-toggle="modal" data-bs-target="#pelunasan{{ $item->id }}">- {{ $item->sisa_pelunasan }}</button>
                                                        <div class="modal fade" id="pelunasan{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <form action="{{ route('pelacakan.update', $item->id) }}" method="post">
                                                                    @csrf
                                                                    @method('put')
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Pelunasan Barang</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body row">
                                                                            <div class="col-md-12">
                                                                                <label for="sisa_pelunasan" class="form-label">Sisa Pembayaran Sebelumnya</label>
                                                                                <input type="number" class="form-control sisa_pelunasan @error('sisa_pelunasan') is-invalid @enderror shadow-none" value="{{ $item->sisa_pelunasan }}" readonly>
                                                                                @error('sisa_pelunasan')
                                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="col-md-6 mt-3">
                                                                                <label for="pembayaran_sisa" class="form-label">Pembayaran Sekarang</label>
                                                                                <input type="number" max="{{ $item->sisa_pelunasan }}" name="pembayaran_sisa" class="form-control pembayaran_sisa @error('pembayaran_sisa') is-invalid @enderror shadow-none" value="{{ old('pembayaran_sisa') }}">
                                                                                @error('pembayaran_sisa')
                                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="col-md-6 mt-3">
                                                                                <label for="sisa_pembayaran" class="form-label">Sisa Pembayaran Sekarang</label>
                                                                                <input type="number" name="sisa_pembayaran" class="form-control sisa_pembayaran @error('sisa_pembayaran') is-invalid @enderror shadow-none" value="{{ old('sisa_pembayaran') }}" readonly>
                                                                                @error('sisa_pembayaran')
                                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer d-flex justify-content-between align-items-center">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                                                            <button type="submit" class="btn btn-primary">Kirim</button>
                                                                        </div>
                                                                    </div>
                                                                </form>                                                                
                                                            </div>
                                                        </div>
                                                    @endif                                                    
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
            @endif


        </div>

    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pembayaranInput = document.getElementById('pembayaran');
    
            // Call the function when the "pembayaran" field is changed
            pembayaranInput.addEventListener('input', calculateSisa);
    
            function calculateSisa() {
                const total = parseFloat(document.getElementById('total').value) || 0;
                const pembayaran = parseFloat(pembayaranInput.value) || 0;
                const sisa = total - pembayaran;
    
                document.getElementById('sisa').value = sisa >= 0 ? sisa : 0;
            }
        });

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all elements with the class 'pembayaran_sisa'
            const pembayaranSisaElements = document.querySelectorAll('.pembayaran_sisa');

            pembayaranSisaElements.forEach(pembayaranSisa => {
                // Add event listener to each 'pembayaran_sisa' input
                pembayaranSisa.addEventListener('input', function() {
                    const sisaPelunasan = parseFloat(pembayaranSisa.closest('.modal-body').querySelector('.sisa_pelunasan').value) || 0;
                    const pembayaran = parseFloat(pembayaranSisa.value) || 0;
                    const sisa = sisaPelunasan - pembayaran;

                    // Update the corresponding 'sisa_pembayaran' input in the same form
                    const sisaPembayaran = pembayaranSisa.closest('.modal-body').querySelector('.sisa_pembayaran');
                    sisaPembayaran.value = sisa >= 0 ? sisa : 0;
                });
            });
        });
    </script>
@endsection