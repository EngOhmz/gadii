<!DOCTYPE html>
<html>
<head>
    <title>Larave Generate Invoice PDF</title>
</head>
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
   
    .w-85{
        width:85%;   
    }
    .w-15{
        width:15%;   
    }
    .logo img{
        width:45px;
        height:45px;
        padding-top:30px;
    }
    .logo span{
        margin-left:8px;
        top:19px;
        position: absolute;
        font-weight: bold;
        font-size:25px;
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tbody tr, table thead th, table tbody td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:30px;
    }
footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: -20px;
            border-top: 1px solid #aaaaaa;
            padding: 8px 0;
            text-align: center;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }
 table tfoot tr td {
  padding:7px 8px;
        }


        table tfoot tr td:first-child {
            border: none;
        }

</style>
<body>
 <?php
$settings= App\Models\Setting::first();

?>
<div class="head-title">
    <h1 class="text-center m-0 p-0">Profoma Invoice</h1>
</div>
<div class="add-detail ">
    <table class="table w-100 ">
 <tfoot>
        
         <tr>
             <td class="w-50">
                 <div class="box-text">
                         <img class="pl-lg" style="width: 133px;height:120px;" src="{{url('images')}}/{{$settings->site_logo}}">
                 </div>
             </td>
   
                   <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td>
                  
             <td class="w-50">
                 <div class="box-text">
                    <p> <strong>Reference: {{$invoices->reference_no}}</strong></p>
       <p> <strong>Invoice Date : {{Carbon\Carbon::parse($invoices->invoice_date)->format('d/m/Y')}}</strong></p>
                 </div>
             </td>
         </tr>
 </tfoot>
     </table>
 
 
     <div style="clear: both;"></div>
 </div>


<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
<tbody>
        <tr>
            <th class="w-50">Our Info</th>
            <th class="w-50">Client Details</th>
        </tr>
        <tr>
            <td>
                <div class="box-text">
                    <p>{{$settings->site_name}}</p>
                    <p>{{ $settings->site_address }}</p>               
                    <p>Contact :{{  $settings->site_phone_number}}</p>
                 <p>Email: <a href="mailto:{{$settings->site_email}}">{{$settings->site_email}}</p>
                    <p>TIN : {{$settings->tin}}</p>
                </div>
            </td>
            <td>
                <div class="box-text">
                    <p>{{$invoices->client->name}}</p>
                    <p>{{$invoices->client->address}}</p>
                     <p>Contact : {{$invoices->client->phone}}</p>
                 <p>Email: <a href="mailto:{{$invoices->client->email}}">{{$invoices->client->email}}</p>
                    <p>TIN : {{!empty($invoices->client->TIN)? $invoices->client->TIN : ''}}</p>
                </div>
            </td>
        </tr>
</tbody>
    </table>
</div>
<!--
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Payment Method</th>
            <th class="w-50">Shipping Method</th>
        </tr>
        <tr>
            <td>Cash On Delivery</td>
            <td>Free Shipping - Free Shipping</td>
        </tr>
    </table>
</div>
-->

<?php
                               
                                 $sub_total = 0;
                                 $gland_total = 0;
                                 $tax=0;
                                 $i =1;
       
                                 ?>

<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
<thead>
        <tr>
            <th class="col-sm-1 w-50">#</th>
            <th class=" col-sm-2 w-50" >Items</th>
            <th class="w-50">Price</th>
            <th class="w-50">Qty</th>
            <th class="w-50">Tax</th>
            <th class="w-50">Total</th>
        </tr>
</thead>
        <tbody>
             @if(!empty($invoice_items))
                                        @foreach($invoice_items as $row)
                                        <?php
                                         $sub_total +=$row->total_cost;
                                         $gland_total +=$row->total_cost +$row->total_tax;
                                         $tax += $row->total_tax; 
                                         ?>

            <tr align="center">
                <td>{{$i++}}</td>
                 <?php
                                             $item_name = App\Models\POS\Items::find($row->item_name);
                                        ?>
                <td> {{$item_name->name}}   </td>
             <td >{{number_format($row->price ,2)}}</td>               
                <td >{{ $row->quantity }}</td>   
                <td>  {{number_format($row->total_tax ,2)}} {{$invoices->exchange_code}}</td>                           
                <td >{{number_format($row->total_cost ,2)}} {{$invoices->exchange_code}}</td>
                
            </tr>
           @endforeach
                                        @endif
       </tbody>

  <tfoot>
<tr>
            <td colspan="4">  </td>
                <td> </td>
               <td></td> 
            </td>
        </tr>
  <tr>
       <tr>
            <td colspan="4">  </td>
                <td> <b> Sub Total</b></td>
               <td>{{number_format($sub_total,2)}}  {{$invoices->exchange_code}}</td> 
            </td>
        </tr>
  <tr>
            <td colspan="4">  </td>
                <td><b>  VAT  (18%)</b></td>
               <td>{{number_format($tax,2)}}  {{$invoices->exchange_code}}</td> 
            </td>
        </tr>

  <tr>
            <td colspan="4">  </td>
                <td><b>  Total Amount</b></td>
               <td>{{number_format($gland_total,2)}}  {{$invoices->exchange_code}}</td> 
            </td>
        </tr>
  </tfoot>
    </table>

  <table class="table w-100 mt-10">
<tr>
         <td style="width: 50%;">
            <div class="left" style="">
        <div><u>  <h3><b>BANK DETAILS</b></h3></u> </div>
         <div><b>Account Name</b>:  DALASHO ENTERPRISES LIMITED</div>
        <div><b>Account Number</b>:  0150386968400 </div>
        <div><b>Bank Name</b>: CRDB BANK</div>
        <div><b>Branch</b>: OYSTERBAY BRANCH</div>
        <div><b>Swift Code</b>: Corutztz</div>
          </div>     
        </tr>
<!--
    <tr>
        <td style="width: 50%;">
            <div class="right" style="">
        <div><u> <h3><b> Account Details For Us-Dollar</b></h3></u> </div>
        <div><b>Account Name</b>:  Isumba Trans Ltd</div>
        <div><b>Account Number</b>:  10201632013 </div>
        <div><b>Bank Name</b>: Bank of Africa</div>
        <div><b>Branch</b>: Business Centre</div>
        <div><b>Swift Code</b>: EUAFTZ TZ</div>
        <div></div>
        </div></td>
    </tr>
-->

      
</table>


</div>

<footer>
This is a computer generated invoice
</footer>
</body>
</html>