<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    @if (auth()->user()->role == 'Karyawan' || auth()->user()->role == 'Admin')
      <!-- Dashboard Nav -->
      <li class="nav-item">
        <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::is('dashboard') ? '' : 'collapsed' }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
    @endif

    @if (auth()->user()->role == 'Admin')
      <!-- Nav -->
      <li class="nav-item">
        <a href="{{ url('/data-staff') }}" class="nav-link {{ Request::is('data-staff*') ? '' : 'collapsed' }}">
          <i class="bi bi-people-fill"></i>
          <span>Data Karyawan</span>
        </a>
      </li><!-- End Nav -->
    @endif
    
    @if (auth()->user()->role == 'Karyawan' || auth()->user()->role == 'Admin')
        <!-- Nav -->
        <li class="nav-item">
          <a href="{{ url('/data-pelanggan') }}" class="nav-link {{ Request::is('data-pelanggan*') ? '' : 'collapsed' }}">
            <i class="bi bi-person-heart"></i>
            <span> Data Pelanggan </span>
          </a>
        </li><!-- End Nav -->
    
        <!-- Nav -->
        <li class="nav-item">
          <a href="{{ url('/data-sales') }}" class="nav-link {{ Request::is('data-sales*') ? '' : 'collapsed' }}">
            <i class="bi bi-person-lines-fill"></i>
            <span> Data Sales </span>
          </a>
        </li><!-- End Nav -->
    
        <!-- Nav -->
        <li class="nav-item">
          <a href="{{ url('/data-product') }} " class="nav-link {{ Request::is('data-product*') ? '' : 'collapsed' }}">
            <i class="bi bi-bag-fill"></i>
            <span>Informasi Produk</span>
          </a>
        </li><!-- End Nav -->
    
        <!-- Nav -->
        <li class="nav-item">
          <a href="{{ url('/inventory') }}" class="nav-link {{ Request::is('inventory*') || Request::is('laporan') ? '' : 'collapsed' }}">
            <i class="bi bi-arrow-left-right"></i>
            <span> Inventory </span>
          </a>
        </li><!-- End Nav -->
    
        <!-- Nav -->
        <li class="nav-item">
          <a href="{{ url('/pelacakan') }}" class="nav-link {{ Request::is('pelacakan*') ? '' : 'collapsed' }}">
            <i class="bi bi-geo-alt-fill"></i>
            <span> Pelacakan </span>
          </a>
        </li><!-- End Nav -->
    @endif

    @if (auth()->user()->role == 'Kurir')
        <!-- Nav -->
        <li class="nav-item">
          <a href="{{ url('/pelacakan') }}" class="nav-link {{ Request::is('pelacakan*') ? '' : 'collapsed' }}">
            <i class="bi bi-geo-alt-fill"></i>
            <span> Pelacakan </span>
          </a>
        </li><!-- End Nav -->
    @endif


    <!-- Logout Nav -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="/logout">
        <i class="bi bi-box-arrow-right"></i>
        <span>Logout</span>
      </a>
    </li><!-- End Logout Nav -->

  </ul>

</aside><!-- End Sidebar -->
