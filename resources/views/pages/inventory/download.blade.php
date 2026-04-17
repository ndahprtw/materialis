<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Laporan Bulanan</title>
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
        Laporan Inventory Bulan {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}
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
            <th> Kurir </th>
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
                        @if ($item->pelacakan)
                            @if ($item->pelacakan->status == 'dikemas' || $item->pelacakan->status == 'dikirim')
                                sedang {{ $item->pelacakan->status }}
                            @elseif ($item->pelacakan->status == 'dibatalkan')
                                {{ $item->pelacakan->status }}
                            @else
                                @if ($item->pelacakan->jumlah_pelunasan == null)
                                    belum dibayar
                                @else
                                    Dibayar : {{ number_format($item->pelacakan->jumlah_pelunasan, 0, ',', '.') }} <br>
                                    @if ($item->pelacakan->sisa_pelunasan != 0)
                                        <span class="badge rounded-pill bg-warning"><i class="bi bi-exclamation-circle"></i></span>{{ number_format($item->pelacakan->sisa_pelunasan, 0, ',', '.') }}
                                    @else
                                        Status : lunas
                                    @endif
                                @endif
                            @endif
                        @endif
                    @endif
                </td>
                <td>{{ $item->staff->name }} ( {{ $item->staff->email }} ) </td>
                <td>
                    @if ($item->pelacakan)
                        @if($item->pelacakan->id_kurir != null)
                            {{ $item->pelacakan->kurir->name }} ( {{ $item->pelacakan->kurir->email }} )
                        @else
                            -
                        @endif
                    @endif
                </td>
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
