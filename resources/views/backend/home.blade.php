@extends('backend.layout.master')

@section('content')

<div class="pagetitle">
    <h1>Dashboard </h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">

        <div class="col-lg-8">
            <div class="row">

                <div class="col-xxl-4 col-md-6 ">
                    <div class="card info-card sales-card rounded">
                        <div class="filter">
                            <!-- <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a> -->
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>
                        @php
                        $sales = DB::table('meetings')
                        ->where('status', '=', 1)
                        ->sum('blance');
                        @endphp
                        <div class="card-body rounded">
                            <h5 class="card-title">Sales </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$sales}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="filter">
                            <!-- <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a> -->
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">
                                Revenue
                            </h5>
                            @php
                            $amount = DB::table('payment_details')->sum('amount');
                            @endphp
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-rupee"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$amount}}</h6>
                                    <!-- <span class="text-success small pt-1 fw-bold">8%</span>
                                    <span class="text-muted small pt-2 ps-1">increase</span> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Total Agent Amount
                            </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex bg-success text-white align-items-center justify-content-center">
                                    <i class="bi bi-currency-rupee"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$totalagentsum}}</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Total Agent Amout Due
                            </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex bg-success text-white align-items-center justify-content-center">
                                    <i class="bi bi-currency-rupee"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$totalagentdue}}</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Customers
                            </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex bg-success text-white align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$customers}}</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Follow Up Meeting
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$followup_meeting}}</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Rejected Meeting
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle bg-danger text-white d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-x-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$reject_meeting}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Meeting Close
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex bg-info text-white align-items-center justify-content-center">
                                    <i class=" bi bi-person-check"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$customers}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Agent
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex bg-info text-white align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$totalagent}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">
                               Total Lead
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex bg-info text-white align-items-center justify-content-center">
                                    <i class=" bi bi-person-check"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$totalClient}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">
                               Total Employee
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex bg-info text-white align-items-center justify-content-center">
                                    <i class=" bi bi-person-check"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$totalemployee}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">
                               Total Leave
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex bg-info text-white align-items-center justify-content-center">
                                    <i class=" bi bi-person-check"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$totalleave}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">
                               Total Today Leave
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex bg-info text-white align-items-center justify-content-center">
                                    <i class=" bi bi-person-check"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$todayleave}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-4">
            <div class="card top-selling overflow-auto">
                <div class="filter">
                    <!-- <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a> -->
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                        </li>

                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                </div>

                <div class="card-body pb-0">
                    <h5 class="card-title">Recent Leads &nbsp; <span> @php date_default_timezone_set('Asia/Kolkata'); echo date('d-m-Y H:i'); @endphp</span></h5>

                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Created Date</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($lead_generate) && !empty($lead_generate))
                            @foreach($lead_generate as $row)
                            <tr>
                                <td>
                                    <a href="#" data-id="{{Crypt::encrypt($row->id)}}" class="text-primary client_id">{{$row->client_name}}</a>
                                </td>
                                <td>{{substr($row->address,1,15)}}</td>
                                <td class="fw-bold">{{$row->created_date}}</td>
                            </tr>
                            @endforeach
                            @endif
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
                <h5 class="modal-title">Recent Leads Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><b>Client Name :</b> <span class="clientname"></span> </p>
                <p><b>Company Name :</b> <span class="companyname"></span> </p>
                <p><b>Email :</b> <span class="email"></span> </p>
                <p><b>Phone :</b> <span class="phone"></span> </p>
                <p><b>Meeting Time :</b> <span class="meetingtime"></span> </p>
                <p><b>Meeting Date :</b> <span class="meating_date"></span> </p>
                <p><b>Status :</b> <span class="status"></span> </p>
                <p><b>Meeting Assign User :</b> <span class="meeting_assign_user"></span> </p>
                <p><b>Created by :</b> <span class="team_person"></span> </p>
                <p><b>Address :</b> <span class="address"></span> </p>
                <p><b>Remark :</b> <span class="remark"></span> </p>
                <p><b>Created Date :</b> <span class="created_date"></span> </p>
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

<script>
    $(document).on('click', '.client_id', function() {
        var dataId = $(this).attr("data-id");
        // $('.service').empty();
        $.ajax({
            type: 'post',
            url: "{{route('backend.views-leads-data')}}",
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
                $(".remark").text(response.data.remark);
                $(".created_date").text(response.data.created_date);
                // $.each(response.service, function(key, item) {
                //     $('.service').append(item, ', ');
                // });
                if (response.data.meeting_status == 1) {
                    $(".status").html('<span class="badge rounded-pill bg-success">Deal Close</span>');
                } else if (response.data.meeting_status == 2) {
                    $(".status").html('<span class="badge rounded-pill bg-warning">Follow Up</span>');
                } else if (response.data.meeting_status == 3) {
                    $(".status").html('<span class="badge rounded-pill bg-danger">Reschedule</span>');
                } else {
                    $(".status").html('<span class="badge rounded-pill bg-danger">Padding</span>');
                }
                if (response.data.user_type == 1) {
                    $(".team_person").text('Admin');
                } else {
                    $(".team_person").text(response.team_person.firstname + ' ' + response.team_person.lastname + ' (Telemarketing)');
                }

                if (response.data.typeofuser == 1) {
                    $(".meeting_assign_user").text(response.manager.name + ' (Manager)');
                } else if (response.data.typeofuser == 2) {
                    $(".meeting_assign_user").text(response.manager.firstname + ' ' + response.manager.lastname + ' (Marketing User)');
                } else if (response.data.typeofuser == 3) {
                    $(".meeting_assign_user").text(response.manager.bde_name + ' (B.D.E)');
                }


            }
        });

    });
    // $(function() {
    //     var i = 1;
    //     var table = $('.dataTable').DataTable({
    //         processing: true,
    //         serverSide: true,
    //         ajax: "{{ url('admin/view-clients') }}",

    //         columns: [{
    //                 "render": function() {
    //                     return i++;
    //                 }
    //             },

    //             {
    //                 data: 'client_name',
    //                 name: 'client_name'
    //             },
    //             {
    //                 data: 'company_name',
    //                 name: 'company_name'
    //             },


    //             {
    //                 data: 'phone',
    //                 name: 'phone'
    //             },

    //             {
    //                 data: 'remark',
    //                 name: 'remark'
    //             },
    //             {
    //                 data: 'status',
    //                 name: 'status',
    //                 "render": function(data, type, row) {
    //                     if (data == 1) {
    //                         return '<span class="badge rounded-pill bg-success">Close</span>';
    //                     } else if (data == 2) {
    //                         return '<span class="badge rounded-pill bg-info">Follow Up</span>';
    //                     } else if (data == 3) {
    //                         return '<span class="badge rounded-pill bg-warning">Padding</span>';
    //                     } else {
    //                         return '<span class="badge rounded-pill bg-danger">Cancle</span>';
    //                     }
    //                 }
    //             },
    //             {
    //                 data: 'created_date',
    //                 name: 'created_date'
    //             },

    //             {
    //                 data: 'action',
    //                 name: 'action',
    //                 orderable: false,
    //                 searchable: false
    //             },
    //         ]
    //     });
    // });
</script>
@endpush