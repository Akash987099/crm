@extends('employee.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1>Add Agent</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{route('agent-master')}}"><i class="bi bi-list"></i> View</a></li>
                    <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{url('manager/archive-market-mteam')}}"><i class="bi bi-archive"></i> Archive</a></li>
                    <li class="p-1"><a href="{{ url()->previous() }}" class="btn btn-success btn-sm text-white"><i class="bi bi-arrow-left" ></i> Back</a></li>
                    
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section dashboard">

    {{-- {{dd($agent)}} --}}

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

                    <form method="post" action="{{route('updateagents')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{$agent->id}}" name="id">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{$agent->name}}" placeholder="Full name">
                                    <span class="text-danger">@error('name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Contact No. </label>
                                    <input type="number" maxlength="10" name="contact" class="form-control" value="{{$agent->contact}}" placeholder="contact">
                                    <span class="text-danger">@error('contact') {{$message}} @enderror</span>
                                </div>
                            </div>
                           
                            
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Email Id. <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{$agent->email}}" placeholder="@gmail.com">
                                    <span class="text-danger">@error('email') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>District <span class="text-danger">*</span></label>
                                    <input type="text" name="District" class="form-control" value="{{$agent->district}}" placeholder="District">
                                    <span class="text-danger">@error('District') {{$message}} @enderror</span>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Aadhar Address <span class="text-danger">*</span></label>
                                    <input type="text" name="adharaddress" class="form-control" value="{{$agent->document_add}}" placeholder="Aadhar Address">
                                    <span class="text-danger">@error('adharaddress') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>State <span class="text-danger">*</span></label>
                                    <input type="text" name="State" class="form-control" value="{{$agent->state}}" placeholder="State">
                                    <span class="text-danger">@error('State') {{$message}} @enderror</span>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Project Name <span class="text-danger">*</span></label>
                                    {{-- <input type="text" name="Project" class="form-control" value="{{$agent->projectname}}" placeholder="Project" readonly> --}}
                                    <select name="Project" id="" class="form-control">
                                        @foreach ($product as $key => $val)
                                            <option value="{{$val->id}}" {{ $agent->project == $val->id ? 'selected' : '' }}>{{$val->name}}</option>
                                        @endforeach
                                    </select>
                                    
                                    <span class="text-danger">@error('Project') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Employee Name <span class="text-danger">*</span></label>
                                    <input type="text" name="Employee" class="form-control" value="{{$agent->employee}}" placeholder="Employee">
                                    <span class="text-danger">@error('Employee') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>RRN No. <span class="text-danger">*</span></label>
                                    <input type="text" name="RRN" class="form-control" value="{{$agent->rrn_no}}" placeholder="RRN">
                                    <span class="text-danger">@error('RRN') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Payment Recieved <span class="text-danger">*</span></label>
                                    <input type="number" name="Payment" class="form-control" value="{{$agent->payment_re}}" placeholder="Payment">
                                    <span class="text-danger">@error('Payment') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Payment Due <span class="text-danger">*</span></label>
                                    <input type="number" name="Due" class="form-control" value="{{$agent->payment_due}}" placeholder="Due">
                                    <span class="text-danger">@error('Due') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <h4>Documents</h4>

                            <hr>
                            
                            @if($document_name == 0)
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
                            @else
                            
                            <div id="document-container">
                                <div class="row">
                                    @foreach($document_name as $index => $name)
                                        <div class="col-lg-6">
                                            <div class="form-group m-2">
                                                <label>Document <span class="text-danger">*</span></label>
                                                <input type="text" name="aadharcard[]" class="form-control" value="{{ $name }}" placeholder="Document">
                                                <span class="text-danger">@error('state') {{ $message }} @enderror</span>
                                            </div>
                                        </div>
                                    
                                        <div class="col-lg-6">
                                            <div class="form-group m-2">
                                                <label>Document (pdf)</label>
                                                <input type="hidden" name="documental" value="{{ asset($documents[$index]['file_path']) }}" class="form-control">
                                                <input type="file" name="aadhar[]" value="{{ asset($documents[$index]['file_path']) }}" class="form-control">
                                                @if(isset($documents[$index]) && isset($documents[$index]['file_path']))
                                                <!--<img src="{{ asset('public/') }}/{{$documents[$index]['file_path']}}">-->
                                                    <iframe src="{{ asset('public/') }}/{{$documents[$index]['file_path']}}" width="100%" height="200px"></iframe>
                                                    <a href="{{ asset('public/') }}/{{$documents[$index]['file_path']}}">Click Here</a>
                                                @else
                                                    <p>No document available</p>
                                                @endif
                                                <span class="text-danger">@error('document_file') {{ $message }} @enderror</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            @endif

                            
                            
                            
                                                    

                            @if($view == 2)

                            

                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-primary mt-3" onclick="addDocumentFields()">Add Document</button>
                                </div>
                            </div>

                        </div>
<br>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    @endif

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