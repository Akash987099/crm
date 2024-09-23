@extends('managerend.layout.master')

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
                            <form method="post" action="{{url('manager/m-profile')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{Auth::guard('manager')->user()->name}}" readonly>
                                            <input type="hidden" name="manager_id" value="{{Crypt::encrypt(Auth::guard('manager')->user()->id)}}">
                                            <span class="text-danger">@error('name') {{$message}} @enderror</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Phone <span class="text-danger">*</span></label>
                                            <input type="number" name="phone" class="form-control" value="{{Auth::guard('manager')->user()->phone}}" readonly>
                                            <span class="text-danger">@error('phone') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pt-3">
                                        <div class="form-group">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control" value="{{Auth::guard('manager')->user()->email}}" placeholder="Enter email address" readonly>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 pt-3">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" name="city" class="form-control" value="{{Auth::guard('manager')->user()->city}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pt-3">
                                        <div class="form-group">
                                            <label>State</label>
                                            <input type="text" name="state" class="form-control" value="{{Auth::guard('manager')->user()->state}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pt-3">
                                        <div class="form-group">
                                            <label>Country</label>
                                            <input type="text" name="country" class="form-control" value="{{Auth::guard('manager')->user()->country}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pt-3">
                                        <div class="form-group">
                                            <label>Pincode</label>
                                            <input type="text" name="pincode" class="form-control" value="{{Auth::guard('manager')->user()->pincode}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 pt-3">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control" value="{{Auth::guard('manager')->user()->address}}" readonly>
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-6 pt-3">
                                        <div class="form-group">
                                            <label>User Profile</label>
                                            <input type="file" name="profile_pic" class="form-control">
                                        </div>
                                    </div> -->
                                    <div class="col-lg-6 pt-3">
                                        <div class="form-group">
                                            @if (file_exists(public_path().'/assets/uploads/manager/'.Auth::guard('manager')->user()->profile_pic))
                                            <img src="{{asset('assets/uploads/manager/'.Auth::guard('manager')->user()->profile_pic)}}" style="width:200px;height:220px;">
                                            @else
                                            <img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle" style="width: 100px;">
                                            @endif

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 pt-3">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Profile Update</button>
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

    </div>
</section>


@endsection

@push('footer-script')
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

@endpush