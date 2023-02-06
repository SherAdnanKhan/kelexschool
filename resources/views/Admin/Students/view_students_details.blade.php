@extends('Admin.layout.master')
@section("page-css")
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

@endsection
@section("content")
<div class="page-content-wrapper">
<div class="row">
<div class="col-12">
   <div class="card m-b-20">
         <div class="card-body">
         @if(Session::get('is_admin'))
         <a href="{{route('showstudent')}}" class="btn btn-primary">View All Students</a>
         @endif
      <br><br>
      <div class="row">
         <div class="col-md-3">
         <div class="box box-primary">
            <div class="box-body box-profile">
               <img class="profile-user-img img-responsive img-circle" src="{{asset('upload')}}/{{Session::get('CAMPUS_ID')}}/{{$student['IMAGE']}}" onerror="this.src='https://via.placeholder.com/200'" alt="User profile picture" style="height: 250px; width:250px">
               <h3 class="profile-username text-center">{{ucfirst($student['NAME'])}}</h3>
               <ul class="list-group list-group-unbordered">
                  <li class="list-group-item listnoback">
                     <b>Admission No</b> <a class="pull-right text-aqua"> {{ucfirst($student['REG_NO'])}}</a>
                  </li>
                  <li class="list-group-item listnoback">
                     <b>{{Session::get('class')}}</b> <a class="pull-right text-aqua">{{ucfirst($class['Class_name'])}} ({{ucfirst($session['SB_NAME'])}})</a>
                  </li>
                  <li class="list-group-item listnoback">
                     <b>{{Session::get('section')}}</b> <a class="pull-right text-aqua">{{ucfirst($section['Section_name'])}}</a>
                  </li>
                  <li class="list-group-item listnoback">
                     <b>Gender</b> <a class="pull-right text-aqua">{{ucfirst($student['GENDER'])}}</a>
                  </li>
                  @if(Session::get('is_admin'))
                  <li class="list-group-item listnoback">
                     <b>Id Card</b> <a href="/getidcard/{{$student['STUDENT_ID']}}" class="btn btn-primary pull-right text-aqua"> Show</a>
                  </li>
                  @endif
               </ul>
            </div>
         </div>
      </div>
      <div class="col-md-9">
      <ul class="nav nav-pills nav-justified" style="width: 250px;" role="tablist">
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link active" data-toggle="tab" href="#activity" role="tab">Profile</a>
                                                </li>
                                                <!-- <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link" data-toggle="tab" href="#fee" role="tab">Fees</a>
                                                </li>
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link" data-toggle="tab" href="#documents" role="tab">Documents</a>
                                                </li>
                                                <li class="nav-item waves-effect waves-light">
                                                    <a class="nav-link" data-toggle="tab" href="#timelineh" role="tab">Timeline</a>
                                                </li>
                                                <li class="pull-right dropdown">
                                                      <a href="#" class="dropdown-toggle" type="button" data-toggle="dropdown" data-original-title="" title="" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                      <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" onclick="send_password()"> Send Student Password</a></li>
                                                            <li><a class="dropdown-item" onclick="send_parent_password()">  Send Parent Password</a></li>
                                                      </ul>
                                                </li> -->
                                                
      </ul>
            <div class="tab-content" style="padding:20px;">
               <div class="tab-pane active" id="activity">
                  <div class="tshadow mb25 bozero">
                     <div class="table-responsive around10 pt0">
                        <table class="table table-hover table-striped tmb0">
                           <tbody>
                              <tr>
                                 <td>Date of Birth</td>
                                 <td class="text-right">{{$student['DOB']}}</td>
                              </tr>
                              <tr>
                                 <td>Mobile Number</td>
                                 <td class="text-right">{{$student['SECONDARY_CONTACT']}}</td>
                              </tr>
                              <tr>
                                 <td>Religion</td>
                                 <td class="text-right">{{$student['RELIGION']}}</td>
                              </tr>
                              <tr>
                                 <td>CNIC/FORM B</td>
                                 <td class="text-right">{{$student['CNIC']}}</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="tshadow mb25 bozero">
                     <h3 class="pagetitleh2">Address </h3>
                     <div class="table-responsive around10 pt0">
                        <table class="table table-hover table-striped tmb0">
                           <tbody>
                              <tr>
                                 <td class="col-md-4">Current Address</td>
                                 <td class="col-md-5">{{$student['PRESENT_ADDRESS']}}</td>
                              </tr>
                              <tr>
                                 <td>Permanent Address</td>
                                 <td>{{$student['PERMANENT_ADDRESS']}}</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="tshadow mb25 bozero">
                     <h3 class="pagetitleh2">Parent / Guardian Details </h3>
                     <div class="table-responsive around10 pt10">
                        <table class="table table-hover table-striped tmb0">
                           <tbody>
                              <tr>
                                 <td class="col-md-4">Father Name</td>
                                 <td class="col-md-5">{{$student['FATHER_NAME']}}</td>
                              </tr>
                              <tr>
                                 <td>Father Phone</td>
                                 <td>{{$student['FATHER_CONTACT']}}</td>
                              </tr>
                              <tr>
                                 <td>Father CNIC</td>
                                 <td>{{$student['FATHER_CNIC']}}</td>
                              </tr>
                                 <td>Guardian Name</td>
                                 <td>{{$student['GUARDIAN']}}</td>
                              </tr>
                              <tr>
                                 <td>Guardian CNIC</td>
                                 <td>{{$student['FATHER_CNIC']}}</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="tab-pane" id="fee">
                  <div class="table-responsive">
                     <table class="table table-hover table-striped">
                        <thead>
                           <tr>
                              <th>Fees Group</th>
                              <th>Fees Code</th>
                              <th class="text text-left">Due Date</th>
                              <th class="text text-left">Status</th>
                              <th class="text text-right">Amount <span>($)</span></th>
                              <th class="text text-left">Payment Id</th>
                              <th class="text text-left">Mode</th>
                              <th class="text text-left">Date</th>
                              <th class="text text-right">Discount <span>($)</span></th>
                              <th class="text text-right">Fine <span>($)</span></th>
                              <th class="text text-right">Paid <span>($)</span></th>
                              <th class="text text-right">Balance</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr class="dark-gray">
                              <td>Class 1 General</td>
                              <td>apr-month-fees</td>
                              <td class="text text-left">
                                 04/10/2020                                                        
                              </td>
                              <td class="text text-left">
                                 <span class="label label-success">Paid</span>
                              </td>
                              <td class="text text-right">300.00</td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">300.00</td>
                              <td class="text text-right">
                              </td>
                           </tr>
                           <tr class="white-td">
                              <td class="text-left"></td>
                              <td class="text-left"></td>
                              <td class="text-left"></td>
                              <td class="text-left"></td>
                              <td class="text-right"><img src="https://demo.smart-school.in/backend/images/table-arrow.png" alt=""></td>
                              <td class="text text-left">
                                 <a href="#" data-toggle="popover" class="detail_popover" data-original-title="" title=""> 57/1</a>
                                 <div class="fee_detail_popover" style="display: none">
                                    <p class="text text-info"> Collected By: Joe Black(9000)</p>
                                 </div>
                              </td>
                              <td class="text text-left">Cash</td>
                              <td class="text text-center">
                                 04/06/2020                                                                
                              </td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">300.00</td>
                              <td></td>
                           </tr>
                           <tr class="danger font12">
                              <td>Class 1 General</td>
                              <td>may-month-fees</td>
                              <td class="text text-left">
                                 05/04/2020                                                        
                              </td>
                              <td class="text text-left">
                                 <span class="label label-danger">Unpaid</span>
                              </td>
                              <td class="text text-right">300.00</td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">300.00
                              </td>
                           </tr>
                           <tr class="danger font12">
                              <td>Class 1 General</td>
                              <td>jun-month-fees</td>
                              <td class="text text-left">
                                 06/03/2020                                                        
                              </td>
                              <td class="text text-left">
                                 <span class="label label-danger">Unpaid</span>
                              </td>
                              <td class="text text-right">300.00</td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">300.00
                              </td>
                           </tr>
                           <tr class="danger font12">
                              <td>Class 1 General</td>
                              <td>jul-month-fees</td>
                              <td class="text text-left">
                                 07/02/2020                                                        
                              </td>
                              <td class="text text-left">
                                 <span class="label label-danger">Unpaid</span>
                              </td>
                              <td class="text text-right">300.00</td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">300.00
                              </td>
                           </tr>
                           <tr class="danger font12">
                              <td>Class 1 General</td>
                              <td>aug-month-fees</td>
                              <td class="text text-left">
                                 08/02/2020                                                        
                              </td>
                              <td class="text text-left">
                                 <span class="label label-danger">Unpaid</span>
                              </td>
                              <td class="text text-right">300.00</td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">300.00
                              </td>
                           </tr>
                           <tr class="danger font12">
                              <td>Class 1 General</td>
                              <td>sep-month-fees</td>
                              <td class="text text-left">
                                 09/02/2020                                                        
                              </td>
                              <td class="text text-left">
                                 <span class="label label-danger">Unpaid</span>
                              </td>
                              <td class="text text-right">300.00</td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">300.00
                              </td>
                           </tr>
                           <tr class="danger font12">
                              <td>Class 1 General</td>
                              <td>oct-month-fees</td>
                              <td class="text text-left">
                                 10/02/2020                                                        
                              </td>
                              <td class="text text-left">
                                 <span class="label label-danger">Unpaid</span>
                              </td>
                              <td class="text text-right">300.00</td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">300.00
                              </td>
                           </tr>
                           <tr class="dark-gray">
                              <td>Class 1 General</td>
                              <td>nov-month-fees</td>
                              <td class="text text-left">
                                 11/04/2020                                                        
                              </td>
                              <td class="text text-left">
                                 <span class="label label-danger">Unpaid</span>
                              </td>
                              <td class="text text-right">300.00</td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">300.00
                              </td>
                           </tr>
                           <tr class="dark-gray">
                              <td>Class 1 General</td>
                              <td>dec-month-fees</td>
                              <td class="text text-left">
                                 12/02/2020                                                        
                              </td>
                              <td class="text text-left">
                                 <span class="label label-danger">Unpaid</span>
                              </td>
                              <td class="text text-right">300.00</td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">300.00
                              </td>
                           </tr>
                           <tr class="dark-gray">
                              <td>Class 1 General</td>
                              <td>caution-money-fees</td>
                              <td class="text text-left">
                                 12/02/2020                                                        
                              </td>
                              <td class="text text-left">
                                 <span class="label label-danger">Unpaid</span>
                              </td>
                              <td class="text text-right">1000.00</td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">1000.00
                              </td>
                           </tr>
                           <tr class="dark-gray">
                              <td>Class 1 General</td>
                              <td>exam-fees</td>
                              <td class="text text-left">
                                 12/04/2020                                                        
                              </td>
                              <td class="text text-left">
                                 <span class="label label-danger">Unpaid</span>
                              </td>
                              <td class="text text-right">250.00</td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">250.00
                              </td>
                           </tr>
                           <tr class="dark-gray">
                              <td>Class 1 General</td>
                              <td>jan-month-fees</td>
                              <td class="text text-left">
                                 01/02/2021                                                        
                              </td>
                              <td class="text text-left">
                                 <span class="label label-danger">Unpaid</span>
                              </td>
                              <td class="text text-right">300.00</td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">300.00
                              </td>
                           </tr>
                           <tr class="dark-gray">
                              <td>Class 1 General</td>
                              <td>feb-month-fees</td>
                              <td class="text text-left">
                                 01/02/2021                                                        
                              </td>
                              <td class="text text-left">
                                 <span class="label label-danger">Unpaid</span>
                              </td>
                              <td class="text text-right">300.00</td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-left"></td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">0.00</td>
                              <td class="text text-right">300.00
                              </td>
                           </tr>
                           <tr class="box box-solid total-bg">
                              <td></td>
                              <td></td>
                              <td></td>
                              <td class="text text-right">Grand Total</td>
                              <td class="text text-right">$4550.00</td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td class="text text-right">$0.00</td>
                              <td class="text text-right">$0.00</td>
                              <td class="text text-right">$300.00</td>
                              <td class="text text-right">$4250.00</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="tab-pane" id="documents">
                  <div class="timeline-header no-border">
                     <button type="button" data-student-session-id="11" class="btn btn-xs btn-primary pull-right myTransportFeeBtn"> <i class="fa fa-upload"></i>  Upload Documents</button>
                     <!-- <h2 class="page-header"> </h2> -->
                     <div class="table-responsive" style="clear: both;">
                        <div class="row">                                     
                        </div>
                        <table class="table table-striped table-bordered table-hover">
                           <thead>
                              <tr>
                                 <th>
                                    Title                                                
                                 </th>
                                 <th>
                                    Name                                                
                                 </th>
                                 <th class="mailbox-date text-right">
                                    Action                                                
                                 </th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <td colspan="5" class="text-danger text-center">No Record Found</td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="tab-pane" id="timelineh">
                  <div>                                       <input type="button" id="myTimelineButton" class="btn btn-sm btn-primary pull-right " value="Add"> 
                  </div>
                  <br>
                  <div class="timeline-header no-border">
                     <div id="timeline_list">
                        <br>
                        <div class="alert alert-info">No Record Found</div>
                     </div>
                     <!-- <h2 class="page-header"> </h2> -->
                  </div>
               </div>
               <div class="tab-pane" id="exam">
                  <div class="examgroup_result1"> </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
</div>
</div>
</section>
@endsection
