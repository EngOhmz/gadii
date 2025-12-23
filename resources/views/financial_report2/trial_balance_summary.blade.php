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
                       
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
        <div class="panel-heading">
            <h6 class="panel-title">
              
             @if(!empty($start_date))
                   For the period :<b> {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} - {{Carbon\Carbon::parse($second_date)->format('d/m/Y')}} </b>
                @endif
       
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

                 <div class="col-md-4">
                    <label class="">Start Date <span class="required"> * </span></label>
                   <input  name="start_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                    echo date('Y-m-d', strtotime('first day of january this year'));
                }
                ?>">

                </div>
                 <div class="col-md-4">
                    <label class="">End Date <span class="required"> * </span></label>
                     <input  name="second_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($second_date)) {
                    echo $second_date;
                } else {
                    echo date('Y-m-d');
                }
                ?>">
                </div>

               <?php $a=  trim(json_encode($x), '[]');  ?>
                
               

                <div class="col-md-4">
                    <label class="">Branch</label> 
                   
                    <select name="branch_id" class="form-control m-b" id="branch_id">
                        <option value="">Select Branch</option>
                       @if(!empty($branch))
                       
                        @foreach($branch as $br)
                        <option value="{{$br->id}}" @if(isset($branch_id)){{  $branch_id == $br->id  ? 'selected' : ''}} @endif>{{$br->name}}</option>
                        @endforeach
                         <option value="<?php echo trim(json_encode($x), '[]');; ?>" @if(isset($branch_id)){{ $branch_id == $a  ? 'selected' : ''}} @endif>All Branches</option>
                        @endif
                    </select>
                    
                </div>
               
               

   <div class="col-md-12">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>
              @if(!empty($start_date))
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle "
                                    data-toggle="dropdown">Download Report
                                <span class="caret"></span></button>
                            <div class="dropdown-menu">
                              
                                    <li class="nav-item">
                                <a class="nav-link" href="{{url('financial_report/trial_balance_summary/pdf?start_date='.$start_date.'&end_date='.$second_date.'&branch_id='.$branch_id)}}"
                                       target="_blank"><i
                                                class="icon-file-pdf"></i>  Download PDF
                                    </a></li>
                                
                                    <li class="nav-item">
                                    <a class="nav-link" href="{{url('financial_report/trial_balance_summary/excel?start_date='.$start_date.'&end_date='.$second_date.'&branch_id='.$branch_id)}}"
                                       target="_blank"><i
                                                class="icon-file-excel"></i> Download Excel
                                    </a></li>
                                
                            </div>
                        </div>
                      @endif

                </div>                  
                </div>
           
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br>
  <!-- /.box -->
    @if(!empty($start_date))
      @if(isset($branch_id))
     @php
     if($branch_id == $a){
         $br_id=$x;
     }
     
     else{
         
      $br_id=$z;    
     }
     
     @endphp
     @endif
     
<div class="panel panel-white col-lg-12">
            <div class="panel-body table-responsive no-padding">
            

            <table id="data-table" class="table table-striped ">
                    <thead>
                    <tr >
                         <th colspan="4"><center>TRIAL BALANCE FOR THE PERIOD BETWEEN {{$start_date}} To {{$second_date}}   </center></th>
                       
                    </tr>
                    </thead>
                     <tbody>

               <?php
               $c=0;     
              $credit_total = 0;
              $debit_total = 0;
            

?>            
     
     @foreach($data->where('added_by',auth()->user()->added_by) as $account_class)
<?php    $c++ ;  ?>
 <?php
           $total_dr_unit=0;
                         $total_cr_unit=0;
   $total_vat_cr=0;;
               $total_vat_dr=0;;
  
?>            
                          <tr>
                        <td colspan="2" ><b>{{ $c }} . <a href="#view{{$account_class->id}}" data-toggle="modal">{{ $account_class->class_name  }}</a></b></td>
                        <?php if($c == 1){ ?>
                           
                           
                    <?php    } ?>
                   


               
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)
@if($account_code->account_name != 'Deffered Tax' && $account_code->account_name != 'Value Added Tax (VAT)' && $account_code->account_codes != '31101')

<?php
                                   
    
                       
                        
  if(!empty($branch_id) && $branch_id != $a){
                $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }
                            

                                        
                         
                       

                     if ($account_class->class_type == 'Assets'){
                            $debit_total += $dr1-$cr1 ;
                            $total_dr_unit  +=($dr1-$cr1);
                        }
                        elseif ($account_class->class_type == 'Liability'){
                            $credit_total += $cr1-$dr1 ;
                             $total_cr_unit  +=($cr1-$dr1);
                        }
                         elseif ($account_class->class_type == 'Equity'){
                            $credit_total += $cr1-$dr1 ;
                             $total_cr_unit  +=($cr1-$dr1);
                        }
                        elseif ($account_class->class_type == 'Expense'){
                           $debit_total += $dr-$cr ;
                            $total_dr_unit  +=($dr-$cr);
                        }
                        elseif ($account_class->class_type == 'Income'){
                           $credit_total += $cr-$dr ;
                            $total_cr_unit  +=($cr-$dr);
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
                             
                      
                        $vat_in= \App\Models\AccountCodes::where('account_name', 'VAT IN')->where('added_by',auth()->user()->added_by)->first();
                        $vat_out= \App\Models\AccountCodes::where('account_name', 'VAT OUT')->where('added_by',auth()->user()->added_by)->first();

                        if(!empty($branch_id) && $branch_id != $a){
                       $cr_in = \App\Models\JournalEntry::where('account_id', $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id', $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id', $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            $cr_in = \App\Models\JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id', $vat_out->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }
                            

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
                          
                        

@elseif($account_code->account_name == 'Deffered Tax' )

<?php
                                   

  if(!empty($branch_id) && $branch_id != $a){
                $cr2 = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr2 = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
               
                $cr2 = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr2 = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }
                            

                             $credit_total +=  ($cr2-$dr2) +$net_profit['tax_for_second_date']; ;
                             $total_cr_unit  +=($cr2-$dr2) +$net_profit['tax_for_second_date']; ;;
                      
                        
 ?> 
 
 
@elseif($account_code->account_codes  == 31101)

<?php
                                   

                             $credit_total +=  $net_profit['profit_for_second_date']; ;
                             $total_cr_unit  +=$net_profit['profit_for_second_date']; ;
                      
                        
 ?> 

 @endif  
 
   @endforeach   
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
     @foreach($data->where('added_by',auth()->user()->added_by) as $account_class)
           <?php    
 $unit_dr  = 0;
$unit_cr  = 0;
  $total_cr= 0;
$total_dr= 0;
$total_v= 0;
?>       
  <!-- Modal -->
  <div class="modal fade" id="view{{$account_class->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
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
                             <table class="table datatable-basic table-striped">
<thead>
                    <tr>
                        <th>Account Code</th>
                          <th>Account Name</th>
                            <th>Debit</th>
                        <th>Credit</th>
                    </tr>
                    </thead>
 <tbody> 
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)
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

     
                   $total_cr = $total_cr + $total_v;
                                      

                   ?>
                     
                         @if ($total_in - $total_out < 0)
                                   <td>{{ number_format(0 ,2) }} </td>
                                        <td>{{ number_format(abs(($total_in - $total_out) *-1 ),2) }}  </td>
                                
                           @else
                                 <td>{{ number_format(abs($total_in - $total_out ),2) }}  </td>
                                <td>{{ number_format(0 ,2) }} </td>

                           @endif 
                    </tr> 

                
 @elseif($account_code->account_name != 'Deffered Tax' && $account_code->account_name != 'Value Added Tax (VAT)' && $account_code->account_codes != '31101')


 <?php   

  if(!empty($branch_id) && $branch_id != $a){
                        
                            
                         if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Liability' || $account_class->class_type == 'Equity'){
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                        }
                        else{
                         $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                        }
                            
                          }
                          else{
                              
                                
                         if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Liability' || $account_class->class_type == 'Equity'){
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                        }
                        else{
                         $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                        }
                            
                          }   

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
                    
                    
@elseif($account_code->account_name == 'Deffered Tax')


 <?php   

  if(!empty($branch_id) && $branch_id != $a){
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                            $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }

                       $unit_cr +=($cr-$dr) + $net_profit['tax_for_second_date'];
                       $unit_dr +=0;
                         $total_dr += 0 ;
                         $total_cr  += ($cr-$dr) + $net_profit['tax_for_second_date']; ;  
  ?>
  <tr>
                        <td >{{ $account_code->account_codes }}</td>
                          <td >{{ $account_code->account_name }}</td>
                            <td>{{ number_format(0,2) }}</td>
                            <td>{{ number_format(($cr+$net_profit['tax_for_second_date']) - $dr,2) }}</td>
                           
                        
                 
                    </tr> 


@elseif($account_code->account_codes  == 31101) 


 <?php   

 

                       $unit_cr +=$net_profit['profit_for_second_date'];
                       $unit_dr +=0;
                         $total_dr += 0 ;
                         $total_cr  += $net_profit['profit_for_second_date'] ;  
  ?>
  <tr>
                        <td >{{ $account_code->account_codes }}</td>
                          <td >{{ $account_code->account_name }}</td>
                            <td>{{ number_format(0,2) }}</td>
                            <td>{{ number_format($net_profit['profit_for_second_date'],2) }}</td>
                           
                        
                 
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
      
                            </table>
                           </div>

        </div>
       
 <div class="modal-footer ">
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
    </div>
</div></div>
  </div>


 
@endforeach
@endif

@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"targets": [1]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection