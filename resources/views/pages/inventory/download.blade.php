<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Laporan Bulanan</title>

    <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logo.png') }}" rel="logo">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-3">

    {{-- Kop Surat --}}
    <div style="margin-bottom:20px;">
        <table width="100%">
            <tr>
                <td width="15%">
                    <img src="{{ asset('assets/img/logo.png') }}" width="100">
                </td>

                <td width="70%" align="center">
                    <h4 style="margin:0;">
                        MATERIALIS
                    </h4>

                    <p style="margin:0;">
                        Kraton Bangkalan<br>
                        Telp. (0254) 345678
                    </p>
                </td>

                <td width="15%" align="right">
                </td>
            </tr>
        </table>

        <hr style="border:2px solid #000;">
    </div>

    {{-- Judul --}}
    <h3 class="text-center my-5">
        Laporan Inventory Bulan
        {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}
        {{ $tahun }}
    </h3>

    <div style="margin-top: 35px; display: flex; justify-content:center; align-items:center;">
        <table class="table" style="font-size: 10px">
            <thead>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Pembayaran</th>
                <th>Penanggung Jawab</th>
                <th class="w-25">Pesan</th>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ $item->produk->nama_produk }}</td>
                    <td>{{ $item->jumlah_barang }}</td>
                    <td>
                        {{ number_format($item->pembayaran, 0, ',', '.') }}
                    </td>
                    <td>
                        {{ $item->staff->name }}
                        ({{ $item->staff->email }})
                    </td>
                    <td class="w-25">
                        {{ $item->pesan ?? '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Tanda Tangan --}}
    <div style="margin-top:50px;">
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