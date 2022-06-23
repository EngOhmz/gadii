@extends('layouts.master')


@section('contents')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Trial Balance   </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Trial Balance  Report
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
        <div class="panel-heading">
            <h6 class="panel-title">
              Trial Balance 
             @if(!empty($start_date))
                    for the period: <b>{{$start_date}} to {{$second_date}}</b>
                @endif
             @if(!empty($end_date))
                   and for the period: <b>{{$second_date}} to {{$end_date}}</b>
                @endif
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

                <div class="col-md-4">
                    <label class="">Start Date</label>
                    {!! Form::date('start_date',$start_date, array('class' => 'form-control date-picker', 'placeholder'=>"First Date",'required'=>'required')) !!}
                </div>
                   <div class="col-md-4">
                    <label class="">Second Date</label>
                    {!! Form::date('second_date',$second_date, array('class' => 'form-control date-picker', 'placeholder'=>"Second Date" ,'required' => 'required')) !!}}
                </div>
                <div class="col-md-4">
                    <label class="">End Date</label>
                   {!! Form::date('end_date',$end_date, array('class' => 'form-control date-picker', 'placeholder'=>"Third Date",'required'=>'required')) !!}
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
                         <th colspan="7"><center>TRIAL BALANCE FOR THE PERIOD BETWEEN {{$start_date}} To {{$second_date}} AND {{$second_date}} To {{$end_date}}  </center></th>
                       
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
                          <tr>
                        <td colspan="3" style="text-align: center"><b>{{ $c }} . {{ $account_class->class_name  }}</b></td>
                        <?php if($c == 1){ ?>
                           
                               <td colspan="2" style="text-align: center">{{$second_date}} To {{$end_date}}</td>
                           <td colspan="2" style="text-align: center">{{$start_date}} To {{$second_date}}</td>
                           
                    <?php    } ?>
                    </tr>

   <?php                              

$d=0;
?>
               
  @foreach($account_class->groupAccount  as $group)
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
                  <td colspan="">Dr</td>
                  <td colspan="">Cr</td>
                  <?php    }else{ ?>
                   <td colspan="4"></td>
                
                  <?php    } ?>
                   </tr>
    
@foreach($group->accountCodes as $account_code)
 @if($account_code->account_codes != 2206)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
 <td><a href="#view{{$account_code->account_id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>

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

                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit'); 

                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            
                        $cr2 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr2 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit'); 

                             
                          $credit_total = $credit_total + $cr2  ;
                        $debit_total = $debit_total + $dr2 ;

                             $total_d+=$dr;
                             $total_d2+=$dr2-$cr2;
                                  $total_c+=$cr;


                             //$balance3 = 0;
                         if($account_code->account_codes == 2206){
                      ?>
                         
                        

                  <?php

                         }

                      else{

    ?>
                         @if ($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense')
                                 <td>{{ number_format($dr2-$cr2 ,2) }}  </td>
                                 <td>{{ number_format(0 ,2) }} </td>
                                        <td>{{ number_format($dr-$cr ,2) }}  </td>
                                 <td>{{ number_format(0 ,2) }} </td>
                           @else
                             <td>{{ number_format(0 ,2) }} </td>
                            <td>{{ number_format($cr2-$dr2 ,2) }}  </td> 
                                <td>{{ number_format(0 ,2) }} </td>
                            <td>{{ number_format($cr-$dr ,2) }}  </td> 
                           @endif 
                           
                          
                         
<?php
                         } 
                        ?>
                        
                           

                           
                        
</tr>
@endif  
   @endforeach   
 @endif             
  @endforeach
  @endforeach
 
                    </tbody>
<!--
 <tfoot>
                    <tr>
                        <td colspan="3" align><b>{{trans_choice('general.total',1)}}</b></td>
                        <td>{{number_format($debit_total,2)}}</td>
                        <td>{{number_format($credit_total,2)}}</td>
                        <td></td>
                    </tr>
                    </tfoot>
                  
 -->                   
                    
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
     @foreach($data as $account_class)
  @foreach($account_class->groupAccount  as $group)
@foreach($group->accountCodes as $account_code)
                       
  <!-- Modal -->
  <div class="modal inmodal " id="view{{$account_code->account_id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog"><div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_code->account_codes }} - {{$account_code->account_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                            <table class="table table-bordered table-striped">
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
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->orderBy('date','asc')->get();
                            
                       $account1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->orderBy('date','asc')->get();
                        ?>  
                 @foreach($account  as $a)
                                 <tr>
                        <td >{{$a->date }}</td>
                          <td>{{ number_format($a->debit ,2) }}</td>
                   <td >{{ number_format($a->credit ,2) }}</td>
                       <td >{{ $a->name }}</td>
                    </tr> 

                @endforeach
                
            
    
 <?php
                   
                        $cr_modal = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_modal = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            
                         $cr_modal1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_modal1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$second_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

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
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div></div>
  </div>
  @endforeach
@endforeach
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