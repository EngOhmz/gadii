<?php
$total_income=($invoice - $sdiscount) - $credit;
$total_paid=( ($purchase - $pdiscount) + $expense) - $debit ;
?>

<table  style="width:40%;display: inline-table;">
 <thead>
                        <tr>
                           
                            <th> Particulars</th>
                            <th> Amount</th>
                      
                        </tr>
                        </thead>
                        <tbody>

                   <tr>
                      <td>Invoice</td> 
                      <td>{{number_format($invoice - $sdiscount,2)}} </td>
                        </tr>
                            <tr>
                      <td>Credit Note</td>
                       <td>{{number_format($credit,2)}} </td>                                                                        
                            </tr>
                        </tbody>
                        <tfoot>
 <tr>
                                
                      <td>Total</td>
                     <td>{{number_format($total_income,2)}}</td>                     
                       
                                                                        
                            </tr>
                        
</tfoot>
    </table>

    <table  style="width:40%;display: inline-table;">
 <thead>
                        <tr>
                            <th> Particulars</th>
                            <th> Amount</th>
                      
                        </tr>
                        </thead>
                        <tbody>

 <tr>
                      <td>Purchases</td> 
                      <td>{{number_format($purchase - $pdiscount,2)}} </td>
                         </tr>
                            <tr>
                      <td>Debit Note</td>
                       <td>{{number_format($debit,2)}} </td>
                            </tr>
                            <tr>
                          <td>Expenses</td>
                       <td>{{number_format($expense,2)}} </td>                                              
                            </tr>
                       
                        
                        </tbody>
                        <tfoot>
 <tr>
                               
                      <td>Total</td>
                     <td>{{number_format($total_paid,2)}}</td>                     
                                                                     
                            </tr>
                        
</tfoot>
 
    </table>




<table>
  <tfoot>

<tr>
                                
                      <td><strong>Balance</strong></td>
                     <td><strong>{{number_format($total_income-$total_paid,2)}}</strong></td>                     
                                                                     
                            </tr>
                        
</tfoot>
    </table>
