<!DOCTYPE html>
<html>
<head>
    <title>Download PDF </title>
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
             font-size: 11px;
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
$settings= App\Models\System::where('added_by',auth()->user()->added_by)->first();
$items=App\Models\SystemDetails::where('system_id',$settings->id)->get();

?>
<div class="head-title">
    <h1 class="text-center m-0 p-0">Stock Movement</h1>
</div>
<div class="add-detail ">
    <table class="table w-100 ">
 <tfoot>
        
         <tr>
             <td class="w-50">
                 <div class="box-text">
                        <img class="pl-lg" style="width: 233px;height: 120px;" src="{{url('public/assets/img/logo')}}/{{$settings->picture}}">
                 </div>
             </td>
   
                   <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td>
                  
             <td class="w-50">
                 <div class="box-text">
                    <p> <strong>Reference: {{$invoices->name}}</strong></p>
       <p> <strong>Date : {{Carbon\Carbon::parse($invoices->movement_date)->format('d/m/Y')}}</strong></p>
                 </div>
             </td>
         </tr>
 </tfoot>
     </table>
 
 
     <div style="clear: both;"></div>
 </div>

<br>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
<tfoot>
        
        <tr>
            <td>Source Location : </td>
            <td>@if(!empty($invoices->source->name)) {{$invoices->source->name}} @endif</td>
            </tr>
            
             <tr>
            <td>Destination Location : </td>
            <td>@if(!empty($invoices->destination->name)) {{$invoices->destination->name}}</td>
            </tr>
            

</tfoot>
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

                                 $i =1;
                                $total=0;
                                 ?>

<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
<thead>
        <tr>
            <th class="col-sm-1 w-50">#</th>
            <th class=" col-sm-2 w-50" >Items</th>
            <th class="w-50">Qty</th>
        </tr>
</thead>
        <tbody>
             @if(!empty($invoice_items))
                                        @foreach($invoice_items as $row)
                                       
                                        <tr align="center">
                                        <td>{{$i++}}</td>
                                       <td> {{$row->item->name}}</td>
                                        <td >{{number_format($row->quantity,2)}}</td>   
                
                                        </tr>
                                        
                                        <?php
                                        $total+=$row->quantity;
                                        ?>
                                       @endforeach
                                        @endif
                                   </tbody>

  <tfoot>
<tr>

                <td> </td>
               <td></td> 
            <td></td>
        </tr>
  <tr>
       <tr>
            <td colspan="">  </td>
                <td> <b>Total</b></td>
               <td>{{number_format($total,2)}} </td> 
            </td>
        </tr>
  


@endif
  </tfoot>
    </table>

 
 
  <br><br><br><br>
<table class="table w-100 mt-10">
<tfoot>
<tr>
         <td style="width: 50%;">
            <div class="left" style="">
         <div><b>ISSUED BY </div> 
         <div>{{$invoices->approve->name}}</div>
          </div>  </td>

            <td style="width: 50%;">
            <div class="right" style="">
        <div>............................................................... </div>
        <div><b>SIGNATURE</b></div></td>

</tr>



<tr>
         <td style="width: 50%;">
            <div class="left" style="">
         <div><b>RECEIVED BY </div> 
          <div>........................................................</div>
          </div>  </td>

            <td style="width: 50%;">
            <div class="right" style="">
        <div>............................................................... </div>
        <div><b>SIGNATURE</b></div></td>

</tr>

  </tfoot>    
</table>


</div>

<footer>
 {{$settings->name}} , {{ $settings->address }}
      <br> Phone: {{$settings->phone}}
     @if(!empty($settings->email)) <br>Email: <a href="mailto:{{$settings->email}}">{{$settings->email}}</a> @endif
</footer>
</body>
</html>