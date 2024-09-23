
@extends('managerend.layout.master')

@section('content')


<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1><i class="bi bi-card-list"></i> Hiring</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{route('add_divice')}}"><i class="bi bi-plus-circle"></i> Add</a></li>
                    {{-- <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{route('archiveemployee')}}"><i class="bi bi-archive"></i> Archive</a></li> --}}
                    <li class="p-1"><a href="{{ url()->previous() }}" class="btn btn-success btn-sm text-white"><i class="bi bi-arrow-left" ></i> Back</a></li>
                </ol>
            </nav>
        </div>
    </div>


</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body pb-0">

                    @if(Session::has('success'))
                    <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                        {{Session::get('success')}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                </div>
                <div class="m-2">


                    <table id="dtBasicExample" class="table table-responsive dataTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>DOB</th>
                                <th>Address</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>


                </div>

            </div>

        </div>
    </div>
</section>
<!-- Basic Modal -->


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

                    <form method="POST" action="" id="createform" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Name">
                                    <span class="name-error" id="name-error">@error('Asset') {{$message}} @enderror</span>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Phone </label>
                                    <input type="text" name="phone" class="form-control" value="{{old('phone')}}" placeholder="phone">
                                    <span class="phone-error" id="phone-error">@error('Name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Email<span class="text-danger">*</span></label>
                                    <input type="text" name="email" class="form-control" value="" placeholder="email">
                                    <span class="email-error" id="email-error">@error('Model') {{$message}} @enderror</span>
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>DOB <span class="text-danger">*</span></label>
                                    <input type="date" name="dob" class="form-control" value="{{old('dob')}}" placeholder="dob">
                                    <span class="text-danger" id="dob-error">@error('Serial') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Country <span class="text-danger">*</span></label>
                                    <input type="text" name="country" class="form-control" value="{{old('country')}}" placeholder="country">
                                    <span class="country-error" id="country-error">@error('address') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>City	 <span class="text-danger">*</span></label>
                                    <input type="text" name="city" class="form-control" value="{{old('city')}}" placeholder="city">
                                    <span class="city-error" id="city-error">@error('Location') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>State <span class="text-danger">*</span></label>
                                    <input type="text" name="state" class="form-control" value="{{old('state')}}" placeholder="state">
                                    <span class="state-error" id="state">@error('state') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control" value="{{old('address')}}" placeholder="address">
                                    <span class="address-error" id="address-error">@error('address') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Pincode <span class="text-danger">*</span></label>
                                    <input type="text" name="pincode" class="form-control" value="{{old('address')}}" placeholder="pincode">
                                    <span class="pincode-error" id="address-error">@error('address') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Documents <span class="text-danger">*(pdf only)</span></label>
                                    <input type="file" name="doc" class="form-control" value="{{old('address')}}" placeholder="address">
                                    <span class="doc-error" id="address-error">@error('address') {{$message}} @enderror</span>
                                </div>
                            </div>
                           

                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary" id="save">Save</button>
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
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

<script type="text/javascript">

$(function() {
        var i = 1;
        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('assest-viewDevice') }}",

            dom: 'Blfrtip',
            buttons: [{
                    extend: 'pdf',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'excel',
                }
            ],

            columns: [{
                    data: 'id',
                },
                {
                    data: 'employee',
                },
                {
                    data: 'asset_id',
                },
                {
                    data: 'name',
                },
                {
                    data: 'modal',
                },
                {
                    data: 'serial',
                },
                {
                    data: 'category',
                },
                {
                    data: 'action',
                },
            ]
        });
    });

    $('#save').on('click' , function(e){

        e.preventDefault();
        // alert('hello');

        Swal.fire({
                     title: "Please wait...",
                     html: "Processing ...",
                     customClass: {
 popup: 'custom-swal-width-height',
 title: 'custom-swal-title',
 htmlContainer: 'custom-swal-text',
 icon: 'custom-swal-icon'
}
                 })

                 Swal.showLoading();

                 var formdata = new FormData($('#createform')[0]);

                 console.log(formdata);

                 $.ajax({

url : "{{route('hiring-save')}}",
type : "POST",
headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
data : formdata,
contentType: false, 
processData: false,
success : function(response){
    // console.log(response);

    if(response.status == "success"){

Swal.fire({
title: 'Success!',
text: 'Clarification submitted successfully',
icon: 'success',
confirmButtonText: 'OK'
}).then((result) => {
if (result.isConfirmed) {
//    table.ajax.reload();
window.location.reload();
// window.reload.location();



}
});

}


if(response.status == "error"){

$.each(response.message, function(field, message) {
            $('#' + field).addClass('is-invalid');
            $('#' + field + '-error').text(message).addClass('text-danger');
        });

Swal.fire({
title: 'error!',
text: 'Ops!',
icon: 'success',
confirmButtonText: 'OK'
}).then((result) => {
if (result.isConfirmed) {
//    table.ajax.reload();
window.reload.location();
  



}
});

}

}

});

    });

    $('body').on('click' , '.delete' , function(){
        var id = $(this).attr('data-id');
        // alert(id);

        Swal.fire({
        title: 'Confirm Submission',
          text: 'Are you sure you want to Delete the record?',
          icon: 'question',
                    customClass: {
    popup: 'custom-swal-width-height',
    title: 'custom-swal-title',
    htmlContainer: 'custom-swal-text',
    icon: 'custom-swal-icon'
  }
                }).then(function(result) {
                    if (result.isConfirmed) {


                        Swal.fire({
                        title: "Please wait...",
                        html: "Processing ...",
                        customClass: {
    popup: 'custom-swal-width-height',
    title: 'custom-swal-title',
    htmlContainer: 'custom-swal-text',
    icon: 'custom-swal-icon'
  }
                    })
                    Swal.showLoading();

                    $.ajax({
                        url : "{{route('assest-delete')}}",
                        type : "GET",
                        data : {id : id},
                        success : function(response){

                            if(response.status == "success"){

                                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Delete Successfully.',
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

                        }
                    });

                }
            });


    });

    //////////////////////////////////////////////////////////////////////

</script>
@endpush