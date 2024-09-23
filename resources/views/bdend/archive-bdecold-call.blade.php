@extends('bdend.layout.master')

@section('content')
<div class="row">
    <div class="col-lg-9">
        <div class="pagetitle">
            <h1><i class="bi bi-archive"></i> Archive Cold Call</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Cold Call</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-lg-3">
        <nav>
            <ol class="breadcrumb">
                <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{route('bde.add-bde-coldcall')}}">
                        <i class="bi bi-card-list"></i> Add Cold Call
                    </a>
                </li>
                <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{route('bde.view-coldcall')}}">
                        <i class="bi bi-card-list"></i> View Cold Call
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
                                            <th>Address</th>
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
<!-- Basic Modal -->

<div class="modal fade basicModal" id="" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cold Call Details </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><b>Client Name :</b> <span class="clientname"></span> </p>
                <p><b>Company Name :</b> <span class="companyname"></span> </p>
                <p><b>Phone :</b> <span class="phone"></span> </p>
                <p><b>Email :</b> <span class="email"></span> </p>
                <p><b>Keyword :</b> <span class="keyword"></span> </p>
                <p><b>Services :</b> <span class="service"></span> </p>
                <p><b>Services Price:</b> <span class="price"></span> </p>

                <p><b>Payment Mode :</b> <span class="payment_mode"></span> </p>
                <p><b>Discount:</b> <span class="discount"></span>% </p>
                <p><b>Advanc Amount:</b> <span class="advance_amount"></span> </p>
                <p><b>Blance:</b> <span class="blance"></span> </p>
                <p><b>Follow Up Date:</b> <span class="followup"></span> </p>
                <p><b>Address :</b> <span class="address"></span> </p>

                <div class="row">
                    <div class="col-lg-4">
                        <label>Visiting Card :</label>
                        <div class="visitingcard"></div>
                    </div>
                    <div class="col-lg-4">
                        <label>Shop/Image :</label>
                        <div class="shop_img"></div>
                    </div>
                    <div class="col-lg-4">
                        <label>Amount Image :</label>
                        <div class="amount_pic"></div>
                    </div>
                </div>
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




<script>
    // $(document).on('click', '.coldcall_id', function() {
    //     var dataId = $(this).attr("data-id");
    //     $('.service').empty();
    //     $.ajax({
    //         type: 'POST',
    //         url: "{{url('marketing/coldcall-view-details')}}",
    //         data: {
    //             "_token": "{{ csrf_token() }}",
    //             "id": dataId
    //         },
    //         success: function(response) {
    //             //console.log(data);
    //             $(".basicModal").modal('show');
    //             $(".clientname").text(response.data.name);
    //             $(".companyname").text(response.data.company_name);
    //             $(".phone").text(response.data.phone);
    //             $(".address").text(response.data.address);
    //             $(".email").text(response.data.email);
    //             $(".price").text(response.data.service_price);
    //             $(".discount").text(response.data.discount);
    //             $(".advance_amount").text(response.data.advance_amount);
    //             $(".blance").text(response.data.blance);
    //             $(".followup").text(response.data.followup_date);
    //             $(".keyword").text(response.data.keywords);
    //             $(".create_date").text(response.data.created_date);
    //             $(".remark").text(response.data.remark);
    //             $.each(response.service, function(key, item) {
    //                 $('.service').append(item, ', ');
    //             });
    //             if (response.data.status == 1) {
    //                 $(".status").text("Interested");
    //             } else if (response.data.status == 2) {
    //                 $(".status").text("Not Interested");
    //             } else {
    //                 $(".status").text("Padding");
    //             }

    //             if (response.data.payment_mode == 1) {
    //                 $(".payment_mode").text('Cash');
    //             } else if (response.data.payment_mode == 2) {
    //                 $(".payment_mode").text('Check');
    //             } else if (response.data.payment_mode == 3) {
    //                 $(".payment_mode").text('Volit');
    //             } else {
    //                 $(".payment_mode").text('Networking');
    //             }
    //             if (response.data.visiting_card == '' || response.data.visiting_card == 'null') {
    //                 $('.visitingcard').html('<img src="assets/img/no-image.png" />');
    //                 $('.visitingcard img').css({
    //                     'width': '200px',
    //                     'height': '200px'
    //                 });
    //             } else {
    //                 $('.visitingcard').html('<img src="/assets/uploads/meeting/visitingCard/' + response.data.visiting_card + '" />');
    //                 $('.visitingcard img').css({
    //                     'width': '200px',
    //                     'height': '200px'
    //                 });
    //             }


    //             if (response.data.shop_img == '' || response.data.shop_img == 'null') {
    //                 $('.shop_img').html('<img src="assets/img/no-image.png" />');
    //                 $('.shop_img img').css({
    //                     'width': '200px',
    //                     'height': '200px'
    //                 });
    //             } else {
    //                 $('.shop_img').html('<img src="/assets/uploads/meeting/shopImage/' + response.data.shop_img + '" />');
    //                 $('.shop_img img').css({
    //                     'width': '200px',
    //                     'height': '200px'
    //                 });
    //             }
    //             if (response.data.amount_pic === '' || response.data.amount_pic == null) {
    //                 $(".amount_pic").hide();
    //             } else {
    //                 $('.amount_pic').html('<img src="/assets/uploads/meeting/amount_pic/' + response.data.amount_pic + '" />');
    //                 $('.amount_pic img').css({
    //                     'width': '200px',
    //                     'height': '200px'
    //                 });
    //             }

    //         }
    //     });

    // });


    //////////////////////////////////DATA TABLE//////////////////////////////////////////////////
    $(function() {
        var i = 1;
        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('bde/archive-bde-coldcall') }}",

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
                    data: 'address',
                    name: 'address'
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
                            return '<span class="badge rounded-pill bg-danger">Residual</span>';
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