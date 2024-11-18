@extends('managerend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1>Add Agent</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{route('Magent')}}"><i class="bi bi-list"></i> View</a></li>
                    {{-- <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{url('manager/archive-market-mteam')}}"><i class="bi bi-archive"></i> Archive</a></li> --}}
                    <li class="p-1"><a href="{{ url()->previous() }}" class="btn btn-success btn-sm text-white"><i class="bi bi-arrow-left" ></i> Back</a></li>
                    
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

                    <form method="post" action="{{route('Maddagents')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Full name">
                                    <span class="text-danger">@error('name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Contact No. </label>
                                    <input type="text" maxlength="10" name="contact" class="form-control" value="{{old('contact')}}" placeholder="contact">
                                    <span class="text-danger">@error('contact') {{$message}} @enderror</span>
                                </div>
                            </div>
                           
                            
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Email Id. <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="@gmail.com">
                                    <span class="text-danger">@error('email') {{$message}} @enderror</span>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Pincode <span class="text-danger">*</span></label>
                                    <input type="text" maxlength="6" id="pincode" name="pincode" class="form-control" value="{{old('pincode')}}" placeholder="Pincode">
                                    <span class="text-danger">@error('pincode') {{$message}} @enderror</span>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>District <span class="text-danger">*</span></label>
                                    <input type="text" id="District" name="District" class="form-control" value="{{old('District')}}" placeholder="District" readonly>
                                    <span class="text-danger">@error('District') {{$message}} @enderror</span>
                                </div>
                            </div>

 <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Aadhar Address <span class="text-danger">*</span></label>
                                    <input type="text" name="adharaddress" class="form-control" value="{{old('adharaddress')}}" placeholder="Aadhar Address">
                                    <span class="text-danger">@error('adharaddress') {{$message}} @enderror</span>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>State <span class="text-danger">*</span></label>
                                    <input type="text" id="State" name="State" class="form-control" value="{{old('State')}}" placeholder="State" readonly>
                                    <span class="text-danger">@error('State') {{$message}} @enderror</span>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Project Name <span class="text-danger">*</span></label>
                                    <select name="Project" id="Project" class="form-control">
                                        <option value="">Select Product</option>
                                        @foreach ($product as $key => $val)
                                        <option value="{{$val->id}}">{{$val->name}}</option>                                            
                                        @endforeach
                                    </select>
                                    {{-- <input type="text" name="Project" class="form-control" value="{{old('Project')}}" placeholder="Project"> --}}
                                    <span class="text-danger">@error('Project') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Employee Name <span class="text-danger">*</span></label>
                                    <input type="text" name="Employee" class="form-control" value="{{old('Employee')}}" placeholder="Employee">
                                    <span class="text-danger">@error('Employee') {{$message}} @enderror</span>
                                </div>
                            </div>
                            
                             <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Pan Card No<span class="text-danger">*</span></label>
                                    <input type="text" name="pancardno" class="form-control" value="{{old('pancardno')}}" placeholder="Pancard Number">
                                    <span class="text-danger">@error('pancardno') {{$message}} @enderror</span>
                                </div>
                            </div>
                            
                              <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Aadhar Card No<span class="text-danger">*</span></label>
                                    <input type="text" name="aadharcardno" class="form-control" value="{{old('aadharcardno')}}" placeholder="Aadhar Card Number">
                                    <span class="text-danger">@error('aadharcardno') {{$message}} @enderror</span>
                                </div>
                            </div>
                            
                              <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Lead Sourse<span class="text-danger">*</span></label>
                                    <input type="text" name="lead" class="form-control" value="{{old('Due')}}" placeholder="lead Source">
                                    <span class="text-danger">@error('lead') {{$message}} @enderror</span>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>RRN No. <span class="text-danger">*</span></label>
                                    <input type="text" name="RRN" class="form-control" value="{{old('RRN')}}" placeholder="RRN">
                                    <span class="text-danger">@error('RRN') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Payment Recieved <span class="text-danger">*</span></label>
                                    <input type="text" name="Payment" class="form-control" value="{{old('Payment')}}" placeholder="Payment">
                                    <span class="text-danger">@error('Payment') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Payment Due <span class="text-danger">*</span></label>
                                    <input type="text" name="Due" class="form-control" value="{{old('Due')}}" placeholder="Due">
                                    <span class="text-danger">@error('Due') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <h4>Documents</h4>

                            <hr>

                           

                            <div id="document-container">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group m-2">
                                            <label>Document <span class="text-danger">*</span></label>
                                            <input type="text" name="aadharcard[]" class="form-control" value="{{old('state')}}" placeholder="Document">
                                            <span class="text-danger">@error('state') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                    
                                    <div class="col-lg-6">
                                        <div class="form-group m-2">
                                            <label>Document (pdf)</label>
                                            <input type="file" name="aadhar[]" class="form-control" value="{{old('document_file')}}" >
                                            <span class="text-danger">@error('document_file') {{$message}} @enderror</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-primary mt-3" onclick="addDocumentFields()">Add Document</button>
                                </div>
                            </div>

                        </div>
<br>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Add User</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>

        <!-- <div class="col-lg-4">
            <div class="card">
                <div class="card-body pb-0">
                    <br>
                    <h4>Change Password </h4>
                    <div class="col-lg-12">
                        <div class="form-group m-2">
                            <label>Password </label>
                            <input type="password" name="password" class="form-control" value="{{old('password')}}" placeholder="Enter password">
                            <span class="text-danger">@error('password') {{$message}} @enderror</span>
                        </div>
                        <div class="form-group m-2">
                            <label>Re-Password </label>
                            <input type="password" name="password" class="form-control" value="{{old('password')}}" placeholder="Re-enter password">
                            <span class="text-danger">@error('password') {{$message}} @enderror</span>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary" name="change_password">Change Password</button>
                    </div>
                    <br>
                </div>
            </div>
        </div> -->

    </div>
    </div>
</section>

@endsection

@push('footer-script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

<script>
    function addDocumentFields() {
        // Get the container where we will append new fields
        var container = document.getElementById('document-container');
    
        // Create a new div for the new document fields
        var newFields = document.createElement('div');
        newFields.classList.add('row');
    
        // Add the new input fields for the document name
        newFields.innerHTML = `
            <div class="col-lg-6">
                <div class="form-group m-2">
                    <label>Document <span class="text-danger">*</span></label>
                    <input type="text" name="aadharcard[]" class="form-control" placeholder="state">
                    <span class="text-danger">@error('state') {{$message}} @enderror</span>
                </div>
            </div>
    
            <div class="col-lg-6">
                <div class="form-group m-2">
                    <label>Document (pdf)</label>
                    <input type="file" name="aadhar[]" class="form-control">
                    <span class="text-danger">@error('document_file') {{$message}} @enderror</span>
                </div>
            </div>
        `;
    
        // Append the new fields to the container
        container.appendChild(newFields);
    }
    </script>

<script>

$(document).on('input' , '#pincode' , function(){
    
      var value = $(this).val();
      
    //   alert(value);
    
    $.ajax({
        url : "{{route('get-pincode')}}",
        type : "GET",
        data : {value : value},
        success : function(response){
            // console.log(response);
            $('#District').val(response.city);
            $('#State').val(response.state);
        }
    });
    
});

$(document).on('input', '#CTC', function() {
            var annualCTC = $(this).val();
            if (annualCTC) {
                var monthlyCTC = (annualCTC / 12).toFixed(2); 
                $('#Sallery').val(monthlyCTC); 
            } else {
                $('#Sallery').text(''); 
            }
        });

    $(document).ready(function() {
        $('.select2').select2({
            closeOnSelect: false
        });
    });
</script>
@endpush