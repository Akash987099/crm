@extends('bdend.layout.master')

@section('content')
<div class="row">
    <div class="col-lg-9">
        <div class="pagetitle">
            <h1><i class="bi bi-pencil-square"></i> Edit Meeting Attend</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Edit Meeting Attend</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-lg-3">
        <nav>
            <ol class="breadcrumb">
                <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{url('bde/view-bde-meeting')}}">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </li>
                <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{url('bde/archive-bde-meeting')}}">
                        <i class="bi bi-archive"></i> Archive Meeting
                    </a>
                </li>
            </ol>
        </nav>
    </div>
</div>
<section class="section profile">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-2">
                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">

                            @if(Session::has('success'))
                            <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                                {{Session::get('success')}}
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                            @if(Session::has('faild'))
                            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                                {{Session::get('faild')}}
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif
                            <div class="msg1"></div>
                            <form method="post" action="{{route('bde.meeting-update',['meditld'=>Crypt::encrypt($edit_meeting->id),'cltid'=>Crypt::encrypt($edit_meeting->clientid)])}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label> Name <span class="text-danger">*</span></label>
                                            <input class="form-control client_id" name="client_name" value="{{$edit_meeting->client_name}}">
                                            <span class="text-danger">@error('client_name') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <input type="text" name="company_name" class="form-control" value="{{$edit_meeting->company_name}}" placeholder="Enter company name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Phone/Mobile <span class="text-danger">*</span></label>
                                            <input type="number" name="phone" class="form-control" value="{{$edit_meeting->phone}}" placeholder="Enter phone number">
                                            <span class="text-danger">@error('phone') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" value="{{$edit_meeting->email}}" placeholder="Enter email">
                                            <span class="text-danger">@error('email') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Category <span class="text-danger">*</span></label>
                                            <input type="text" name="keywords" class="form-control" value="{{$edit_meeting->keywords}}" placeholder="Enter keyword">

                                        </div>
                                    </div>

                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Visiting card <span class="text-danger">*</span></label>
                                            <input type="file" name="visiting_card" accept="image/jpeg,jpg,png" class="form-control">

                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Shop/Front Photo <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" name="shop_img" accept="image/jpeg,jpg,png" capture="camera">

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Tenure</label>
                                            <input type="text" name="tenure" class="form-control" value="{{$edit_meeting->tenure}}" placeholder="Tenure">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Status <span class="text-danger">*</span></label>
                                            <select class="form-control status" name="status">
                                                @php $status=['1'=>'Deal Close','2'=>'Follow Up','3'=>'Reschedule'] @endphp
                                                <option value="0">--select--</option>
                                                @if(!empty($status))
                                                @foreach($status as $key=>$values)
                                                <option {{($edit_meeting->status == $key)?'selected':''}} value="{{$key}}">{{$values}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger">@error('status') {{$message}} @enderror</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 deal_close">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Upload Payment Image</label>
                                            <input type="file" name="amount_pic" accept="image/jpeg,jpg,png" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 followup_date">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Foolow up date</label>
                                            <input type="date" name="followup_date" class="form-control" value="{{$edit_meeting->followup_date}}">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 residual">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Reschedule date</label>
                                            <input type="date" name="residual" class="form-control" value="{{$edit_meeting->residual}}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 pt-3">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control address" placeholder="Enter address">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 pt-3">
                                        <div class="form-group">
                                            <label>Remark</label>
                                            <textarea name="remark" class="form-control">{{$edit_meeting->remark}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Visiting Card</label>
                                            <br>
                                            @if (file_exists(public_path().'/assets/uploads/meeting/visitingCard/'.$edit_meeting->visiting_card))
                                            <img src="{{asset('assets/uploads/meeting/visitingCard/'.$edit_meeting->visiting_card)}}" style="width:200px; height:220px;">
                                            @else
                                            <img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle" style="width:60px;">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Shop/Image</label>
                                            <br>
                                            @if (file_exists(public_path().'/assets/uploads/meeting/shopImage/'.$edit_meeting->shop_img))
                                            <img src="{{asset('assets/uploads/meeting/shopImage/'.$edit_meeting->shop_img)}}" style="width:200px; height:220px;">
                                            @else
                                            <img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle" style="width:60px;">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Amount Pic</label>
                                            <br>
                                            @if(isset($edit_meeting->amount_pic) && $edit_meeting->amount_pic!="")
                                            @if (file_exists(public_path().'/assets/uploads/meeting/amount_pic/'.$edit_meeting->amount_pic))
                                            <img src="{{asset('assets/uploads/meeting/amount_pic/'.$edit_meeting->amount_pic)}}" style="width:200px; height:220px;">
                                            @endif
                                            @else
                                            <img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle" style="width:200px; height:220px;">
                                            @endif
                                        </div>
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

    </div>
</section>

@endsection

@push('footer-script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script>
    $(document).ready(function() {
        $(".deal_close").hide();
        $(".followup_date").hide();
        $(".residual").hide();
        $(".status").change(function() {
            let status_id = $(this).val();
            if (status_id == 1) {
                $(".deal_close").show();
            } else {
                $(".deal_close").hide();
            }
            if (status_id == 2) {
                $(".followup_date").show();
            } else {
                $(".followup_date").hide();
            }
            if (status_id == 3) {
                $(".residual").show();
            } else {
                $(".residual").hide();
            }

        }).trigger("change");

        /****************************** end discount************************************** */

        ////////////////////////SELECT2/////////////////////////////////
        $('.select2').select2({
            closeOnSelect: false
        });
    });
</script>

@endpush