{{-- @extends('backend.layout.master') --}}

@extends('employee.master')

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

                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
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
                        <div class="card-body">
                            <h5 class="card-title">Leave</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cart"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$leave}}</h6>
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
                                Total Lead
                            </h5>
                         
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    {{-- <i class="bi bi-currency-rupee"></i> --}}
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$lead}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Total Agent
                            </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex bg-success text-white align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6>{{$agent}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-xxl-4 col-xl-12">
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
                                   

                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="col-xxl-4 col-xl-12">
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
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="col-xxl-4 col-xl-12">
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
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

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

                {{-- <div class="card-body pb-0">
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
                           
                        </tbody>
                    </table>
                </div> --}}
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
  
</script>
@endpush