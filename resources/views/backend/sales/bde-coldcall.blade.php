@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1><i class="bi bi-person"></i> {{$user->bde_name}} (Cold Call)</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-danger text-white" href="{{route('backend.bde.view-bde')}}"><i class="bi bi-arrow-left"></i> Back</a></li>
                    <li class="p-1"><a class="btn btn-danger text-white" href="{{route('backend.bde-coldcall-archive',['bdeid'=>Crypt::encrypt($user->id)])}}"><i class="bi bi-archive"></i> Archive Cold Call</a></li>
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
                <div class="m-2">
                    <table class="table dataTable table-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Client Name</th>
                                <th>Company</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($meeting) && !empty($meeting))
                            @php $sn=1; @endphp
                            @foreach($meeting as $row_value)
                            @php
                            if($row_value->status==1){
                            $sts='Deal Close';
                            $bg='success';
                            }elseif($row_value->status==1){
                            $sts='Follow Up';
                            $bg='warning';
                            }else{
                            $sts='Residual';
                            $bg='danger';
                            }
                            @endphp

                            <tr>
                                <td>{{$sn++}}</td>
                                <td>{{$row_value->client_name}}</td>
                                <td>{{$row_value->company_name}}</td>
                                <td>{{$row_value->phone}}</td>
                                <td>{{$row_value->email}}</td>
                                <td><span class="badge rounded-pill bg-{{$bg}}"> {{$sts}}</span></td>
                                <td>
                                    <a target="_blank" href="{{route('backend.bde-coldcall-details',['meetingid'=>Crypt::encrypt($row_value->id)])}}" title="View Data" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i></a>
                                    <a href="{{route('backend.bde-coldcall-delete',['meetingid'=>Crypt::encrypt($row_value->id)])}}" title="Delete" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                                </td>
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