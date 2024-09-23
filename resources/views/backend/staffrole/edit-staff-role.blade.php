@extends('backend.layout.master')

@section('content')
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-10">
            <h1><i class="bi bi-pencil-square"></i> Edit Staff Role</h1>
        </div>
        <div class="col-lg-2">
            <nav>
                <ol class="breadcrumb">

                    <li>
                        <a class="btn btn-danger btn-sm text-white" href="{{url('admin/staff-roles')}}">
                            <i class="bi bi-arrow-left"></i> Back
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


                    <form method="post" action="{{url('admin/edit-staff-role')}}">
                        @csrf
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="form-group m-2">
                                    <label> Staff Role Name<span class="text-danger">*</span></label>
                                    <input type="text" name="staff_name" class="form-control" value="{{$edit_role->staff_name}}" placeholder="staff role">
                                    <input type="hidden" name="role_id" value="{{Crypt::encrypt($edit_role->id)}}">
                                    <span class="text-danger">@error('staff_name') {{$message}} @enderror</span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-2"><b>Telemarketing</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    @if(isset($edit_role->telemarketing) && !empty($edit_role->telemarketing))
                                    @php $telemarketing=json_decode($edit_role->telemarketing); @endphp
                                    <input class="form-check-input" @if(is_array($telemarketing) && in_array('menu',$telemarketing)) {{'checked'}} @endif type="checkbox" name="telemarketing[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->telemarketing) && !empty($edit_role->telemarketing))
                                    @php $telemarketing=json_decode($edit_role->telemarketing); @endphp
                                    <input class="form-check-input" @if(is_array($telemarketing) && in_array('add',$telemarketing)) {{'checked'}} @endif type="checkbox" name="telemarketing[]" value="add">
                                    <label class="form-check-label">Add</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->telemarketing) && !empty($edit_role->telemarketing))
                                    @php $telemarketing=json_decode($edit_role->telemarketing); @endphp
                                    <input class="form-check-input" @if(is_array($telemarketing) && in_array('edit',$telemarketing)) {{'checked'}} @endif type="checkbox" name="telemarketing[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->telemarketing) && !empty($edit_role->telemarketing))
                                    @php $telemarketing=json_decode($edit_role->telemarketing); @endphp
                                    <input class="form-check-input" @if(is_array($telemarketing) && in_array('delete',$telemarketing)) {{'checked'}} @endif type="checkbox" name="telemarketing[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->telemarketing) && !empty($edit_role->telemarketing))
                                    @php $telemarketing=json_decode($edit_role->telemarketing); @endphp
                                    <input class="form-check-input" @if(is_array($telemarketing) && in_array('view',$telemarketing)) {{'checked'}} @endif type="checkbox" name="telemarketing[]" value="view">
                                    <label class="form-check-label">View</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"><b>Marketing</b> </label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    @if(isset($edit_role->marketing) && !empty($edit_role->marketing))
                                    @php $marketing=json_decode($edit_role->marketing); @endphp
                                    <input class="form-check-input" @if(is_array($marketing) && in_array('menu',$marketing)) {{'checked'}} @endif type="checkbox" name="marketing[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->marketing) && !empty($edit_role->marketing))
                                    @php $marketing=json_decode($edit_role->marketing); @endphp
                                    <input class="form-check-input" @if(is_array($marketing) && in_array('add',$marketing)) {{'checked'}} @endif type="checkbox" name="marketing[]" value="add">
                                    <label class="form-check-label">Add</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->marketing) && !empty($edit_role->marketing))
                                    @php $marketing=json_decode($edit_role->marketing); @endphp
                                    <input class="form-check-input" @if(is_array($marketing) && in_array('edit',$marketing)) {{'checked'}} @endif type="checkbox" name="marketing[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->marketing) && !empty($edit_role->marketing))
                                    @php $marketing=json_decode($edit_role->marketing); @endphp
                                    <input class="form-check-input" @if(is_array($marketing) && in_array('delete',$marketing)) {{'checked'}} @endif type="checkbox" name="marketing[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->marketing) && !empty($edit_role->marketing))
                                    @php $marketing=json_decode($edit_role->marketing); @endphp
                                    <input class="form-check-input" @if(is_array($marketing) && in_array('view',$marketing)) {{'checked'}} @endif type="checkbox" name="marketing[]" value="view">
                                    <label class="form-check-label">View</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"> <b>Client</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    @if(isset($edit_role->client) && !empty($edit_role->client))
                                    @php $client=json_decode($edit_role->client); @endphp
                                    <input class="form-check-input" @if(is_array($client) && in_array('menu' ,$client)) {{'checked'}} @endif type="checkbox" name="client[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->client) && !empty($edit_role->client))
                                    @php $client=json_decode($edit_role->client); @endphp
                                    <input class="form-check-input" @if(is_array($client) && in_array('add' ,$client)) {{'checked'}} @endif type="checkbox" name="client[]" value="add">
                                    <label class="form-check-label">Add</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->client) && !empty($edit_role->client))
                                    @php $client=json_decode($edit_role->client); @endphp
                                    <input class="form-check-input" @if(is_array($client) && in_array('edit' ,$client)) {{'checked'}} @endif type="checkbox" name="client[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->client) && !empty($edit_role->client))
                                    @php $client=json_decode($edit_role->client); @endphp
                                    <input class="form-check-input" @if(is_array($client) && in_array('delete' ,$client)) {{'checked'}} @endif type="checkbox" name="client[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->client) && !empty($edit_role->client))
                                    @php $client=json_decode($edit_role->client); @endphp
                                    <input class="form-check-input" @if(is_array($client) && in_array('view' ,$client)) {{'checked'}} @endif type="checkbox" name="client[]" value="view">
                                    <label class="form-check-label">View</label>
                                    @endif
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <label class="mt-4"> <b>Manager</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    @if(isset($edit_role->manager) && !empty($edit_role->manager))
                                    @php $manager=json_decode($edit_role->manager); @endphp
                                    <input class="form-check-input" @if(is_array($manager) && in_array('menu',$manager)) {{'checked'}} @endif type="checkbox" name="manager[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->manager) && !empty($edit_role->manager))
                                    @php $manager=json_decode($edit_role->manager); @endphp
                                    <input class="form-check-input" @if(is_array($manager) && in_array('add',$manager)) {{'checked'}} @endif type="checkbox" name="manager[]" value="add">
                                    <label class="form-check-label">Add</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->manager) && !empty($edit_role->manager))
                                    @php $manager=json_decode($edit_role->manager); @endphp
                                    <input class="form-check-input" @if(is_array($manager) && in_array('edit',$manager)) {{'checked'}} @endif type="checkbox" name="manager[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->manager) && !empty($edit_role->manager))
                                    @php $manager=json_decode($edit_role->manager); @endphp
                                    <input class="form-check-input" @if(is_array($manager) && in_array('delete',$manager)) {{'checked'}} @endif type="checkbox" name="manager[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->manager) && !empty($edit_role->manager))
                                    @php $manager=json_decode($edit_role->manager); @endphp
                                    <input class="form-check-input" @if(is_array($manager) && in_array('view',$manager)) {{'checked'}} @endif type="checkbox" name="manager[]" value="view">
                                    <label class="form-check-label">View</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"> <b>B.D.E</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    @if(isset($edit_role->bde) && !empty($edit_role->bde))
                                    @php $bde=json_decode($edit_role->bde); @endphp
                                    <input class="form-check-input" @if(is_array($bde) && in_array('menu',$bde)) {{'checked'}} @endif type="checkbox" name="bde[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->bde) && !empty($edit_role->bde))
                                    @php $bde=json_decode($edit_role->bde); @endphp
                                    <input class="form-check-input" @if(is_array($bde) && in_array('add',$bde)) {{'checked'}} @endif type="checkbox" name="bde[]" value="add">
                                    <label class="form-check-label">Add</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->bde) && !empty($edit_role->bde))
                                    @php $bde=json_decode($edit_role->bde); @endphp
                                    <input class="form-check-input" @if(is_array($bde) && in_array('edit',$bde)) {{'checked'}} @endif type="checkbox" name="bde[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->bde) && !empty($edit_role->bde))
                                    @php $bde=json_decode($edit_role->bde); @endphp
                                    <input class="form-check-input" @if(is_array($bde) && in_array('delete',$bde)) {{'checked'}} @endif type="checkbox" name="bde[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->bde) && !empty($edit_role->bde))
                                    @php $bde=json_decode($edit_role->bde); @endphp
                                    <input class="form-check-input" @if(is_array($bde) && in_array('view',$bde)) {{'checked'}} @endif type="checkbox" name="bde[]" value="view">
                                    <label class="form-check-label">View</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"> <b>Call History</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    @if(isset($edit_role->call_history) && !empty($edit_role->call_history))
                                    @php $call_history=json_decode($edit_role->call_history); @endphp
                                    <input class="form-check-input" @if(is_array($call_history) && in_array('menu',$call_history)) {{'checked'}} @endif type="checkbox" name="call_history[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->call_history) && !empty($edit_role->call_history))
                                    @php $call_history=json_decode($edit_role->call_history); @endphp
                                    <input class="form-check-input" @if(is_array($call_history) && in_array('add',$call_history)) {{'checked'}} @endif type="checkbox" name="call_history[]" value="add">
                                    <label class="form-check-label">Add</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->call_history) && !empty($edit_role->call_history))
                                    @php $call_history=json_decode($edit_role->call_history); @endphp
                                    <input class="form-check-input" @if(is_array($call_history) && in_array('edit',$call_history)) {{'checked'}} @endif type="checkbox" name="call_history[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->call_history) && !empty($edit_role->call_history))
                                    @php $call_history=json_decode($edit_role->call_history); @endphp
                                    <input class="form-check-input" @if(is_array($call_history) && in_array('delete',$call_history)) {{'checked'}} @endif type="checkbox" name="call_history[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->call_history) && !empty($edit_role->call_history))
                                    @php $call_history=json_decode($edit_role->call_history); @endphp
                                    <input class="form-check-input" @if(is_array($call_history) && in_array('view',$call_history)) {{'checked'}} @endif type="checkbox" name="call_history[]" value="view">
                                    <label class="form-check-label">View</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"> <b>Check Call availability</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    @if(isset($edit_role->check_call) && !empty($edit_role->check_call))
                                    @php $check_call=json_decode($edit_role->check_call); @endphp
                                    <input class="form-check-input" @if(is_array($check_call) && in_array('menu',$check_call)) {{'checked'}} @endif type="checkbox" name="check_call[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->check_call) && !empty($edit_role->check_call))
                                    @php $check_call=json_decode($edit_role->check_call); @endphp
                                    <input class="form-check-input" @if(is_array($check_call) && in_array('add',$check_call)) {{'checked'}} @endif type="checkbox" name="check_call[]" value="add">
                                    <label class="form-check-label">Add</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->check_call) && !empty($edit_role->check_call))
                                    @php $check_call=json_decode($edit_role->check_call); @endphp
                                    <input class="form-check-input" @if(is_array($check_call) && in_array('edit',$check_call)) {{'checked'}} @endif type="checkbox" name="check_call[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->check_call) && !empty($edit_role->check_call))
                                    @php $check_call=json_decode($edit_role->check_call); @endphp
                                    <input class="form-check-input" @if(is_array($check_call) && in_array('delete',$check_call)) {{'checked'}} @endif type="checkbox" name="check_call[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->check_call) && !empty($edit_role->check_call))
                                    @php $check_call=json_decode($edit_role->check_call); @endphp
                                    <input class="form-check-input" @if(is_array($check_call) && in_array('view',$check_call)) {{'checked'}} @endif type="checkbox" name="check_call[]" value="view">
                                    <label class="form-check-label">View</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"> <b>Cold Call</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    @if(isset($edit_role->coldcall) && !empty($edit_role->coldcall))
                                    @php $coldcall=json_decode($edit_role->coldcall); @endphp
                                    <input class="form-check-input" @if(is_array($coldcall) && in_array('menu',$coldcall)) {{'checked'}} @endif type="checkbox" name="coldcall[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->coldcall) && !empty($edit_role->coldcall))
                                    @php $coldcall=json_decode($edit_role->coldcall); @endphp
                                    <input class="form-check-input" @if(is_array($coldcall) && in_array('add',$coldcall)) {{'checked'}} @endif type="checkbox" name="coldcall[]" value="add">
                                    <label class="form-check-label">Add</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->coldcall) && !empty($edit_role->coldcall))
                                    @php $coldcall=json_decode($edit_role->coldcall); @endphp
                                    <input class="form-check-input" @if(is_array($coldcall) && in_array('edit',$coldcall)) {{'checked'}} @endif type="checkbox" name="coldcall[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->coldcall) && !empty($edit_role->coldcall))
                                    @php $coldcall=json_decode($edit_role->coldcall); @endphp
                                    <input class="form-check-input" @if(is_array($coldcall) && in_array('delete',$coldcall)) {{'checked'}} @endif type="checkbox" name="coldcall[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->coldcall) && !empty($edit_role->coldcall))
                                    @php $coldcall=json_decode($edit_role->coldcall); @endphp
                                    <input class="form-check-input" @if(is_array($coldcall) && in_array('view',$coldcall)) {{'checked'}} @endif type="checkbox" name="coldcall[]" value="view">
                                    <label class="form-check-label">View</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"> <b>Ashign Meeting (Clients)</b></label> <br>
                                @if(isset($edit_role->ashign_meating_client) && !empty($edit_role->ashign_meating_client))
                                @php $ashign_meating_client=json_decode($edit_role->ashign_meating_client); @endphp
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    <input class="form-check-input" @if(is_array($ashign_meating_client) && in_array('menu',$ashign_meating_client)) {{'checked'}} @endif type="checkbox" name="ashign_meating_client[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->ashign_meating_client) && !empty($edit_role->ashign_meating_client))
                                    @php $ashign_meating_client=json_decode($edit_role->ashign_meating_client); @endphp
                                    <input class="form-check-input" @if(is_array($ashign_meating_client) && in_array('add',$ashign_meating_client)) {{'checked'}} @endif type="checkbox" name="ashign_meating_client[]" value="add">
                                    <label class="form-check-label">Add</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->ashign_meating_client) && !empty($edit_role->ashign_meating_client))
                                    @php $ashign_meating_client=json_decode($edit_role->ashign_meating_client); @endphp
                                    <input class="form-check-input" @if(is_array($ashign_meating_client) && in_array('edit',$ashign_meating_client)) {{'checked'}} @endif type="checkbox" name="ashign_meating_client[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->ashign_meating_client) && !empty($edit_role->ashign_meating_client))
                                    @php $ashign_meating_client=json_decode($edit_role->ashign_meating_client); @endphp
                                    <input class="form-check-input" @if(is_array($ashign_meating_client) && in_array('delete',$ashign_meating_client)) {{'checked'}} @endif type="checkbox" name="ashign_meating_client[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->ashign_meating_client) && !empty($edit_role->ashign_meating_client))
                                    @php $ashign_meating_client=json_decode($edit_role->ashign_meating_client); @endphp
                                    <input class="form-check-input" @if(is_array($ashign_meating_client) && in_array('view',$ashign_meating_client)) {{'checked'}} @endif type="checkbox" name="ashign_meating_client[]" value="view">
                                    <label class="form-check-label">View</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"> <b>Meeting Response</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    @if(isset($edit_role->meeting_response) && !empty($edit_role->meeting_response))
                                    @php $meeting_response=json_decode($edit_role->meeting_response); @endphp
                                    <input class="form-check-input" @if(is_array($meeting_response) && in_array('menu',$meeting_response)) {{'checked'}} @endif type="checkbox" name="meeting_response[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->meeting_response) && !empty($edit_role->meeting_response))
                                    @php $meeting_response=json_decode($edit_role->meeting_response); @endphp
                                    <input class="form-check-input" @if(is_array($meeting_response) && in_array('add',$meeting_response)) {{'checked'}} @endif type="checkbox" name="meeting_response[]" value="add">
                                    <label class="form-check-label">Add</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->meeting_response) && !empty($edit_role->meeting_response))
                                    @php $meeting_response=json_decode($edit_role->meeting_response); @endphp
                                    <input class="form-check-input" @if(is_array($meeting_response) && in_array('edit',$meeting_response)) {{'checked'}} @endif type="checkbox" name="meeting_response[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->meeting_response) && !empty($edit_role->meeting_response))
                                    @php $meeting_response=json_decode($edit_role->meeting_response); @endphp
                                    <input class="form-check-input" @if(is_array($meeting_response) && in_array('delete',$meeting_response)) {{'checked'}} @endif type="checkbox" name="meeting_response[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->meeting_response) && !empty($edit_role->meeting_response))
                                    @php $meeting_response=json_decode($edit_role->meeting_response); @endphp
                                    <input class="form-check-input" @if(is_array($meeting_response) && in_array('view',$meeting_response)) {{'checked'}} @endif type="checkbox" name="meeting_response[]" value="view">
                                    <label class="form-check-label">View</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="mt-4"> <b>Our Services</b></label> <br>
                                <div class="form-check form-check-inline mt-2 mt-2">
                                    @if(isset($edit_role->our_service) && !empty($edit_role->our_service))
                                    @php $our_service=json_decode($edit_role->our_service); @endphp
                                    <input class="form-check-input" @if(is_array($our_service) && in_array('menu',$our_service)) {{'checked'}} @endif type="checkbox" name="our_service[]" value="menu">
                                    <label class="form-check-label">Menu</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->our_service) && !empty($edit_role->our_service))
                                    @php $our_service=json_decode($edit_role->our_service); @endphp
                                    <input class="form-check-input" @if(is_array($our_service) && in_array('add',$our_service)) {{'checked'}} @endif type="checkbox" name="our_service[]" value="add">
                                    <label class="form-check-label">Add</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->our_service) && !empty($edit_role->our_service))
                                    @php $our_service=json_decode($edit_role->our_service); @endphp
                                    <input class="form-check-input" @if(is_array($our_service) && in_array('edit',$our_service)) {{'checked'}} @endif type="checkbox" name="our_service[]" value="edit">
                                    <label class="form-check-label">Edit</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->our_service) && !empty($edit_role->our_service))
                                    @php $our_service=json_decode($edit_role->our_service); @endphp
                                    <input class="form-check-input" @if(is_array($our_service) && in_array('delete',$our_service)) {{'checked'}} @endif type="checkbox" name="our_service[]" value="delete">
                                    <label class="form-check-label">Delete</label>
                                    @endif
                                </div>
                                <div class="form-check form-check-inline mt-2">
                                    @if(isset($edit_role->our_service) && !empty($edit_role->our_service))
                                    @php $our_service=json_decode($edit_role->our_service); @endphp
                                    <input class="form-check-input" @if(is_array($our_service) && in_array('view',$our_service)) {{'checked'}} @endif type="checkbox" name="our_service[]" value="view">
                                    <label class="form-check-label">View</label>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">Update Role</button>
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