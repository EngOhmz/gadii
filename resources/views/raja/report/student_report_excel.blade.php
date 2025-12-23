<?php
$total_amount=0;
$total_paid=0;
?>
<table style="width:40%;display: inline-table;">
    <thead>
    <tr>
        <th>Particulars</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $key)
        <tr>
            <td>{{$key->name->account_name}}</td>                      
                     <td>{{number_format($key->amount,2)}} </td>
        </tr>

<?php
$total_amount+=$key->amount;
?>
 @endforeach

 <tr>
                      <td>Discount Fee</td>                      
                     <td>{{number_format($student->discount,2)}} </td>
                                                    
                            </tr>
   
    </tbody>

<tfoot>
 <tr>
                                
                      <td>Total</td>
                     <td>{{number_format($total_amount -$student->discount,2)}}</td>                     
                       
                                                                        
                            </tr>
                        
</tfoot>
</table>



<table style="width:40%;display: inline-table;">
    <thead>
    <tr>
        <th>Date</th>
        <th>Particulars</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach($payments as $row)
        <tr>
                    <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}</td>                      
                     <td>{{$row->type}} </td>
                         <td>{{number_format($row->paid,2)}} </td>             
        </tr>

<?php
$total_paid+=$row->paid;
?>
 @endforeach
 
    </tbody>

<tfoot>
 <tr>
                                <td></td>
                      <td>Total</td>
                     <td>{{number_format($total_paid,2)}}</td>                     
                                                                     
                            </tr>

 <tr>
                                <td></td>
                      <td><strong>Balance</strong></td>
                     <td><strong>{{number_format(($total_amount -$student->discount)-$total_paid,2)}}</strong></td>                     
                                                                     
                            </tr>
                        
</tfoot>
</table>



