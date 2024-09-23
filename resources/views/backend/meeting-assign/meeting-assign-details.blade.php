@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-person"></i> {{$user->firstname}}</h1>
        </div>
        <div class="col-lg-2">
            <nav>
                <ol class="breadcrumb">
                    <li class=""><a class="btn btn-danger btn-sm text-white" href="{{route('backend.telemarket.view-telemarketing')}}"><i class="bi bi-arrow-left"></i> Back</a></li>

                </ol>
            </nav>
        </div>
    </div>
</div>

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
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-9">
                            <strong>{{$meeetingData->created_date}}</strong>
                        </div>
                        <div class="col-lg-3">
                            <div class="float-right"> <strong>Status :</strong>
                                @if($meeetingData->meeting_status == 1)
                                <span class="badge rounded-pill bg-success">{{'Deal Close'}}</span>
                                @elseif($meeetingData->meeting_status == 2)
                                <span class="badge rounded-pill bg-warning">{{'Follow Up'}}</span>
                                @else
                                <span class="badge rounded-pill bg-danger">{{'Residual'}}</span>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-6 lh-lg">
                            <div>
                                <p class="text-danger">To whom the meeting is assigned : <span class="text-success">
                                        @if($meeetingData->typeofuser == 1)
                                        {{DB::table('managers')->where('id', $meeetingData->assign_meating)->where('archive', 0)->value('name')}} (Manager)
                                        @elseif($meeetingData->typeofuser == 2)
                                        {{DB::table('marketing_users')->where('id', $meeetingData->assign_meating)->where('archived', 0)->value('firstname')}} (Marketing)
                                        @else
                                        {{DB::table('bdes')->where('id', $meeetingData->assign_meating)->where('archive', 0)->value('bde_name')}} (B.D.E)
                                        @endif
                                    </span>
                                </p>

                            </div>
                            <div> <b>Client Name :</b> {{$meeetingData->client_name}}</div>
                            <div><b>Company :</b> {{$meeetingData->company_name}}</div>
                            <div><b>Email :</b> {{$meeetingData->email}}</div>
                            <div><b>Phone :</b> {{$meeetingData->phone}}</div>
                            <div><b>Meeting Date :</b> {{$meeetingData->meating_date}}</div>
                            <div><b>Meeting Time :</b> {{$meeetingData->meating_time}}</div>
                            @if($meeetingData->meeting_status == 2)
                            <div><b>Follow Up Date :</b> {{$meeetingData->followup_date}}</div>
                            @endif
                            @if($meeetingData->meeting_status == 3)
                            <div><b>Reschedule Date :</b> {{$meeetingData->reschedule}}</div>
                            @endif
                            <div><b>Remark :</b> <br>
                                <textarea class="form-control" readonly>{{$meeetingData->remark}}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <p class="fw-light fs-3">Address</p>
                            <p class="fw-normal">{{$meeetingData->address}}</p>
                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>
</section>


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
    //////////////////////////////////////////DATA TABLE//////////////////////////////////////////////
    $(function() {
        var i = 1;
        var table = $('.dataTable').DataTable({
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
        });
    });
</script>

@endpush