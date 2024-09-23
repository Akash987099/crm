@extends('backend.layout.master')

@section('content')


<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1><i class="bi bi-card-list"></i> Our Services</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li><a class="btn btn-primary btn-sm text-white" href="{{url('admin/add-service')}}"><i class="bi bi-plus"></i> Add Services</a></li>
                    &nbsp;
                    <li><a class="btn btn-danger btn-sm text-white" href="{{url('admin/archive-service')}}"> <i class="bi bi-archive"></i> Archive Services</a></li>
                </ol>
            </nav>
        </div>
    </div>


</div>

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
                                <th style="width: 5%;">S.no.</th>
                                <th style="width: 15%;">Service</th>
                                <th style="width: 10%;">Price</th>
                                <th style="width: 10%;">company</th>
                                <th style="width: 30%;">Description</th>
                                <th style="width: 10%;">Status</th>
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
<!-- Basic Modal -->

<div class="modal fade" id="basicModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Service Details </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><b>Service Name :</b> <span class="servicename"></span> </p>
                <p><b>Service Price :</b> <span class="price"></span> </p>
                <p><b>Company :</b> <span class="company"></span> </p>
                <p><b>Description :</b> <span class="description"></span> </p>
                <p><b>Status :</b> <span class="status"></span> </p>
                <p><b>Create Date :</b> <span class="created_date"></span> </p>


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

<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

<script type="text/javascript">
    $(document).on('click', '.service_id', function() {
        var dataId = $(this).attr("data-id");
        $('.service').empty();
        $.ajax({
            type: 'POST',
            url: "{{url('admin/service-view-modal')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": dataId
            },
            success: function(data) {

                $("#basicModal").modal('show');
                $(".servicename").text(data.data.service_name);
                $(".price").text(data.data.service_price);
                $(".company").text(data.data.company);
                $(".description").text(data.data.description);
                $(".created_date").text(data.data.created_date);
                if (data.data.status == 0) {
                    $(".status").text("Active");
                } else {
                    $(".status").text("Inactive");
                }


                if (data.data.visiting_card == '' || data.data.visiting_card == null) {
                    $('.visitingcard').html('<img src="assets/img/no-image.png" />');
                    $('.visitingcard img').css({
                        'width': '200px',
                        'height': '200px'
                    });
                } else {
                    $('.visitingcard').html('<img src="/assets/uploads/meeting/visitingCard/' + data.data.visiting_card + '" />');
                    $('.visitingcard img').css({
                        'width': '200px',
                        'height': '200px'
                    });
                }


                if (data.data.shop_img == '' || data.data.shop_img == null) {
                    $('.shop_img').html('<img src="assets/img/no-image.png" />');
                    $('.shop_img img').css({
                        'width': '200px',
                        'height': '200px'
                    });
                } else {
                    $('.shop_img').html('<img src="/assets/uploads/meeting/shopImage/' + data.data.shop_img + '" />');
                    $('.shop_img img').css({
                        'width': '200px',
                        'height': '200px'
                    });
                }


            }
        });

    });



    //////////////////////////////////////////DATA TABLE//////////////////////////////////////////////
    $(function() {
        var i = 1;
        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/services') }}",

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

            columns: [{
                    "render": function() {
                        return i++;
                    }
                },

                {
                    data: 'service_name',
                    name: 'service_name'
                },
                {
                    data: 'service_price',
                    name: 'service_price'
                },

                {
                    data: 'company',
                    name: 'company'
                },

                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, full, meta) {
                        if (data == 0) {
                            return '<span class="badge rounded-pill bg-success">Active</span>';
                        } else {
                            return '<span class="badge rounded-pill bg-danger">Inactive</span>';
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