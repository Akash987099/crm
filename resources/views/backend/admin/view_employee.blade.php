@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1>Add Employee</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    {{-- <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{url('manager/view-market-mteam')}}"><i class="bi bi-list"></i> View</a></li> --}}
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

                    <form method="post" action="{{route('adminupdateemp')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="updateid" value="{{$data->id}}">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="firstname" class="form-control" value="{{$data->firstname}}" placeholder="first name">
                                    <span class="text-danger">@error('firstname') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Last Name </label>
                                    <input type="text" name="lastname" class="form-control" value="{{$data->lastname}}" placeholder="last name">
                                    <span class="text-danger">@error('lastname') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Staff Id <span class="text-danger">*</span></label>
                                    <input type="text" name="staff_id" class="form-control" value="{{$data->staffid}}" placeholder="Staff id">
                                    <span class="text-danger">@error('staff_id') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Staff Designation <span class="text-danger">*</span></label>

                                    <select name="designation" class="form-control">
                                        @foreach ($Designation as $key => $val)
                                            <option value="{{ $val->id }}" {{ $val->id == $data->desigantion_id ? 'selected' : '' }}>{{ $val->Designation }}</option>
                                        @endforeach
                                    </select>                                    

                                    <span class="text-danger">@error('staff_role') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Assign Employee <span class="text-danger">*</span></label>
                                    <!-- <input type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="@gmail.com"> -->
                                     <select name="assignuser" id="" class="form-control">

                                     @foreach ($manager as $key => $val)

                                       <option value="{{$val->id}}">{{$val->name ?? ''}} ({{$val->email ?? ''}})</option>
    
                                    @endforeach

                                     </select>
                                    <span class="text-danger">@error('email') {{$message}} @enderror</span>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{$data->email}}" placeholder="@gmail.com">
                                    <span class="text-danger">@error('email') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Phone <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control" value="{{$data->phone}}" placeholder="91+">
                                    <span class="text-danger">@error('phone') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Date Of Joining <span class="text-danger">*</span></label>
                                    <input type="date" name="joining_date" class="form-control" value="{{$data->joinningdate}}">
                                    <span class="text-danger">@error('joining_date') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control" value="{{$data->address}}" placeholder="address">
                                    <span class="text-danger">@error('address') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>City <span class="text-danger">*</span></label>
                                    <input type="text" name="city" class="form-control" value="{{$data->city}}" placeholder="city">
                                    <span class="text-danger">@error('city') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Picode <span class="text-danger">*</span></label>
                                    <input type="text" name="pincode" class="form-control" value="{{$data->pincode}}" placeholder="pincode">
                                    <span class="text-danger">@error('pincode') {{$message}} @enderror</span>
                                </div>
                            </div>

                            {{-- <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" value="{{old('password')}}" placeholder="password">
                                    <span class="text-danger">@error('password') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control" value="{{old('password_confirmation')}}" placeholder="password">
                                    <span class="text-danger">@error('password_confirmation') {{$message}} @enderror</span>
                                </div>
                            </div> --}}

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>State <span class="text-danger">*</span></label>
                                    <input type="text" name="state" class="form-control" value="{{$data->state}}" placeholder="state">
                                    <span class="text-danger">@error('state') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Image </label>
                                    <input type="file" name="image" class="form-control" value="{{$data->image}}" accept="application/image">
                                    {{-- <img src="{{data->i}}" alt=""> --}}
                                    <iframe src="{{$data->image}}" frameborder="0"></iframe>
                                    <span class="text-danger">@error('document_file') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Aadhar Card <span class="text-danger">*</span></label>
                                    <input type="text" name="aadharcard" class="form-control" value="{{$data->aadhar}}" placeholder="state" readonly>
                                    <span class="text-danger">@error('state') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Aadhar Document</label>
                                    <input type="file" name="aadhar" class="form-control" value="{{$data->aadhardoc}}" >
                                    <iframe src="{{$data->aadhardoc}}" frameborder="0"></iframe>
                                    <span class="text-danger">@error('document_file') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Pancard <span class="text-danger">*</span></label>
                                    <input type="text" name="pan" class="form-control" value="{{$data->pnacard}}" placeholder="Pancard" readonly>
                                    <span class="text-danger">@error('state') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Pan card</label>
                                    <input type="file" name="pancard" class="form-control" value="{{$data->pandoc}}" >
                                    <iframe src="{{$data->pandoc}}" frameborder="0"></iframe>
                                    <span class="text-danger">@error('document_file') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>CTC <span class="text-danger">*</span></label>
                                    <input type="number" maxlength="5" name="CTC" id="CTC" class="form-control" value="{{$data->ctc}}" placeholder="CTC">
                                    <span class="text-danger">@error('CTC') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Monthly Sallery <span class="text-danger">*</span></label>
                                    <input type="text" name="Sallery" id="Sallery" class="form-control" value="{{$data->sallery}}" placeholder="state" readonly>
                                    <span class="text-danger">@error('Sallery') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <h4>Bank Deatils</h4>

                            <hr>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Bank Name <span class="text-danger">*</span></label>
                                    <input type="text" name="bankname" class="form-control" value="{{$data->bank}}" placeholder="state">
                                    <span class="text-danger">@error('state') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Bank Acc. No. <span class="text-danger">*</span></label>
                                    <input type="text" name="accountno" class="form-control" value="{{$data->bankacc}}" placeholder="state">
                                    <span class="text-danger">@error('state') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Ifsc Code. <span class="text-danger">*</span></label>
                                    <input type="text" name="ifsccode" class="form-control" value="{{$data->ifsc}}" placeholder="state">
                                    <span class="text-danger">@error('state') {{$message}} @enderror</span>
                                </div>
                            </div>

                            {{-- <var> --}}
                                <div class="col-lg-6">
                                    <div class="form-group m-2">
                                        <label>Bank Passbook </label>
                                        <input type="file" name="passbook" class="form-control" value="{{$data->bankacc}}" accept="application/pdf">
                                        <iframe src="{{$data->bankdoc}}" frameborder="0"></iframe>
                                        <span class="text-danger">@error('document_file') {{$message}} @enderror</span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group m-2">
                                        <label>Bank Check Book </label>
                                        <input type="file" name="checkbook" class="form-control" value="{{old('document_file')}}" accept="application/pdf">
                                       <iframe src="{{$data->checkbook}}" frameborder="0"></iframe>
                                        <span class="text-danger">@error('document_file') {{$message}} @enderror</span>
                                    </div>
                            {{-- </var> --}}

                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Update</button>
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