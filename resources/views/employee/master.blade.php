<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@if(isset($users->company_title) && $users->company_title!=""){{$users->company_title}} @endif</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{asset('/public/assets/img/favicon.png')}}" rel="icon">
    <link href="{{asset('/public/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
</head>

<body>

    <style>
        .logo img {
        max-height: 60px;
        margin-right: 100px;
    }
    .dropdown-toggle::after{
     /* display: inline-block ;  */
     /* margin-left: 100%;  */
     margin-right : 20% !important;
     /* vertical-align: .255em;  */
     /* content: ""; */
    }
    </style>
    
    <header id="header" class="header fixed-top d-flex align-items-center">
      
        <div class="d-flex align-items-center justify-content-between">
            <a href="" class="logo d-flex align-items-center">
                <img src="{{asset('public/assets/uploads/logo/1719429761.jpg')}}">
                <span class="d-none d-lg-block">@if(isset($setting->company_title) && $setting->company_title!='') {{$setting->company_title}} @endif</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div>


        <nav class="header-nav ms-auto">

        

            <ul class="d-flex align-items-center">

            

      

</ul>
</nav>

<!-- <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-end">

                


        <li class="align-items-end">
            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
               
                <i class="bi bi-bell" aria-hidden="true"></i>
                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end mailbox animated bounceInDown">
                <ul id="messageList">
                    <li>
                        <div class="drop-title">Notifications</div>
                    </li>

                    <li>
                        <div class="message-center ps ps--theme_default" data-ps-id="5c1f353f-e42f-b76f-b7a7-87d36dad2cc2">
                            <a href="javascript:void(0)">
                                <div class="btn btn-danger btn-circle text-white"><i class="fa fa-link"></i></div>
                                <div class="mail-contnet">
                                    <h5 class="time">9:30</h5> <span class="mail-desc">Just see the my new admin!</span>  </div>
                            </a>
                        <div class="ps__scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps__scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__scrollbar-y-rail" style="top: 0px; right: 0px;"><div class="ps__scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
                    </li>

                    <li>
                        <a class="nav-link text-center link" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                    </li>
                </ul>
            </div>
        </li>

    </ul>
</nav> -->



        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                         <!-- <li>
                            <a class="dropdown-item d-flex align-items-center" href="">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li> -->


                        <li class="nav-item dropdown">
    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-bell"></i>
        <span class="badge bg-primary badge-number"> </span>
    </a><!-- End Notification Icon -->

    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" id="messageList">
        <li class="dropdown-header">
            <!-- You have 4 new notifications -->
            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>
        <!-- Notification items will be appended here by JavaScript -->
        <li class="dropdown-footer">
            <a href="#">Show all notifications</a>
        </li>
    </ul><!-- End Notification Dropdown Items -->
</li>

                        
                        


                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                       
                        <img src="{{asset('public/assets/img/profile-img.jpg')}}" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{Auth::guard('employee')->user()->name}}</span>
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
                            <a class="dropdown-item d-flex align-items-center" href="{{route('employee-profile')}}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <!-- <li>
                            <a class="dropdown-item d-flex align-items-center" href="">
                                <i class="bi bi-gear"></i>
                                <span> Settings</span>
                            </a>
                        </li> -->
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <!-- <li>
                            <a class="dropdown-item d-flex align-items-center" href="">
                                <i class="bi bi-question-circle"></i>
                                <span>Services</span>
                            </a>
                        </li> -->
                        <!-- <li>
                            <a class="dropdown-item d-flex align-items-center" href="">
                                <i class="bi bi-people"></i>
                                <span>Admin</span>
                            </a>
                        </li> -->
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{route('employee.logout')}}">
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
                <a class="nav-link " href="{{route('index')}}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            
            <hr>

            @if (ViewPermission(1))
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('Eattendance')}}">
                    <i class="bi bi-people-fill"></i>
                    <span>Attendance</span>
                </a>
            </li>
            @endif
           

            @if (ViewPermission(2))
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('employee_notification_view')}}">
                    <i class="bi bi-people-fill"></i>
                    <span>Notifications</span>
                </a>
            </li>
            @endif

           
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#task" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-book"></i><span> Lead </span> <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="task" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    
                    @if (AddPermission(3))
                    <li>
                        <a href="{{route('backend.client')}}">
                            <i class="bi bi-plus-circle-fill"></i><span>Add Lead</span>
                        </a>
                    </li>
                    @endif

                    @if (ViewPermission(3))
                    <li>
                        <a href="{{route('backend.view-client')}}">
                            <i class="bi bi-eye-fill"></i><span>View Lead</span>
                        </a>
                    </li>
                    @endif

                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-people-fill"></i><span> Masters </span> <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                   
                    @if (ViewPermission(4))
                    <li>
                        <a href="{{route('leave')}}">
                            <i class="bi bi-eye-fill"></i><span>Leave</span>
                        </a>
                    </li>
                    @endif
   

                </ul>
            </li>

            <li class="nav-heading"> Agent Master</li>

            @if (ViewPermission(5))
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('agent-master')}}">
                    <i class="bi bi-people-fill"></i>
                    <span>Agent</span>
                </a>
            </li>
            @endif

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#Masters" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-people-fill"></i><span> file Manager </span> <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="Masters" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                    @if (ViewPermission(6))
                    <li>
                        <a href="{{route('employee_file')}}">
                            <i class="bi bi-eye-fill"></i><span>File</span>
                        </a>
                    </li>
                    @endif
   

                </ul>
            </li>
         
            <hr>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('employee.logout')}}">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>


        </ul>

    </aside>

    <main id="main" class="main">

        @yield('content')

    </main>


    <!-- <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Aws Connect</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Created by <a target="_blank" href="">Aws Connect</a>
        </div>
    </footer> -->

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

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>


    <!-- Template Main JS File -->
    <script src="{{asset('public/assets/js/main.js')}}"></script>

    <script>
        $(document).ready(function(){
    $.ajax({
        url: "{{ route('getMessages') }}",
        type: "GET",
        success: function(response) {
            if (response.status === 'success') {
                var messageList = $('#messageList'); 
                messageList.find('.notification-item').remove();
                
                $.each(response.data, function(index, message) {
                    var messageTime = new Date(message.updated_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    var messageItem = `
                        <li class="notification-item">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <div>
                                <h4>${message.title}</h4>
                                <p>${message.message}</p>
                                <p>${messageTime}</p>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    `;
                    messageList.find('.dropdown-footer').before(messageItem);
                });
            } else {
                console.error('Error: Unable to fetch messages.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching messages:', error);
        }
    });
});

    </script>
   
</body>

</html>
