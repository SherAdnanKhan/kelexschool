@extends('Admin.layout.master')
@section("page-css")
<!-- DataTables -->
<link href="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<div class="row col-12">
    <div class="card m-b-20 card-body">
        <h3 class="card-title font-16 mt-0">Define Fee Strcuture</h3>
        <form action="{{ route('add-fee-structure')}}" id="add-fee-structure" name="add-fee-structure" method="post" accept-charset="utf-8">

            <div class="row">
               <div class="col-md-12">

                        @if(empty($sessions)):

                        <div class="alert alert-primary">Please create Session First</div>
                        @endif;
                        @if(empty($record)):

                        <div class="alert alert-primary">Please define classes and sections first.</div>
                        @endif;

                        @if(!empty($record)):
                     <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Select {{Session::get('session')}}</label>
                                <small class="req"> *</small>
                                <select name="SESSION_ID" class="form-control formselect required" placeholder="Select Class" id="SESSION_ID" required>
                                    <option value="">{{Session::get('session')}} *</option>
                                    @foreach($sessions as $session)
                                     @php
                                            $selected = ($session->SB_ID == $sessionID) ? "selected" : "";
                                        @endphp
                                    <option {{$selected}} value="{{ $session->SB_ID }}">

                                        {{ ucfirst($session->SB_NAME) }}</option>
                                    @endforeach
                                </select>
                                <small id="SESSION_ID_error" class="form-text text-danger"></small>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table ">
                                 <thead>
                                     <tr>
                                         <th>{{Session::get('class')}}</th>
                                         <th>Fee Category</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @php $i=0;  @endphp
                                     @foreach ($record as $key => $item)
                                        <tr>
                                        <td>{{$item->Class_name}} <span class="badge badge-primary">{{$item->Section_name}}</span></td>
                                        <td>
                                        <input type="hidden" name="record[{{$i}}][section_id]" value="{{$item->Section_id}}">
                                        <input type="hidden" name="record[{{$i}}][class_id]" value="{{$item->Class_id}}">
                                        <input type="hidden" name="record[{{$i}}][fee_structure_id]" value="{{$item->FEE_STRUCTURE_ID}}">
                                            @php $j=0; @endphp
                                            @foreach($fee_cat as $k => $row)

                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    @php
                                                        $fee_cat_array = json_decode($item->FEE_CATEGORY_ID,true);
                                                        $cat_amount = json_decode($item->CATEGORY_AMOUNT,true);
                                                        $checked = null;
                                                        $disabled = 'disabled';
                                                        $amount = null;
                                                        $index = null;
                                                    //    echo $cat_amount[0];
                                                        if($fee_cat_array):
                                                            if(in_array($row->FEE_CAT_ID,$fee_cat_array)) :
                                                                 $checked = "checked";
                                                                 $index = $row->FEE_CAT_ID;
                                                                 $fee = array_column($cat_amount,$index);
                                                                 $amount = $fee[0];
                                                               else:
                                                                $checked = "";
                                                            endif;

                                                        endif;
                                                        // var_dump($amount);
                                                        if($cat_amount):
                                                            $disabled = (in_array($row->FEE_CAT_ID,$fee_cat_array)) ? "" : "disabled";
                                                        endif;

                                                    @endphp

                                                    <input {{$checked}} type="checkbox" name="record[{{$i}}][cat_id][]" value ="{{$row->FEE_CAT_ID}}" class="cat_id" data-targetclass="render-{{$item->Class_id}}-{{$item->Section_id}}-{{$row->FEE_CAT_ID}}"></span>
                                                    <span class="input-group-text">{{$row->CATEGORY}}</span>
                                                </div>
                                            <input type="number" name="record[{{$i}}][cat_amount][]" value="{{$amount}}"  class="form-control col-3 render-{{$item->Class_id}}-{{$item->Section_id}}-{{$row->FEE_CAT_ID}}" {{$disabled}}>
                                            </div>

                                            @php $j++; @endphp
                                            @endforeach
                                                @php $i++; @endphp
                                        </td>
                                        </tr>
                                     @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan=""><button type="submit" class="btn submit btn-primary">Save fee Structure</button></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @php
                        endif;
                   @endphp
               </div>
            </div>
            @csrf
        </form>
    </div>
</div>

@endsection

@section("customscript")
<!-- Required datatable js -->
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
<script>
    $(document).ready(function() {
        $('#DataTables_Table_0').DataTable();
    });
</script>
<script>
    $('body').on('change','.cat_id',function(){
         var target = $(this).data('targetclass');
        if(this.checked) {
           $('.'+target).prop('disabled',false).prop('required',true).attr('placeholder','Enter Amount');
        }else{
             $('.'+target).prop('disabled',true).prop('required',false).removeAttr('placeholder');
        }
    });

        //////////////////////////
</script>
<Script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('body').on('submit','#add-fee-structure',function(e){
        e.preventDefault();
        var session_id = $('#SESSION_ID').val();
        if(session_id == '')
        {
            toastr.error('Please select a session first');
            return false;
        }
        $('.submit').prop('disabled',true);
        var fdata = new FormData($(this)[0]);;
        try {
            $.ajax({
                type: 'POST',
                url: '{{url("apply-fee-structure")}}',
                data:fdata,
                processData: false,
                contentType: false,
                success: function(data) {
                     if(data.type == '1'){
                            toastr.success(data.response,'Success');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }else{
                            alert(data);
                        }
                }
            });
            $('.submit').prop('disabled',false);
        } catch (error) {
            alert(error);
        }
        return false;
    })
</script>


@endsection
