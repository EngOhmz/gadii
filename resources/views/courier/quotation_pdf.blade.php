<!DOCTYPE html>
<html>
<head>
    <title>Courier Quotation PDF </title>
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
      .float-right{
        float:right;
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
$items=App\Models\SystemDetails::where('system_id',$settings->id)->get();
?>
<div class="head-title">
    <h2 class="text-center m-0 p-0">Customer Quotation</h1>
</div>


<div class="add-detail ">
   <table class="table w-100 ">
<tfoot>
       
        <tr>
            <td class="w-50">
                <div class="box-text">
                        <img class="pl-lg" style="width: 133px;height:120px;" src="{{url('assets/img/logo')}}/{{$settings->picture}}">
                </div>
            </td>
  
                  <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td>
                 
            <td class="w-50">
                <div class="box-text">
                   <p> <strong>Quotation : {{$purchases->confirmation_number}}</strong></p>
      <p> <strong>Quotation Date : {{Carbon\Carbon::parse($purchases->date)->format('d/m/Y')}}</strong></p>
                </div>
            </td>
        </tr>
</tfoot>
    </table>

</div>


<div class="table-section bill-tbl w-100 ">
    <table class="table w-100">
<tbody>
        <tr>
            <th class="w-50">From</th>
            <th class="w-50">To</th>
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
             <th class="col-sm-1 w-50">Waybill No</th>
            <th class=" col-sm-2 w-50" >Tariff</th>
              <th class=" col-sm-2 w-50" >Route</th>
            <th class="w-50">Price</th>
             <th class="w-50">Unit</th>
            <th class="w-50">Tax</th>
            <th class="w-50">Total</th>
        </tr>
</thead>
        <tbody>
             @if(!empty($purchase_items))
                                        @foreach($purchase_items as $row)
                                        <?php
                                         $sub_total +=$row->total_cost;
                                         $gland_total +=$row->total_cost +$row->total_tax;
                                         $tax += $row->total_tax; 
                                         ?>

            <tr align="center">
                <td>{{$i++}}</td>
                    <td class=""> {{$row->wbn_no}}</td>
                 <?php
                                        $item_name = App\Models\Tariff::find($row->item_name);
                                        ?>
                <td> @if(!empty($item_name)) {{$item_name->zone_name}} - {{$item_name->weight}}  @else {{$row->item_name }} @endif </td>
   <td class="">{{ $purchases->from->name }} -  {{ $row->to->name }}</td>
             <td >{{number_format($row->price ,2)}}</td>               
               <td class="">{{ $row->unit }} </td> 
                <td>  {{number_format($row->total_tax ,2)}} </td>                           
                <td >{{number_format($row->total_cost ,2)}} </td>
                
            </tr>
           @endforeach
                                        @endif
       </tbody>

  <tfoot>
<tr>
            <td colspan="6">  </td>
                <td> </td>
               <td></td> 
            </td>
        </tr>
  <tr>
       <tr>
            <td colspan="6">  </td>
                <td> <b> Sub Total</b></td>
               <td>{{number_format($sub_total,2)}}  {{$purchases->currency_code}}</td> 
            </td>
        </tr>
  <tr>
            <td colspan="6">  </td>
                <td><b>  VAT  (18%)</b></td>
               <td>{{number_format($tax,2)}}  {{$purchases->currency_code}}</td> 
            </td>
        </tr>

  <tr>
            <td colspan="6">  </td>
                <td><b>  Total Amount</b></td>
               <td>{{number_format($gland_total,2)}}  {{$purchases->currency_code}}</td> 
            </td>
        </tr>
  </tfoot>
    </table>

<br><br><br>




  <table class="table w-100 mt-20" >
<tfoot>
@if(!empty($items))
@foreach ($items->chunk(2) as $chunk)
<tr>
  @foreach ($chunk as $i)
<?php
$word_curr= App\Models\Currency::where('code',$i->exchange_code)->first();
?>


         <td style="width: 50%;">

         <div><u> <h3><b> Account Details For {{$word_curr->name}}</b></h3></u> </div>
         <div><b>Account Name</b>:   {{$i->account_name}}</div>
        <div><b>Account Number</b>:   {{$i->account_number}} </div>
        <div><b>Bank Name</b>:  {{$i->bank_name}}</div>
        <div><b>Branch</b>:  {{$i->branch_name}}</div>
        <div><b>Swift Code</b>:  {{$i->swift_code}}</div>
         
 @endforeach
</tr>  
 @endforeach
@endif

       
    

</tfoot>
      
</table>
</div>

<footer>
This is a computer generated Quotation
</footer>
</body>
</html>