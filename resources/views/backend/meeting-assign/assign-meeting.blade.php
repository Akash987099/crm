@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-8">
            <h1><i class="bi bi-card-list"></i> Telemarketing </h1>
            <h1><i class="bi bi-person"></i> {{$telemarket->firstname.' '.$telemarket->lastname}}</h1>
        </div>
        <div class="col-lg-4">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-danger text-white" href="{{route('backend.telemarket.view-telemarketing')}}"><i class="bi bi-arrow-left"></i> Back</a></li>
                    <li class="p-1"><a class="btn btn-danger text-white" href="{{route('backend.telemarket.assign-meeting-archive',['marketid'=>Crypt::encrypt($telemarket->id)])}}"><i class="bi bi-archive"></i> Archive Assign Meetings</a></li>
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
                <div class="m-2" style="overflow-x: hidden;overflow-y: auto">
                    <table class="table dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Phone</th>
                                <th>Potential</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($assign_meeting) && !empty($assign_meeting))
                            @php $sn=1; @endphp
                            @foreach($assign_meeting as $row_data)
                            @php
                            if($row_data->client_potential==1){
                            $potential='Heigh';
                            $bg='success';
                            }elseif($row_data->client_potential==2){
                            $potential='Moderate';
                            $bg='warning';
                            }else{
                            $potential='Low';
                            $bg='danger';
                            }
                            @endphp
                            <tr>
                                <td>{{$sn++}}</td>
                                <td>{{$row_data->client_name}}</td>
                                <td>{{$row_data->company_name}}</td>
                                <td>{{$row_data->phone}}</td>
                                <td><span class="badge rounded-pill bg-{{$bg}}">{{$potential}}</span></td>
                                <td>{{$row_data->created_date}}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{route('backend.telemarket.assign-meetingDetails',['assignid'=>Crypt::encrypt($row_data->id)])}}"><i class="bi bi-eye"></i></a>
                                    <a class="btn btn-danger btn-sm" href="{{route('backend.telemarket.assign-meeting-delete',['assignid'=>Crypt::encrypt($row_data->id)])}}"><i class="bi bi-trash"></i></a>
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
        });
    });
</script>

@endpush