
@extends('managerend.layout.master')

@section('content')


<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1><i class="bi bi-card-list"></i> Task Management</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white addpage" href="javascript:void(0)"><i class="bi bi-plus-circle"></i> Add</a></li>
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
                                <th>Employee Name</th>
                                <th>Staff ID</th>
                                <th>Task</th>
                                <th>Target</th>
                                <th>From date</th>
                                <th>To date</th>
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
                                    <label>Assign Task<span class="text-danger">*</span></label>
                                    
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
                                    <label>Task Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{old('phone')}}" placeholder="Task" required>
                                    <span class="phone-error" id="phone-error">@error('Name') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Target<span class="text-danger">*</span></label>
                                    <input type="text" name="target" class="form-control" value="" placeholder="target" required>
                                    <span class="email-error" id="email-error">@error('Model') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>From Date<span class="text-danger">*</span></label>
                                    <input type="date" name="fromdate" class="form-control" value="" placeholder="" required>
                                    <span class="email-error" id="email-error">@error('Model') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Todate<span class="text-danger">*</span></label>
                                    <input type="date" name="todate" class="form-control" value="" placeholder="" required>
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

<section class="section dashboard" id="updatepage" style="display: none">
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

                    <form method="POST" action="" id="updateform" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" id="updateid" name="updateid">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Assign Task<span class="text-danger">*</span></label>
                                    
                                    <select name="empid" id="empid" class="form-control" required>
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
                                    <label>Task Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Task" required>
                                    <span class="phone-error" id="phone-error">@error('Name') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Target<span class="text-danger">*</span></label>
                                    <input type="text" name="target" id="target" class="form-control" value="" placeholder="target" required>
                                    <span class="email-error" id="email-error">@error('Model') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>From Date<span class="text-danger">*</span></label>
                                    <input type="date" id="fromdate" name="fromdate" class="form-control" value="" placeholder="">
                                    <span class="email-error" id="email-error">@error('Model') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Todate<span class="text-danger">*</span></label>
                                    <input type="date" id="todate" name="todate" class="form-control" value="" placeholder="">
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

<script>

     $(document).ready(function(){

        $('body').on('click' , '.addpage' , function(){

          $('#createpage').css('display' , 'block');

        });

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

        url : "{{route('Addtask')}}",
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
            ajax: "{{ route('taskAjax') }}",

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
                    data: 'staffid',
                },
                {
                    data: 'task',
                },
                {
                    data: 'target',
                },
                {
                    data : 'fromdate',
                },
                {
                    data : 'todate',
                },
                {
                    data: 'action',
                },
                
            ]

        });

        $('body').on('click' , '.delete' , function(){

            var id = $(this).attr('data-id');

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

        url : "{{route('Deletetask')}}",
        type : "GET",
        data : {id : id},
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

        $('body').on('click' , '.edit' , function(){

            $('#updatepage').css('display' , 'block');

var id = $(this).attr('data-id');

$.ajax({

url : "{{route('Deletetask')}}",
type : "GET",
data : {update : id},
success: function(response) {

if(response.status == "success"){
   
    // alert(response.data.id);

    $('#updateid').val(response.data.id);
    $('#empid').val(response.data.emp_id);
    $('#name').val(response.data.name);
    $('#target').val(response.data.target);
    $('#fromdate').val(response.data.fromdate);
    $('#todate').val(response.data.todate);


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

});

$('#updateform').on('submit', function(e){

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

        url : "{{route('updatetask')}}",
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



     });

</script>

@endsection
