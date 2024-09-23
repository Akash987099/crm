@extends('managerend.layout.master')

@section('content')
<div class="row">
    <div class="col-lg-10">
        <div class="pagetitle">
            <h1><i class="bi bi-info-circle"></i> Meeting Details</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Meeting Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-lg-2">
        <nav>
            <ol class="breadcrumb">
                <li><a class="btn btn-danger btn-sm text-white" href="{{route('manager.view-meeting-manager')}}">
                        <i class="bi bi-arrow-left"></i> Back
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


                            <div class="card-body">
                                <!-- Invoice Company Details -->
                                <div id="invoice-company-details" class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="media">
                                            <div class="media-body lh-lg">
                                                <ul class="ml-2 px-0 list-unstyled">
                                                    <li class="text-bold-800"><b>Name - </b> @if(isset($meeting_data->client_name)) {{$meeting_data->client_name}} @endif </li>
                                                    <li><b>Company - </b>@if(isset($meeting_data->company_name)) {{$meeting_data->company_name}} @endif</li>
                                                    <li><b>Phone - </b>@if(isset($meeting_data->phone)) {{$meeting_data->phone}} @endif</li>
                                                    <li><b>Email - </b>@if(isset($meeting_data->email)) {{$meeting_data->email}} @endif</li>
                                                    <li><b>Address - </b>@if(isset($meeting_data->address)) {{$meeting_data->address}} @endif</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 text-center text-md-right">

                                        <p class="pb-3"><b>@if(isset($meeting_data->created_date)) {{$meeting_data->created_date}} @endif</b></p>
                                        <p class="pb-3"><b>Status : </b>

                                            @if(isset($meeting_data->status) && $meeting_data->status == 1)
                                            {{'Deal Close'}}
                                            @elseif(isset($meeting_data->status) && $meeting_data->status == 2)
                                            {{'Follow Up'}} - @if(isset($meeting_data->followup_date)) {{$meeting_data->followup_date}} @endif
                                            @else
                                            {{'Reschedule'}} - @if(isset($meeting_data->residual)) {{$meeting_data->residual}} @endif
                                            @endif

                                        </p>
                                        <ul class="px-0 list-unstyled">
                                            <li><b>Balance</b></li>
                                            @if(isset($meeting_data->blance))
                                            <li class="lead text-bold-800">₹ {{number_format($meeting_data->blance, 2, '.', ',')}}</li>
                                            @endif

                                            <li><b>Balance Due</b></li>
                                            @if(isset($meeting_data->temp_value))
                                            <li class="lead text-bold-800">₹ {{number_format($meeting_data->temp_value, 2, '.', ',')}}</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                                <div id="invoice-items-details" class="pt-2">
                                    <div class="row">
                                        <div class="table-responsive col-sm-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10%;">#</th>
                                                        <th style="width: 50%;">Services &amp; Description</th>
                                                        <th style="width: 20%;" class="text-right">Tenure</th>
                                                        <th style="width: 20%;" class="text-right">Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($temp_service) && !empty($temp_service))
                                                    @php $sn=1; @endphp
                                                    @foreach($temp_service as $service)
                                                    @php
                                                    $service_temp = DB::table('services')->where('id',$service->serviceid)->where('archive',0)->where('status',0)->first();
                                                    @endphp
                                                    <tr>
                                                        <th scope="row">{{$sn++}}</th>
                                                        <td>
                                                            <p>{{$service_temp->service_name}}</p>
                                                            <p class="text-muted">{{$service_temp->description}}</p>
                                                        </td>
                                                        <td class="text-right">{{$service->tenure}}</td>
                                                        <td class="text-right">₹ {{number_format($service->price, 2, '.', ',')}}</td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 text-center text-md-left">

                                        </div>
                                        <div class="col-md-8 col-sm-12">
                                            <p class="lead">Total due</p>
                                            <div class="table-responsive">
                                                <table class="table table-responsive" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Payment Mode</th>
                                                            <th>Amount</th>
                                                            <th>Payment Date</th>
                                                        </tr>

                                                    </thead>
                                                    <tbody>
                                                        @if(isset($payment) && !empty($payment))
                                                        @php
                                                        $payment_mode="";
                                                        $amount=0;
                                                        @endphp
                                                        @foreach($payment as $row)
                                                        @php
                                                        $amount+=$row->amount;
                                                        if($row->payment_mode == 1){
                                                        $payment_mode="Cash";
                                                        }elseif($row->payment_mode == 2){
                                                        $payment_mode="Cheque";
                                                        }elseif($row->payment_mode == 3){
                                                        $payment_mode="Wallet";
                                                        }else{
                                                        $payment_mode="Internet Banking";
                                                        }
                                                        @endphp
                                                        <tr>
                                                            <td>{{$payment_mode}}</td>
                                                            <td>₹ {{number_format($row->amount, 2, ',', ',')}}</td>
                                                            <td> {{$row->payment_date}}</td>
                                                        </tr>
                                                        @endforeach
                                                    <tfoot>
                                                        <tr>
                                                            <td><strong>Payable-</strong></td>
                                                            <td>₹ {{number_format($amount, 2, '.', ',')}}</td>
                                                            <td colspan="2"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Due Amount-</strong></td>
                                                            <td>@if(isset($row->due_amount)) ₹ {{number_format($row->due_amount, 2, '.', ',')}}@endif</td>
                                                            <td colspan="2"></td>
                                                        </tr>
                                                    </tfoot>

                                                    @endif

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
</section>

@endsection

@push('footer-script')



@endpush