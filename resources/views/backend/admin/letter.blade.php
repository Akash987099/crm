@extends('backend.layout.master')

@section('content')

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>ss
<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1><i class="bi bi-card-list"></i> Letter Template</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalCenter">Add Page</button></li>
                    {{-- <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{route('archiveemployee')}}"><i class="bi bi-archive"></i> Archive</a></li> --}}
                    <li class="p-1"><a href="{{ url()->previous() }}" class="btn btn-success btn-sm text-white"><i class="bi bi-arrow-left" ></i> Back</a></li>
                </ol>
            </nav>
        </div>
    </div>


</div><!-- End Page Title -->


<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Welcome Letter</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Termination Letter</button>
    </li>
    {{-- <li class="nav-item" role="presentation">
      <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
    </li> --}}
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">


        <textarea class="form-control" name="update_about"   id="programeditor">
            @foreach($letter as $item)
            @if($item->type == 1)
                {{ $item->description}}
            @endif
        @endforeach
            </textarea>

            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-primary btn-sm" id="welcome">Add</button>
                </div>
            </div>

    </div>


    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

        <textarea class="form-control" name="update_about"   id="programeditor1">
            @foreach($letter as $item)
            @if($item->type == 2)
                {{ $item->description}}
            @endif
        @endforeach
        
        </textarea>

        <div class="row">
            <div class="col-lg-12">
                <button type="submit" class="btn btn-primary btn-sm" id="terminate">Add</button>
            </div>
        </div>

    </div>

  </div>


<div class="modal fade" id="basicModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Marketing Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><b>Staff ID :</b> <span class="staffid"></span> </p>
                <p><b>Staff Role :</b> <span class="staff_role"></span> </p>
                <p><b>First Name :</b> <span class="firstname"></span> </p>
                <p><b>Last Name :</b> <span class="lastname"></span> </p>
                <p><b>Phone :</b> <span class="phone"></span> </p>
                <p><b>Email :</b> <span class="email"></span> </p>
                <p><b>Joining Date :</b> <span class="joining_date"></span> </p>
                <p><b>Address:</b> <span class="address"></span> </p>
                <p><b>City : </b> <span class="city"></span> </p>
                <p><b>Pincode : </b> <span class="pincode"></span> </p>
                <p><b>State :</b> <span class="state"></span> </p>
                <p><b>Create Date :</b> <span class="created_date"></span> </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>

            </div>
        </div>
    </div>
</div>


<!-- Button trigger modal -->
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

<!-- End Basic Modal-->


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

<script type="text/javascript">



    $(function() {
        var i = 1;
        var table = $('.dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('view-employee') }}",

            dom: 'Blfrtip',
            buttons: [{
                    extend: 'pdf',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    }
                },
                {
                    extend: 'excel',
                }
            ],

            columns: [{
                    data: 'id',
                },
                {
                    data: 'name',
                },
                {
                    data: 'staff_id',
                },
                {
                    data: 'email',
                },
                {
                    data: 'phone',
                },
                {
                    data: 'date',
                },
                {
                    data: 'action',
                },
            ]
        });
    });


    //////////////////////////////////////////////////////////////////////

    $(document).on('click', '.marketing', function() {
        var dataId = $(this).attr("data-id");
        $.ajax({
            type: 'POST',
            url: "{{url('manager/view-details-market-mteam')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": dataId
            },
            success: function(response) {
                $("#basicModal").modal('show');
                $(".firstname").text(response.data.firstname);
                $(".lastname").text(response.data.lastname);
                $(".email").text(response.data.email);
                $(".phone").text(response.data.phone);
                $(".joining_date").text(response.data.joining_date);
                $(".address").text(response.data.address);
                $(".city").text(response.data.city);
                $(".pincode").text(response.data.pincode);
                $(".state").text(response.data.state);
                $(".staffid").text(response.data.staff_id);
                $(".staff_role").text(response.data.staff_role);
                $(".created_date").text(response.data.created_date);

            }
        });

    });
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
<script>
     let editorInstance;

ClassicEditor
    .create(document.querySelector('#programeditor'))
    .then(editor => {
        editorInstance = editor;
    })
    .catch(error => {
        console.error(error);
    });


$(document).on('click', '#welcome', function() {
    var editorContent = editorInstance.getData();
    // alert(editorContent);

    Swal.fire({
        title: 'Confirm Submission',
          text: 'Are you sure you want to submit the form?',
          icon: 'question',
                    customClass: {
    popup: 'custom-swal-width-height',
    title: 'custom-swal-title',
    htmlContainer: 'custom-swal-text',
    icon: 'custom-swal-icon'
  }
                }).then(function(result) {
                    if (result.isConfirmed) {


                        Swal.fire({
                        title: "Please wait...",
                        html: "Processing ...",
                        customClass: {
    popup: 'custom-swal-width-height',
    title: 'custom-swal-title',
    htmlContainer: 'custom-swal-text',
    icon: 'custom-swal-icon'
  }
                    })
                    Swal.showLoading();

                    $.ajax({
                        headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
                        url : "{{route('letter-save')}}",
                        type : "POST",
                        data : { welcome : editorContent},
                        success : function(response){

                            // console.log(response);

                            if(response.status == 'success'){

Swal.fire({
icon: 'success',
title: 'Success!',
text: 'Saved Successfully.',
customClass: {
popup: 'custom-swal-width-height',
title: 'custom-swal-title',
htmlContainer: 'custom-swal-text',
icon: 'custom-swal-icon'
}
}).then(function(result) {
if (result.isConfirmed) {
window.location.reload();
}
});

}

                        }
                    });

                }
            });


});



</script>

<script>
     let editorInstance1;

ClassicEditor
    .create(document.querySelector('#programeditor1'))
    .then(editor => {
        editorInstance1 = editor;
    })
    .catch(error => {
        console.error(error);
    });

        $(document).on('click', '#terminate', function() {
    var editorContent = editorInstance1.getData();
    // alert(editorContent);

    Swal.fire({
        title: 'Confirm Submission',
          text: 'Are you sure you want to submit the form?',
          icon: 'question',
                    customClass: {
    popup: 'custom-swal-width-height',
    title: 'custom-swal-title',
    htmlContainer: 'custom-swal-text',
    icon: 'custom-swal-icon'
  }
                }).then(function(result) {
                    if (result.isConfirmed) {


                        Swal.fire({
                        title: "Please wait...",
                        html: "Processing ...",
                        customClass: {
    popup: 'custom-swal-width-height',
    title: 'custom-swal-title',
    htmlContainer: 'custom-swal-text',
    icon: 'custom-swal-icon'
  }
                    })
                    Swal.showLoading();

                    $.ajax({
                        headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
                        url : "{{route('letter-save')}}",
                        type : "POST",
                        data : { terminate : editorContent},
                        success : function(response){

                            // console.log(response);

                            if(response.status == 'success'){

Swal.fire({
icon: 'success',
title: 'Success!',
text: 'Saved Successfully.',
customClass: {
popup: 'custom-swal-width-height',
title: 'custom-swal-title',
htmlContainer: 'custom-swal-text',
icon: 'custom-swal-icon'
}
}).then(function(result) {
if (result.isConfirmed) {
window.location.reload();
}
});

}

                        }
                    });

                }
            });


});

</script>

{{-- <script type="text/javascript">
    $(document).ready(function() {
  var editor=CKEDITOR.replace('programeditor',{
    extraPlugins : ['colorbutton','floatpanel','font','panel','autogrow','table'],
    height:250,
    allowedContent :true,
    uiColor : '#ffffff' , 
  });
    });

</script> --}}
@endpush