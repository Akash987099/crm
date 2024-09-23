@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-card-list"></i> All Admin Users</h1>
        </div>
        <div class="col-lg-2">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{url('admin/create-admin-user')}}"><i class="bi bi-plus-circle"></i> Add Users</a></li>

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
                    <table class="table table-responsive dataTables_length dataTable" cellspacing="0" width="100%">
                        <thead>

                            <tr>
                                <th style="width: 10%;">#</th>
                                <th style="width: 15%;">Name</th>
                                <th style="width: 15%;">Email</th>
                                <th style="width: 15%;">Phone</th>
                                <th style="width: 15%;">Address</th>
                                <th style="width:15%">Action</th>
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

<script type="text/javascript">
    $(function() {
        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/user-admin') }}",
            columns: [{
                    data: 'image',
                    name: 'image',
                    "render": function(data) {
                        return '<img src="{{asset("assets/img/profile-img.jpg")}}" alt="Profile" class="rounded-circle" style="width:40px">'
                    }
                },
                {
                    data: 'name',
                    name: 'name'
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
                    data: 'address',
                    name: 'address'
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