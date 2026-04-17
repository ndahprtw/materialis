@extends('layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

        <div class="row p-5" style="background-color: #798645">
    
            <!-- Pemasukan Card -->
            <div class="col-xxl-4 col-md-4">
              {{-- <div class="card info-card revenue-card bg-success"> --}}
              <div class="card info-card revenue-card" style="background-color: #FEFAE0">

                <div class="card-body">
                  <h5 class="card-title">Pemasukan</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-bag-heart-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6> Rp. {{ number_format($pemasukan, 0, ',', '.') }} </h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Pemasukan Card -->

            <!-- Pengeluaran Card -->
            <div class="col-xxl-4 col-md-4">
              {{-- <div class="card info-card sales-card bg-primary"> --}}
              <div class="card info-card sales-card" style="background-color: #FEFAE0">

                <div class="card-body">
                  <h5 class="card-title">Pengeluaran</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-bag-dash-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6> Rp. {{ number_format($pengeluaran, 0, ',', '.') }} </h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Pengeluaran Card -->

            <!-- Karyawan Card -->
            <div class="col-xxl-4 col-md-4">
              {{-- <div class="card info-card customers-card bg-warning"> --}}
              <div class="card info-card customers-card" style="background-color: #FEFAE0">

                <div class="card-body">
                  <h5 class="card-title"> Total Karyawan </h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6> {{ $karyawan}} Karyawan </h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Siswa Card -->          

            <!-- Reports -->
            <div class="col-12">
              <div class="card" style="background-color: #F2EED7">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter Tahun</h6>
                    </li>

                    <li>
                      <form action="/dashboard" method="GET">
                        <select id="tahunSelect" name="tahun" onchange="this.form.submit()" class="form-select">
                          @foreach($daftarTahun as $tahun)
                            <option value="{{ $tahun }}" {{ $tahun == $tahunIni ? 'selected' : '' }}>{{ $tahun }}</option>
                          @endforeach
                        </select>
                      </form>
                    </li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Reports <span>/ {{ $tahunIni }}</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      const bulan = @json($bulanBarang);
                      const pengeluaran = @json($data_total_harga_masuk);
                      const pemasukan = @json($data_total_harga_keluar);
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Pemasukan',
                          data: pemasukan
                        }, {
                          name: 'Pengeluaran',
                          data: pengeluaran
                        }],
                        chart: {
                          height: 350,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#2eca6a', '#ff771d'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          categories: bulan
                        },
                      }).render();
                    });
                  </script>
                  <!-- End Line Chart -->

                </div>

              </div>
            </div><!-- End Reports -->
    
            <div class="col-lg-6">
              <div class="card" style="background-color: #F2EED7">
                <div class="card-body">
                  <h5 class="card-title">Sales - Produk</h5>
    
                  <!-- Doughnut Chart -->
                  <canvas id="doughnutChart" style="max-height: 400px;"></canvas>
                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      // Mengambil data dari server
                      let data_sales = {!! json_encode($data_sales) !!};
                      let banyak_produk = {!! json_encode($banyak_produk) !!};

                      new Chart(document.querySelector('#doughnutChart'), {
                        type: 'doughnut',
                        data: {
                          labels: data_sales,
                          datasets: [{
                            label: 'Total',
                            data: banyak_produk,
                            backgroundColor: [
                              'rgb(255, 99, 132)',
                              'rgb(54, 162, 235)',
                              'rgb(255, 205, 86)'
                            ],
                            hoverOffset: 4
                          }]
                        }
                      });
                    });
                  </script>
                  <!-- End Doughnut CHart -->
    
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="card" style="background-color: #F2EED7">
                <div class="card-body">
                  <h5 class="card-title">Status Pelacakan</h5>

                  @if ($cek_status != 0)
                    <!-- Pie Chart -->
                    <canvas id="pieChart" style="max-height: 400px;"></canvas>
                    <script>
                      document.addEventListener("DOMContentLoaded", () => {
                        // Mengambil data dari server
                        let status = {!! json_encode($status) !!};
                        let data = {!! json_encode($data) !!};

                        new Chart(document.querySelector('#pieChart'), {
                          type: 'pie',
                          data: {
                            labels: status,
                            datasets: [{
                              label: 'Total',
                              data: data,
                              backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 205, 86)'
                              ],
                              hoverOffset: 4
                            }]
                          }
                        });
                      });
                    </script>
                    <!-- End Pie CHart -->
                  @else
                    <p class="text-center">
                      Belum ada aktivitas terbaru
                    </p>
                  @endif
    
                </div>
              </div>
            </div>


          </div>
    </section>
@endsection