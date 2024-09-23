@extends('employee.master')
@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-plus-circle-fill"></i> Add Lead</h1>
        </div>
        <div class="col-lg-2">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{route('backend.view-client')}}">
                            <i class="bi bi-card-list"></i> View Lead
                        </a>
                    </li>

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

                    {{-- action="{{route('backend.client-submit')}}" --}}
                    <form method="POST" enctype="multipart/form-data" id="addformdata">
                        @csrf
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label> Name<span class="text-danger">*</span></label>
                                    <input type="text" name="client_name" class="form-control" value="{{old('client_name')}}" placeholder="name">
                                    <span id="client_name-danger" class="client_name-danger">@error('client_name') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Shop Name<span class="text-danger">*</span></label>
                                    <input type="text" name="company_name" class="form-control" value="{{old('company_name')}}" placeholder="Shop name">
                                    <span id="company_name-danger" class="company_name-danger">@error('company_name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Email </label>
                                    <input type="text" name="email" class="form-control" value="{{old('email')}}" placeholder="@gmail.com">
                                    <span id="email-danger" class="email-danger">@error('email') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <input type="number" name="phone" class="form-control" value="{{old('phone')}}" placeholder="+91">
                                    <span id="phone-danger" class="phone-danger">@error('phone') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control" value="{{old('address')}}" placeholder="address">
                                    <span class="text-danger">@error('address') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Meating Time <span class="text-danger">*</span></label>
                                    <input type="time" name="meating_time" class="form-control" value="{{old('meating_time')}}">
                                    <span class="text-danger">@error('meating_time') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Date <span class="text-danger">*</span></label>
                                    <input type="date" name="meating_date" class="form-control" value="{{old('meating_date')}}">
                                    <span id="meating_date-danger" class="text-danger">@error('meating_date') {{$message}} @enderror</span>
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
                                        <option value="{{$key}}">{{$row}}</option>
                                        @endforeach
                                        @endif

                                    </select>
                                    <span id="typeofuser-danger" class="text-danger">@error('meating_date') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Assign Meating <span class="text-danger">*</span></label>
                                    <select name="assign_meating" class="form-control assign_meating">
                                    <option value="">Select Assign Lead</option>

                                    @foreach ($employeedata as $key => $val)

                                    <option value="{{$val->id}}">{{$val->firstname}} {{$val->lastname}}</option>
                                    
                                    @endforeach

                                </select>
                                <span id="assign_meating-danger"></span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Client Potential </label>
                                    @php
                                    $client_status=['1'=>'Height','2'=>'Moderate','3'=>'Low'];
                                    @endphp
                                    <select name="client_potential" class="form-control">
                                        @if(isset($client_status) && !empty($client_status))
                                        @foreach($client_status as $key=>$row)
                                        <option value="{{$key}}">{{$row}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <span id="client_potential-danegr" class="text-danger">@error('status') {{$message}} @enderror</span>

                                </div>
                            </div>

                            {{-- <div class="col-lg-12">
                                <div class="form-group m-2">
                                    <label>Image</label>
                                    <br>
                                    <a class="text-white btn btn-primary btn-sm addbutton from-control" href="javascript:void(0);"> Image</a>
                                    
                                </div>
                            </div> --}}

                            <div class="col-lg-12">
                                <div class="form-group m-2">
                                    <label>Remark </label>
                                    <textarea class="form-control" name="remark">{{old('remark')}}</textarea>

                                </div>
                            </div>

                           


                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <a class="text-white btn btn-primary btn-sm addbutton from-control" href="javascript:void(0);"> Save</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Capture Photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="dashboard">
                    <select id="cameraSelect" class="form-control mb-2">
                        <option value="user">Front Camera</option>
                        <option value="environment">Back Camera</option>
                    </select>
                    <video id="video" autoplay style="width: 100%; height:100%;"></video>
                    <canvas id="canvas" style="width: 100%; height:100%; display:none;"></canvas>
                </div>
            </div>
            <div class="modal-footer">
                <button id="capture" class="btn btn-secondary">Capture Photo</button>
                <button id="recapture" style="display:none;" class="btn btn-secondary">Recapture Photo</button>
                <button id="upload" style="display:none;" class="btn btn-secondary">Upload Photo</button>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.js"></script>


<script>

$('.addbutton').click(function() {
            $('#exampleModalCenter').modal('show');
            const cameraSelect = $('#cameraSelect').val();
            startCamera(cameraSelect);
        });

    $(document).ready(function() {
        let stream;
        const video = $('#video')[0];
        const canvas = $('#canvas')[0];
        const captureButton = $('#capture');
        const recaptureButton = $('#recapture');
        const uploadButton = $('#upload');
        const imageInput = $('<input>').attr('type', 'hidden').attr('name', 'image').attr('id', 'image');
    
        function startCamera(cameraFacing) {
            navigator.mediaDevices.getUserMedia({
                video: { facingMode: cameraFacing }
            })
            .then(s => {
                stream = s;
                video.srcObject = stream;
            })
            .catch(err => {
                console.error("Error accessing the camera: ", err);
            });
        }
    
        $('.addbutton').click(function() {
            $('#exampleModalCenter').modal('show');
            const cameraSelect = $('#cameraSelect').val();
            startCamera(cameraSelect);
        });
    
        $('#cameraSelect').change(function() {
            const cameraSelect = $(this).val();
            if (stream) {
                stream.getTracks().forEach(track => track.stop()); 
            }
            startCamera(cameraSelect);
        });
    
        captureButton.click(function() {
            canvas.width = video.videoWidth; 
            canvas.height = video.videoHeight; 
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = canvas.toDataURL('image/png');
            imageInput.val(imageData);
            $('body').append(imageInput);
    
            video.style.display = 'none';
            canvas.style.display = 'block';
            captureButton.hide();
            recaptureButton.show();
            uploadButton.show();
        });
    
        // Recapture photo
        recaptureButton.click(function() {
            video.style.display = 'block';
            canvas.style.display = 'none';
            captureButton.show();
            recaptureButton.hide();
            uploadButton.hide();
        });
    
        uploadButton.click(function() {

            var formdata = $('#addformdata').serializeArray();
            formdata.push({ name: 'image', value: imageInput.val() });
            $.ajax({
                url: '{{ route('backend.client-submit') }}',
                type: 'POST',
                data: formdata ,
                success: function(response) {
                  
                    console.log(response.status);
                    
                    if(response.status == "success"){

                        Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Thank You!!.',
                    customClass: {
    popup: 'custom-swal-width-height',
    title: 'custom-swal-title',
    htmlContainer: 'custom-swal-text',
    icon: 'custom-swal-icon'
  }
                }).then(function(result) {
                    if (result.isConfirmed) {
                window.location.reload();
                    }
                });


                    }
                    
                    if(response.status == "error"){
                        alert('hello')
                        $.each(response.message, function(field, message) {
                            $('#exampleModalCenter').modal('hide');
                                    $('#' + field).addClass('is-invalid');
                                    $('#' + field + '-danger').text(message).addClass('text-danger');
                                });
                    }

                },
                error: function(xhr) {
                    console.error('Error uploading image:', xhr);
                }
            });
        });
    });
    </script>

@endsection

@push('footer-script')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" /> --}}



<script>
    // $(".services").change(function() {
    //     var getId = $(this).val();
    //     $.ajax({
    //         type: 'POST',
    //         url: "",
    //         data: {
    //             "_token": "{{ csrf_token() }}",
    //             "id": getId
    //         },
    //         success: function(response) {
    //             console.log(response.data);
    //             if (response.status == 200) {
    //                 $(".service-price").val(response.data);

    //             } else {
    //                 $(".service-price").val(0);
    //                 $(".msg").html('<div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">Please select company service.<button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button></div>');
    //             }
    //         }
    //     });
    // });
    ///////////////////////SELECT2/////////////////////////////

    ///////////////////////////TYPE OF USER////////////////////////////////////////////////////////
    $("#typeofuser").change(function() {
        var getId = $(this).val();
        $('.assign_meating').find('option').remove();
        $.ajax({
            type: 'POST',
            url: "{{route('backend.client.type-of-user')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": getId
            },
            success: function(response) {
                if (response.status == 100) {
                    $.each(response.data, function(key, item) {
                        let option = '<option value ="' + item.id + '">' + item.name + '</option>';
                        $('.assign_meating').append(option);
                    });
                } else if (response.status == 200) {
                    $.each(response.data, function(key, item) {
                        let option = '<option value ="' + item.id + '">' + item.firstname + ' ' + item.lastname + '</option>';
                        $('.assign_meating').append(option);
                    });
                } else if (response.status == 300) {
                    $.each(response.data, function(key, item) {
                        let option = '<option value ="' + item.id + '">' + item.bde_name + '</option>';
                        $('.assign_meating').append(option);
                    });
                }
            }
        });
    });

    /////////////////////////////END TYPE OF USER//////////////////////////////////////////////////////////

    $(document).ready(function() {
        $('.select2').select2({
            closeOnSelect: false
        });
    });
</script>

@endpush