@extends('managerend.layout.master')

@section('content')


<style>
    video, canvas {
        display: block;
        margin: 10px auto;
    }
</style>



<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body pb-0">

                    

                </div>
                <div class="m-2">


                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 left-side">
                                <h3>Employee Details</h3>
                                <table id="dtBasicExample" class="table table-responsive dataTable">
                                    <thead>
                                        <tr>
                                            <td>Employee Name : {{$employee->firstname}} {{$employee->lastname}}</td>
                                        </tr>
                                        <tr>
                                            <td>Email : {{$employee->email}}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone : {{$employee->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>StaffID : {{$employee->staffid}}</td>
                                        </tr>
                                        <tr>
                                            <td>Joining Date : {{$employee->joinningdate}}</td>
                                        </tr>
                                        <tr>
                                            <td>Address : {{$employee->address}}</td>
                                        </tr>
                                        <tr>
                                            <td>Current Ctc : {{$employee->ctc}}</td>
                                        </tr>
                                        <tr>
                                            <td>Current Sallry : {{$employee->sallery}}</td>
                                        </tr>
                                    </thead>
                                  
                                </table>
                            </div>
                            <div class="col-md-6 right-side">
                                <h3>Pay Sallary Amount Details</h3>
                                <ul>
                                    @foreach ($amount_pay as $key => $val)
                                   
                                    <li><strong>Amount:</strong> {{$val->amount}}</li>
                                    <li><strong>Date:</strong> {{$val->created_at}}</li>
   <hr>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    

            </div>

        </div>
    </div>
</section>
 
<style>
    .container {
    padding: 20px;
}

.left-side, .right-side {
    padding: 15px;
}

.table {
    width: 100%;
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .row {
        flex-direction: column;
    }
}

</style>

@endsection
