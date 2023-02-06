@extends('Admin.layout.master')

@section('content')
<div class="page-content-wrapper">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <div class="card m-b-20">
                  <div class="row">
               <div class="col-md-12">
               <div class="pt-5">
                <div class="row d-flex justify-content-center align-items-center" style="padding-top:50px;">
                    <h1>Teacher TimeTable details</h1>
                </div>
                    
                        <div id="myDIV" >
                              <div class="box-body">
                           <div class="table-responsive">
                           <table class="table" id="customers">
                              <thead id="theads">
                   <th width="125">Time</th>
               @for($i = 1; $i < count($WEEK_DAYS); $i++)
                  <th> {{$WEEK_DAYS[$i]}} </th>
             
               @endfor
                              </thead>
                 <tbody id="tabledata">
                       
                @foreach($calendarData as $time => $days)
                    <tr>
                 <td>   {{ $time }} </td>
                 @foreach($days as $value)
                  @if (is_array($value))
   
                  <td rowspan="{{$value['rowspan']}}" class="align-middle text-center" style="background-color:#f0f0f0;width:100px;height:20px">
                  Subject: {{$value['subject_name']}}<br>
                  Room : {{$value['class_name']}}<br>          
                 @elseif($value === 1)
                  <td></td>
                 @endif          
               @endforeach
                 </tr> 
               @endforeach                
                                    </tbody>
                                 </table>
                              </div>
                        </div>
                     </div>
            </div>
         </div>
      </div>
   </div>
</div>
       
</div>
@endsection

@section('customscript')


@endsection