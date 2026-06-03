
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Download Filter Data</title>

    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logo.png') }}" rel="logo">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>

    {{-- Kop Surat --}}
    <div style="margin-bottom:20px;">
        <table width="100%">
            <tr>
                <td width="15%">
                    <img src="{{ asset('assets/img/logo.png') }}" width="100">
                </td>

                <td width="70%" align="center">
                    <h4 style="margin:0;">
                        PT KRAKATAU PERBENGKELAN DAN PERAWATAN
                    </h4>

                    <p style="margin:0;">
                        Jl. Raya Anyer Kav. A-01 Kawasan Industri Krakatau<br>
                        Cilegon - Banten<br>
                        Telp. (0254) 396464
                    </p>
                </td>

                <td width="15%" align="right">
                    {{-- Logo sertifikasi jika ada --}}
                    {{-- <img src="{{ asset('assets/img/sertifikasi.png') }}" width="100"> --}}
                </td>
            </tr>
        </table>

        <hr style="border:2px solid #000; margin-top:10px;">
    </div>

    <h3 class="text-center my-5">
        Laporan Inventori

        @if(request('tanggal_dari') || request('tanggal_sampai'))
            <br>
            <small>
                @if(request('tanggal_dari') && request('tanggal_sampai'))
                    {{ \Carbon\Carbon::parse(request('tanggal_dari'))->translatedFormat('d F Y') }}
                    -
                    {{ \Carbon\Carbon::parse(request('tanggal_sampai'))->translatedFormat('d F Y') }}

                @elseif(request('tanggal_dari'))
                    Dari
                    {{ \Carbon\Carbon::parse(request('tanggal_dari'))->translatedFormat('d F Y') }}

                @elseif(request('tanggal_sampai'))
                    Sampai
                    {{ \Carbon\Carbon::parse(request('tanggal_sampai'))->translatedFormat('d F Y') }}
                @endif
            </small>
        @endif
    </h3>

    <div style="margin-top:35px;">
        <table class="table table-bordered" style="font-size:10px;">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Pembayaran</th>
                    <th>Penanggung Jawab</th>
                    <th class="w-25">Pesan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ $item->produk->nama_produk }}</td>
                    <td>{{ $item->jumlah_barang }}</td>
                    <td>{{ number_format($item->pembayaran, 0, ',', '.') }}</td>
                    <td>{{ $item->staff->name }} ({{ $item->staff->email }})</td>
                    <td>{{ $item->pesan ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Tanda Tangan --}}
    <div style="margin-top:60px;">
        <table width="100%">
            <tr>
                <td width="60%"></td>

                <td width="40%" align="center">
                    Cilegon,
                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                    <br>
                    <strong>Penanggung Jawab</strong>

                    <br><br><br><br><br>

                    <u>{{ auth()->user()->name }}</u>
                    <br>
                    {{ auth()->user()->role }}
                </td>
            </tr>
        </table>
    </div>

    <script>
        window.print();
    </script>

</body>

</html>

