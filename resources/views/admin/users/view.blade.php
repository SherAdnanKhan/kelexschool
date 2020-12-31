@extends('admin.layouts.template')

@section('page_title', 'Users')

@section('content_head')
<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
  <div class="kt-container  kt-container--fluid ">
    <div class="kt-subheader__main">
      <h3 class="kt-subheader__title">
        {{ $user->username }} 
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
              @if(isset($user->avatar))
                <img src="{{$user->avatar->path}}" alt="image">
              @endif
            </div>
            <div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-boldest kt-font-light kt-hidden">
              JM
            </div>
            <div class="kt-widget__content">
              <div class="kt-widget__head">
                <a href="#" class="kt-widget__username">
                  {{ $user->first_name }} {{ $user->last_name }}
                  <i class="flaticon2-correct"></i>
                </a>
                <div class="kt-widget__action">
                  <!-- <button type="button" class="btn btn-label-success btn-sm btn-upper">ask</button>&nbsp;
                  <button type="button" class="btn btn-brand btn-sm btn-upper">hire</button> -->
                </div>
              </div>
              <div class="kt-widget__subhead">
                <a href="#"><i class="flaticon2-new-email"></i>{{ $user->email }}</a>
                <a href="#"><i class="flaticon2-calendar-3"></i>{{ $user->username }} </a>
                <a href="#"><i class="flaticon2-placeholder"></i>{{ $user->slug }}</a>
              </div>
              <div class="kt-widget__info">
                <div class="kt-widget__desc">
                  {{ $user->bio }}
                </div>
              </div>
            </div>
          </div>
          <div class="kt-widget__bottom">
            <div class="kt-widget__item">
              <div class="kt-widget__icon">
                <i class="flaticon-piggy-bank"></i>
              </div>
              <div class="kt-widget__details">
                <span class="kt-widget__title">Galleries</span>
                <span class="kt-widget__value">{{ $user->galleries_count }}</span>
              </div>
            </div>
            <div class="kt-widget__item">
              <div class="kt-widget__icon">
                <i class="flaticon-confetti"></i>
              </div>
              <div class="kt-widget__details">
                <span class="kt-widget__title">Posts</span>
                <span class="kt-widget__value">{{ $user->posts_count }}</span>
              </div>
            </div>
            <div class="kt-widget__item">
              <div class="kt-widget__icon">
                <i class="flaticon-pie-chart"></i>
              </div>
              <div class="kt-widget__details">
                <span class="kt-widget__title">Feeds</span>
                <span class="kt-widget__value">{{ $user->feeds_count }}</span>
              </div>
            </div>
            <div class="kt-widget__item">
              <div class="kt-widget__icon">
                <i class="flaticon-chat-1"></i>
              </div>
              <div class="kt-widget__details">
                <span class="kt-widget__title">{{ $user->comments_count }} Comments</span>
                <!-- <a href="#" class="kt-widget__value kt-font-brand">View</a> -->
              </div>
            </div>
            <div class="kt-widget__item">
              <div class="kt-widget__icon">
                <i class="flaticon-network"></i>
              </div>
              <div class="kt-widget__details">
                <div class="kt-section__content kt-section__content--solid">
                  {{ $user->feel->name }}
                </div>
              </div>
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
