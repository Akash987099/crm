@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-pencil-square"></i> Edit/Phone Number</h1>
        </div>
        <div class="col-lg-2">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{url('admin/calling-list')}}">
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
                    <form method="post" action="{{url('admin/edit-call')}}">
                        @csrf
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label> Phone/Mobile<span class="text-danger">*</span></label>
                                    <input type="text" name="mobile" class="form-control" value="{{$edit_call->mobile}}" placeholder="+91">
                                    <input type="hidden" name="caleid" value="{{Crypt::encrypt($edit_call->id)}}">
                                    <span class="text-danger">@error('mobile') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label> Client Name</label>
                                    <input type="text" name="client_name" class="form-control" value="{{$edit_call->client_name}}" placeholder="client name">
                                    <span class="text-danger">@error('client_name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Remark <span class="text-danger">*</span></label>
                                    <textarea name="remark" class="form-control">{{$edit_call->remark}}</textarea>
                                    <span class="text-danger">@error('remark') {{$message}} @enderror</span>
                                </div>
                            </div>


                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-arrow-repeat"></i> Update</button> <button type="submit" class="btn btn-danger">Cancel</button>
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