@extends('managerend.layout.master')

@section('content')

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1><i class="bi bi-card-list"></i> All Lead</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li><a class="btn btn-primary btn-sm text-white" href="{{route('manager.add-lead')}}"><i class="bi bi-plus-circle"></i> Add Lead</a></li>
                    &nbsp;
                    {{-- <li><a class="btn btn-danger btn-sm text-white" href="{{route('backend.archive-client')}}"><i class="bi bi-archive"></i> Archive Lead</a></li> --}}

                </ol>
            </nav>
        </div>
    </div>


</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body m-2">
                    @if(Session::has('success'))
                    <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                        {{Session::get('success')}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="result"></div>
                </div>
                <div class="m-2">
                    <table class="table table-responsive dataTables_length dataTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Phone</th>
                                <th>Client Potential</th>
                                <th>Created Date</th>
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
                <h5 class="modal-title">Assign Meating Information </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="h4"> Created Date : <span class="created_date"></span></p>
                <p><b>Client Name :</b> <span class="clientname"></span> </p>
                <p><b>Company Name :</b> <span class="companyname"></span> </p>
                <p><b>Email :</b> <span class="email"></span> </p>
                <p><b>Phone :</b> <span class="phone"></span> </p>
                <p><b>Meeting Time :</b> <span class="meetingtime"></span> </p>
                <p><b>Meeting Date :</b> <span class="meating_date"></span> </p>
                <p><b>Client Potential :</b> <span class="status"></span> </p>
                <p><b class="text-danger">Meeting Assigned :</b> <span class="assign_user text-success"></span> </p>
                <p><b>Lead Generate By :</b> <span class="lead_generate"></span> </p>
                <p><b>Address :</b> <span class="address"></span> </p>
                <p><b>Remark :</b> <span class="remark"></span> </p>
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

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>


<script type="text/javascript">
    $(document).on('click', '.client_id', function() {
        let dataId = $(this).attr("data-id");
        $('.service').empty();
        $.ajax({
            type: 'post',
            url: "{{route('backend.lead.views-clients-data')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": dataId
            },
            success: function(response) {
                //console.log(response.manager);
                $("#basicModal").modal('show');
                $(".clientname").text(response.data.client_name);
                $(".companyname").text(response.data.company_name);
                $(".phone").text(response.data.phone);
                $(".address").text(response.data.address);
                $(".email").text(response.data.email);
                $(".meetingtime").text(response.data.meating_time);
                $(".meating_date").text(response.data.meating_date);
                $(".remark").text(response.data.remark);
                $(".created_date").text(response.data.created_date);

                $.each(response.service, function(key, item) {
                    $('.service').append(item, ', ');
                });
                if (response.data.meeting_status == 1) {
                    $(".status").text('Deal Close');
                } else if (response.data.meeting_status == 2) {
                    $(".status").text('Follow Up');
                } else if (response.data.meeting_status == 3) {
                    $(".status").text('Reschedule');
                } else {
                    $(".status").text('Padding');
                }
                if (response.data.user_type == 1) {
                    $(".lead_generate").text('Admin');
                } else {
                    $(".lead_generate").text(response.lead_generate.firstname + response.lead_generate.lastname + ' ( Telemarketing )');
                }

                if (response.data.typeofuser == 1) {
                    $(".assign_user").text(response.manager.name + ' ( Manager )');
                } else if (response.data.typeofuser == 2) {
                    $(".assign_user").text(response.manager.firstname + ' ' + response.manager.lastname + ' ( Marketing User )');
                } else if (response.data.typeofuser == 3) {
                    $(".assign_user").text(response.manager.bde_name + ' ( Marketing User )');
                } else {
                    $(".assign_user").text(response.manager + ' ( Admin )');
                }
            }
        });

    });



    //////////////////////////////////////////DATA TABLE//////////////////////////////////////////////
    $(function() {
        var i = 1;
        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('frontend.View_clients') }}",

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
                    data: 'client_potential',
                    name: 'client_potential',
                    "render": function(data, type, row) {
                        if (data == 1) {
                            return '<span class="badge rounded-pill bg-success">Heigh</span>';
                        } else if (data == 2) {
                            return '<span class="badge rounded-pill bg-info">Moderate</span>';
                        } else {
                            return '<span class="badge rounded-pill bg-warning">Low</span>';
                        }
                    }
                },
                {
                    data: 'created_date',
                    name: 'created_date'
                },

                
            ]
        });
    });
</script>

@endsection

@push('footer-script')


@endpush