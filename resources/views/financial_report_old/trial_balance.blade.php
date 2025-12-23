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
               

   <div class="col-md-12">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

@if(!empty($start_date))
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle "
                                    data-toggle="dropdown">Download Report
                                <span class="caret"></span></button>
                            <div class="dropdown-menu">
                              
                                    <li class="nav-item"><a class="nav-link" href="{{url('financial_report/trial_balance/pdf?start_date='.$start_date.'&end_date='.$second_date)}}"
                                       target="_blank"><i
                                                class="icon-file-pdf"></i>  Download PDF
                                    </a></li>
                                
                                    <li class="nav-item"><a class="nav-link" href="{{url('financial_report/trial_balance/excel?start_date='.$start_date.'&end_date='.$second_date)}}"
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
     
     @foreach($data->where('added_by',auth()->user()->added_by) as $account_class)
<?php    $c++ ;  ?>

 
                          <tr>
                        <td colspan="5" style="text-align: center"><b>{{ $c }} . {{ $account_class->class_name  }}</b></td>
                        <?php if($c == 1){ ?>
                           
                           
                    <?php    } ?>
                    </tr>

   <?php                              

$d=0;
?>
               
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)
 @if($group->name != 'Retained Earnings/Loss')
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
    
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)

 @if($account_code->account_name != 'Deffered Tax' && $account_code->account_name != 'Value Added Tax (VAT)')
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
 <td><a href="#view{{$account_code->id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>

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

                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->id)->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->id)->sum('debit'); 

                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            

                        //$credit_total = $credit_total + $cr  ;
                        //$debit_total = $debit_total + $dr ;

                       
                        if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense'){
                            $debit_total += $dr-$cr ;
                        }
                        else{
                            $credit_total += $cr-$dr ;
                        }

                             //$balance3 = 0;
                         if($account_code->account_codes == 2206){
                      ?>
                         
                        

                  <?php

                         }

                      else{

    ?>
                         @if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense')
                                        <td>{{ number_format($dr-$cr ,2) }}  </td>
                                 <td>{{ number_format(0 ,2) }} </td>
                           @else
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
 <td><a href="#vat{{$account_code->id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>

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

                        $cr_in = \App\Models\JournalEntry::where('account_id', $vat_in->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id', $vat_in->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit'); 

                        $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id', $vat_out->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            

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

@endif  
   @endforeach   
 @endif             
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
     @foreach($data->where('added_by',auth()->user()->added_by) as $account_class)
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)  as $group)
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by) as $account_code)
   @if($account_code->account_name != 'Value Added Tax (VAT)')                   
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
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->orderBy('date','asc')->get();
                            
                       $account1 = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->orderBy('date','asc')->get();
                        ?>  
                 @foreach($account->where('added_by',auth()->user()->added_by)  as $a)
                                 <tr>
                        <td >{{$a->date }}</td>
                          <td>{{ number_format($a->debit ,2) }}</td>
                   <td >{{ number_format($a->credit ,2) }}</td>
                       <td >{{ $a->notes }}</td>
                    </tr> 

                @endforeach
                
            
    
 <?php
                   
                        $cr_modal = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_modal = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                         $cr_modal1 = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_modal1 = \App\Models\JournalEntry::where('account_id', $account_code->id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b>{{ number_format($dr_modal,2) }}</b></td>
                            <td><b>{{ number_format($cr_modal,2) }}</b></td>
                             <td></td>
                             
                    </tr> 
  <tr>
                        <td >
                              <b>{{$account_code->account_name }} Total Balance</b></td>                           
                            @if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense')
     <td colspan="3"><b>{{ number_format($dr_modal-$cr_modal ,2) }} </b></td>                                
                           @else
                         <td colspan="3"><b>{{ number_format($cr_modal-$dr_modal ,2) }} </b></td>
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

@yield('scripts')


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

@else
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
                            <table class="table table-bordered table-striped"><h4>VAT IN </h4>
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
                        $account = \App\Models\JournalEntry::where('account_id', $vat_in->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->orderBy('date','asc')->get();
                            
                       
                        ?>  
                 @foreach($account  as $a)
                                 <tr>
                        <td >{{$a->date }}</td>
                          <td>{{ number_format($a->debit ,2) }}</td>
                   <td >{{ number_format($a->credit ,2) }}</td>
                       <td >{{ $a->notes }}</td>
                    </tr> 

                @endforeach
                
            
    
 <?php
                   
                        $cr_in = \App\Models\JournalEntry::where('account_id',  $vat_in->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id',  $vat_in->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                       $vat_in= $dr_in- $cr_in;


                        ?>  
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b>{{ number_format($dr_in,2) }}</b></td>
                            <td><b>{{ number_format($cr_in,2) }}</b></td>
                             <td></td>
                             
                    </tr> 
 
                        </tbody>
                            </table>


                            <table class="table table-bordered table-striped"><h4>VAT OUT </h4>
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
                        $account_out = \App\Models\JournalEntry::where('account_id', $vat_out->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->orderBy('date','asc')->get();
                            
                       
                        ?>  
                 @foreach($account_out  as $a_out)
                                 <tr>
                        <td >{{$a_out->date }}</td>
                          <td>{{ number_format($a_out->debit ,2) }}</td>
                   <td >{{ number_format($a_out->credit ,2) }}</td>
                       <td >{{ $a_out->notes }}</td>
                    </tr> 

                @endforeach
                
            
    
 <?php
                   
                        $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('added_by',auth()->user()->added_by)->sum('debit');

                            $vat_out=$cr_out-$dr_out;


                        ?>  
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b>{{ number_format($dr_out,2) }}</b></td>
                            <td><b>{{ number_format($cr_out,2) }}</b></td>
                             <td></td>
                             
                    </tr> 

                        </tbody>
                            </table>


                            <table class="table table-bordered table-striped">

 <tbody>   

  <tr>
                        <td >
                              <b>{{$account_code->account_name }} Total Balance</b></td>    
                                                          @if ($total_in - $total_out < 0)
                                    <td> </td>
                                        <td><b>{{ number_format(abs($vat_in - $vat_out) ,2) }} </b>  </td>
                                
                           @else
                                  <td><b>{{ number_format(abs($vat_in - $vat_out) ,2) }} </b> </td>
                                <td> </td>
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

@endsection