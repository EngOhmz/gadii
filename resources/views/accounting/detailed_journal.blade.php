@extends('layouts.master')


@section('content')
        
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detailed Journal Entry Report</h4>
                    </div>
                    <div class="card-body">
                      
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
        <div class="panel-heading">
            <h6 class="panel-title">
               @if(!empty($start_date))
                  For the period: <b>{{Carbon\Carbon::parse($start_date)->format('d/m/Y')}}  to {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}}</b>
                @endif
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

               <div class="col-md-3">
                    <label class="">Start Date</label>
                   <input  name="start_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                    echo date('Y-m-d', strtotime('first day of january this year'));
                }
                ?>">

                </div>
                <div class="col-md-3">
                    <label class="">End Date</label>
                     <input  name="end_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($end_date)) {
                    echo $end_date;
                } else {
                    echo date('Y-m-d');
                }
                ?>">
                </div>
                <div class="col-md-3">
                    <label class="">Type</label>
                    
                    <select class="form-control m-b type" id="type" name="type" required>{{$account_id}}
                                                    <option value="">Select </option>                                                    
                                                          <option value="Client" @if(isset($type))@if('Client' == $type) selected @endif @endif>Client </option> 
                                                           <option value="Supplier" @if(isset($type))@if('Supplier' == $type) selected @endif @endif>Supplier</option> 
                                                            <option value="Staff" @if(isset($type))@if('Staff' == $type) selected @endif @endif>Staff</option> 
                                                                <option value="Others" @if(isset($type))@if('Others' == $type) selected @endif @endif>Others</option> 
                                                             </select>
                </div>
                
                
                <div class="col-md-3">
                                        <div class="form-group row" id="client" style=" display: @if(!empty($account_id)){{ 'Client' == $type ? 'block' : 'none'  }} @else none @endif;">
                                          <label class="">Client</label>                                                 
                                                <select class="m-b client_id" id="client_id" name="@if(!empty($account_id)){{'Client' == $type  ? 'account_id' : ''}}@endif">
                                                    <option value="">Select Client</option>                                                    
                                                            @foreach ($client as $c)                                                             
                                                <option value="{{$c->id}}" @if(isset($account_id))@if('Client' == $type)@if($account_id == $c->id) selected @endif @endif @endif>{{$c->name}}</option>
                                                               @endforeach
                                                             </select>
                                                    </div>
                                               

                                     <div class="form-group row" id="supplier" style=" display: @if(!empty($account_id)){{ 'Supplier' == $type ? 'block' : 'none'  }} @else none @endif;">
                                            <label class="">Supplier</label>                                                  
                                                <select class="m-b supplier_id" id="supplier_id" name="@if(!empty($account_id)){{'Supplier' == $type  ? 'account_id' : ''}}@endif">
                                                    <option value="">Select Supplier</option>                                                    
                                                            @foreach ($supplier as $m)                                                             
                                                <option value="{{$m->id}}" @if(isset($account_id))@if('Supplier' == $type)@if($account_id == $m->id) selected @endif @endif @endif>{{$m->name}}</option>
                                                               @endforeach
                                                             </select>
                                                   
                                                </div>
                                                
                                        <div class="form-group row" id="user" style=" display: @if(!empty($account_id)){{ 'Staff' == $type ? 'block' : 'none'  }} @else none @endif;">
                                                 <label class="">Staff</label>                                                  
                                                <select class="m-b user_id" id="user_id"name="@if(!empty($account_id)){{'Staff' == $type  ? 'account_id' : ''}}@endif" >
                                                    <option value="">Select Staff</option>                                                    
                                                            @foreach ($user as $u)                                                             
                                                <option value="{{$u->id}}" @if(isset($account_id))@if('Staff' == $type)@if($account_id == $u->id) selected @endif @endif @endif>{{$u->name}}</option>
                                                               @endforeach
                                                             </select>
                                                    </div>

                                                
                                        <div class="form-group row" id="others" style=" display: @if(!empty($account_id)){{ 'Others' == $type ? 'block' : 'none'  }} @else none @endif;">
                                                <label class="">Options</label>
                                                <select class="form-control m-b other_id" id="other_id" name="@if(!empty($account_id)){{'Others' == $type  ? 'account_id' : ''}}@endif" >
                                                    <option value="">Select Options</option>                                                    
                                                            @foreach ($oth as $o)                                                             
                                        <option value="{{$o->id}}" @if(isset($account_id))@if('Others' == $type)@if($account_id == $o->id) selected @endif @endif @endif>{{$o->name}}</option>
                                                               @endforeach
                                                             </select>
                                                </div>
                </div>

   <div class="col-md-4">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

                </div>                  
                </div>
           
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br>
@if(!empty($start_date))
        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">
                
                                    
                                    
                     <table class="table datatable-button-html5-basic">
                        <thead>
                        <tr>
                            <th>#</th>
                           
                            <th>Date</th>
                            <th>Account Name</th>
                            <th>Debit</th>
                            <th>Credit</th>
                     <th>Notes</th>
                        </tr>
                        </thead>
                        <tbody>
<?php
$dr=0;
$cr=0;
?>
                        @foreach($data as $key)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                               
                                <td>{{Carbon\Carbon::parse($key->date)->format('d/m/Y')}}</td>
                                <td>
                                    @if(!empty($key->chart))
                                        {{ $key->chart->account_name }}
                                    @endif
                                </td>
                                 
                                <td>{{ number_format($key->debit,2) }}</td>
                                <td>{{ number_format($key->credit,2) }}</td>
                                 <td>{{ $key->notes }}</td>
                            </tr>
<?php
$dr+=$key->debit;
$cr+=$key->credit;
?>
                        @endforeach
                        </tbody>
 <tfoot>
                            <tr class="custom-color-with-td">
                                   <td></td> <td></td>  
                                <td ><b>Total</b></td>
                                <td><b>{{ number_format($dr,2) }}</b></td>
                                   <td><b>{{ number_format($cr,2) }}</b></td>
                                    <td></td>
                                    
    
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- /.panel-body -->
             </div>
    @endif              

                                        </div>
                                    </div>
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

@section('scripts')
<link rel="stylesheet" href="{{ asset('assets/datatables/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatables/css/buttons.dataTables.min.css') }}">

<script src="{{asset('assets/datatables/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/datatables/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/jszip.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/datatables/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/buttons.print.min.js')}}"></script>
<script>

      $('.datatable-button-html5-basic').DataTable(
        {
        dom: 'lBfrtip',

        buttons: [
          {extend: 'copyHtml5',title: 'DETAILED JOURNAL ENTRY REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}} ', footer: true},
           {extend: 'excelHtml5',title: 'DETAILED JOURNAL ENTRY REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}' , footer: true},
           {extend: 'csvHtml5',title: 'DETAILED JOURNAL ENTRY REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}' , footer: true},
            {extend: 'pdfHtml5',title: 'DETAILED JOURNAL ENTRY REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}', footer: true,
           
},
            {extend: 'print',title: 'DETAILED JOURNAL ENTRY REPORT FOR THE PERIOD {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} TO {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}' , footer: true}

                ],
        }
      );
     
    </script>


 <script>
        $(document).ready(function(){
            /*
                         * Multiple drop down select
                         */
            $('.m-b').select2({ width: '100%', });



        });
    </script>
    
    
    <script>
$(document).ready(function() {

    $(document).on('change', '.type', function() {
        var id = $(this).val();
  console.log(id);


 if (id == 'Supplier'){
      $("#supplier").show();
      $("#client").hide(); 
      $("#user").hide();
      $("#others").hide();
      
      $("#supplier_id").prop('required',true);
      $("#client_id").prop('required',false);
      $("#user_id").prop('required',false);
       $("#other_id").prop('required',false);
       
       $("#supplier_id").attr("name", "account_id");;
      $("#client_id").attr("name", "");;
      $("#user_id").attr("name", "");;
       $("#other_id").attr("name", "");;
}

else if(id == 'Client'){
        $("#client").show();   
     $("#supplier").hide(); 
      $("#user").hide();
       $("#others").hide();
       
        $("#client_id").prop('required',true);
      $("#supplier_id").prop('required',false);
      $("#user_id").prop('required',false);
       $("#other_id").prop('required',false);
       
       $("#client_id").attr("name", "account_id");;
      $("#supllier_id").attr("name", "");;
      $("#user_id").attr("name", "");;
       $("#other_id").attr("name", "");;
}
else if(id == 'Staff'){
        $("#user").show(); 
        $("#client").hide(); 
     $("#supplier").hide(); 
       $("#others").hide();
       
        $("#user_id").prop('required',true);
      $("#client_id").prop('required',false);
      $("#supplier_id").prop('required',false);
       $("#other_id").prop('required',false);
       
       $("#user_id").attr("name", "account_id");;
      $("#client_id").attr("name", "");;
      $("#supplier_id").attr("name", "");;
       $("#other_id").attr("name", "");;
}

else{
     $("#others").show();
  $("#client").hide();    
     $("#supplier").hide(); 
      $("#user").hide();
      
       $("#other_id").prop('required',true);
      $("#client_id").prop('required',false);
      $("#user_id").prop('required',false);
       $("#supplier_id").prop('required',false);
       
       $("#other_id").attr("name", "account_id");;
      $("#client_id").attr("name", "");;
      $("#user_id").attr("name", "");;
       $("#supplier_id").attr("name", "");;

}


     

    });



});

</script>

@endsection