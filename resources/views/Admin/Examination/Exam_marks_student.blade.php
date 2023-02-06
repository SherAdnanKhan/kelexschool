@extends('Admin.layout.master')
@section("page-css")
<link href="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
<link href="{{asset('admin_assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<style>
   @media print {
  #printPageButton{
    display: none;
  }
  #printPageicon{
    display: none;
  }
}
.pagetitleh {
  font-family: "Comic Sans MS", cursive, sans-serif;
}
</style>
@endsection
@section("content")
<section class="content">
   <div class="row">
   <div class="col-md-1"> </div>
      <div class="col-md-10">
         <div class="box box-warning">
            <div class="box-header ptbnull">
               <h2 class="box-title titlefix">Exam Result </h2>
               <div class="box-tools pull-right">
                  <div class="dt-buttons btn-group btn-group2 pt5"> 
                     <a class="dt-button btn btn-default btn-xs no_print" id="printPageButton" onclick="window.print()" style="display: block"><i id="printPageicon" class=" fa fa-print"></i></a> 
                  </div>
               </div>
            </div>
            <?php $examid=100000;
              $totalmarks=0;
              $grade=' ';
              $all_sub_tot_marks=0;
              $grandtotal=0;
              $examterm=10000;
            ?>
            @if(count($record)>0)
            @for($i=0;$i<count($record);$i++)

            @if($examid!==$record[$i]->EXAM_ID)

            @if($examterm!=10000)
            <tfoot class="table-info">
            <td colspan="2">   Percentage : <?= round(($all_sub_tot_marks/$grandtotal)*100)  ?>  </td>
            <td colspan="2">   Grand Total : {{$grandtotal}}   </td>
            <td colspan="2"> Total Obtain Marks : {{$all_sub_tot_marks}}  </td>
            </tfoot>
                   <?php  $all_sub_tot_marks=1;
                            $grandtotal=0;
                            ?>
            @endif
            </tbody>
                     </table>
                  </div>
            <div class="box-body table-responsive" id="exam">
               <div class="tshadow mb25">
                  <h4 class="pagetitleh"> 
                  {{$record[$i]->EXAM_NAME}}                    
                  </h4>
              <?php $examid=$record[$i]->EXAM_ID; ?>
                  <div class="table-responsive">
                     <table class="table table-striped table-hover ptt10 table-bordered" id="headerTable">
                        <thead class="table-info">
                           <tr>
                              <th>Subject</th>
                              <th>Total Marks</th>
                              <th>Marks Obtained</th>
                              <th>
                                 Result                              
                              </th>
                              <th> Grade </th>
                              <th>Note</th>
                           </tr>
                        </thead>
                        <tbody>
                  @endif
                     
                           <tr id="{{$record[$i]->PAPER_ID}}">
                          <?php 
                          $examterm+=1;
                           $c=0;
                            $VOB_MARKS = $record[$i]->VOB_MARKS==null ? 0 : $record[$i]->VOB_MARKS;
                             $totalmarks=$record[$i]->TOB_MARKS+$VOB_MARKS;  
                            
                             $all_sub_tot_marks=$all_sub_tot_marks+$totalmarks;
                             $grandtotal=$grandtotal+$record[$i]->TOTAL_MARKS;
                            ?>
                              <td>{{$record[$i]->SUBJECT_NAME}}</td>
                              <td>{{$record[$i]->TOTAL_MARKS}}</td>
                              <td>{{$totalmarks}}</td>
                              <td>
                             <?= $totalmarks>=$record[$i]->PASSING_MARKS ? 'PASS' : 'FAIL'; ?>                           
                              </td>
                    @for ($j = 0; $j < count($grades); $j++) 
                      @for ($k = $grades[$j]->TO_MARKS; $k <= $grades[$j]->FROM_MARKS; $k++) 
                        @if($totalmarks==$k)
                       <td> {{$grades[$j]->GRADE_NAME}} </td>
                      <?php  $c+=1; ?>
                        @endif
                       @endfor
                    @endfor
                      @if($c==0)
                         <td> {{$grade}}</td>
                      @endif
                              <td>{{$record[$i]->REMARKS}}</td>
                           </tr>
                
                           @endfor
                           <tfoot class="table-info">
            <td colspan="2">   Percentage : <?= round(($all_sub_tot_marks/$grandtotal)*100)  ?>  </td>
            <td colspan="2">   Grand Total : {{$grandtotal}}   </td>
            <td colspan="2"> Total Obtain Marks : {{$all_sub_tot_marks}}  </td>
                        </tbody>
                     </table>
                  </div>
               
               @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
@section('customscript')
<script>  
</script>
        <script src="{{asset('admin_assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
        <!-- Buttons examples -->
        <script src="{{asset('admin_assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/jszip.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/pdfmake.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/vfs_fonts.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/buttons.html5.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/buttons.print.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
        <script src="{{asset('admin_assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
@endsection