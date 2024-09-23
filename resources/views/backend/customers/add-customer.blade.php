@extends('backend.layout.master')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="pagetitle">
            <h1><i class="bi bi-plus"></i> Add Customer</h1>
            <nav>
                <ol class="breadcrumb">

                    <li class="breadcrumb-item active">Add Customer</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-lg-4">
        <nav>
            <ol class="breadcrumb">
                <li><a class="btn btn-primary text-white" href="{{route('backend.view-customers')}}">
                        <i class="bi bi-card-list"></i> View Customers
                    </a>
                </li>
                &nbsp;
                <li><a class="btn btn-danger text-white" href="{{route('backend.archive-customers')}}">
                        <i class="bi bi-archive"></i> Archive Customers
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
                            <form method="post" action="{{route('backend.submit-customer')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label> Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Enter name">
                                            <span class="text-danger">@error('name') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <input type="text" name="company_name" class="form-control" value="{{old('company_name')}}" placeholder="Enter company name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Phone/Mobile <span class="text-danger">*</span></label>
                                            <input type="number" name="phone" class="form-control" value="{{old('phone')}}" placeholder="Enter phone number">
                                            <span class="text-danger">@error('phone') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 pt-3">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" value="{{old('phone')}}" placeholder="Enter email">
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
                                            <input type="file" name="shop_img" class="form-control">
                                            <span class="text-danger">@error('shop_img') {{$message}} @enderror</span>
                                        </div>
                                    </div>

                                    <div class="col-lg-8 pt-3">
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
                                            <label class="form-label mt-2">Tenure <span class="text-danger">*</span></label>
                                            <input type="text" name="tenure" class="form-control" value="{{old('tenure')}}" placeholder="Tenure">
                                            <span class="text-danger">@error('tenure') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Status <span class="text-danger">*</span></label>
                                            <select class="form-control status" name="status">
                                                <option value="0">--select--</option>
                                                <option value="1">Deal Close</option>
                                                <option value="2">Cancle</option>
                                                <option value="3">Follow Up</option>
                                            </select>
                                            <span class="text-danger">@error('status') {{$message}} @enderror</span>
                                        </div>
                                    </div> -->
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
                                            <label class="form-label mt-2"> Advanced </label>
                                            <div class="msg1 text-danger"></div>
                                            <input type="text" name="advance_amount" class="form-control advance" value="{{old('advance_amount')}}" placeholder="₹ 00.00">
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
                                                <option value="3">Volit</option>
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
                                    <div class="col-lg-12 pt-3">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control" value="{{old('address')}}" placeholder="Enter address">
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
                                            <button type="submit" name="submit" class="btn btn-primary">Save Change</button>
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
        //$(".deal_close").hide();
        //$(".followup_date").hide();
        // $(".status").change(function() {
        //     let status_id = $(this).val();
        //     if (status_id == 1) {
        //         $(".deal_close").show();
        //     } else {
        //         $(".deal_close").hide();
        //     }
        //     if (status_id == 3) {
        //         $(".followup_date").show();
        //     } else {
        //         $(".followup_date").hide();
        //     }

        // });

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