<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Download Filter Data</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/img/logo.png') }}" rel="icon">
  <link href="{{ asset('assets/img/logo.png') }}" rel="logo">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

  <div>

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
    

    <div style="margin-top: 35px; display: flex; justify-content:center; align-items:center;">
      <table class="table" style="font-size: 10px">
        <thead>
            <th> Tanggal </th>
            <th> Jenis </th>
            <th> Produk </th>
            <th> Jumlah </th>
            <th> Pembayaran </th>
            <th> Penanggung Jawab </th>
            <th class="w-25"> Pesan </th>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->jenis }}</td>
                <td>{{ $item->produk->nama_produk }} </td>
                <td>{{ $item->jumlah_barang }}</td>
                <td>
                    @if($item->jenis == 'barang masuk')
                        {{ number_format($item->pembayaran, 0, ',', '.') }}
                    @elseif($item->jenis == 'barang keluar')
                        {{ number_format($item->pembayaran, 0, ',', '.') }} <br>
                    @endif
                </td>
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

  <script type="text/javascript">
    window.print();
  </script>
</body>

</html>
