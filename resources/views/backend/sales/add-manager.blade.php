@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-8">
            <h1><i class="bi bi-plus-circle-fill"></i> Manager/HR</h1>
        </div>
        <div class="col-lg-4">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{url('admin/manager')}}"><i class="bi bi-list"></i> View Manager/HR</a></li>
                    <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{url('admin/archive-manager')}}"><i class="bi bi-archive"></i> Archive Manager/HR</a></li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body pb-0 m-4">
                    @if(Session::has('success'))
                    <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                        {{Session::get('success')}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form method="post" action="{{url('admin/add-manager')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label> Name (Manager)<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="name">
                                    <span class="text-danger">@error('name') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Emp Id <span class="text-danger">*</span></label>
                                    <input type="text" name="staff_id" class="form-control" value="{{'#'.time()}}" placeholder="">
                                    <span class="text-danger">@error('staff_id') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Company Name <span class="text-danger">*</span></label>
                                    <input type="text" name="company_name" class="form-control" value="" placeholder="">
                                    <span class="text-danger">@error('company_name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>EMPLOYMENT TYPE <span class="text-danger">*</span></label>
                                    <input type="text" name="employment_type" class="form-control" value="" placeholder="">
                                    <span class="text-danger">@error('employment_type') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>User Type <span class="text-danger">*</span></label>
                                    {{-- <input type="text" name="employment_type" class="form-control" value="" placeholder="Staff id"> --}}
                                    {{-- <span class="text-danger">@error('employment_type') {{$message}} @enderror</span> --}}

                                    <select name="user_type" id="" class="form-control">
                                        <option value="1">Mnager</option>
                                        <option value="2">ZSM</option>
                                    </select>
                                    <span class="text-danger">@error('user_type') {{$message}} @enderror</span>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Previous Company <span class="text-danger">*</span></label>
                                    <input type="text" name="previous_company" class="form-control" value="" placeholder="">
                                    <span class="text-danger">@error('previous_company') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Team Leader <span class="text-danger">*</span></label>
                                    <input type="text" name="team_leader" class="form-control" value="" placeholder="">
                                    <span class="text-danger">@error('team_leader') {{$message}} @enderror</span>
                                </div>
                            </div>
                            {{-- <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Pan No. </label>
                                    <input type="text" name="pan_number" class="form-control" value="{{old('pan_number')}}" placeholder="pan_number">
                                    <span class="text-danger">@error('pan_number') {{$message}} @enderror</span>
                                </div>
                            </div> --}}
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Father Name <span class="text-danger">*</span></label>
                                    <input type="text" name="father_name" class="form-control" value="" placeholder="">
                                    <span class="text-danger">@error('father_name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
    <div class="form-group m-2">
        <label>Gender <span class="text-danger">*</span></label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="male" value="male">
            <label class="form-check-label" for="male">Male</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="female" value="female">
            <label class="form-check-label" for="female">Female</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="other" value="other">
            <label class="form-check-label" for="other">Other</label>
        </div>
        <span class="text-danger">@error('gender') {{$message}} @enderror</span>
    </div>
</div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="@gmail.com">
                                    <span class="text-danger">@error('email') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Phone </label>
                                    <input type="text" name="phone" class="form-control" value="{{old('phone')}}" placeholder="91+">
                                    <span class="text-danger">@error('phone') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Date Of Joining <span class="text-danger">*</span></label>
                                    <input type="date" name="joining_date" class="form-control" value="{{old('joining_date')}}">
                                    <span class="text-danger">@error('joining_date') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Address </label>
                                    <input type="text" name="address" class="form-control" value="{{old('address')}}" placeholder="address">
                                    <span class="text-danger">@error('address') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter password">
                                    <span class="text-danger">@error('password') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                                    <span class="text-danger">@error('password_confirmation') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>City </label>
                                    <input type="text" name="city" class="form-control" value="{{old('city')}}" placeholder="city">
                                    <span class="text-danger">@error('city') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>District <span class="text-danger">*</span></label>
                                    <input type="text" name="district" class="form-control" value="{{old('district')}}" placeholder="@gmail.com">
                                    <span class="text-danger">@error('district') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Pincode</label>
                                    <input type="text" name="pincode" class="form-control" value="{{old('pincode')}}" placeholder="pincode">
                                    <span class="text-danger">@error('pincode') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>State </label>
                                    <input type="text" name="state" class="form-control" value="{{old('state')}}" placeholder="state">
                                    <span class="text-danger">@error('state') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Adhar No. </label>
                                    <input type="text" name="adhar_number" class="form-control" value="{{old('adhar_number')}}" placeholder="adhar_number">
                                    <span class="text-danger">@error('adhar_number') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Pan No. </label>
                                    <input type="text" name="pan_number" class="form-control" value="{{old('pan_number')}}" placeholder="pan_number">
                                    <span class="text-danger">@error('pan_number') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Bank Name <span class="text-danger">*</span></label>
                                    <input type="text" name="bank_name" class="form-control" value="" placeholder="Staff id">
                                    <span class="text-danger">@error('bank_name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Bank A/C <span class="text-danger">*</span></label>
                                    <input type="text" name="bank_acc" class="form-control" value="" placeholder="Staff id">
                                    <span class="text-danger">@error('bank_acc') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>IFSC Code <span class="text-danger">*</span></label>
                                    <input type="text" name="ifsc_code" class="form-control" value="" placeholder="Staff id">
                                    <span class="text-danger">@error('ifsc_code') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Upload profile pic </label>
                                    <input type="file" name="profile_pic" class="form-control" value="{{old('profile_pic')}}">
                                    <span class="text-danger">@error('profile_pic') {{$message}} @enderror</span>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

@endsection

@push('footer-script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script>
    $(document).ready(function() {
        $('.select2').select2({
            closeOnSelect: false
        });
    });
</script>
@endpush