@extends('frontend.layout.master')

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
        <div class="col-xl-12">

            <div class="card">
                <div class="card-body pt-2">
                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <h5 class="card-title">Profile Details</h5>
                            @if(Session::has('success'))
                            <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                                {{Session::get('success')}}
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                            <form method="post" action="{{url('profile-update')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>First Name <span class="text-danger">*</span></label>
                                            <input type="text" name="firstname" class="form-control" value="{{$profile->firstname}}" placeholder="Enter first name">
                                            <input type="hidden" name="teleuser_id" value="{{Crypt::encrypt($profile->id)}}">
                                            <span class="text-danger">@error('firstname') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" name="lastname" class="form-control" value="{{$profile->lastname}}" placeholder="Enter last name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pt-3">
                                        <div class="form-group">
                                            <label>Phone <span class="text-danger">*</span></label>
                                            <input type="number" name="phone" class="form-control" value="{{$profile->phone}}" placeholder="Enter phone number">
                                            <span class="text-danger">@error('phone') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pt-3">
                                        <div class="form-group">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control" value="{{$profile->email}}" placeholder="Enter email address" disabled="disabled">

                                        </div>
                                    </div>
                                    <div class="col-lg-6 pt-3">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" name="city" class="form-control" value="{{$profile->city}}" placeholder="Enter city">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pt-3">
                                        <div class="form-group">
                                            <label>State</label>
                                            <input type="text" name="state" class="form-control" value="{{$profile->state}}" placeholder="Enter state">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pt-3">
                                        <div class="form-group">
                                            <label>Pincode</label>
                                            <input type="text" name="pincode" class="form-control" value="{{$profile->pincode}}" placeholder="Enter pincode">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pt-3">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control" value="{{$profile->address}}" placeholder="Enter address">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pt-3">
                                        <div class="form-group">
                                            <label>User Profile</label>
                                            <input type="file" name="document_file" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pt-3">
                                        <div class="form-group">
                                            @if($profile->document_file && $profile->document_file!="")
                                            <img class="img-responsive" src="{{asset('assets/uploads/telemarketing/'.$profile->document_file)}}" style="width:80px;">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 pt-3">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Save Change</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <!-- <div class="col-xl-4">
            <div class="card">
                <div class="card-body pt-2">
                    <h5 class="card-title">Change Password</h5>
                    @if(Session::has('password'))
                    <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                        {{Session::get('password')}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <form method="post" action="{{url('tele-pass-update')}}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Password <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="password" name="password" class="form-control" placeholder="Password">
                                <input type="hidden" name="pass_id" value="{{Crypt::encrypt($profile->id)}}">
                            </div>
                            <span class="text-danger">@error('password') {{$message}} @enderror</span>
                        </div>
                        <div class="form-group row pt-3">
                            <label class="col-sm-4 col-form-label">Confirm Password <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="confirm password">
                            </div>
                            <span class="text-danger">@error('password_confirmation') {{$message}} @enderror</span>
                        </div>
                        <div class="form-group row pt-1">
                            <label class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-8">
                                <button class="btn btn-primary" type="submit"> Save Change</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div> -->
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
            // console.log(form_data);
            $.ajax({
                url: "{{url('admin/profile')}}",
                method: 'POST',
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    if (response.error == false) {
                        $(".bg-danger").show();
                        $(".message").html(response.message);
                    } else {
                        $(".bg-success").show();
                        $(".success").html(response.success);
                    }

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
                url: "{{url('admin/change-pass')}}",
                method: 'POST',
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    // console.log(response);
                    if (response.error == false) {
                        $(".bg-danger").show();
                        $(".message").html(response.message);
                    } else {
                        $(".bg-success").show();
                        $(".success").html(response.success);
                    }

                }
            });

        });
        //////////////////////////END PASSWORD CHANGE ////////////////////////////////////////////

    });
</script>
@endpush