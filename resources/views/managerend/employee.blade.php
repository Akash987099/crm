
@extends('managerend.layout.master')

@section('content')

<style>
    .custom-control.custom-switch {
    display: flex;
    align-items: center;
}

.toggle-text {
    margin-left: 10px; /* Adjust spacing between the switch and the label */
}

</style>

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1><i class="bi bi-card-list"></i> Employee</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{route('manager-add-employee')}}"><i class="bi bi-plus-circle"></i> Add</a></li>
                    <!-- <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{route('archiveemployee')}}"><i class="bi bi-archive"></i> Archive</a></li> -->
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

                    

                    {{-- <div class="card-body pb-0">
                        <div class="row">
                       <div class="form-group col-4">

                    <label for="">Select User</label>
                  <select name="" id="userdata" class="form-control">
                    <option value="">Select User</option>
                    <option value="1">Employee</option>
                    <option value="2">Distributor</option>
                  </select>
                       </div>
    
                    </div>

                </div> --}}

                    <br>
                    <hr>


                    <table id="dtBasicExample" class="table table-responsive dataTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>Staff Id</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Joining Date</th>
                                <th>Status</th>
                                {{-- <th>Action</th> --}}
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


  <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="exampleModalLongTitle">Change Password</h5>
          <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span> -->
          </button>
        </div>
        <div class="modal-body">
      <form method="POST" id="passwordchange">
      @csrf

      <input type="hidden" name="changeid" id="changeid">
  
    <div class="form-group">
      <label for="exampleInputPassword1">New Password</label>
      <input type="password" class="form-control" onKeyPress="if(this.value.length==15) return false;" name="newpassword" id="exampleInputPassword1" placeholder="New Password">
    <span id="newpassword_error"></span>
    </div>
  
    <div class="form-group">
      <label for="exampleInputPassword1">Confirm Password</label>
      <input type="password" class="form-control" onKeyPress="if(this.value.length==15) return false;" name="confirmpassword" id="exampleInputPassword1" placeholder="Confirm Password">
    <span id="confirmpassword_error"></span>
    </div>
  
    
  </form>
        </div>
        <div class="modal-footer">
      <button type="submit" class="btn btn-primary btn-sm" id="savepassword">Submit</button>
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

<script type="text/javascript">

$('body').on('click' , '.reset' , function(){
    // alert('hello');
    var input = $(this).attr('data-id');
    // alert(input);
    $('#changeid').val(input);
    $('#exampleModalCenter1').modal('show');
});


$('#savepassword').on('click' , function(e){
			e.preventDefault();
			var formdata = $('#passwordchange').serializeArray();
			Swal.fire({
          title: 'Confirm Submission',
          text: 'Are you sure you want to Change the Password?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Yes, submit!',
          cancelButtonText: 'Cancel',
          customClass: {
    popup: 'custom-swal-width-height',
    title: 'custom-swal-title',
    htmlContainer: 'custom-swal-text',
    icon: 'custom-swal-icon'
}
        }).then((result) => {
			if (result.isConfirmed) {
				
				$.ajax({
					headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
					url : "{{route('userChangepass')}}",
					type : "POST",
					data : formdata,
					success : function(response){
						// console.log(response);

						if(response.status == "success"){

							Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Password Change Successfully.',
                    customClass: {
    popup: 'custom-swal-width-height',
    title: 'custom-swal-title',
    htmlContainer: 'custom-swal-text',
    icon: 'custom-swal-icon'
                    }
                }).then(function(result) {
                    if (result.isConfirmed) {
						$('#exampleModalCenter').modal('hide');
					}
                });

						}

						else if (response.status == 'error') {
                //   $('.loader-container').show();
				console.log(response);
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

          $('body').on('click' , '.tglbtn' , function(){

            // alert('hello');
            var id = $(this).attr('data-id');
            // alert(id);

            $.ajax({

                url : "{{route('employee-changeStatus')}}",
                type : "GET",
                data : {id : id},
                success : function(response){
                   if(response.status == 'success'){
                    alert('Success');
                    window.location.reload();
                   }
                    
                   if(response.status == 'error'){
                    alert('failed!');
                    window.location.reload();
                   }

                }

            });

          });

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
// userdata

    $(function() {
        var i = 1;
        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            // ajax: "{{ route('view-employee') }}",
            ajax: {
        url: "{{ route('view-employee') }}",
        type: "GET", 
        data: function (d) {
            d.userdata = $('#userdata').val();
        }
    },

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
                    data: 'staff_id',
                },
                {
                    data: 'email',
                },
                {
                    data: 'phone',
                },
                {
                    data: 'date',
                },
                {
                    data : 'status',
                },

                // {
                //     data: 'action',
                // },
            ]
        });

        $('#userdata').on('change', function() {
        // alert('Calling');
    table.ajax.reload(); 
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
                        url : "{{route('deleteemployee')}}",
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