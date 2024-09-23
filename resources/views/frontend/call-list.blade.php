@extends('frontend.layout.master')

@section('content')

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-card-list"></i> All Calls</h1>
        </div>
        <div class="col-lg-2">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{url('/client-calling')}}"><i class="bi bi-plus-circle"></i> Add Call</a></li>

                </ol>
            </nav>
        </div>
    </div>


</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body pb-0">

                    @if(Session::has('success'))
                    <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                        {{Session::get('success')}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                </div>
                <div class="m-2">

                    <table class="table dataTable" cellspacing="0" width="100%">
                        <thead>

                            <tr>
                                <th style="width: 10%;">#</th>
                                <th style="width: 15%;">Name</th>
                                <th style="width: 15%;">Phone</th>
                                <th style="width: 25%;">Remark</th>
                                <th style="width: 15%;">Status</th>
                                <th style="width: 20%;">Action</th>
                            </tr>

                        </thead>
                        <tbody>

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
    $(function() {
        var i = 1;
        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/View-call-list') }}",

            dom: 'Blfrtip',
            buttons: [{
                    extend: 'pdf',
                    exportOptions: {
                        columns: [1, 2, 3, 4]
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2, 3]
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
                    data: 'mobile',
                    name: 'mobile'
                },

                {
                    data: 'remark',
                    name: 'remark'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        if (data == 0) {
                            return '<span class="badge rounded-pill bg-success">Interested</span>';
                        } else {
                            return '<span class="badge rounded-pill bg-danger">Not Interested</span>';
                        }

                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>

@endpush