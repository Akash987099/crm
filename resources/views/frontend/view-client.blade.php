@extends('frontend.layout.master')

@section('content')

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1><i class="bi bi-card-list"></i> All Lead</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{url('client-details')}}"><i class="bi bi-plus-circle"></i> Add Lead</a></li>
                    <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{url('view-archive-client')}}"><i class="bi bi-archive"></i> Archive Lead</a></li>

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
                <div class="m-3">

                    <table class="table table-responsive dataTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 15%;">Name</th>
                                <th style="width: 15%;">Company</th>
                                <th style="width: 10%;">Phone</th>
                                <th style="width: 20%;">Address</th>
                                <th style="width: 15%;">Meeting Status</th>
                                <th style="width:20%">Action</th>
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
                <h5 class="modal-title">All Lead Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><b>Meeting Assign User </b> <span class="assignUser"></span></p>
                <p><b>Client Name :</b> <span class="clientname"></span> </p>
                <p><b>Company Name :</b> <span class="companyname"></span> </p>
                <p><b>Phone :</b> <span class="phone"></span> </p>
                <p><b>Email :</b> <span class="email"></span> </p>
                <p><b>Meeting Date :</b> <span class="meating_date"></span> </p>
                <p><b>Meeting Time :</b> <span class="meating_time"></span> </p>
                <p><b>Client Potential : </b> <span class="status"></span> </p>
                <p><b>Note/Remark : </b> <span class="remark"></span> </p>
                <p><b>Address :</b> <span class="address"></span> </p>
                <p><b>Create Date :</b> <span class="create_date"></span> </p>

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
    $(document).on('click', '.lead_id', function() {
        var dataId = $(this).attr("data-id");
        $.ajax({
            type: 'POST',
            url: "{{route('telecaller.frontend.view-telemarketing-details')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": dataId
            },
            success: function(response) {
                $("#basicModal").modal('show');
                $(".clientname").text(response.data.client_name);
                $(".companyname").text(response.data.company_name);
                $(".phone").text(response.data.phone);
                $(".address").text(response.data.address);
                $(".email").text(response.data.email);
                $(".create_date").text(response.data.created_date);
                $(".remark").text(response.data.remark);
                $(".meating_date").text(response.data.meating_date);
                $(".meating_time").text(response.data.meating_time);

                if (response.data.typeofuser == 1) {
                    $(".assignUser").text(response.user + ' (Manager)');
                } else if (response.data.typeofuser == 2) {
                    $(".assignUser").text(response.user + ' (Marketing)');
                } else if (response.data.typeofuser == 3) {
                    $(".assignUser").text(response.user + ' (B.D.M)');
                }



                if (response.data.client_potential == 1) {
                    $(".status").text("Heigh");
                } else if (response.data.client_potential == 2) {
                    $(".status").text("Moderate");
                } else {
                    $(".status").text("Low");
                }

            }
        });

    });

    /////////////////////////////STARD DATA TABLE//////////////////////////////////
    $(function() {
        var i = 1;
        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('frontend.view-clients') }}",

            dom: 'Blfrtip',
            buttons: [{
                    extend: 'pdf',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'excel',
                }
            ],

            columns: [{
                    "render": function() {
                        return i++;
                    }
                },
                {
                    data: 'client_name',
                    name: 'client_name'
                },
                {
                    data: 'company_name',
                    name: 'company_name'
                },

                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'address',
                    name: 'address'
                },

                {
                    data: 'meeting_status',
                    name: 'meeting_status',
                    render: function(data, type, row) {
                        if (data == 1) {
                            return '<span class="badge rounded-pill bg-success">Deal Close</span>';
                        } else if (data == 2) {
                            return '<span class="badge rounded-pill bg-warning">Follow Up</span>';
                        } else if (data == 3) {
                            return '<span class="badge rounded-pill bg-danger">Residual</span>';
                        } else {
                            return '<span class="badge rounded-pill bg-danger">Padding</span>';
                        }

                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>

@endpush