@extends('managerend.layout.master')

@section('content')

<section class="section dashboard">
    <div class="row">

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body pb-0 m-4">
                    @if(Session::has('success'))
                    <div class="alert alert-danger bg-success text-light border-0 alert-dismissible fade show" role="alert">
                        {{Session::get('success')}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form method="POST" id="createform" action="" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="id" value="{{$employee->id}}">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Debit</label>
                                    <input type="text" name="debit" id="debit" class="form-control" value="{{old('debit')}}" placeholder="">
                                    <span class="text-danger">@error('dibit') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Creadit</label>
                                    <input type="text" name="creadit" id="creadit" id="status" class="form-control" value="{{old('creadit')}}" placeholder="">
                                    <span class="text-danger">@error('creadit') {{$message}} @enderror</span>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Status</label>
                                    <input type="text" name="status" id="status" class="form-control" value="{{old('firstname')}}" placeholder="Cr/Dr">
                                    <span class="text-danger">@error('status') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-2">
                                    <label>Total</label>
                                    <input type="text" name="total" id="total" class="form-control" value="{{old('total')}}" placeholder="">
                                    <span class="text-danger">@error('total') {{$message}} @enderror</span>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group m-2">
                                    <label>Description</label>
                                    {{-- <input type="text" name="description" class="form-control" value="{{old('description')}}" placeholder="Cr/D"> --}}
                                  
                                    <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                                    <span class="text-danger">@error('description') {{$message}} @enderror</span>
                                </div>
                            </div>
                           
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>

        {{-- second --}}


        <div class="col-lg-6">
            <div class="card">
                <div class="card-body pb-0 m-4">
         

                    <div class="container mt-4">
                        <div class="ledger-header">A/C Ledger</div>
                        
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <strong>Company Name / Employee Name :  {{$employee->firstname ?? ''}} {{$employee->lastname ?? ''}}</strong> <br>
                                <strong>Address: {{ $employee->address ?? ''}}</strong>
                            </div>
                            <div class="col-md-6">
                                <strong>Phone No.: {{$employee->phone ?? ''}}</strong> <br>
                                <strong>Email ID: {{$employee->email ?? ''}}</strong>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <strong>To:</strong>
                            </div>
                            <div class="col-md-6">
                                <strong>Created By:</strong>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <strong>Time Period:</strong>
                            </div>
                        </div>
                    
                        <table class="table table-bordered mt-4">
                            <thead>
                                <tr class="table-header">
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Dr or Cr</th>
                                    <th>Closing Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-right font-weight-bold">Opening Balance</td>
                                    <td>{{$employee->ctc ?? ''}}</td>
                                </tr>
                    
                               
                                    
                               
                                <tr>
                                    <td>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</td>
                                    <td class="description"></td>
                                    <td class="debit"> </td>
                                    <td class="creadit"></td>
                                    <td class="status"></td>
                                    <td class="total"></td>
                                </tr>
                    
                               
                                <!-- Add more rows as needed -->
                                <tr>
                                    <td colspan="2" class="font-weight-bold text-right">Total</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td></td>
                                    <td>{{$totalamount}}</td>
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

<style>
    .table-header {
        background-color: #f0e6c8;
        font-weight: bold;
        text-align: center;
    }
    .ledger-header {
        background-color: #f0e6c8;
        font-weight: bold;
        font-size: 1.5em;
        text-align: center;
        padding: 10px;
    }
</style>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>

$(document).ready(function(){
    $('#debit').on('input', function(){
       var debit = $(this).val();
           $('.debit').text(debit);
    });

    $('#creadit').on('input', function(){
       var debit = $(this).val();
           $('.creadit').text(debit);
    });

    $('#status').on('input', function(){
       var debit = $(this).val();
           $('.status').text(debit);
    });

    $('#total').on('input', function(){
       var debit = $(this).val();
           $('.total').text(debit);
    });

    $('#description').on('input', function(){
       var debit = $(this).val();
           $('.description').text(debit);
    });

    $('#createform').on('submit' , function(e){

        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({

            url : "{{route('add-account')}}",
            type : "POST",
            data : formData,
            success : function(response){

                // console.log(response);
                alert('Success')

                window.location.href = '{{route('account-manager')}}';

            }

        });

    });

});


</script>



@endsection