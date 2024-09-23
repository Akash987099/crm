@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-archive text-danger"></i> Archive Manager Cold Call</h1>
            <nav>
                <ol class="breadcrumb">
                    <li><a><i class="bi bi-archive"></i> Archive</a></li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-2">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-danger text-white" href="{{route('backend.manager.view-manager')}}"><i class="bi bi-arrow-left"></i> Back</a></li>

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
                                <th style="width: 5%;">#</th>
                                <th style="width: 15%;">Client</th>
                                <th style="width: 15%;">Company</th>
                                <th style="width: 10%;">Phone</th>
                                <th style="width: 15%;">Email</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 30%;">Address</th>
                                <th style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($archiveColdcal))
                            @php
                            $sn=1;
                            $sts='';
                            $bg='';
                            @endphp
                            @foreach($archiveColdcal as $row_data)
                            @php
                            if($row_data->status==1){
                            $sts='Deal Close';
                            $bg='success';
                            }elseif($row_data->status==2){
                            $sts='Follow Up';
                            $bg='warning';
                            }else{
                            $sts='Residual';
                            $bg='danger';
                            }
                            @endphp
                            <tr>
                                <td>{{$sn++}}</td>
                                <td>{{$row_data->client_name}}</td>
                                <td>{{$row_data->company_name}}</td>
                                <td>{{$row_data->phone}}</td>
                                <td>{{$row_data->email}}</td>
                                <td><span class="badge rounded-pill bg-{{$bg}}"> {{$sts}}</span></td>
                                <td>{{$row_data->address}}</td>
                                <td><a title="Active" class="btn btn-info btn-sm text-danger" href="{{route('backend.manager-active-coldcall',['meetingid'=>Crypt::encrypt($row_data->id)])}}"> <i class="bi bi-arrow-clockwise"></i></a></td>
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
        let i = 1;
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