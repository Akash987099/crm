<!DOCTYPE html>
<html lang="en">
@php
$setting = DB::table('settings')->where('id', Session::get('company_id'))->first();
@endphp


<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@if(isset($users->company_title) && $users->company_title!=""){{$users->company_title}} @endif</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{asset('/public/assets/img/favicon.png')}}" rel="icon">
    <link href="{{asset('/public/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">


    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="{{asset('public/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('public/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet"> -->
    <link href="{{asset('public/assets/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

     <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet"> 


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap.min.js"></script>

 <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
</head>

<body>

<style>
    .logo img {
    max-height: 60px;
    margin-right: 100px;
}
</style>

    <header id="header" class="header fixed-top d-flex align-items-center">
      
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{route('backend.home')}}" class="logo d-flex align-items-center">
            <img src="{{asset('public/assets/uploads/logo/1719429761.jpg')}}">
                <!-- <span class="d-none d-lg-block">@if(isset($setting->company_title) && $setting->company_title!='') {{$setting->company_title}} @endif</span> -->
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <!-- <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div> -->

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
                        $user = DB::table('users')->where('id',Session::get('company_id'))->first();
                        @endphp
                        @if(isset($user->profile_pic) && $user->profile_pic!='')
                        <img src="{{asset('public/assets/uploads/users/'.$user->profile_pic)}}" alt="Profile" class="rounded-circle">
                         @else
                        <img src="{{asset('public/assets/img/profile-img.jpg')}}" alt="Profile" class="rounded-circle">
                        @endif
                        <span class="d-none d-md-block dropdown-toggle ps-2">@if(isset($user->name) && $user->name!='') {{$user->name}} @endif</span>
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
                            <a class="dropdown-item d-flex align-items-center" href="{{url('admin/profile')}}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{url('admin/setting')}}">
                                <i class="bi bi-gear"></i>
                                <span> Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{url('admin/services')}}">
                                <i class="bi bi-question-circle"></i>
                                <span>Services</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{url('admin/user-admin')}}">
                                <i class="bi bi-people"></i>
                                <span>Admin</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{url('admin/logout')}}">
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
                <a class="nav-link " href="{{url('admin/home')}}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-user" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-people-fill"></i><span> Users </span> <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-user" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{route('backend.telemarket.view-telemarketing')}}">
                            <i class="bi bi-eye-fill"></i><span>Telemarketing</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{route('backend.view-marketing-list')}}">
                            <i class="bi bi-eye-fill"></i><span>Sales Team</span>
                        </a>
                    </li> --}}
                    <li>
                        <a href="{{route('backend.manager.view-manager')}}">
                            <i class="bi bi-eye-fill"></i><span>Manager/Hr</span>
                        </a>
                    </li>

                </ul>
            </li>

            {{-- <hr> --}}
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-people-fill"></i><span> Masters </span> <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                   
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{route('Privilege')}}">
                            <i class="bi bi-telephone-fill"></i>
                            <span>Employee Permision</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{route('Distributor')}}">
                            <i class="bi bi-ussers"></i>
                            <span>Distributor</span>
                        </a>
                    </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('Designation')}}">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Designation</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('letter')}}">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Letter Template</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('status')}}">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Status Master</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{url('admin/user-admin')}}">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Add Admin</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('adminagent')}}">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Agent</span>
                </a>
            </li>

                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#Store" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-telephone-fill"></i> <span> Store </span> <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="Store" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                    <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('Product')}}">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Project</span>
                </a>
            </li>
                </ul>
            </li>
            
         
            
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#coldcall" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-telephone-fill"></i> <span> Sales </span> <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="coldcall" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                    <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('backend.lead')}}">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Lead</span>
                </a>
            </li>

            <li>
                <a href="{{route('backend.add-cold-calls')}}">
                    <i class="bi bi-plus-circle-fill"></i><span>Add Cold Call</span>
                </a>
            </li>
            <li>
                <a href="{{route('backend.view-cold-call')}}">
                    <i class="bi bi-eye-fill"></i><span>View Cold Call</span>
                </a>
            </li>

            <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('admin/calling-list')}}">
            <i class="bi bi-telephone-fill"></i>
            <span>Call History</span>
        </a>
    </li>

            <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('backend.view-meeeting')}}">
            <i class="bi bi-person-lines-fill"></i>
            <span>Attend Meetings</span>
        </a>
    </li>

                </ul>
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('backend.view-meeeting')}}">
                    <i class="bi bi-person-lines-fill"></i>
                    <span>Attend Meetings</span>
                </a>
            </li>
-->

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#account" data-bs-toggle="collapse" href="#">
        <i class="bi bi-telephone-fill"></i> <span> Account </span> <i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="account" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
        <li class="nav-item">
    <a class="nav-link collapsed" href="{{route('agent')}}">
        <i class="bi bi-telephone-fill"></i>
        <span>Agent Invoice</span>
    </a>
</li>
    </ul>
</li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#BDE" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-building"></i><span> Hr </span> <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="BDE" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('admin_leave')}}">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Leave</span>
                </a>
               </li>

                <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('employee')}}">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Employee</span>
                </a>
               </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('Admin_attendance')}}">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Attendance</span>
                </a>
            </li>

          
            <li class="nav-item">
                <a class="nav-link collapsed" href="">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Hiring</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('admin_messages')}}">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Mesages</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('admin.divice')}}">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Asset Tracker</span>
                </a>
            </li>

                </ul>
            </li> 

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#file" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-building"></i><span> File Manager </span> <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="file" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('admin_file')}}">
                    <i class="bi bi-telephone-fill"></i>
                    <span>File</span>
                </a>
               </li>


                </ul>
            </li> 


            <hr>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#report" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-building"></i><span> Report </span> <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="report" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('admin_Allemployee')}}">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Sales Report</span>
                </a>
               </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{url('admin/check-availability')}}">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Check Call</span>
                </a>
            </li>
            <li class="nav-heading"> Meetings Reports</li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('backend.meeting-report')}}">
                    <i class="bi bi-file-earmark-check-fill"></i>
                    <span>Meetings Report</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('backend.coldcall-report')}}">
                    <i class="bi bi-file-earmark-check-fill"></i>
                    <span>Cold Call Report</span>
                </a>
            </li>

              
            <li class="nav-heading"> Product Reports</li>

               <li class="nav-item">
                <a class="nav-link collapsed" href="">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Total pnb file</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Total bob file</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Total Kotak file</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Total kiosk file</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Total pending leads</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Total confirm lead</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Total due payment</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="">
                    <i class="bi bi-telephone-fill"></i>
                    <span>Total payment</span>
                </a>
            </li>



                </ul>
            </li> 
           
           
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{url('admin/logout')}}">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>
            
         

        </ul>

    </aside>

    <main id="main" class="main">

        @yield('content')

    </main>


    {{-- <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Aws Connect</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Created by <a target="_blank" href="https://www.youtube.com/c/Aryawebdeveloper">Awc</a>
        </div>
    </footer> --}}

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
