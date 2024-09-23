@extends('managerend.layout.master')

@section('content')
<div class="row">
    <div class="col-lg-10">
        <div class="pagetitle">
            <h1><i class="bi bi-pencil-square"></i> Edit Cold Call</h1>
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
                <li><a class="btn btn-danger btn-sm text-white" href="{{route('manager.view-coldcall')}}">
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
                            <form method="post" action="{{route('manager.update-coldcall',['coldId'=>Crypt::encrypt($edit_mcoldCall->id)])}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Client Name <span class="text-danger">*</span></label>
                                            <input type="text" name="client_name" class="form-control" value="{{$edit_mcoldCall->client_name}}" placeholder="Enter name">

                                            <span class="text-danger">@error('client_name') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Company Name</label>
                                            <input type="text" name="company_name" class="form-control" value="{{$edit_mcoldCall->company_name}}" placeholder="Enter company name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Phone/Mobile <span class="text-danger">*</span></label>
                                            <input type="number" name="phone" class="form-control" value="{{$edit_mcoldCall->phone}}" placeholder="Enter phone number">
                                            <span class="text-danger">@error('phone') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Email</label>
                                            <input type="email" name="email" class="form-control" value="{{$edit_mcoldCall->email}}" placeholder="Enter email">
                                            <span class="text-danger">@error('email') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Category <span class="text-danger">*</span></label>
                                            <input type="text" name="keywords" class="form-control" value="{{$edit_mcoldCall->keywords}}" placeholder="Enter keyword">
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

                                            <input type="file" name="shop_img" class="form-control">
                                            <span class="text-danger">@error('shop_img') {{$message}} @enderror</span>
                                        </div>
                                    </div>





                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Status <span class="text-danger">*</span></label>
                                            @php $status = ['1'=>'Deal Close','2'=>'Follow Up','3'=>'Reschedule']; @endphp
                                            <select class="form-control status" name="status">
                                                <option value="0">--select--</option>
                                                @if(!empty($status))
                                                @foreach($status as $key=>$row)
                                                <option {{($edit_mcoldCall->status==$key)?'selected':''}} value="{{$key}}">{{$row}}</option>
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
                                            <input type="date" name="followup_date" class="form-control" value="{{$edit_mcoldCall->followup_date}}">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 residual">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Reschedule date</label>
                                            <input type="date" name="residual" class="form-control" value="{{$edit_mcoldCall->residual}}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Address</label>
                                            <input type="text" name="address" class="form-control" value="{{$edit_mcoldCall->address}}" placeholder="Enter address">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Remark</label>
                                            <textarea name="remark" class="form-control">{{$edit_mcoldCall->remark}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Visiting Card</label><br>
                                            @if ($edit_mcoldCall->visiting_card!="" && file_exists(public_path().'/assets/uploads/meeting/visitingCard/'.$edit_mcoldCall->visiting_card))
                                            <img src="{{asset('assets/uploads/meeting/visitingCard/'.$edit_mcoldCall->visiting_card)}}" style="width:150px;height:160px;">
                                            @else
                                            <img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle" style="width:60px;">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Shop/image</label><br>
                                            @if ($edit_mcoldCall->shop_img!="" && file_exists(public_path().'/assets/uploads/meeting/shopImage/'.$edit_mcoldCall->shop_img))
                                            <img src="{{asset('assets/uploads/meeting/shopImage/'.$edit_mcoldCall->shop_img)}}" style="width:150px;height:160px;">
                                            @else
                                            <img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle" style="width:60px;">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Payment Image</label><br>

                                            @if ($edit_mcoldCall->amount_pic!="" && file_exists(public_path().'/assets/uploads/meeting/amount_pic/'.$edit_mcoldCall->amount_pic))
                                            <img src="{{asset('assets/uploads/meeting/amount_pic/'.$edit_mcoldCall->amount_pic)}}" style="width:150px;height:160px;">
                                            @else
                                            <img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle" style="width:60px;">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Save Update</button>
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
        $(".residual").hide();
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
                $(".residual").show();
            } else {
                $(".residual").hide();
            }

        }).trigger("change");
        /***************************************************************** */
        $('.select2').select2({
            closeOnSelect: false
        });
        /**********************services************************************ */

        ///////////////////////////////ADVANCED///////////////////////////////////////////////////////

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
                $(".balance").val(parseFloat(0));
            }


        });

        ///////////////////////////////////////////////////////////////////////////////////
    });
    /////////////////////////END PROFILE UPDATE///////////////////////////////////////
</script>

<script>
    $(document).ready(function() {
        $("#accesscamera").on('click', function() {
            $(".photomodal").modal("show");
            Webcam.set({
                width: 320,
                height: 300,
                image_format: 'jpeg',
                jpeg_quality: 90
            });
            Webcam.attach('#my_camera');
        });
        $("#capture_image").click(function() {
            Webcam.snap(function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById("results").innerHTML = '<img src="' + data_uri + '"/>';

            });
        });
    });
</script>
@endpush