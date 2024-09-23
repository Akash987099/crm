@extends('marketend.layout.master')

@section('content')
<div class="row">
    <div class="col-lg-10">
        <div class="pagetitle">
            <h1><i class="bi bi-pencil-square"></i> Edit Attend Meetings</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Edit Attend Meetings</li>p
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-lg-2">
        <nav>
            <ol class="breadcrumb">
                <li><a class="btn btn-danger btn-sm text-white" href="{{url('marketing/view-meeting')}}">
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
                            <form method="post" action="{{route('market.update-meeting',['meetid'=>Crypt::encrypt($edit_meeting->id),'clientid'=>Crypt::encrypt($edit_meeting->clientid)])}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Client Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control client_id" value="{{$edit_meeting->client_name}}" name="client_name">
                                            <span class="text-danger">@error('client_id') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Company Name</label>
                                            <input type="text" name="company_name" class="form-control company_name" value="{{$edit_meeting->company_name}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Phone/Mobile <span class="text-danger">*</span></label>
                                            <input type="number" name="phone" class="form-control phone" value="{{$edit_meeting->phone}}">
                                            <span class="text-danger">@error('phone') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Email</label>
                                            <input type="email" name="email" class="form-control email" value="{{$edit_meeting->email}}">
                                            <span class="text-danger">@error('email') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Category <span class="text-danger">*</span></label>
                                            <input type="text" name="keywords" class="form-control" value="{{$edit_meeting->keywords}}" placeholder="Enter category keyword">
                                            <span class="text-danger">@error('keywords') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Visiting card </label>
                                            <input type="file" name="visiting_card" class="form-control">
                                            <span class="text-danger">@error('visiting_card') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Shop/Front Photo </label>

                                            <input type="file" name="shop_img" class="form-control">
                                            <span class="text-danger">@error('shop_img') {{$message}} @enderror</span>
                                        </div>
                                    </div>





                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Status</label>
                                            @php $status = ['1'=>'Deal Close','2'=>'Follow Up','3'=>'Reschedule']; @endphp
                                            <select class="form-control status" name="status">
                                                <option value="0">--select--</option>
                                                @if(!empty($status))
                                                @foreach($status as $key=>$row)
                                                <option {{($edit_meeting->status==$key)?'selected':''}} value="{{$key}}">{{$row}}</option>
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
                                            <input type="date" name="followup_date" class="form-control" value="{{$edit_meeting->followup_date}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 residual_date">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Reschedule date</label>
                                            <input type="date" name="residual" class="form-control" value="{{$edit_meeting->followup_date}}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Address</label>
                                            <input type="text" name="address" class="form-control address" value="{{$edit_meeting->address}}" placeholder="Enter address">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label">Remark</label>
                                            <textarea name="remark" class="form-control">{{$edit_meeting->remark}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Visiting Card</label><br>
                                            @if (file_exists(public_path().'/assets/uploads/meeting/visitingCard/'.$edit_meeting->visiting_card))
                                            <img src="{{asset('assets/uploads/meeting/visitingCard/'.$edit_meeting->visiting_card)}}" style="width:150px;height:160px;">
                                            @else
                                            <img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle" style="width:60px;">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Shop/image</label><br>
                                            @if (file_exists(public_path().'/assets/uploads/meeting/shopImage/'.$edit_meeting->shop_img))
                                            <img src="{{asset('assets/uploads/meeting/shopImage/'.$edit_meeting->shop_img)}}" style="width:150px;height:160px;">
                                            @else
                                            <img src="{{asset('assets/img/no-image.png')}}" class="rounded-circle" style="width:60px;">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Payment Image</label><br>
                                            @if (file_exists(public_path().'/assets/uploads/meeting/amount_pic/'.$edit_meeting->amount_pic))
                                            <img src="{{asset('assets/uploads/meeting/amount_pic/'.$edit_meeting->amount_pic)}}" style="width:150px;height:160px;">
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
        $(".residual_date").hide();
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
                $(".residual_date").show();
            } else {
                $(".residual_date").hide();
            }



        }).trigger("change");
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
                        $(".final_price").val(response.data);
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

                $(".final_price").val(parseFloat(totale));
                $(".blance").val(parseFloat(totale));

            } else {
                $(".final_price").val(0);
                $(".blance").val(parseFloat(totals_service_price));

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
    $(document).ready(function() {
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
        }).trigger("change");
    });
</script>
<script>
    // $(document).ready(function() {
    //     function remove() {
    //         $(".red").click(function() {
    //             $(this).closest("tr").remove();
    //         });
    //     }
    //     remove();
    //     $(".add-form").on('submit', function(e) {
    //         e.preventDefault();
    //         if ($("input[name=name]").val(), $("input[name=name]").val(), $("input[name=name]").val() == "") {
    //             $(".alert").addClass("active");
    //             $(".remove").click(function() {
    //                 $(".alert").removeClass("active");
    //             });
    //         } else {
    //             var name = $("input[name=name]").val();
    //             var surname = $("input[name=surname]").val();
    //             var email = $("input[name=email]").val();
    //             $(".first-tr").after('<tr><td></td><td>' + name + '</td><td>' + surname + '</td><td>' + email + '</td><td class="static"><span class="button red"><i class="glyphicon glyphicon-remove"></i></span></td></tr>');
    //             remove();
    //             $("input[name=name], input[name=surname], input[name=email]").val("");
    //         }
    //     });
    // });
</script>
@endpush