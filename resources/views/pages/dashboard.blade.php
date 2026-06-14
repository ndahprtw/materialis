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

    <div class="row">
      <div class="col-lg-8">
        <div class="card">
            <div class="card-body row justify-content-center text-center m-2">
              <img src="{{ asset('assets/img/logo.png') }}" alt="logo perusahaan" class="img-fluid w-50 my-3 rounded-5 ">
              <h5> Selamat Datang, <b>{{ auth()->user()->name }}</b> </h5>
              <h3 class="fw-bold"> MATERIALIS </h3>
              <p>(Material Information System)</p>
            </div>
        </div>
      </div>

      <div class="col-lg-4">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-12">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Sales</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-buildings"></i>
                    </div>
                    <div class="ps-3">
                      <h6> {{ $sales }} </h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-12">
              <div class="card info-card revenue-card">

                <div class="card-body">
                  <h5 class="card-title">Bahan Material</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6> {{ $material }} </h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-12">

              <div class="card info-card customers-card">

                <div class="card-body">
                  <h5 class="card-title">Karyawan</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $karyawan }}</h6>
                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

          </div>
      </div>
    </div>

    </section>
@endsection