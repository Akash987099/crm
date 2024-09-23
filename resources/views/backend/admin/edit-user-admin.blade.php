@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-pencil-square"></i> Edit Admin</h1>
        </div>
        <div class="col-lg-2">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{url('admin/user-admin')}}">
                            <i class="bi bi-card-list"></i> View Admin
                        </a>
                    </li>

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

                    <form method="post" action="{{url('admin/edit-admin-data')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label> Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{$edit_admin->name}}" placeholder="name">
                                    <input type="hidden" name="admin_id" class="form-control" value="{{Crypt::encrypt($edit_admin->id)}}" placeholder="name">
                                    <span class="text-danger">@error('name') {{$message}} @enderror</span>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="text" name="email" class="form-control" value="{{$edit_admin->email}}" placeholder="@gmail.com">
                                    <span class="text-danger">@error('email') {{$message}} @enderror</span>
                                </div>
                            </div>




                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Password </label>
                                    <input type="password" name="password" class="form-control" placeholder="Enter password">
                                    <span class="text-danger">@error('password') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Confirm Password </label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Phone </label>
                                    <input type="number" name="phone" class="form-control" value="{{$edit_admin->phone}}" placeholder="+91">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Address </label>
                                    <input type="text" name="address" class="form-control" value="{{$edit_admin->address}}" placeholder="address">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Country </label>
                                    <select name="country" class="form-control">
                                        <option value="">Select Country</option>
                                        @if(isset($country) && !empty($country))
                                        @foreach($country as $key=>$row)
                                        <option @if(isset($edit_admin->country) && $edit_admin->country==$key) {{'selected'}} @endif value="{{$key}}">{{$row}}</option>
                                        @endforeach
                                        @endif
                                    </select>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Image Upload</label>
                                    <input type="file" name="profile_pic" class="form-control" value="{{old('profile_pic')}}">

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">

                                    @if(isset($edit_admin->profile_pic) && $edit_admin->profile_pic!="")
                                    <img src="{{asset('assets/uploads/users/'.$edit_admin->profile_pic)}}" class="rounded-circle" style="width:60px;">
                                    @else
                                    <img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle" style="width:60px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Update Admin</button>
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