@extends('managerend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1><i class="bi bi-plus-circle-fill"></i> Add Telemarketing Team</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{url('manager/view-tele-team')}}"><i class="bi bi-list"></i> View User</a></li>
                    <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{url('manager/archive-mtele-team')}}"><i class="bi bi-archive"></i> Archive User</a></li>
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

                    <form method="post" action="{{url('manager/madd-tele-team')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="firstname" class="form-control" value="{{old('firstname')}}" placeholder="first name">
                                    <span class="text-danger">@error('firstname') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Last Name </label>
                                    <input type="text" name="lastname" class="form-control" value="{{old('lastname')}}" placeholder="last name">
                                    <span class="text-danger">@error('lastname') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Staff Id <span class="text-danger">*</span></label>
                                    <input type="text" name="staff_id" class="form-control" value="{{'#'.time()}}" placeholder="Staff id">
                                    <span class="text-danger">@error('staff_id') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Staff Designation <span class="text-danger">*</span></label>
                                    <input type="text" name="staff_role" class="form-control" value="{{old('staff_role')}}" placeholder="designation">
                                    <span class="text-danger">@error('staff_role') {{$message}} @enderror</span>
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
                                    <label>Phone <span class="text-danger">*</span></label>
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
                                    <label>Address <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control" value="{{old('address')}}" placeholder="address">
                                    <span class="text-danger">@error('address') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>City <span class="text-danger">*</span></label>
                                    <input type="text" name="city" class="form-control" value="{{old('city')}}" placeholder="city">
                                    <span class="text-danger">@error('city') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Picode <span class="text-danger">*</span></label>
                                    <input type="text" name="pincode" class="form-control" value="{{old('pincode')}}" placeholder="pincode">
                                    <span class="text-danger">@error('pincode') {{$message}} @enderror</span>
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
                                    <label>State <span class="text-danger">*</span></label>
                                    <input type="text" name="state" class="form-control" value="{{old('state')}}" placeholder="state">
                                    <span class="text-danger">@error('state') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Upload Document </label>
                                    <input type="file" name="document_file" class="form-control" value="{{old('document_file')}}">
                                    <span class="text-danger">@error('document_file') {{$message}} @enderror</span>
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