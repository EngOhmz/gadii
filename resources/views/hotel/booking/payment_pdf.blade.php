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
$items=App\Models\SystemDetails::where('system_id',$settings->id)->get();
?>
<div class="head-title">
    <h1 class="text-center m-0 p-0 head"><img class="pl-lg" style="width: 133px;height: 120px;" src="{{url('assets/img/logo')}}/{{$settings->picture}}"> </h1>
    <h4 class="text-center m-0 p-0 head">{{$settings->name}}</h4><br>
     <p class="text-center  margin"> {{ $settings->address }}  </p>
      <p class="text-center  margin"> Phone: {{ $settings->phone}}</p>
      <p class="text-center margin ">E: <a href="mailto:{{$settings->email}}">{{$settings->email}}</a></p>
       <p class="text-center margin "> TIN: {{$settings->tin}}</p>

 <h1 class="text-center m-0 p-0">Order Sales Payments</h1>
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
          
 
            <td>
                <div class="box-text">
                <p>Order Reference : {{$invoice->reference_no}}</p>
                   
               
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
            <th class="col-sm-1 w-50">Transaction ID</th>
        <th class="col-sm-1 w-50">Payment Date</th>
            <th class=" col-sm-2 w-50" >Amount</th>
            <th class="w-50">Payment Mode</th>
                <th class="col-sm-2 w-50">Payment Account</th>
        </tr>
</thead>
        <tbody>
          

            <tr align="center">

    <?php
$method= App\Models\Payment_methodes::find($data->payment_method);


?>
                <td class=""> {{$data->trans_id}}</td>
                                               <td class="">{{Carbon\Carbon::parse($data->date)->format('d/m/Y')}}  </td>
                                            <td class="">{{ number_format($data->amount ,2)}} {{$invoice->currency_code}}</td>
                                            <td class="">{{ $method->name }}</td>
                                          <td class="">{{ $data->payment->account_name }}</td>
            </tr>
          
       </tbody>

  <tfoot>
 
    </table>

<br><br><br><br>
<table class="table w-100 mt-10">
<tfoot>
<tr>
         <td style="width: 30%;">
            <div class="left" style="">
        <div>........................................................</div>
         <div><b> PREPARED BY {{strtoupper($data->user->name)}}</div>        
          </div>  </td>


     <td style="width: 30%;">
            <div class="left" style="">
        <div></div>
        <div></div>
        
        </div></td>

     <td style="width: 40%;">
            <div class="right" style="">
        <div><b>DATE  :  {{Carbon\Carbon::parse($data->date)->format('d/m/Y')}}</b></div>
        
        </div></td>

    </tr>


</tfoot>      
</table>

<br><br>
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



<div class="table-section bill-tbl w-100 mt-10">
<p></p><br>

</div>
<br>
</div>

<footer>
This is a computer generated invoice
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