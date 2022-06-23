@extends('layouts.master')
@section('title')
    {{trans_choice('general.balance',1)}} {{trans_choice('general.sheet',1)}}
@endsection
@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">
                {{trans_choice('general.balance',1)}} {{trans_choice('general.sheet',1)}}

                @if(!empty($start_date))
                    as at: <b>{{$start_date}} </b>
                @endif
                          @if(!empty($end_date))
                    as at: <b>{{$end_date}} </b>
                @endif
            </h6>
            
          
            <div class="heading-elements">

            </div>
        </div>
        <div class="panel-body hidden-print">
            <h4 class="">{{trans_choice('general.date',1)}} {{trans_choice('general.range',1)}}</h4>
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">
                
                
                <div class="col-xs-5">
                    {!! Form::text('start_date',$start_date, array('class' => 'form-control date-picker', 'placeholder'=>"Start Date")) !!}
                </div>
                        <div class="col-xs-5 ">
                    {!! Form::text('end_date',$end_date, array('class' => 'form-control date-picker', 'placeholder'=>"End Date")) !!}
                </div>         
                
            
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">

                        <button type="submit" class="btn btn-success">{{trans_choice('general.search',1)}}!
                        </button>


                        <a href="{{Request::url()}}"
                           class="btn btn-danger">{{trans_choice('general.reset',1)}}!</a>

                        <div class="btn-group">
                            <button type="button" class="btn bg-blue dropdown-toggle legitRipple"
                                    data-toggle="dropdown">{{trans_choice('general.download',1)}} {{trans_choice('general.report',1)}}
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a href="{{url('report/financial_report/balance_sheet/pdf?start_date='.$start_date.'')}}"
                                       target="_blank"><i
                                                class="icon-file-pdf"></i> {{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.pdf',1)}}
                                    </a></li>
                                <li>
                                    <a href="{{url('report/financial_report/balance_sheet/excel?start_date='.$start_date.'')}}"
                                       target="_blank"><i
                                                class="icon-file-excel"></i> {{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.excel',1)}}
                                    </a></li>
                                <li>
                                    <a href="{{url('report/financial_report/balance_sheet/csv?start_date='.$start_date.'')}}"
                                       target="_blank"><i
                                                class="icon-download"></i> {{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.csv',1)}}
                                    </a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
        <!-- /.panel-body -->

    </div>
    <!-- /.box -->
    @if(!empty($start_date))
        <div class="panel panel-white col-lg-8">
            <div class="panel-body table-responsive no-padding">

                <table class="table table-bordered table-condensed table-hover">
                    <thead>
                    <tr class="bg-green">
                 <th>#</th>
                        <th>{{trans_choice('general.account_name',1)}}</th>
                        <th>{{trans_choice('general.account_codes',2)}}</th>
                    <th>{{trans_choice('general.debit',1)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                        
                    </tr>
                    </thead>
                   <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center"><b>{{trans_choice('general.asset',2)}}</b></td>
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
?>            
     
     @foreach($asset as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="3"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
​<td><a href="#view{{$account_code->account_id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>
   <!-- Modal Start -->
                    <div class="modal fade" id="view{{$account_code->account_id}}" tabindex="-1" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" align ="center"> {{$account_code->account_codes }} - {{$account_code->account_name }}</h4>
                          </div>
                          <div class="modal-body">
                              <div class="table-responsive">
                            <table class="table table-bordered table-striped table-responsive">
<thead>
                    <tr class="bg-green">
                       <th>{{trans_choice('general.date',1)}}</th>
                          <th>{{trans_choice('general.debit',2)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                    </tr>
                    </thead>
                              <tbody>
                    <?php                   
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->orderBy('date','asc')->get();
                        ?>  
                 @foreach($account  as $a)
                                 <tr>
                        <td >{{$a->date }}</td>
                          <td>{{ number_format($a->debit ,2) }}</td>
                   <td >{{ number_format($a->credit ,2) }}</td>
                    </tr> 

  @endforeach
    
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                             <b>{{$account_code->account_name }} {{trans_choice('general.total',1)}} {{trans_choice('general.balance',1)}}</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
                    </tr> 
 
                              </tbody>
                            </table>
                           </div>
                          </div>
                          <div class="modal-footer"></div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_assets +=$dr ;
                         $total_credit_assets +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              
  @endforeach
  @endforeach
 
           <tr>
                        <td colspan="3" style="text-align: right">
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.asset',2)}}</b></td>
                        <td><b>{{ number_format($total_debit_assets,2) }}</b></td>
                        <td><b>{{ number_format($total_credit_assets,2) }}</b></td>

                    </tr>            
                   


                    <tr>
                        <td colspan="5" style="text-align: center "><b>{{trans_choice('general.liability',2)}}</b></td>
                    </tr>
                     @foreach($liability  as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="3"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
​<td><a href="#view{{$account_code->account_id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>
   <!-- Modal Start -->
                    <div class="modal fade" id="view{{$account_code->account_id}}" tabindex="-1" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" align ="center"> {{$account_code->account_codes }} - {{$account_code->account_name }}</h4>
                          </div>
                          <div class="modal-body">
                              <div class="table-responsive">
                            <table class="table table-bordered table-striped table-responsive">
<thead>
                    <tr class="bg-green">
                       <th>{{trans_choice('general.date',1)}}</th>
                          <th>{{trans_choice('general.debit',2)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                    </tr>
                    </thead>
                              <tbody>
                    <?php                   
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->orderBy('date','asc')->get();
                        ?>  
                 @foreach($account  as $a)
                                 <tr>
                        <td >{{$a->date }}</td>
                          <td>{{ number_format($a->debit ,2) }}</td>
                   <td >{{ number_format($a->credit ,2) }}</td>
                    </tr> 

  @endforeach
    
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                             <b>{{$account_code->account_name }} {{trans_choice('general.total',1)}} {{trans_choice('general.balance',1)}}</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
                    </tr> 
 
                              </tbody>
                            </table>
                           </div>
                          </div>
                          <div class="modal-footer"></div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_liability  +=$dr ;
                         $total_credit_liability  +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              ​
 ​@endforeach
 ​@endforeach


  ​<tr>
                       ​<td colspan="3" style="text-align: right">
                           ​<b>{{trans_choice('general.total',1)}} {{trans_choice('general.liability',2)}}</b></td>
                       ​<td><b>{{ number_format($total_debit_liability ,2) }}</b></td>
                       ​<td><b>{{ number_format($total_credit_liability,2) }}</b></td>

                   ​</tr>     
                       


<tr>
                        <td colspan="5" style="text-align: center"><b>{{trans_choice('general.equity',2)}}</b></td>
                    </tr>
    @foreach($equity   as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="3"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
​<td><a href="#view{{$account_code->account_id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>
   <!-- Modal Start -->
                    <div class="modal fade" id="view{{$account_code->account_id}}" tabindex="-1" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" align ="center"> {{$account_code->account_codes }} - {{$account_code->account_name }}</h4>
                          </div>
                          <div class="modal-body">
                              <div class="table-responsive">
                            <table class="table table-bordered table-striped table-responsive">
<thead>
                    <tr class="bg-green">
                       <th>{{trans_choice('general.date',1)}}</th>
                          <th>{{trans_choice('general.debit',2)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                    </tr>
                    </thead>
                              <tbody>
                    <?php                   
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->orderBy('date','asc')->get();
                        ?>  
                 @foreach($account  as $a)
                                 <tr>
                        <td >{{$a->date }}</td>
                          <td>{{ number_format($a->debit ,2) }}</td>
                   <td >{{ number_format($a->credit ,2) }}</td>
                    </tr> 

  @endforeach
    
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                             <b>{{$account_code->account_name }} {{trans_choice('general.total',1)}} {{trans_choice('general.balance',1)}}</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
                    </tr> 
 
                              </tbody>
                            </table>
                           </div>
                          </div>
                          <div class="modal-footer"></div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $start_date)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_equity   +=$dr ;
                         $total_credit_equity   +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              ​
 ​@endforeach
 ​@endforeach
                   
                                      <tr>
                        <td colspan="3" style="text-align: right">
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.equity',2)}}</b></td>
                       ​<td><b>{{ number_format($total_debit_equity ,2) }}</b></td>
                       ​<td><b>{{ number_format($total_credit_equity,2) }}</b></td>
                    </tr>

                    </tbody>
                    <tfoot>
                    
                                                
                    <tr>
                        <td colspan="3" style="text-align: right">
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.liability',2)}} {{trans_choice('general.and',1)}} {{trans_choice('general.equity',2)}}</b>
                        </td>
                        <td><b>{{ number_format($total_debit_liability+$total_debit_equity ,2) }}</b></td>

                        <td><b>{{ number_format($total_credit_liability+$total_credit_equity,2) }}</b></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

@else
        <div class="panel panel-white col-lg-8">
            <div class="panel-body table-responsive no-padding">

                <table class="table table-bordered table-condensed table-hover">
                    <thead>
                    <tr class="bg-green">
                       <th>#</th>
                        <th>{{trans_choice('general.account_name',1)}}</th>
                        <th>{{trans_choice('general.account_codes',2)}}</th>
                    <th>{{trans_choice('general.debit',1)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center"><b>{{trans_choice('general.asset',2)}}</b></td>
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
?>            
     
     @foreach($asset as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="3"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
 <td><a href="#view{{$account_code->account_id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>
   <!-- Modal Start -->
                    <div class="modal fade" id="view{{$account_code->account_id}}" tabindex="-1" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" align ="center"> {{$account_code->account_codes }} - {{$account_code->account_name }}</h4>
                          </div>
                          <div class="modal-body">
                              <div class="table-responsive">
                            <table class="table table-bordered table-striped table-responsive">
<thead>
                    <tr class="bg-green">
                       <th>{{trans_choice('general.date',1)}}</th>
                          <th>{{trans_choice('general.debit',2)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                    </tr>
                    </thead>
                              <tbody>
                    <?php                   
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->orderBy('date','asc')->get();
                        ?>  
                 @foreach($account  as $a)
                                 <tr>
                        <td >{{$a->date }}</td>
                          <td>{{ number_format($a->debit ,2) }}</td>
                   <td >{{ number_format($a->credit ,2) }}</td>
                    </tr> 

  @endforeach
    
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                             <b>{{$account_code->account_name }} {{trans_choice('general.total',1)}} {{trans_choice('general.balance',1)}}</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
                    </tr> 
 
                              </tbody>
                            </table>
                           </div>
                          </div>
                          <div class="modal-footer"></div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_assets +=$dr ;
                         $total_credit_assets +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              
  @endforeach
  @endforeach
 
           <tr>
                        <td colspan="3" style="text-align: right">
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.asset',2)}}</b></td>
                        <td><b>{{ number_format($total_debit_assets,2) }}</b></td>
                        <td><b>{{ number_format($total_credit_assets,2) }}</b></td>

                    </tr>            
                   


                    <tr>
                        <td colspan="5" style="text-align: center "><b>{{trans_choice('general.liability',2)}}</b></td>
                    </tr>
                     @foreach($liability  as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="3"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
<td><a href="#view{{$account_code->account_id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>
   <!-- Modal Start -->
                    <div class="modal fade" id="view{{$account_code->account_id}}" tabindex="-1" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" align ="center"> {{$account_code->account_codes }} - {{$account_code->account_name }}</h4>
                          </div>
                          <div class="modal-body">
                              <div class="table-responsive">
                            <table class="table table-bordered table-striped table-responsive">
<thead>
                    <tr class="bg-green">
                       <th>{{trans_choice('general.date',1)}}</th>
                          <th>{{trans_choice('general.debit',2)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                    </tr>
                    </thead>
                              <tbody>
                    <?php                   
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->orderBy('date','asc')->get();
                        ?>  
                 @foreach($account  as $a)
                                 <tr>
                        <td >{{$a->date }}</td>
                          <td>{{ number_format($a->debit ,2) }}</td>
                   <td >{{ number_format($a->credit ,2) }}</td>
                    </tr> 

  @endforeach
    
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                             <b>{{$account_code->account_name }} {{trans_choice('general.total',1)}} {{trans_choice('general.balance',1)}}</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
                    </tr> 
 
                              </tbody>
                            </table>
                           </div>
                          </div>
                          <div class="modal-footer"></div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_liability  +=$dr ;
                         $total_credit_liability  +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              ​
 ​@endforeach
 ​@endforeach


  ​<tr>
                       ​<td colspan="3" style="text-align: right">
                           ​<b>{{trans_choice('general.total',1)}} {{trans_choice('general.liability',2)}}</b></td>
                       ​<td><b>{{ number_format($total_debit_liability ,2) }}</b></td>
                       ​<td><b>{{ number_format($total_credit_liability,2) }}</b></td>

                   ​</tr>     
                       


<tr>
                        <td colspan="5" style="text-align: center"><b>{{trans_choice('general.equity',2)}}</b></td>
                    </tr>
    @foreach($equity   as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="3"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
<td><a href="#view{{$account_code->account_id}}" data-toggle="modal"">{{$account_code->account_codes }}</a>
   <!-- Modal Start -->
                    <div class="modal fade" id="view{{$account_code->account_id}}" tabindex="-1" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" align ="center"> {{$account_code->account_codes }} - {{$account_code->account_name }}</h4>
                          </div>
                          <div class="modal-body">
                              <div class="table-responsive">
                            <table class="table table-bordered table-striped table-responsive">
<thead>
                    <tr class="bg-green">
                       <th>{{trans_choice('general.date',1)}}</th>
                          <th>{{trans_choice('general.debit',2)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                    </tr>
                    </thead>
                              <tbody>
                    <?php                   
                        $account = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->orderBy('date','asc')->get();
                        ?>  
                 @foreach($account  as $a)
                                 <tr>
                        <td >{{$a->date }}</td>
                          <td>{{ number_format($a->debit ,2) }}</td>
                   <td >{{ number_format($a->credit ,2) }}</td>
                    </tr> 

  @endforeach
    
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                             <b>{{$account_code->account_name }} {{trans_choice('general.total',1)}} {{trans_choice('general.balance',1)}}</b></td>
                           <td><b>{{ number_format($dr,2) }}</b></td>
                            <td><b>{{ number_format($cr,2) }}</b></td>
                    </tr> 
 
                              </tbody>
                            </table>
                           </div>
                          </div>
                          <div class="modal-footer"></div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_equity   +=$dr ;
                         $total_credit_equity   +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              ​
 ​@endforeach
 ​@endforeach
                   
                                      <tr>
                        <td colspan="3" style="text-align: right">
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.equity',2)}}</b></td>
                       ​<td><b>{{ number_format($total_debit_equity ,2) }}</b></td>
                       ​<td><b>{{ number_format($total_credit_equity,2) }}</b></td>
                    </tr>

                    </tbody>
                    <tfoot>
                    
                            
                    
                    <tr>
                        <td colspan="3" style="text-align: right">
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.liability',2)}} {{trans_choice('general.and',1)}} {{trans_choice('general.equity',2)}}</b>
                        </td>
                        <td><b>{{ number_format($total_debit_liability+$total_debit_equity ,2) }}</b></td>

                        <td><b>{{ number_format($total_credit_liability+$total_credit_equity,2) }}</b></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif

  @if(!empty($end_date))
        <div class="panel panel-white col-lg-4">
            <div class="panel-body table-responsive no-padding">

                <table class="table table-bordered table-condensed table-hover">
                    <thead>
                    <tr class="bg-green">

                    <th>{{trans_choice('general.debit',1)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                        
                    </tr>
                    </thead>
                   <tbody>
                    <tr>
                        <td colspan="1" style="text-align: center"><b>&nbsp;</b></td>
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
?>            
     
     @foreach($asset as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >&nbsp; </td>
                        <td ><b>&nbsp;</b></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>

 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $end_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $end_date)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_assets +=$dr ;
                         $total_credit_assets +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              
  @endforeach
  @endforeach
 
           <tr>
                       
                        <td><b>{{ number_format($total_debit_assets,2) }}</b></td>
                        <td><b>{{ number_format($total_credit_assets,2) }}</b></td>

                    </tr>            
                   


                    <tr>
                        <td colspan="1" style="text-align: center "><b>&nbsp;</b></td>
                    </tr>
                     @foreach($liability  as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >&nbsp;</td>
                        <td ><b>&nbsp;</b></td>

                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>

 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $end_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $end_date)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_liability  +=$dr ;
                         $total_credit_liability  +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              ​
 ​@endforeach
 ​@endforeach


  ​<tr>

                       ​<td><b>{{ number_format($total_debit_liability ,2) }}</b></td>
                       ​<td><b>{{ number_format($total_credit_liability,2) }}</b></td>

                   ​</tr>     
                       


<tr>
                        <td colspan="1" style="text-align: center"><b>&nbsp;</b></td>
                    </tr>
    @foreach($equity   as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >&nbsp; </td>
                        <td ><b>&nbsp;</b></td>

                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>

 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $end_date)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('date', '<=',
                            $end_date)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_equity   +=$dr ;
                         $total_credit_equity   +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              ​
 ​@endforeach
 ​@endforeach
                   
                                      <tr>

                       ​<td><b>{{ number_format($total_debit_equity ,2) }}</b></td>
                       ​<td><b>{{ number_format($total_credit_equity,2) }}</b></td>
                    </tr>

                    </tbody>
                    <tfoot>
                    
                                                
                    <tr>
                     
                        <td><b>{{ number_format($total_debit_liability+$total_debit_equity ,2) }}</b></td>

                        <td><b>{{ number_format($total_credit_liability+$total_credit_equity,2) }}</b></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

@else
        <div class="panel panel-white col-lg-4">
            <div class="panel-body table-responsive no-padding">

                <table class="table table-bordered table-condensed table-hover">
                    <thead>

                    <tr class="bg-green">
                    
                    <th>{{trans_choice('general.debit',1)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="1" style="text-align: center"><b>&nbsp;</b></td>
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
?>            
     
     @foreach($asset as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >{{-- $c --}} &nbsp; </td>
                        <td ><b>{{-- $account_class->class_name  --}}&nbsp;</b></td>

                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>

 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_assets +=$dr ;
                         $total_credit_assets +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              
  @endforeach
  @endforeach
 
           <tr>

                        <td><b>{{ number_format($total_debit_assets,2) }}</b></td>
                        <td><b>{{ number_format($total_credit_assets,2) }}</b></td>

                    </tr>            
                   


                    <tr>
                        <td colspan="1" style="text-align: center "><b>&nbsp;</b></td>
                    </tr>
                     @foreach($liability  as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >&nbsp; </td>
                        <td ><b>&nbsp;</b></td>
                
                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>

 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_liability  +=$dr ;
                         $total_credit_liability  +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              ​
 ​@endforeach
 ​@endforeach


  ​<tr>

                       ​<td><b>{{ number_format($total_debit_liability ,2) }}</b></td>
                       ​<td><b>{{ number_format($total_credit_liability,2) }}</b></td>

                   ​</tr>     
                       


<tr>
                        <td colspan="1" style="text-align: center"><b>&nbsp</b></td>
                    </tr>
    @foreach($equity   as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >&nbsp;</td>
                        <td ><b>&nbsp;</b></td>

                    </tr>

  
               
  @foreach($account_class->groupAccount  as $group)
                             
@foreach($group->accountCodes as $account_code)
<tr>

 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                          $total_debit_equity   +=$dr ;
                         $total_credit_equity   +=$cr;
                        ?>                           
                             <td>{{ number_format($dr,2) }}</td>
                            <td>{{ number_format($cr,2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              ​
 ​@endforeach
 ​@endforeach
                   
                                      <tr>

                       ​<td><b>{{ number_format($total_debit_equity ,2) }}</b></td>
                       ​<td><b>{{ number_format($total_credit_equity,2) }}</b></td>
                    </tr>

                    </tbody>
                    <tfoot>
                    
                            
                    
                    <tr>
                        
                        <td><b>{{ number_format($total_debit_liability+$total_debit_equity ,2) }}</b></td>

                        <td><b>{{ number_format($total_credit_liability+$total_credit_equity,2) }}</b></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif



@endsection
@section('footer-scripts')

@endsection
