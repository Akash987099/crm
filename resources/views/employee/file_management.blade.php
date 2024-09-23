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
                    <li class="p-1">
                        {{-- <a class="btn btn-primary btn-sm text-white" href="{{route('adminagent')}}"><i class="bi bi-list"></i> View</a> --}}
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createFolderModal">
                            Create Folder
                        </button>
                    </li>
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
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                        {{Session::get('error')}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="container mt-5">

                        <div class="m-2">


                            <table id="dtBasicExample" class="table table-responsive dataTable" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Folder Name</th>
                                        <th>Employee Code</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                       
                                    <tbody>

                                        @php
                                            $count = 1;
                                        @endphp

                                        @foreach($files as $file)

                                        <tr>
                                            <td>{{$count++}}</td>
                                            @if ($file->is_folder)
                                            <td><a href="{{ route('employee_file_view', ['parentId' => $file->id]) }}">{{ $file->name }}</a></td>
                                        @else
                                        <a href="{{ Storage::url($file->path) }}" target="_blank">{{ $file->name }}</a>
                                        @endif
                                        <td>{{$file->staff_id}}</td>
                                        <td>
                                            <div class="d-inline-block">
                                                {{-- <button type="button" class="btn btn-danger btn-sm" data-id="{{$file->staff_id}}" id="">View</button> --}}
                                                <a class="btn btn-danger btn-sm" href="{{ route('employee_file_view', ['id' => $file->staff_id]) }}">View</a>
                                            </div>
                                            <div class="d-inline-block">
                                                <button type="button" class="btn btn-danger btn-sm uploaddocument" data-id="{{$file->staff_id}}" id="">Upload</button>
                                            </div>
                                           
                                        </td>
                                        
                                        
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </tbody>
                            </table>
        
        
                        </div>
                        
                        {{-- @if ($parent)
                            <a href="{{ route('file.index', ['parentId' => $parent->parent_id]) }}" class="btn btn-secondary mb-3">Back</a>
                        @endif
                 --}}
                        <!-- Button to Open the Modal -->
                        
                
                        <!-- The Modal -->
                        <div class="modal fade" id="createFolderModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Create New Folder</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                
                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form action="{{ route('employee_file.createFolder') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="folderName">Folder Name:</label>
                                                <input type="text" class="form-control" id="folderName" name="name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="folderName">Employee Staff id</label>
                                                <input type="text" class="form-control" id="staffid" name="staffid" required>
                                            </div>
                                            <input type="hidden" name="parent_id" value="{{ $parent ? $parent->id : null }}">
                                            <button type="submit" class="btn btn-primary">Create Folder</button>
                                        </form>
                                    </div>
                
                                    <!-- Modal Footer -->
                                  
                                </div>
                            </div>
                        </div>
                
                        <!-- Upload File Form -->

                        <div class="modal fade" id="createFolderModal1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                
                                    @if(Session::has('success'))
                                    <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                                        {{Session::get('success')}}
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Upload Documents</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                
                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form id="uploadFileForm" action="" method="POST" enctype="multipart/form-data" class="mb-3">
                                            @csrf
                                            <div class="form-group">
                                                <label for="file">Choose file:</label>
                                                <input type="file" class="form-control-file" id="file" name="file" required>
                                            </div>
                                            <input type="hidden" name="parent_id" id="parent_id" value="">
                                            <button type="submit" class="btn btn-success">Upload File</button>
                                        </form>
                                    </div>                                    
                
                                    <!-- Modal Footer -->
                                  
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    
                </div>

            </div>

        </div>

    </div>
    </div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
{{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>


$('.uploaddocument').click( function(){

    // alert('hello');

    var value = $(this).attr('data-id');

    // alert(value);

    $('#parent_id').val(value);

    $('#createFolderModal1').modal('show');

});

$(document).ready(function() {
    $('#uploadFileForm').on('submit', function(e) {
        e.preventDefault(); 
        //   alert('hello');
        var formData = new FormData(this); 

        $.ajax({
            url: "{{ route('employee_file.uploadFile') }}",
            method: $(this).attr('method'),
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
               
                if(response.status == "success"){
                    alert('File uploaded successfully');
                }else{
                    alert('Error!!');
                }
                $('#createFolderModal').modal('hide');
                location.reload();
            },
            error: function(response) {
                // Handle the error response (e.g., display an error message)
                alert('An error occurred while uploading the file');
            }
        });
    });
});


</script>

@endsection

@push('footer-script')


@endpush