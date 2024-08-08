<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"
          rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('/adminlte/css/adminlte.min.css')}}">
    <link href="{{ asset('/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.admin.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/sweetalert2.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/sweetalert2.min.js')}}"></script>
    <title>Toko Helm | Halaman Admin</title>
    @yield('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<nav class="main-header navbar navbar-expand custom-navbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link navbar-link-item" data-widget="pushmenu" href="#" role="button">
                <i class='bx bx-menu'></i>
            </a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link navbar-link-item">Logout</a>
        </li>
    </ul>
</nav>
<aside class="main-sidebar sidebar-dark-primary custom-sidebar">
    <div class="sidebar">
        <div class="sidebar-brand-container">
            <a href="#" class="sidebar-brand">
                <img src="{{ asset('/assets/images/payment-bg.png') }}" alt="brand-image">
{{--                <p class="color-dark ms-2" style="color: var(--bg-primary);">TOKO HELM</p>--}}
            </a>
        </div>
        <div class="sidebar-item-container">
            <ul class="nav nav-sidebar nav-pills flex-column" style="gap: 0.25rem">
                <li class="nav-item">
                    <a href="#"
                       class="nav-link d-flex align-items-center sidebar-item {{ request()->is('dashboard*') ? 'active' : '' }}">
                        <i class="bx bxs-dashboard"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user') }}"
                       class="nav-link d-flex align-items-center sidebar-item {{ request()->is('user*') ? 'active' : '' }}">
                        <i class='bx bx-user'></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('category') }}"
                       class="nav-link d-flex align-items-center sidebar-item {{ request()->is('category*') ? 'active' : '' }}">
                        <i class='bx bx-purchase-tag'></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('product') }}"
                       class="nav-link d-flex align-items-center sidebar-item {{ request()->is('product*') ? 'active' : '' }}">
                        <i class='bx bxs-component'></i>
                        <p>Product</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('shipping') }}"
                       class="nav-link d-flex align-items-center sidebar-item {{ request()->is('shipping*') ? 'active' : '' }}">
                        <i class='bx bx-car'></i>
                        <p>Shipping Setting</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('order') }}"
                       class="nav-link d-flex align-items-center sidebar-item {{ request()->is('order*') ? 'active' : '' }}">
                        <i class='bx bx-shopping-bag'></i>
                        <p>Pesanan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('report.order') }}"
                       class="nav-link d-flex align-items-center sidebar-item {{ request()->is('report-order*') ? 'active' : '' }}">
                        <i class='bx bxs-report'></i>
                        <p>Laporan Penjualan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('report.stock') }}"
                       class="nav-link d-flex align-items-center sidebar-item {{ request()->is('report-stock*') ? 'active' : '' }}">
                        <i class='bx bxs-report'></i>
                        <p>Laporan Stok</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('report.customer') }}"
                       class="nav-link d-flex align-items-center sidebar-item {{ request()->is('report-customer*') ? 'active' : '' }}">
                        <i class='bx bxs-report'></i>
                        <p>Laporan Customer</p>
                    </a>
                </li>
{{--                <li class="nav-item">--}}
{{--                    <a href="{{ route('admin.setting-kredit') }}"--}}
{{--                       class="nav-link d-flex align-items-center sidebar-item {{ request()->is('admin/setting-kredit*') ? 'active' : '' }}">--}}
{{--                        <i class='bx bx-cog'></i>--}}
{{--                        <p>Setting Kredit</p>--}}
{{--                    </a>--}}
{{--                </li>--}}
{{--                <li class="nav-item">--}}
{{--                    <a href="#"--}}
{{--                       class="nav-link d-flex align-items-center sidebar-item {{ request()->is('admin/transaction*') ? 'active' : '' }}">--}}
{{--                        <i class='bx bx-shopping-bag'></i>--}}
{{--                        <p>Transaction</p>--}}
{{--                    </a>--}}
{{--                </li>--}}
            </ul>
        </div>
    </div>
</aside>

<div class="content-wrapper p-4">
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset ('/adminlte/js/adminlte.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
@yield('js')
</body>
</html>
