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

?>
<div class="head-title">
    <h1 class="text-center m-0 p-0">Good Issue</h1>
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
                    <p> <strong>Reference: {{$purchases->name}}</strong></p>
       <p> <strong>Purchase Date : {{Carbon\Carbon::parse($purchases->date)->format('d/m/Y')}}</strong></p>
                 </div>
             </td>
         </tr>
 </tfoot>
     </table>
 
 
     <div style="clear: both;"></div>
 </div>

<div class="table-section bill-tbl w-100 mt-10">
{{--
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
    --}}
</div>


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
<?php $total_qty=0; ?>
             @if(!empty($purchase_items))
                                        @foreach($purchase_items as $row)
                                        <?php

                              $total_qty += $row->quantity; 
                                         ?>

            <tr align="center">
                <td>{{$i++}}</td>
                 <?php
                $item_name = App\Models\POS\Items::find($row->item_id);
                                        ?>
                <td>@if(!empty($item_name->name)) {{$item_name->name}}  @endif   </td>             
                <td >{{ $row->quantity }}</td>   

                
            </tr>
           @endforeach
                                        @endif
       </tbody>
<tfoot>

  <tr align="center">
                <td></td>
                <td> <b>Total </b>  </td>             
                <td ><b>{{ number_format($total_qty,3) }}</b></td>   

                
            </tr>
</tfoot>
  
    </table>


    
    <br><br><br><br>
<table class="table w-100 mt-10">
<tfoot>
<tr>
         <td style="width: 50%;">
            <div class="left" style="">
         <div><b>ISSUED BY </div> 
         <div>{{$purchases->approve->name}}</div>
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