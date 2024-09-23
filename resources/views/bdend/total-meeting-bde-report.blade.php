@extends('bdend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-check-circle-fill"></i> All Total Meetings</h1>
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
                    @elseif(Session::has('faild'))
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                        {{Session::get('faild')}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    @endif

                    <form method="post" action="{{route('bde.total-meeting-report-generate')}}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group m-2">
                                    <label> Start Date <span class="text-danger">*</span></label>
                                    <input type="date" name="start_date" class="form-control">
                                    <span class="text-danger">@error('start_date') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group m-2">
                                    <label> End Date <span class="text-danger">*</span></label>
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
            @if(isset($filter_meeting) && !empty($filter_meeting))
            @php
            $sn=1;
            $number = 0;
            @endphp
            <div class="card">
                <div class="m-2">

                    <table id="myTable" class="table table-borderless" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                            </tr>

                        </thead>
                        <tbody>

                            @foreach($filter_meeting as $row)

                            <tr>
                                <td> {{$sn++}}</td>
                                <td>{{$row->client_name}}</td>
                                <td>{{$row->phone}}</td>
                                <td>{{$row->email}}</td>
                                <td>{{$row->address}}</td>
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

<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf'
            ]
        });
    });
</script>

@endpush