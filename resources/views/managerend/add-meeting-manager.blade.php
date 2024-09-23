@extends('managerend.layout.master')

@section('content')
<div class="row">
    <div class="col-lg-9">
        <div class="pagetitle">
            <h1><i class="bi bi-plus"></i> Add Meeting</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Add Meeting</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-lg-3">
        <nav>
            <ol class="breadcrumb">
                <li><a class="btn btn-primary btn-sm text-white" href="{{url('manager/view-meeting-manager')}}">
                        <i class="bi bi-card-list"></i> View Meeting
                    </a>
                </li>
                &nbsp;
                <li><a class="btn btn-danger btn-sm text-white" href="{{url('manager/archive-meeting-manager')}}">
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
                            <form method="post" action="{{url('manager/add-meeting-manager')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label> Name <span class="text-danger">*</span></label>
                                            <select class="form-select client_id" name="client_id">
                                                <option value="0">Select Client...</option>
                                                @if(isset($ashign_client) && !empty($ashign_client))
                                                @foreach($ashign_client as $row)
                                                <option value="{{$row->id}}">{{$row->client_name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger">@error('client_id') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <input type="text" name="company_name" class="form-control company_name" value="{{old('company_name')}}" placeholder="Enter company name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Phone/Mobile <span class="text-danger">*</span></label>
                                            <input type="number" name="phone" class="form-control phone" value="{{old('phone')}}" placeholder="Enter phone number">
                                            <span class="text-danger">@error('phone') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control email" value="{{old('phone')}}" placeholder="Enter email">
                                            <span class="text-danger">@error('email') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Keyword <span class="text-danger">*</span></label>
                                            <input type="text" name="keywords" class="form-control" value="{{old('keyword')}}" placeholder="Enter keyword">

                                        </div>
                                    </div>

                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Visiting card <span class="text-danger">*</span></label>
                                            <input type="file" name="visiting_card" class="form-control">
                                            <span class="text-danger">@error('visiting_card') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Shop/Front Photo <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" name="shop_img" accept="image/jpeg,jpg,png" capture="camera">
                                            <span class="text-danger">@error('shop_img') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Tenure</label>
                                            <input type="text" name="tenure" class="form-control" value="{{old('tenure')}}" placeholder="Tenure">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 pt-3">
                                        <div class="form-group">
                                            <label>Company Service <span class="text-danger">*</span></label>
                                            <select name="company_service[]" class="form-control select2 services" data-placeholder=" Select services" multiple>
                                                @php
                                                $services = DB::table('services')
                                                ->where('status',0)
                                                ->select('id', 'service_name','service_price')
                                                ->get();
                                                @endphp

                                                @if(isset($services) && !empty($services))
                                                @foreach($services as $row)
                                                <option value="{{$row->id}}">{{$row->service_name."/".$row->service_price}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger">@error('company_service') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Status <span class="text-danger">*</span></label>
                                            <select class="form-control status" name="status">
                                                <option value="0">--select--</option>
                                                <option value="1">Deal Close</option>
                                                <option value="2">Cancel</option>
                                                <option value="3">Follow Up</option>
                                            </select>
                                            <span class="text-danger">@error('status') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Service Price</label>
                                            <input type="text" name="service_price" class="form-control service-price get_price" value="{{old('service_price')}}" placeholder="₹ 00.00" readonly>
                                        </div>
                                    </div>



                                    <div class="col-lg-4 deal_close">
                                        <div class="form-group">
                                            <label class="form-label mt-2"> Discount (%)</label>
                                            <input type="text" name="discount" class="form-control discount" value="{{old('discount')}}" placeholder="%">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 deal_close">
                                        <div class="form-group">
                                            <label class="form-label mt-2"> Final Price</label>
                                            <input type="text" name="final_price" class="form-control final_price" placeholder="₹ 00.00" disabled="disabled">
                                        </div>
                                    </div>



                                    <div class="col-lg-4 deal_close">
                                        <div class="form-group">
                                            <label class="form-label mt-2"> Blance </label>
                                            <input type="text" name="blance" class="form-control balance" value="{{old('blance')}}" placeholder="₹ 00.00" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 deal_close">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Payment Of Mode</label>
                                            <select class="form-control" name="payment_mode">
                                                <option value="0">--select--</option>
                                                <option value="1">Cash</option>
                                                <option value="2">Check</option>
                                                <option value="3">Wallet</option>
                                                <option value="4">Networking</option>
                                            </select>
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
                                            <input type="date" name="followup_date" class="form-control" value="{{old('followup_date')}}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 pt-3">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control address" value="{{old('address')}}" placeholder="Enter address">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 pt-3">
                                        <div class="form-group">
                                            <label>Remark</label>
                                            <textarea name="remark" class="form-control">{{old('remark')}}</textarea>
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
        $(".status").change(function() {
            let status_id = $(this).val();
            if (status_id == 1) {
                $(".deal_close").show();
            } else {
                $(".deal_close").hide();
            }
            if (status_id == 3) {
                $(".followup_date").show();
            } else {
                $(".followup_date").hide();
            }

        });

        /******************************service select get price************************************** */
        $(".services").change(function() {
            let service_id = $(this).val();

            $.ajax({
                type: 'POST',
                url: "{{url('admin/service-select-getprice')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": service_id
                },
                success: function(response) {

                    if (response.status == 200) {
                        $(".service-price").val(response.data);
                        $(".balance").val(parseFloat(response.data));
                        $(".final_price").val(parseFloat(response.data));
                        let discount = $(".discount").val();
                        if (discount != "") {
                            let amt = (parseFloat(response.data) * parseFloat(discount)) / 100;
                            let total = response.data - amt;

                            $(".final_price").val(parseFloat(total));
                            $(".balance").val(parseFloat(total));
                        }

                    } else {
                        $(".service-price").val(0);
                        $(".final_price").val(0);
                        $(".discount").val(0);
                        $(".balance").val(0);
                        $(".advance").val(0)
                        $(".msg1").html('<div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">Please Select Company Service.<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                    }

                }
            });
        });

        /****************************** end service select get price******************* */

        /******************************  discount************************************** */
        $(".discount").keyup(function() {
            let discount = $(this).val();
            let total_service_price = $(".get_price").val();
            if (total_service_price != "" && discount != "") {
                let amt = (parseFloat(total_service_price) * parseFloat(discount)) / 100;
                let totale = total_service_price - amt;
                $(".final_price").val(parseFloat(totale));
                $(".balance").val(parseFloat(totale));

            } else {
                $(".final_price").val(parseFloat(total_service_price));
                $(".balance").val(parseFloat(total_service_price));
            }

        });

        /****************************** end discount************************************** */

        //////////////////////////////////CLIENT SELECT///////////////////////////////////
        $(".client_id").on('change', function() {
            var getId = $(this).val();
            $(".company_name").val('');
            $(".phone").val('');
            $(".email").val('');
            $(".address").val('');

            $.ajax({
                type: 'post',
                url: "{{url('manager/selectclientcompany')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": getId
                },
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        $(".company_name").val(response.clientData.company_name);
                        $(".phone").val(response.clientData.phone);
                        $(".email").val(response.clientData.email);
                        $(".address").val(response.clientData.address);
                    }
                }

            });
        });
        ////////////////////////SELECT2/////////////////////////////////
        $('.select2').select2({
            closeOnSelect: false
        });
    });
</script>

@endpush