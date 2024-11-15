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
            <h1>Message</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white addpage" href="javascript:void(0)"><i class="bi bi-plus-circle"></i> Add</a></li>
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

                <form action="" method="POST" id="userprivilege">
                        <div class="row">
                                              <div class="mb-2 col-md-4">
                                                <select class="form-control"  name="user_id" id="user_id">
                                                   <option value="">Select Employee</option>
                                                  
                                                   @foreach($employee as $key => $val)
                                                   @if($val->user_id == Auth::guard('manager')->user()->id)
                                                 <option value="{{$val->id}}">{{$val->firstname}} &nbsp; {{$val->lastname}}</option>
                                                 @endif
                                                 @endforeach
                                                </select>
                                              </div>

                                           </div>
                                   </form>


                    <table id="dtBasicExample" class="table table-responsive dataTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Employee name</th>
                                <th>Subject</th>
                                <th>Message </th>
                                <th>Date</th>
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
  
<section class="section dashboard" id="createpage" style="display: none">
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
                                    <label>Select Employee<span class="text-danger">*</span></label>
                                    
                                    <select name="empid" id="" class="form-control" required>
                                        <option value="">Select Employee</option>

                                        @foreach ($employee as $key =>  $val)

                                        <option value="{{$val->id}}">{{$val->firstname}} {{$val->lastname}} ({{$val->staffid}})</option>
                                            
                                        @endforeach

                                    </select>
                                    <span class="name-error" id="name-error">@error('Asset') {{$message}} @enderror</span>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Subject <span class="text-danger">*</span></label>
                                    <input type="text" name="subject" class="form-control" value="{{old('subject')}}" placeholder="Task" required>
                                    <span class="subject-error" id="phone-error">@error('Name') {{$subject}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group m-2">
                                    <label>message<span class="text-danger">*</span></label>
                                    <textarea name="message" id="message" class="form-control" cols="30" rows="10"></textarea>
                                    <span class="email-error" id="email-error">@error('Model') {{$message}} @enderror</span>
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

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>


<script>
    
    $('body').on('click' , '.addpage' , function(){

$('#createpage').css('display' , 'block');

});

    $('.dashboard').hide();

    $('#createform').on('submit', function(e){

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

        url : "{{route('Addmessage')}}",
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
    

    $(document).ready(function(){

        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            // ajax: "{{ route('Admin_attendance_view') }}",
            ajax: {
        url: "{{ route('messagelist') }}",
        data: function (d) {
            d.username = $('#user_id').val();
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
                    data: 'subject',
                },
                {
                    data: 'message',
                },
                {
                    data: 'date',
                },
                {
                    data: 'action',
                },
                
            ]

        });

        $('#user_id').on('change' , function(){
            table.ajax.reload();
        });

        $('#fromdate, #todate').on('change', function() {
        table.ajax.reload();
    });

        $('body').on('click' , '.delete' , function(){
            // alert('hello');
            var id = $(this).attr('data-id');
            // alert(id);

            $.ajax({
                url : '{{route('delete-attenance')}}',
                type : "GET",
                data : {id : id},
                success : function(response){

                    Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Success!',
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
            });

        });

    });

</script>



@endsection
