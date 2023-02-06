<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>121</title>
  
 
  <link href="{{asset('css/certificate.css')}}" rel="stylesheet" type="text/css"/>
</head>
<body>
<!-- A4 -->

<page size="A4" layout="landscape">

<?php  $CAMPUS=Session::get('CAMPUS') ?>
<!-- top-strip -->
<div class="top-2"></div>

<!-- header start -->
<div class="header-2">

<div class="logo-2"><img src="{{asset('upload') }}/{{$CAMPUS['LOGO_IMAGE']}}" width="170" height="140" alt="logo"></div>

<div class="hbg-center">
<div class="large-heading"> {{$CAMPUS['SCHOOL_NAME']}}
</div>

<div class="small-heading">{{$CAMPUS['SCHOOL_ADDRESS']}}</div>
<div class="large-heading">{{Session::get('campusname')}} Leaving Certificate

</div>

</div>

</div>
<!-- header end -->

<div class="section-1">
<div class="row-3">
<div class="s-no">
<div class="info-text">S No:</div>

<div class="l-ser">
<input name="serialNo" type="text" class="big-field" id="mail" value="{{$SLCDATA->STD_WITHDRAW_ID}}">

</div>

</div>

<div class="date-2">
<div class="info-text"
>Admission No:</div>

<div class="l-date">
<input name="addmissionNo" type="text" class="big-field" id="mail" value="{{$SLCDATA->REG_NO}}">
</div>
</div>

</div>


<div class="row-3">

<div class="info-text">Certified that:</div>
<div class="name-bg2mobi"><input name="certifiedThat" type="text" class="big-field" id="mail" value="{{$SLCDATA->NAME}}"></div>


</div>

<div class="row-3">

<div class="info-text">S/o:</div>
<div class="name-bg3"><input name="mail" type="text" class="big-field" id="mail" value="{{$SLCDATA->FATHER_NAME}}"></div>


</div>

<div class="row-3">

<div class="info-text">Attended this {{Session::get('campusname')}} from:</div>
<div class="block-bg3"><input name="attendedFrom" type="text" class="big-field" id="mail" value="{{ \Carbon\Carbon::parse($SLCDATA->created_at)->format('d, m, Y') }}"></div>
  <div class="info-text">to:</div>
  <div class="l-ser1"><input name="attendedTo" type="text" class="big-field" id="mail" value="{{ \Carbon\Carbon::parse($SLCDATA->WITHDRAW_DATE)->format('d, m, Y') }}">
  </div>

</div>

<div class="row-3">


  <div class="info-text">  and now leave the {{Session::get('campusname')}} having paid all dues to date.</div>
</div>
  <div class="row-3"></div>
<div class="row-3">

<div class="info-text">His/Her date of birth, as per {{Session::get('campusname')}} record,is (in words)</div>
<div class="block-bg1"><input name="inWord" type="text" class="big-field" id="mail" value="{{ \Carbon\Carbon::parse($SLCDATA->WITHDRAW_DATE)->format('j F, Y') }}"></div>
<div class="info-text">(in figures)</div>
<div class="l-date"><input name="inFigures" type="text" class="big-field" id="mail" value="{{ \Carbon\Carbon::parse($SLCDATA->WITHDRAW_DATE)->format('d, m, Y') }}"></div>

</div>

  <div class="row-3">
  <?php $prevclassname=""; ?>
  @foreach($classes as $class)      
  @if($SLCDATA->PREV_CLASS==$class->Class_id)
  <?php $prevclassname=$class->Class_name; ?>
  @endif
  @endforeach
    <div class="info-text">Last Examination passed by him/her was that of {{Session::get('class')}}</div>
    <div class="block-bg3mobi"><input name="attendedFrom" type="text" class="big-field" id="mail" value="{{$prevclassname}}"></div>


  </div>

  <div class="row-3">
    <div class="info-text">Now he is in {{Session::get('class')}}</div>
    <?php $currentclassname=""; ?>
  @foreach($classes as $class)      
  @if($SLCDATA->CLASS_ID==$class->Class_id)
  <?php $currentclassname=$class->Class_name; ?>
  @endif
  @endforeach
    <div class="block-bg3"><input name="currentClass" type="text" class="big-field" id="mail" value="{{$currentclassname}}"></div>
  </div>
 <!--  <div class="row-3">
    <div class="info-text">His/Her conduct is </div>
    <div class="block-bg3"><input name="character" type="text" class="big-field" id="mail" value=""></div>
  </div> -->


<div class="row-3">

<div class="info-text">Registration No:</div>
<div class="block-bg3"><input name="mail" type="text" class="big-field" id="mail" value="{{$SLCDATA->REG_NO}}"></div>
</div>

  <div class="row-3">
    <div class="s-no">
      <div class="info-text">Date:</div>

      <div class="l-ser">
        <input name="date" type="text" class="big-field" id="mail" value="{{ \Carbon\Carbon::now()->format('d, m, Y')}}">

      </div>

    </div>

    <div class="date-2">
      <div class="sign-bg2">

        <div class="bottom2"></div>

        <div class=""style="text-align:center;">Verified by <br>
         PRINCIPAL {{ strtoupper($CAMPUS['SCHOOL_NAME'])}}</div>
      </div>
    </div>

  </div>

</div>




</page>


<!-- partial -->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

</body>
</html>