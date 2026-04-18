<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <!-- Dashboard Nav -->
    <li class="nav-item">
      <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::is('dashboard') ? '' : 'collapsed' }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Manager')
      <!-- Nav -->
      <li class="nav-item">
        <a href="{{ url('/data-staff') }}" class="nav-link {{ Request::is('data-staff*') ? '' : 'collapsed' }}">
          <i class="bi bi-people-fill"></i>
          <span>Data Karyawan</span>
        </a>
      </li><!-- End Nav -->
    @endif
    
    @if (auth()->user()->role == 'Staff Gudang' || auth()->user()->role == 'Admin')
        <!-- Nav -->
        <li class="nav-item">
          <a href="{{ url('/data-sales') }}" class="nav-link {{ Request::is('data-sales*') ? '' : 'collapsed' }}">
            <i class="bi bi-person-lines-fill"></i>
            <span> Data Supplier </span>
          </a>
        </li><!-- End Nav -->
    
        <!-- Nav -->
        <li class="nav-item">
          <a href="{{ url('/data-product') }} " class="nav-link {{ Request::is('data-product*') ? '' : 'collapsed' }}">
            <i class="bi bi-bag-fill"></i>
            <span>Data Material</span>
          </a>
        </li><!-- End Nav -->
    
        <!-- Nav -->
        <li class="nav-item">
          <a href="{{ url('/inventory') }}" class="nav-link {{ Request::is('inventory*') || Request::is('laporan') ? '' : 'collapsed' }}">
            <i class="bi bi-arrow-left-right"></i>
            <span> Inventory </span>
          </a>
        </li><!-- End Nav -->
    
     
    @endif

    @if (auth()->user()->role == 'Staff Proyek' || auth()->user()->role == 'Staff Gudang')
        <!-- Nav -->
        <li class="nav-item">
          <a href="{{ url('/permintaan') }}" class="nav-link {{ Request::is('permintaan*') ? '' : 'collapsed' }}">
            <i class="bi bi-geo-alt-fill"></i>
            <span> Permintaan </span>
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
