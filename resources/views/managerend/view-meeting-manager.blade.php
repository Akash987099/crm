@extends('managerend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-card-list"></i> All Attend Meetings</h1>
        </div>
        <div class="col-lg-2">
            <nav>
                <ol class="breadcrumb">
                    <li><a class="btn btn-danger btn-sm text-white" href="{{route('manager.archive-meeting')}}"><i class="bi bi-archive"></i> Archive Client</a></li>
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
                    <table class="table table-responsive dataTables_length dataTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 15%;">Client Name</th>
                                <th style="width: 15%;">Company Name</th>
                                <th style="width: 5%;">Phone</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width:20%">Action</th>
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
                <h5 class="modal-title">Assign Meating Information </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><b>Client Name :</b> <span class="clientname"></span> </p>
                <p><b>Company Name :</b> <span class="companyname"></span> </p>
                <p><b>Phone :</b> <span class="phone"></span> </p>
                <p><b>Email :</b> <span class="email"></span> </p>
                <p><b>Category :</b> <span class="category"></span> </p>
                <p><b>Services :</b> <span class="service"></span> </p>
                <p><b>Total Services Price: ₹</b> <span class="price"></span> </p>
                <p><b>Discount:</b> <span class="discount"></span>% </p>
                <p><b>Balance: ₹</b> <span class="balance"></span></p>
                <p><b>Payment Mode:</b> <span class="payment_mode"></span></p>
                <p><b>Follow Up Date :</b> <span class="followup"></span></p>
                <p><b>Residual Date :</b> <span class="residual"></span></p>
                <p><b>Status :</b> <span class="status"></span> </p>
                <p><b>Create Date :</b> <span class="create_date"></span> </p>
                <p><b>Address :</b> <span class="address"></span> </p>
                <p><b>Remak/Note :</b> <span class="remark"></span> </p>
                <div class="row">
                    <div class="col-lg-4">
                        <label>Visiting Card :</label>
                        <br>
                        <div class="visitingcard mt-2"></div>
                    </div>
                    <div class="col-lg-4">
                        <label>Shop/Image :</label>
                        <div class="shop_img mt-2"></div>
                    </div>
                    <div class="col-lg-4">
                        <label>Amount Pic :</label>
                        <div class="amount_pic mt-2"></div>
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

<script type="text/javascript">
    $(document).on('click', '.meetingid', function() {
        var meetingid = $(this).attr("data-id");
        $('.service').empty();
        $.ajax({
            type: 'POST',
            url: "{{route('manager.meeting-modelData')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "meetingid": meetingid
            },
            success: function(response) {
                console.log(response);
                $("#basicModal").modal('show');
                $(".clientname").text(response.data.client_name);
                $(".companyname").text(response.data.company_name);
                $(".phone").text(response.data.phone);
                $(".address").text(response.data.address);
                $(".email").text(response.data.email);
                $(".category").text(response.data.keywords);
                $(".price").text(response.data.service_price);
                $(".discount").text(response.data.discount);
                $(".balance").text(response.data.blance);
                $(".followup").text(response.data.followup_date);
                $(".residual").text(response.data.residual);
                $(".create_date").text(response.data.created_date);
                $(".remark").text(response.data.remark);
                $.each(response.service, function(key, value) {
                    $('.service').append("<span>" + value.service_name + ",  Price - " + value.service_price + " , " + "</span>");
                });
                if (response.data.payment_mode == 1) {
                    $(".payment_mode").text('Cash');
                } else if (response.data.payment_mode == 2) {
                    $(".payment_mode").text('Cheque');
                } else if (response.data.payment_mode == 3) {
                    $(".payment_mode").text('Wallet');
                } else {
                    $(".payment_mode").text('Internet Banking');
                }

                if (response.data.user_type == 1) {
                    $(".team_person").text('Admin');
                } else {
                    $(".team_person").text(response.team_person);
                }

                if (response.data.status == 1) {
                    $(".status").text("Deal Close");
                } else if (response.data.status == 2) {
                    $(".status").text("Follow Up");
                } else {
                    $(".status").text("Residual");
                }


                if (response.data.visiting_card == '' || response.data.visiting_card == null) {
                    $('.visitingcard').html('<img src="assets/img/no-image.png" />');
                    $('.visitingcard img').css({
                        'width': '200px',
                        'height': '200px'
                    });
                } else {
                    $('.visitingcard').html('<img src="/assets/uploads/meeting/visitingCard/' + response.data.visiting_card + '" />');
                    $('.visitingcard img').css({
                        'width': '200px',
                        'height': '200px'
                    });
                }


                if (response.data.shop_img == '' || response.data.shop_img == null) {
                    $('.shop_img').html('<img src="assets/img/no-image.png" />');
                    $('.shop_img img').css({
                        'width': '200px',
                        'height': '200px'
                    });
                } else {
                    $('.shop_img').html('<img src="/assets/uploads/meeting/shopImage/' + response.data.shop_img + '" />');
                    $('.shop_img img').css({
                        'width': '200px',
                        'height': '200px'
                    });
                }
                if (response.data.amount_pic == '' || response.data.amount_pic == null) {
                    $('.amount_pic').html('<img src="assets/img/no-image.png" />');
                    $('.amount_pic img').css({
                        'width': '200px',
                        'height': '200px'
                    });
                } else {
                    $('.amount_pic').html('<img src="/assets/uploads/meeting/amount_pic/' + response.data.amount_pic + '" />');
                    $('.amount_pic img').css({
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
            ajax: "{{ route('manager.view-meeting-manager') }}",

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
                    data: 'status',
                    name: 'status',
                    render: function(data, type, full, meta) {
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