@extends('backend.layout.master')

@section('content')

<style>
      .dataTable {
            width: 100% !important;
        }
        section .dashboard{
            width: 100% !important;
        }
        .dataTable thead th {
            background-color: #fff;
        }
         .dataTable tbody td {
            background-color: #fff;
        }
</style>

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1><i class="bi bi-card-list"></i> Agent</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{route('admin-Add-agent')}}"><i class="bi bi-plus-circle"></i> Add</a></li>
                    {{-- <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{route('archiveemployee')}}"><i class="bi bi-archive"></i> Archive</a></li> --}}
                    <li class="p-1"><a href="{{ url()->previous() }}" class="btn btn-success btn-sm text-white"><i class="bi bi-arrow-left" ></i> Back</a></li>
                </ol>
            </nav>
        </div>
    </div>


</div><!-- End Page Title -->

<section class="section dashboard " width="100%">
    <div class="row">
        <div class="col-lg-12" >
            <div class="card" >
                <div class="card-body pb-0" >

                    @if(Session::has('success'))
                    <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                        {{Session::get('success')}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                </div>
                {{-- <form id="importForm" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="text-center">
                        <label for="file" class="btn btn-primary">
                            Browse Excel Format
                            <input type="file" name="file" id="file" class="d-none" accept=".xls, .xlsx">
                        </label>
                    </div>
                </form> --}}

                    <table id="dtBasicExample" class="table table-responsive dataTable"  style="width:100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                {{-- <th>Staff Id</th> --}}
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Employee Name</th>
                                <th>Project Name</th>
                                <th>District</th>
                                <th>State</th>
                                <th>Address</th>
                                <th>Pincode</th>
                                <th>Rrn No.</th>
                                <th>Lead Sourse</th>
                                <th>aadhar_card</th>
                                <th>pan_card</th>
                                <th>Paument Recieved</th>
                                <th>Payment Due</th>
                                <th style="width: 100% !important;">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

            </div>
            
                </div>

            </div>

</section>
<!-- Basic Modal -->

<div class="modal fade" id="basicModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Marketing Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><b>Staff ID :</b> <span class="staffid"></span> </p>
                <p><b>Staff Role :</b> <span class="staff_role"></span> </p>
                <p><b>First Name :</b> <span class="firstname"></span> </p>
                <p><b>Last Name :</b> <span class="lastname"></span> </p>
                <p><b>Phone :</b> <span class="phone"></span> </p>
                <p><b>Email :</b> <span class="email"></span> </p>
                <p><b>Joining Date :</b> <span class="joining_date"></span> </p>
                <p><b>Address:</b> <span class="address"></span> </p>
                <p><b>City : </b> <span class="city"></span> </p>
                <p><b>Pincode : </b> <span class="pincode"></span> </p>
                <p><b>State :</b> <span class="state"></span> </p>
                <p><b>Create Date :</b> <span class="created_date"></span> </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>

            </div>
        </div>
    </div>
</div>
<!-- End Basic Modal-->

<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
    Launch demo modal
  </button> --}}
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Select Email Letter</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">


          <form action="" method="POST" id="sendletterform">
            @csrf

            <div class="col-lg-12">
                <div class="form-group m-2">
                    <label>Select Letter </label>
                    <input type="hidden" name="senduerid" class="form-control" id="senduerid" value="" accept="application/pdf">

                    <select name="template" id="template" class="form-control">
                       
                        <option value="">select Letter</option>
                        <option value="1">Welcome Letter</option>
                        <option value="2">Terminate Letter</option>

                    </select>

                    <span class="text-danger">@error('document_file') {{$message}} @enderror</span>
                </div>
            </div>

          </form>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="send">Send</button>
        </div>
      </div>
    </div>
  </div>


  


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


<script>
  $(document).ready(function () {
    $('#file').on('change', function () {
        var formData = new FormData($('#importForm')[0]);

        $.ajax({
            url: "{{ route('importagents') }}",
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#response').html('<p style="color:green;">' + response.success + '</p>');
            },
            error: function (response) {
                var errors = response.responseJSON.errors;
                var errorHtml = '<ul style="color:red;">';
                $.each(errors, function (key, value) {
                    errorHtml += '<li>' + value[0] + '</li>';
                });
                errorHtml += '</ul>';
                $('#response').html(errorHtml);
            }
        });
    });
});

</script>

<script type="text/javascript">



$('body').on('click' , '.send' , function(){

    //  alert('hello');

    var id = $(this).attr('data-id');
    // alert(id);

    $('#senduerid').val(id);

    var modalId = $('#exampleModalCenter').modal('show');

});


$('#template').change(function(){
    // alert('hello');

    var template = $(this).val();

    var formdata = $('#sendletterform').serialize();

    // alert(template);

    $(document).on('click' , '#send' , function(){

    Swal.fire({
        title: 'Confirm Submission',
          text: 'Are you sure you want to Send the letter?',
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
                        url : "{{route('send-letter')}}",
                        type : "GET",
                        data : formdata,
                        success : function(response){
                            // console.log(response);

                            if(response.status == 'success'){

Swal.fire({
icon: 'success',
title: 'Success!',
text: 'Send Mail Successfully.',
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

if (response.status == 'error') {
                                Swal.close();
                  $('.loader-container').hide();
                  $.each(response.message, function(field, message) {
                  $('#' + field).addClass('is-invalid');
                  $('#' + field + '_error').text(message).addClass('text-danger');
              }); 

              
}

                        }
                    });

                }
            });

        });

});


    $(function() {
        var i = 1;
        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            // scrollY: '800px',
            // scrollCollapse: true, 
            ajax: "{{ route('agent-view') }}",

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
                    data: 'name',
                },
                
                {
                    data: 'email',
                },
                {
                    data: 'phone',
                },
                {
                    data: 'employee',//
                },
                 {
                    data: 'project',
                },
                {
                    data: 'district',
                },
                {
                    data: 'state',
                },
                {
                    data: 'document_add',
                },
                {
                    data: 'pincode',
                },
                {
                    data: 'staff_id',
                },
                {
                    data: 'lead_source',
                },
                {
                    data: 'aadhar_card',
                },
                {
                    data: 'pan_card',
                },
                {
                    data: 'payment_re',
                },
                {
                    data: 'payment_due',
                },
                {
                    data: 'action',
                },
            ],
            
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
                        url : "{{route('deleteagent')}}",
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

    $(document).on('click', '.marketing', function() {
        var dataId = $(this).attr("data-id");
        $.ajax({
            type: 'POST',
            url: "{{url('manager/view-details-market-mteam')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": dataId
            },
            success: function(response) {
                $("#basicModal").modal('show');
                $(".firstname").text(response.data.firstname);
                $(".lastname").text(response.data.lastname);
                $(".email").text(response.data.email);
                $(".phone").text(response.data.phone);
                $(".joining_date").text(response.data.joining_date);
                $(".address").text(response.data.address);
                $(".city").text(response.data.city);
                $(".pincode").text(response.data.pincode);
                $(".state").text(response.data.state);
                $(".staffid").text(response.data.staff_id);
                $(".staff_role").text(response.data.staff_role);
                $(".created_date").text(response.data.created_date);

            }
        });

    });
</script>
@endpush