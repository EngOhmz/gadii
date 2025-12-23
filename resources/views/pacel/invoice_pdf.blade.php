<!DOCTYPE html>
<html>
<head>
    <title>Larave Generate Invoice PDF - Nicesnippest.com</title>
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
            position: fixed;
            bottom: 0;
              margin-top:30px;
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
 <!-- Define header and footer blocks before your content -->


  <!-- Wrap the content of your PDF inside a main tag -->
 <?php
$settings= App\Models\System::where('added_by',auth()->user()->added_by)->first();
$items=App\Models\SystemDetails::where('system_id',$settings->id)->get();

?>
<div class="head-title">
    <h1 class="text-center m-0 p-0">Cargo Invoice</h1>
</div>
<div class="add-detail ">
   <table class="table w-100 ">
<tfoot>
       
        <tr>
            <td class="w-50">
                <div class="box-text">
                        <img class="pl-lg" style="width: 133px;height:120px;" src="{{url('public/assets/img/logo')}}/{{$settings->picture}}">
                </div>
            </td>
  
                  <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td> <td><div class="box-text">  </div>  </td>
                 
            <td class="w-50">
                <div class="box-text">
                   <p> <strong>Invoice : {{$purchases->confirmation_number}}</strong></p>
      <p> <strong>Invoice Date : {{Carbon\Carbon::parse($purchases->date)->format('d/m/Y')}}</strong></p>
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
            <th class=" col-sm-2 w-50" >Route Name</th>
          <!-- <th class="col-sm-1 w-50">Charge Type</th>-->
              <th class="col-sm-1 w-50">Truck</th>
            <th class="w-50">Price</th>
            <th class="w-50">Qty</th>
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
                 <?php
                                          //$item_name = App\Models\Pacel\PacelList::find($row->item_name);
                          $item_name = App\Models\Route::find($row->item_name);
                          $cargo = App\Models\CargoLoading::where('item_id',$row->items_id)->first();
                          $word_curr= App\Models\Currency::where('code',$purchases->currency_code)->first();
                                        ?>
                <td> {{$item_name->from}}  -  {{$item_name->to}}
              @if(!empty($row->items_id))
 ({{date("d/m/Y", strtotime($cargo->collection_date))}})
                     @else
    ({{date("d/m/Y", strtotime($row->created_at))}})     
                          @endif
                   @if(!empty($row->end))
                   <!-- <br>Arrival Location/Address - {{$row->end}} -->
                      @endif
                </td>
            <!--<td>{{ $row->charge_type }} </td>-->
                 <td >{{ $row->truck->reg_no }} </td>
             <td >{{number_format($row->price ,2)}}</td>               
                <td >{{ $row->quantity }}</td>
   
                <td>  {{number_format($row->total_tax ,2)}} {{$purchases->currency_code}}</td>                           
                <td >{{number_format($row->total_cost ,2)}} {{$purchases->currency_code}}</td>
                
            </tr>
           @endforeach
                                        @endif
       </tbody>

  <tfoot>
<tr>
            <td colspan="5"></td>
                <td> </td>
               <td></td> 
            </td>
        </tr>
  <tr>
       <tr>
            <td colspan="5">  </td>
                <td> <b> Sub Total</b></td>
               <td>{{number_format($sub_total,2)}}  {{$purchases->currency_code}}</td> 
            </td>
        </tr>
  <tr>
           
           {{-- <td colspan="5"> {{convertNumberToWordsForIndia($gland_total)}}   {{$word_curr->name}}   </td> --}}
           <td colspan="5">  </td>
                <td><b>  VAT  (18%)</b></td>
               <td>{{number_format($tax,2)}}  {{$purchases->currency_code}}</td> 
            </td>
        </tr>

  <tr>
            <td colspan="5">  </td>
                <td><b>  Total Amount</b></td>
               <td>{{number_format($gland_total,2)}}  {{$purchases->currency_code}}</td> 
            </td>
        </tr>



        <tr>
            <td colspan="5"> <h3><b>Authorized Signature .......................</b></h3>  </td>
                
               <td colspan="6" ></td> 
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


</body>
</html>

<?php

   function convertNumberToWordsForIndia($number){
    //A function to convert numbers into Indian readable words with Cores, Lakhs and Thousands.
    $words = array(
    '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five',
    '6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten',
    '11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen',
    '16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty',
    '30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy',
    '80' => 'eighty','90' => 'ninty');
    
    //First find the length of the number
    $number_length = strlen($number);
    //Initialize an empty array
    $number_array = array(0,0,0,0,0,0,0,0,0);        
    $received_number_array = array();
    
    //Store all received numbers into an array
    for($i=0;$i<$number_length;$i++){    
  		$received_number_array[$i] = substr($number,$i,1);    
  	}

    //Populate the empty array with the numbers received - most critical operation
    for($i=9-$number_length,$j=0;$i<9;$i++,$j++){ 
        $number_array[$i] = $received_number_array[$j]; 
    }

    $number_to_words_string = "";
    //Finding out whether it is teen ? and then multiply by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
    for($i=0,$j=1;$i<9;$i++,$j++){
        //"01,23,45,6,78"
        //"00,10,06,7,42"
        //"00,01,90,0,00"
        if($i==0 || $i==2 || $i==4 || $i==7){
            if($number_array[$j]==0 || $number_array[$i] == "1"){
                $number_array[$j] = intval($number_array[$i])*10+$number_array[$j];
                $number_array[$i] = 0;
            }
               
        }
    }

    $value = "";
    for($i=0;$i<9;$i++){
        if($i==0 || $i==2 || $i==4 || $i==7){    
            $value = $number_array[$i]*10; 
        }
        else{ 
            $value = $number_array[$i];    
        }            
        if($value!=0)         {    $number_to_words_string.= $words["$value"]." "; }
        if($i==1 && $value!=0){    $number_to_words_string.= "Crores "; }
        if($i==3 && $value!=0){    $number_to_words_string.= "Lakhs ";    }
        if($i==5 && $value!=0){    $number_to_words_string.= "Thousand "; }
        if($i==6 && $value!=0){    $number_to_words_string.= "Hundred  "; }            

    }
    if($number_length>9){ $number_to_words_string = "Sorry This does not support more than 99 Crores"; }
    return ucwords(strtolower("".$number_to_words_string));
}


?>