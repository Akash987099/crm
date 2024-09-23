<!DOCTYPE html>
<html lang="en">
    

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@if(isset($setting->company_title) && $setting->company_title!=''){{$setting->company_title}} @endif</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{asset('public/assets/img/favicon.png')}}" rel="icon">
    <link href="{{asset('public/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">


    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="{{asset('public/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/jquery.dataTables.min.css')}}" rel="stylesheet">

</head>

<body>
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                @if(isset($setting->site_logo) && $setting->site_logo!="")
                <img src="{{asset('public/assets/uploads/logo/'.$setting->site_logo)}}">
                @endif
                <span class="d-none d-lg-block">Telecalling CRM</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->



        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li>


                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        @php
                        $teleMarket = DB::table('tele_person')->where('id',Session::get('user_id'))->first();
                        @endphp
                        @if(isset($teleMarket->document_file) && $teleMarket->document_file!='')
                        <img src="{{asset('public/assets/uploads/telemarketing/'.$teleMarket->document_file)}}" class="rounded-circle">
                        @else
                        <img src="{{asset('public/assets/img/profile-img.jpg')}}" class="rounded-circle">
                        @endif
                        <span class="d-none d-md-block dropdown-toggle ps-2">@if(isset($teleMarket->firstname) && $teleMarket->firstname!='') {{$teleMarket->firstname}} @endif</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <!-- <li class="dropdown-header">
                            <h6>Kevin Anderson</h6>
                            <span>Web Designer</span>
                        </li> -->
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{url('telecaller.my-profile')}}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>

                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>


                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{url('telecaller.telelogout')}}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </nav>

    </header>


    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="{{route('telecaller.index')}}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-heading">Lead Payments</li>

             <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('telecaller.agent')}}">
                    <i class="bi bi-person"></i>
                    <span>Agent</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('telecaller.asset')}}">
                    <i class="bi bi-person"></i>
                    <span>Asset Track</span>
                </a>
            </li>
            {{-- <li class="nav-heading">Call Details</li> --}}

           {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('telecaller.client-calling')}}">
                    <i class="bi bi-telephone-outbound-fill"></i>
                    <span>Client Call</span>
                </a>
            </li> --}}
            <hr>
            <li class="nav-heading">Login Details</li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{url('telelogout')}}">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>

    </aside>

    <main id="main" class="main">
        @yield('content')
    </main>
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Aws Connect</span></strong>. All Rights Reserved
        </div>
        <div class="credits">

            Created by <a target="_blank" href="https://www.youtube.com/c/Aryawebdeveloper">Awc</a>
        </div>
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{asset('public/assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/assets/vendor/chart.js/chart.umd.js')}}"></script>
    <script src="{{asset('public/assets/vendor/echarts/echarts.min.js')}}"></script>
    <script src="{{asset('public/assets/vendor/quill/quill.min.js')}}"></script>
    <script src="{{asset('public/assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
    <script src="{{asset('public/assets/vendor/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('public/assets/vendor/php-email-form/validate.js')}}"></script>

    <!-- Template Main JS File -->
    <script src="{{asset('public/assets/js/main.js')}}"></script>

    @stack('footer-script')
</body>

</html>
