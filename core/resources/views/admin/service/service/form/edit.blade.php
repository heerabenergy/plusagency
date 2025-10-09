@extends('admin.layout')


@if(!empty($service->language) && $service->language->rtl == 1)
@section('styles')
<style>
    form input,
    form textarea,
    form select {
        direction: rtl;
    }
    .nicEdit-main {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif



@section('content')
  <div class="page-header">
    <h4 class="page-title">Form Builder</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{route('admin.dashboard')}}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Service Management</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Form Builder</a>
      </li>
    </ul>
  </div>


      <div class="card">
        <div class="card-header">
          <div class="card-title">
              <div class="row">
                  <div class="col-lg-6">
                    Edit Input
                  </div>
                  <div class="col-lg-6 text-right">
                    <a class="btn btn-primary" href="{{route('admin.service.form.index',$service->id)}}">Back</a>
                  </div>
              </div>
          </div>
        </div>

        <div class="card-body">
            @include('admin.partials.edit-form',[
                "updateRoute"=>"admin.service.form.inputUpdate",
                "optionsRoute"=>"admin.service.form.options",
                "input"=>$input
            ])

        </div>

      </div>


@endsection



