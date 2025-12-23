@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Income Statement  Summary</h4>
                    </div>
                    <div class="card-body">
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
        <div class="panel-heading">
            <h6 class="panel-title">

               @if(!empty($start_date))
                    For the period: <b>{{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} to {{Carbon\Carbon::parse($second_date)->format('d/m/Y')}}</b>
                @endif
         
            </h6>
        </div>

<br>
       <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

               <div class="col-md-4">
                    <label class="">Start Date</label>
                   <input  name="start_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                    echo date('Y-m-d', strtotime('first day of january this year'));
                }
                ?>">

                </div>
                <div class="col-md-4">
                    <label class="">End Date</label>
                     <input  name="second_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($second_date)) {
                    echo $second_date;
                } else {
                    echo date('Y-m-d');
                }
                ?>">
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
                              
                                    <li class="nav-item"><a class="nav-link" href="{{url('financial_report/income_statement_summary/pdf?start_date='.$start_date.'&end_date='.$second_date)}}"
                                       target="_blank"><i
                                                class="icon-file-pdf"></i>  Download PDF
                                    </a></li>
                                
                                    <li class="nav-item"><a class="nav-link" href="{{url('financial_report/income_statement_summary/excel?start_date='.$start_date.'&end_date='.$second_date)}}"
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
                        <td colspan="4" style="text-align: left"><b><a href="#viewincome" data-toggle="modal"">Income</a></b></td>
                   
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
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)   
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)

 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                              [$start_date, $second_date])->sum('debit');
                            
                       $income_balance=$dr- $cr;
                          $total_incomes+=$income_balance ;
                          

                        ?>                          
                             
                                                                
 @endforeach 
  @endforeach
  @endforeach
 
   
                           <td colspan="" ><b>{{ number_format(abs($total_incomes),2) }}</b></td>
                           
                         
                    </tr> 
                    
  <!--          
     
 <tr>
                        <td colspan="4" style="text-align: left"><b><a href="#viewcost" data-toggle="modal"">Financial Cost</a></b></td>
                    
  @foreach($cost->where('added_by',auth()->user()->added_by) as $account_class)
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group) 
  @if($group->group_id == 6180)
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)

 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date,$second_date])->sum('debit');


                            
                       $cost_balance=$dr- $cr;
                        
                          $total_cost+=$cost_balance ;
                        ?>                        
                            
                            

                        </tr>
                                                                
 @endforeach  
 @endif
  @endforeach
  
  @endforeach

   
          
                          <td colspan="" ><b>{{ number_format(abs($total_cost),2) }}</b></td>
                      
                    </tr> 
      <tr>
                        <td >
                            <b>Gross Profit</b></td>

  -->                   
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
<!--
                  <td></td> <td></td><td></td>   
                <td colspan="7"><b>{{ number_format($gross,2) }}</b></td>
                    </tr> 
                 
  -->
                    
                       <tr>
                        <td colspan="4" style="text-align: left"><b><a href="#viewexpenses" data-toggle="modal"">Expenses</a></b></td>
                   



                  @foreach($expense->where('added_by',auth()->user()->added_by) as $account_class)
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)        
    @if($group->group_id != 6180)
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)

 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                        

                       $expense_balance=$dr- $cr;
                          $total_expense+=$expense_balance ;
                          
                        ?>                           
                            
                                                               
 @endforeach  
 @endif
  @endforeach
  @endforeach

   


                           <td colspan="" style=""><b>{{ number_format($total_expense,2) }}</b></td>
                    </tr> 
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>
                           <b>Profit Before Tax</b></td><td></td><td></td>
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
<td></td>
                         <td colspan="4"><b>{{ number_format($profit,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>Tax</b></td><td></td><td></td><td></td>
                               <?php
if($profit > 0){
$tax=$profit*0.3;
}


?>
                        <td colspan="4" ><b>{{ number_format($tax,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>Net Profit</b></td><td></td><td></td><td></td>
                        <td colspan="4" ><b>{{ number_format($profit-$tax,2) }}</b></td>
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
 <?php    
 $unit_total  = 0;
   $total_cr= 0;
$total_dr= 0;
?>      

                       
  <!-- Modal -->
  <div class="modal fade "id="viewincome"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> Income<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
   <table class="table datatable-basic table-striped">

<thead>
                    <tr>
               <th>Account Code</th>
                          <th>Account Name</th>
                            <th>Debit</th>
                        <th>Credit</th>
         
                    </tr>
                    </thead>
                              <tbody>
 @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code) 
                    <?php                   
                          $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');

                          $unit_total  +=($cr-$dr);
                              $total_cr+=$cr;
                           $total_dr+=$dr;
                        ?>  
                                 <tr>
                                <tr>
                        <td >{{ $account_code->account_codes }}</td>
                          <td >{{ $account_code->account_name }}</td>
                          <td>{{ number_format($dr ,2) }}</td>
                   <td >{{ number_format($cr ,2) }}</td>
                    </tr> 

           
  @endforeach
 @endforeach   
                              </tbody>
<tfoot>
<tr>     
                      
                        <td></td>
                            <td><b>Total</b></td>
                             <td><b>{{ number_format($total_dr,2) }}</b></td>
                            <td><b>{{ number_format($total_cr,2) }}</b></td>
 
                    </tr> 

<tr>
                        <td >
                               <b>Income Total Balance</b></td>
                           <td colspan="3"><b>{{ number_format( $unit_total ,2) }}</b></td>

                    </tr> 
</tfoot>
                            </table>
                           </div>

        </div>
       
 <div class="modal-footer ">
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
    </div>
</div></div>
  </div>
 @endforeach
 

<!-- //sehemu ya equity ==================================================================== -->
  @foreach($cost->where('added_by',auth()->user()->added_by) as $account_class)
 
 <?php    
 $unit_total  = 0;
   $total_cr= 0;
$total_dr= 0;
?>     
                       
  <!-- Modal -->
  <div class="modal fade " id="viewcost"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> Finanacial Cost<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                             <table class="table datatable-basic table-striped">

<thead>
                    <tr>
               <th>Account Code</th>
                          <th>Account Name</th>
                            <th>Debit</th>
                        <th>Credit</th>
         
                    </tr>
                    </thead>
                              <tbody>
 @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)   
 @if($group->group_id == 6180)                          
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code) 
                    <?php                   
                          $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');

                          $unit_total  +=($dr-$cr);
                              $total_cr+=$cr;
                           $total_dr+=$dr;
                        ?>  
                                 <tr>
                                <tr>
                        <td >{{ $account_code->account_codes }}</td>
                          <td >{{ $account_code->account_name }}</td>
                          <td>{{ number_format($dr ,2) }}</td>
                   <td >{{ number_format($cr ,2) }}</td>
                    </tr> 

           
  @endforeach
@endif
 @endforeach   
                              </tbody>
<tfoot>
<tr>     
                        
                        <td></td>
                            <td><b>Total</b></td>
                             <td><b>{{ number_format($total_dr,2) }}</b></td>
                            <td><b>{{ number_format($total_cr,2) }}</b></td>
 
                    </tr> 

<tr>
                        <td >
                               <b>Financial Cost Total Balance</b></td>
                           <td colspan="3"><b>{{ number_format( $unit_total ,2) }}</b></td>

                    </tr> 
</tfoot>
                            </table>
                           </div>

        </div>
       
 <div class="modal-footer ">
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
    </div>
</div></div>
  </div>
            
  @endforeach

<!-- sehemu ya liabilitty==================================================== -->
                   
 @foreach($expense->where('added_by',auth()->user()->added_by) as $account_class)
   <!-- Modal -->
  <div class="modal fade " id="viewexpenses"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> Expenses<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                             <table class="table datatable-basic table-striped">

<thead>
                    <tr>
               <th>Account Code</th>
                          <th>Account Name</th>
                            <th>Debit</th>
                        <th>Credit</th>
         
                    </tr>
                    </thead>
                              <tbody>
 @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code) 
                    <?php                   
                          $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');

                          $unit_total  +=($dr-$cr);
                              $total_cr+=$cr;
                           $total_dr+=$dr;
                        ?>  
                                 <tr>
                                <tr>
                        <td >{{ $account_code->account_codes }}</td>
                          <td >{{ $account_code->account_name }}</td>
                          <td>{{ number_format($dr ,2) }}</td>
                   <td >{{ number_format($cr ,2) }}</td>
                    </tr> 

           
  @endforeach
 @endforeach   
                              </tbody>
<tfoot>
<tr>     
                       
                        <td></td>
                            <td><b>Total</b></td>
                             <td><b>{{ number_format($total_dr,2) }}</b></td>
                            <td><b>{{ number_format($total_cr,2) }}</b></td>
 
                    </tr> 

<tr>
                        <td >
                               <b>Expenses Total Balance</b></td>
                           <td colspan="3"><b>{{ number_format( $unit_total ,2) }}</b></td>

                    </tr> 
</tfoot>
                            </table>
                           </div>

        </div>
       
 <div class="modal-footer ">
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
    </div>
</div></div>
  </div>
            
  @endforeach

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
@endsection