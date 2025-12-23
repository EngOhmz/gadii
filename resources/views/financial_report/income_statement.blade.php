@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Income Statement </h4>
                    </div>
                    <div class="card-body">
                       
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
        <div class="panel-heading">
            <h6 class="panel-title">
               @if(!empty($start_date))
                    For the period: <b> {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} to {{Carbon\Carbon::parse($second_date)->format('d/m/Y')}}</b>
                @endif
         
            </h6>
        </div>

<br>
         <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

                <div class="col-md-4">
                    <label class="">Start Date <span class="required"> * </span></label>
                   <input id="start_date" name="start_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                    echo date('Y-m-d', strtotime('first day of january this year'));
                }
                ?>">

                </div>
                 <div class="col-md-4">
                    <label class="">End Date <span class="required"> * </span></label>
                     <input id="second_date" name="second_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($second_date)) {
                    echo $second_date;
                } else {
                    echo date('Y-m-d');
                }
                ?>">
                </div>
                
                <?php $a=  trim(json_encode($x), '[]');  ?>
                
               

                <div class="col-md-4">
                    <label class="">Branch</label> 
                   
                    <select name="branch_id" class="form-control m-b branch" id="branch_id">
                        <option value="">Select Branch</option>
                      @if(!empty($branch))
                       
                        @foreach($branch as $br)
                        <option value="{{$br->id}}" @if(isset($branch_id)){{  $branch_id == $br->id  ? 'selected' : ''}} @endif>{{$br->name}}</option>
                        @endforeach
                         <option value="<?php echo trim(json_encode($x), '[]');; ?>" @if(isset($branch_id)){{ $branch_id == $a  ? 'selected' : ''}} @endif>All Branches</option>
                        @endif
                    </select>
                    
                </div>
           

   <div class="col-md-12">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

@if(!empty($start_date))
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle "
                                    data-toggle="dropdown">Download Report
                                <span class="caret"></span></button>
                            <div class="dropdown-menu">
                              
                                    <li class="nav-item">
                <a class="nav-link" href="{{url('financial_report/income_statement/pdf?start_date='.$start_date.'&end_date='.$second_date.'&branch_id='.$branch_id)}}"
                                       target="_blank"><i
                                                class="icon-file-pdf"></i>  Download PDF
                                    </a></li>
                                
                                    <li class="nav-item">
                            <a class="nav-link" href="{{url('financial_report/income_statement/excel?start_date='.$start_date.'&end_date='.$second_date.'&branch_id='.$branch_id)}}"
                                       target="_blank"><i
                                                class="icon-file-excel"></i> Download Excel
                                    </a></li>
                                
                            </div>
                        </div>
                      @endif

                </div>                  
                </div>
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br>
 @if(!empty($start_date))
 
  @if(isset($branch_id))
     @php
     if($branch_id == $a){
         $br_id=$x;
     }
     
     else{
         
      $br_id=$z;    
     }
     
     @endphp
     @endif
     
        <div class="panel panel-white col-lg-12">
            <div class="panel-body table-responsive no-padding">
            
           

                  <table id="data-table" class="table table-striped ">
                    <thead>
                    <tr>
                        <th colspan="5"></th>
                         
                    </tr>
                    </thead>
                      <tbody>
                    <tr>
                        <td colspan="4" style="text-align: left"><b>Income</b></td>
                    </tr>
                                 <?php
                     $c=0;     
                    $sales_balance  = 0;
                     $sales_balance1  = 0;
                    $total_incomes  = 0;
                    $total_incomes1 = 0;
                     $total_other_incomes  = 0;
                    $total_other_incomes1 = 0;
                    $cost_balance  = 0;
                    $cost_balance1  = 0;
                    $total_cost  = 0;
                    $total_cost1  = 0;
                    $expense_balance  = 0;
                    $expense_balance1 = 0;
                    $total_expense  = 0;
                    $total_expense1  = 0;
                    $gross  = 0;
                    $gross1  = 0;
                   $profit=0;
                   $profit1=0;
                  $tax=0;
                  $tax1=0;
                $net_profit=0;
                $net_profit1=0;
?>            
     
     @foreach($income->where('added_by',auth()->user()->added_by) as $account_class)
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group)   
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code)
@php
     $account_id=$account_code->id;
      $amount=App\Traits\Calculate_Account::get_amount($start_date,$second_date,$branch_id,$account_id);
     
     @endphp

<tr>
  <td>{{$account_code->account_name }}</td>
<td><a onclick="model({{ $account_code->id }},'account')" href="#view{{$account_code->id}}" data-toggle="modal" data-target="#appFormModal">{{$account_code->account_codes }}</a>
 
</td>
 <?php

                            
                            
                      

                       $income_balance=$amount['debit']- $amount['credit'];
                          $total_incomes+=$income_balance ;
                          

                        ?>                          
                             <td>{{ number_format(abs($income_balance),2) }}</td>
                           
                             

                        </tr>
                                                                
 @endforeach 
  @endforeach
  @endforeach
 
           <tr>
                        <td >
                            <b>Total Income</b></td>
                           <td colspan="5" style="text-align: right"><b>{{ number_format(abs($total_incomes),2) }}</b></td>
                           
                         
                    </tr> 
                    
                     
                       <?php

if($total_other_incomes < 0){
$total_o=$total_other_incomes * -1;
}
else if($total_other_incomes >= 0){
$total_o=$total_other_incomes ;
}




if($total_incomes < 0){
$total_s=$total_incomes * -1;
$gross=$total_s+$total_o-$total_cost;
}
else if($total_incomes >= 0){
$gross=$total_incomes+$total_o-$total_cost;
}


?>
                    
                       <tr>
                        <td colspan="7" style="text-align: left"><b>Expenses</b></td>
                    </tr>



                  @foreach($expense->where('added_by',auth()->user()->added_by) as $account_class)
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group)        
    @if($group->group_id != 6180)
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code)
 @php
     $account_id=$account_code->id;
      $amount=App\Traits\Calculate_Account::get_amount($start_date,$second_date,$branch_id,$account_id);
     
     @endphp
<tr>
 <td>{{$account_code->account_name }}</td>
<td><a onclick="model({{ $account_code->id }},'account')" href="#view{{$account_code->id}}" data-toggle="modal" data-target="#appFormModal">{{$account_code->account_codes }}</a>
  
</td>
 <?php
                   

                        

                       $expense_balance=$amount['debit']- $amount['credit'];;
                          $total_expense+=$expense_balance ;
                          
                        ?>                           
                             <td>{{ number_format(abs($expense_balance),2) }}</td>

                        </tr>
                                                               
 @endforeach  
 @endif
  @endforeach
  @endforeach

   
           <tr>
                        <td >
                            <b>Total Expenses</b></td>
                           <td colspan="5" style="text-align: right"><b>{{ number_format($total_expense,2) }}</b></td>
                    </tr> 
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>
                           <b>Profit Before Tax</b></td>
                        <?php

if($gross < 0){
$profit=$gross+$total_expense;
}
else if($gross < 0 && $total_expense < 0){
$profit=$gross+$total_expense;
}
else if($gross >= 0 && $total_expense < 0){
$profit=$total_expense +$gross;
}
else{
$profit=$gross-$total_expense;
}


?>
                         <td colspan="5" style="text-align: right"><b>{{ number_format($profit,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>Tax</b></td>
                               <?php
if($profit > 0){
$tax=$profit*0.3;
}


?>
                        <td colspan="5" style="text-align: right"><b>{{ number_format($tax,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>Net Profit</b></td>
                        <td colspan="5" style="text-align: right"><b>{{ number_format($profit-$tax,2) }}</b></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
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
 @if(!empty($start_date))
  <!-- Modal -->
 <div class="modal fade"  data-backdrop="" id="appFormModal"  tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg">
   
</div>
  </div>


@endif


@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"targets": [1]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>
    
     <script>
     
        function model(id, type) {
            
            var start_date = $('#start_date').val();
            var second_date = $('#second_date').val();
            var end_date = $('#end_date').val();
            var branch_id = $('.branch').val();

            $.ajax({
                type: 'GET',
                url: '{{ url('financial_report/reportModal') }}',
                data: {
                    'id': id,
                    'type': type,
                    'start_date': start_date,
                    'second_date': second_date,
                     'end_date': end_date,
                    'branch_id': branch_id,
                },
                cache: false,
                async: true,
                success: function(data) {
                    //alert(data);
                    $('#appFormModal > .modal-dialog').html(data);
                     
                },
                error: function(error) {
                    $('#appFormModal').modal('toggle');

                }
            });

        }
        
     
    </script>
    
    
@endsection