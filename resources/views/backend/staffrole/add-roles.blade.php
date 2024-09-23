@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1><i class="bi bi-plus-circle-fill"></i> Add Role</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li>
                        <a class="btn btn-primary btn-sm text-white" href="{{url('admin/staff-roles')}}">
                            <i class="bi bi-list"></i> View Roles
                        </a>
                    </li>
                    &nbsp;
                    <li>
                        <a class="btn btn-danger btn-sm text-white" href="{{url('admin/archive-role-staff')}}">
                            <i class="bi bi-archive"></i> Archive Roles
                        </a>
                    </li>
                </ol>
            </nav>
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
                        <button type="button" class="bt9n-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif


                    <form method="post" action="{{url('admin/add-roles')}}">
                        @csrf
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="form-group m-2">
                                    <label> Staff Role Name<span class="text-danger">*</span></label>
                                    <input type="text" name="staff_name" class="form-control" value="{{old('staff_name')}}" placeholder="staff role">
                                    <span class="text-danger">@error('staff_name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-2"><b>Telemarketing</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    <input class="form-check-input" type="checkbox" name="telemarketing[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="telemarketing[]" value="add">
                                    <label class="form-check-label">Add</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="telemarketing[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="telemarketing[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="telemarketing[]" value="view">
                                    <label class="form-check-label">View</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"><b>Marketing</b> </label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    <input class="form-check-input" type="checkbox" name="marketing[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="marketing[]" value="add">
                                    <label class="form-check-label">Add</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="marketing[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="marketing[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="marketing[]" value="view">
                                    <label class="form-check-label">View</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"> <b>Client</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    <input class="form-check-input" type="checkbox" name="client[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="client[]" value="add">
                                    <label class="form-check-label">Add</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="client[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="client[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="client[]" value="view">
                                    <label class="form-check-label">View</label>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <label class="mt-4"> <b>Manager</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    <input class="form-check-input" type="checkbox" name="manager[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="manager[]" value="add">
                                    <label class="form-check-label">Add</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="manager[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="manager[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="manager[]" value="view">
                                    <label class="form-check-label">View</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"> <b>B.D.E</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    <input class="form-check-input" type="checkbox" name="bde[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="bde[]" value="add">
                                    <label class="form-check-label">Add</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="bde[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="bde[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="bde[]" value="view">
                                    <label class="form-check-label">View</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"> <b>Call History</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    <input class="form-check-input" type="checkbox" name="call_history[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="call_history[]" value="add">
                                    <label class="form-check-label">Add</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="call_history[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="call_history[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="call_history[]" value="view">
                                    <label class="form-check-label">View</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"> <b>Check Call availability</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    <input class="form-check-input" type="checkbox" name="check_call[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="check_call[]" value="add">
                                    <label class="form-check-label">Add</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="check_call[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="check_call[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="check_call[]" value="view">
                                    <label class="form-check-label">View</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"> <b>Cold Call</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    <input class="form-check-input" type="checkbox" name="coldcall[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="coldcall[]" value="add">
                                    <label class="form-check-label">Add</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="coldcall[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="coldcall[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="coldcall[]" value="view">
                                    <label class="form-check-label">View</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"> <b>Ashign Meeting (Clients)</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    <input class="form-check-input" type="checkbox" name="ashign_meating_client[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="ashign_meating_client[]" value="add">
                                    <label class="form-check-label">Add</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="ashign_meating_client[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="ashign_meating_client[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="ashign_meating_client[]" value="view">
                                    <label class="form-check-label">View</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"> <b>Meeting Response</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    <input class="form-check-input" type="checkbox" name="meeting_response[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="meeting_response[]" value="add">
                                    <label class="form-check-label">Add</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="meeting_response[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="meeting_response[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="meeting_response[]" value="view">
                                    <label class="form-check-label">View</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"> <b>Our Services</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    <input class="form-check-input" type="checkbox" name="our_service[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="our_service[]" value="add">
                                    <label class="form-check-label">Add</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="our_service[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="our_service[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    <input class="form-check-input" type="checkbox" name="our_service[]" value="view">
                                    <label class="form-check-label">View</label>
                                </div>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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