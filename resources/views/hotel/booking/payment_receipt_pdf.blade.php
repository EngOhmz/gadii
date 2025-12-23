<!DOCTYPE html>
<html>

<head>
    <title>BOOKING PAYMENT RECEIPT</title>
<link href='https://fonts.googleapis.com/css?family=Open Sans' rel='stylesheet'>
    <style>
     body, html { 
            
            margin: 0px 5px 10px 5px !important;
            padding: 1px 1px px 0px !important;
              font-family: 'Open Sans';
        }
    table {
       
        width: 100%;
    }

    td,
    th {
        
    }
    .space{
        margin-top: -1em;
    }
   .fontL{
        font-size:10px;
    }
    
    .fontS{
        font-size:15px;
    }
    .fontN{
        font-size:23px;
    }
    
    .page-break {
            page-break-inside: avoid;
        }
        .center {
  margin-left: auto;
  margin-right: auto;
}
    </style>

</head>

<body>
 <?php
$settings= App\Models\System::where('added_by',auth()->user()->added_by)->first();;



?>
    <div>
        <h4 align="center" style="margin-top: 0%;" class="fontS">{{$settings->name}}<h4>
         <p align="center" style=" font-size:10px;">{{ $settings->address }} 
         <br>{{ $settings->phone}}
         <br>{{ $settings->email}}
         @if(!empty($settings->TIN)) <br>TIN : {{ $settings->TIN}} @endif
         
         </p>
  

                <hr style="border: 1px solid;">  
                <p align="center" style="font-weight: normal;" class="fontL">
                <b> Booking Ref No :{{ $invoice->reference_no }}</b>
                <br><b>RECEIPT NO: {{$data->trans_id}}</b>
                </p>
               
                <p align="center" style="font-weight: normal;" class="fontL">Date: {{Carbon\Carbon::parse($data->date)->format('d/m/Y')}}
                <br>Client: {{$invoice->client->name}}
                <br>Payment Account:{{ $data->payment->account_name }}
                <br>Amount: {{ number_format($data->amount)}} {{$invoice->exchange_code}}
                
                </p>



<p class="fontL" ><b>Signature:&nbsp;&nbsp;&nbsp;______________</b></p>
               

<hr style="border: solid;">
<p align="center">Powered by UjuziNet Systems</p>

</div></div></div>