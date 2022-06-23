@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Balance Sheet Summary  </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Balance Sheet Summary Report
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
        <div class="panel-heading">
            <h6 class="panel-title">
              Balance Sheet Summary
            @if(!empty($start_date))
                    as at: <b>{{$start_date}}</b>
                   @endif
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

                <div class="col-md-4">
                    <label class="">As at Date</label>
                   <input  name="start_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                     echo date('Y-m-d');
                }
                ?>">
                </div>
           

   <div class="col-md-4">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

                </div>                  
                </div>
           
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br>
  <!-- /.box -->
    @if(!empty($start_date))
<div class="panel panel-white col-lg-12">
            <div class="panel-body table-responsive no-padding">

            <table id="data-table" class="table table-striped ">
                     <thead>
                    <tr>
                 <th>#</th>
                        <th colspan="5" style="text-align: center">STATEMENT OF FINANCIAL POSITION FOR THE PERIOD ENDING {{ $start_date }} </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center"><b>Assets</b></td>
                    </tr>


               <?php
               $c=0;     
                    $total_liabilities = 0;
                    $total_debit_assets = 0;
                    $total_credit_assets = 0;
                      $total_debit_liability  = 0;
                    $total_credit_liability  = 0;
                        $total_debit_equity  = 0;
                    $total_credit_equity  = 0;
                   $total_assets = 0;
                    $total_equity = 0;
                    $total_cr=0;
                    $total_dr=0;
?>            
     
     @foreach($asset as $account_class)
<?php    $c++ ; 

 $unit_total1   = 0;
 $unit_total2   = 0;

?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b><a href="#view{{$account_class->id}}" data-toggle="modal"">{{ $account_class->class_name  }}</a></b></td>
                  <td ></td>
                  <?php   if($c == 1){ ?>
                   <?php  } else{ ?>

                    <?php  }  ?>
                    

  
               
  @foreach($account_class->groupAccount  as $group)
                          
@foreach($group->accountCodes as $account_code)


 <?php
                   
                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('debit');


                         $total_credit_assets +=($dr1-$cr1);
                         
                         $unit_total1  +=($dr1-$cr1);
                        ?>                           
                           
             
                                 
                  
 @endforeach              
  @endforeach


                        <td><b>{{ number_format($unit_total1,2) }}</b></td>
                  </tr> 

                      
                     
  @endforeach
                      
 
           <tr>
                        <td colspan="3" style="text-align: center">
                            <b>Total Assets</b></td>
                        <td><b>{{ number_format($total_credit_assets,2) }}</b></td>

                    </tr>            
                   
     
                        
                         <tr>
                        <td colspan="5" style="text-align: center">
                            </td>

                    </tr>

                    <tr>
                        <td colspan="5" style="text-align: center "><b>Liabilities</b></td> <!-- sehemu ya liabilitty==================================================== -->
                    </tr>
                     @foreach($liability  as $account_class)
<?php    $c++ ; 

 $unit_total1  =0;
 $unit_total2  =0;

?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b><a href="#view{{$account_class->id}}" data-toggle="modal"">{{ $account_class->class_name  }}</a></b></td>
                  <td colspan=""></td>
                   

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
@if($account_code->account_name == 'Value Added Tax (VAT)')

<?php
                        $cr_in = 0;
                        $dr_in = 0;                   
                        $cr_out  = 0;
                        $dr_out  = 0;
                        $total_vat=0;
                           $total_out=0;
                             $total_in=0;
                             
                      
                        $vat_in= \App\Models\AccountCodes::where('account_name', 'VAT IN')->first();
                        $vat_out= \App\Models\AccountCodes::where('account_name', 'VAT OUT')->first();

                        $cr_in = \App\Models\JournalEntry::where('account_id', $vat_in->account_id)->where('date', '<=',
                            $start_date)->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id', $vat_in->account_id)->where('date', '<=',
                            $start_date)->sum('debit'); 

                        $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->account_id)->where('date', '<=',
                            $start_date)->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id', $vat_out->account_id)->where('date', '<=',
                            $start_date)->sum('debit');
                            

                         $total_in= $dr_in- $cr_in ;
                          $total_out = $cr_out - $dr_out ;
                         if ($total_in - $total_out < 0){
                        $total_vat=($total_in -  $total_out) * -1;
                       }
                       else{
                         $total_vat=($total_in -  $total_out) * -1;;
                         }
                   $unit_total2  = $unit_total2+ $total_vat ;
                         
  ?>
                          
             

@else

 <?php
                   
                            
                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('debit');

                      if($account_code->account_name == 'Deffered Tax'){
                       $total_credit_liability  =    $total_credit_liability + $net_profit['tax_for_second_date'];
                                              
                         $unit_total2  +=($cr1-$dr1) +  $net_profit['tax_for_second_date'];

                         }
                         else{
                          
                         $total_credit_liability  +=($cr1-$dr1);                     
                         
                         $unit_total2  +=($cr1-$dr1)  ;
                           }

                       
                        ?>                           
                              @if($account_code->account_name != 'Deffered Tax')
                                                 
                        
                        
                       
                         @else
                             
                         @endif

                    
             
                                 
  @endif                  
 @endforeach              ​
 ​@endforeach


                       ​<td><b>{{ number_format($unit_total2 ,2) }}</b></td>

                   ​</tr>    
 ​@endforeach


  ​<tr>
                       ​<td colspan="3" style="text-align: center">
                           ​<b>Total Liabilities</b></td>
                       ​<td><b>{{ number_format($total_credit_liability + $total_vat,2) }}</b></td>

                   ​</tr>     
                       


<tr>
                        <td colspan="5" style="text-align: center"><b>Equities</b></td>   <!-- //sehemu ya equity ==================================================================== -->
                    </tr>
    @foreach($equity   as $account_class)
<?php    $c++ ; 
  
     $unit_cost  = 0;
     $unit_cost1 = 0;

?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b><a href="#view{{$account_class->id}}" data-toggle="modal"">{{ $account_class->class_name  }}</a></b></td>
                  <td colspan=""></td>
                 
  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)

 <?php
                   
                            
                            
                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('debit');
                     
                     
                         if($account_code->account_codes == 31101){
                         $total_credit_equity    =$total_credit_equity + $net_profit['profit_for_second_date'];
                         $unit_cost1 = $unit_cost1 + $net_profit['profit_for_second_date'];  
                          
                        //   $unit_cost =1000 ;
                        //  $unit_cost1 = 1000;
                         }else{
                         $total_credit_equity    +=($cr1-$dr1) ;
                         $unit_cost1 +=($cr1-$dr1);
                         } ?>
                         @if($account_code->account_codes != 31101)

                         @else
                             
                         @endif
                                 
                  
 @endforeach              ​
 ​@endforeach
                
                       ​<td><b>{{ number_format($unit_cost1,2) }}</b></td>
                    </tr>
 ​@endforeach
                   
                                      <tr>
                        <td colspan="3" style="text-align: right">
                            <b>Total Equities</b></td>
                       ​<td><b>{{ number_format($total_credit_equity,2) }}</b></td>
                    </tr>

                    </tbody>
                    <tfoot>
                    
                                                
                    <tr>
                        <td colspan="3" style="text-align: right">
                            <b>Total Liabilities And Equities</b>
                        </td>


                        <td><b>{{ number_format($total_credit_liability+$total_credit_equity + $total_vat,2) }}</b></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    @endif


        

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
 @if(!empty($start_date))
@foreach($asset as $account_class)
       <?php    
 $unit_total  = 0;
   $total_cr= 0;
$total_dr= 0;
?>                   


                       
  <!-- Modal -->
  <div class="modal inmodal "id="view{{$account_class->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_class->class_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                            <table class="table table-bordered table-striped">
<thead>
                    <tr>
                       <th>Account Code</th>
                          <th>Account Name</th>
                            <th>Debit</th>
                        <th>Credit</th>
                    </tr>
                    </thead>
 <tbody>
@foreach($account_class->groupAccount  as $group)     
@foreach($group->accountCodes as $account_code) 
                    <?php                   
                       $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('debit');

                                 $unit_total  +=($dr-$cr);
                              $total_cr+=$cr;
                           $total_dr+=$dr;
                        ?>  

                                 <tr>
                        <td >{{ $account_code->account_codes }}</td>
                          <td >{{ $account_code->account_name }}</td>
                          <td>{{ number_format($dr ,2) }}</td>
                   <td >{{ number_format($cr ,2) }}</td>
                   
                    </tr> 


        
  @endforeach

 @endforeach  
                              </tbody>
<tfoot>
<tr>     
                     
                          <td></td>
                             <td><b> Total Balance</b></td>
                           <td><b>{{ number_format($total_dr,2) }}</b></td>
                            <td><b>{{ number_format($total_cr,2) }}</b></td>
                          
                    </tr> 
 <tr>     
                        <td >
                             <b>{{$account_class->class_name }} Total Balance</b></td>
                             <td colspan="3"><b>{{ number_format($unit_total,2) }}</b></td>
                    </tr>
<tfoot>
                            </table>
                           </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div></div>
  </div>
            
  @endforeach

<!-- //sehemu ya equity ==================================================================== -->
 @foreach($equity   as $account_class)

      <?php    
 $unit_equity  = 0;
   $total_cr= 0;
$total_dr= 0;
?>  
                       
  <!-- Modal -->
  <div class="modal inmodal " id="view{{$account_class->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_class->class_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                            <table class="table table-bordered table-striped">
<thead>
                    <tr>
                       <th>Account Code</th>
                          <th>Account Name</th>
                            <th>Debit</th>
                        <th>Credit</th>
                    </tr>
                    </thead>
 <tbody>
@foreach($account_class->groupAccount  as $group)     
@foreach($group->accountCodes as $account_code) 
 <?php        
                       if($account_code->account_codes == 31101){

                      $total_credit_equity    =$total_credit_equity + $net_profit['profit_for_second_date'];
                         $unit_equity =$unit_equity + $net_profit['profit_for_second_date']; 
?>

 <tr>
                        <td >{{ $account_code->account_codes }}</td>
                          <td >{{ $account_code->account_name }}</td>
                          <td>{{ number_format(0 ,2) }}</td>
                   <td >{{ number_format($net_profit['profit_for_second_date'] ,2) }}</td>
                   
                    </tr> 

                        

                      

  <?php  
}

else{   

 $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $unit_equity +=($cr-$dr);
  ?>


                          
              <tr>
                        <td >{{ $account_code->account_codes }}</td>
                          <td >{{ $account_code->account_name }}</td>
                          <td>{{ number_format($dr ,2) }}</td>
                   <td >{{ number_format($cr ,2) }}</td>
                   
                    </tr> 

<?php
}
?>
  @endforeach
  @endforeach       

                             
                              </tbody>
<tfoot>
<tr>     
                     
                          <td></td>
                             <td><b> Total Balance</b></td>
                           <td><b>{{ number_format($total_dr,2) }}</b></td>
                            <td><b>{{ number_format($total_cr + $net_profit['profit_for_second_date'] ,2) }}</b></td>
                          
                    </tr> 
 <tr>     
                        <td >
                             <b>{{$account_class->class_name }} Total Balance</b></td>
                             <td colspan="3"><b>{{ number_format($unit_equity,2) }}</b></td>
                    </tr>
<tfoot>
                            </table>
                           </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div></div>
  </div>

          
  @endforeach

<!-- sehemu ya liabilitty==================================================== -->
                   
 @foreach($liability  as $account_class)

      <?php    
 $unit_liability = 0;
   $total_cr= 0;
$total_dr= 0;
 $total_vat_cr= 0;
$total_vat_dr= 0;
$total_net= 0;
$total_v= 0;
?>  

                        
  <!-- Modal -->
  <div class="modal inmodal "id="view{{$account_class->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_class->class_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                            <table class="table table-bordered table-striped">

<thead>
                    <tr>
                     <th>Account Code</th>
                          <th>Account Name</th>
                            <th>Debit</th>
                        <th>Credit</th>
         
                    </tr>
                    </thead>
                              <tbody>
@foreach($account_class->groupAccount  as $group)                             
@foreach($group->accountCodes as $account_code) 

   @if($account_code->account_name == 'Value Added Tax (VAT)')  
 <tr>
                        <td >{{ $account_code->account_codes }}</td>
                          <td >{{ $account_code->account_name }}</td>
                          
                        
                   <?php
                      
                       if ($total_in - $total_out < 0){
                        $total_vat_cr=($total_in -  $total_out) * -1;
                         $total_v=($total_in -  $total_out) * -1;
                       }
                       else{
                         $total_vat_dr=$total_in -  $total_out;
                           $total_v=($total_in -  $total_out) * -1;; 
                         }

     
                     $unit_liability =  $unit_liability + $total_v;
                                      

                   ?>
                     
                         @if ($total_in - $total_out < 0)
                                   <td>{{ number_format(0 ,2) }} </td>
                                        <td>{{ number_format(abs(($total_in - $total_out) *-1 ),2) }}  </td>
                                
                           @else
                                 <td>{{ number_format(abs($total_in - $total_out ),2) }}  </td>
                                <td>{{ number_format(0 ,2) }} </td>

                           @endif 
                    </tr> 

  

@elseif($account_code->account_name == 'Deffered Tax')  
 
<tr>
                        <td >{{ $account_code->account_codes }}</td>
                          <td >{{ $account_code->account_name }}</td>
                          <td>{{ number_format(0 ,2) }}</td> 
                          <?php
                             $total_net=$net_profit['tax_for_second_date'];
                              ?>
                   <td >{{ number_format($total_net ,2) }}</td>
                     <?php

                      $unit_liability  =  $unit_liability + $total_net ;
                   ?>
                    </tr> 

@else
<?php
$cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('debit');

                       $unit_liability +=($cr-$dr);
                    $total_cr+=$cr;
                           $total_dr+=$dr;
  ?>


                          
              <tr>
                        <td >{{ $account_code->account_codes }}</td>
                          <td >{{ $account_code->account_name }}</td>
                          <td>{{ number_format($dr ,2) }}</td>
                   <td >{{ number_format($cr ,2) }}</td>
                   
                    </tr>
@endif
 @endforeach
  @endforeach
                              </tbody>
<tfoot>
<tr>     
                     
                          <td></td>
                             <td><b> Total Balance</b></td>
                           <td><b>{{ number_format($total_dr +  $total_vat_dr,2) }}</b></td>
                            <td><b>{{ number_format($total_cr + $total_net +  $total_vat_cr ,2) }}</b></td>
                          
                    </tr> 
 <tr>     
                        <td >
                             <b>{{$account_class->class_name }} Total Balance</b></td>
                               @if ($total_in - $total_out < 0)
                                   <td colspan="3"><b>{{ number_format($unit_liability +  $total_vat_cr  ,2) }}</b></td>
                                
                           @else
                                 <td colspan="3"><b>{{ number_format($unit_liability +  $total_vat_dr  ,2) }}</b></td>

                           @endif 
                             
                    </tr>
<tfoot>
                            </table>
                           </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div></div>
  </div>


       
              
  @endforeach

@endif

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'copy'
            },
            {
                extend: 'csv'
            },
            {
                extend: 'excel',
                title: 'ExampleFile'
            },
            {
                extend: 'pdf',
                title: 'ExampleFile'
            },

            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ]

    });

});
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection