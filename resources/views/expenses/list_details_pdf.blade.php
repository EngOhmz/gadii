<!DOCTYPE html>
<html>
<head>
    <title>PAYMENTS</title>
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
        
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
      
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
            
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: -20px;
            border-top: 1px solid #aaaaaa;
            padding: 8px 0;
            text-align: center;
        }
.head{
            font-size: 15px;
        }
.margin{
            margin-top: -1%;
            font-size: 10px;
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
   <h1 class="text-center m-0 p-0 head"><img class="pl-lg" style="width: 120px;height: 120px;" src="{{url('public/assets/img/logo')}}/{{$settings->picture}}"> </h1><br>
    <h4 class="text-center m-0 p-0 head">{{$settings->name}}</h4><br>
     <p class="text-center  margin">{{ $settings->address }}</p>
      <p class="text-center  margin"> Phone: {{  $settings->phone}}</p>
      <p class="text-center margin ">E: {{$settings->email}}</p>
       <p class="text-center margin "> TIN: {{$settings->tin}}</p>

 <h1 class="text-center m-0 p-0">Payments</h1>
</div>
<div class="add-detail ">
   <table class="table w-100 ">
<tfoot>

</tfoot>
    </table>


    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
<tbody>
       
        <tr>
          
  @php
                                                 $bank=App\Models\AccountCodes::where('id',$expenses->bank_id)->first();
                                                @endphp
            <td>
                <div class="box-text">
                <p>Reference : {{$expenses->name}}</p>
                    <p>Date Requested : {{Carbon\Carbon::parse($expenses->date)->format('d/m/Y')}}</p>
                     <p>Paid Through : {{$bank->account_name}}</p>
               
                </div>
            </td>
        </tr>
</tbody>
    </table>
</div>
<hr>
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
                               
                         
                                 $gland_total = 0;
                                 
                           
                                 $i =1;
       
                                 ?>

<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
<thead>
        <tr>
            <th class="col-sm-1 w-50">#</th>
        <th class="col-sm-1 w-50">Account</th>
            <th class=" col-sm-2 w-50" >Description</th>
            <th class="w-50">Total</th>
        </tr>
</thead>
        <tbody>
             @if(!empty($items))
                                        @foreach($items as $row)
                                        <?php
                                         $gland_total +=$row->amount;
                                       
                                         ?>

            <tr align="center">
                <td>{{$i++}}</td>
                 <?php
                                             $item_name = App\Models\AccountCodes::where('id',$row->account_id)->first();
                                        ?>
                <td> {{$item_name->account_name}} </td>
  
                     <td> {{$row->notes}}</td>
                        

             <td >{{number_format($row->amount ,2)}}</td>               
                
                
            </tr>
           @endforeach
                                        @endif
       </tbody>

  <tfoot>
 <tr>
            <td></td> 
                <td></td>
               <td> </td> 
             <td> </td> 
        </tr>
     
 <tr>
            <td></td> 
                <td></td>
               <td> </td> 
             <td> </td> 
        </tr>  

  <tr>
            <td></td>  <td> </td> 
                <td><b>  Total Amount</b></td>
               <td><b>{{number_format($gland_total,2)}}<b> </td> 
            
        </tr>
  </tfoot>
    </table>

<br><br><br><br>
<table class="table w-100 mt-10">
<tr>
         <td style="width: 50%;">
            <div class="left" style="">
        <div>........................................................</div>
         <div><b>Prepared By</div>        
          </div>  

     <td style="width: 50%;">
            <div class="right" style="">
        <div>............................................................... </div>
        <div><b>Date</b></div>
        
        </div></td>
    </tr>

<tr>
         <td style="width: 50%;">
            <div class="left" style="">
        <div>........................................................</div>
         <div><b>Reviewed By</div>        
          </div>  

     <td style="width: 50%;">
            <div class="right" style="">
        <div>............................................................... </div>
        <div><b>Date</b></div>
        
        </div></td>
    </tr>
<tr>
         <td style="width: 50%;">
            <div class="left" style="">
        <div>........................................................</div>
         <div><b>Approved By</div>        
          </div>  

     <td style="width: 50%;">
            <div class="right" style="">
        <div>............................................................... </div>
        <div><b>Date</b></div>
        
        </div></td>
    </tr>
      
</table>


<!--
  <table class="" align="center">
<tr>
         <td style="width: 100%;">
            <div class="" style="">
        <div> <h5>1.Payments through Supplier Account</h5></div>
         <div><b>Bank</b>:  CRDB BANK PLC</div>
          <div><b>Branch</b>: PUGU ROAD BRANCH</div>
        <div><b>Account Number</b>:  0150443650900 </div>
        <div><b>Swift Code</b>: CORUTZTZ</div>
          </div>     
        </tr>

    <tr>
        <td colspan="">
            <div class="" style="">
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

<div class="table-section bill-tbl w-100 mt-10">
<p></p><br>

</div>
<br>
</div>

<footer>
<h3>Payments Vocher</h3>
</footer>
<script type="text/php">
    if ( isset($pdf) ) {
        $x = 35;
        $y = 820;
        $text = "Generated from Fléx CRM                                             - - - -    {PAGE_NUM} of {PAGE_COUNT} pages    - - - - ";
        $font = null;
        $size = 10;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);


     }



</script>
</body>
</html>