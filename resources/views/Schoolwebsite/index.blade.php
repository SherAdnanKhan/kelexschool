
@extends('Schoolwebsite.layout.master')
@section('page-css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/flickity/2.2.1/flickity.css" rel="stylesheet" type="text/css" />

@endsection
@section('content')
<div class="main-container">
   <section class="cover unpad--bottom switchable switchable--switch bg--secondary text-center-xs">
    <div class="container">
        <div class="row align-items-center justify-content-around">
            <div class="col-md-6 col-lg-5 mt-0">
                <h1>
                   {{Session::get('campus_info')['campusdetails']['SCHOOL_NAME']}}
                </h1>
                <p class="lead">
                   campus details will go here....
                </p>

            </div>
            <div class="col-md-6">
                <img alt="Image" src="https://via.placeholder.com/350" />
            </div>
        </div>
        <!--end of row-->
    </div>
    <!--end of container-->
</section>
<section class="switchable feature-large">
    <div class="container">
        <div class="row justify-content-around">
            <div class="col-lg-5 col-md-6 switchable__text">
                <h2>Perfect for bootstrapped startups</h2>
                <p class="lead"> Launching an attractive and scalable website quickly and affordably is important for modern startups — Stack offers massive value without looking 'bargain-bin'. </p>
                <a class="btn btn--primary type--uppercase" href="#"> <span class="btn__text">
            Explore Detail
        </span> </a>
            </div>

        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row justify-content-center no-gutters">
            <div class="col-md-10 col-lg-8">
                <div class="boxed boxed--border">
                    <form class="text-left form-email row mx-0" method="post" id="submit_admiss_form" data-success="Thanks for your enquiry, we'll be in touch shortly." data-error="Please fill in all fields correctly.">
                        <div class="col-md-6"> <span>Name:</span> <input type="text" name="NAME" class="validate-required"> </div>
                        <div class="col-md-6"> <span>Father Name:</span> <input type="text" name="FATHER_NAME" class="validate-required"> </div>
                        <div class="col-md-6"> <span>Father Contact:</span> <input type="tel" name="FATHER_CONTACT" class="validate-required validate-email"> </div>
                        <div class="col-md-6"> <span>Present Address:</span> <input type="text" name="phone" class="validate-required"> </div>
                        <div class="col-md-6"> <span>Permanent Address:</span> <input type="text" name="phone" class="validate-required"> </div>
                        <div class="col-md-6"> <span>Date of Birth:</span> <input type="date" name="phone" class="validate-required"> </div>
                        <div class="col-md-6 boxed">
                            <h5>Gender</h5>

                        </div>
                        <div class="col-md-6 boxed">
                            <h5>Shift</h5>

                        </div>
                        <div class="col-md-3 col-3 text-center" > <span class="block">MALE</span>
                        <input type="radio" id="male" name="GENDER" value="Male">
                        </div>
                        <div class="col-md-3 col-3 text-center"> <span class="block">FEMALE</span>
                        <input type="radio" id="female" name="GENDER" value="Female">
                        </div>
                        <div class="col-md-3 col-3 text-center"> <span class="block">MORNING</span>
                        <input type="radio" id="morning" name="SHIFT" value="1">
                        </div>
                        <div class="col-md-3 col-3 text-center"> <span class="block">EVENING</span>
                        <input type="radio" id="evening" name="SHIFT" value="2">
                        </div>
                        <div class="col-md-3 col-3 text-center">
                        </div>
                        <div class="col-md-6 col-6 text-center"> <span class="block"> <b>CLASS </b></span>
                        <small id="Classes_id_error" class="form-text text-danger"></small>
                        <select name="Classes_id" id="classes_id" class="form-control formselect required">
                        {{-- @foreach($classes as $class)
                            <option value="{{$class->Class_id}}">{{$class->Class_name}}</option>
                        @endforeach --}}
                            </select>
                        </div>

                        <div class="col-md-12 boxed"> <button type="submit" class="btn btn--primary type--uppercase">Submit&nbsp;</button> </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@section('custom-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flickity/2.2.1/flickity.pkgd.min.js"></script>
<script>
jQuery(document).ready(function(){
    jQuery('.main-carousel').flickity({
    // options
    cellAlign: 'left',
    contain: true
    });
});
$('body').on('submit','#submit_admiss_form',function(e){
      e.preventDefault();
      $('#class_name_error').text('');
      var fdata = new FormData(this);
      $.ajax({
        url: '{{url("submit_admiss_form")}}',
            type:'POST',
            data: fdata,
            processData: false,
            contentType: false,
            success: function(data){
               console.log(data)
               toastr.success('success Submitted', 'Notice');
                setTimeout(function(){location.reload();},1000);
              },
              error: function(error){
               console.log(error);
               var response = $.parseJSON(error.responseText);
                    $.each(response.errors, function (key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
    }



      });
    });
</script>

@endsection
