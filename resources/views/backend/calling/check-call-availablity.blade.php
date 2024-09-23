@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-check-circle-fill"></i> Check Call Availability</h1>
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
                    @if(Session::has('success'))
                    <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                        {{Session::get('success')}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form method="post" action="{{url('admin/filter-call')}}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group m-2">
                                    <label> Name (Telemarketing Team)<span class="text-danger">*</span></label>
                                    <select name="team_person_name" class="form-control">
                                        <option value="0"> -- Select --</option>
                                        @php
                                        $tele_user = DB::table('tele_person')
                                        ->where('company_id',Session::get('company_id'))
                                        ->where('archive',0)->get();
                                        @endphp
                                        @if(isset($tele_user) && !empty($tele_user))
                                        @foreach($tele_user as $row)
                                        <option value="{{$row->id}}">{{$row->firstname.' '.$row->lastname}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <span class="text-danger">@error('team_person_name') {{$message}} @enderror</span>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group m-2">
                                    <label> Start Date</label>
                                    <input type="date" name="start_date" class="form-control">
                                    <span class="text-danger">@error('start_date') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group m-2">
                                    <label> End Date</label>
                                    <input type="date" name="end_date" class="form-control">
                                    <span class="text-danger">@error('end_date') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group mt-4 p-2">
                                    <button class="btn btn-primary" type="submit">Submit</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(isset($filter_transactions) && !empty($filter_transactions))
            @php
            $sn = 1;
            $number=0;
            @endphp
            <div class="card">
                <div class="m-2">
                    <table class="table table-responsive dataTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Phone</th>
                                <th>Client Name</th>
                                <th>Remark</th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach($filter_transactions as $row)
                            @php $number++; @endphp
                            <tr>
                                <td>{{$sn++}}</td>
                                <td>{{$row->mobile}}</td>
                                <td>{{$row->client_name}}</td>
                                <td>{{$row->remark}}</td>
                            </tr>
                            @endforeach
                        <tfoot>
                            <tr>
                                <td><b>Total Count</b></td>
                                <td class="text-left"><b>{{$number}}</b></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
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
        $('.select2').select2({
            closeOnSelect: false
        });

    });

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