@extends('employee.master')

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
            <h1>Attendance</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white addbutton" href="javascript:void(0);"><i class="bi bi-plus"></i> Attendance</a></li>
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
                                <th>Login Time</th>
                                <th>Logout Time</th>
                                <th>Date</th>
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

<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>

<script>
    $(document).ready(function() {
        let stream;
        const video = $('#video')[0];
        const canvas = $('#canvas')[0];
        const captureButton = $('#capture');
        const recaptureButton = $('#recapture');
        const uploadButton = $('#upload');
        const imageInput = $('<input>').attr('type', 'hidden').attr('name', 'image').attr('id', 'image');
    
        function startCamera(cameraFacing) {
            navigator.mediaDevices.getUserMedia({
                video: { facingMode: cameraFacing }
            })
            .then(s => {
                stream = s;
                video.srcObject = stream;
            })
            .catch(err => {
                console.error("Error accessing the camera: ", err);
            });
        }
    
        $('.addbutton').click(function() {
            $('#exampleModalCenter').modal('show');
            const cameraSelect = $('#cameraSelect').val();
            startCamera(cameraSelect);
        });
    
        $('#cameraSelect').change(function() {
            const cameraSelect = $(this).val();
            if (stream) {
                stream.getTracks().forEach(track => track.stop()); 
            }
            startCamera(cameraSelect);
        });
    
        captureButton.click(function() {
            canvas.width = video.videoWidth; 
            canvas.height = video.videoHeight; 
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = canvas.toDataURL('image/png');
            imageInput.val(imageData);
            $('body').append(imageInput);
    
            video.style.display = 'none';
            canvas.style.display = 'block';
            captureButton.hide();
            recaptureButton.show();
            uploadButton.show();
        });
    
        // Recapture photo
        recaptureButton.click(function() {
            video.style.display = 'block';
            canvas.style.display = 'none';
            captureButton.show();
            recaptureButton.hide();
            uploadButton.hide();
        });
    
        // Upload photo
        uploadButton.click(function() {
            $.ajax({
                url: '{{ route('employee.save.attendane') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    image: imageInput.val()
                },
                success: function(response) {
                   
                    if(response.status == 'success'){

                        Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Thank You!!.',
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

                    if(response.status == "error"){

                        Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Attendance already recorded for today',
                 
                }).then(function(result) {
                    if (result.isConfirmed) {
                window.location.reload();
                    }
                });

                    }

                },
                error: function(xhr) {
                    console.error('Error uploading image:', xhr);
                }
            });
        });
    });
    </script>
    
    
    

<script>

$('.addbutton').click(function(){
        // alert('hello');
        $('.dashboard').show();

        
    

     let editorInstance;

ClassicEditor
    .create(document.querySelector('#programeditor'))
    .then(editor => {
        editorInstance = editor;
    })
    .catch(error => {
        console.error(error);
    });
});

</script>

<script>
    
    $('.dashboard').hide();
    

    $(document).ready(function(){

        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('EattendanceList') }}",

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
                    data: 'login_time',
                },
                {
                    data: 'logout_time',
                },
                {
                    data: 'date',
                },
                {
                    data: 'image',
                },
            ]

        });
    });

</script>

@endsection