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
            <h1>Employee Attendance</h1>
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

                <form action="" method="POST" id="userprivilege">
                        <div class="row">
                                              <div class="mb-2 col-md-4">
                                                <select class="form-control"  name="user_id" id="user_id">
                                                   <option value="">Select Employee</option>
                                                   {{-- if(Auth::guard('manager')->check()){

                                                    $empid = employee::where('user_id' , Auth::guard('manager')->user()->id)->pluck('id');
                                                   $data->whereIn('employee.user_id' , $empid);
                                                } --}}
                                                   @foreach($employee as $key => $val)
                                                   @if($val->user_id == Auth::guard('manager')->user()->id)
                                                 <option value="{{$val->id}}">{{$val->firstname}} &nbsp; {{$val->lastname}}</option>
                                                 @endif
                                                 @endforeach
                                                </select>
                                              </div>

                                              <div class="mb-2 col-md-4">
                                               <!-- <label for=""></label> -->
                                                <input type="date" id="fromdate" class="form-control" name="fromdate">
                                              </div>

                                              <div class="mb-2 col-md-4">
                                               <!-- <label for=""></label> -->
                                                <input type="date" id="todate" class="form-control" name="todate">
                                              </div>
                    </div>
</form>


                    <table id="dtBasicExample" class="table table-responsive dataTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>name</th>
                                <th>Conatct </th>
                                <th>Email</th>
                                <th>RRN No.</th>
                                <th>Total Amount</th>
                                <th>Action</th>
                                <th>Payment</th>
                                <th>Address</th>
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
    
    $('.dashboard').hide();
    

    $(document).ready(function(){

        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            // ajax: "{{ route('Admin_attendance_view') }}",
            ajax: {
        url: "{{ route('manager_data') }}",
        data: function (d) {
            d.username = $('#user_id').val();
            d.fromdate = $('#fromdate').val();
            d.todate   = $('#todate').val();
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
                    data: 'contact',
                },
                {
                    data: 'email',
                },
                {
                    data: 'rrn_no',
                },
                {
                    data: 'total_amount',
                },
                {
                    data: 'payment_re',
                },
                {
                    data: 'document_add',
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
