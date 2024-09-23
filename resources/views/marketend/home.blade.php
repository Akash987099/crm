@extends('marketend.layout.master')

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
                            <h5 class="card-title">Sales </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>₹{{$total_sale}}</h6>
                                    <!-- <span class="text-success small pt-1 fw-bold">12%</span>
                                    <span class="text-muted small pt-2 ps-1">increase</span> -->
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
                                Revenue
                            </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger text-white">
                                    <i class="bi bi-currency-rupee"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$devit}}</h6>
                                    <!-- <span class="text-success small pt-1 fw-bold">8%</span>
                                    <span class="text-muted small pt-2 ps-1">increase</span> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">

                        <div class="card-body">
                            <h5 class="card-title">
                                Sale <span>| Today</span>
                            </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning text-white">
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

                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Total Meeting
                            </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success text-white">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$total_meetings}}</h6>
                                    <!-- <span class="text-success small pt-1 fw-bold">8%</span>
                                    <span class="text-muted small pt-2 ps-1">increase</span> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Total Cold Call
                            </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info text-white">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$total_coldcall}}</h6>
                                    <!-- <span class="text-success small pt-1 fw-bold">8%</span>
                                    <span class="text-muted small pt-2 ps-1">increase</span> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <!-- Recent Activity -->
            <div class="card">
                <div class="card-body pb-0">
                    <h5 class="card-title">Recent Meetings &nbsp; <span> @php date_default_timezone_set('Asia/Kolkata'); echo date('d-m-Y H:i'); @endphp</span></h5>

                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Address</th>
                                <th scope="col">Created Date</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($recent_meeting) && !empty($recent_meeting))
                            @foreach($recent_meeting as $row)
                            <tr>
                                <td>
                                    <a href="#" data-id="{{Crypt::encrypt($row->id)}}" class="text-primary meeting_id">
                                        {{$row->client_name}}
                                    </a>
                                </td>
                                <td>{{substr($row->address,0,15)}}</td>
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

                <!-- <div class="card-body">
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
                </div> -->
            </div>
        </div>
    </div>
</section>

<!-- Basic Modal -->

<div class="modal fade meeting_modal" id="" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Meeting Response Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><b>Client Name :</b> <span class="clientname"></span> </p>
                <p><b>Company Name :</b> <span class="companyname"></span> </p>
                <p><b>Phone :</b> <span class="phone"></span> </p>
                <p><b>Email :</b> <span class="email"></span> </p>
                <p><b>Keyword :</b> <span class="keyword"></span> </p>
                <p><b>Services :</b> <span class="service"></span> </p>
                <p><b>Services Price:</b> <span class="price"></span> </p>
                <p><b>Discount:</b> <span class="discount"></span>% </p>
                <p><b>Balance:</b> <span class="blance"></span> </p>
                <p><b>Follow Up Date:</b> <span class="followup"></span> </p>
                <p><b>Address :</b> <span class="address"></span> </p>

                <div class="row">
                    <div class="col-lg-4">
                        <label>Visiting Card :</label>
                        <div class="visitingcard"></div>
                    </div>
                    <div class="col-lg-4">
                        <label>Shop/Image :</label>
                        <div class="shop_img"></div>
                    </div>
                    <div class="col-lg-4">
                        <label>Amount Image :</label>
                        <div class="amount_pic"></div>
                    </div>
                </div>
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
    $(document).on('click', '.meeting_id', function() {
        var dataId = $(this).attr("data-id");
        $('.service').empty();
        $.ajax({
            type: 'POST',
            url: "{{route('market.views-recent-meeting-data')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "dataId": dataId
            },
            success: function(response) {
                $(".meeting_modal").modal('show');
                $(".companyname").text(response.data.company_name);
                $(".phone").text(response.data.phone);
                $(".address").text(response.data.address);
                $(".email").text(response.data.email);
                $(".keyword").text(response.data.keywords);
                $(".price").text(response.data.service_price);
                $(".discount").text(response.data.discount);
                $(".blance").text(response.data.blance);
                $(".followup").text(response.data.followup_date);

                $.each(response.service, function(key, item) {
                    $('.service').append(item, ', ');
                });
                if (response.data.type == 1) {
                    $(".clientname").text(response.data.client_name);
                } else {
                    $(".clientname").text(response.data.name);
                }


                if (response.data.payment_mode == 1) {
                    $(".payment_mode").text('Cash');
                } else if (response.data.payment_mode == 2) {
                    $(".payment_mode").text('Check');
                } else if (response.data.payment_mode == 3) {
                    $(".payment_mode").text('Volit');
                } else {
                    $(".payment_mode").text('Networking');
                }

                if (response.data.visiting_card == '' || response.data.visiting_card == null) {
                    $('.visitingcard').html('<img src="assets/img/no-image.png" />');
                    $('.visitingcard img').css({
                        'width': '200px',
                        'height': '200px'
                    });
                } else {
                    $('.visitingcard').html('<img src="/assets/uploads/meeting/visitingCard/' + response.data.visiting_card + '" />');
                    $('.visitingcard img').css({
                        'width': '200px',
                        'height': '200px'
                    });
                }

                if (response.data.shop_img == '' || response.data.shop_img == null) {
                    $('.shop_img').html('<img src="assets/img/no-image.png" />');
                    $('.shop_img img').css({
                        'width': '200px',
                        'height': '200px'
                    });
                } else {
                    $('.shop_img').html('<img src="/assets/uploads/meeting/shopImage/' + response.data.shop_img + '" />');
                    $('.shop_img img').css({
                        'width': '200px',
                        'height': '200px'
                    });
                }
                if (response.data.amount_pic == '' || response.data.amount_pic == null) {
                    $('.amount_pic').html('<img src="assets/img/no-image.png" />');
                    $('.amount_pic img').css({
                        'width': '200px',
                        'height': '200px'
                    });
                } else {
                    $('.amount_pic').html('<img src="/assets/uploads/meeting/amount_pic/' + response.data.amount_pic + '" />');
                    $('.amount_pic img').css({
                        'width': '200px',
                        'height': '200px'
                    });
                }


            }

        });

    });
</script>
@endpush