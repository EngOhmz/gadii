<!DOCTYPE html>
<html>

<head>
    <title>ORDER RECEIPT</title>
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
    </style>

</head>

<body>
 <?php
$settings= App\Models\System::where('added_by',auth()->user()->added_by)->first();;



?>
    <div>
        <h4 align="center" style="margin-top: 0%;" class="fontS">{{$settings->name}}<h4>
         <p align="center" style="margin-top: 0%; font-size:10px;">{{ $settings->address }} 
         <br>{{ $settings->phone}}
         <br>{{ $settings->email}}
         @if(!empty($settings->TIN)) <br>TIN : {{ $settings->TIN}} @endif
         
         </p>
  

                        <hr style="border: 1px solid;">  
                <p align="center" style="font-weight: normal;" class="fontL"><b>RECEIPT NO: {{$invoices->reference_no}}</b>
                <br><b>Date: {{Carbon\Carbon::parse($invoices->invoice_date)->format('d/m/Y')}}</b>
                 @if(!empty($invoices->client->name))<br><b>Name: {{$invoices->client->name}}</b>@endif
                
                
                </p>
               

   <?php
                               
                                 $gland_total = 0;
                                 $i =1;
       
                                 ?>


                    <table style=" border: none !important; family:source_sans_proregular; font-size:10px;">
                            <thead>
                                <tr>
                                   
                                    <td align="">ITEM</td>
                                     <td align="">QTY</td>
                                   
                                </tr>
                                </thead>
                                      <tbody>

                                @if(!empty($invoice_items))
                                        @foreach($invoice_items as $row)
                                        <?php
                                         $gland_total +=$row->due_quantity;


                                        if($row->type == 'Bar'){
                                           $item_name=App\Models\POS\Items::find($row->item_name);
                                                }

                                           else if($row->type == 'Kitchen'){
                                             $item_name=App\Models\Restaurant\POS\Menu::find($row->item_name);
                                                                                }
                                         ?>
 <tr>
                                   
                                    <td align="">{{$item_name->name}}</td>
                                     <td align="">{{ number_format($row->due_quantity)}}</td>
                                    
                                </tr>

                                         @endforeach
                                        @endif
                               </tbody>
                               
                               
                                <tfoot>

                                <tr>
                                   <td align="" colspan="1" style="font-weight:bold;">Total :</td>
                                    <td align="" style="font-weight:bold;">{{number_format($gland_total)}} </td>
                                </tr>
                               
                              
                            </tfoot>
                    </table>
                                        

<hr style="border: solid;">
<p align="center">Powered by UjuziNet Systems</p>

</div></div></div>
