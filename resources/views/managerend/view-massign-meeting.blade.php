@extends('managerend.layout.master')

@section('content')
<div class="row">
    <div class="col-lg-10">
        <div class="pagetitle">
            <h1>Assign Meating</h1>
            <nav>
                <ol class="breadcrumb">

                    <li class="breadcrumb-item active">Assign Meating</li>
                </ol>
            </nav>
        </div>
    </div>

</div>
<section class="section profile">
    <div class="row">
        <div class="col-xl-12">

            <div class="card">
                <div class="card-body pt-2">
                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">

                            @if(Session::has('success'))
                            <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                                {{Session::get('success')}}
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <div class="m-2">
                                <table class="table table-responsive dataTable" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Employee Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            {{-- <th>Status</th> --}}
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
            </div>
        </div>
    </div>
    </div>
</section>


<!-- Basic Modal -->

<div class="modal fade" id="basicModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Meating Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><b>Client Name :</b> <span class="clientname"></span> </p>
                <p><b>Company Name :</b> <span class="companyname"></span> </p>
                <p><b>Phone :</b> <span class="phone"></span> </p>
                <p><b>Email :</b> <span class="email"></span> </p>
                <p><b>Meeting Date :</b> <span class="meating_date"></span> </p>
                <p><b>Meeting Time :</b> <span class="meetingtime"></span> </p>
                <p><b>Services :</b> <span class="service"></span> </p>
                <p><b>Total Services Price:</b> <span class="price"></span> </p>
                <p><b>Custom Price:</b> <span class="customPrice"></span> </p>
                <p><b>Tenure:</b> <span class="tenure"></span> </p>
                <p><b>Meeting Created by:</b> <span class="team_person"></span> </p>
                <p><b>Address :</b> <span class="address"></span> </p>
                <p><b>Status:</b> <span class="status"></span> </p>
                <p><b>Remark:</b> <span class="remark"></span> </p>
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

<script>
    $(document).on('click', '.client_id', function() {
        var dataId = $(this).attr("data-id");

        $('.service').empty();
        $.ajax({
            type: 'POST',
            url: "{{url('manager/views-clients-data')}}",
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
                $(".meetingtime").text(response.data.meating_time);
                $(".meating_date").text(response.data.meating_date);
                $(".price").text(response.data.service_price);
                $(".customPrice").text(response.data.custom_price);
                $(".tenure").text(response.data.tenure);
                $(".remark").text(response.data.remark);
                $.each(response.service, function(key, value) {
                    $('.service').append("<span>" + value.service_name + ", Price - " + value.service_price + " , " + "</span>");
                });
                if (response.data.meeting_status == 1) {
                    $(".status").text('Deal Close');
                } else if (response.data.status == 2) {
                    $(".status").text('Follow Up');
                } else {
                    $(".status").text('Residual');
                }

                if (response.data.user_type == 1) {
                    $(".team_person").text(response.team_user);
                } else {
                    $(".team_person").text(response.team_user.firstname + ' ( Telemarketing Staff )');
                }

            }
        });

    });



    $(function() {
        var i = 1;
        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('manager.massign-meeting') }}",

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
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },

                // {
                //     data: 'meeting_status',
                //     name: 'meeting_status',
                //     render: function(data, type, row) {
                //         if (data == 1) {
                //             return '<span class="badge rounded-pill bg-success">Deal Close</span>';
                //         } else if (data == 2) {
                //             return '<span class="badge rounded-pill bg-info">Follow Up</span>';
                //         } else if (data == 3) {
                //             return '<span class="badge rounded-pill bg-danger">Reschedule</span>';
                //         } else {
                //             return '<span class="badge rounded-pill bg-warning">Padding</span>';
                //         }

                //     }
                // },
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