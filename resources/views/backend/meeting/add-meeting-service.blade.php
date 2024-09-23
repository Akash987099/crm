@extends('backend.layout.master')

@section('content')

<div class="row">
    <div class="col-lg-10">
        <div class="pagetitle">
            <h1><i class="bi bi-plus-circle-fill"></i> Add Services</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active text-danger">@if(isset($meeting->client_name) && isset($meeting->phone) && isset($meeting->email)){{$meeting->client_name.' , '.$meeting->phone.' , '.$meeting->email}} @endif</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-lg-2">
        <nav>
            <ol class="breadcrumb">
                <li><a class="btn btn-danger btn-sm text-white" href="{{route('backend.view-meeeting')}}">
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


                            @csrf
                            <input type="hidden" id="meetingid" value="{{Crypt::encrypt($meeting->id)}}">
                            <table class="table table-bordered table-scroll mt-3" id="productTable">
                                <thead>
                                    <tr>
                                        <th>Services</th>
                                        <th>Price</th>
                                        <th>Tenure</th>
                                        <th><a class="btn btn-info addProduct" id="addProduct"><i class="bi bi-plus-circle-fill"></i></a></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="service" class="form-select service">
                                                @php
                                                $services = DB::table('services')
                                                ->where('status',0)
                                                ->where('archive',0)
                                                ->select('id', 'service_name','service_price')
                                                ->get();
                                                @endphp

                                                @if(isset($services) && !empty($services))
                                                @foreach($services as $row)
                                                <option value="{{$row->id}}">{{$row->service_name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td><input type="text" name="price" class="form-control price" placeholder="Price"></td>
                                        <td><input type="text" name="tenure" class="form-control tenure" placeholder="Tenure"></td>
                                        <!-- <td><a class="btn btn-danger remove"><i class="bi bi-trash"></i></a></td> -->
                                    </tr>
                                    @if(isset($temp_service) && !empty($temp_service))
                                    @php $amt=0; @endphp
                                    @foreach($temp_service as $service_data)
                                    @php
                                    $amt+=$service_data->price;
                                    $service = DB::table('services')->where('id',$service_data->serviceid)->where('archive',0)->where('status',0)->first();
                                    @endphp
                                    <tr>
                                        <td>
                                            <select class="form-control" id="servivename" readonly>
                                                <option value="{{$service->id}}">{{$service->service_name}}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="{{$service_data->price}}" readonly>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" value="{{$service_data->tenure}}" readonly>
                                        </td>
                                        <td><a class="btn btn-danger remove" data-id="{{Crypt::encrypt($service_data->id)}}"><i class="bi bi-trash"></i></a></td>
                                    </tr>
                                    @endforeach
                                    @endif

                                </tbody>
                                <tfoot>
                                    <form method="post" action="{{route('backend.meeting-service-discount',['meetingid'=>Crypt::encrypt($meeting->id)])}}">
                                        @csrf
                                        <tr>
                                            <td><b>Total</b></td>
                                            <td colspan="3"><input type="text" name="total" class="form-control total" value="{{$amt}}" readonly></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <small>Discount %</small>
                                                <input type="text" name="discount" class="form-control discount" value="@if(isset($meeting->discount)){{$meeting->discount}}@endif" placeholder="discount %">
                                            </td>
                                            <td>
                                                <small>Subtotal</small>
                                                <input type="text" class="form-control" value="@if(isset($meeting->discount)){{$meeting->blance}}@endif" placeholder="sub total">
                                            </td>
                                            <td colspan="2">
                                                <button type="submit" class="btn btn-primary mt-4">Save change</button>
                                            </td>
                                        </tr>
                                    </form>
                                </tfoot>
                            </table>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

<script>
    $(document).ready(function() {

        $("#addProduct").click(function() {
            let service = $('.service :selected').val();
            let service_text = $('.service :selected').text();
            let price = $(".price").val();
            let tenure = $(".tenure").val();
            if (service > 0 && price > "") {
                var html = '<tr><td><select class="form-control" name="service[]" id="servivename" readonly><option value=' + service + '>' + service_text + '</option></select></td><td><input type="text" name="price" class="form-control price" value="' + price + '" readonly></td><td><input type="text" name="tenure" class="form-control tenure" value="' + tenure + '" placeholder="Tenure" readonly></td><td><button class="btn btn-danger remove"><i class="bi bi-trash"></i></button></td></tr>';
                $('tbody').append(html);
            }

        });

        $(document).on('click', '.remove', function() {
            $(this).parents('tr').remove();
        });

        $('.select2').select2({
            closeOnSelect: false
        });


    });
</script>
<script>
    $(".addProduct").click(function() {
        let serviceid = $('.service :selected').val();
        let price = $(".price").val();
        let discount = $(".discount").val();
        let tenure = $(".tenure").val();
        let meetingid = $("#meetingid").val();
        $.ajax({
            type: 'POST',
            url: "{{route('backend.meeting-service-submit')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "serviceid": serviceid,
                "price": price,
                "discount": discount,
                "meetingid": meetingid,
                "tenure": tenure
            },
            success: function(response) {

                if (response.status == 200) {
                    location.reload();
                }
            }

        });
    });


    $(".remove").click(function() {
        let serviceid = $(this).attr('data-id');
        let meetingid = $("#meetingid").val();

        $.ajax({
            type: 'POST',
            url: "{{route('backend.meeting-service-delete')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "serviceid": serviceid,
                "meetingid": meetingid

            },
            success: function(response) {

                if (response.status == 200) {
                    location.reload();
                }
            }

        });
    });
</script>

@endpush