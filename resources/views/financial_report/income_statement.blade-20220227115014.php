@extends('layouts.master')


@section('contents')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Income Statement </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Income Statement Report
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
        <div class="panel-heading">
            <h6 class="panel-title">
                Income Statement
               @if(!empty($start_date))
                    for the period: <b>{{$start_date}} to {{$second_date}}</b>
                @endif
             @if(!empty($end_date))
                    and period: <b>{{$second_date}} to {{$end_date}}</b>
                @endif
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

                <div class="col-md-4">
                    <label class="">Start Date</label>
                    {!! Form::date('start_date',$start_date, array('class' => 'form-control date-picker', 'placeholder'=>"First Date",'required'=>'required')) !!}
                </div>
                <div class="col-md-4">
                    <label class="">Second Date</label>
                    {!! Form::date('second_date',$second_date, array('class' => 'form-control date-picker', 'placeholder'=>"Second Date",'required'=>'required')) !!}
                </div>
              <div class="col-md-4">
                    <label class="">End Date</label>
                    {!! Form::date('end_date',$end_date, array('class' => 'form-control date-picker', 'placeholder'=>"Third Date",'required'=>'required')) !!}
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
        <div class="panel panel-white col-lg-12">
            <div class="panel-body table-responsive no-padding">

                  <table id="data-table" class="table table-striped ">
                    <thead>
                    <tr>
                        <th colspan="2">STATEMENT OF COMPRENHESIVE FOR THE PERIOD</th>
                         
                        <th> ENDING {{$end_date}}</th>
                           <th  colspan="3">ENDING {{$second_date}}</th>
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
     
     @foreach($income as $account_class)
  @foreach($account_class->groupAccount  as $group)   
  @if($group->group_id != 5110)
@foreach($group->accountCodes as $account_code)
<tr>
  <td>{{$account_code->account_name }}</td>
<td><a href="#view{{$account_code->account_id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>
 
</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                              [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            
                          $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date ,$end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            
                            
                        //   $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                        //     session('branch_id'))->sum('credit');
                        // $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                        //     session('branch_id'))->sum('debit');
                            
                        //   $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                        //     session('branch_id'))->sum('credit');
                        // $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                        //     session('branch_id'))->sum('debit');

                       $income_balance=$dr- $cr;
                          $total_incomes+=$income_balance ;
                          
                        $income_balance1=$dr1- $cr1;
                          $total_incomes1+=$income_balance1 ;
                        ?>     
                               <td>{{ number_format(abs($income_balance1),2) }}</td>                      
                             <td>{{ number_format(abs($income_balance),2) }}</td>
                           
                             

                        </tr>
                                                                
 @endforeach 
  @endif
  @endforeach
  @endforeach
 
           <tr>
                        <td >
                            <b>Total Income</b></td>
                                <td colspan="2" style="text-align: center"><b>{{ number_format(abs($total_incomes1),2) }}</b></td>
                           <td colspan="5" style="text-align: center"><b>{{ number_format(abs($total_incomes),2) }}</b></td>
                           
                         
                    </tr> 
                    
            
     <tr>
                        <td colspan="7" style="text-align: left"><b>Other Income Cost</b></td>
                    </tr> 
                    
     @foreach($income as $account_class)
  @foreach($account_class->groupAccount  as $group)   
  @if($group->group_id == 5110)
@foreach($group->accountCodes as $account_code)
<tr>
  <td>{{$account_code->account_name }}</td>
<td><a href="#view{{$account_code->account_id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>
 
</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                               [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            
                               
                          $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date ,$end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $income_balance=$dr- $cr;
                        $income_balance1=$dr1- $cr1;
                          $total_other_incomes+=$income_balance ;
                          $total_other_incomes1+=$income_balance1 ;
                        ?>      
                           <td >{{ number_format(abs($income_balance1),2) }}</td>                     
                             <td>{{ number_format(abs($income_balance),2) }}</td>
                             

                        </tr>
                                                                
 @endforeach 
  @endif
  @endforeach
  @endforeach
 
           <tr>
                        <td >
                            <b>Total Other Income Cost</b></td>
                               <td colspan="2" style="text-align: center"><b>{{ number_format(abs($total_other_incomes1),2) }}</b></td>
                           <td colspan="5" style="text-align: center"><b>{{ number_format(abs($total_other_incomes),2) }}</b></td>
                           
                    </tr>

 <tr>
                        <td colspan="4" style="text-align: left"><b>Financial Cost</b></td>
                    </tr>
  @foreach($cost as $account_class)
  @foreach($account_class->groupAccount  as $group) 
  @if($group->group_id == 6180)
@foreach($group->accountCodes as $account_code)
<tr>
 <td>{{$account_code->account_name }}</td>
<td><a href="#view{{$account_code->account_id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>

</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date,$second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');


                             
                          $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date ,$end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            
                       $cost_balance=$dr- $cr;
                        $cost_balance1=$dr1- $cr1;
                        
                          $total_cost+=$cost_balance ;
                          $total_cost1+=$cost_balance1 ;
                        ?>   
                             <td>{{ number_format(abs($cost_balance1),2) }}</td>                        
                             <td>{{ number_format(abs($cost_balance),2) }}</td>
                            

                        </tr>
                                                                
 @endforeach  
 @endif
  @endforeach
  
  @endforeach

   
           <tr>
                        <td >
                            <b>Total Financial Cost</b></td>
                                 <td colspan="2" style="text-align: right"><b>{{ number_format(abs($total_cost1),2) }}</b></td>
                          <td colspan="5" style="text-align: right"><b>{{ number_format(abs($total_cost),2) }}</b></td>
                      
                    </tr> 
      <tr>
                        <td >
                            <b>Gross Profit</b></td>

                     
                       <?php

if($total_other_incomes < 0){
$total_o=$total_other_incomes * -1;
}
else if($total_other_incomes >= 0){
$total_o=$total_other_incomes ;
}


if($total_other_incomes1 < 0){
$total_o1=$total_other_incomes1 * -1;
}
else if($total_other_incomes1 >= 0){
$total_o1=$total_other_incomes1 ;
}



if($total_incomes < 0){
$total_s=$total_incomes * -1;
$gross=$total_s+$total_o-$total_cost;
}
else if($total_incomes >= 0){
$gross=$total_incomes+$total_o-$total_cost;
}

if($total_incomes1 < 0){
$total_s1=$total_incomes1 * -1;
$gross1=$total_s1+$total_o1-$total_cost1;
}
else if($total_incomes1 >= 0){
$gross1=$total_incomes1+$total_o1-$total_cost1;
}
?>
                     
                 <td colspan="2" style="text-align: right"><b>{{ number_format($gross1,2) }}</b></td>
                <td colspan="5" style="text-align: right"><b>{{ number_format($gross,2) }}</b></td>
                    </tr> 
                 
  
                    
                       <tr>
                        <td colspan="7" style="text-align: left"><b>Expenses</b></td>
                    </tr>



                  @foreach($expense as $account_class)
  @foreach($account_class->groupAccount  as $group)        
    @if($group->group_id != 6180)
@foreach($group->accountCodes as $account_code)
<tr>
 <td>{{$account_code->account_name }}</td>
<td><a href="#view{{$account_code->account_id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>
  
</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            
                        
                               
                          $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date ,$end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $expense_balance=$dr- $cr;
                          $total_expense+=$expense_balance ;
                          
                          $expense_balance1=$dr1- $cr1;
                          $total_expense1+=$expense_balance1 ;
                        ?>                           
                             <td>{{ number_format(abs($expense_balance1),2) }}</td>
                             <td>{{ number_format(abs($expense_balance),2) }}</td>

                        </tr>
                                                               
 @endforeach  
 @endif
  @endforeach
  @endforeach

   
           <tr>
                        <td >
                            <b>Total Expenses</b></td>
                           <td colspan="2" style="text-align: right"><b>{{ number_format($total_expense1,2) }}</b></td>
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


//range for second date
if($gross1 < 0){
$profit1=$gross1+$total_expense1;
}
else if($gross1 < 0 && $total_expense1 < 0){
$profit1=$gross1+$total_expense1;
}
else if($gross1 >= 0 && $total_expense1 < 0){
$profit1=$total_expense1 +$gross1;
}
else{
$profit1=$gross1-$total_expense1;
}
?>
                         <td colspan="2" style="text-align: right"><b>{{ number_format($profit1,2) }}</b></td>
                         <td colspan="5" style="text-align: right"><b>{{ number_format($profit,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>Tax</b></td>
                               <?php
if($profit > 0){
$tax=$profit*0.3;
}

if($profit1 > 0){
$tax1=$profit1*0.3;
}
?>
                        <td colspan="2" style="text-align: right"><b>{{ number_format($tax1,2) }}</b></td>
                        <td colspan="5" style="text-align: right"><b>{{ number_format($tax,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>Net Profit</b></td>
                        <td colspan="2" style="text-align: right"><b>{{ number_format($profit1-$tax1,2) }}</b></td>
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
@foreach($income as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code) 

                       
  <!-- Modal -->
  <div class="modal inmodal "id="view{{$account_code->account_id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog"><div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_code->account_codes }} - {{$account_code->account_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                            <table class="table table-bordered table-striped">
<thead>
                    <tr>
                       <th>Date</th>
                            <th>Debit</th>
                        <th>Credit</th>
                      <th>Note</th>
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
                    <td >{{$a->name }}</td>
                    </tr> 

  @endforeach
    
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            

                        ?>  
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
                           <td></td>
                            
                            
                    </tr> 
  <tr>
                        <td >
                          <b>{{$account_code->account_name }} Total Balance</b></td>
                           <td colspan="3"><b>{{ number_format($cr-$dr,2) }}</b></td>

                         

                    </tr> 
                              </tbody>
                            </table>
                           </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div></div>
  </div>
 @endforeach
 @endforeach              
  @endforeach

<!-- //sehemu ya equity ==================================================================== -->
  @foreach($cost as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code) 

                       
  <!-- Modal -->
  <div class="modal inmodal "id="view{{$account_code->account_id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog"><div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_code->account_codes }} - {{$account_code->account_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                            <table class="table table-bordered table-striped">

<thead>
                    <tr>
                 <th>Date</th>
                            <th>Debit</th>
                        <th>Credit</th>
                      <th>Note</th>
         
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
                   <td >{{ $a->name }}</td>
                    </tr> 

  @endforeach
    
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
 <td></td>
                    </tr> 
  <tr>
                        <td >
                               <b>{{$account_code->account_name }} Total Balance</b></td>
                           <td colspan="3"><b>{{ number_format($dr-$cr,2) }}</b></td>

                    </tr> 
                              </tbody>
                            </table>
                           </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div></div>
  </div>
 @endforeach
 @endforeach              
  @endforeach

<!-- sehemu ya liabilitty==================================================== -->
                   
 @foreach($expense as $account_class)
  @foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code) 

                       
  <!-- Modal -->
  <div class="modal inmodal "id="view{{$account_code->account_id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog"><div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_code->account_codes }} - {{$account_code->account_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                            <table class="table table-bordered table-striped">
 
<thead>
                    <tr>
                  <th>Date</th>
                            <th>Debit</th>
                        <th>Credit</th>
                      <th>Note</th>
         
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
                     <td >{{ $a->name }}</td>
                    </tr> 

  @endforeach
    
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
                           <td></td>
                    </tr> 
  <tr>
                        <td >
                            <b>{{$account_code->account_name }} Total Balance</b></td>
                           <td colspan="3"><b>{{ number_format($dr-$cr,2) }}</b></td>

                    </tr> 
                              </tbody>
                            </table>
                           </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div></div>
  </div>
 @endforeach
 @endforeach              
  @endforeach

@endif


@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'copy'
            },
            {
                extend: 'csv'
            },
            {
                extend: 'excel',
                title: 'ExampleFile'
            },
            {
                extend: 'pdf',
                title: 'ExampleFile'
            },

            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ]

    });

});
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection