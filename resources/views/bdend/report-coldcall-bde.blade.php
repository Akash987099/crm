@extends('bdend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-check-circle-fill"></i> Coldcall Availability</h1>
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

                    <form method="post" action="{{route('bde.coldcall-report-generate')}}">
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

                    <table class="table table-borderless datatable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>email</th>
                                <th>Address</th>
                            </tr>

                        </thead>
                        <tbody>

                            @foreach($filter_meeting as $row)
                            @php $number++; @endphp
                            <tr>
                                <td>{{$sn++}}</td>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script>
    $(document).ready(function() {
        $('.select2').select2({
            closeOnSelect: false
        });

    });
</script>

@endpush