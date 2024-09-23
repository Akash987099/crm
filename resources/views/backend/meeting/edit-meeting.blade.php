@extends('backend.layout.master')

@section('content')
<div class="row">
    <div class="col-lg-10">
        <div class="pagetitle">
            <h1><i class="bi bi-pencil-square"></i> Edit Attend Meeting</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Edit Attend Meeting</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-lg-2">
        <nav>
            <ol class="breadcrumb">
                <li class="p-1"><a class="btn btn-danger text-white" href="{{route('backend.view-meeeting')}}">
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
                            <form method="post" action="{{route('backend.update-meeting',['meetingid'=>Crypt::encrypt($edit_meeting->id)])}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Client Name <span class="text-danger">*</span></label>
                                            <input type="text" name="client_name" class="form-control" value="{{$edit_meeting->client_name}}" placeholder="Enter name">
                                            <small class="text-danger">@error('client_name') {{$message}} @enderror</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Company Name</label>
                                            <input type="text" name="company_name" class="form-control" value="{{$edit_meeting->company_name}}" placeholder="Enter company name">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Phone/Mobile <span class="text-danger">*</span></label>
                                            <input type="number" name="phone" class="form-control" value="{{$edit_meeting->phone}}" placeholder="Enter phone number">
                                            <small class="text-danger">@error('phone') {{$message}} @enderror</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Email</label>
                                            <input type="email" name="email" class="form-control" value="{{$edit_meeting->email}}" placeholder="Enter email">

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Category <span class="text-danger">*</span></label>
                                            <input type="text" name="keywords" class="form-control" value="{{$edit_meeting->keywords}}" placeholder="Enter keyword">

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Visiting card <span class="text-danger">*</span></label>
                                            <input type="file" name="visiting_card" class="form-control" accept="image/jpeg,jpg,png">
                                            <small class="text-danger">@error('visiting_card') {{$message}} @enderror</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Shop/Front Photo <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" name="shop_img" accept="image/jpeg,jpg,png" capture="camera">
                                            <small class="text-danger">@error('shop_img') {{$message}} @enderror</small>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Status <span class="text-danger">*</span></label>
                                            @php $status = ['1'=>'Deal Close','2'=>'Follow Up','3'=>'Reschedule']; @endphp
                                            <select class="form-control status" name="status">
                                                <option value="0">Select ..</option>
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
                                            <small class="text-danger">@error('amount_pic') {{$message}} @enderror</small>
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


                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label mt-2">Address</label>
                                            <input type="text" name="address" class="form-control" value="{{$edit_meeting->address}}" placeholder="Enter address">
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

        /******************************service select get price************************************** */
        // $(".services").change(function() {
        //     let service_id = $(this).val();
        //     $.ajax({
        //         type: 'POST',
        //         url: "",
        //         data: {
        //             "_token": "{{ csrf_token() }}",
        //             "id": service_id
        //         },
        //         success: function(response) {
        //             if (response.status == 200) {
        //                 $(".service-price").val(response.data);
        //                 $(".balance").val(parseFloat(response.data));
        //                 $(".final_price").val(parseFloat(response.data));
        //                 let discount = $(".discount").val();
        //                 if (discount != "") {
        //                     let amt = (parseFloat(response.data) * parseFloat(discount)) / 100;
        //                     let total = response.data - amt;

        //                     $(".final_price").val(parseFloat(total));
        //                     $(".balance").val(parseFloat(total));
        //                 }

        //             } else {
        //                 $(".service-price").val(0);
        //                 $(".final_price").val(0);
        //                 $(".discount").val(0);
        //                 $(".balance").val(0);
        //                 $(".advance").val(0)
        //                 $(".msg1").html('<div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">Please Select Company Service.<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        //             }

        //         }
        //     });
        // });



        /****************************** select client get company************************************** */
        // $(".client_id").on('change', function() {
        //     var getId = $(this).val();
        //     $(".company_name").val('');
        //     $(".phone").val('');
        //     $(".email").val('');
        //     $(".address").val('');
        //     $.ajax({
        //         type: 'post',
        //         url: "{{url('admin/selectclientgetcompany')}}",
        //         data: {
        //             "_token": "{{ csrf_token() }}",
        //             "id": getId
        //         },
        //         success: function(response) {
        //             console.log(response);
        //             if (response.status == 200) {
        //                 $(".company_name").val(response.clientData.company_name);
        //                 $(".phone").val(response.clientData.phone);
        //                 $(".email").val(response.clientData.email);
        //                 $(".address").val(response.clientData.address);
        //             }
        //         }

        //     });
        // }).trigger("change");

        /****************************** end select client get company************************************** */




        ////////////////////////SELECT2/////////////////////////////////
        $('.select2').select2({
            closeOnSelect: false
        });
    });
</script>

@endpush