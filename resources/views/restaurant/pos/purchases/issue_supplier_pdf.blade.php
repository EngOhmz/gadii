<!DOCTYPE html>
<html>
<head>
    <title>DOWNLOAD PDF</title>
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
$settings= App\Models\System::where('added_by',auth()->user()->added_by)->first();

?>
<div class="head-title">
    <h1 class="text-center m-0 p-0">Issued Purchase</h1>
</div>


<div class="add-detail ">
    <table class="table w-100 ">
 <tfoot>
        
         <tr>
             <td class="w-50">
                 <div class="box-text">
                        <img class="pl-lg" style="width: 133px;height: 120px;" src="{{url('assets/img/logo')}}/{{$settings->picture}}">
                 </div>
             </td>
   
                   <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td>
                  
             <td class="w-50">
                 <div class="box-text">
                    <p> <strong>Reference: {{$purchases->reference_no}}</strong></p>
       <p> <strong>Purchase Date : {{Carbon\Carbon::parse($purchases->purchase_date)->format('d/m/Y')}}</strong></p>
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
            <th class="w-50">Supplier Details</th>
        </tr>
        <tr>
            <td>
                <div class="box-text">
                    <p>{{$settings->name}}</p>
                    <p>{{ $settings->address }}</p>               
                    <p>Contact :{{  $settings->phone}}</p>
                 <p>Email: <a href="mailto:{{$settings->email}}">{{$settings->email}}</p>
                    <p>TIN : {{$settings->tin}}</p>
                </div>
            </td>
            <td>
                <div class="box-text">
                    <p>{{$purchases->supplier->name}}</p>
                    <p>{{$purchases->supplier->address}}</p>
                     <p>Contact : {{$purchases->supplier->phone}}</p>
                 <p>Email: <a href="mailto:{{$purchases->supplier->email}}">{{$purchases->supplier->email}}</p>
                    <p>TIN : {{!empty($purchases->supplier->TIN)? $purchases->supplier->TIN : ''}}</p>
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
            <th class="w-50">Qty</th>

        </tr>
</thead>
        <tbody>
             @if(!empty($purchase_items))
                                        @foreach($purchase_items as $row)
                                        <?php
                                         $sub_total +=$row->total_cost;
                                         $gland_total +=$row->total_cost +$row->total_tax;
                                         $tax += $row->total_tax; 


                           $due=App\Models\Restaurant\POS\PurchaseHistory::where('purchase_id',$row->purchase_id)->where('item_id',$row->item_name)->where('type', 'Purchases')->sum('quantity');
                            $return=App\Models\Restaurant\POS\PurchaseHistory::where('purchase_id',$row->purchase_id)->where('item_id',$row->item_name)->where('type', 'Debit Note')->sum('quantity');
                             $qty=$due-$return;
                                         ?>

            <tr align="center">
                <td>{{$i++}}</td>
                 <?php
                                             $item_name = App\Models\Restaurant\POS\Items::find($row->item_name);
                                        ?>
                <td> {{$item_name->name}}   </td>             
                <td >{{ $qty }}</td>   

                
            </tr>
           @endforeach
                                        @endif
       </tbody>

  
    </table>

<br><br><br><br>
@if(!empty($purchases->approval_1))
<table class="table w-100 mt-10">
<tfoot>

<tr>
         <td style="width: 30%;">
            <div class="left" style="">
        <div>........................................................</div>
         <div><b> PREPARED BY {{strtoupper($purchases->user->name)}}</div>        
          </div>  </td> 


     <td style="width: 30%;">
            <div class="left" style="">
        <div></div>
        <div></div>
        
        </div></td>

     <td style="width: 40%;">
            <div class="right" style="">
        <div><b>DATE  :  {{Carbon\Carbon::parse($purchases->purchase_date)->format('d/m/Y')}}</b></div>
        
        </div></td>

    </tr>

@if(!empty($purchases->approval_2))
<tr>
         <td style="width: 30%;">
            <div class="left" style="">
        <div>........................................................</div>
         <div><b> CHECKED BY  {{strtoupper($purchases->second->name)}}</div>        
          </div>  </td> 

<td style="width: 30%;">
            <div class="left" style="">
        <div></div>
        <div></div>
        
        </div></td>

     <td style="width: 40%;">
            <div class="right" style="">
        <div><b>DATE  :  {{Carbon\Carbon::parse($purchases->approval_2_date)->format('d/m/Y')}}</b></div>
        
        </div></td>

    </tr>
@endif

@if(!empty($purchases->approval_3))

<tr>
         <td style="width: 30%;">
            <div class="left" style="">
        <div>........................................................</div>
         <div><b>APPROVED BY  {{strtoupper($purchases->third->name)}}</div>        
          </div>  

<td style="width: 30%;">
            <div class="left" style="">
        <div></div>
        <div></div>
        
        </div></td>

     <td style="width: 40%;">
            <div class="right" style="">
        <div><b>DATE  :  {{Carbon\Carbon::parse($purchases->approval_3_date)->format('d/m/Y')}}</b></div>
        
        </div></td>

    </tr>

@endif
</tfoot>      
</table>

@endif


<!--
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


      
</table>

-->


</div>

<footer>
This is a computer generated invoice
</footer>
</body>
</html>