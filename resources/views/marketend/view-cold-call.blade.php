@extends('marketend.layout.master')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="pagetitle">
            <h1>Cold Call</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Cold Call</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-lg-4">
        <nav>
            <ol class="breadcrumb">

                <li class="p-1 addMeeting"><a class="btn btn-primary btn-sm text-white" href="{{url('marketing/cold-call')}}">
                        <i class="bi bi-card-list"></i> Add Cold Call
                    </a>
                </li>


                <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{url('marketing/archive-cold-call')}}">
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
    // var d = new Date();
    // if (d.getHours() >= 10 && d.getHours() <= 21) {
    //     $(".addMeeting").show();
    // } else {
    //     $(".addMeeting").hide();
    // }

    // $(document).on('click', '.coldcall_id', function() {
    //     var dataId = $(this).attr("data-id");
    //     $('.service').empty();
    //     $.ajax({
    //         type: 'POST',
    //         url: "{{route('market.coldcall-view-details')}}",
    //         data: {
    //             "_token": "{{ csrf_token() }}",
    //             "id": dataId
    //         },
    //         success: function(response) {
    //             console.log(response);
    //             $(".basicModal").modal('show');
    //             $(".clientname").text(response.data.client_name);
    //             $(".companyname").text(response.data.company_name);
    //             $(".phone").text(response.data.phone);
    //             $(".address").text(response.data.address);
    //             $(".email").text(response.data.email);
    //             $(".price").text(response.data.service_price);
    //             $(".discount").text(response.data.discount);
    //             $(".advance_amount").text(response.data.advance_amount);
    //             $(".blance").text(response.data.blance);
    //             $(".followup").text(response.data.followup_date);
    //             $(".residual").text(response.data.residual);
    //             $(".keyword").text(response.data.keywords);
    //             $(".create_date").text(response.data.created_date);
    //             $(".remark").text(response.data.remark);
    //             $.each(response.service, function(key, value) {
    //                 $('.service').append("<span>" + value.service_name + ", </span>");
    //             });
    //             if (response.data.status == 1) {
    //                 $(".status").text("Deal Close");
    //             } else if (response.data.status == 2) {
    //                 $(".status").text("Follow Up");
    //             } else {
    //                 $(".status").text("Residual");
    //             }

    //             if (response.data.payment_mode == 1) {
    //                 $(".payment_mode").text('Cash');
    //             } else if (response.data.payment_mode == 2) {
    //                 $(".payment_mode").text('cheque');
    //             } else if (response.data.payment_mode == 3) {
    //                 $(".payment_mode").text('Wallet');
    //             } else {
    //                 $(".payment_mode").text('Internet Banking');
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
            ajax: "{{ url('marketing/view-cold-list') }}",

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
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        if (data == 1) {
                            return '<span class="badge rounded-pill bg-success">Deal Close</span>';
                        } else if (data == 2) {
                            return '<span class="badge rounded-pill bg-warning">Follow Up</span>';
                        } else {
                            return '<span class="badge rounded-pill bg-danger">Cancle</span>';
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