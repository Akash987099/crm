@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1><i class="bi bi-gear"></i> Site Settings</h1>
        </div>

    </div>
</div><!-- End Page Title -->
@php
$users = DB::table('settings')->where('company_id',Session::get('company_id'))->first();
$admin_id = Crypt::encryptString(Session::get('company_id'));
@endphp
<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body pb-0 m-4">
                    <span class="card-title">Settings Information </span>
                    @if(Session::has('success'))
                    <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                        {{Session::get('success')}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form method="post" action="{{url('admin/setting')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group m-2">
                                    <label>Company Name <span class="text-danger">*</span></label>
                                    <input type="text" name="company_name" class="form-control" value="{{$users->company_name ?? '' }}">
                                    <input type="hidden" name="setting_id" value="{{$admin_id}}"> <span class="text-danger">@error('company_name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group m-2">
                                    <label>Company Title <span class="text-danger">*</span></label>
                                    <input type="text" name="company_title" class="form-control" value="@if(isset($users->company_title)) {{$users->company_title}} @else {{''}} @endif">
                                    <span class="text-danger">@error('company_title') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group m-2">
                                    <label>Company Website <span class="text-danger">*</span></label>
                                    <input type="text" name="company_website" class="form-control" value="@if(isset($users->company_website)) {{$users->company_website}} @else {{''}} @endif">
                                    <span class="text-danger">@error('company_website') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group m-2">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control" value="@if(isset($users->address)) {{$users->address}} @else {{''}} @endif">
                                    <span class="text-danger">@error('address') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group m-2">
                                    <label>Country <span class="text-danger">*</span></label>
                                    <input type="text" name="country" class="form-control" value="@if(isset($users->country)) {{$users->country}} @else {{''}} @endif">
                                    <span class="text-danger">@error('country') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group m-2">
                                    <label>State <span class="text-danger">*</span></label>
                                    <input type="text" name="state" class="form-control" value="@if(isset($users->state)) {{$users->state}} @else {{''}} @endif">
                                    <span class="text-danger">@error('state') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group m-2">
                                    <label>City <span class="text-danger">*</span></label>
                                    <input type="text" name="city" class="form-control" value="@if(isset($users->city)) {{$users->city}}@else {{''}} @endif">
                                    <span class="text-danger">@error('city') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group m-2">
                                    <label>Zipcode <span class="text-danger">*</span></label>
                                    <input type="text" name="zipcode" class="form-control" value="@if(isset($users->zipcode)) {{$users->zipcode}} @else {{''}} @endif">
                                    <span class="text-danger">@error('zipcode') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group m-2">
                                    <label>Telephone <span class="text-danger">*</span></label>
                                    <input type="text" name="telephone" class="form-control" value="@if(isset($users->telephone)) {{$users->telephone}} @else {{''}} @endif">
                                    <span class="text-danger">@error('telephone') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group m-2">
                                    <label>Site Logo <span class="text-danger">*</span></label>
                                    <input type="file" name="site_logo" class="form-control">
                                    <span class="text-danger">@error('site_logo') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group m-2">

                                    @if(isset($users->site_logo) && $users->site_logo!="")
                                    <img src="{{asset('public/assets/uploads/logo/'.$users->site_logo)}}" class="img-responsive" style="width:100px;">
                                    @else
                                    <img src="{{asset('public/assets/img/profile-img.jpg')}}" class="rounded-circle">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Update Setting</button>
                            </div>
                        </div>
                </div>

                </form>
            </div>

        </div>
    </div>
    </div>
</section>

@endsection

@push('footer-script')

@endpush