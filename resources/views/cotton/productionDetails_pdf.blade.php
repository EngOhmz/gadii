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
        text-align: left;
       

        }

        table.items th {
            white-space: nowrap;
            font-weight: normal;
       
        }

        table.items td {
         text-align: left;
        
        }

        table.items td h3 {
            color: #57B223;
            font-size: 1em;
            font-weight: normal;
            margin-top: 2px;
            margin-bottom: 2px;
       
        }

        table.items .no {
            background: #dddddd;
        }

        table.items .desc {
          text-align: left;

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
        <td style="width: 30%;">
            <div id="logo" class="left">
                <img style="width: 170px;height: 80px;float: left !important;" src="{{url('public/assets/img/logo')}}/{{$settings->picture}}">
            </div>
        </td>
        
         <td style="width: 70%;">
            <table cellpadding=0 cellspacing=0 >
                                        <tr>
                                       <td > <h4 class="" style="font-size: 16px;">GAKI INVESTIMENT CO.LTD</h4></td>
                                        </tr>
                                        <tr>
                                       <td > <p class="" style="padding-left: 100px;"><small ><b>GINNERY OIL MILL & RICE MILL , P.O.BOX 707 SHINYANGA</b></small></p>
                                       </td>
                                         </tr>
                                      
                                          <tr>
                                       <td > <p class=""><small ><b>TEL:+255 28 2765022/2765024, FAX +255 28 2765023; MOBILE: +255 767 650806</b></small></p></td>
                                        </tr>
                                        
                                        </table>        
        </td>
        
        
    </tr>
</table>

<table id="details" class="clearfix">
 
    <tr style="margin-top: 0px">
      
        <td style="width: 50%">
            <div style="padding-left: 5px">
              
                 <div class="address"> Weight Note No :</b>{{$data->weight_note}}  </div>
                <div class="address"> Location/Ginnery :</b> {{$data->location}}</div>
                  <?php $client=App\Models\Cotton\CottonClient::find($data->client) ?>
                <div class="address">Client : </b>{{!empty($client)? $client->name : ""}}       </div>
                
            </div>
        </td>

         <td style="width: 50%;">
            <div class="right" style="">

        
        
                <div class="date"><span style="text-align: right"> Date :</b> {{$data->date}}</span></div>             
                <div class="date"><span style="text-align: right">Lot No :</b> {{$data->lot_no}} </span></div>
               <div class="date"> <span style="text-align: right"><b> Total balance Weight :</b>{{$data->bale_weight}} </span></div>
               

    
                
             
            </div>
        
        </td>  
          
         
    </tr>
</table>


<div id="notices">
    <div class="notice"></div>
</div><br><br>

       
                                <?php
                               
                                 $sub_total1 = 0;
                                 $sub_total2 = 0;
                                 $sub_total3 = 0;
                                 $sub_total4 = 0;
                                 $sub_total5 = 0;
                                 $gland_total = 0;
                                 $tax=0;
                                 $i =1;
       
                                 ?>


<table class="items">
    <thead class="p-md bg-items"> <tr>
                        <th style="color:white; text-align:center;"  colspan="10" class="align-centre"><centre>SPECIFICATION FOR 100 BALES FULL PRESSED LIT AR/BR</centre></th>
                      
                    </tr>
        <tr>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Bale</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Kg</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Bale</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Kg</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Bale</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Kg</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Bale</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Kg</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Bale</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Kg</centre></th>
                      
                    </tr>
    </thead>
    <tbody>

                                       <?php
                                     
                                         ?>
                                       <tr>
                                       <?php $i=0; ?>
                                       @foreach($data->productionList as $row)
                                       <?php 
                                       $i++; 
                                       if($i <21)
                                       $sub_total1 += $row->bale;
                                        if($i <41 && $i >20)
                                       $sub_total2 += $row->bale;
                                       if($i <61 && $i >40)
                                       $sub_total3 += $row->bale;
                                        if($i <81 && $i >60)
                                       $sub_total4 += $row->bale;
                                        if($i <101 && $i >80)
                                       $sub_total5 += $row->bale;
                                       ?>
                                       <td>{{$i}}</td>
                                       <td>{{$row->bale}}</td>
                                       
                                       @if(fmod($i, 5) == 0 )
                                       </tr>
                                       <tr>
                                       @elseif($i == count($data->productionList))
                                        </tr>
                                       @endif
                                       
                                       @endforeach
                                      

                                       
    </tbody>

</table>



<table class="clearfix">
<tr>
        <td style="width: 50%;">
            <br><br> <br><br>
        </td>
    </tr>

</table>

  
                                
                              <table class="clearfix">
                              <tr>
                              <td style="width: 50%;">
                              <p class="pull-left">
                    <table style="border:1px;">
                 
                <tr><td><b>Avg Bale weight Gross</b></td><td>{{$data->gross_weight/$i}}</td><td><b>Unit</b></td><td>Kg</td></tr>
                <tr><td><b>Avg Bale weight Net</b></td><td>{{$data->net_weight/$i}}</td><td><b>Unit</b></td><td>Kg</td></tr>
                 <tr><td></td><td>.</td><td></td><td></td></tr>
                <tr><td clospan="1">No of Bales Sampled Nos</td><td>{{$i}}</td><td></td></tr>
                <tr><td></td><td>.</td><td></td><td></td></tr>
                <tr><td clospan="1">Remarks</td><td>..............</td><td></td></tr>
                <tr><td></td><td>.</td><td></td><td></td></tr>
                <tr><td></td><td>.</td><td></td><td></td></tr>
                <tr><td></td><td>.</td><td></td><td></td></tr>
                <tr><td><b>Independent Controller Signature</b></td><td>.................</td><td></td><td></td></tr>
                <tr><td></td><td>.</td><td></td><td></td></tr>
                <tr><td><b>Rubber Stamp</b></td><td>.................</td><td></td><td></td></tr>
              
                
                </table>
                </p>
                </td>
                <td style="width: 50%;">
                
                    <p class="pull-right">
                    <table style="border:1px;">
                 <tr><td colspan="2">RECALCULATION</td></tr>
                <tr><td>1-20</td><td>{{$sub_total1}} Kg</td></tr>
                <tr><td>21-40</td><td>{{$sub_total2}} Kg</td></tr>
                <tr><td>41-60</td><td>{{$sub_total3}} Kg</td></tr>
                <tr><td>61-80</td><td>{{$sub_total4}} Kg</td></tr>
                <tr><td>81-100</td><td>{{$sub_total5}} Kg</td></tr>
                <tr><td>GROSS</td><td>{{$data->gross_weight}} Kg</td></tr>
                <tr><td>TALE</td><td>{{$data->tale}}</td> Kg</tr>
                <tr><td>NET</td><td>{{$data->net_weight}} Kg</td></tr>
                <tr><td></td><td>.</td><td></td><td></td></tr>
                
                
                     <tr><td><b>Name (BLACK CLERK)</b></td><td>.................</td></tr>
                <tr><td></td><td>.</td><td></td><td></td></tr>
                <tr><td><b>Signature</b></td><td>.................</td></tr>
                <tr><td></td><td>.</td><td></td><td></td></tr>
                <tr><td><b>Company Repres Name</b></td><td>.................</td></tr>
                <tr><td></td><td>.</td><td></td><td></td></tr>
                <tr><td><b>Signature</b></td><td>.................</td></tr>
                
                </table>
                </p>
              </td>
              </tr>
  


<footer>

</footer>
</body>
</html>
