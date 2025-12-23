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
  

                        <hr style="border: 1px solid;">  
                <p align="center" style="font-weight: normal;" class="fontL"><b>REF: {{$invoices->reference}}</b>
                <br><b>Date: {{Carbon\Carbon::parse($invoices->date)->format('M d, Y')}}</b>
                <br><b>Student: {{$invoices->student->student_name}}</b>
                 <br><b>Class: {{$invoices->class}}</b>
                
                </p>
               

   <?php
                               
                                 $gland_total = 0;
                                 $i =1;
       
                                 ?>


                    <table class="center" style=" border: none !important; family:source_sans_proregular; font-size:10px;margin:0 auto;">
                            <thead>
                                <tr>
                                   
                                     <td align="">TYPE</td>
                                    <td align="">AMOUNT</td>
                                </tr>
                                </thead>
                                      <tbody>

                                @if(!empty($invoice_items))
                                        @foreach($invoice_items as $row)
                                        <?php
                                         $gland_total +=$row->paid;
                                               
                                         ?>
 <tr>
                                   
                                    <td align="">{{$row->type}}</td>
                                    <td align="">{{number_format($row->paid ,2)}} </td>
                                </tr>

                                         @endforeach
                                        @endif
                               </tbody>
                               
                               
                                <tfoot>

                                <tr>
                                   <td align="" colspan="" style="font-weight:bold;">Total :</td>
                                    <td align="" style="font-weight:bold;">{{number_format($gland_total,2)}} </td>
                                </tr>
                               
                              
                            </tfoot>
                    </table>
                    
                    
<br>
<p class="fontL" ><b>Signature:&nbsp;&nbsp;&nbsp;______________</b></p>
 
 {{--                                       
<hr style="border: solid;">
                <div class="space  fontS">
                    <div class="col-md-12">                 
<p class="fontL" ><b>Created by:&nbsp;&nbsp;&nbsp;@if(!empty($invoices->assign->name)){{$invoices->assign->name }} @endif</b></p>
--}}

               

<hr style="border: solid;">
<p align="center">Powered by UjuziNet Systems</p>

</div></div></div>
