@extends('employee.master')

@section('content')

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1>Add Assign Task Report</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
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

                    <form method="POST" action="" id="taskaddform" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <input type="hidden" name="taskid" value="{{$data->id}}">

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Task Name <span class="text-danger">*</span></label>
                                    <input type="text" name="subject" class="form-control" value="{{$data->name}}" placeholder="Task name" readonly>
                                    <span class="text-danger">@error('subject') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Target <span class="text-danger">*</span></label>
                                    <input type="text" name="subject" class="form-control" value="{{$data->target}}" placeholder="first name">
                                    <span class="text-danger">@error('subject') {{$message}} @enderror</span>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Task Amount <span class="text-danger">*</span></label>
                                    <input type="text" name="amount" class="form-control"  placeholder="Task Amount" required>
                                    <span class="text-danger">@error('subject') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>File <span class="text-danger"></span></label>
                                    <input type="file" name="file" class="form-control" value="{{$data->target}}">
                                    <span class="text-danger">@error('subject') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group m-2">
                                    <label>Report Details <span class="text-danger">*</span></label>
                                   <textarea name="details" id="" cols="30" rows="10" class="form-control" required></textarea>
                                    <span class="text-danger">@error('subject') {{$message}} @enderror</span>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Add</button>
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
     let editorInstance;

ClassicEditor
    .create(document.querySelector('#programeditor'))
    .then(editor => {
        editorInstance = editor;
    })
    .catch(error => {
        console.error(error);
    });
</script>

<script>
    
    $(document).ready(function(){

        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('leave-leave') }}",

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
                    data: 'subject',
                },
                {
                    data: 'date',
                },
                {
                    data: 'status',
                },
                {
                    data: 'action',
                },
            ]

        });

        $('#taskaddform').on('submit', function(e) {
    e.preventDefault();

    // Get the form data
    var formData = new FormData($(this)[0]);

    // Show confirmation dialog using SweetAlert
    Swal.fire({
        title: 'Confirm Submission',
        text: 'Are you sure you want to submit this task?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, submit!',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {

            // Send the form data via AJAX
            $.ajax({
                url: "{{route('Addtaskreport')}}", // The route to submit the form data
                type: "POST", // Use POST instead of GET
                data: formData,
                processData: false, // Prevent jQuery from automatically processing the form data
                contentType: false, // Ensure the correct content type for file uploads
                success: function(response) {

                    if(response.status == "success") {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Task added successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Reload the page after successful submission
                                window.location.reload();
                            }
                        });
                    }

                    if(response.status == "error") {
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an error submitting the task.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again later.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });

        }
    });
});

    });

</script>

@endsection