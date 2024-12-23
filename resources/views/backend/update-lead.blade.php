@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-pencil-square"></i> Update Lead</h1>
        </div>
        <div class="col-lg-2">
            <nav>
                <ol class="breadcrumb">
                    {{-- <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{route('backend.view-client')}}">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </li> --}}

                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body pb-0 m-4">
                    @if(Session::has('success'))
                    <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                        {{Session::get('success')}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="msg"></div>
                    <form method="post" action="{{route('lead.update-ajax',['clieid'=>Crypt::encrypt($edit_client->id)])}}">
                        @csrf
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label> Name<span class="text-danger">*</span></label>
                                    <input type="text" name="client_name" class="form-control" value="{{$edit_client->client_name}}" placeholder="name">
                                    <span class="text-danger">@error('client_name') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Company Name<span class="text-danger">*</span></label>
                                    <input type="text" name="company_name" class="form-control" value="{{$edit_client->company_name}}" placeholder="company name">
                                    <span class="text-danger">@error('company_name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Email </label>
                                    <input type="email" name="email" class="form-control" value="{{$edit_client->email}}" placeholder="@gmail.com">
                                    <span class="text-danger">@error('email') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <input type="number" name="phone" class="form-control" value="{{$edit_client->phone}}" placeholder="+91">
                                    <span class="text-danger">@error('phone') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control" value="{{$edit_client->address}}" placeholder="address">
                                    <span class="text-danger">@error('address') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Meeting Date <span class="text-danger">*</span></label>
                                    <input type="date" name="meating_date" class="form-control" value="{{$edit_client->meating_date}}">
                                    <span class="text-danger">@error('meating_date') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Meating Time <span class="text-danger">*</span></label>
                                    <input type="time" name="meating_time" class="form-control" value="{{$edit_client->meating_time}}">
                                    <span class="text-danger">@error('meating_time') {{$message}} @enderror</span>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Type Of User <span class="text-danger">*</span></label>
                                    @php $userType=['1'=>'Manager','2'=>'Marketing','3'=>'BDE']; @endphp
                                    <select id="typeofuser" class="form-select" name="typeofuser">
                                        <option value="0">Select user...</option>
                                        @if(isset($userType) && !empty($userType))
                                        @foreach($userType as $key=>$row)
                                        <option {{($edit_client->typeofuser == $key)?'selected':''}} value="{{$key}}">{{$row}}</option>
                                        @endforeach
                                        @endif

                                    </select>
                                    <span class="text-danger">@error('typeofuser') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Assign Meating <span class="text-danger">*</span></label>
                                    <select id="assign_meating" name="assign_meating" class="form-control">

                                        {{-- @foreach ($employeedata as $key => $val)

                                        <option value="{{$val->id}}">{{$val->firstname}} {{$val->lastname}}</option>
                                            
                                        @endforeach --}}

                                        @foreach ($employeedata as $key => $val)
                      <option value="{{ $val->id }}" {{ $val->id == $edit_client->assign_meating ? 'selected' : '' }}>
                        {{ $val->firstname }} {{ $val->lastname }}
                        </option>
                                @endforeach


                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Client Potential </label>
                                    @php
                                    $client_status=['1'=>'Height','2'=>'Moderate','3'=>'Low'];
                                    @endphp
                                    <select name="client_potential" class="form-control">
                                        <option value="0">None</option>
                                        @if(isset($client_status) && !empty($client_status))
                                        @foreach($client_status as $key=>$row)
                                        <option @if(isset($edit_client->client_potential) && $edit_client->client_potential==$key) {{'selected'}} @endif value="{{$key}}">{{$row}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <span class="text-danger">@error('client_potential') {{$message}} @enderror</span>

                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group m-2">
                                    <label>Remark </label>
                                    <textarea class="form-control" name="remark">{{$edit_client->remark}}</textarea>

                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary"> Update Lead</button>
                            </div>
                        </div>
                    </form>
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
            url: "{{url('admin/select-service-getprice')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": getId
            },
            success: function(response) {
                console.log(response.data);
                if (response.status == 200) {
                    $(".service-price").val(response.data);

                } else {
                    $(".service-price").val(0);
                    $(".msg").html('<div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">Please select company service.<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                }
            }
        });
    });
    ////////////////////////SELECT2/////////////////////////////////

    ///////////////////////////TYPE OF USER////////////////////////////////////////////////////////
    // $("#typeofuser").change(function() {
    //     var getId = $(this).val();
    //     $('#assign_meating').find('option').remove();
    //     $.ajax({
    //         type: 'POST',
    //         url: "{{route('backend.client.type-of-user')}}",
    //         data: {
    //             "_token": "{{ csrf_token() }}",
    //             "id": getId
    //         },
    //         success: function(response) {
    //             if (response.status == 100) {
    //                 $.each(response.data, function(key, item) {
    //                     let option = '<option value ="' + item.id + '">' + item.name + '</option>';
    //                     $('#assign_meating').append(option);
    //                 });
    //             } else if (response.status == 200) {
    //                 $.each(response.data, function(key, item) {
    //                     let option = '<option value ="' + item.id + '">' + item.firstname + ' ' + item.lastname + '</option>';
    //                     $('#assign_meating').append(option);
    //                 });
    //             } else if (response.status == 300) {
    //                 $.each(response.data, function(key, item) {
    //                     let option = '<option value ="' + item.id + '">' + item.bde_name + '</option>';
    //                     $('#assign_meating').append(option);
    //                 });
    //             }
    //         }
    //     });
    // }).trigger("change");

    /////////////////////////////END TYPE OF USER//////////////////////////////////////////////////////////

    $(document).ready(function() {
        $('.select2').select2({
            closeOnSelect: false
        });
    });
</script>

@endpush