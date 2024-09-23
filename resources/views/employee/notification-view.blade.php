@extends('employee.master')

@section('content')

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1>Notification</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    {{-- <li class="p-1"><a class="btn btn-primary btn-sm text-white addbutton" href="javascript:void(0);"><i class="bi bi-plus"></i> Add</a></li> --}}
                    {{-- <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{url('manager/archive-market-mteam')}}"><i class="bi bi-archive"></i> Archive</a></li> --}}
                    {{-- <li class="p-1"><a href="{{ url()->previous() }}" class="btn btn-success btn-sm text-white"><i class="bi bi-arrow-left" ></i> Back</a></li> --}}
                    
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body pb-0">

                    

                </div>
                <div class="m-2">

                <textarea name="" id="" cols="30" class="form-control" rows="10">{{$name ?? '0'}}</textarea>

{{-- 
                    <table id="dtBasicExample" class="table table-responsive dataTable" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table> --}}


                </div>

            </div>

        </div>
    </div>
</section>


@endsection