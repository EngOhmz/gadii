@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Trial Balance Summary </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Trial Balance  Summary  Report
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
        <div class="panel-heading">
            <h6 class="panel-title">
              Trial Balance  Summary
             @if(!empty($start_date))
                    for the period: <b>{{$start_date}} to {{$second_date}}</b>
                @endif
       
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

                 <div class="col-md-4">
                    <label class="">Start Date</label>
                   <input  name="start_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                    echo date('Y-m-d', strtotime('first day of january this year'));
                }
                ?>">

                </div>
                 <div class="col-md-4">
                    <label class="">End Date</label>
                     <input  name="second_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($second_date)) {
                    echo $second_date;
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
                    <tr >
                         <th colspan="7"><center>TRIAL BALANCE FOR THE PERIOD BETWEEN {{$start_date}} To {{$second_date}}   </center></th>
                       
                    </tr>
                    </thead>
                     <tbody>

               <?php
               $c=0;     
              $credit_total = 0;
              $debit_total = 0;
            

?>            
     
     @foreach($data as $account_class)
<?php    $c++ ;  ?>
 <?php
           $total_dr_unit=0;
                         $total_cr_unit=0;
   $total_vat_cr=0;;
               $total_vat_dr=0;;
  
?>            
                          <tr>
                        <td colspan="2" ><b>{{ $c }} . <a href="#view{{$account_class->id}}" data-toggle="modal"">{{ $account_class->class_name  }}</a></b></td>
                        <?php if($c == 1){ ?>
                           
                           
                    <?php    } ?>
                   


               
  @foreach($account_class->groupAccount  as $group)
 @if($group->name != 'Retained Earnings/Loss')                          
@foreach($group->accountCodes as $account_code)
 @if($account_code->account_name != 'Deffered Tax' && $account_code->account_name != 'Value Added Tax (VAT)')

<?php
                                   
    
                       
                        

                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('debit');
                            

                                        
                          $total_dr_unit  +=($dr-$cr);
                        $total_cr_unit  +=($cr-$dr);

                    if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense'){
                                        $debit_total = $debit_total + ($dr-$cr) ;
                           }else{
                                  $credit_total =  $credit_total  +($cr-$dr) ;
                           }
                     
                        
 ?> 
                     
                        
    @elseif($account_code->account_name == 'Value Added Tax (VAT)')


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

                        $cr_in = \App\Models\JournalEntry::where('account_id', $vat_in->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id', $vat_in->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('debit'); 

                        $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id', $vat_out->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('debit');
                            

                         $total_in= $dr_in- $cr_in ;
                          $total_out = $cr_out - $dr_out ;

                         if ($total_in - $total_out < 0){
                        $total_vat_cr=($total_in -  $total_out) * -1;
                         $total_cr_unit=$total_cr_unit + (($total_in -  $total_out) * -1);
                        $credit_total=$credit_total +$total_vat_cr;
                       }
                       else{
                         $total_vat_dr=$total_in -  $total_out;
                   $total_dr_unit=$total_cr_unit + (($total_in -  $total_out) * -1);
                    $debit_total= $debit_total +$total_vat_dr;
                         }
  ?>
                          
                        


 @endif  
   @endforeach   
 @endif             
  @endforeach

 @if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense')
                                        <td>{{ number_format( $total_dr_unit ,2) }}  </td>
                                 <td>{{ number_format(0 ,2) }} </td>
                           @else
                                <td>{{ number_format(0 ,2) }} </td>
                            <td>{{ number_format( $total_cr_unit ,2) }}  </td> 
                           @endif 
</tr>

  @endforeach
 
                    </tbody>

 <tfoot>
                    <tr>
                           
                        <td><b>Total</b></td>
                          <td></td>
                        <td><b>{{number_format($debit_total, 2)}}</b></td>
                        <td><b>{{number_format($credit_total ,2)}}</b></td>
                        <td></td>
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
 <?php    
 
?>       
     @foreach($data as $account_class)
           <?php    
 $unit_dr  = 0;
$unit_cr  = 0;
  $total_cr= 0;
$total_dr= 0;
$total_v= 0;
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

     
                   $total_cr = $total_v;
                                      

                   ?>
                     
                         @if ($total_in - $total_out < 0)
                                   <td>{{ number_format(0 ,2) }} </td>
                                        <td>{{ number_format(abs(($total_in - $total_out) *-1 ),2) }}  </td>
                                
                           @else
                                 <td>{{ number_format(abs($total_in - $total_out ),2) }}  </td>
                                <td>{{ number_format(0 ,2) }} </td>

                           @endif 
                    </tr> 

                
 @elseif($account_code->account_name != 'Deffered Tax' && $account_code->account_name != 'Value Added Tax (VAT)')


 <?php   

 $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('debit');

                       $unit_cr +=($cr-$dr);
                       $unit_dr +=($dr-$cr);
                         $total_dr += $dr ;
                         $total_cr  += $cr ;  
  ?>
  <tr>
                        <td >{{ $account_code->account_codes }}</td>
                          <td >{{ $account_code->account_name }}</td>
                           @if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense')
                                           <td>{{ number_format($dr-$cr ,2) }}  </td>
                                 <td>{{ number_format(0 ,2) }} </td>
                           @else
                                <td>{{ number_format(0 ,2) }} </td>
                            <td>{{ number_format($cr-$dr ,2) }}  </td> 
                           @endif
                        
                 
                    </tr> 

                         
                       
@endif
            @endforeach
@endforeach          
                        </tbody>
<tfoot>
<tr>     
                     
                          <td></td>
                             <td><b> Total Balance</b></td>
                              @if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense')
                                           <td>{{ number_format( $unit_dr ,2) }}  </td>
                                 <td>{{ number_format(0 ,2) }} </td>
                           @else
                                <td>{{ number_format(0 ,2) }} </td>
                            <td>{{ number_format( $unit_cr + $total_v ,2) }}  </td> 
                           @endif
                         
                          
                    </tr> 
 <tr>     
                        <td >
                             <b>{{$account_class->class_name }} Total Balance</b></td>
                             <td colspan="3"><b>{{ number_format( abs($total_dr -  $total_cr),2) }}</b></td>
                    </tr>
<tfoot>
+         
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