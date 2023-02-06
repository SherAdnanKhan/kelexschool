<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>121</title>
  
  <link href="{{asset('css/certificate.css')}}" rel="stylesheet" type="text/css"/>

</head>
<body>
@if(count($result)>0)
<!-- A4 -->
@for($i=0;$i<count($result);$i++)
<page size="A4" layout="landscape">

<!-- top-strip -->
<div class="top-2"></div>


<div class="section-1">

  <div class="row-3">

    <div class="s-no">
      <div class="info-text">{{Session::get('campusname')}} NAME:</div>
      <?php  $CAMPUS=Session::get('CAMPUS') ?>
      <div class="2-ser"> <b><input name="mail" type="text" class="big-field" id="mail" value="{{ $CAMPUS['SCHOOL_NAME']}}">
      </div>

    </div>

    <div class="date-2">
      <div class="info-text">EXAM CENTER:</div>

      <div class="2-date">
        <input name="mail" type="text" class="big-field" id="mail" value="{{ $CAMPUS['SCHOOL_NAME']}}">
      </div>
    </div>

  </div>

<div class="row-3">
<div class="s-no">
<div class="info-text">Student Name:</div>
<div class="2-ser"><input name="mail" type="text" class="big-field" id="mail" value="{{$result[$i]->NAME}}"></div>
</div>

</div>

<div class="row-3">

<div class="s-no">
<div class="info-text">Roll No:</div>
<?php 
$words = explode(" ", $CAMPUS['SCHOOL_NAME']);
$acronym = "";
foreach ($words as $w) {
  $acronym .= $w[0]."-";
}
?>
<div class="2-ser">
<input name="mail" type="text" class="big-field" id="mail" value="{{$acronym}}{{$result[$i]->ROLL_NO}}">

</div>

</div>

<div class="date-2">
<div class="info-text"
>Date:</div>
<div class="2-date">
<input name="mail" type="text" class="big-field" id="mail" value="{{$Exam->START_DATE}} TO {{$Exam->END_DATE}}">
</div>
</div>

</div>




  <div class="row-3">
      <table border="3">
      <thead>
      <tr>
      <th>SUBJECT CODE</th>
      <th>SUBJECT NAME</th>
      <td>DURATION</td>
      <th>DATE</th>
      </tr>
      </thead>
        <tbody>
          @for($j=0;$j<count($data);$j++)
        <tr id="{{$j}}">
          <td>{{$data[$j]->SUBJECT_CODE}}</td>
          <td>{{$data[$j]->SUBJECT_NAME}}</td>
          <td>{{$data[$j]->TIME}}</td>
          <td>{{$data[$j]->DATE}}</td>
        </tr>
        @endfor
        </tbody>

    </table>
  </div>

<div class="row-3">
<div class="sign-bg2">

<div class="bottom2"></div>

<div class="sign-2">Verified by<br>
CONTROLLER OF EXAMINATION <br>
{{ strtoupper($CAMPUS['SCHOOL_NAME'])}}
</div>
</div>

</div>

</div>




</page>
@endfor
@else
<div class="alert alert-danger" role="alert">
Please Apply Exam Before Printing Roll Number!
</div>
@endif
<!-- partial -->
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

</body>
</html>