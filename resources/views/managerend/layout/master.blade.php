<!DOCTYPE html>
<html lang="en">
@php $setting = DB::table('settings')->where('id', 1)->first(); @endphp

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@if(isset($setting->company_title) && $setting->company_title!=''){{$setting->company_title}} @endif</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.18/sweetalert2.min.css"> --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>


    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                {{-- @if(isset($setting->site_logo) && $setting->site_logo!="") --}}
                <img src="{{asset('public/assets/uploads/logo/1719429761.jpg')}}" style="height:100px; width:150px;">
                {{-- @endif --}}
                {{-- <span class="d-none d-lg-block">CRM Manager</span> --}}
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->



        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->


                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        @php
                        $manager = DB::table('managers')->where('id',Session::get('user_id'))->first();
                        @endphp
                        @if(isset($manager->profile_pic) && $manager->profile_pic!='')
                        <img src="{{asset('public/assets/uploads/manager/'.$manager->profile_pic)}}" class="rounded-circle">
                        @else
                        <img src="{{asset('public/assets/img/profile-img.jpg')}}" class="rounded-circle">
                        @endif
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{Auth::guard('manager')->user()->name}}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{url('manager/m-profile')}}">
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
                            <a class="dropdown-item d-flex align-items-center" href="{{url('manager/logout-manager')}}">
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
                <a class="nav-link " href="{{url('manager/deshboard')}}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
          
            @if(Auth::guard('manager')->user()->user_type == 1)
            
            <hr>

          

            <li class="nav-heading">Team Master</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('managerleave')}}">
                    <i class="bi bi-people-fill"></i>
                    <span>Leave</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('manager-employee')}}">
                    <i class="bi bi-people-fill"></i>
                    <span>Employee</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('manager_attendance')}}">
                    <i class="bi bi-people-fill"></i>
                    <span>Attendance</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('hiring')}}">
                    <i class="bi bi-people-fill"></i>
                    <span>Hiring</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="">
                    <i class="bi bi-people-fill"></i>
                    <span>Message</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('manager.divice')}}">
                    <i class="bi bi-people-fill"></i>
                    <span>Accest Tracker</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{url('manager/view-tele-team')}}">
                    <i class="bi bi-people-fill"></i>
                    <span>Telemarketing</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="{{url('manager/view-market-mteam')}}">
                    <i class="bi bi-people-fill"></i>
                    <span>Marketing</span>
                </a>
            </li> --}}

            <hr>
           
            <li class="nav-heading">Meeting Details</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('manager.massign-meeting')}}">
                    <i class="bi bi-people-fill"></i>
                    <span>Assign Meeting</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('manager.view-meeting-manager')}}">
                    <img src="{{asset('public/assets/img/meeting.png')}}" style="width:18px; opacity: 0.5;">&nbsp; <span>Attend Meeting</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('manager.coldcall')}}">
                    <i class="bi bi-telephone-outbound-fill"></i>

                    <span>Cold Call</span>
                </a>
            </li> --}}

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('backend.leads')}}">
                    <i class="bi bi-people-fill"></i>
                    <span>Lead</span>
                </a>
            </li>


            <hr>
            <li class="nav-heading">Meetings Reports</li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('manager.meeting-report')}}">
                    <i class="bi bi-file-earmark-check-fill"></i> <span> Meetings Report</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('manager.coldcall-report')}}">
                    <i class="bi bi-file-earmark-check-fill"></i> <span> Cold Call Report</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('manager.total-mettingReport')}}">
                    <i class="bi bi-file-earmark-check-fill"></i> <span> Total Meetings Report</span>
                </a>
            </li>
        </ul>
        
        @endif

        @if(Auth::guard('manager')->user()->user_type == 2)

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{route('manager-employee')}}">
                <i class="bi bi-people-fill"></i>
                <span>Employee</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{route('manager_attendance')}}">
                <i class="bi bi-people-fill"></i>
                <span>Attendance</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="">
                <i class="bi bi-people-fill"></i>
                <span>Message</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{route('backend.leads')}}">
                <i class="bi bi-people-fill"></i>
                <span>Lead</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="">
                <i class="bi bi-people-fill"></i>
                <span>State</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="">
                <i class="bi bi-people-fill"></i>
                <span>Manage Task</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{route('manager.report')}}">
                <i class="bi bi-people-fill"></i>
                <span>Report</span>
            </a>
        </li>
            
        @endif

    </aside>

    <main id="main" class="main">

        @yield('content')

    </main>


    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>AWS Connect</span></strong>. All Rights Reserved
        </div>
        <div class="credits">

            Created by <a target="_blank" href="http://www.magnumdigitalsolution.com/">AWS Connect</a>
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
