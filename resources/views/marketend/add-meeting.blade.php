@extends('marketend.layout.master')

@section('content')

<div class="row">
    <div class="col-lg-10">
        <div class="pagetitle">
            <h1>Add Meeting</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Add Meeting</li>p
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-lg-2">
        <nav>
            <ol class="breadcrumb">
                <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{url('marketing/view-meeting')}}">
                        <i class="bi bi-card-list"></i> View Meeting
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
                            <form method="post" action="{{url('marketing/add-meeting')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Client Name <span class="text-danger">*</span></label>
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
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Company Name</label>
                                            <input type="text" class="form-control company_name" name="company_name" placeholder="company name" readonly>
                                            <span class="text-danger">@error('company_name') {{$message}} @enderror</span>
                                            <!-- <input type="text" name="company_name" class="form-control" value="{{old('company_name')}}" placeholder="Enter company name"> -->
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Phone/Mobile <span class="text-danger">*</span></label>
                                            <input type="number" name="phone" class="form-control phone" value="{{old('phone')}}" placeholder="Enter phone number" readonly>
                                            <span class="text-danger">@error('phone') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Email</label>
                                            <input type="email" name="email" class="form-control email" value="{{old('phone')}}" placeholder="Enter email" readonly>
                                            <span class="text-danger">@error('email') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Keywords <span class="text-danger">*</span></label>
                                            <input type="text" name="keywords" class="form-control" value="{{old('keywords')}}" placeholder="Enter keyword">
                                            <span class="text-danger">@error('keywords') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Visiting card <span class="text-danger">*</span></label>
                                            <input type="file" name="visiting_card" class="form-control">
                                            <span class="text-danger">@error('visiting_card') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Shop/Front Photo <span class="text-danger">*</span></label>

                                            <input type="file" id="mypic" name="shop_img" class="form-control" accept="image/jpeg,jpg,png" capture="camera">
                                            <span class="text-danger">@error('shop_img') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Company Service <span class="text-danger">*</span></label>
                                            <select name="company_service[]" class="form-control select2 services" data-placeholder="Select services" multiple>
                                                @php
                                                $services = DB::table('services')
                                                ->where('status',0)
                                                ->select('id', 'service_name','service_price')
                                                ->get();
                                                @endphp

                                                @if(isset($services) && !empty($services))
                                                @foreach($services as $row)
                                                <option value="{{$row->id}}">{{$row->service_name ."/".$row->service_price}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger">@error('company_service') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Tenure</label>
                                            <input type="text" name="tenure" class="form-control" value="{{old('tenure')}}" placeholder="Tenure">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Service Price</label>
                                            <input type="text" name="service_price" class="form-control service-price get-price" value="{{old('service_price')}}" placeholder="service price">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Status</label>
                                            <select class="form-control status" name="status">
                                                <option value="0">--select--</option>
                                                <option value="1">Deal Close</option>
                                                <option value="2">Cancle</option>
                                                <option value="3">Follow Up</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-lg-4 deal_close">
                                        <div class="form-group">
                                            <label class="form-label mt-2"> Discount (%)</label>
                                            <input type="text" name="discount" class="form-control discount" placeholder="%">
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
                                            <input type="text" name="blance" class="form-control balance" value="" placeholder="₹ 00.00" readonly>
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
                                            <label class="form-label mt-2">Upload Payment Image <span class="text-danger">*</span></label>
                                            <input type="file" name="amount_pic" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 followup_date">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Foolow up date</label>
                                            <input type="date" name="followup_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Address</label>
                                            <input type="text" name="address" class="form-control address" value="{{old('address')}}" placeholder="Enter address">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Remark</label>
                                            <textarea name="remark" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Save Change</button>
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
    </div>
</section>
<!-- Vertically centered Modal -->

<div class="modal fade photomodal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vertically Centered</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-6">
                        <div id="my_camera">
                            camera on start
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div id="results">
                            Your Captured image will be appear here..
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">

                <input id="capture_image" type="button" class="btn btn-warning" value="Take snapshot">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> Close</button>

            </div>
        </div>
    </div>
</div>
<!-- End Vertically centered Modal-->

@endsection

@push('footer-script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script>
    $(document).ready(function() {
        $(".deal_close").hide();
        $(".followup_date").hide();
        $(".status").change(function() {
            var data_id = $(this).val();
            if (data_id == 1) {
                $(".deal_close").show();
            } else {
                $(".deal_close").hide();
            }
            if (data_id == 3) {
                $(".followup_date").show();
            } else {
                $(".followup_date").hide();
            }

        });
        /***************************************************************** */

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

                        let advance = $(".advance").val();
                        let get_final_price = $(".final_price").val();

                        if (advance != '') {
                            if (Number(response.data) >= Number(advance)) {
                                let balance = parseFloat(get_final_price) - parseFloat(advance);
                                $(".balance").val(balance);
                            } else {

                                $(".msg1").html('<div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">Advance price can\'t be total price.<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>');

                            }
                        }

                        // console.log(dis);
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


        });
        ///////////////////////////////ADVANCED///////////////////////////////////////////////////////
        // $(".advance").on('keyup', function() {
        //     let advance_price = $(this).val();
        //     let total_service_price = $(".final_price").val();

        //     if (advance_price != '') {
        //         if (Number(total_service_price) >= Number(advance_price)) {
        //             let balance = parseFloat(total_service_price) - parseFloat(advance_price);
        //             $(".balance").val(balance);

        //         } else {

        //             $(".msg1").html('<div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">Advance price can\'t be total price.<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>');

        //         }
        //     } else {
        //         $(".balance").val(total_service_price);
        //     }
        // });
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
            }


        });

        ///////////////////////////////////////////////////////////////////////////////////

        $('.select2').select2({
            closeOnSelect: false
        });
    });
    /////////////////////////END PROFILE UPDATE///////////////////////////////////////
</script>

<script>
    //////////////////////////////////CLIENT SELECT///////////////////////////////////
    $(".client_id").on('change', function() {
        var getId = $(this).val();
        $.ajax({
            type: 'post',
            url: "{{url('marketing/selectclientcompany')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": getId
            },
            success: function(response) {
                if (response.status == 200) {
                    $(".company_name").val(response.clientData.company_name);
                    $(".phone").val(response.clientData.phone);
                    $(".email").val(response.clientData.email);
                    $(".address").val(response.clientData.address);
                }
            }

        });
    });
</script>
@endpush