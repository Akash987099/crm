@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-person"></i>@if(isset($user->name)) {{$user->name}} @endif</h1>
        </div>
        <div class="col-lg-2">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><a class="btn btn-danger text-white" href="{{route('backend.manager.view-manager')}}"><i class="bi bi-arrow-left"></i> Back</a></li>
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
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-9">
                            <strong>{{$meeetingData->created_date}}</strong>
                        </div>
                        <div class="col-lg-3">
                            <span class="float-right"> <strong>Status:</strong> @if($meeetingData->status == 1){{'Deal Close'}} @elseif($meeetingData->status == 2) {{'Follow Up'}} @else {{'Residual'}} @endif</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-6 lh-lg">

                            <div>Client Name : @if(isset($meeetingData->client_name))<span class="text-muted">{{$meeetingData->client_name}}</span>@endif</div>
                            <div>Company : @if(isset($meeetingData->company_name))<span class="text-muted">{{$meeetingData->company_name}}</span> @endif</div>
                            <div>Email : @if(isset($meeetingData->email))<span class="text-muted">{{$meeetingData->email}}</span> @endif</div>
                            <div>Phone : @if(isset($meeetingData->phone))<span class="text-muted"> {{$meeetingData->phone}}</span> @endif</div>
                            <div>Address :
                                <textarea class="form-control" readonly>@if(isset($meeetingData->address)) {{$meeetingData->address}}@endif</textarea>
                            </div>
                            <div>Category : @if(isset($meeetingData->keywords))<span class="text-muted"> {{$meeetingData->keywords}}</span> @endif</div>
                            <div>Payment Mode : @if($meeetingData->payment_mode==1) {{'Cash'}} @elseif($meeetingData->payment_mode==2) {{'Cheque'}} @elseif($meeetingData->payment_mode==3) {{'Wallet'}} @else {{'Internet Banking'}} @endif</div>
                            <div>Remark/Note : <br>
                                <textarea class="form-control" readonly>@if(isset($meeetingData->remark)){{$meeetingData->remark}}@endif</textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div>
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
                                            <td>{{$row->amount}}</td>
                                            <td>{{$row->payment_date}}</td>
                                        </tr>
                                        @endforeach
                                    <tfoot>
                                        <tr>
                                            <td><strong>Payable-</strong></td>
                                            <td>{{$amount}}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Due Amount-</strong></td>
                                            <td>@if(isset($row->due_amount)){{($row->due_amount)}}@endif</td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>

                                    @endif

                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-5">
                            <div class="table-responsive-sm">
                                @if(isset($temp_service) && !empty($temp_service))
                                @php $amount=0; @endphp
                                <table class="table table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Services</th>
                                            <th>Unit Cost</th>
                                            <th>Tenure</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($temp_service as $service)
                                        @php $amount+= $service->price; @endphp
                                        <tr>
                                            <td>{{DB::table('services')->where('id', $service->serviceid)->pluck('service_name')->first()}}</td>
                                            <td>{{number_format($service->price, 2, '.', ',')}}</td>
                                            <td>{{$service->tenure}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Sub Total</th>
                                            <th colspan="2">@if(isset($amount)){{number_format($amount, 2, '.', ',')}}@endif</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-sm-5">

                        </div>

                        <div class="col-lg-4 col-sm-5 ml-auto">
                            <table class="table table-clear">
                                <tbody>

                                    <tr>
                                        <td class="left">
                                            Discount %
                                        </td>
                                        <td class="right">@if(isset($meeetingData->discount)){{$meeetingData->discount}}@endif</td>
                                    </tr>

                                    <tr>
                                        <td class="left">
                                            <strong>Total</strong>
                                        </td>
                                        <td class="right">
                                            @if(isset($meeetingData->discount))
                                            @php
                                            $dis = ($amount / 100) * $meeetingData->discount;
                                            $price = $amount-$dis;
                                            @endphp
                                            @endif
                                            <strong>@if(empty($price)) @if(isset($amount)){{number_format($amount, 2, '.', ',')}}@endif @else {{number_format($price, 2, '.', ',')}} @endif</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


@endsection

@push('footer-script')


@endpush