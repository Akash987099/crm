<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    

<style>
    /* Global Styles */
  body {
      background-color: #7fb1e0;
      font-family: 'Arial', sans-serif;
  }
  
  /* Wrapper for the login section */
  .login-wrapper {
      max-width: 1200px;
      margin: auto;
  }
  
  /* Logo and banner adjustments */
  .logo img {
      max-width: 180px;
  }
  
  .banner img {
      max-width: 350px;
  }
  
  .slogan {
      font-size: 1.2rem;
      font-weight: bold;
      color: #333;
  }
  
  /* Form container styles */
  .form-container {
      max-width: 400px;
      width: 100%;
  }
  
  .form-label {
      font-weight: bold;
  }
  
  /* Footer Styles */
  .footer {
      position: fixed;
      bottom: 0;
      width: 100%;
      background-color: #f8f9fa;
      padding: 10px 0;
  }
  
  /* Background color and button adjustments */
  .bg-blue {
      background-color: #7fb1e0;
  }
  
  .btn-primary {
      background-color: #007bff;
      border: none;
  }
  
  /* Links styling */
  .links .link {
      color: #007bff;
      text-decoration: none;
      margin: 0 5px;
  }
  
  .links .link:hover {
      text-decoration: underline;
  }
  
  /* Captcha Image */
  .captcha img {
      max-width: 100px;
  }
  
  /* Media Queries for Responsiveness */
  @media (max-width: 992px) {
      .banner img {
          display: none;
      }
      .login-wrapper {
          max-width: 100%;
          padding: 0 20px;
      }
  }
  
  </style>

</head>
<body>

    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center bg-blue">
        <div class="row w-100 login-wrapper">
            <!-- Left Side -->
            <div class="col-lg-6 d-none d-lg-block bg-light p-5 text-center rounded">
                <div class="logo mb-4">
                    {{-- <img src="{{asset('public/assets/uploads/logo/1719429761.jpg')}}" alt="Logo" class="img-fluid"> --}}
                </div>
                <div class="banner mb-4">
                    <img src="{{asset('public/assets/uploads/logo/1719429761.jpg')}}" alt="Email Image" class="img-fluid">
                </div>
                <h5 class="slogan">Aws Connect And Innovative Solutions</h5>
            </div>

            <!-- Right Side - Login Form -->
            <div class="col-lg-6 bg-white p-5 d-flex flex-column justify-content-center align-items-center rounded">
                <div class="form-container">
                    <h2 class="text-center mb-4 fw-bold">Login</h2>
                    <form class="row g-3 needs-validation" method="POST" action="" id="loginpage">
                        @csrf
                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                <input type="email" name="email" value="{{$logindata->email ?? ' '}}" class="form-control" required>
                            </div>
                            <div class="text-danger">@error('email') {{$message}} @enderror</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" value="{{$logindata->show_password ?? ''}}" class="form-control" required>
                            <div class="text-danger">@error('password') {{$message}} @enderror</div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">Remember me</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <p class="small mb-0"> <a href="{{route('ForgetPassword')}}">Forget Password</a></p>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Login</button>
                        </div>
                        <div class="col-12">
                            <!--<p class="small mb-0">Don't have account? <a href="{{url('admin/signup')}}">Create an account</a></p>-->
                        </div>
                    </form>
                </div>

                <div class="mt-4 text-center links">
                    <a href="https://snedutech.com/admin/login" class="link" href="">Admin</a> |
                    <a href="https://snedutech.com/manager/login"  class="link" href="">Manager</a> |
                    <a href="https://snedutech.com/manager/login"  class="link" href="">ZSM</a> |
                    <a href="https://snedutech.com/employeeLogin"  class="link" href="">DM Login</a>
                </div>
            </div>
        </div>
    </div>

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
{{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.18/sweetalert2.min.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>

$(document).ready(function(){

    $('#loginpage').on('submit' , function(e){

        e.preventDefault();

        // alert('Calling');

        var formdata = $('#loginpage').serialize();

        $.ajax({

            url : "{{route('Manager_Login_submit')}}",
            type : "GET", 
            data : formdata,
            success : function(response){

                // console.log(response);

                if(response.status == "success"){

Swal.fire({
title: 'Success!',
text: 'You have successfully logged in.',
icon: 'success',
confirmButtonText: 'OK'
}).then((result) => {
if (result.isConfirmed) {
    window.location.href = "{{url('manager/deshboard')}}";
}
});

}

if(response.status == "error"){

Swal.fire({
// title: 'Ooops....',
text: 'Invalid Login credentials',
icon: 'error',
confirmButtonText: 'OK'
}).then((result) => {
if (result.isConfirmed) {
	window.location.reload();
}
});

}

if(response.status == "timeout"){

Swal.fire({
// title: 'Ooops....',
text: 'Login is allowed only between 9 AM and 6 PM IST.',
icon: 'error',
confirmButtonText: 'OK'
}).then((result) => {
if (result.isConfirmed) {
	window.location.reload();
}
});

}

if(response.status == "not"){

Swal.fire({
// title: 'Ooops....',
text: 'Email not registered!',
icon: 'error',
confirmButtonText: 'OK'
}).then((result) => {
if (result.isConfirmed) {
	window.location.reload();
}
});

}

            },

            error: function(xhr, status, error) {

console.error(xhr.responseText);

Swal.fire({
    title: 'Error!',
    text: 'There was a problem with your login.',
    icon: 'error',
    confirmButtonText: 'OK'
});
}

        });

    });

});

</script>

</html>

{{-- <!DOCTYPE html>
<html lang="en">
@php
$setting = DB::table('settings')->select('*')->first();
@endphp

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@isset($setting->company_title) {{$setting->company_title}} @endisset</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

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
</head>

<body>

<style>
        .logo img {
        max-height: 60px;
      
    }
    </style>

    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="{{asset('public/assets/uploads/logo/1719429761.jpg')}}">
                                  
                                </a>
                            </div>

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                        <p class="text-center small">Enter your username & password to login</p>
                                    </div>
                                    @if(Session::has('faild'))
                                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                                        {{Session::get('faild')}}
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif
                                    <form class="row g-3 needs-validation" method="post" action="{{url('manager/login')}}">
                                        @csrf
                                        <div class="col-12">
                                            <label class="form-label">Email</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="email" name="email" class="form-control">
                                            </div>
                                            <div class="text-danger">@error('email') {{$message}} @enderror</div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control">
                                            <div class="text-danger">@error('password') {{$message}} @enderror</div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                                <label class="form-check-label" for="rememberMe">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                     
                                    </form>

                                </div>
                            </div>

                            <div class="credits">
                            <a href="https://tewaribrothers.shop/crm/admin/login" class="text-decoration-underline p-1" href="">Admin</a>
                            <a href="https://tewaribrothers.shop/crm/manager/login"  class="text-decoration-underline p-1" href="">Manager</a>
                            <a href="https://tewaribrothers.shop/crm/manager/login"  class="text-decoration-underline p-1" href="">ZSM</a>
                            <a href="https://tewaribrothers.shop/crm/employeeLogin"  class="text-decoration-underline p-1" href="">DM Login</a>
                            </div>


                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script src="{{asset('public/assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/assets/vendor/chart.js/chart.umd.js')}}"></script>
    <script src="{{asset('public/assets/vendor/echarts/echarts.min.js')}}"></script>
    <script src="{{asset('public/assets/vendor/quill/quill.min.js')}}"></script>
    <script src="{{asset('public/assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
    <script src="{{asset('public/assets/vendor/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('public/assets/vendor/php-email-form/validate.js')}}"></script>

    <script src="{{asset('public/assets/js/main.js')}}"></script>

</body>

</html> --}}
