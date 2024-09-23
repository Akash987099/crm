@extends('managerend.layout.master')

@section('content')


<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1><i class="bi bi-card-list"></i> Telemarketing</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{url('manager/madd-tele-team')}}"><i class="bi bi-plus-circle"></i> Add User</a></li>
                    <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{url('manager/archive-mtele-team')}}"><i class="bi bi-archive"></i> Archive User</a></li>
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
                                <th>#</th>
                                <th>User Name</th>
                                <th>Staff Id</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Joining Date</th>
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
</section>
<!-- Basic Modal -->

<div class="modal fade" id="basicModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tele Marketing Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><b>Staff ID :</b> <span class="staffid"></span> </p>
                <p><b>Staff Role :</b> <span class="staff_role"></span> </p>
                <p><b>First Name :</b> <span class="firstname"></span> </p>
                <p><b>Last Name :</b> <span class="lastname"></span> </p>
                <p><b>Phone :</b> <span class="phone"></span> </p>
                <p><b>Email :</b> <span class="email"></span> </p>
                <p><b>Joining Date :</b> <span class="joining_date"></span> </p>
                <p><b>Address:</b> <span class="address"></span> </p>
                <p><b>City : </b> <span class="city"></span> </p>
                <p><b>Pincode : </b> <span class="pincode"></span> </p>
                <p><b>State :</b> <span class="state"></span> </p>
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


<script>
    $(function() {
        var i = 1;
        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('manager/view-tele-team') }}",

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
                    data: 'image',
                    name: 'image',
                    render: function(data) {
                        return i++;
                        //return "<img class='rounded-circle' src=\"/assets/uploads/telemarketing/" + data + "\" width=\"40\"/ height=\"40\"/>";
                    }
                },
                {
                    data: 'firstname',
                    name: 'firstname'
                },
                {
                    data: 'staff_id',
                    name: 'staff_id'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'joining_date',
                    name: 'joining_date'
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

    ////////////////////////////END DATA TABLE//////////////////////////////////////////////

    $(document).on('click', '.tele_mteam', function() {
        var dataId = $(this).attr("data-id");
        alert(dataId);
        $.ajax({
            type: 'POST',
            url: "{{url('manager/view-details-tele-team')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": dataId
            },
            success: function(data) {
                $("#basicModal").modal('show');
                $(".firstname").text(data.data.firstname);
                $(".lastname").text(data.data.lastname);
                $(".email").text(data.data.email);
                $(".phone").text(data.data.phone);
                $(".joining_date").text(data.data.joining_date);
                $(".address").text(data.data.address);
                $(".city").text(data.data.city);
                $(".pincode").text(data.data.pincode);
                $(".state").text(data.data.state);
                $(".staffid").text(data.data.staff_id);
                $(".staff_role").text(data.data.staff_role);
                $(".created_date").text(data.data.created_date);
                // $.each(data.service, function(key, item) {
                //     //let option = '<option value ="' + item.id + '">' + item.color_name + '</option>';
                //     $('.service').append(item, ', ');
                // });
            }
        });

    });
</script>
@endpush