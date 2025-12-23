@extends('layouts.master')
<style>
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
</style>

@section('content')
<section class="section">
    <div class="section-body">


        <div class="row">


            <div class="col-12 col-md-12 col-lg-12">

               <div class="col-lg-10">
              
{{--
                   @if($bill_of_material->status == 0 )        
              <a class="btn btn-xs btn-info"  title="Convert to Invoice" onclick="return confirm('Are you sure?')"    href="{{ route('inventory.approve',$bill_of_material->id)}}"  title="" >Approve Purchase </a>
                @endif

           

      @if($bill_of_material->status != 0 && $bill_of_material->status != 4 && $bill_of_material->status != 3 && $bill_of_material->good_receive == 0)                        
              <a class="btn btn-xs btn-info" data-placement="top"  href="{{ route('inventory.receive',$bill_of_material->id)}}"  title="Good Receive"> Good Receive </a>   
           @endif  
--}}             
             <a class="btn btn-xs btn-success"  href="{{ route('bill_of_material_inv_pdfview',['download'=>'pdf','id'=>$bill_of_material->id]) }}"  title="" > Download PDF </a>         
                                         
    </div>

<br>



<br>
 
                <div class="card">
                    <div class="card-body">
                       
                        <?php
$settings= App\Models\System::where('added_by', auth()->user()->added_by)->first();


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
                                        
                                       <h5 class=mb0">REF NO : {{$bill_of_material->reference_no}}</h5>
                                       Product :  {{$bill_of_material->item->name}}              
              <br>Descripttion : {{$bill_of_material->description}}                                          

                                      
                                                      
                    
                    
                
            </div>
                                </div>


                               <br><br>
                              

                                
                                <?php

                                 $i =1;
       
                                 ?>

                               <div class="table-responsive mb-lg">
            <table class="table items invoice-items-preview" page-break-inside:="" auto;="">
                <thead class="bg-items">
                    <tr>
                        <th style="color:white;">#</th>
                        <th style="color:white;">Items</th>
                        <th style="color:white;">Qty</th>
                        <th  class="" style="color:white;">Unit</th>

                    </tr>
                </thead>
                                    <tbody>
                                        @if(!empty($bill_of_material_item))
                                        @foreach($bill_of_material_item as $row)
                                    
                                        <tr>
                                         <td class="">{{$i++}}</td>
                                            <td class=""><strong class="block">{{$row->item_name}}</strong></td>
                                            
                                        <td class="">{{number_format($row->quantity ,2)}}  </td>
                                       <td class="">{{ $row->unit }} </td>
                                            
                                        </tr>
                                        @endforeach
                                        @endif

                                       
                                    </tbody>
</table>
                            </div>

                                     <div class="row" >
                                              <div class="col-lg-8"> </div>
                                        <div class="col-lg-4 pv">

  




<br>



 







</div>

                                
                             
                            </div>

                        </div>

                    </div>
                </div>
            </div>

         

 
        </div>
    </div>
</section>


   
@endsection

@section('scripts')

@endsection