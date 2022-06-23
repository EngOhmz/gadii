@extends('layouts.master')
@section('title')
    {{trans_choice('general.income',1)}} {{trans_choice('general.statement',1)}}
@endsection
@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">
                {{trans_choice('general.income',1)}} {{trans_choice('general.statement',1)}}
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
                    {!! Form::text('end_date',$end_date, array('class' => 'form-control date-picker', 'placeholder'=>"First Date")) !!}
                </div>
                
                <div class="col-xs-5  col-lg-4">
                    {!! Form::text('second_date',$second_date, array('class' => 'form-control date-picker', 'placeholder'=>"Second Date" ,'required' => 'required')) !!}
                </div>
             <div class="col-xs-5  col-lg-4">
                    {!! Form::text('start_date',$start_date, array('class' => 'form-control date-picker', 'placeholder'=>"Third Date")) !!}
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">

                        <button type="submit" class="btn btn-success">{{trans_choice('general.search',1)}}!
                        </button>


                        <a href="{{Request::url()}}"
                           class="btn btn-danger">{{trans_choice('general.reset',1)}}!</a>

                        <div class="btn-group">
                            <button type="button" class="btn bg-blue dropdown-toggle legitRipple"
                                    data-toggle="dropdown">{{trans_choice('general.download',1)}} {{trans_choice('general.report',1)}}
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a href="{{url('report/financial_report/income_statement/pdf?date='.$second_date)}}"
                                       target="_blank"><i
                                                class="icon-file-pdf"></i> {{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.pdf',1)}}
                                    </a></li>
                                <li>
                                    <a href="{{url('report/financial_report/income_statement/excel?start_date='.$start_date.'&end_date='.$end_date)}}"
                                       target="_blank"><i
                                                class="icon-file-excel"></i> {{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.excel',1)}}
                                    </a></li>
                                <li>
                                    <a href="{{url('report/financial_report/income_statement/csv?start_date='.$start_date.'&end_date='.$end_date)}}"
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
        <div class="panel panel-white col-lg-6">
            <div class="panel-body table-responsive no-padding">

                <table class="table table-bordered table-condensed table-hover">
                    <thead>
                    <tr class="bg-green">
                        <th>{{trans_choice('general.account',1)}}</th>
                          <th>{{trans_choice('general.account_codes',2)}}</th>
                        <th>{{trans_choice('general.balance',1)}}</th>
                    </tr>
                    </thead>
                      <tbody>
                    <tr>
                        <td colspan="3" style="text-align: left"><b>{{trans_choice('general.sale',1)}}</b></td>
                    </tr>
                                 <?php
                     $c=0;     
                    $sales_balance  = 0;
                    $total_sales  = 0;
                    $cost_balance  = 0;
                    $total_cost  = 0;
                    $expense_balance  = 0;
                    $total_expense  = 0;
                    $gross  = 0;
                   $profit=0;
                  $tax=0;
                $net_profit=0;
?>            
     
     @foreach($sales as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>
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
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                            <b>{{trans_choice('general.total',1)}}</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
                    </tr> 
  <tr>
                        <td >
                          <b>{{$account_code->account_name }} {{trans_choice('general.total',1)}} {{trans_choice('general.balance',1)}}</b></td>
                           <td colspan="2"><b>{{ number_format($dr-$cr,2) }}</b></td>

                    </tr> 
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
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                               [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $sales_balance=$dr- $cr;
                          $total_sales+=$sales_balance ;
                        ?>                           
                             <td>{{ number_format(abs($sales_balance),2) }}</td>

                        </tr>
                                                                
 @endforeach              
  @endforeach
  @endforeach
 
           <tr>
                        <td >
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.sale',2)}}</b></td>
                           <td colspan="2" style="text-align: right"><b>{{ number_format(abs($total_sales),2) }}</b></td>
                    </tr> 

 <tr>
                        <td colspan="3" style="text-align: left"><b>{{trans_choice('general.cogs',1)}}</b></td>
                    </tr>
  @foreach($cost as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>
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
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                            <b>{{trans_choice('general.total',1)}}</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
                    </tr> 
  <tr>
                        <td >
                               <b>{{$account_code->account_name }} {{trans_choice('general.total',1)}} {{trans_choice('general.balance',1)}}</b></td>
                           <td colspan="2"><b>{{ number_format($dr-$cr,2) }}</b></td>

                    </tr> 
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
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date,$second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $cost_balance=$dr- $cr;
                          $total_cost+=$cost_balance ;
                        ?>                           
                             <td>{{ number_format(abs($cost_balance),2) }}</td>

                        </tr>
                                                                
 @endforeach              
  @endforeach
  @endforeach

   
           <tr>
                        <td >
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.cogs',2)}}</b></td>
                          <td colspan="2" style="text-align: right"><b>{{ number_format(abs($total_cost),2) }}</b></td>
                    </tr> 
      <tr>
                        <td >
                            <b>{{trans_choice('general.gross',2)}}</b></td>

                     
                       <?php
if($total_sales < 0){
$total_s=$total_sales * -1;
$gross=$total_s-$total_cost;
}
else if($total_sales > 0){
$gross=$total_sales-$total_cost;
}
?>
                     
                 <td colspan="2" style="text-align: right"><b>{{ number_format($gross,2) }}</b></td>
                    </tr> 
                    <tr>
                        <td colspan="3" style="text-align: left"><b>{{trans_choice('general.expense',2)}}</b></td>
                    </tr>

                  @foreach($expense as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>
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
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                            <b>{{trans_choice('general.total',1)}}</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
                    </tr> 
  <tr>
                        <td >
                            <b>{{$account_code->account_name }} {{trans_choice('general.total',1)}} {{trans_choice('general.balance',1)}}</b></td>
                           <td colspan="2"><b>{{ number_format($dr-$cr,2) }}</b></td>

                    </tr> 
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
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $expense_balance=$dr- $cr;
                          $total_expense+=$expense_balance ;
                        ?>                           
                             <td>{{ number_format(abs($expense_balance),2) }}</td>

                        </tr>
                                                               
 @endforeach              
  @endforeach
  @endforeach

   
           <tr>
                        <td >
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.expense',2)}}</b></td>
                           <td colspan="2" style="text-align: right"><b>{{ number_format($total_expense,2) }}</b></td>
                    </tr> 
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>
                            <b>{{trans_choice('general.income_profit',2)}}</b></td>
                        <?php

if($gross < 0){
$profit=$gross+$total_expense;
}
else if($gross < 0 && $total_expense < 0){
$profit=$gross+$total_expense;
}
else{
$profit=$gross-$total_expense;
}
?>
                         <td colspan="2" style="text-align: right"><b>{{ number_format($profit,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>{{trans_choice('general.tax',1)}}</b></td>
                               <?php
if($profit > 0){
$tax=$profit*0.3;
}
?>
                        <td colspan="2" style="text-align: right"><b>{{ number_format($tax,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b> {{trans_choice('general.income_profit',1)}}</b></td>
                        <td colspan="2" style="text-align: right"><b>{{ number_format($profit-$tax,2) }}</b></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

       @else
   <div class="panel panel-white col-lg-6">
            <div class="panel-body table-responsive no-padding">

                <table class="table table-bordered table-condensed table-hover ">
                    <thead>
                    <tr class="bg-green">
                       <th>{{trans_choice('general.account',1)}}</th>
                          <th>{{trans_choice('general.account_codes',2)}}</th>
                        <th>{{trans_choice('general.balance',1)}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="3" style="text-align: left"><b>{{trans_choice('general.sale',1)}}</b></td>
                    </tr>
                                 <?php
                     $c=0;     
                    $sales_balance  = 0;
                    $total_sales  = 0;
                    $cost_balance  = 0;
                    $total_cost  = 0;
                    $expense_balance  = 0;
                    $total_expense  = 0;
                    $gross  = 0;
                   $profit=0;
                  $tax=0;
                $net_profit=0;
?>            
     
     @foreach($sales as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>
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
<thead>
                    <tr class="bg-green">
                       <th>{{trans_choice('general.date',1)}}</th>
                          <th>{{trans_choice('general.debit',2)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                    </tr>
                    </thead>
                              <tbody>
                    <?php                   
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
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
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                            <b>{{trans_choice('general.total',1)}}</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
                    </tr> 
  <tr>
                        <td >
                              <b>{{$account_code->account_name }} {{trans_choice('general.total',1)}} {{trans_choice('general.balance',1)}}</b></td>
                           <td colspan="2"><b>{{ number_format($dr-$cr,2) }}</b></td>

                    </tr> 
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
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $sales_balance=$dr- $cr;
                          $total_sales+=$sales_balance ;
                        ?>                           
                             <td>{{ number_format(abs($sales_balance),2) }}</td>

                        </tr>
                                                                
 @endforeach              
  @endforeach
  @endforeach
 
           <tr>
                        <td >
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.sale',2)}}</b></td>
                        <td colspan="2" style="text-align: right"><b>{{ number_format(abs($total_sales),2) }}</b></td>
                    </tr> 

 <tr>
                        <td colspan="3" style="text-align: left"><b>{{trans_choice('general.cogs',1)}}</b></td>
                    </tr>
  @foreach($cost as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>
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
<thead>
                    <tr class="bg-green">
                       <th>{{trans_choice('general.date',1)}}</th>
                          <th>{{trans_choice('general.debit',2)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                    </tr>
                    </thead>
                              <tbody>
                    <?php                   
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
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
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                            <b>{{trans_choice('general.total',1)}}</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
                    </tr> 
  <tr>
                        <td >
                             <b>{{$account_code->account_name }} {{trans_choice('general.total',1)}} {{trans_choice('general.balance',1)}}</b></td>
                           <td colspan="2"><b>{{ number_format($dr-$cr,2) }}</b></td>

                    </tr> 
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
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $cost_balance=$dr- $cr;
                          $total_cost+=$cost_balance ;
                        ?>                           
                             <td>{{ number_format(abs($cost_balance),2) }}</td>

                        </tr>
                                                                
 @endforeach              
  @endforeach
  @endforeach

   
           <tr>
                        <td >
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.cogs',2)}}</b></td>
                          <td colspan="2" style="text-align: right"><b>{{ number_format(abs($total_cost),2) }}</b></td>
                    </tr> 
      <tr>
                        <td >
                            <b>{{trans_choice('general.gross',2)}}</b></td>

                     
                       <?php
if($total_sales < 0){
$total_s=$total_sales * -1;
$gross=$total_s-$total_cost;
}
else if($total_sales > 0){
$gross=$total_sales-$total_cost;
}
?>
                     
                 <td colspan="2" style="text-align: right"><b>{{ number_format($gross,2) }}</b></td>
                    </tr> 
                    <tr>
                        <td colspan="3" style="text-align: left"><b>{{trans_choice('general.expense',2)}}</b></td>
                    </tr>

                  @foreach($expense as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>
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
<thead>
                    <tr class="bg-green">
                       <th>{{trans_choice('general.date',1)}}</th>
                          <th>{{trans_choice('general.debit',2)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                    </tr>
                    </thead>
                              <tbody>
                    <?php                   
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
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
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                            <b>{{trans_choice('general.total',1)}}</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
                    </tr> 
  <tr>
                        <td >
                            <b>{{$account_code->account_name }} {{trans_choice('general.total',1)}} {{trans_choice('general.balance',1)}}</b></td>
                           <td colspan="2"><b>{{ number_format($dr-$cr,2) }}</b></td>

                    </tr> 
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
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $expense_balance=$dr- $cr;
                          $total_expense+=$expense_balance ;
                        ?>                           
                             <td>{{ number_format(abs($expense_balance),2) }}   </td>                
                        </tr>
                                                               
 @endforeach              
  @endforeach
  @endforeach

   
           <tr>
                        <td >
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.expense',2)}}</b></td>
                           <td colspan="2" style="text-align: right"><b>{{ number_format($total_expense,2) }}</b></td>
                    </tr> 
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>
                            <b>{{trans_choice('general.income_profit',2)}}</b></td>
                        <?php

if($gross < 0){
$profit=$gross+$total_expense;
}
else if($gross < 0 && $total_expense < 0){
$profit=$gross+$total_expense;
}
else{
$profit=$gross-$total_expense;
}
?>
                
                        <td colspan="2" style="text-align: right"><b>{{ number_format($profit,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>{{trans_choice('general.tax',1)}}</b></td>
                               <?php
if($profit > 0){
$tax=$profit*0.3;
}
?>
                        <td colspan="2" style="text-align: right"><b>{{ number_format($tax,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b> {{trans_choice('general.income_profit',1)}}</b></td>
                      <td colspan="2" style="text-align: right"><b>{{ number_format($profit-$tax,2) }}</b></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif



 @if(!empty($end_date))
        <div class="panel panel-white col-lg-6">
            <div class="panel-body table-responsive no-padding">

        <table class="table table-bordered table-condensed table-hover">
                    <thead>
                    <tr class="bg-green">
                        <th>{{trans_choice('general.balance',1)}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><b>&nbsp;</b></td>
                    </tr>
                                 <?php
                     $c=0;     
                    $sales_balance  = 0;
                    $total_sales  = 0;
                    $cost_balance  = 0;
                    $total_cost  = 0;
                    $expense_balance  = 0;
                    $total_expense  = 0;
                    $gross  = 0;
                   $profit=0;
                  $tax=0;
                $net_profit=0;
?>            
     
     @foreach($sales as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>

 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $sales_balance=$dr- $cr;
                          $total_sales+=$sales_balance ;
                        ?>                           
                             <td>{{ number_format(abs($sales_balance),2) }}</td>

                        </tr>
                                                                
 @endforeach              
  @endforeach
  @endforeach
 
           <tr>

                          <td><b>{{ number_format(abs($total_sales),2) }}</b></td>
                    </tr> 

 <tr>
                        <td ><b>&nbsp;</b></td>
                    </tr>
  @foreach($cost as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>

 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $cost_balance=$dr- $cr;
                          $total_cost+=$cost_balance ;
                        ?>                           
                             <td>{{ number_format(abs($cost_balance),2) }}</td>

                        </tr>
                                                                
 @endforeach              
  @endforeach
  @endforeach

   
           <tr>

                          <td><b>{{ number_format(abs($total_cost),2) }}</b></td>
                    </tr> 
      <tr>
                       
                     
                       <?php
if($total_sales < 0){
$total_s=$total_sales * -1;
$gross=$total_s-$total_cost;
}
else if($total_sales > 0){
$gross=$total_sales-$total_cost;
}
?>
                     
                 <td><b>{{ number_format($gross,2) }}</b></td>
                    </tr> 
                    <tr>
                        <td ><b>&nbsp;</b></td>
                    </tr>

                  @foreach($expense as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $expense_balance=$dr- $cr;
                          $total_expense+=$expense_balance ;
                        ?>                           
                             <td>{{ number_format(abs($expense_balance),2) }}</td>

                        </tr>
                                                               
 @endforeach              
  @endforeach
  @endforeach

   
           <tr>

                          <td><b>{{ number_format($total_expense,2) }}</b></td>
                    </tr> 
                    </tbody>
                    <tfoot>
                    <tr>
                        <?php

if($gross < 0){
$profit=$gross+$total_expense;
}
else if($gross < 0 && $total_expense < 0){
$profit=$gross+$total_expense;
}
else{
$profit=$gross-$total_expense;
}
?>
                        <td><b>{{ number_format($profit,2) }}</b></td>
                    </tr>
                     <tr>
                               <?php
if($profit > 0){
$tax=$profit*0.3;
}
?>
                        <td><b>{{ number_format($tax,2) }}</b></td>
                    </tr>
                     <tr>
                        <td><b>{{ number_format($profit-$tax,2) }}</b></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

       @else
   <div class="panel panel-white col-lg-6">
            <div class="panel-body table-responsive no-padding">

                <table class="table table-bordered table-condensed table-hover">
                    <thead>
                    <tr class="bg-green">
                        <th>{{trans_choice('general.balance',1)}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><b>&nbsp;</b></td>
                    </tr>
                                 <?php
                     $c=0;     
                    $sales_balance  = 0;
                    $total_sales  = 0;
                    $cost_balance  = 0;
                    $total_cost  = 0;
                    $expense_balance  = 0;
                    $total_expense  = 0;
                    $gross  = 0;
                   $profit=0;
                  $tax=0;
                $net_profit=0;
?>            
     
     @foreach($sales as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>

 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $sales_balance=$dr- $cr;
                          $total_sales+=$sales_balance ;
                        ?>                           
                             <td>{{ number_format(abs($sales_balance),2) }}</td>

                        </tr>
                                                                
 @endforeach              
  @endforeach
  @endforeach
 
           <tr>

                          <td><b>{{ number_format(abs($total_sales),2) }}</b></td>
                    </tr> 

 <tr>
                        <td ><b>&nbsp;</b></td>
                    </tr>
  @foreach($cost as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>

 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $cost_balance=$dr- $cr;
                          $total_cost+=$cost_balance ;
                        ?>                           
                             <td>{{ number_format(abs($cost_balance),2) }}</td>

                        </tr>
                                                                
 @endforeach              
  @endforeach
  @endforeach

   
           <tr>

                          <td><b>{{ number_format(abs($total_cost),2) }}</b></td>
                    </tr> 
      <tr>
                       
                     
                       <?php
if($total_sales < 0){
$total_s=$total_sales * -1;
$gross=$total_s-$total_cost;
}
else if($total_sales > 0){
$gross=$total_sales-$total_cost;
}
?>
                     
                 <td><b>{{ number_format($gross,2) }}</b></td>
                    </tr> 
                    <tr>
                        <td ><b>&nbsp;</b></td>
                    </tr>

                  @foreach($expense as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code)
<tr>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $expense_balance=$dr- $cr;
                          $total_expense+=$expense_balance ;
                        ?>                           
                             <td>{{ number_format(abs($expense_balance),2) }}</td>

                        </tr>
                                                               
 @endforeach              
  @endforeach
  @endforeach

   
           <tr>

                          <td><b>{{ number_format($total_expense,2) }}</b></td>
                    </tr> 
                    </tbody>
                    <tfoot>
                    <tr>
                        <?php

if($gross < 0){
$profit=$gross+$total_expense;
}
else if($gross < 0 && $total_expense < 0){
$profit=$gross+$total_expense;
}
else{
$profit=$gross-$total_expense;
}
?>
                        <td><b>{{ number_format($profit,2) }}</b></td>
                    </tr>
                     <tr>
                               <?php
if($profit > 0){
$tax=$profit*0.3;
}
?>
                        <td><b>{{ number_format($tax,2) }}</b></td>
                    </tr>
                     <tr>
                        <td><b>{{ number_format($profit-$tax,2) }}</b></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif




@endsection
@section('footer-scripts')

@endsection
