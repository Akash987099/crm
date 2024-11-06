@extends('managerend.layout.master')

@section('content')

<div class="pagetitle">
    <div class="row">
        <div class="col-lg-9">
            <h1>View Files</h1>
        </div>
        <div class="col-lg-3">
            <nav>
                <ol class="breadcrumb">
                    <li class="p-1">
                        <a class="btn btn-primary btn-sm text-white" href="{{route('adminagent')}}"><i class="bi bi-list"></i> View</a>
                      
                    </li>
                    {{-- <li class="p-1"><a class="btn btn-danger btn-sm text-white" href="{{url('manager/archive-market-mteam')}}"><i class="bi bi-archive"></i> Archive</a></li> --}}
                    <li class="p-1"><a href="{{ url()->previous() }}" class="btn btn-success btn-sm text-white"><i class="bi bi-arrow-left" ></i> Back</a></li>
                    
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
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(Session::has('error'))
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                        {{Session::get('error')}}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="container mt-5">

                        <div class="m-2">

                            <div class="row">

                                @foreach ($filenew as $key => $val)
                                    
                              
                                <div class="col-4">

                                    <div class="card" style="width: 18rem;">
                                        {{-- <img class="card-img-top" src="..." alt="Card image cap"> --}}
                                        <iframe src="{{asset('storage/app/public/')}}/{{$val->path}}" frameborder="0" class="card-img-top"></iframe>
                                        <div class="card-body">
                                          {{-- <h5 class="card-title">Card title</h5>
                                          <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> --}}
                                          <a href="{{asset('storage/app/public/')}}/{{$val->path}}" class="btn btn-primary btn-sm">Click here</a> 
                                        </div>
                                      </div>

                                </div>

                                @endforeach

                                

                                

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