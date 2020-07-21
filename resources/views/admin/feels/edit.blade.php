@extends('admin.layouts.template')

@section('page_title', 'Feels')
@section('content_head')
<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
  <div class="kt-container  kt-container--fluid ">
    <div class="kt-subheader__main">
      <h3 class="kt-subheader__title">
        {{ $feel->name }} 
      </h3>
      <span class="kt-subheader__separator kt-hidden"></span>
      <div class="kt-subheader__breadcrumbs">
        <a href="#" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="" class="kt-subheader__breadcrumbs-link">
          Feel 
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
<div class="col-lg-12">

<!--begin::Portlet-->
<div class="kt-portlet">
  <div class="kt-portlet__head">
    <div class="kt-portlet__head-label">
      <h3 class="kt-portlet__head-title">
        Feel Edit
      </h3>
    </div>
  </div>

  <!--begin::Form-->
  <form class="kt-form">
    @csrf
    <div class="kt-portlet__body">
      <div class="kt-section kt-section--first">
        <div class="form-group row">
          <label class="col-xl-3 col-lg-3 col-form-label">Feel Icon</label>
          <div class="col-lg-9 col-xl-6">
            <div class="kt-avatar kt-avatar--outline kt-avatar--circle-" id="kt_user_edit_avatar">
              <div class="kt-avatar__holder">
                <img class="feel-icon-img" src="{{$feel->image_path}}" alt="{{$feel->name}}" />
              </div>
              <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Change avatar">
                <i class="fa fa-pen"></i>
                <input type="file" name="feel_icon" accept=".png, .jpg, .jpeg">
              </label>
              <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel avatar">
                <i class="fa fa-times"></i>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-xl-3 col-lg-3 col-form-label">Color code</label>
          <div class="col-lg-9 col-xl-6">
            <input class="form-control" type="text" value="{{$feel->color_code}}">
          </div>
        </div>
      </div>
    </div>
    <div class="kt-portlet__foot">
      <div class="kt-form__actions">
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-secondary">Cancel</button>
      </div>
    </div>
  </form>

  <!--end::Form-->
</div>

<!--end::Portlet-->

</div>
</div>
<!--End::Section-->
<!--end::Portlet-->

@endsection