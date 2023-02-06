@extends('admin.layouts.template')

@section('page_title', 'Feels')

@section('content')
<!--begin::Portlet-->
<!--Begin::Section-->
<div class="row">
  <div class="col-xl-12">
    <div class="color-changer-screen" style="display: block;">
      <div class="center-center">
        <div class="feel-img">
          @foreach($feels as $feel)
            <div class="{{$feel->name}}">
            <a href="{{action('Admin\FeelController@show', $feel->id)}}" >
              <span class="edit-feel-icon"><i class="flaticon-edit"></i></span>
            </a>
            <img alt="" src="{{$feel->image_path}}" color="{{$feel->color}}">
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
<!--End::Section-->
<!--end::Portlet-->

@endsection
