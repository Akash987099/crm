@extends('frontend.layout.master')

@section('content')


<div class="row">
    <div class="col-lg-10">
        <div class="pagetitle">
            <h1><i class="bi bi-info-circle"></i> Lead Details</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Lead Details</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-lg-2">
        <nav>
            <ol class="breadcrumb">
                <li><a class="btn btn-danger btn-sm text-white" href="{{route('telemarket.view-clients-list')}}">
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
                                                    <li class="text-bold-800"><b>Name - </b> @if(isset($client_data->client_name)) {{$client_data->client_name}} @endif </li>
                                                    <li><b>Company - </b>@if(isset($client_data->company_name)) {{$client_data->company_name}} @endif</li>
                                                    <li><b>Phone - </b>@if(isset($client_data->phone)) {{$client_data->phone}} @endif</li>
                                                    <li><b>Email - </b>@if(isset($client_data->email)) {{$client_data->email}} @endif</li>
                                                    <li><b>Address - </b>@if(isset($client_data->address)) {{$client_data->address}} @endif</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 text-center text-md-right">

                                        <p class="pb-3"><b>@if(isset($client_data->created_date)) {{$client_data->created_date}} @endif</b></p>
                                        <p class="pb-3"><b>Status : </b>

                                            @if(isset($client_data->meeting_status) && $client_data->meeting_status == 1)
                                            {{'Deal Close'}}
                                            @elseif(isset($client_data->meeting_status) && $client_data->meeting_status == 2)
                                            {{'Follow Up'}} - @if(isset($client_data->followup_date)) {{$client_data->followup_date}} @endif
                                            @else
                                            {{'Residual'}} - @if(isset($client_data->residual)) {{$client_data->residual}} @endif
                                            @endif

                                        </p>
                                        <ul class="px-0 list-unstyled">
                                            <li><b>Balance</b></li>
                                            @if(isset($client_data->blance))
                                            <li class="lead text-bold-800">₹ {{number_format($client_data->blance, 2, '.', ',')}}</li>
                                            @endif

                                            <li><b>Balance Due</b></li>
                                            @if(isset($client_data->temp_value))
                                            <li class="lead text-bold-800">₹ {{number_format($client_data->temp_value, 2, '.', ',')}}</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                                <div id="invoice-items-details" class="pt-2">
                                    <div class="row">
                                        <div class="table-responsive col-sm-12">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 text-center text-md-left">

                                        </div>

                                    </div>
                                </div>

                            </div>
</section>




@endsection

@push('footer-script')

@endpush