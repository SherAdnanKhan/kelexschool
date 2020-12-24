@extends('admin.layouts.template')

@section('page_title', 'Users')

@section('content_head')
<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
  <div class="kt-container  kt-container--fluid ">
    <div class="kt-subheader__main">
      <h3 class="kt-subheader__title">
        {{-- {{ dd($feedbacks)}} --}}
        {{ $feedbacks->user->username }} 
      </h3>
      <span class="kt-subheader__separator kt-hidden"></span>
      <div class="kt-subheader__breadcrumbs">
        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="" class="kt-subheader__breadcrumbs-link">
          User 
        </a>
      </div>
    </div>
  </div>
</div>

<!-- end:: Subheader -->
@endsection('content_head')

@section('content')
<!--begin::Portlet-->
<!--Begin::Section-->
<div class="row">
  <div class="col-xl-12">
    <div class="kt-portlet kt-portlet--height-fluid">
      <div class="kt-portlet__body">
        <div class="kt-widget kt-widget--user-profile-3">
          <div class="kt-widget__top">
            <div class="kt-widget__media kt-hidden-">
              @if(isset($feedbacks->user->avatars))
                <img src="{{$feedbacks->user->avatars[0]->path}}" alt="image">
              @endif
            </div>
            <div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-boldest kt-font-light kt-hidden">
              JM
            </div>
            <div class="kt-widget__content">
              <div class="kt-widget__head">
                <a href="#" class="kt-widget__username">
                  {{ $feedbacks->user->first_name }} {{ $feedbacks->user->last_name }}
                  <i class="flaticon2-correct"></i>
                </a>
                <div class="kt-widget__action">
                  <!-- <button type="button" class="btn btn-label-success btn-sm btn-upper">ask</button>&nbsp;
                  <button type="button" class="btn btn-brand btn-sm btn-upper">hire</button> -->
                </div>
              </div>
              <div class="kt-widget__subhead">
                <a href="#"><i class="flaticon2-new-email"></i>{{ $feedbacks->user->email }}</a>
                <a href="#"><i class="flaticon2-calendar-3"></i>{{ $feedbacks->user->username }} </a>
                <a href="#"><i class="flaticon2-placeholder"></i>{{ $feedbacks->user->slug }}</a>
              </div>
              <div class="kt-widget__info">
                <div class="kt-widget__desc">
                  {{ $feedbacks->user->bio }}
                </div>
              </div>
            </div>
          </div>
          <div class="kt-widget__bottom">
            <div class="col-md-6">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"> Feedback Description</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <dl>
                  <dd> {{$feedbacks->feedback}} </dd>
                  </dl>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <div class="col-md-6">
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"> Feedback Picture</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <dl>
                    <dd>  <img src="{{$feedbacks->image->path}}" alt="photo" height="300px" height="300px"> </dd>
                  </dl>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--End::Section-->

<!--end::Portlet-->

@endsection
