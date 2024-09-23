@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1><i class="bi bi-card-list"></i> Cold Call</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li><a class="btn btn-primary btn-sm text-white" href="{{url('admin/add-cold-calls')}}"><i class="bi bi-plus-circle"></i> Add Cold Call</a></li>
                    &nbsp;
                    <li><a class="btn btn-danger btn-sm text-white" href="{{url('admin/archive-cold-call')}}"><i class="bi bi-archive"></i> Archive Cold Call</a></li>
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
                    <table class="table table-responsive dataTable" cellspacing="0" width="100%">
                        <thead>

                            <tr>
                                <th style="width:5%;">#</th>
                                <th style="width:15%;">Client</th>
                                <th style="width:10%;">Company</th>
                                <th style="width:10%;">Phone</th>
                                <th style="width:10%;">Status</th>
                                <th style="width:20%;">Address</th>
                                <th style="width:30%;">Action</th>
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
    /////////////////////////////////DATA TABLE/////////////////////////////////////////////////////

    $(function() {
        var i = 1;
        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('backend.view-cold-call') }}",

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
                        columns: [0, 1, 2, 3, 4, 5, 6]
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
                    data: "client_name",
                    name: "client_name"
                },
                {
                    data: "company_name",
                    name: "company_name"
                },

                {
                    data: "phone",
                    name: "phone"
                },


                {
                    data: "status",
                    name: "status",
                    render: function(data, type, row) {
                        if (data == 1) {
                            return '<span class="badge rounded-pill bg-success">Deal Close</span>';
                        } else if (data == 2) {
                            return '<span class="badge rounded-pill bg-warning"> Follow Up</span>';
                        } else {
                            return '<span class="badge rounded-pill bg-danger">Cancle</span>';
                        }

                    }
                },
                {
                    data: "address",
                    name: "address"
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>

@endpush