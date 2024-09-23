@extends('bdend.layout.master')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="pagetitle">
            <a>

                <h1><i class="bi bi-card-list"></i> Cold Call</h1>
            </a>
            <nav>
                <ol class="breadcrumb">

                    <li class="breadcrumb-item active">Cold Call</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-lg-4">
        <nav>
            <ol class="breadcrumb">
                <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{route('bde.add-bde-coldcall')}}">
                        <i class="bi bi-card-list"></i> Add Cold Call
                    </a>
                </li>
                <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{route('bde.archive-coldcall')}}">
                        <i class="bi bi-card-list"></i> Archive Cold Call
                    </a>
                </li>
            </ol>
        </nav>
    </div>
</div>





<section class="section profile">
    <div class="row">
        <div class="col-xl-12">

            <div class="card">
                <div class="card-body pt-2">
                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">

                            @if(Session::has('success'))
                            <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                                {{Session::get('success')}}
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <div class="m-2">
                                <table class="table table-responsive dataTable" cellspacing="0" width="100%">
                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Company</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
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

<script>
    //////////////////////////////////DATA TABLE//////////////////////////////////////////////////
    $(function() {
        var i = 1;
        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('bde.view-coldcall') }}",

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
                    data: 'company_name',
                    name: 'company_name'
                },

                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'email',
                    name: 'email'
                },

                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        if (data == 1) {
                            return '<span class="badge rounded-pill bg-success">Deal Close</span>';
                        } else if (data == 2) {
                            return '<span class="badge rounded-pill bg-warning">Follow Up</span>';
                        } else {
                            return '<span class="badge rounded-pill bg-danger">Reschedule</span>';
                        }

                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>
@endpush