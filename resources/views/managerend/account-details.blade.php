<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A/C Ledger</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
</head>
<body>

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

            @foreach ($amount_pay as $key => $val)
                
           
            <tr>
                <td>{{$val->created_at}}</td>
                <td>-</td>
                <td>{{$val->amount}}</td>
                <td></td>
                <td>Dr</td>
                <td>{{$val->amount}}</td>
            </tr>

            @endforeach
           
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
