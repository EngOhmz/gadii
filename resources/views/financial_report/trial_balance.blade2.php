 @extends('layouts.master')
@section('title')
    {{trans_choice('general.trial_balance',1)}}
@endsection
@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">
                {{trans_choice('general.trial_balance',1)}}
          @if(!empty($start_date))
                    for period: <b>{{$start_date}} to {{$second_date}}</b>
                @endif
             @if(!empty($end_date))
                    for period: <b>{{$second_date}} to {{$end_date}}</b>
                @endif
          
            </h6>

            <div class="heading-elements">

            </div>
        </div>
        <div class="panel-body hidden-print">
            <h4 class="">{{trans_choice('general.date',1)}} {{trans_choice('general.range',1)}}</h4>
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">
              
             <div class="col-xs-5 col-lg-4">
                    {!! Form::text('start_date',$start_date, array('class' => 'form-control date-picker', 'placeholder'=>"First Date")) !!}
                </div>
                
                <div class="col-xs-5  col-lg-4">
                    {!! Form::text('second_date',$second_date, array('class' => 'form-control date-picker', 'placeholder'=>"Second Date" ,'required' => 'required')) !!}
                </div>
             <div class="col-xs-5  col-lg-4">
                    {!! Form::text('end_date',$end_date, array('class' => 'form-control date-picker', 'placeholder'=>"Third Date")) !!}
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">

                        <button type="submit" class="btn btn-success">{{trans_choice('general.search',1)}}
                        </button>


                        <a href="{{Request::url()}}"
                           class="btn btn-danger">{{trans_choice('general.reset',1)}}!</a>

                        <div class="btn-group">
                            <button type="button" class="btn bg-blue dropdown-toggle legitRipple"
                                    data-toggle="dropdown">{{trans_choice('general.download',1)}} {{trans_choice('general.report',1)}}
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a href="{{url('report/financial_report/trial_balance/pdf?start_date='.$start_date.'&end_date='.$end_date)}}"
                                       target="_blank"><i
                                                class="icon-file-pdf"></i> {{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.pdf',1)}}
                                    </a></li>
                                <li>
                                    <a href="{{url('report/financial_report/trial_balance/excel?start_date='.$start_date.'&end_date='.$end_date)}}"
                                       target="_blank"><i
                                                class="icon-file-excel"></i> {{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.excel',1)}}
                                    </a></li>
                                <li>
                                    <a href="{{url('report/financial_report/trial_balance/csv?start_date='.$start_date.'&end_date='.$end_date)}}"
                                       target="_blank"><i
                                                class="icon-download"></i> {{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.csv',1)}}
                                    </a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
        <!-- /.panel-body -->

    </div>
    <!-- /.box -->
 @if(!empty($start_date))
        <div class="panel panel-white col-lg-12">
            <div class="panel-body table-responsive no-padding">

                <table class="table table-bordered table-condensed table-hover">
                    <thead>
                    <tr  class="bg-green">
                         <th>{{trans_choice('general.account',2)}}</th>
                        <th>{{trans_choice('general.account_name',1)}}</th>
                        <th>{{trans_choice('general.account_codes',2)}}</th>
                       <th> PERIOD : {{$start_date}} - {{$second_date}}</th>
                        <th>{{trans_choice('general.account_balance ',2)}}</th>
                    </tr>
                    </thead>
                     <tbody>

               <?php
               $c=0;     
?>            
     
     @foreach($data as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td colspan="5" style="text-align: center"><b>{{ $c }} . {{ $account_class->class_name  }}</b></td>
                    </tr>

   <?php                              

$d=0;
?>
               
  @foreach($account_class->groupAccount  as $group)
                             <?php $d++ ; 
                      //  $values = explode(",",  $account_group->holidays);
?>
                                                      
                         <tr>
                   <td>{{ $d }} .</td>
                   ​<td>{{$group->name  }}</td>                      
                  <td colspan="2"></td>              
                   </tr>
       
@foreach($group->accountCodes as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
 <td><a href="#view{{$account_code->account_id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>
   <!-- Modal Start -->
                    <div class="modal fade" id="view{{$account_code->account_id}}" tabindex="-1" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" align ="center"> {{$account_code->account_codes }} - {{$account_code->account_name }}</h4>
                          </div>
                          <div class="modal-body">
                              <div class="table-responsive">
                            <table class="table table-bordered table-striped table-responsive">

                    <?php        
                       if($account_code->account_codes == 3105){
?>
<thead>
                    <tr class="bg-green">
                    <th>{{trans_choice('general.account_name',1)}}</th>
                        <th>{{trans_choice('general.account_codes',2)}}</th>
                          <th>{{trans_choice('general.debit',2)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                    </tr>
                    </thead>
                              <tbody>
 <tr>
                        <td colspan="4" style="text-align: left"><b>{{trans_choice('general.income',1)}}</b></td>
                    </tr>
  <?php   
$total_incomes_start   = 0;
$total_other_incomes_start   = 0;
$cost_balance_start   = 0;
$total_cost_start   = 0;
$expense_balance_start   = 0;
$total_expense_start   = 0;
$gross_start   = 0;
$profit_start =0;
$tax_start =0;
$net_profit_start =0;
$total_debit_income_balance_start  =0 ;
 $total_credit_income_balance_start   =0 ;
  $total_debit_other_income_balance_start    =0 ;
  $total_credit_other_income_balance_start   =0 ;
   $total_debit_cost_balance_start    =0 ;
   $total_credit_cost_balance_start   =0 ;
   $total_debit_expense_balance_start    =0 ;
   $total_credit_expense_balance_start   =0 ;
$gross_dr_start   = 0;
$gross_cr_start   = 0;
$tax_dr_start =0;
$tax_cr_start =0;
$profit_dr_start =0;
$profit_cr_start =0;   
$net_profit_dr_start =0;
$net_profit_cr_start =0;   

  $income =  \App\Models\ClassAccount::where('class_type','Income')->get();
           $cost = \App\Models\ ClassAccount::where('class_type','Expense')->get();
           $expense=  \App\Models\ClassAccount::where('class_type','Expense')->get();
           
           
foreach($income as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal) {  
if($group_modal->group_id != 5110){
foreach($group_modal->accountCodes as $account_code_modal){
     
     
                         $cr_start = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                         $total_debit_income_balance_start  +=$dr_start  ;
                         $total_credit_income_balance_start  +=$cr_start ;

                          $income_balance_start =$dr_start - $cr_start ;
                          $total_incomes_start +=$income_balance_start  ;
                          ?>
<tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format($dr_start ,2) }}</td>
      <td>{{ number_format($cr_start ,2) }}</td>
</tr>                
  <?php  

    }}}}           
?>

<tr>
                        <td >
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.income',2)}}</b></td>
                       <td></td>
                            <td>{{ number_format($total_debit_income_balance_start ,2) }}</td>                           
                           <td>{{ number_format($total_credit_income_balance_start ,2) }}</td>
                    </tr> 

  <tr>
                        <td colspan="4" style="text-align: left"><b>{{trans_choice('general.other_income',1)}}</b></td>
                    </tr>
  <?php  
foreach($income as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal) {  
if($group_modal->group_id == 5110){
foreach($group_modal->accountCodes as $account_code_modal){
   
                    $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                   
                        $total_debit_other_income_balance_start +=$dr_start  ;
                         $total_credit_other_income_balance_start   +=$cr_start ;

                       $income_balance_start =$dr_start - $cr_start ;
                          $total_other_incomes_start +=$income_balance_start  ;

  ?>
<tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format($dr_start ,2) }}</td>
      <td>{{ number_format($cr_start ,2) }}</td>
     </tr>           
  <?php  

  
}}}} 

?>

<tr>
                        <td >
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.other_income',2)}}</b></td>
                       <td></td>
                             <td>{{ number_format($total_debit_other_income_balance_start ,2) }}</td>
      <td>{{ number_format($total_credit_other_income_balance_start ,2) }}</td>
                    </tr> 
 <tr>
                        <td colspan="4" style="text-align: left"><b>{{trans_choice('general.financial_cost',1)}}</b></td>
                    </tr>
  <?php  
foreach($cost as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal) {
if($group->group_id == 6180){
foreach($group_modal->accountCodes as $account_code_modal){


                   $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            
                        $total_debit_cost_balance_start    +=$dr_start  ;
                         $total_credit_cost_balance_start   +=$cr_start ;

                        $cost_balance_start =$dr_start - $cr_start ;
                        $total_cost_start +=$cost_balance_start  ;

  ?>
<tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format($dr_start ,2) }}</td>
      <td>{{ number_format($cr_start ,2) }}</td>
</tr>                
  <?php  

                            
}}}}
?>

<tr>
                        <td >
                             <b>{{trans_choice('general.total',1)}} {{trans_choice('general.financial_cost',2)}}</b></td>
                       <td></td>
                              <td>{{ number_format($total_debit_cost_balance_start ,2) }}</td>
      <td>{{ number_format($total_credit_cost_balance_start,2) }}</td>
                    </tr> 

  <?php  
 if($total_debit_income_balance_start   < 0){
$total_s=$total_debit_income_balance_start   * -1;
$gross_dr_start =$total_s+$total_debit_other_income_balance_start -$total_debit_cost_balance_start ;
}
else if($total_debit_income_balance_start  >= 0){
$gross_dr_start =$total_debit_income_balance_start +$total_debit_other_income_balance_start -$total_debit_cost_balance_start ;
}

 if($total_credit_income_balance_start   < 0){
$total_s_cr=$total_credit_income_balance_start   * -1;
$gross_cr_start =$total_s_cr+$total_credit_other_income_balance_start -$total_credit_cost_balance_start ;
}
else if($total_credit_income_balance_start  >= 0){
$gross_cr_start =$total_credit_income_balance_start  + $total_credit_other_income_balance_start -$total_credit_cost_balance_start ;
}

?>

  <tr>
                        <td >
                            <b>{{trans_choice('general.gross',2)}}</b></td>
                    <td></td>
                            <td><b>{{ number_format($gross_dr_start ,2) }}</b></td>
                <td><b>{{ number_format($gross_cr_start ,2) }}</b></td>
                    </tr> 

<tr>
                        <td colspan="4" style="text-align: left"><b>{{trans_choice('general.expense',2)}}</b></td>
                    </tr>
  <?php  
foreach($expense as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal)  {      
if($group->group_id != 6180){
foreach($group_modal->accountCodes as $account_code_modal){

                   $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            
                           $total_debit_expense_balance_start    +=$dr_start  ;
                         $total_credit_expense_balance_start   +=$cr_start ;

                $expense_balance_start =$dr_start - $cr_start ;
                $total_expense_start +=$expense_balance_start  ;
                          
  ?>
  <tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format($dr_start ,2) }}</td>
      <td>{{ number_format($cr_start ,2) }}</td>
       </tr>             
  <?php  

}}}}

?>

<tr>
                        <td >
                             <b>{{trans_choice('general.total',1)}} {{trans_choice('general.expense',2)}}</b></td>
                       <td></td>
                               <td>{{ number_format($total_debit_expense_balance_start ,2) }}</td>
                                  <td>{{ number_format($total_credit_expense_balance_start ,2) }}</td>
                    </tr> 

  <?php  

if($gross_dr_start  < 0){
$profit_dr_start =$gross_dr_start + $total_debit_expense_balance_start ;
}
else if($gross_dr_start  < 0 &&  $total_debit_expense_balance_start   < 0){
$profit_dr_start =$gross_dr_start + $total_debit_expense_balance_start ;
}
else if($gross_dr_start  >= 0 &&  $total_debit_expense_balance_start   < 0){
$profit_dr_start = $total_debit_expense_balance_start  +$gross_dr_start ;
}
else{
$profit_dr_start =$gross_dr_start -$total_debit_expense_balance_start ;
}


if($gross_cr_start  < 0){
$profit_cr_start =$gross_cr_start + $total_credit_expense_balance_start ;
}
else if($gross_cr_start  < 0 &&  $total_credit_expense_balance_start   < 0){
$profit_cr_start =$gross_cr_start + $total_credit_expense_balance_start ;
}
else if($gross_cr_start >= 0 &&  $total_credit_expense_balance_start  < 0){
$profit_cr_start = $total_credit_expense_balance_start   +$gross_cr_start ;
}
else{
$profit_cr_start =$gross_cr_start -$total_credit_expense_balance_start ;
}
  
if($profit_dr_start - $profit_cr_start  > 0){
$tax_dr_start =$profit_dr_start *0.3;
$tax_cr_start =$profit_cr_start *0.3;
}
$net_dr_start =$profit_dr_start -$tax_dr_start ;
$net_cr_start =$profit_cr_start -$tax_cr_start ;

if($net_dr_start  < 0){
$net_pt_start =$net_dr_start +$net_cr_start ;
}
else{
$net_pt_start =$net_dr_start -$net_cr_start ;
}
?>

<tr>
                        <td>
                           <b>{{trans_choice('general.income_profit',2)}}</b></td>
                            <td></td>
                                 <td><b>{{ number_format($profit_dr_start ,2) }}</b></td>
                         <td ><b>{{ number_format($profit_cr_start ,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>{{trans_choice('general.tax',1)}}</b></td>
                         <td></td>
                              <td><b>{{ number_format($tax_dr_start ,2) }}</b></td>
                        <td colspan="5" style="text-align: right"><b>{{ number_format($tax_cr_start,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                           <b>{{trans_choice('general.total',1)}} </b></td>
<td></td>
                        <td><b>{{ number_format($net_dr_start ,2) }}</b></td>
                        <td><b>{{ number_format($net_cr_start ,2) }}</b></td>
                    </tr>

 <tr>
                        <td colspan="2">
                           <b>{{$account_code->account_name }} {{trans_choice('general.total',1)}} {{trans_choice('general.balance',1)}}</b></td>
                              @if ($net_pt_start> 0)
                               <td colspan="2"><b>{{ number_format($net_pt_start ,2) }} Dr </b></td>
                           @elseif ($net_pt_start == 0)
                               <td colspan="2"><b>{{ number_format($net_pt_start ,2) }}  </b></td>
                           @else
                               <td colspan="2"><b>{{number_format(abs($net_pt_start),2)}} Cr </b></td>
                           @endif 

                      
                    </tr>

  <?php  
}

else{   
  ?>
<thead>
                    <tr class="bg-green">
                       <th>{{trans_choice('general.date',1)}}</th>
                          <th>{{trans_choice('general.debit',2)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                    </tr>
                    </thead>
                              <tbody>   
 <?php
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->orderBy('date','asc')->get();
                        ?>  
                 @foreach($account  as $a)
                                 <tr>
                        <td >{{$a->date }}</td>
                          <td>{{ number_format($a->debit ,2) }}</td>
                   <td >{{ number_format($a->credit ,2) }}</td>
                    </tr> 

  @endforeach
    
 <?php
                   
                        $cr_modal = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_modal = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                            <b>{{trans_choice('general.total',1)}}</b></td>
                           <td><b>{{ number_format($dr_modal,2) }}</b></td>
                            <td><b>{{ number_format($cr_modal,2) }}</b></td>
                    </tr> 
  <tr>
                        <td >
                              <b>{{$account_code->account_name }} {{trans_choice('general.total',1)}} {{trans_choice('general.balance',1)}}</b></td>
                                   @if ($dr_modal-$cr_modal > 0)
                               <td colspan="2"><b>{{ number_format($dr_modal-$cr_modal ,2) }} Dr </b></td>
                           @elseif ($dr_modal-$cr_modal == 0)
                               <td colspan="2"><b>{{ number_format($dr_modal-$cr_modal ,2) }}  </b></td>
                           @else
                               <td colspan="2"><b>{{number_format(abs($dr_modal-$cr_modal),2)}} Cr </b></td>
                           @endif 

                    </tr> 
<?php
}
?>
                              </tbody>
                            </table>
                           </div>
                          </div>
                          <div class="modal-footer"></div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
</td>
<?php
                        $cr1 = 0;
                        $dr1 = 0;
                        $balance1=0;                    
                        $cr = 0;
                        $dr = 0;
                        $balance=0;

                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit'); 

                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');              
      
                         if($account_code->account_codes == 3105){
                          $balance = $net_profit['profit_for_first_date'];
                             $balance1 = $net_p['net_profit_dr'];

                         }else{
                         $balance =  $dr-$cr;
                            $balance1 =  $dr1-$cr1;
                         } 
                        ?>
                          @if ($balance > 0)
                           <td>{{ number_format($balance ,2) }} Dr </td>
                           @elseif ($balance == 0)
                           <td>{{ number_format($balance ,2) }}  </td>
                           @else
                           <td>{{number_format(abs($balance),2)}} Cr </td> 
                           @endif 

                              @if ($balance1 > 0)
                           <td>{{ number_format($balance1 ,2) }} Dr </td>
                           @elseif ($balance1 == 0)
                           <td>{{ number_format($balance1 ,2) }}  </td>
                           @else
                           <td>{{number_format(abs($balance1),2)}} Cr </td> 
                           @endif 
                        
</tr>
   @endforeach              
  @endforeach
  @endforeach
 
                    </tbody>
                </table>
            </div>
        </div>
    @endif


@if(!empty($end_date))
        <div class="panel panel-white col-lg-12">
            <div class="panel-body table-responsive no-padding">

                <table class="table table-bordered table-condensed table-hover">
                    <thead>
                    <tr  class="bg-green">
                         <th>{{trans_choice('general.account',2)}}</th>
                        <th>{{trans_choice('general.account_name',1)}}</th>
                        <th>{{trans_choice('general.account_codes',2)}}</th>
                        <th>{{trans_choice('general.account_balance ',2)}}</th>
                           <th> PERIOD : {{$second_date}} - {{$end_date}}</th>
                    </tr>
                    </thead>
                     <tbody>

               <?php
               $c=0;     
?>            
     
     @foreach($data as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td colspan="5" style="text-align: center"><b>{{ $c }} . {{ $account_class->class_name  }}</b></td>
                    </tr>

   <?php                              

$d=0;
?>
               
  @foreach($account_class->groupAccount  as $group)
                             <?php $d++ ; 
                      //  $values = explode(",",  $account_group->holidays);
?>
                                                      
                         <tr>
                   <td>{{ $d }} .</td>
                   ​<td>{{$group->name  }}</td>                      
                  <td colspan="2"></td>              
                   </tr>
       
@foreach($group->accountCodes as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
 <td><a href="#view{{$account_code->account_id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>
   <!-- Modal Start -->
                    <div class="modal fade" id="view{{$account_code->account_id}}" tabindex="-1" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" align ="center"> {{$account_code->account_codes }} - {{$account_code->account_name }}</h4>
                          </div>
                          <div class="modal-body">
                              <div class="table-responsive">
                            <table class="table table-bordered table-striped table-responsive">

                    <?php        
                       if($account_code->account_codes == 3105){
?>
<thead>
                    <tr class="bg-green">
                    <th>{{trans_choice('general.account_name',1)}}</th>
                        <th>{{trans_choice('general.account_codes',2)}}</th>
                          <th>{{trans_choice('general.debit',2)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                    </tr>
                    </thead>
                              <tbody>
 <tr>
                        <td colspan="4" style="text-align: left"><b>{{trans_choice('general.income',1)}}</b></td>
                    </tr>
  <?php   
$total_incomes_start   = 0;
$total_other_incomes_start   = 0;
$cost_balance_start   = 0;
$total_cost_start   = 0;
$expense_balance_start   = 0;
$total_expense_start   = 0;
$gross_start   = 0;
$profit_start =0;
$tax_start =0;
$net_profit_start =0;
$total_debit_income_balance_start  =0 ;
 $total_credit_income_balance_start   =0 ;
  $total_debit_other_income_balance_start    =0 ;
  $total_credit_other_income_balance_start   =0 ;
   $total_debit_cost_balance_start    =0 ;
   $total_credit_cost_balance_start   =0 ;
   $total_debit_expense_balance_start    =0 ;
   $total_credit_expense_balance_start   =0 ;
$gross_dr_start   = 0;
$gross_cr_start   = 0;
$tax_dr_start =0;
$tax_cr_start =0;
$profit_dr_start =0;
$profit_cr_start =0;   
$net_profit_dr_start =0;
$net_profit_cr_start =0;   

  $income =  \App\Models\ClassAccount::where('class_type','Income')->get();
           $cost = \App\Models\ ClassAccount::where('class_type','Expense')->get();
           $expense=  \App\Models\ClassAccount::where('class_type','Expense')->get();
           
           
foreach($income as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal) {  
if($group_modal->group_id != 5110){
foreach($group_modal->accountCodes as $account_code_modal){
     
     
                         $cr_start = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                         $total_debit_income_balance_start  +=$dr_start  ;
                         $total_credit_income_balance_start  +=$cr_start ;

                          $income_balance_start =$dr_start - $cr_start ;
                          $total_incomes_start +=$income_balance_start  ;
                          ?>
<tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format($dr_start ,2) }}</td>
      <td>{{ number_format($cr_start ,2) }}</td>
</tr>                
  <?php  

    }}}}           
?>

<tr>
                        <td >
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.income',2)}}</b></td>
                       <td></td>
                            <td>{{ number_format($total_debit_income_balance_start ,2) }}</td>                           
                           <td>{{ number_format($total_credit_income_balance_start ,2) }}</td>
                    </tr> 

  <tr>
                        <td colspan="4" style="text-align: left"><b>{{trans_choice('general.other_income',1)}}</b></td>
                    </tr>
  <?php  
foreach($income as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal) {  
if($group_modal->group_id == 5110){
foreach($group_modal->accountCodes as $account_code_modal){
   
                    $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                   
                        $total_debit_other_income_balance_start +=$dr_start  ;
                         $total_credit_other_income_balance_start   +=$cr_start ;

                       $income_balance_start =$dr_start - $cr_start ;
                          $total_other_incomes_start +=$income_balance_start  ;

  ?>
<tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format($dr_start ,2) }}</td>
      <td>{{ number_format($cr_start ,2) }}</td>
     </tr>           
  <?php  

  
}}}} 

?>

<tr>
                        <td >
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.other_income',2)}}</b></td>
                       <td></td>
                             <td>{{ number_format($total_debit_other_income_balance_start ,2) }}</td>
      <td>{{ number_format($total_credit_other_income_balance_start ,2) }}</td>
                    </tr> 
 <tr>
                        <td colspan="4" style="text-align: left"><b>{{trans_choice('general.financial_cost',1)}}</b></td>
                    </tr>
  <?php  
foreach($cost as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal) {
if($group->group_id == 6180){
foreach($group_modal->accountCodes as $account_code_modal){


                   $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            
                        $total_debit_cost_balance_start    +=$dr_start  ;
                         $total_credit_cost_balance_start   +=$cr_start ;

                        $cost_balance_start =$dr_start - $cr_start ;
                        $total_cost_start +=$cost_balance_start  ;

  ?>
<tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format($dr_start ,2) }}</td>
      <td>{{ number_format($cr_start ,2) }}</td>
</tr>                
  <?php  

                            
}}}}
?>

<tr>
                        <td >
                             <b>{{trans_choice('general.total',1)}} {{trans_choice('general.financial_cost',2)}}</b></td>
                       <td></td>
                              <td>{{ number_format($total_debit_cost_balance_start ,2) }}</td>
      <td>{{ number_format($total_credit_cost_balance_start,2) }}</td>
                    </tr> 

  <?php  
 if($total_debit_income_balance_start   < 0){
$total_s=$total_debit_income_balance_start   * -1;
$gross_dr_start =$total_s+$total_debit_other_income_balance_start -$total_debit_cost_balance_start ;
}
else if($total_debit_income_balance_start  >= 0){
$gross_dr_start =$total_debit_income_balance_start +$total_debit_other_income_balance_start -$total_debit_cost_balance_start ;
}

 if($total_credit_income_balance_start   < 0){
$total_s_cr=$total_credit_income_balance_start   * -1;
$gross_cr_start =$total_s_cr+$total_credit_other_income_balance_start -$total_credit_cost_balance_start ;
}
else if($total_credit_income_balance_start  >= 0){
$gross_cr_start =$total_credit_income_balance_start  + $total_credit_other_income_balance_start -$total_credit_cost_balance_start ;
}

?>

  <tr>
                        <td >
                            <b>{{trans_choice('general.gross',2)}}</b></td>
                    <td></td>
                            <td><b>{{ number_format($gross_dr_start ,2) }}</b></td>
                <td><b>{{ number_format($gross_cr_start ,2) }}</b></td>
                    </tr> 

<tr>
                        <td colspan="4" style="text-align: left"><b>{{trans_choice('general.expense',2)}}</b></td>
                    </tr>
  <?php  
foreach($expense as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal)  {      
if($group->group_id != 6180){
foreach($group_modal->accountCodes as $account_code_modal){

                   $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            
                           $total_debit_expense_balance_start    +=$dr_start  ;
                         $total_credit_expense_balance_start   +=$cr_start ;

                $expense_balance_start =$dr_start - $cr_start ;
                $total_expense_start +=$expense_balance_start  ;
                          
  ?>
  <tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format($dr_start ,2) }}</td>
      <td>{{ number_format($cr_start ,2) }}</td>
       </tr>             
  <?php  

}}}}

?>

<tr>
                        <td >
                             <b>{{trans_choice('general.total',1)}} {{trans_choice('general.expense',2)}}</b></td>
                       <td></td>
                               <td>{{ number_format($total_debit_expense_balance_start ,2) }}</td>
                                  <td>{{ number_format($total_credit_expense_balance_start ,2) }}</td>
                    </tr> 

  <?php  

if($gross_dr_start  < 0){
$profit_dr_start =$gross_dr_start + $total_debit_expense_balance_start ;
}
else if($gross_dr_start  < 0 &&  $total_debit_expense_balance_start   < 0){
$profit_dr_start =$gross_dr_start + $total_debit_expense_balance_start ;
}
else if($gross_dr_start  >= 0 &&  $total_debit_expense_balance_start   < 0){
$profit_dr_start = $total_debit_expense_balance_start  +$gross_dr_start ;
}
else{
$profit_dr_start =$gross_dr_start -$total_debit_expense_balance_start ;
}


if($gross_cr_start  < 0){
$profit_cr_start =$gross_cr_start + $total_credit_expense_balance_start ;
}
else if($gross_cr_start  < 0 &&  $total_credit_expense_balance_start   < 0){
$profit_cr_start =$gross_cr_start + $total_credit_expense_balance_start ;
}
else if($gross_cr_start >= 0 &&  $total_credit_expense_balance_start  < 0){
$profit_cr_start = $total_credit_expense_balance_start   +$gross_cr_start ;
}
else{
$profit_cr_start =$gross_cr_start -$total_credit_expense_balance_start ;
}
  
if($profit_dr_start - $profit_cr_start  > 0){
$tax_dr_start =$profit_dr_start *0.3;
$tax_cr_start =$profit_cr_start *0.3;
}
$net_dr_start =$profit_dr_start -$tax_dr_start ;
$net_cr_start =$profit_cr_start -$tax_cr_start ;

if($net_dr_start  < 0){
$net_pt_start =$net_dr_start +$net_cr_start ;
}
else{
$net_pt_start =$net_dr_start -$net_cr_start ;
}
?>

<tr>
                        <td>
                           <b>{{trans_choice('general.income_profit',2)}}</b></td>
                            <td></td>
                                 <td><b>{{ number_format($profit_dr_start ,2) }}</b></td>
                         <td ><b>{{ number_format($profit_cr_start ,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>{{trans_choice('general.tax',1)}}</b></td>
                         <td></td>
                              <td><b>{{ number_format($tax_dr_start ,2) }}</b></td>
                        <td colspan="5" style="text-align: right"><b>{{ number_format($tax_cr_start,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                           <b>{{trans_choice('general.total',1)}} </b></td>
<td></td>
                        <td><b>{{ number_format($net_dr_start ,2) }}</b></td>
                        <td><b>{{ number_format($net_cr_start ,2) }}</b></td>
                    </tr>

 <tr>
                        <td colspan="2">
                           <b>{{$account_code->account_name }} {{trans_choice('general.total',1)}} {{trans_choice('general.balance',1)}}</b></td>
                              @if ($net_pt_start> 0)
                               <td colspan="2"><b>{{ number_format($net_pt_start ,2) }} Dr </b></td>
                           @elseif ($net_pt_start == 0)
                               <td colspan="2"><b>{{ number_format($net_pt_start ,2) }}  </b></td>
                           @else
                               <td colspan="2"><b>{{number_format(abs($net_pt_start),2)}} Cr </b></td>
                           @endif 

                      
                    </tr>

  <?php  
}

else{   
  ?>
<thead>
                    <tr class="bg-green">
                       <th>{{trans_choice('general.date',1)}}</th>
                          <th>{{trans_choice('general.debit',2)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                    </tr>
                    </thead>
                              <tbody>   
 <?php
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->orderBy('date','asc')->get();
                        ?>  
                 @foreach($account  as $a)
                                 <tr>
                        <td >{{$a->date }}</td>
                          <td>{{ number_format($a->debit ,2) }}</td>
                   <td >{{ number_format($a->credit ,2) }}</td>
                    </tr> 

  @endforeach
    
 <?php
                   
                        $cr_modal = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_modal = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                            <b>{{trans_choice('general.total',1)}}</b></td>
                           <td><b>{{ number_format($dr_modal,2) }}</b></td>
                            <td><b>{{ number_format($cr_modal,2) }}</b></td>
                    </tr> 
  <tr>
                        <td >
                              <b>{{$account_code->account_name }} {{trans_choice('general.total',1)}} {{trans_choice('general.balance',1)}}</b></td>
                                   @if ($dr_modal-$cr_modal > 0)
                               <td colspan="2"><b>{{ number_format($dr_modal-$cr_modal ,2) }} Dr </b></td>
                           @elseif ($dr_modal-$cr_modal == 0)
                               <td colspan="2"><b>{{ number_format($dr_modal-$cr_modal ,2) }}  </b></td>
                           @else
                               <td colspan="2"><b>{{number_format(abs($dr_modal-$cr_modal),2)}} Cr </b></td>
                           @endif 

                    </tr> 
<?php
}
?>
                              </tbody>
                            </table>
                           </div>
                          </div>
                          <div class="modal-footer"></div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
</td>
<?php
                        $cr1 = 0;
                        $dr1 = 0;
                        $balance1=0;                    
                        $cr = 0;
                        $dr = 0;
                        $balance=0;

                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit'); 

                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');              
      
                         if($account_code->account_codes == 3105){
                      $balance = $net_profit['profit_for_second_date'];
                             $balance1 = $net_p['net_profit_dr'];

                         }else{
                         $balance =  $dr-$cr;
                            $balance1 =  $dr1-$cr1;
                         } 
                        ?>
                        
                              @if ($balance1 > 0)
                           <td>{{ number_format($balance1 ,2) }} Dr </td>
                           @elseif ($balance1 == 0)
                           <td>{{ number_format($balance1 ,2) }}  </td>
                           @else
                           <td>{{number_format(abs($balance1),2)}} Cr </td> 
                           @endif 

                        @if ($balance > 0)
                           <td>{{ number_format($balance ,2) }} Dr </td>
                           @elseif ($balance == 0)
                           <td>{{ number_format($balance ,2) }}  </td>
                           @else
                           <td>{{number_format(abs($balance),2)}} Cr </td> 
                           @endif 
                        
</tr>
   @endforeach              
  @endforeach
  @endforeach

 </tbody>
                </table>
            </div>
        </div>
@endif
 
@endsection
@section('footer-scripts')

@endsection
