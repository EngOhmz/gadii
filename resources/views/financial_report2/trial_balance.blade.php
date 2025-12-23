@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Trial Balance   </h4>
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
                    <label class="">Start Date <span class="required"> * </span> </label>
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
                                    <a class="nav-link" href="{{url('financial_report/trial_balance/pdf?start_date='.$start_date.'&end_date='.$second_date.'&branch_id='.$branch_id)}}"
                                       target="_blank"><i
                                                class="icon-file-pdf"></i>  Download PDF
                                    </a></li>
                                
                                    <li class="nav-item">
                                    <a class="nav-link" href="{{url('financial_report/trial_balance/excel?start_date='.$start_date.'&end_date='.$second_date.'&branch_id='.$branch_id)}}"
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
                         <th colspan="5"><center>TRIAL BALANCE FOR THE PERIOD BETWEEN {{$start_date}} To {{$second_date}}   </center></th>
                       
                    </tr>
                    </thead>
                     <tbody>

  <?php
               $c=0;     
             $credit_total = 0;
              $debit_total = 0;
               $total_vat_cr=0;;
               $total_vat_dr=0;;
?>                
     
     @foreach($data->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_class)
<?php    $c++ ;  ?>

 
                          <tr>
                        <td colspan="5" style="text-align: center"><b>{{ $c }} . {{ $account_class->class_name  }}</b></td>
                        <?php if($c == 1){ ?>
                           
                           
                    <?php    } ?>
                    </tr>

   <?php                              

$d=0;
?>
               
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group)
                             <?php $d++ ; 
                      //  $values = explode(",",  $account_group->holidays);
?>
   
                                                         
                         <tr>
                   <td>{{ $d }} .</td>
                   ​<td>{{$group->name  }}</td>                      
                  <td colspan="1"></td> 
                  <?php if($c == 1 && $d == 1 ){ ?>
                  <td colspan="">Dr</td>
                  <td colspan="">Cr</td>
                  <?php    }else{ ?>
                   <td colspan="2"></td>
                
                  <?php    } ?>
                   </tr>
    
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code)

 @if($account_code->account_name != 'Deffered Tax' && $account_code->account_name != 'Value Added Tax (VAT)' && $account_code->account_codes != '31101')
 
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
 <td><a href="#view{{$account_code->id}}" data-toggle="modal">{{$account_code->account_codes }}</a>
</td>
<?php
         
        
        
    $cr1 = 0;
                        $dr1 = 0;
                        $balance1=0;                    
                        $cr = 0;
                        $dr = 0;
                        $balance=0;
                           $total_d=0;
                             $total_d2=0;
                             $total_c=0;
                             $total_c2=0;

               
                        
                      

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
                            

                        //$credit_total = $credit_total + $cr  ;
                        //$debit_total = $debit_total + $dr ;

                       
                       ?>
                       
                       <?php
                        if ($account_class->class_type == 'Assets'){
                            $debit_total += $dr1-$cr1 ;
                        }
                        elseif ($account_class->class_type == 'Liability'){
                            $credit_total += $cr1-$dr1 ;
                        }
                         elseif ($account_class->class_type == 'Equity'){
                            $credit_total += $cr1-$dr1 ;
                        }
                        elseif ($account_class->class_type == 'Expense'){
                           $debit_total += $dr-$cr ;
                        }
                        elseif ($account_class->class_type == 'Income'){
                           $credit_total += $cr-$dr ;
                        }
                        

                             //$balance3 = 0;
                         if($account_code->account_codes == 2206){
                      ?>
                         
                        

                  <?php

                         }

                      else{

    ?>
                         @if ($account_class->class_type == 'Assets')
                                 <td>{{ number_format($dr1-$cr1 ,2) }} </td>
                                 <td>{{ number_format(0 ,2) }} </td>
                         @elseif ($account_class->class_type == 'Liability')
                                <td>{{ number_format(0 ,2) }} </td>
                                <td>{{ number_format($cr1-$dr1 ,2) }}  </td> 
                         @elseif ($account_class->class_type == 'Equity')
                                <td>{{ number_format(0 ,2) }} </td>
                                <td>{{ number_format($cr1-$dr1 ,2) }}  </td> 
                         @elseif ($account_class->class_type == 'Expense')
                                <td>{{ number_format($dr-$cr ,2) }} </td>
                                 <td>{{ number_format(0 ,2) }} </td> 
                        @elseif ($account_class->class_type == 'Income')
                                <td>{{ number_format(0 ,2) }} </td>
                                <td>{{ number_format($cr-$dr ,2) }}  </td> 
                         @endif 
                           
                          
                         
<?php
                         } 
                        ?>
                        
                           

                           
                        
</tr>

@elseif($account_code->account_name == 'Value Added Tax (VAT)')
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
 <td><a href="#vat{{$account_code->id}}" data-toggle="modal">{{$account_code->account_codes }}</a>

</td>
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
                       }
                       else{
                         $total_vat_dr=$total_in -  $total_out;
                         }
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
 <td></td>
 <td>{{$account_code->account_name }}</td>
 <td><a href="#deff{{$account_code->id}}" data-toggle="modal">{{$account_code->account_codes }}</a>

</td>
                    <?php
                    $cr2 = 0;
                    $dr2 = 0;
                        

                         if(!empty($branch_id) && $branch_id != $a){
               
                $cr2 = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr2 = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
               
                $cr2 = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                $dr2 = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }
                            
                             $credit_total +=  ($cr2-$dr2) +$net_profit['tax_for_second_date']; ;

                                     ?>
                          
                         
                                    <td>{{ number_format(0 ,2) }} </td>
                                    <td>{{ number_format(($cr2+$net_profit['tax_for_second_date']) - $dr2,2) }}  </td>
                                
                          
                           
                          
                              

                           
                        
</tr>


@elseif($account_code->account_codes  == 31101)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
 <td><a href="#np{{$account_code->id}}" data-toggle="modal">{{$account_code->account_codes }}</a>

</td>
                    <?php
                            
                    $credit_total +=  $net_profit['profit_for_second_date']; ;

                                     ?>
                          
                         
                                    <td>{{ number_format(0 ,2) }} </td>
                                    <td>{{ number_format($net_profit['profit_for_second_date'],2) }}  </td>
                                
                          
                           
                          
                              

                           
                        
</tr>




@endif  
   @endforeach   
            
  @endforeach
  @endforeach
 
                    </tbody>

 <tfoot>
                    <tr>
                           <td></td>
                        <td><b>Total</b></td>
                          <td></td>
                        <td><b>{{number_format($debit_total +  $total_vat_dr,2)}}</b></td>
                        <td><b>{{number_format($credit_total +  $total_vat_cr ,2)}}</b></td>
                        
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
     @foreach($data->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_class)
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group)
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code)
   @if($account_code->account_name != 'Deffered Tax' && $account_code->account_name != 'Value Added Tax (VAT)' && $account_code->account_codes != '31101')                 
  <!-- Modal -->
  <div class="modal fade " id="view{{$account_code->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_code->account_codes }} - {{$account_code->account_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                             <table class="table datatable-basic table-striped">
<thead>
                    <tr>
                       <th>Date</th>
                            <th>Debit</th>
                        <th>Credit</th>
                      <th>Note</th>
                    </tr>
                    </thead>
 <tbody>   
 <?php
 
                          if(!empty($branch_id) && $branch_id != $a){
                              
                        if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Liability' || $account_class->class_type == 'Equity'){
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->orderBy('date','desc')->get();
                        }
                        else{
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $second_date])->where('added_by',auth()->user()->added_by)->orderBy('date','desc')->get();
                        }

                          }
                          else{
                              
                    if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Liability' || $account_class->class_type == 'Equity'){
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->orderBy('date','desc')->get();
                        }
                        else{
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $second_date])->where('added_by',auth()->user()->added_by)->orderBy('date','desc')->get();
                        }
                            
                          }
                          
                          
                        ?>  
                 @foreach($account->where('added_by',auth()->user()->added_by)  as $ac)
                                 <tr>
                        <td >{{Carbon\Carbon::parse($ac->date)->format('d/m/Y') }}</td>
                          <td>{{ number_format($ac->debit ,2) }}</td>
                   <td >{{ number_format($ac->credit ,2) }}</td>
                       <td >{{ $ac->notes }}</td>
                    </tr> 

                @endforeach
                
      </tbody>      
    
 <?php
                   
                    if(!empty($branch_id) && $branch_id != $a){
                        
                            
                         if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Liability' || $account_class->class_type == 'Equity'){
                        $cr_modal = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_modal = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                        }
                        else{
                         $cr_modal = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_modal = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->whereBetween('date',[$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                        }
                            
                          }
                          else{
                              
                                
                         if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Liability' || $account_class->class_type == 'Equity'){
                        $cr_modal = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_modal = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                        }
                        else{
                         $cr_modal = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_modal = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',[$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                        }
                            
                         
                          }
                          
                      

                        ?> 
                        <tfoot>
                    <tr>     
                        <td><b>Total</b></td>
                           <td><b>{{ number_format($dr_modal,2) }}</b></td>
                            <td><b>{{ number_format($cr_modal,2) }}</b></td>
                             <td></td>
                             
                    </tr> 
  <tr>
                        <td>
                              <b>{{$account_code->account_name }} Total Balance</b></td>                           
                            @if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense')
                       <td colspan="3"><b>{{ number_format($dr_modal-$cr_modal ,2) }} </b></td>                                
                           @else
                         <td colspan="3"><b>{{ number_format($cr_modal-$dr_modal ,2) }} </b></td>
                           @endif 
                       

                    </tr> 
                        </tfoot>
                            </table>
                           </div>

        </div>
      
 <div class="modal-footer ">
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
        

    
    </div>
</div>
  </div>
  
  
        


@elseif($account_code->account_name == 'Value Added Tax (VAT)')
  <!-- Modal -->
  <div class="modal fade " id="vat{{$account_code->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_code->account_codes }} - {{$account_code->account_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                            <table class="table datatable-vi table-striped"><h4>VAT IN </h4>
<thead>
                    <tr>
                       <th>Date</th>
                            <th>Debit</th>
                        <th>Credit</th>
                      <th>Note</th>
                    </tr>
                    </thead>
 <tbody>   
 <?php
                         $vat_in = \App\Models\AccountCodes::where('account_name', 'VAT IN')->where('added_by',auth()->user()->added_by)->first();
                         
                         if(!empty($branch_id) && $branch_id != $a){
                       $account = \App\Models\JournalEntry::where('account_id', $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->orderBy('date','desc')->get();
                            
                          }
                          else{
                              
                         $account = \App\Models\JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->orderBy('date','desc')->get();
                          }
                        
                            
                       
                        ?>  
                 @foreach($account  as $ac)
                                 <tr>
                        <td >{{Carbon\Carbon::parse($ac->date)->format('d/m/Y') }}</td>
                          <td>{{ number_format($ac->debit ,2) }}</td>
                   <td >{{ number_format($ac->credit ,2) }}</td>
                       <td >{{ $ac->notes }}</td>
                    </tr> 

                @endforeach
     </tbody>           
            
    
 <?php
 
if(!empty($branch_id) && $branch_id != $a){
                          $cr_in = \App\Models\JournalEntry::where('account_id',  $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id',  $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                          }
                          else{
                              
                              $cr_in = \App\Models\JournalEntry::where('account_id',  $vat_in->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id',  $vat_in->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                          }
                   
                      
                            
                       $vat_in= $dr_in- $cr_in;


                        ?> 
                        
                        <tfoot>
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b>{{ number_format($dr_in,2) }}</b></td>
                            <td><b>{{ number_format($cr_in,2) }}</b></td>
                             <td></td>
                             
                    </tr> 
                    
                     <tr>     
                        <td >
                            <b>VAT IN Total Balance</b></td>
                           <td colspan="3"><b>{{ number_format(abs($vat_in),2) }}</b></td>
                            
                             
                    </tr> 
 
                        </tfoot>
                            </table>


                            <table class="table datatable-vo table-striped"><h4>VAT OUT </h4>
<thead>
                    <tr>
                       <th>Date</th>
                            <th>Debit</th>
                        <th>Credit</th>
                      <th>Note</th>
                    </tr>
                    </thead>
 <tbody>   
 <?php
                         $vat_out = \App\Models\AccountCodes::where('account_name', 'VAT OUT')->where('added_by',auth()->user()->added_by)->first();
                         
                         
                                if(!empty($branch_id) && $branch_id != $a){
                        $account_out = \App\Models\JournalEntry::where('account_id', $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->orderBy('date','desc')->get();
                            
                          }
                          else{
                              
                          $account_out = \App\Models\JournalEntry::where('account_id', $vat_out->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->orderBy('date','desc')->get();
                          }
                          
                        
                            
                       
                        ?>  
                 @foreach($account_out  as $a_out)
                                 <tr>
                        <td >{{Carbon\Carbon::parse($a_out->date)->format('d/m/Y') }}</td>
                          <td>{{ number_format($a_out->debit ,2) }}</td>
                   <td >{{ number_format($a_out->credit ,2) }}</td>
                       <td >{{ $a_out->notes }}</td>
                    </tr> 

                @endforeach
                
          </tbody>  
    
 <?php
                   
                        


                               if(!empty($branch_id) && $branch_id != $a){
                        $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                          }
                          else{
                              
                           $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                          }
                          
                            $vat_out=$cr_out-$dr_out;


                        ?> 
                        <tfoot>
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b>{{ number_format($dr_out,2) }}</b></td>
                            <td><b>{{ number_format($cr_out,2) }}</b></td>
                             <td></td>
                             
                    </tr> 
                    
                     <tr>     
                        <td >
                            <b>VAT OUT Total Balance</b></td>
                           <td colspan="3"><b>{{ number_format(abs($vat_out),2) }}</b></td>
                            
                             
                    </tr> 

                        </tfoot>
                            </table>


<br>
                            <table class="table table-bordered table-striped">

 <tbody>   

  <tr>
                        <td >
                              <b>{{$account_code->account_name }} Total Balance</b></td>    
                                                          @if ($total_in - $total_out < 0)
                                   
                                        <td><b>{{ number_format(abs($vat_in - $vat_out) ,2) }} </b>  </td>
                                
                           @else
                                  <td><b>{{ number_format(abs($vat_in - $vat_out) ,2) }} </b> </td>
                               
                           @endif 
                       

                       

                    </tr> 
                        </tbody>
                            </table>
                           </div>

        </div>
       
 <div class="modal-footer ">
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
    </div>
</div>
  </div>
  
  
  
@elseif($account_code->account_name == 'Deffered Tax')                        
  <!-- Modal -->
  <div class="modal fade "id="deff{{$account_code->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_code->account_codes }} - {{$account_code->account_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                            <table class="table datatable-deff table-striped">
 
<thead>
                    <tr>
                     <th>Date</th>
                          <th>Debit</th>
                        <th>Credit</th>
           <th>Note</th>
         
                    </tr>
                    </thead>
                              
<tbody>   
 <?php
 
                          if(!empty($branch_id) && $branch_id != $a){
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereIn('branch_id', $br_id)->where('date', '<=',$start_date)
                        ->where('added_by',auth()->user()->added_by)->orderBy('date','desc')->get();
                            
                       
                            
                          }
                          else{
                              
                             $account = \App\Models\JournalEntry::where('account_id', $account_code->id)->where('added_by',auth()->user()->added_by)->where('date', '<=',$start_date)
                             ->orderBy('date','desc')->get();
                            
                          }
                          
                          
                        ?>  
                        
                         <tr>
                        <td >{{Carbon\Carbon::parse($start_date)->format('d/m/Y') }}</td>
                          <td>{{ number_format(0 ,2) }}</td>
                   <td >{{ number_format($net_profit['tax_for_second_date'] ,2) }}</td>
                       <td >Tax From Income Statement</td>
                    </tr> 
                    
                 @foreach($account  as $ac)
                                 <tr>
                        <td >{{Carbon\Carbon::parse($ac->date)->format('d/m/Y') }}</td>
                          <td>{{ number_format($ac->debit ,2) }}</td>
                   <td >{{ number_format($ac->credit ,2) }}</td>
                       <td >{{ $ac->notes }}</td>
                    </tr> 

                @endforeach
                
      </tbody>  
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
                            

                        ?>  
                        <tfoot>
                       <tr>     
                        <td>
                             <b>Total Balance</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr + $net_profit['tax_for_second_date'],2) }}</b></td>
 <td></td>
                    </tr> 

                      <tr>     
                        <td>
                             <b>{{$account_code->account_name }} Total Balance</b></td>
                             <td colspan="3"><b>{{ number_format( ($cr+$net_profit['tax_for_second_date']) - $dr,2) }}</b></td>
                    </tr> 
  </tfoot>
 
                   

 </table>
                           </div>

        </div>
       
 <div class="modal-footer ">
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
    </div>
</div></div>
  </div>
  
@elseif($account_code->account_codes  == 31101) 
   <div class="modal fade" id="np{{$account_code->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_code->account_codes }} - {{$account_code->account_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                            <table class="table datatable-eq table-striped">
       
                      
<thead>
                    <tr>
                   <th>Account Name</th>
                        <th>Account Code</th>
                          <th>Balance</th>
         
                    </tr>
                    </thead>
                              <tbody>
 <tr>
                        <td colspan="3" style="text-align: left"><b>Income</b></td>
                    </tr>

  <?php   
$total_incomes_start   = 0;
$total_other_incomes_start   = 0;
$cost_balance_start   = 0;
$total_cost_start   = 0;
$expense_balance_start   = 0;
$total_expense_start   = 0;
$gross_start   = 0;
$profit_start =0;
$tax_start =0;
$net_profit_start =0;
$total_debit_income_balance_start  =0 ;
 $total_credit_income_balance_start   =0 ;
  $total_debit_other_income_balance_start    =0 ;
  $total_credit_other_income_balance_start   =0 ;
   $total_debit_cost_balance_start    =0 ;
   $total_credit_cost_balance_start   =0 ;
   $total_debit_expense_balance_start    =0 ;
   $total_credit_expense_balance_start   =0 ;
$gross_dr_start   = 0;
$gross_cr_start   = 0;
$tax_dr_start =0;
$tax_cr_start =0;
$profit_dr_start =0;
$profit_cr_start =0;   
$net_profit_dr_start =0;
$net_profit_cr_start =0;   

foreach($income->where('added_by',auth()->user()->added_by) as $account_class_modal){
foreach($account_class_modal->groupAccount->where('added_by',auth()->user()->added_by)  as $group_modal) {  
if($group_modal->group_id != 5110){
foreach($group_modal->accountCodes->where('added_by',auth()->user()->added_by) as $account_code_modal){
     
     
                          if(!empty($branch_id) && $branch_id != $a){
                        $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_start = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                             $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }

                         $total_debit_income_balance_start  +=$dr_start  ;
                         $total_credit_income_balance_start  +=$cr_start ;

                          $income_balance_start =$dr_start - $cr_start ;
                          $total_incomes_start +=$income_balance_start  ;
                          ?>
<tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format(abs($income_balance_start),2) }}</td>
</tr>                
  <?php  

    }}}}           
?>

<tr>
                        <td >
                            <b>Total Income</b></td>
                       <td></td>
                            <td>{{ number_format(abs($total_incomes_start),2) }}</td>                           
                    </tr> 
<!--
 
                        <td colspan="3" style="text-align: left"><b> Financial Cost</b></td>
                    </tr>
  <?php  
foreach($cost->where('added_by',auth()->user()->added_by) as $account_class_modal){
foreach($account_class_modal->groupAccount->where('added_by',auth()->user()->added_by)  as $group_modal) {
if($group->group_id == 6180){
foreach($group_modal->accountCodes->where('added_by',auth()->user()->added_by) as $account_code_modal){


                    if(!empty($branch_id) && $branch_id != $a){
                        $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_start = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                             $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }
                            
                        $total_debit_cost_balance_start    +=$dr_start  ;
                         $total_credit_cost_balance_start   +=$cr_start ;

                        $cost_balance_start =$dr_start - $cr_start ;
                        $total_cost_start +=$cost_balance_start  ;

  ?>
<tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format(abs($cost_balance_start),2) }}</td>
</tr>                
  <?php  

                            
}}}}
?>

<tr>
                        <td >
                             <b>Total Financial Cost</b></td>
                       <td></td>
      <td>{{ number_format(abs($total_cost_start),2) }}</td>
                    </tr> 
-->

  <?php  

if($total_other_incomes_start < 0){
$total_o_start=$total_other_incomes_start * -1;
}
else if($total_other_incomes_start >= 0){
$total_o_start=$total_other_incomes_start ;
}


if($total_incomes_start < 0){
$total_s_start=$total_incomes_start * -1;
$gross_start=$total_s_start+$total_o_start-$total_cost_start;
}
else if($total_incomes_start >= 0){
$gross_start=$total_incomes_start+$total_o_start-$total_cost_start;
}



?>
<!--
  <tr>
                        <td >
                            <b>Gross Profit</b></td>
                    <td></td>
                            <td><b>{{ number_format($gross_start ,2) }}</b></td>
                    </tr> 
-->

<tr>
                        <td colspan="3" style="text-align: left"><b>Expenses</b></td>
                    </tr>
  <?php  
foreach($expense->where('added_by',auth()->user()->added_by) as $account_class_modal){
foreach($account_class_modal->groupAccount->where('added_by',auth()->user()->added_by)  as $group_modal)  {      
if($group->group_id != 6180){
foreach($group_modal->accountCodes->where('added_by',auth()->user()->added_by) as $account_code_modal){

                   if(!empty($branch_id) && $branch_id != $a){
                        $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_start = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->whereIn('branch_id', $br_id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         }else{
                            
                             $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->id)->where('date', '<=',
                            $start_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                            }

                            
                           $total_debit_expense_balance_start    +=$dr_start  ;
                         $total_credit_expense_balance_start   +=$cr_start ;

                $expense_balance_start =$dr_start - $cr_start ;
                $total_expense_start +=$expense_balance_start  ;
                          
  ?>
  <tr>
  <td>{{$account_code_modal->account_name }}</td>
<td>{{$account_code_modal->account_codes }}</td>
  <td>{{ number_format(abs($expense_balance_start ),2) }}</td>
       </tr>             
  <?php  

}}}}

?>

<tr>
                        <td >
                             <b>Total Expenses</b></td>
                       <td></td>
                               <td>{{ number_format($total_expense_start ,2) }}</td>
                    </tr> 

  <?php  

if($gross_start  < 0){
$profit_start =$gross_start + $total_expense_start ;
}
else if($gross_start  < 0 &&  $total_expense_start   < 0){
$profit_start =$gross_start + $total_expense_start ;
}
else if($gross_start  >= 0 &&  $total_expense_start   < 0){
$profit_start = $total_expense_start  +$gross_start ;
}
else{
$profit_start =$gross_start -$total_expense_start ;
}


if($profit_start > 0){
$tax_start =$profit_start *0.3;
}

?>

<tr>
                        <td>
                           <b>Profit Before Tax</b></td>
                            <td></td>
                                 <td><b>{{ number_format($profit_start ,2) }}</b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>Tax</b></td>
                         <td></td>
                              <td><b>{{ number_format($tax_start ,2) }}</b></td>
                    </tr>
                   
<tr>
                      <td colspan=2>
                           <b>{{$account_code->account_name }} Total Balance</b></td>
                        <td colspan=2><b>{{ number_format($profit_start-$tax_start,2) }}</b></td>
                    </tr>


   
 </tbody>
                            </table>
                           </div>

        </div>
       
 <div class="modal-footer ">
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
    </div>
</div></div>
  </div>
  
@endif

  @endforeach
@endforeach
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
    
    <script>
        
         $('.datatable-deff').DataTable({
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
    
     <script>
       $('.datatable-vi').DataTable({
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
    
    
     <script>
       $('.datatable-vo').DataTable({
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

@endsection