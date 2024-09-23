@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-card-list"></i> All Calls (Telemarketing)</h1>
            <h1><i class="bi bi-person"></i> {{$user->firstname.' '.$user->lastname}}</h1>
        </div>
        <div class="col-lg-2">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-danger text-white" href="{{route('backend.telemarket.view-telemarketing')}}"><i class="bi bi-arrow-left"></i> Back</a></li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="m-3">
                    @if(Session::has('success'))
                    <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                        {{Session::get('success')}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <table class="table table-responsive dataTables_length dataTable" cellspacing="0" width="100%">
                        <thead>

                            <tr>
                                <th style="width:5%">#</th>
                                <th style="width:20%">Client Name</th>
                                <th style="width:20%">Mobile</th>
                                <th style="width:20%">Remark</th>
                                <th style="width:20%">Tele User</th>
                                <th style="width:15%">Action</th>
                            </tr>

                        </thead>
                        <tbody>



                            @if(isset($data) && !empty($data))
                            @php $sn=1; @endphp
                            @foreach($data as $row)
                            @php $user = DB::table('tele_person')->where('id', $row->user_id)->first(); @endphp
                            <tr>
                                <td>{{$sn++}}</td>
                                <td>{{$row->client_name}}</td>
                                <td>{{$row->mobile}}</td>
                                <td>{{$row->remark}}</td>
                                <td>{{($row->user_type == 1)?'Admin':$user->firstname.' '.$user->lastname}}</td>
                                <td><a class="btn btn-primary btn-sm" title="Update" href="{{url('admin/edit-call/'. Crypt::encrypt($row->id))}}"><i class="bi bi-pencil-square"></i></a> <a class="btn btn-danger btn-sm" title="Delete" href="{{url('admin/delete-call/'. Crypt::encrypt($row->id))}}"><i class="bi bi-trash"></i></a></td>
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
<script>
    $(document).ready(function() {
        $('.select2').select2({
            closeOnSelect: false
        });

    });

    $(function() {
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