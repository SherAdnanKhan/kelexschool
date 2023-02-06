<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>121</title>

  <link href="{{asset('css/result.css')}}" rel="stylesheet" type="text/css"/>
  <style>
@media print{
    .body {
		width: 21cm;
		height: 29.7cm;
}
#printPageButton{
    display: none;
  }
  #printPageicon{
    display: none;
  }
}
</style>
</head>
<body>
<!-- A4 -->

@if(count($result)>0)
<!-- A4 -->
@for($i=0;$i<count($result);$i++)

<page size="A4mobi" layout="landscape">

<?php  $CAMPUS=Session::get('CAMPUS') ?>
<!-- top-strip -->
<div class="top-2"></div>

<!-- header start -->
<div class="header-2">

<div class="logo-2"><img src="{{asset('upload') }}/{{$CAMPUS['LOGO_IMAGE']}}" width="170" height="140" alt="logo"></div>

<!--<div class="hbg-center">-->

  <div class="large-heading"> {{$CAMPUS['SCHOOL_NAME']}}
</div>

<div class="small-heading">{{$Exam->EXAM_NAME}} EXAMINATION</div>
  <div class="small-heading"><u>RESULT CARD</u></div>


<!--</div>-->

</div>
<!-- header end -->

<div class="section-1">

  <div class="row-3">

    <div class="s-no">
      <div class="info-text">ADMISSION NO:</div>

      <div class="l-ser"> <input name="admissionNo" type="text" class="big-field" value="{{$result[$i]->REG_NO}}">

      </div>

    </div>
    <?php 
$words = explode(" ", $CAMPUS['SCHOOL_NAME']);
$acronym = "";
foreach ($words as $w) {
  $acronym .= $w[0]."-";
}
?>
    <div class="date-2">
      <div class="info-text">ROLL NUMBER:</div>

      <div class="l-date">
        <input name="rollNo" type="text" class="big-field"  value="{{$acronym}}{{$result[$i]->ROLL_NO}}">
      </div>
    </div>

  </div>

<div class="row-3">
  <div class="colleftpadding500">CERTIFICATED THAT</div>
</div>

<div class="row-3">
  <div class="colmobi">
<div class="row-4mobi">

<div class="info-text">MR/MS:</div>
<div class="block-bg3"><input name="studentName" type="text" class="big-field"  value="{{$result[$i]->NAME}}"></div>


</div>
  <div class="row-4mobi">

    <div class="info-text">FATHER NAME:</div>
    <div class="block-bg3"><input name="fName" type="text" class="big-field"  value="{{$result[$i]->FATHER_NAME}}"></div>


  </div>
  <?php $currentclassname=""; ?>
  @foreach($classes as $class)      
  @if($result[$i]->CLASS_ID==$class->Class_id)
  <?php $currentclassname=$class->Class_name; ?>
  @endif
  @endforeach
  <div class="row-4mobi">

    <div class="info-text">CLASS:</div>
    <div class="block-bg3"><input name="class" type="text" class="big-field" value="{{$currentclassname}}"></div>


  </div>
  </div>
  <div class="colmobi2">
  <img src="{{ asset('upload')}}/{{Session::get('CAMPUS_ID')}}/{{$result[$i]->IMAGE}}" alt="No image Found" style="width: 150px;height:150px;">
   </div>
</div>

  <div class="row-3">
      <table class="table1" border="3">
      <thead>
      <th>SUBJECTS</th>
      <th>MAX. MARKS</th>
      <th>PASS. MARKS</th>
      <th>MARKS OBTAINED</th>
        <th> REMARKS</th>
      </tr>
      </thead>
        <tbody>
      @if(count($record)>0)
      <?php 
      $all_sub_tot_marks=0; $grandtotal=0; $totalmarks=0; ?>
      @for($j=0;$j<count($record);$j++)
      @if($record[$j]->STUDENT_ID==$result[$i]->STUDENT_ID)
     <?php
 
     $VOB_MARKS = $record[$j]->VOB_MARKS==null ? 0 : $record[$j]->VOB_MARKS;
     $totalmarks=$record[$j]->TOB_MARKS+$VOB_MARKS; 
     $all_sub_tot_marks=$all_sub_tot_marks+$totalmarks;
     $grandtotal=$grandtotal+$record[$j]->TOTAL_MARKS; ?>
        <tr id="{{$j}}">
          <td>{{$record[$j]->SUBJECT_NAME}}</td>
          <td>{{$record[$j]->TOTAL_MARKS}}</td>
          <td>{{$record[$j]->PASSING_MARKS}}</td>
          <td>{{$totalmarks}}</td>
          <td>{{$record[$j]->REMARKS}}</td>
        </tr>
    @endif
    @endfor
<!--        outer row from loop-->
    @if($totalmarks!==0)
        <tr>
          <td colspan="2" style="text-align: right;padding-right: 15px;">
            Total Mark = {{$grandtotal}}
          </td>
          <td>GRAND TOTAL</td>
          <td> {{$all_sub_tot_marks}}</td>
          <td></td>
        </tr>
        <tr>
     <?php   $averageresult=round(($all_sub_tot_marks/$grandtotal)*100); ?>
          <td colspan="5" style="text-align: left;padding-left: 15px;">
          RESULT: <?= $averageresult>=50 ? 'PASS' : 'FAIL'; ?>   
          </td>
        </tr>
        <tr>
          <td colspan="5" style="text-align: left;padding-left: 15px;">
          
          @for ($j = 0; $j < count($grades); $j++) 
                      @for ($k = $grades[$j]->TO_MARKS; $k <= $grades[$j]->FROM_MARKS; $k++) 
                        @if($averageresult==$k)
                     DIVISION:  {{$grades[$j]->GRADE_NAME}} 
                        @endif
                       @endfor
                    @endfor
          
          </td>
        </tr>
      @endif
        @endif
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