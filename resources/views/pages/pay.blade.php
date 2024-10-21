@extends('managerend.layout.master')

@section('content')


<style>
    video, canvas {
        display: block;
        margin: 10px auto;
    }
</style>

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1>Pay</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <!-- <li class="p-1"><a class="btn btn-primary btn-sm text-white addbutton" href="javascript:void(0);"><i class="bi bi-plus"></i> Add</a></li> -->
                    {{-- <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{url('manager/archive-market-mteam')}}"><i class="bi bi-archive"></i> Archive</a></li> --}}
                    <li class="p-1"><a href="{{ url()->previous() }}" class="btn btn-success btn-sm text-white"><i class="bi bi-arrow-left" ></i> Back</a></li>
                    
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body pb-0">

                    

                </div>
                <div class="m-2">


                    <table id="dtBasicExample" class="table table-responsive dataTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Staffid</th>
                                <th>Employee Name</th>
                                <th>Attendance</th>
                                <th>Leave</th>
                                <th>Sallery</th>
                                <th>Pay Sallery</th>
                                <th>Image</th>
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
  

{{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Open modal for @mdo</button> --}}

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="holdsallary">

            <input type="hidden" id="empid" name="empid">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Subject</label>
            <input type="text" name="subject" class="form-control" id="recipient-name" required>
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" name="message" id="message-text" required></textarea>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Send message</button>
          </div>

        </form>
      </div>
     
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap.min.js"></script>

{{-- <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>  --}}


<script>
    

    $(document).ready(function(){

        $('#holdsallary').on('submit', function(e){

            e.preventDefault();
            
            var formData = $(this).serialize();

            Swal.fire({
            title: 'Confirm Submission',
            text: 'Are you sure you want to Pay this Payment?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit!',
            cancelButtonText: 'Cancel',
          }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({

                    url : "{{route('holdsallery')}}",
                    type : "GET",
                    data : formData,
                    success: function(response) {

if(response.status == "success"){

 Swal.fire({
                       title: 'Success!',
                       text: 'Success!',
                       icon: 'success',
                       confirmButtonText: 'OK'
                   }).then((result) => {
                       if (result.isConfirmed) {
                         
                           window.location.reload();
                       }
                   });

}

                   if(response.status == "error"){

                     Swal.fire({
                   title: 'Error!',
                   text: 'Mail Server Error!!.',
                   icon: 'error',
                   confirmButtonText: 'OK'
               });

                 }
 
},

                });

            }
          });

        });

        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('payAjax') }}",

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
                    data: 'staffid',
                },
                {
                    data: 'name',
                },
                {
                    data: 'total_attendance',
                },
                {
                    data: 'total_leaves',
                },
                {
                    data : 'sallery',
                },
                {
                    data : 'paysallery',
                },
                {
                    data: 'action',
                },
                
            ]

        });


        $('body').on('click' , '.hold' , function(){

            var id = $(this).attr('data-id');

            $('#empid').val(id);

            // alert(id);

            $('#exampleModal').modal('show');

        });

      

        $('body').on('click' , '.pay' , function(){

            // alert('Calling');
            let data = $(this).data('id');
           let values = data.split('|');
          let firstValue = values[0];
          let secondValue = values[1];

            Swal.fire({
            title: 'Confirm Submission',
            text: 'Are you sure you want to Pay this Payment?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit!',
            cancelButtonText: 'Cancel',
          }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({

                    url : "{{route('payamount')}}",
                    type : "GET",
                    data : {firstValue : firstValue , secondValue : secondValue},
                    success: function(response) {

if(response.status == "success"){

 Swal.fire({
                       title: 'Success!',
                       text: 'Success!',
                       icon: 'success',
                       confirmButtonText: 'OK'
                   }).then((result) => {
                       if (result.isConfirmed) {
                         
                           window.location.reload();
                       }
                   });

}

                   if(response.status == "error"){

                     Swal.fire({
                   title: 'Error!',
                   text: 'error.',
                   icon: 'error',
                   confirmButtonText: 'OK'
               });

                 }
 
},

                });

            }
          });

        });

    });

</script>



@endsection
