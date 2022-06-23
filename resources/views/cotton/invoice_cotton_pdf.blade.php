<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tire</title>
   
    <style type="text/css">
        /*@page {*/
        /*    margin: 1in 0in 0in 0in;*/
        /*}*/
        @font-face {
            font-family: "Source Sans Pro", sans-serif;
        }

        .h4 {
            font-size: 14px;
        }

        .h3 {
            font-size: 15px;
        }

        h2 {
            font-size: 19px;
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            color: #555555;
            background: #ffffff;
            font-size: 12px;
            font-family: "Source Sans Pro", sans-serif;
            width: 100%;
       
        }

        header {
            padding: 10px 0;
            margin-bottom: 15px;
            border-bottom: 1px solid #aaaaaa;
       
        }

        #logo {
       
        }

        #company {
       text-align: right;

        }

        #details {
            margin-bottom: 10px;
       
        }

        #client {
            padding-left: 6px;
            /*border-left: 6px solid #0087C3;*/
       
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1em;
            font-weight: normal;
            margin: 0;
       
        }

        #invoice {
          text-align: right;

        }

        #invoice h1 {
            color: #0087C3;
            font-size: 1.5em;
            line-height: 1em;
            font-weight: normal;
       
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
       
        }

        table {
            width: 100%;
            border-spacing: 0;
       
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            /*margin-bottom: 10px;*/
       
        }

        table.items th,
        table.items td {
            padding: 5px;
            /*background: #EEEEEE;*/
            border-bottom: 1px solid #FFFFFF;
       
       

        }

        table.items th {
            white-space: nowrap;
            font-weight: normal;
       
        }

        table.items td {
         
        
        }

        table.items td h3 {
           
            font-size: 1em;
            font-weight: normal;
            margin-top: 2px;
            margin-bottom: 2px;
       
        }

        table.items .no {
            background: #dddddd;
        }

        table.items .desc {
         

        }

        table.items .unit {
            background: #F3F3F3;
            padding: 5px 10px 5px 5px;
            word-wrap: break-word;
        }

        table.items .qty {
        }

        table.items td.unit,
        table.items td.qty,
        table.items td.total {
            font-size: 1em;
        }

        table.items tbody tr:last-child td {
            border: none;

        }

        table.items tfoot td {
            padding: 5px 10px;
            background: #ffffff;
            border-bottom: none;
            font-size: 14px;
            white-space: nowrap;
            border-top: 1px solid #aaaaaa;
       
        }

        table.items tfoot tr:first-child td {
            border-top: none;
        }

        table.items tfoot tr:last-child td {
            color: #57B223;
            font-size: 1.4em;
            border-top: 1px solid #57B223;

        }

        table.items tfoot tr td:first-child {
            border: none;
         text-align: right;
        
        }

        #thanks {
            font-size: 16px;
            margin-bottom: 10px;
        }

        #notices {
            padding-left: 6px;
            border-left: 0px solid #0087C3;

        }

        #notices .notice {
            font-size: 1em;
            color: #000000;
        }

        footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #aaaaaa;
            padding: 8px 0;
            text-align: center;
        }

        tr.total td, tr th.total, tr td.total {
        text-align: right;
       
        }

        .bg-items {
            background: #303252 !important;
            color: #ffffff
        }

        .p-md {
            padding: 9px !important;
        }

        .left {
         float: left;
        
        }

        .right {
           float: right;
            padding-left: 10px;
        
        }

        .num_word {
            margin-top: 5px;
            margin-bottom: 5px;
        }
    
    </style>
</head>
<body>
   <?php
$settings= App\Models\System::first();

?>
<table class="clearfix">
    <tr>
        <td style="width: 60%;">
            <div id="logo" class="left">
                <img style="width: 170px;height: 80px;float: left !important;" src="{{url('public/assets/img/logo')}}/{{$settings->picture}}">
            </div>
        </td>
        
         <td style="width: 40%;">
            <div class="left" style="">
        <div> <h1><b>GAKI INVESTMENT CO LTD</b></h1></div>
        <div> <b>   P.O BOX 707 , SHINYANGA , TANZANIA</b></div>
        <div> <b>Tel : +255282986301</b></div>
                <div> <b>Fax : +255282986300  </b></div>
        <div><b>Email: <a href="mailto:gakiginning@yahoo.com">gakiginning@yahoo.com</b></div>        
        </td>
        
        
    </tr>
</table>

<table id="details" class="clearfix">
    <tr>
        <td style="width: 80%;overflow: hidden">
            <h4 class="p-md bg-items ">
                Client Details
            </h4>
        </td>
        <td style="width: 20%">
            <h4 class="p-md bg-items ">
                Invoice Details
            </h4>
        </td>
    </tr>
    <tr style="margin-top: 0px">
      
        <td style="width: 20%">
            <div style="padding-left: 5px">
              
               <h3 style="margin: 0px">{{$purchases->supplier->name}}</h3>
              
        </td>

         <td style="width: 50%;">
            <div class="left" style="">

        
        <h3 style="margin-bottom: 0;margin-top: 0">REF NO : <span style="text-align: right">{{$purchases->reference}}</span></h3>
                <div class="date">Invoice Date : <span style="text-align: right"> {{Carbon\Carbon::parse($purchases->purchase_date)->format('d/m/Y')}}</span></div>             
                <div class="date">Due date : <span style="text-align: right">{{Carbon\Carbon::parse($purchases->due_date)->format('d/m/Y')}}</span></div>
               <div class="date"> Sales Agent : <span style="text-align: right">{{$purchases->user->name }} </span></div>
                <div class="date">Status: <span style="text-align: right">  
                                       @if($purchases->status == 0)
                                           Not Approved
                                            @elseif($purchases->status == 1 )
                                           Not Paid
                                            @elseif($purchases->status == 2)
                                             Partially Paid
                                            @elseif($purchases->status == 3)
                                              Fully Paid
                                            @elseif($purchases->status == 4)
                                            Cancelled
                                            @endif
                                          </span></div>

               <div class="date"> Currency : <span style="text-align: right">{{$purchases->exchange_code }} </span> </div>
                
             
            </div>
        
        </td>  
          
         
    </tr>
</table>


<div id="notices">
    <div class="notice"></div>
</div><br><br>


<?php
                               
                                  $total_bales =0;
                                $total_gross =0;
                                  $total_tare = 0; 
                               $total_net= 0;
                                 $i =1;
       
                                 ?>


<table class="items">
    <thead class="p-md bg-items">
    <tr>
        <th class="col-sm-2" style="text-align: right"> # </th>
         <th style="color:white;text-align: right;" class="col-sm-2">Lot No</th>
                        <th style="color:white;text-align: right;" >Bales</th>
                        <th  class="col-sm-1" style="color:white;text-align: right;"">Gross</th>
                        <th class="col-sm-1" style="color:white;text-align: right;"">Tare</th>
                        <th class="col-sm-2" style="color:white;text-align: right;"">Net</th>
    </tr>
    </thead>
    <tbody>
     @if(!empty($purchase_items))
                                        @foreach($purchase_items as $row)
                                        <?php
                                         $total_bales +=$row->bales;
                                         $total_gross +=$row->gross;
                                          $total_tare += $row->tare; 
                                         $total_net+= $row->net; 
                                         ?>

            <tr>
                <td class="unit" style="text-align: right"><h3>{{$i++}}</h3>
                 <?php
                                            $item_name = App\Models\Cotton\Production::find($row->item_name);
                                        ?>
                <td class="unit" style="text-align: right"><h3>{{$item_name->lot_no}}</h3>
                </td>
                <td class="unit" style="text-align: right">{{ $row->bales }}</td>
                <td class="unit" style="text-align: right">{{number_format($row->gross ,2)}}</td>
                <td class="unit" style="text-align: right" > {{number_format($row->tare ,2)}} 
</td>

                    
                <td class="unit" style="text-align: right">{{number_format($row->net ,2)}}</td>
                
            </tr>
           @endforeach
                                        @endif

<tr>
                <td class="unit" style="text-align: right">
                <td class="unit" style="text-align: right"><h3><b>TOTAL</b></h3>
                </td>
                <td class="unit" style="text-align: right" >{{ number_format($total_bales,2) }}</td>
                <td class="unit" style="text-align: right">{{number_format($total_gross ,2)}} kg</td>
                <td class="unit"style="text-align: right" > {{number_format($total_tare ,2)}} kg 
</td>    
                <td class="unit" style="text-align: right">{{number_format($total_net ,2)}} kg</td>
                
            </tr></tbody>
    <tfoot>
    

            <tr class="total">
        <td colspan="4"></td>
        <td colspan="1"><b>Unit Price</b></td>
        <td>{{number_format($purchases->unit_price,2)}}  {{$purchases->exchange_code}}</td>
    </tr>
    
   <tr class="total">
        <td colspan="4"></td>
        <td colspan="1"><b>Total Pound</b></td>
        <td>{{number_format(2.20462 * $total_net ,2)}} kg</td>
    </tr>
   <tr class="total">
        <td colspan="4"></td>
        <td colspan="1"><b>Total Amount</b></td>
        <td>{{number_format($purchases->purchase_amount,2)}}  {{$purchases->exchange_code}}</td>
    </tr>

    <tr class="total">
         <td colspan="4"></td>
        <td colspan="1"><div>.<</div></td>
         <td><div></div></td>

     </tr>
    
    
   
    </tfoot>
</table>





 
<table class="clearfix">
    <tr>
        <td style="width: 50%;">
            <div class="left" style="">
        <div><u> <h3><b> Account Details For Us-Dollar</b></h3></u> </div>
        <div><b>Account Name</b>:  GAKI INVESTMENT CO LTD</div>
        <div><b>Account Number</b>:  02J1058283300 </div>
        <div><b>Bank Name</b>: CRDB BANK PLC</div>
        <div><b>Branch</b>: SHINYANGA BRANCH , TANZANIA</div>
        <div><b>Swift Code</b>: CORUTZTZ</div>
        <div></div>
        </div></td>
    </tr>
 <!--
      <tr>
         <td style="width: 50%;">
            <div class="right" style="">
        <div><u>  <h3><b>Account Details For Tanzania Shillings</b></h3></u> </div>
         <div><b>Account Name</b>:  Isumba Trans Ltd</div>
        <div><b>Account Number</b>:  10201632005 </div>
        <div><b>Bank Name</b>: Bank of Africa</div>
        <div><b>Branch</b>: Business Centre</div>
        <div><b>Swift Code</b>: EUAFTZ TZ</div>
          </div>     
        </td></tr>
!-->
</table>


<footer>
ALL CORRESPONDENCES SHOULD BE ADDRESSED TO THE MANAGING DIRECTOR
</footer>
</body>
</html>
