<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>CRM</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{asset('public/assets/img/awc-logo.png')}}" rel="icon">
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
    

    <section class="h-100 gradient-form" style="background-color: #5F9EA0;">
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-4">
              <div class="card rounded-3 text-black">
                <div class="row g-0">
                  <div class="col-lg-12">
                    <div class="card-body p-md-5 mx-md-4">

                      <div class="text-center">
                        <img src="{{asset('public/assets/uploads/logo/1719429761.jpg')}}"
                          style="width: 185px;" alt="logo">
                        {{-- <h4 class="mt-1 mb-5 pb-1">Arya web coding</h4> --}}
                      </div>
                      @if(Session::has('faild'))
                      <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                          {{Session::get('faild')}}
                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                      @endif
                      {{-- <div class="col-12">
                        <label class="form-label">Choose Member</label>
                        <select id="memberSelection" class="form-control">
                            <option value="">Choose member</option>
                            <option value="1">Telemarketing</option>
                            <option value="2">Marketing</option>
                            <option value="3">Bde</option>
                            <option value="4">Manager/Hr</option>
                        </select>
                    </div> --}}
                    <br>

                    

                    <div id="telemarketing">
                        <form class="row g-3 needs-validation" method="post" action="{{route('TeleUserLogin')}}">
                          @csrf
  
                          <div class="col-12">
                              <label class="form-label">Email</label>
                              <div class="input-group has-validation">
                                  <span class="input-group-text" id="inputGroupPrepend">@</span>
                                  <input type="email" name="email" class="form-control" placeholder="tele@gmail.com">
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
                          <!-- <div class="col-12">
                              <p class="small mb-0">Don't have account? <a href="">Create an account</a></p>
                          </div> -->
                      </form>
                  </div>

                    



                    </div>
                  </div>
                 
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <style>
.gradient-custom-2 {
/* fallback for old browsers */
background: #fccb90;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
}

@media (min-width: 768px) {
.gradient-form {
height: 100vh !important;
}
}
@media (min-width: 769px) {
.gradient-custom-2 {
border-top-right-radius: .3rem;
border-bottom-right-radius: .3rem;
}
}
      </style>


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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#telemarketing').show();
    $('#marketing').hide();
    $('#bde').hide();
    $('#manager').hide();

    // Add change event listener to the dropdown
    $('#memberSelection').change(function(){
        var selectedOption = $(this).val();

        // Hide all forms
        $('#telemarketing').hide();
        $('#marketing').hide();
        $('#bde').hide();
        $('#manager').hide();

        // Show the selected form based on the dropdown value
        if(selectedOption === '1') {
            $('#telemarketing').show();
        } else if(selectedOption === '2') {
            $('#marketing').show();
        } else if(selectedOption === '3') {
            $('#bde').show();
        } else if(selectedOption === '4') {
            $('#manager').show();
        }
    });
});
</script>

</body>

</html>
