@extends('backend.layout.master')

@section('content')
<div class="row">
    <div class="col-lg-10">
        <div class="pagetitle">
            <h1><i class="bi bi-pencil-square"></i> Edit Customer</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Edit Customer</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-lg-2">
        <nav>
            <ol class="breadcrumb">
                <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{url('admin/view-customers')}}">
                        <i class="bi bi-arrow-left"></i> back
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
                            <div class="msg1"></div>
                            <form method="post" action="{{url('admin/edit-customer')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label> Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{$edit_customer->name}}" placeholder="Enter name">
                                            <input type="hidden" name="meditld" value="{{Crypt::encrypt($edit_customer->id)}}">
                                            <span class="text-danger">@error('name') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <input type="text" name="company_name" class="form-control" value="{{$edit_customer->company_name}}" placeholder="Enter company name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Phone/Mobile <span class="text-danger">*</span></label>
                                            <input type="number" name="phone" class="form-control" value="{{$edit_customer->phone}}" placeholder="Enter phone number">
                                            <span class="text-danger">@error('phone') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" value="{{$edit_customer->email}}" placeholder="Enter email">
                                            <span class="text-danger">@error('email') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Keyword <span class="text-danger">*</span></label>
                                            <input type="text" name="keywords" class="form-control" value="{{$edit_customer->keywords}}" placeholder="Enter keyword">

                                        </div>
                                    </div>

                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Visiting card <span class="text-danger">*</span></label>
                                            <input type="file" name="visiting_card" class="form-control">

                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Shop/Front Photo <span class="text-danger">*</span></label>
                                            <input type="file" name="shop_img" class="form-control">

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Tenure</label>
                                            <input type="text" name="tenure" class="form-control" value="{{$edit_customer->tenure}}" placeholder="Tenure">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 pt-3">
                                        <div class="form-group">
                                            <label>Company Service <span class="text-danger">*</span></label>
                                            @if(isset($edit_customer->company_service))
                                            @php
                                            $arr=[];
                                            $company_service = json_decode($edit_customer->company_service);
                                            foreach( $company_service as $values) {
                                            array_push($arr,$values);
                                            }
                                            @endphp
                                            @endif
                                            <select name="company_service[]" class="form-control select2 services" data-placeholder=" Select services" multiple>
                                                @php
                                                $services = DB::table('services')
                                                ->where('status',0)
                                                ->select('id', 'service_name','service_price')
                                                ->get();
                                                @endphp

                                                @if(isset($services) && !empty($services))
                                                @foreach($services as $row)
                                                <option @if(is_array($arr) && in_array($row->id,$arr)) {{'selected'}} @endif value="{{$row->id}}">{{$row->service_name."/".$row->service_price}}</option>
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
                                                <option {{($edit_customer->status==1)?'selected':''}} value="1">Deal Close</option>
                                            </select>
                                            <span class="text-danger">@error('status') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Service Price</label>
                                            <input type="text" name="service_price" class="form-control service-price get_price" value="{{$edit_customer->service_price}}" placeholder="₹ 00.00" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 deal_close">
                                        <div class="form-group">
                                            <label class="form-label mt-2"> Discount (%)</label>
                                            <input type="text" name="discount" class="form-control discount" value="{{$edit_customer->discount}}" placeholder="%">
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
                                            <label class="form-label mt-2"> Advanced </label>
                                            <div class="text-danger"></div>
                                            <input type="text" name="advance_amount" class="form-control advance" value="{{$edit_customer->advance_amount}}" placeholder="₹ 00.00">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 deal_close">
                                        <div class="form-group">
                                            <label class="form-label mt-2"> Blance </label>
                                            <input type="text" name="blance" class="form-control balance" value="{{$edit_customer->blance}}" placeholder="₹ 00.00" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 deal_close">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Payment Of Mode</label>
                                            <select class="form-control" name="payment_mode">
                                                <option value="0">--select--</option>
                                                <option {{($edit_customer->payment_mode==1)?'selected':''}} value="1">Cash</option>
                                                <option {{($edit_customer->payment_mode==2)?'selected':''}} value="2">Check</option>
                                                <option {{($edit_customer->payment_mode==3)?'selected':''}} value="3">Volit</option>
                                                <option {{($edit_customer->payment_mode==4)?'selected':''}} value="4">Networking</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-lg-4 deal_close">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Upload Payment Image</label>
                                            <input type="file" name="amount_pic" class="form-control">
                                        </div>
                                    </div>



                                    <div class="col-lg-12 pt-3">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control" value="{{$edit_customer->address}}" placeholder="Enter address">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 pt-3">
                                        <div class="form-group">
                                            <label>Remark</label>
                                            <textarea name="remark" class="form-control">{{$edit_customer->remark}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Visiting Card</label>
                                            <br>
                                            @if (file_exists(public_path().'/assets/uploads/meeting/visitingCard/'.$edit_customer->visiting_card))
                                            <img src="{{asset('assets/uploads/meeting/visitingCard/'.$edit_customer->visiting_card)}}" style="width:200px; height:220px;">
                                            @else
                                            <img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle" style="width:60px;">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Shop/Image</label>
                                            <br>
                                            @if (file_exists(public_path().'/assets/uploads/meeting/shopImage/'.$edit_customer->shop_img))
                                            <img src="{{asset('assets/uploads/meeting/shopImage/'.$edit_customer->shop_img)}}" style="width:200px; height:220px;">
                                            @else
                                            <img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle" style="width:60px;">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Amount Pic</label>
                                            <br>
                                            @if (file_exists(public_path().'/assets/uploads/meeting/amount_pic/'.$edit_customer->amount_pic))
                                            <img src="{{asset('assets/uploads/meeting/amount_pic/'.$edit_customer->amount_pic)}}" style="width:200px; height:220px;">
                                            @else
                                            <img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle" style="width:60px;">
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
        //$(".followup_date").hide();
        $(".status").change(function() {
            let status_id = $(this).val();
            if (status_id == 1) {
                $(".deal_close").show();
            }
        }).trigger("change");

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

                        let advance = $(".advance").val();
                        let finalprice = $(".final_price").val();
                        if (advance != '') {
                            if (Number(response.data) >= Number(advance)) {
                                let balance = parseFloat(finalprice) - parseFloat(advance);
                                $(".balance").val(balance);
                            } else {

                                $(".msg1").html('<div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">Advance price can\'t be total price.<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>');

                            }
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

        /****************************** end service select get price************************************** */
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
                $(".advance").val(parseFloat(0));
            }

        });

        /****************************** end discount************************************** */

        /****************************** advance************************************** */
        $(".advance").keyup(function() {
            let advance = $(this).val();
            let final_price = $(".final_price").val();
            if (advance != "") {
                if (Number(final_price) >= Number(advance)) {
                    let blance = parseFloat(final_price) - parseFloat(advance);
                    $(".balance").val(parseFloat(blance));

                } else {

                    $(".msg1").html('<div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">Advance price can\'t be total price.<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                }
            } else {
                $(".balance").val(parseFloat(final_price));
            }

        });

        /****************************** end advance************************************** */




        ////////////////////////SELECT2/////////////////////////////////
        $('.select2').select2({
            closeOnSelect: false
        });
    });
</script>

@endpush