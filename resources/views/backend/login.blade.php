
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animated Login Form</title>
    <link href="{{asset('public/assets/img/favicon.png')}}" rel="icon">
    <link href="{{asset('public/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
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
    <link rel="stylesheet" href="style.css">

    
<style>

    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }
    
    body{
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: url('https://i.postimg.cc/XYjWrv36/dark-hexagonal-background-with-gradient-color_79603-1409.jpg') no-repeat;
        background-size: cover;
        background-position: center;
    }
    
    .box{
        position: relative;
        width: 370px;
        height: 450px;
        background: #1c1c1c;
        border-radius: 50px 5px;
        overflow: hidden;
    }
    
    .box::before{
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 370px;
        height: 450px;
        background: linear-gradient(60deg, transparent, #45f3ff, #45f3ff);
        transform-origin: bottom right;
        animation: animate 6s linear infinite;
    }
    
    .box::after{
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 370px;
        height: 450px;
        background: linear-gradient(60deg, transparent, #d9138a, #d9138a);
        transform-origin: bottom right;
        animation: animate 6s linear infinite;
        animation-delay: -3s;
    }
    
    @keyframes animate{
        0% { transform: rotate(0deg);}
        100% { transform: rotate(360deg);}
    }
    
    form{
        position: absolute;
        inset: 2px;
        border-radius: 50px 5px;
        background: #28292d;
        z-index: 10;
        padding: 30px 30px;
        display: flex;
        flex-direction: column;
    }
    
    h2{
        color: #45f3ff;
        font-size: 35px;
        font-weight: 500;
        text-align: center;
    }
    
    .input-box{
        position: relative;
        width: 300px;
        margin-top: 35px;
    }
    
    .input-box input{
        position: relative;
        width: 100%;
        padding: 20px 10px 10px;
        background: transparent;
        border: none;
        outline: none;
        color: #23242a;
        font-size: 1em;
        letter-spacing: .05em;
        z-index: 10;
    }
    
    input[type="submit"]{
        font-size: 20px;
        border: none;
        outline: none;
        background: #45f3ff;
        padding: 5px;
        margin-top: 40px;
        border-radius: 90px;
        font-weight: 600;
        cursor: pointer;
    }
    
    input[type="submit"]:active{
        background: linear-gradient(90deg, #45f3ff, #d9138a);
        opacity: .8;
    }
    
    .input-box span{
        position: absolute;
        left: 0;
        padding: 20px 10px 10px;
        font-size: 1em;
        color: #8f8f8f;
        pointer-events: none;
        letter-spacing: .05em;
        transition: .5s;
    }
    
    .input-box input:valid ~ span,
    .input-box input:focus ~ span{
        color: #45f3ff;
        transform: translateX(-10px) translateY(-30px);
        font-size: .75em;
    }
    
    .input-box i{
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 2px;
        background: rgb(69, 243, 255);
        border-radius: 4px;
        transition: .5s;
        pointer-events: none;
        z-index: 9;
    }
    
    .input-box input:valid ~ i,
    .input-box input:focus ~ i{
        height: 44px;
        background: rgba(69, 243, 255, .5);
    }
    
    .links{
        display: flex;
        justify-content: space-between;
    }
    
    .links a{
        margin: 25px 0;
        font-size: 1em;
        color: #8f8f8f;
        text-decoration: none;
    }
    
    .links a:hover,
    .links a:nth-child(2){
        color: #45f3ff;
    }
    
    .links a:nth-child(2):hover{
        color: #d9138a;
    }
    
    </style>


</head>
<body>

    {{-- @if(Session::has('success'))
    <div class="alert alert-success bg-danger text-light border-0 alert-dismissible fade show" role="alert">
        {{Session::get('success')}}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if(Session::has('faild'))
    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
        {{Session::get('faild')}}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif --}}


    <div class="box">
        <form method="POST" id="loginpage" action="{{url('admin/login')}}">
            @csrf
            <div class="input-box">
                <h2>Sign In</h2>
                <input type="email" name="email" required>
                <span>Email</span>
                <div class="text-danger">@error('email') {{$message}} @enderror</div>
                <i></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" required>
                <span>Enter Password</span>
                <div class="text-danger">@error('password') {{$message}} @enderror</div>
                <i></i>
            </div>
            <input type="submit" value="Login">
            {{-- <div class="links">
                <a href="#">Forgot Password?</a>
                <a href="#">Sign Up</a>
            </div> --}}
        </form>
    </div>
</body>

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

            url : "{{route('userlogin')}}",
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
    window.location.href = "{{url('admin/home')}}";
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

    <title>CRM</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{asset('public/assets/img/favicon.png')}}" rel="icon">
    <link href="{{asset('public/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
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
        /* margin-right: 100px; */
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
                                    <!-- <span class="d-none d-lg-block">CRM ADMIN</span> -->
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                        <p class="text-center small">Enter your username & password to login</p>
                                    </div>
                                    @if(Session::has('success'))
                                    <div class="alert alert-success bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                                        {{Session::get('success')}}
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif
                                    @if(Session::has('faild'))
                                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                                        {{Session::get('faild')}}
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif
                                    <form class="row g-3 needs-validation" method="post" action="{{url('admin/login')}}">
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
                                            <p class="small mb-0"> <a href="">Forget Password</a></p>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                        <div class="col-12">
                                            <!--<p class="small mb-0">Don't have account? <a href="{{url('admin/signup')}}">Create an account</a></p>-->
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

</body>

</html> --}}
