@extends('managerend.layout.master')

@section('content')

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1>Add Device</h1>
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

                    @if(Session::has('error'))
                    <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                        {{Session::get('error')}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form method="post" action="{{route('adddivice')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Asset id <span class="text-danger">*</span></label>
                                    <input type="text" name="Asset" class="form-control" value="{{old('Asset')}}" placeholder="Asset id">
                                    <span class="text-danger">@error('Asset') {{$message}} @enderror</span>
                                </div>
                            </div>

                            @foreach ($employee as $key => $value)

                            <input type="hidden" value="{{$value->id}}" name="emp_id" hidden>
                            @endforeach

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Employee Name </label>
                                    <select name="employee" id="" class="form-control">
                                        <option value="">select employee</option>
                                        @foreach ($employee as $key => $value)
                                        <option value="{{$value->id}}">{{$value->firstname}}&nbsp; {{$value->lastname}}</option>
                                            
                                        @endforeach
                                    </select>
                                    <span class="text-danger">@error('Name') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Name </label>
                                    <input type="text" name="Name" class="form-control" value="{{old('Name')}}" placeholder="Name">
                                    <span class="text-danger">@error('Name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Model Number	 <span class="text-danger">*</span></label>
                                    <input type="text" name="Model" class="form-control" value="" placeholder="Model">
                                    <span class="text-danger">@error('Model') {{$message}} @enderror</span>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Serial Numbe <span class="text-danger">*</span></label>
                                    <input type="text" name="Serial" class="form-control" value="{{old('Serial')}}" placeholder="Serial">
                                    <span class="text-danger">@error('Serial') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Category	Status <span class="text-danger">*</span></label>
                                    <input type="text" name="Category" class="form-control" value="{{old('Category')}}" placeholder="Category">
                                    <span class="text-danger">@error('Category') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Location	 <span class="text-danger">*</span></label>
                                    <input type="text" name="Location" class="form-control" value="{{old('Location')}}" placeholder="location">
                                    <span class="text-danger">@error('Location') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Purchase Date <span class="text-danger">*</span></label>
                                    <input type="date" name="Purchase" class="form-control" value="{{old('Purchase')}}" placeholder="Purchase">
                                    <span class="text-danger">@error('Purchase') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Purchased From <span class="text-danger">*</span></label>
                                    <input type="text" name="Purchased" class="form-control" value="{{old('Purchased')}}" placeholder="Purchased from">
                                    <span class="text-danger">@error('Purchased') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Purchase Price <span class="text-danger">*</span></label>
                                    <input type="text" name="Price" class="form-control" value="{{old('Price')}}" placeholder="Price">
                                    <span class="text-danger">@error('Price') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Warranty Length <span class="text-danger">*</span></label>
                                    <input type="Warranty" name="warranty" class="form-control" value="{{old('warranty')}}" placeholder="warranty">
                                    <span class="text-danger">@error('warranty') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status">
                                        <option value="">select status</option>
                                        <option value="1">in use</option>
                                        <option value="2">Available</option>
                                        <option value="3">Out for repair</option>
                                        <option value="4">Broken/unfixable</option>
                                    </select>
                                    {{-- <input type="text" name="status" class="form-control" value="{{old('warranty')}}" placeholder="Staus"> --}}
                                    <span class="text-danger">@error('status') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group m-2">
                                    <label>Notes <span class="text-danger">*</span></label>
                                    {{-- <input type="password" name="Notes" class="form-control" value="{{old('Notes')}}" placeholder="Notes"> --}}
                                    <textarea id="" name="Notes" class="form-control" ></textarea>
                                    <span class="text-danger">@error('Notes') {{$message}} @enderror</span>
                                </div>
                            </div>

                            
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Doc. Upload </label>
                                    <input type="file" name="image" class="form-control" value="{{old('image')}}" >
                                    <span class="text-danger">@error('image') {{$message}} @enderror</span>
                                </div>
                            </div>

                          

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