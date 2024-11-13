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
            <h1>Employee Leave</h1>
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
                                <th>Login Time</th>
                                <th>Logout Time</th>
                                <th>Date</th>
                                {{-- <th>Image</th> --}}
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
  
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Capture Photo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="dashboard">
                    <select id="cameraSelect" class="form-control mb-2">
                        <option value="user">Front Camera</option>
                        <option value="environment">Back Camera</option>
                    </select>
                    <video id="video" autoplay style="width: 100%; height:100%;"></video>
                    <canvas id="canvas" style="width: 100%; height:100%; display:none;"></canvas>
                </div>
            </div>
            <div class="modal-footer">
                <button id="capture" class="btn btn-secondary">Capture Photo</button>
                <button id="recapture" style="display:none;" class="btn btn-secondary">Recapture Photo</button>
                <button id="upload" style="display:none;" class="btn btn-secondary">Upload Photo</button>
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
    
    $('body').on('click' , '.approve' , function(){

// alert('Calling');
var id = $(this).attr('data-id');

// alert(id);

$.ajax({

    url : "{{route('approved-leave')}}",
    type : "GET",
    data : {id : id},
    success : function(response){
        // console.log(response);

        if(response.status == "success"){
            alert('success');
        }

        if(response.status == 'error'){
            alert('error');
        }
    }

});

});

$('body').on('click' , '.reject' , function(){

// alert('Calling');
var id = $(this).attr('data-id');

// alert(id);

$.ajax({

    url : "{{route('reject-leave')}}",
    type : "GET",
    data : {id : id},
    success : function(response){
        // console.log(response);

        if(response.status == "success"){
            alert('success');
        }

        if(response.status == 'error'){
            alert('error');
        }
    }

});

});

    $(document).ready(function(){

        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('managerleave-leave') }}",

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
                    data: 'emp',
                },
                {
                    data: 'name',
                },
                {
                    data: 'login_time',
                },
                {
                    data: 'logout_time',
                },
                {
                    data: 'date',
                },
                {
                    data : "action"
                }
                
            ]

        });
    });

</script>



@endsection
