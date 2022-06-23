 
@extends('layouts.master')

<style>
@font-face {
  font-family: SourceSansPro;
  src: url(SourceSansPro-Regular.ttf);
}

.p-md {
    padding: 12px !important;
}

.bg-items {
    background: #303252;
    color: #ffffff;
}
.ml-13 {
    margin-left: -13px !important;
}
body {
  
  color: #555555;
  background: #FFFFFF; 
  font-size: 14px; 
  font-family: SourceSansPro;
}
table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table th,
table td {
  padding: 20px;
  text-align: center;
  border-bottom: 1px solid #FFFFFF;
}

table th {
  white-space: nowrap;        
  font-weight: normal;
}


</style>

@section('content')
<section class="section">
    <div class="section-body">


        <div class="row">


            <div class="col-12 col-md-12 col-lg-12">

               <div class="col-lg-10">
                  @if($purchases->good_receive == 0 && $purchases->status != 4)
                 <a class="btn btn-xs btn-primary"  onclick="return confirm('Are you sure?')"   href="{{ route('purchase_inventory.edit', $purchases->id)}}"  title="" > Edit </a>          
            
                @endif

                   @if($purchases->status == 0 )        
              <a class="btn btn-xs btn-info"  title="Convert to Invoice" onclick="return confirm('Are you sure?')"    href="{{ route('inventory.approve',$purchases->id)}}"  title="" >Approve Purchase </a>
                @endif

               @if($purchases->status != 0 && $purchases->status != 4 && $purchases->status != 3 && $purchases->good_receive == 1)                      
                <a class="btn btn-xs btn-danger " data-placement="top"  href="{{ route('invoice.pay',$purchases->id)}}"  title="Add Payment"> Pay Purchase  </a>    
           @endif  

      @if($purchases->status != 0 && $purchases->status != 4 && $purchases->status != 3 && $purchases->good_receive == 0)                        
              <a class="btn btn-xs btn-info" data-placement="top"  href="{{ route('inventory.receive',$purchases->id)}}"  title="Good Receive"> Good Receive </a>   
           @endif  
             
             <a class="btn btn-xs btn-success"  href="{{ route('sales_pdfview',['download'=>'pdf','id'=>$purchases->id]) }}"  title="" > Download PDF </a>         
                                         
    </div>

<br>

<?php if (strtotime($purchases->due_date) < time() && $purchases->status != '4' && $purchases->status != '3') {
    $start = strtotime(date('Y-m-d H:i'));
    $end = strtotime($purchases->due_date);

    $days_between = ceil(abs($end - $start) / 86400);
    ?>

   <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>×</span>
              </button>
             <i class="fa fa-exclamation-triangle"></i>
        This invoice is overdue by {{ $days_between}} days
            </div>
          </div>

  
    <?php
}
?>

<br>
 
                <div class="card">
                    <div class="padding-20">
                       
                        <?php
$settings= App\Models\System::first();


?>
                        <div class="tab-content" id="myTab3Content">
                            <div class="tab-pane fade show active" id="about" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="row">
                                   <div class="col-lg-6 col-xs-6 ">
                <img class="pl-lg" style="width: 233px;height: 120px;" src="{{url('public/assets/img/logo')}}/{{$settings->picture}}">
            </div>
                                  
 <div class="col-lg-3 col-xs-3">

                                    </div>

                                      <div class="col-lg-3 col-xs-3">
                                        
                                       <h5 class=mb0">REF NO : {{$purchases->reference}}</h5>
                                      Invoice Date : {{Carbon\Carbon::parse($purchases->purchase_date)->format('d/m/Y')}}                  
              <br>Due Date : {{Carbon\Carbon::parse($purchases->due_date)->format('d/m/Y')}}                                          
           <br>Sales Agent: {{$purchases->user->name }} 
                                      
          <br>Status: 
                                   @if($purchases->status == 0)
                                            <span class="badge badge-danger badge-shadow">Not Approved</span>
                                            @elseif($purchases->status == 1)
                                            <span class="badge badge-warning badge-shadow">Not Paid</span>
                                            @elseif($purchases->status == 2)
                                            <span class="badge badge-info badge-shadow">Partially Paid</span>
                                            @elseif($purchases->status == 3)
                                            <span class="badge badge-success badge-shadow">Fully Paid</span>
                                            @elseif($purchases->status == 4)
                                            <span class="badge badge-danger badge-shadow">Cancelled</span>
                                            @endif
                                       
                                        <br>Currency: {{$purchases->exchange_code }}                                                
                    
                    
                
            </div>
                                </div>


                               <br><br>

                               <div class="row mb-lg">
{{--
                                    <div class="col-lg-6 col-xs-6">
                                         <h5 class="p-md bg-items mr-15">Our Info:</h5>
                                 <h4 class="mb0">{{$purchases->user->name}}</h4>
                    {{ $purchases->user->address }}  
                   <br>Phone : {{ $purchases->user->phone}}     
                  <br> Email : <a href="mailto:{{$purchases->user->email}}">{{$purchases->user->email}}</a>                                                               
                   <br>TIN : {{$settings->tin}}
                                    </div>
    --}}       


                                <div class="col-lg-6 col-xs-6">
                                         <h5 class="p-md bg-items mr-15">Our Info:</h5>
                                 <h4 class="mb0">GAKI INVESTMENT CO LTD</h4>
                              P.O BOX 707 , SHINYANGA , TANZANIA
                   <br>Tel : +255282986301    
                      <br>Fax : +255282986300     
                  <br> Email : <a href="mailto:gakiginning@yahoo.com">gakiginning@yahoo.com</a>                                                               
                                    </div>                        

                                    <div class="col-lg-6 col-xs-6">
                                       
                                       <h5 class="p-md bg-items ml-13">  Client Info: </h5>
                                       <h4 class="mb0"> {{$purchases->supplier->name}}</h4>
                                        

                                        </div>
 </div>

                                    </div>
                                </div>

         <br> <br>                     
                                <?php
                               
                               $total_bales =0;
                                $total_gross =0;
                                  $total_tare = 0; 
                               $total_net= 0; 
                                 $i =1;
       
                                 ?>

                               <div class="table-responsive mb-lg">
            <table>
                <thead class="bg-items">
                    <tr>
                        <th style="color:white;">#</th>
                        <th style="color:white;">Lot No</th>
                        <th style="color:white;" >Bales</th>
                        <th  class="col-sm-2" style="color:white;">Gross</th>
                        <th class="col-sm-2" style="color:white;">Tare</th>
                        <th class="col-sm-2" style="color:white;">Net</th>
                    </tr>
                </thead>
                                    <tbody>
                                        @if(!empty($purchase_items))
                                        @foreach($purchase_items as $row)
                                        <?php
                                         $total_bales +=$row->bales;
                                         $total_gross +=$row->gross;
                                          $total_tare += $row->tare; 
                                         $total_net+= $row->net; 
                                         ?>
                                        <tr>
                                            <td class="">{{$i++}}</td>
                                            <?php
                                         $item_name = App\Models\Cotton\Production::find($row->item_name);
                                        ?>
                                            <td class=""><strong class="block">{{$item_name->lot_no}}</strong></td>
                                            <td class="">{{ $row->bales }} </td>
                                        <td class="">{{number_format($row->gross ,2)}}  </td>                                         
                                         <td class=""> {{number_format($row->tare ,2)}} </td>
                                            <td class="">{{number_format($row->net, 2)}} </td>
                                            
                                        </tr>
                                        @endforeach
                                        @endif
  <tr>
                                            <td class=""></td>                                           
                                            <td class=""><strong class="block">TOTAL</strong></td>
                                            <td class=""><strong class="block">{{ number_format( $total_bales,2) }} </strong></td>
                                        <td class=""><strong class="block">{{number_format( $total_gross ,2)}} kg</strong> </td>                                         
                                         <td class=""><strong class="block"> {{number_format( $total_tare ,2)}} kg</strong> </td>
                                            <td class=""><strong class="block">{{number_format($total_net, 2)}} kg </strong></td>
                                            
                                        </tr>
                                       
                                    </tbody>
</table>
                            </div>

    <br>                               
  <div class="row" >
                                              <div class="col-lg-8"> </div>
                                        <div class="col-lg-4 pv">

               
 <div class="clearfix">
                    <p class="pull-left"><b>Unit Price</b></p>
                    <p class="pull-right mr">{{number_format($purchases->unit_price ,2)}} {{$purchases->exchange_code}}</p>
                </div>
 <div class="clearfix">
                    <p class="pull-left"><b>Total Pound</b></p>
                    <p class="pull-right mr">{{number_format(2.20462 * $total_net ,5)}} kg</p>
                </div>
 <div class="clearfix">
                    <p class="pull-left"><b>Total Amount</b></p>
                    <p class="pull-right mr">{{number_format($purchases->purchase_amount ,2)}} {{$purchases->exchange_code}}</p>
                </div>



  @if(!@empty($purchases->due_amount < $purchases->purchase_amount + $purchases->purchase_tax))
        <div class="clearfix">
                    <p class="pull-left"><b>Paid Amount</b></p>
                    <p class="pull-right mr">{{number_format(($purchases->purchase_amount + $purchases->purchase_tax) - $purchases->due_amount,2)}}  {{$purchases->exchange_code}}</p>
                </div>

      <div class="clearfix">
                    <p class="pull-left h3 text-danger"><b>Total Due</b></p>
                    <p class="pull-right mr">{{number_format($purchases->due_amount,2)}}  {{$purchases->exchange_code}}</p>
                </div>
@endif

<br>
 


</div>

                                
                             
                            </div>

                        </div>

                    </div>
                </div>
            </div>

         

  @if(!empty($payments[0]))
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="padding-20">
                        <h5 class="mb0" style="text-align:center">PAYMENT DETAILS</h5>
                      <div class="tab-content" id="myTab3Content">
                            <div class="tab-pane fade show active" id="about" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="row">     
                            
                                
                                <?php
                               
                                
                                 $i =1;
       
                                 ?>
                                <div class="table-responsive">
            <table class="table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Transaction ID</th>
                        <th>Payment Date</th>
                        <th>Amount</th>
                        <th>Payment Mode</th>
                        <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        @foreach($payments as $row)
                                       
                                        <tr>
                                            <?php
$method= App\Models\Payment_methodes::find($row->payment_method);


?>
                                            <td class=""> {{$row->trans_id}}</td>
                                               <td class="">{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}  </td>
                                            <td class="">{{ number_format($row->amount ,2)}} {{$purchases->currency_code}}</td>
                                            <td class="">{{ $method->name }}</td>
                                            <td class=""><a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                            title="Edit" onclick="return confirm('Are you sure?')"
                                            href="{{ route('cotton_sales_payment.edit', $row->id)}}"><i
                                                class="fa fa-edit"></i></a></td>
                                        </tr>
                                        @endforeach
                                       


                                    </tbody>
                                   
                                </table>
                              </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>


   
@endsection

@section('scripts')

@endsection