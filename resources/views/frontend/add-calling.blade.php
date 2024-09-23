@extends('frontend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-plus-circle-fill"></i> Add Call/Phone Number</h1>
        </div>
        <div class="col-lg-2">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{url('/call-list')}}">
                            <i class="bi bi-card-list"></i> Call List
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

                    <form method="post" action="{{url('calling-data')}}">
                        @csrf
                        <div class="row">

                            <div class="col-lg-4">
                                <div class="form-group m-2">
                                    <label> Phone/Mobile<span class="text-danger">*</span></label>
                                    <input type="text" name="mobile" class="form-control" value="{{old('mobile')}}" placeholder="+91">
                                    <span class="text-danger">@error('mobile') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group m-2">
                                    <label> Client Name</label>
                                    <input type="text" name="client_name" class="form-control" value="{{old('client_name')}}" placeholder="client name">
                                    <span class="text-danger">@error('client_name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group m-2">
                                    <label> Status</label>
                                    <select class="form-select" name="status">
                                        <option value="0">Interested</option>
                                        <option value="1">Not Interested</option>
                                    </select>
                                    <span class="text-danger">@error('status') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group m-2">
                                    <label>Remark <span class="text-danger">*</span></label>
                                    <textarea name="remark" class="form-control">{{old('remark')}}</textarea>
                                    <span class="text-danger">@error('remark') {{$message}} @enderror</span>
                                </div>
                            </div>


                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Save</button>
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