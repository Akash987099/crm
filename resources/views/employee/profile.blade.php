
@extends('employee.master')

@section('content')

<div class="pagetitle">
    <h1>Profile</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Users</li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section profile">
    <div class="row">
        <div class="col-xl-4">

            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    
                    <img src="{{asset('assets/img/profile-img.jpg')}}" alt="Profile" class="rounded-circle">
                    <h2>{{Auth::guard('employee')->user()->firstname}}&nbsp;{{Auth::guard('employee')->user()->lastname}}</h2>
                    <h3>{{$empDesignation->Designation ?? '-'}}</h3>
                    <div class="social-links mt-2">
                        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xl-8">

            <div class="card">
                <div class="card-body pt-3">
                    <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert" style="display: none;">
                        <span class="success"></span>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert" style="display: none;">
                        <span class="message"></span>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <ul class="nav nav-tabs nav-tabs-bordered">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                        </li>

                        <!-- <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                        </li> -->

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview" id="profile-overview">

                            <h5 class="card-title">Profile Details</h5>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                <div class="col-lg-9 col-md-8">{{Auth::guard('employee')->user()->firstname}}&nbsp;{{Auth::guard('employee')->user()->lastname}}</div>
                            </div>



                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">desiganation</div>
                                <div class="col-lg-9 col-md-8">{{$empDesignation->Designation ?? '-'}}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Country</div>
                                <div class="col-lg-9 col-md-8">India</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Address</div>
                                <div class="col-lg-9 col-md-8">{{Auth::guard('employee')->user()->address}}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Phone</div>
                                <div class="col-lg-9 col-md-8">{{Auth::guard('employee')->user()->phone}}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8">{{Auth::guard('employee')->user()->email}}</div>
                            </div>

                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                            <!-- Profile Edit Form -->
                            <form id="profile_update" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input type="file" class="form-control" name="profile_pic">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">First Name <span class="text-danger">*</span></label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="firstname" type="text" class="form-control" id="fullName" value="{{Auth::guard('employee')->user()->firstname}}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Last Name <span class="text-danger">*</span></label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="lastname" type="text" class="form-control" id="fullName" value="{{Auth::guard('employee')->user()->lastname}}">
                                    </div>
                                </div>


                                {{-- <div class="row mb-3">
                                    <label for="desiganation" class="col-md-4 col-lg-3 col-form-label">desiganation <span class="text-danger">*</span></label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="desiganation" type="text" class="form-control" id="desiganation" value="">
                                    </div>
                                </div> --}}

                                {{-- <div class="row mb-3">
                                    <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country <span class="text-danger">*</span></label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="country" type="text" class="form-control" id="Country" value="">
                                    </div>
                                </div> --}}

                                <div class="row mb-3">
                                    <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address <span class="text-danger">*</span></label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="address" type="text" class="form-control" id="Address" value="{{Auth::guard('employee')->user()->address}}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-md-4 col-lg-3 col-form-label">Phone <span class="text-danger">*</span></label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="phone" type="text" class="form-control" value="{{Auth::guard('employee')->user()->phone}}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email </label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="email" class="form-control" id="Email" value="{{Auth::guard('employee')->user()->email}}" disabled="disabled">
                                    </div>
                                </div>

                                {{-- <div class="row mb-3">
                                    <label class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="twitter" type="text" class="form-control" value=" ">
                                    </div>
                                </div> --}}
                                {{-- <div class="row mb-3">
                                    <label class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="facebook" type="text" class="form-control" value="">
                                    </div>
                                </div> --}}

                                {{-- <div class="row mb-3">
                                    <label class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="instagram" type="text" class="form-control" value="">
                                    </div>
                                </div> --}}

                                {{-- <div class="row mb-3">
                                    <label class="col-md-4 col-lg-3 col-form-label">Linkedin Profile</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="linkedin" type="text" class="form-control" value="">
                                    </div>
                                </div> --}}

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>

                        </div>

                        <div class="tab-pane fade pt-3" id="profile-settings">

                            <!-- Settings Form -->
                            <form>

                                <div class="row mb-3">
                                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                                    <div class="col-md-8 col-lg-9">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="changesMade" checked>
                                            <label class="form-check-label" for="changesMade">
                                                Changes made to your account
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="newProducts" checked>
                                            <label class="form-check-label" for="newProducts">
                                                Information on new products and services
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="proOffers">
                                            <label class="form-check-label" for="proOffers">
                                                Marketing and promo offers
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                                            <label class="form-check-label" for="securityNotify">
                                                Security alerts
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form><!-- End settings Form -->

                        </div>

                        <div class="tab-pane fade pt-3" id="profile-change-password">
                            <!-- Change Password Form -->
                            <form id="password_change" method="post">
                                @csrf
                                {{-- <div class="row mb-3">
                                    <label class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="old_password" type="password" class="form-control">
                                    </div>
                                </div> --}}

                                <div class="row mb-3">
                                    <label class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="newpassword" type="text" class="form-control">
                                        <span id="newpassword_error"></span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="confirmpassword" type="text" class="form-control">
                                        <span id="confirmpassword_error"></span>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</section>


@endsection

@push('footer-script')
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        //////////////////////PROFILE UPDATE//////////////////////////////////////////////
        $("#profile_update").submit(function(e) {
            e.preventDefault();
            let form_data = new FormData(this);

            $.ajax({
                url: "{{route('Eprofile-update')}}",
                method: 'POST',
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.status == 'error') {
                        $(".bg-danger").show();
                        $(".message").html('thre waas a problem');
                    } else {
                       
                        $(".bg-success").show();
                        $(".success").html('Success Update Profile');

                    }
                    window.setTimeout(function() {
                        location.reload();
                    }, 3000);
                }
            });

        });

        /////////////////////////END PROFILE UPDATE///////////////////////////////////////


        //////////////////////////PASSWORD CHANGE ////////////////////////////////////////////
        $("#password_change").submit(function(e) {
            e.preventDefault();
            // alert('hello');
            let form_data = new FormData(this);
            // console.log(form_data);
            $.ajax({
                url: "{{route('userChangepass')}}",
                method: 'POST',
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    // console.log(response);
                    if(response.status == "success"){

Swal.fire({
icon: 'success',
title: 'Success!',
text: 'Password Change Successfully.',
customClass: {
popup: 'custom-swal-width-height',
title: 'custom-swal-title',
htmlContainer: 'custom-swal-text',
icon: 'custom-swal-icon'
}
}).then(function(result) {
if (result.isConfirmed) {
    window.location.reload();
}
});

}

else if (response.status == 'error') {
//   $('.loader-container').show();
console.log(response);
$.each(response.message, function(field, message) {
$('#' + field).addClass('is-invalid');
$('#' + field + '_error').text(message).addClass('text-danger');
}); 
}


                }
            });

        });
        //////////////////////////END PASSWORD CHANGE ////////////////////////////////////////////

    });
</script>
@endpush