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
    .mt-50{
        margin-top:50px;
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
       background-color: #2F75B5;
        font-size:14px;
      color:white;
    }
    table tr td{
        font-size:12px;
    }
    table{
        border-collapse:collapse;
    }
table tbody tr:nth-of-type(odd) {
    background-color: rgba(0,0,0,.07);
}
table tbody tr {
    background-color: #ffffff;
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

?>

<div class="add-detail ">
   <table class="table w-100 ">
<tfoot>
       
        <tr>
            <td class="w-50">
                <div class="box-text">
                    <center><img class="pl-lg" style="width: 133px;height:120px;" src="{{url('public/assets/img/logo')}}/{{$settings->picture}}"> 
                   <p><strong> {{$settings->name}}</strong></p>
                     </center>
                </div>
            </td>
  
                  
        </tr>
</tfoot>
    </table>


    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
<tfoot>
 <td class="w-50">
                <div class="box-text">

                    <center><b>   {{ strtoupper($class) }} Fee Report for the Year {{$year}}</b> </center>
                </div>
        <td>
          
        </tr>

</tfoot>
    </table>
</div>



<?php
$total_amount=0;
$total_discount=0;
$total_due=0;
?>
<div class="table-section bill-tbl w-100 mt-50">
    <table class="table  w-100 mt-50" >
                     <thead>
                        <tr>
                           
                                             <th>#</th>
                                               <th>Name</th>
                                                 <th >Fee Price</th>
                                                <th >Discount</th>
                                          <th >Paid Amount</th>
                                                 <th >Due Amount</th>
                                                
                      
                        </tr>
                        </thead>
                        <tbody>


                        @foreach($data as $row)
                        
                            <tr>
                    <td>{{ $loop->iteration }}</td>
                      <td>{{$row->student_name}} </td>
                        <td>{{number_format($row->fee,2)}} </td>
                        <td>{{number_format($row->discount,2)}} </td>
                      <td>{{number_format(($row->fee-$row->discount) - $row->due_fee,2)}} </td>
                          <td>{{number_format($row->due_fee,2)}} </td>
                                                  
                                                                                          
                            </tr>
                        
                        <?php
$total_amount+=$row->fee;
$total_discount+=$row->discount;
$total_due+=$row->due_fee;
?>
                        @endforeach

                 
                        </tbody>
                        <tfoot>
 <tr>
                                
                      <td></td><td>Total</td>
                     <td>{{number_format($total_amount,2)}}</td>
                       <td>{{number_format($total_discount,2)}}</td>
                     <td>{{number_format(($total_amount-$total_discount) - $total_due,2)}} </td>
                     <td>{{number_format($total_due,2)}}</td>                     
                       
                                                                        
                            </tr>
                        
</tfoot>

    </table>




</div>

<br><br>
<!--
<table class="table w-100 mt-10">
<tr>
         <td style="width: 50%;">
        
            <div class="left" style="">
        <div><u>  <h3><b>BANK DETAILS (USD)</b></h3></u> </div>
         <div><b>Account Name</b>:  DALASHO ENTERPRISES LIMITED</div>
        <div><b>Account Number</b>:  0252386968400</div>
        <div><b>Bank Name</b>: CRDB BANK</div>
        <div><b>Branch</b>: NZEGA BRANCH</div>
        <div><b>Swift Code</b>: Corutztz</div>
          </div> 
</td>
          
      <td style="width: 50%;">
 
          <div class="left" style="">
       <div><u>  <h3><b>BANK DETAILS (TSH)</b></h3></u> </div>
         <div><b>Account Name</b>:  DALASHO ENTERPRISES LIMITED</div>
        <div><b>Account Number</b>:  0150386968400</div>
        <div><b>Bank Name</b>: CRDB BANK PLC</div>
        <div><b>Branch</b>: OSTERBAY BRANCH</div>
        <div><b>Swift Code</b>: Corutztz</div>
          </div> 
          
        </tr>


      
</table>
-->


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