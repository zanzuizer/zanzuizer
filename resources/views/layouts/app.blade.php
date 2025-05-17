<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-Control" content="no-store" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Quản lý thiết bị">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <title>@yield('title', 'Trang chủ')</title>
    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <!-- Toastr style -->
    <link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <!-- JQuery UI -->
    <link href="{{ asset('js/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
    <!-- Data Tables -->
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <!-- Flat Picker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css" integrity="sha512-MQXduO8IQnJVq1qmySpN87QQkiR1bZHtorbJBD0tzy7/0U9+YIC93QWHeGTEoojMVHWWNkoCp8V6OzVSYrX0oQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom styles -->
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style2.css') }}" rel="stylesheet">
    <style>
        /* Tùy chỉnh màu sắc nút theo yêu cầu */
        .btn-primary {
            background-color: #f8ac59;
            border-color: #f8ac59;
        }
        .btn-primary:hover, 
        .btn-primary:focus, 
        .btn-primary:active {
            background-color: #e8a04b;
            border-color: #e8a04b;
        }
        
        /* Nút 3 gạch (navbar-minimalize) */
        .navbar-minimalize {
            background-color: #1a7bb9 !important;
            border-color: #1a7bb9 !important;
        }
        .navbar-minimalize:hover,
        .navbar-minimalize:focus,
        .navbar-minimalize:active {
            background-color: #166ea8 !important;
            border-color: #166ea8 !important;
        }
        
        /* Tùy chỉnh màu cho nút Thêm mới */
        .btn-themmoi .btn-primary,
        .btn-primary.btn-add {
            background-color: #1a7bb9 !important;
            border-color: #1a7bb9 !important;
        }
        .btn-themmoi .btn-primary:hover, 
        .btn-themmoi .btn-primary:focus, 
        .btn-themmoi .btn-primary:active,
        .btn-primary.btn-add:hover, 
        .btn-primary.btn-add:focus, 
        .btn-primary.btn-add:active {
            background-color: #166ea8 !important;
            border-color: #166ea8 !important;
        }
    </style>
    @yield('css')
</head>

<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span>
                                <img alt="image" class="img-circle" src="images/logo.png" width="30px" height="30px" />
                            </span>
                            <a href="{{ route('home') }}">
                                <span class="clear">
                                    <span class="block m-t-xs">
                                        <strong class="font-bold">QUẢN LÝ THIẾT BỊ</strong>
                                    </span>
                                </span>
                            </a>
                        </div>
                        <div class="logo-element">
                            <img alt="image" class="img-circle" src="images/logo.png" width="30px" height="30px" />
                        </div>
                    </li>

                    {{-- Quản lý đơn vị --}}
                    @php $menu1 = request()->is('donvi*') || request()->is('phongkho*'); @endphp
                    <li class="{{ $menu1 ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa fa-university"></i>
                            <span class="nav-label">Quản lý đơn vị</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level {{ $menu1 ? 'in' : 'collapse' }}">
                            <li class="{{ request()->is('donvi*') ? 'active' : '' }}"><a href="{{ route('donvi.index') }}">Đơn vị</a></li>
                            <li class="{{ request()->is('phongkho*') ? 'active' : '' }}"><a href="{{ route('phongkho.index') }}">Phòng-kho</a></li>
                        </ul>
                    </li>

                    {{-- Quản lý người dùng --}}
                    @php $menu2 = request()->is('loaitaikhoan*') || request()->is('taikhoan*'); @endphp
                    <li class="{{ $menu2 ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-group"></i>
                            <span class="nav-label">Quản lý người dùng</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level {{ $menu2 ? 'in' : 'collapse' }}">
                            <li class="{{ request()->is('loaitaikhoan*') ? 'active' : '' }}"><a href="{{ route('loaitaikhoan.index') }}">Loại tài khoản</a></li>
                            <li class="{{ request()->is('taikhoan*') ? 'active' : '' }}"><a href="{{ route('taikhoan.index') }}">Danh sách tài khoản</a></li>
                            <li><a href="#">Lịch sử truy cập</a></li>
                        </ul>
                    </li>

                    {{-- Đồ nội thất --}}
                    @php $menu3 = request()->is('loainoithat*')||request()->is('noithat*')||request()->is('kiemkenoithat*'); @endphp
                    <li class="{{ $menu3 ? 'active' : '' }}">
                        <a href="#">
                            <i class="fa fa-bed"></i>
                            <span class="nav-label">Đồ nội thất</span><span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level {{ $menu3 ? 'in' : 'collapse' }}">
                            <li class="{{ request()->is('loainoithat*') ? 'active' : '' }}"><a href="{{route('loainoithat.index') }}">Loại đồ nội thất</a></li>
                            <li class="{{ request()->is('noithat*') ? 'active' : '' }}"><a href="#">Danh sách nội thất</a></li>
                            <li class="{{ request()->is('kiemkenoithat*') ? 'active' : '' }}"><a href="#">Danh mục kiểm kê</a></li>
                        </ul>
                    </li>

                    {{-- Biểu mẫu --}}
                    @php $menu4 = request()->is('bieumau*'); @endphp
                    <li class="{{ $menu4 ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-file"></i>
                            <span class="nav-label">Biểu mẫu</span><span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level {{ $menu4 ? 'in' : 'collapse' }}">
                            <li class="{{ request()->is('bieumau/thietbi*') ? 'active' : '' }}">
                                <a href="{{ route('bieumau.thietbi') }}">Biểu mẫu thiết bị</a>
                            </li>
                            <li class="{{ request()->is('bieumau/sokho*') ? 'active' : '' }}">
                                <a href="{{ route('bieumau.sokho') }}">Sổ quản lý kho</a>
                            </li>
                            <li class="{{ request()->is('bieumau/nhatky*') ? 'active' : '' }}">
                                <a href="{{ route('bieumau.nhatky') }}">Nhật ký phòng máy</a>
                            </li>
                        </ul>
                    </li>

                    {{-- Ghi sổ nhật ký --}}
                    @php $menu5 = request()->is('nhatkyphongmay*') || request()->is('hocky*') || request()->is('nhatkythietbi*'); @endphp
                    <li class="{{ $menu5 ? 'active' : '' }}">
                        <a href="#"><i class="fa fa-book"></i>
                            <span class="nav-label">Ghi sổ nhật ký</span><span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level {{ $menu5 ? 'in' : 'collapse' }}">
                            <li><a href="#">Quản lý học kỳ</a></li>
                            <li class="{{ request()->is('nhatkyphongmay*') ? 'active' : '' }}">
                                <a href="{{ route('nhatkyphongmay.index') }}">Nhật ký phòng máy</a>
                            </li>
                            <li><a href="#">Sổ quản lý kho</a></li>
                            <li><a href="#">Nhật ký từng loại thiết bị</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        <!-- <form role="search" class="navbar-form-custom" action="search_results.html">
                            <div class="form-group">
                                <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                            </div>
                        </form> -->
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="#"
                                onclick="event.preventDefault();sessionStorage.clear(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> Đăng xuất
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="dashboard-header">
                @yield('content')
            </div>
            @include('layouts.footer')
        </div>
    </div>
    <!-- JQuery -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <!-- Jquery UI -->
    <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- Metis Menu -->
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <!-- Loading progress bar -->
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
    <!-- Data Tables -->
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <!-- Flat Picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js" integrity="sha512-K/oyQtMXpxI4+K0W7H25UopjM8pzq0yrVdFdG21Fh5dBe91I40pDd9A4lzNlHPHBIP2cwZuoxaUSX0GJSObvGA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('js')
    @include('layouts.toast')
</body>

</html>