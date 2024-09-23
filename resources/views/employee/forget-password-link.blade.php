
<!DOCTYPE html>
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

    

<style>

    body {
        font-family: Arial, sans-serif;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        /* Set the background image */
        background: url("../public/assets/images/exterior.jpeg") center/cover fixed;;
    }
    
    
            .container {
    
               
    
                padding: 20px;
    
                border-radius: 8px;
    
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    
                width: 100%;
    
                /* max-width: 400px; */
    
            }
    
            h2 {
    
                margin-bottom: 20px;
    
            }
    
            label {
    
                display: block;
    
                margin-bottom: 5px;
    
                font-weight: bold;
    
            }
    
            input[type="text"],
    
            input[type="email"],
    
            input[type="password"] {
    
                width: 100%;
    
                padding: 8px;
    
                margin-bottom: 15px;
    
                border: 1px solid #ccc;
    
                border-radius: 4px;
    
            }
    
            button[type="submit"] {
    
                background-color: #000;
    
      color: #ffffff;
    
      border: none;
    
      padding: 10px 20px;
    
      border-radius: 4px;
    
      cursor: pointer;
    
      margin: 0 auto;
    
      display: block;
    
            }
    
            button[type="submit"]:hover {
    
                background-color: #0056b3;
    
            }
    
            i {
    
                color:#09ddc9a3;
    
            }
    
        </style>
    

    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-md-12 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center ">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="{{asset('public/assets/uploads/logo/1719429761.jpg')}}">
                                    {{-- <span class="d-none d-lg-block">Employee</span> --}}
                                </a>
                            </div><!-- End Logo -->

                          

                                    <div class="">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                        <p class="text-center small">Enter your username & password to login</p>
                                    </div>
                                    @if(Session::has('success'))
                                    <div class="alert alert-success bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                                        {{Session::get('success')}}
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif
                                    @if(Session::has('failed'))
                                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                                        {{Session::get('failed')}}
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif

                                    <form action="{{ route('ResetPasswordPost') }}" method="POST">

                                        @csrf
              
                                        <input type="hidden" name="token" value="{{ $token }}">
              
                
                                       
              
              
                                        <div class="form-group col-12">
              
                                            <label for="email_address" class="">E-Mail Address</label>
                                                <input type="text" id="email_address" class="form-control" name="email" required autofocus>
              
                                                @if ($errors->has('email'))
              
                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
              
                                                @endif
              
                                         
              
                                        </div>
                                        
              
                
              
                                        <div class="form-group col-12">
              
                                            <label for="password" class="">Password</label>
              
                                                <input type="password" id="password" class="form-control" name="password" required autofocus>
              
                                                @if ($errors->has('password'))
              
                                                    <span class="text-danger">{{ $errors->first('password') }}</span>
              
                                                @endif
              
              
                                        </div>
              
                
              
                                        <div class="form-group col-12">
              
                                            <label for="password-confirm" class="">Confirm Password</label>
              
                                                <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>
              
                                                @if ($errors->has('password_confirmation'))
              
                                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
              
                                                @endif
              
              
                                        </div>
              
                
              
                                        <div class="col-md-2 offset-md-4">
              
                                            <button type="submit" class="btn btn-primary btn-sm">
              
                                                Save
              
                                            </button>
              
                                        </div>
              
                                    </form>
                                  

                               <br>
                            <div class="credits">
                                Powered by <a target="_blank" href="">Awc</a>
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

</html>