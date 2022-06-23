<style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    }
    th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #4CAF50;
        color: white;
    }
</style>
<div>

    @if(!empty($start_date))
        <table class="">
            <caption>
                {{trans_choice('general.balance',1)}} {{trans_choice('general.sheet',1)}}
                @if(!empty($start_date))
                    as at: {{$start_date}}
                @endif
            </caption>
            <thead>
            <tr class="">
             <th>#</th
                        <th>{{trans_choice('general.account_name',1)}}</th>
                        <th>{{trans_choice('general.account_codes',2)}}</th>
                    <th>{{trans_choice('general.debit',1)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
            </tr>
            </thead>
             <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center"><b>{{trans_choice('general.asset',2)}}</b></td>
                    </tr>


               <?php
               $c=0;     
                    $total_liabilities = 0;
                    $total_debit_assets = 0;
                    $total_credit_assets = 0;
                      $total_debit_liability  = 0;
                    $total_credit_liability  = 0;
                        $total_debit_equity  = 0;
                    $total_credit_equity  = 0;
                   $total_assets = 0;
                    $total_equity = 0;
?>            
     
     @foreach($asset as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="3"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
​<td>{{$account_code->account_codes  }}</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_assets +=$dr ;
                         $total_credit_assets +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              
  @endforeach
  @endforeach
 
           <tr>
                        <td colspan="3" style="text-align: right">
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.asset',2)}}</b></td>
                        <td><b>{{ number_format($total_debit_assets,2) }}</b></td>
                        <td><b>{{ number_format($total_credit_assets,2) }}</b></td>

                    </tr>            
                   


                    <tr>
                        <td colspan="5" style="text-align: center "><b>{{trans_choice('general.liability',2)}}</b></td>
                    </tr>
                     @foreach($liability  as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="3"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
​<td>{{$account_code->account_codes  }}</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_liability  +=$dr ;
                         $total_credit_liability  +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              ​
 ​@endforeach
 ​@endforeach


  ​<tr>
                       ​<td colspan="3" style="text-align: right">
                           ​<b>{{trans_choice('general.total',1)}} {{trans_choice('general.liability',2)}}</b></td>
                       ​<td><b>{{ number_format($total_debit_liability ,2) }}</b></td>
                       ​<td><b>{{ number_format($total_credit_liability,2) }}</b></td>

                   ​</tr>     
                       


<tr>
                        <td colspan="5" style="text-align: center"><b>{{trans_choice('general.equity',2)}}</b></td>
                    </tr>
    @foreach($equity   as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="3"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
​<td>{{$account_code->account_codes  }}</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_equity   +=$dr ;
                         $total_credit_equity   +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              ​
 ​@endforeach
 ​@endforeach
                   
                                      <tr>
                        <td colspan="3" style="text-align: right">
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.equity',2)}}</b></td>
                       ​<td><b>{{ number_format($total_debit_equity ,2) }}</b></td>
                       ​<td><b>{{ number_format($total_credit_equity,2) }}</b></td>
                    </tr>

                    </tbody>
                    <tfoot>
                    
                                                
                    <tr>
                        <td colspan="3" style="text-align: right">
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.liability',2)}} {{trans_choice('general.and',1)}} {{trans_choice('general.equity',2)}}</b>
                        </td>
                        <td><b>{{ number_format($total_debit_liability+$total_debit_equity ,2) }}</b></td>

                        <td><b>{{ number_format($total_credit_liability+$total_credit_equity,2) }}</b></td>
                    </tr>
                    </tfoot>
                </table>
           

@else
         <table class="">
            <caption>
                {{trans_choice('general.balance',1)}} {{trans_choice('general.sheet',1)}}
              
            </caption>
                    <thead>
                    <tr class="bg-green">
                       <th>#</th>
                        <th>{{trans_choice('general.account_name',1)}}</th>
                        <th>{{trans_choice('general.account_codes',2)}}</th>
                    <th>{{trans_choice('general.debit',1)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center"><b>{{trans_choice('general.asset',2)}}</b></td>
                    </tr>


               <?php
               $c=0;     
                    $total_liabilities = 0;
                    $total_debit_assets = 0;
                    $total_credit_assets = 0;
                      $total_debit_liability  = 0;
                    $total_credit_liability  = 0;
                        $total_debit_equity  = 0;
                    $total_credit_equity  = 0;
                   $total_assets = 0;
                    $total_equity = 0;
?>            
     
     @foreach($asset as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="3"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
​<td>{{$account_code->account_codes  }}</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_assets +=$dr ;
                         $total_credit_assets +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              
  @endforeach
  @endforeach
 
           <tr>
                        <td colspan="3" style="text-align: right">
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.asset',2)}}</b></td>
                        <td><b>{{ number_format($total_debit_assets,2) }}</b></td>
                        <td><b>{{ number_format($total_credit_assets,2) }}</b></td>

                    </tr>            
                   


                    <tr>
                        <td colspan="5" style="text-align: center "><b>{{trans_choice('general.liability',2)}}</b></td>
                    </tr>
                     @foreach($liability  as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="3"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
​<td>{{$account_code->account_codes  }}</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_liability  +=$dr ;
                         $total_credit_liability  +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              ​
 ​@endforeach
 ​@endforeach


  ​<tr>
                       ​<td colspan="3" style="text-align: right">
                           ​<b>{{trans_choice('general.total',1)}} {{trans_choice('general.liability',2)}}</b></td>
                       ​<td><b>{{ number_format($total_debit_liability ,2) }}</b></td>
                       ​<td><b>{{ number_format($total_credit_liability,2) }}</b></td>

                   ​</tr>     
                       


<tr>
                        <td colspan="5" style="text-align: center"><b>{{trans_choice('general.equity',2)}}</b></td>
                    </tr>
    @foreach($equity   as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="3"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
​<td>{{$account_code->account_codes  }}</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_equity   +=$dr ;
                         $total_credit_equity   +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              ​
 ​@endforeach
 ​@endforeach
                   
                                      <tr>
                        <td colspan="3" style="text-align: right">
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.equity',2)}}</b></td>
                       ​<td><b>{{ number_format($total_debit_equity ,2) }}</b></td>
                       ​<td><b>{{ number_format($total_credit_equity,2) }}</b></td>
                    </tr>

                    </tbody>
                    <tfoot>
                    
                            
                    
                    <tr>
                        <td colspan="3" style="text-align: right">
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.liability',2)}} {{trans_choice('general.and',1)}} {{trans_choice('general.equity',2)}}</b>
                        </td>
                        <td><b>{{ number_format($total_debit_liability+$total_debit_equity ,2) }}</b></td>

                        <td><b>{{ number_format($total_credit_liability+$total_credit_equity,2) }}</b></td>
                    </tr>
                    </tfoot>
        </table>
    @endif
</div>