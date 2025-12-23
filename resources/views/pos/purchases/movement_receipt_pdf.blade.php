<!DOCTYPE html>
<html>

<head>
    <title>STOCK MOVEMENT RECEIPT</title>

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
  

                        <hr style="border: 1px solid;">  
                <p align="center" style="font-weight: normal;" class="fontL"><b>REF NO: {{$invoices->name}}</b>
                <br><b>Date: {{Carbon\Carbon::parse($invoices->movement_date)->format('d/m/Y')}}</b>
                <br><b>@if(!empty($invoices->source->name)) Source Location : {{$invoices->source->name}} @endif</b>
                 <br><b>@if(!empty($invoices->destination->name)) Destination Location : {{$invoices->destination->name}} @endif</b>
                
                
                </p>
               

   <?php
                               
                                 $total = 0;
                                 $i =1;
       
                                 ?>


                    <table class="center" style=" border: none !important; family:source_sans_proregular; font-size:10px;">
                            <thead>
                                <tr>
                                   <td align="">#</td>
                                    <td align="">ITEM</td>
                                     <td align="">QTY</td>
                                    
                                </tr>
                                </thead>
                                      <tbody>

                                @if(!empty($invoice_items))
                                        @foreach($invoice_items as $row)
                                        <?php
                                         $total+=$row->quantity;
                                               
                                         ?>
 <tr>
                                   
                                    <td>{{$i++}}</td>
                                    <td> {{$row->item->name}}</td>
                                    <td >{{number_format($row->quantity,2)}}</td>  
                                </tr>

                                         @endforeach
                                        @endif
                               </tbody>
                               
                               
                                <tfoot>

                                
                                <tr>
                        <td align="" colspan="2" style="font-weight:bold;">Total :</td>
                        <td align="" style="font-weight:bold;">{{number_format($total ,2)}} </td>
                                </tr>
                               
                              
                            </tfoot>
                    </table>
                                        

<p class="fontL" ><b>Signature:&nbsp;&nbsp;&nbsp;______________</b></p>
               

<hr style="border: solid;">
<p align="center">Powered by UjuziNet Systems</p>

</div></div></div>
