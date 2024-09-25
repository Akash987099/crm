@extends('frontend.layout.master')

@section('content')

<div class="pagetitle">
    <h1>Dashboard</h1>
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

                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">


                        <div class="card-body">
                            <h5 class="card-title">Total Leads </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$total_lead}}</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">
                                Total Calls
                            </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success text-white">
                                    <i class="bi bi-telephone-forward"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$calls}}</h6>
                                    <span class="small pt-2 ps-1 text-danger fw-bold"> Reject Calls | <a style="color:black;font-weight:bold; font-size:17px;"> {{$reject_call}}</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">
                                Calls <span>| Today</span>
                            </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning text-white">
                                    <i class="bi bi-telephone-forward"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$today_call}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        {{-- <div class="col-lg-4">
           
            <div class="card">
                <div class="card-body pb-0">
                    <h5 class="card-title">Recent Leads &nbsp; <span> @php date_default_timezone_set('Asia/Kolkata'); echo date('d-m-Y H:i'); @endphp</span></h5>

                    <table class="table table-borderless" style="font-size: 15px;">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($recent_leads) && !empty($recent_leads))
                            @foreach($recent_leads as $row)
                            <tr>
                                <td><a data-id="{{Crypt::encrypt($row->id)}}" class="text-primary lead_id"> {{$row->client_name}}</a></td>
                                <td>{{substr($row->address,0,15)}}</td>
                                <td class="fw-bold">{{$row->created_date}}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
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
                    <h5 class="card-title">Reports <span>/Today</span></h5>
                    <div id="reportsChart"></div>
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            new ApexCharts(
                                document.querySelector("#reportsChart"), {
                                    series: [{
                                            name: "Sales",
                                            data: [31, 40, 28, 51, 42, 82, 56],
                                        },
                                        {
                                            name: "Revenue",
                                            data: [11, 32, 45, 32, 34, 52, 41],
                                        },
                                        {
                                            name: "Customers",
                                            data: [15, 11, 32, 18, 9, 24, 11],
                                        },
                                    ],
                                    chart: {
                                        height: 350,
                                        type: "area",
                                        toolbar: {
                                            show: false,
                                        },
                                    },
                                    markers: {
                                        size: 4,
                                    },
                                    colors: ["#4154f1", "#2eca6a", "#ff771d"],
                                    fill: {
                                        type: "gradient",
                                        gradient: {
                                            shadeIntensity: 1,
                                            opacityFrom: 0.3,
                                            opacityTo: 0.4,
                                            stops: [0, 90, 100],
                                        },
                                    },
                                    dataLabels: {
                                        enabled: false,
                                    },
                                    stroke: {
                                        curve: "smooth",
                                        width: 2,
                                    },
                                    xaxis: {
                                        type: "datetime",
                                        categories: [
                                            "2018-09-19T00:00:00.000Z",
                                            "2018-09-19T01:30:00.000Z",
                                            "2018-09-19T02:30:00.000Z",
                                            "2018-09-19T03:30:00.000Z",
                                            "2018-09-19T04:30:00.000Z",
                                            "2018-09-19T05:30:00.000Z",
                                            "2018-09-19T06:30:00.000Z",
                                        ],
                                    },
                                    tooltip: {
                                        x: {
                                            format: "dd/MM/yy HH:mm",
                                        },
                                    },
                                }
                            ).render();
                        });
                    </script>
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
                <h5 class="modal-title">All Lead Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><b>Client Name :</b> <span class="clientname"></span> </p>
                <p><b>Company Name :</b> <span class="companyname"></span> </p>
                <p><b>Phone :</b> <span class="phone"></span> </p>
                <p><b>Email :</b> <span class="email"></span> </p>
                <p><b>Services :</b> <span class="service"></span> </p>
                <p><b>Services Price:</b> <span class="price"></spanassign_user>
                </p>
                <p><b>Assign Meeting User :</b> <span class="assign_user"></span> </p>
                <p><b>Meeting Date :</b> <span class="meating_date"></span> </p>
                <p><b>Meeting Time :</b> <span class="meating_time"></span> </p>
                <p><b>Status : </b> <span class="status"></span> </p>
                <p><b>Remark : </b> <span class="remark"></span> </p>
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

<script>
    $(document).on('click', '.lead_id', function() {
        var dataId = $(this).attr("data-id");
        $('.service').empty();
        $.ajax({
            type: 'POST',
            url: "{{url('recent-lead')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": dataId
            },
            success: function(response) {
                console.log(response);
                $("#basicModal").modal('show');
                $(".clientname").text(response.data.client_name);
                $(".companyname").text(response.data.company_name);
                $(".phone").text(response.data.phone);
                $(".address").text(response.data.address);
                $(".email").text(response.data.email);
                $(".price").text(response.data.service_price);
                $(".create_date").text(response.data.created_date);
                $(".remark").text(response.data.remark);
                $(".meating_date").text(response.data.meating_date);
                $(".meating_time").text(response.data.meating_time);
                $.each(response.service, function(key, item) {
                    $('.service').append(item, ', ');
                });
                if (response.data.status == 1) {
                    $(".status").text("Close");
                } else if (response.data.status == 2) {
                    $(".status").text("Follow Up");
                } else if (response.data.status == 3) {
                    $(".status").text("Padding");
                } else {
                    (".status").text("Cancle");
                }

                if (response.data.typeofuser == 1) {
                    $(".assign_user").text(response.manager.name + ' (Manager)');
                } else if (response.data.typeofuser == 2) {
                    $(".assign_user").text(response.manager.firstname + ' ' + response.manager.lastname + ' (Marketing User)');
                } else if (response.data.typeofuser == 3) {
                    $(".assign_user").text(response.manager.bde_name + ' (B.D.E)');
                }

            }
        });

    });
</script>
@endpush