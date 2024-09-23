@extends('managerend.layout.master')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="pagetitle">
            <h1>Bill Payment</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Bill payment</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="col-lg-4">
        <nav>
            <ol class="breadcrumb">
                <li><a class="btn btn-danger text-white" href="{{route('manager.view-meeting-manager')}}"><i class="bi bi-arrow-left"></i> Attend Meeting</a></li>
                &nbsp;
                <li><a class="btn btn-danger text-white" href="{{route('manager.view-coldcall')}}"><i class="bi bi-arrow-left"></i> Cold Call</a></li>
            </ol>
        </nav>
    </div>
</div>
<section class="section profile">

    <div id="showPayment" class="card">
        <div class="card-body">
            <br>
            @if(Session::has('success'))
            <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                {{Session::get('success')}}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(Session::has('faild'))
            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                {{Session::get('faild')}}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <form method="post" action="{{route('market.add_payment',['meetingid'=>Crypt::encrypt($meeting_data->id)])}}">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"> Client Name</label>
                            <input type="text" name="client_name" class="form-control" value="{{$meeting_data->client_name}}" readonly="readonly">

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"> Total Amount</label>
                            <input type="text" name="" class="form-control" value="{{$meeting_data->blance}}" disabled="disabled">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"> Amount <span class="text-danger">*</span></label>
                            <input type="text" name="amount" class="form-control" placeholder="₹ 00.00">
                            <small class="text-danger">@error('amount') {{$message}} @enderror</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"> Date <span class="text-danger">*</span></label>
                            <input type="date" name="payment_date" class="form-control" placeholder="₹ 00.00">
                            <small class="text-danger">@error('payment_date') {{$message}} @enderror</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"> Payment Mode <span class="text-danger">*</span></label>
                            @php $paymentMode=['1'=>'Cash','2'=>'Cheque','3'=>'Wallet','4'=>'Internet Banking']; @endphp
                            <select class="form-control" name="payment_mode">
                                @if(!empty($paymentMode))
                                @foreach($paymentMode as $key=>$row)
                                <option value="{{$key}}">{{$row}}</option>
                                @endforeach
                                @endif
                            </select>
                            <small class="text-danger">@error('payment_mode') {{$message}} @enderror</small>
                        </div>
                    </div>
                    <div class="col-md-3 mt-4 pt-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add Payment</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">

            <div class="card">
                <div class="card-body pt-2">
                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">

                            <div class="m-2">
                                <table id="myTable" class="table table-responsive" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Client Name</th>
                                            <th>Amount</th>
                                            <th>Payment Mode</th>
                                            <th>Payment Date</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        @if(isset($payment_details) && !empty($payment_details))
                                        @php
                                        $payment_mode="";
                                        $amount=array();
                                        @endphp
                                        @foreach($payment_details as $row)
                                        @php
                                        array_push($amount,$row->amount);
                                        $meeting = DB::table('meetings')->where('id',$row->meeting_id)->first();
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
                                            <td>{{$meeting->client_name}}</td>
                                            <td>{{$row->amount}}</td>
                                            <td>{{$payment_mode}}</td>
                                            <td>{{$row->payment_date}}</td>
                                        </tr>
                                        @endforeach
                                    <tfoot>
                                        <tr>
                                            <td><strong>Payable</strong></td>
                                            <td>{{array_sum($amount)}}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Due Amount</strong></td>
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
                </div>
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