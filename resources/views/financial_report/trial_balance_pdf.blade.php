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
                {{trans_choice('general.trial_balance',1)}}
                @if(!empty($start_date))
                    for period: {{$start_date}} to {{$end_date}}
                @endif
            </caption>
            <thead>
            <tr class="">
                <th>{{trans_choice('general.account',2)}}</th>
                        <th>{{trans_choice('general.account_name',1)}}</th>
                        <th>{{trans_choice('general.account_codes',2)}}</th>
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
​<td>{{$account_code->account_codes  }}</td>
<?php
                        $cr = 0;
                        $dr = 0;
                        $balance=0;
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');                    
                         $balance =  $dr-$cr;
                        ?>
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
@else
   <table class="">
            <caption>
                {{trans_choice('general.trial_balance',1)}}
             
            </caption>
            <thead>
            <tr class="">
                <th>{{trans_choice('general.account',2)}}</th>
                        <th>{{trans_choice('general.account_name',1)}}</th>
                        <th>{{trans_choice('general.account_codes',2)}}</th>
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
​<td>{{$account_code->account_codes  }}</td>
<?php
                        $cr = 0;
                        $dr = 0;
                        $balance=0;
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');                    
                         $balance =  $dr-$cr;
                        ?>
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
    @endif
</div>