@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-pencil-square"></i> Edit Service</h1>
        </div>
        <div class="col-lg-2">
            <nav>
                <ol class="breadcrumb">
                    <!-- <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{url('admin/services')}}">View Services</a></li> -->
                    <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{url('admin/services')}}"><i class="bi bi-arrow-left"></i> Back</a></li>
                </ol>
            </nav>
        </div>
    </div>
</div><!-- End Page Title -->

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

                    <form method="post" action="{{url('admin/edit-service')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$editservics->id}}">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Service Name <span class="text-danger">*</span></label>
                                    <input type="text" name="service_name" class="form-control" value="{{$editservics->service_name}}">
                                    <span class="text-danger">@error('service_name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Service Price <span class="text-danger">*</span></label>
                                    <input type="text" name="service_price" class="form-control" value="{{$editservics->service_price}}">
                                    <span class="text-danger">@error('service_price') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Company <span class="text-danger">*</span></label>
                                    <input type="text" name="company" class="form-control" value="{{$editservics->company}}">
                                    <span class="text-danger">@error('company') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option>Select Status</option>
                                        <option @if(isset($editservics->status) && $editservics->status==0) {{'selected'}} @endif value="0">Active</option>
                                        <option @if(isset($editservics->status) && $editservics->status==1) {{'selected'}} @endif value="1">In active</option>
                                    </select>
                                    <span class="text-danger">@error('status') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group m-2">
                                    <label>Description </label>
                                    <textarea type="text" name="description" class="form-control">{{$editservics->description}}</textarea>
                                    <span class="text-danger">@error('description') {{$message}} @enderror</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Update Service</button>
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