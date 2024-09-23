<!DOCTYPE html>
<html lang="en">
@php $setting = DB::table('settings')->where('id', 1)->first(); @endphp

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@if(isset($setting->company_title) && $setting->company_title!=''){{$setting->company_title}} @endif</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
    <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">


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
                <span class="d-none d-lg-block">BDM CRM</span>
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
                        $bde = DB::table('bdes')->where('id',Session::get('user_id'))->first();
                        @endphp
                        @if(isset($bde->profile_pic) && $bde->profile_pic!='')
                        <img src="{{asset('public/assets/uploads/bde/'.$bde->profile_pic)}}" class="rounded-circle">
                        @else
                        <img src="{{asset('public/assets/img/profile-img.jpg')}}" class="rounded-circle">
                        @endif
                        <span class="d-none d-md-block dropdown-toggle ps-2">@if(isset($bde->bde_name) && $bde->bde_name!='') {{$bde->bde_name}} @endif</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{url('bde/profile')}}">
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
                            <a class="dropdown-item d-flex align-items-center" href="{{url('bde/logout-bde')}}">
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
                <a class="nav-link " href="{{url('bde/deshboard')}}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-heading">Assign Meetings Details</li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('bde.show-assign-meeting')}}">
                    <i class="bi bi-people-fill"></i>
                    <span>Assign Meeting</span>
                </a>
            </li>
            <hr>
            <li class="nav-heading">Meetings Details</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('bde.view-bde-meeting')}}">
                    <img src="{{asset('assets/img/meeting.png')}}" style="width:18px; opacity: 0.5;"> &nbsp; <span> Meeting Attend </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#coldcall" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-telephone-fill"></i> <span> Cold Call </span> <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="coldcall" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{url('bde/add-bde-coldcall')}}">
                            <i class="bi bi-plus-circle-fill"></i><span>Add Cold Call</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('bde/view-bde-coldcall')}}">
                            <i class="bi bi-eye-fill"></i><span>View Cold Call</span>
                        </a>
                    </li>

                </ul>
            </li>


            <li class="nav-heading">Check meeting availability</li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('bde.meeting-report')}}">
                    <i class="bi bi-file-earmark-check-fill"></i> <span>Meetings Report</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('bde.report-coldcall')}}">
                    <i class="bi bi-file-earmark-check-fill"></i> <span>Cold Call Report</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('bde.total-meeting-report')}}">
                    <i class="bi bi-file-earmark-check-fill"></i> <span>Total Meetings Report</span>
                </a>
            </li>
        </ul>

    </aside>

    <main id="main" class="main">

        @yield('content')

    </main>


    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Arya web coding</span></strong>. All Rights Reserved
        </div>
        <div class="credits">

            Created by <a target="_blank" href="">Arya web coding</a>
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
