<!DOCTYPE html>
<html>

<head>
    <title>SALES RECEIPT</title>
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
                <p align="center" style="font-weight: normal;" class="fontL"><b>RECEIPT NO: {{$invoices->reference_no}}</b>
                <br><b>Date: {{Carbon\Carbon::parse($invoices->invoice_date)->format('d/m/Y')}}</b>
                <br><b>Client: {{$invoices->client->name}}</b>
                
                
                </p>
               

   <?php
                               
                                 $gland_total = 0;
                                 $tax=0;
                                 $i =1;
       
                                 ?>


                    <table class="center" style=" border: none !important; family:source_sans_proregular; font-size:10px;">
                            <thead>
                                <tr>
                                   
                                    <td align="">ITEM</td>
                                     <td align="">QTY</td>
                                    <td align="">AMOUNT</td>
                                </tr>
                                </thead>
                                      <tbody>

                                @if(!empty($invoice_items))
                                        @foreach($invoice_items as $row)
                                        <?php
                                         $gland_total +=$row->total_cost +$row->total_tax;
                                         $tax += $row->total_tax; 

                                           $item_name=App\Models\POS\Items::find($row->item_name);
                                               
                                         ?>
 <tr>
                                   
                                    <td align="">{{$item_name->name}} @if(!empty($item_name->color)) - {{$item_name->c->name}} @endif   @if(!empty($item_name->size)) - {{$item_name->s->name}} @endif</td>
                                     <td align="">{{ number_format($row->due_quantity)}}</td>
                                    <td align="">{{number_format($row->total_cost + $row->total_tax ,2)}} </td>
                                </tr>

                                         @endforeach
                                        @endif
                               </tbody>
                               
                               
                                <tfoot>

                                <tr>
                                   <td align="" colspan="2" style="font-weight:bold;">Sub Total :</td>
                                    <td align="" style="font-weight:bold;">{{number_format($gland_total - $tax,2)}} {{$invoices->exchange_code}}</td>
                                </tr>
                                <tr>
                                   <td align="" colspan="2" style="font-weight:bold;">VAT :</td>
                                    <td align="" style="font-weight:bold;">{{number_format($tax,2)}} {{$invoices->exchange_code}}</td>
                                </tr>
                                
                                <tr>
                                   <td align="" colspan="2" style="font-weight:bold;">Shipping Cost :</td>
                                    <td align="" style="font-weight:bold;">{{number_format($invoices->shipping_cost,2)}} {{$invoices->exchange_code}}</td>
                                </tr>
                                <tr>
                                   <td align="" colspan="2" style="font-weight:bold;">Discount :</td>
                                    <td align="" style="font-weight:bold;">{{number_format($invoices->discount,2)}} {{$invoices->exchange_code}}</td>
                                </tr>
                                @if($invoices->adjustment !=0)
                                <tr>
                        <td align="" colspan="2" style="font-weight:bold;">Total Before Adjustment :</td>
                        <td align="" style="font-weight:bold;">{{number_format(($gland_total +$invoices->shipping_cost) - $invoices->discount ,2)}} {{$invoices->exchange_code}}</td>
                                </tr>
                                 <tr>
                        <td align="" colspan="2" style="font-weight:bold;">Adjustment :</td>
                        <td align="" style="font-weight:bold;">{{number_format($invoices->adjustment ,2)}} {{$invoices->exchange_code}}</td>
                                </tr>
                                @endif
                                 <tr>
                        <td align="" colspan="2" style="font-weight:bold;">Total :</td>
                        <td align="" style="font-weight:bold;">{{number_format(($gland_total +$invoices->shipping_cost) - $invoices->discount + $invoices->adjustment ,2)}} {{$invoices->exchange_code}}</td>
                                </tr>
                               
                              
                            </tfoot>
                    </table>
                                        
<hr style="border: solid;">
                <div class="space  fontS">
                    <div class="col-md-12">                 
<p class="fontL" ><b>Created by:&nbsp;&nbsp;&nbsp;@if(!empty($invoices->assign->name)){{$invoices->assign->name }} @endif</b></p>
<p class="fontL" ><b>Signature:&nbsp;&nbsp;&nbsp;______________</b></p>
               

<hr style="border: solid;">
<p align="center">Powered by UjuziNet Systems</p>

</div></div></div>
