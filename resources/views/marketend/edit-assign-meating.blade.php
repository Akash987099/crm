@extends('marketend.layout.master')

@section('content')
<div class="row">
    <div class="col-lg-10">
        <div class="pagetitle">
            <h1><i class="bi bi-person"></i> Meeting Attend</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active text-danger">@if(isset($user->firstname) && isset($user->firstname)) {{$user->firstname .' '. $user->lastname}} @endif {{$post}}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-lg-2">
        <nav>
            <ol class="breadcrumb">
                <li><a class="btn btn-danger btn-sm text-white" href="{{route('market.View-assign-meating')}}">
                        <i class="bi bi-arrow-left"></i> Back
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
                            <div class="msg"></div>

                            <form method="post" action="{{route('meeting.add-meeting',['cltid'=>Crypt::encrypt($ashign_meating->id)])}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Client Name <span class="text-danger">*</span></label>
                                            <input type="text" name="client_name" class="form-control" value="{{$ashign_meating->client_name}}" placeholder="Enter name">
                                            <span class="text-danger">@error('client_name') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Company Name <span class="text-danger">*</span></label>
                                            <input type="text" name="company_name" class="form-control" value="{{$ashign_meating->company_name}}" placeholder="Enter company name">
                                            <span class="text-danger">@error('company_name') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Email </label>
                                            <input type="email" name="email" class="form-control" value="{{$ashign_meating->email}}" placeholder="Enter email">

                                        </div>
                                    </div>

                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Phone <span class="text-danger">*</span></label>
                                            <input type="text" name="phone" class="form-control" value="{{$ashign_meating->phone}}" placeholder="Enter phone">
                                            <span class="text-danger">@error('phone') {{$message}} @enderror</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Category</label>
                                            <input type="text" name="keywords" class="form-control" value="{{old('keywords')}}" placeholder="Enter category keyword">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control" value="{{$ashign_meating->address}}" placeholder="Enter address">
                                        </div>
                                    </div>


                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Visiting card </label>
                                            <input type="file" name="visiting_card" class="form-control">

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Shop/Front Photo </label>
                                            <input type="file" id="mypic" name="shop_img" class="form-control" accept="image/jpeg,jpg,png" capture="camera">

                                        </div>
                                    </div>

                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Meeting Status</label>
                                            @php $status = ['1'=>'Deal Close','2'=>'Follow Up','3'=>'Reschedule']; @endphp
                                            <select class="form-control status" name="status">
                                                <option value="0">Select ..</option>
                                                @if(!empty($status))
                                                @foreach($status as $key=>$row)
                                                <option @if(isset($ashign_meating->meeting_status) && $ashign_meating->status==$key) {{'selected'}} @endif value="{{$key}}">{{$row}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <small class="text-danger">@error('status') {{$message}} @enderror</small>
                                        </div>
                                    </div>




                                    <div class="col-lg-4 deal_close">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Upload Payment Image</label>
                                            <input type="file" name="amount_pic" class="form-control">

                                        </div>
                                    </div>

                                    <div class="col-lg-4 followup_date">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Foolow up date</label>
                                            <input type="date" name="followup_date" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 residual">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Reschedule</label>
                                            <input type="date" name="residual" class="form-control">
                                        </div>
                                    </div>


                                    <div class="col-lg-12 pt-3">
                                        <div class="form-group">
                                            <label>Remark</label>
                                            <textarea name="remark" class="form-control" disabled>{{$ashign_meating->remark}}</textarea>
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
    $(".services").change(function() {
        var getId = $(this).val();

        $.ajax({
            type: 'POST',
            url: "{{url('marketing/selectservice-getprice')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": getId
            },
            success: function(response) {

                if (response.status == 200) {
                    $(".service-price").val(response.data);

                } else {
                    $(".service-price").val(0);

                    $(".msg").html('<div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">Please select company service.<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                }
            }

        });


    });
    ////////////////////////////////SELECT2///////////////////////////////////////////
    $(document).ready(function() {
        /****************meeting status******************************/
        $(".deal_close").hide();
        $(".followup_date").hide();
        $('.residual').hide();
        $(".status").change(function() {
            var data_id = $(this).val();
            if (data_id == 1) {
                $(".deal_close").show();
            } else {
                $(".deal_close").hide();
            }
            if (data_id == 2) {
                $(".followup_date").show();
            } else {
                $(".followup_date").hide();
            }
            if (data_id == 3) {
                $('.residual').show();
            } else {
                $('.residual').hide();
            }

        }).trigger("change");
        /****************end meeting status******************************/

        /**********************services************************************ */
        $(".services").change(function() {
            var getId = $(this).val();
            $.ajax({
                type: 'POST',
                url: "{{url('marketing/select-service-getprice')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": getId
                },
                success: function(response) {
                    if (response.status == 200) {
                        $(".service-price").val(response.data);
                        $(".balance").val(response.data);
                        let dis = $('.discount').val();
                        if (dis != '') {
                            let amt = (parseFloat(response.data) * parseFloat(dis)) / 100;
                            let total = response.data - amt;
                            $(".final_price").val(total);
                        }
                    } else {
                        $(".service-price").val(0);
                        $(".final_price").val(0);
                        $(".discount").val(0);
                        $(".balance").val(0);
                        $(".advance").val(0);
                        $(".msg").html('<div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">Please select company service.<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    }
                }

            });
        }).trigger("change");


        /////////////////////////////DESCOUNT %/////////////////////////////////////////////////////////////////////
        $(".discount").on('keyup', function() {
            let discount = $(this).val();
            let totals_service_price = $(".get-price").val();

            if (totals_service_price != "" && discount != "") {
                let amt = (parseFloat(totals_service_price) * parseFloat(discount)) / 100;
                let totale = totals_service_price - amt;
                // console.log(totale);
                $(".final_price").val(parseFloat(totale));
                $(".balance").val(parseFloat(totale));

            } else {
                $(".final_price").val(0);
                $(".balance").val(parseFloat(totals_service_price));
            }


        });
        /**************************************************************************** */
        $('.select2').select2({
            closeOnSelect: false
        });
    });
</script>

@endpush