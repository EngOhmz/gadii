<!DOCTYPE html>
<html>

<head>
    <title>SALES RECEIPT</title>

    <style>
     body, html { 
            
            margin: 0px 5px 10px 5px !important;
            padding: 1px 1px px 0px !important;
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
  

                        <hr style="border: 1px dashed;">  
                <p align="center" style="font-weight: normal;" class="fontL">
                <b> Property : @if (!empty($invoices->store->name)){{ $invoices->store->name }}@endif </b>
                <br><b>RECEIPT NO: {{$invoices->reference_no}}</b>
                <br><b>Date: {{Carbon\Carbon::parse($invoices->invoice_date)->format('d/m/Y')}}</b>
                <br><b>Client: {{$invoices->client->name}}</b>
                
                
                </p>
               

   <?php
                               
                                 $gland_total = 0;
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

                                           $item_name=App\Models\POS\Items::find($row->item_name);
                                               
                                         ?>
 <tr>
                                   
                                    <td align="">{{$item_name->name}}</td>
                                     <td align="">{{ number_format($row->quantity)}}</td>
                                    <td align="">{{number_format($row->total_cost + $row->total_tax ,2)}} </td>
                                </tr>

                                         @endforeach
                                        @endif
                               </tbody>
                               
                               
                                <tfoot>

                                <tr>
                                   <td align="" colspan="2" style="font-weight:bold;">Total :</td>
                                    <td align="" style="font-weight:bold;">{{number_format($gland_total,2)}} </td>
                                </tr>
                               
                              
                            </tfoot>
                    </table>
                                        
<hr style="border: dashed;">
                <div class="space  fontS">
                    <div class="col-md-12">                 
<p class="fontL" ><b>Created by:&nbsp;&nbsp;&nbsp;@if(!empty($invoices->assign->name)){{$invoices->assign->name }} @endif</b></p>
<p class="fontL" ><b>Signature:&nbsp;&nbsp;&nbsp;______________</b></p>
               

<hr style="border: dashed;">
<p align="center">Powered by UjuziNet Systems</p>

</div></div></div>
