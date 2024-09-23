@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-check-circle-fill"></i> Meetings Report</h1>
        </div>
        <div class="col-lg-2">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-primary btn-sm text-white" href="{{url('admin/calling-list')}}">
                            <i class="bi bi-card-list"></i> Call List
                        </a>
                    </li>

                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body pb-0 m-4">
                    @if(Session::has('faild'))
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                        {{Session::get('faild')}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form method="post" action="{{route('backend.filter-meeting')}}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group m-2">
                                    <label> Type Of User<span class="text-danger">*</span></label>
                                    @php $arr = ['2'=>'Marketing','3'=>'Manager','4'=>'BDE']; @endphp

                                    <select id="user_type" name="user_type" class="form-control">
                                        <option value="0"> -- Select --</option>
                                        @if(isset($arr) && !empty($arr))
                                        @foreach($arr as $key=>$row)
                                        <option value="{{$key}}">{{$row}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <span class="text-danger">@error('team_person_name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group m-2">
                                    <label> Name </label>
                                    <select name="name" class="form-select staffUser">

                                    </select>
                                    <span class="text-danger">@error('name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group m-2">
                                    <label> Start Date</label>
                                    <input type="date" name="start_date" class="form-control">
                                    <span class="text-danger">@error('start_date') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group m-2">
                                    <label> End Date</label>
                                    <input type="date" name="end_date" class="form-control">
                                    <span class="text-danger">@error('end_date') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group mt-4 p-2">
                                    <button class="btn btn-primary" type="submit">Save</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            @if(isset($all_meeting) && !empty($all_meeting))
            @php
            $number=0;
            @endphp
            <div class="card">
                <div class="m-2">
                    <table class="table dataTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($all_meeting as $row)
                            @php
                            if(isset($row->status) && $row->status==1){
                            $status="Deal Close";
                            $badge="bg-success";
                            }elseif(isset($row->status) && $row->status==2){
                            $status="Follow Up";
                            $badge="bg-warning";
                            }else{
                            $status="Cancel";
                            $badge="bg-danger";
                            }
                            @endphp
                            <tr>
                                <td> {{$row->client_name}}</td>
                                <td>{{$row->company_name}}</td>
                                <td>{{$row->phone}}</td>
                                <td>{{$row->email}}</td>
                                <td>{{$row->address}}</td>
                                <td><span class="badge rounded-pill {{$badge}}">{{$status}}</span></td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            @endif

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
        $("#user_type").change(function() {
            let dataid = $(this).val();
            $('.staffUser').empty();
            $.ajax({
                type: 'POST',
                url: "{{route('backend.report-meeting-data')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": dataid
                },
                success: function(response) {
                    // console.log(response);
                    if (response.status == 100) {
                        $.each(response.team_person, function(key, value) {
                            $(".staffUser").append("<option value='" + value.id + "'>" + value.firstname + "</option>");
                        });

                    } else if (response.status == 200) {
                        $.each(response.team_person, function(key, value) {
                            $(".staffUser").append("<option value='" + value.id + "'>" + value.name + "</option>");
                        });
                    } else if (response.status == 300) {
                        $.each(response.team_person, function(key, value) {
                            $(".staffUser").append("<option value='" + value.id + "'>" + value.bde_name + "</option>");
                        });
                    }
                }

            });
        });
    });
</script>

<script>
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