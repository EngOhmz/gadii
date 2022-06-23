@extends('layouts.master')
@section('title')
    {{trans_choice('general.summary',2)}} 
@endsection
@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">
             {{trans_choice('general.summary',2)}} 
 @if(!empty($start_date))
                    for period: <b>{{$start_date}} to {{$second_date}}</b>
                @endif
             @if(!empty($end_date))
                    for period: <b>{{$second_date}} to {{$end_date}}</b>
                @endif
            </h6>
            
          
            <div class="heading-elements">

            </div>
        </div>
        <div class="panel-body hidden-print">
            <h4 class="">{{trans_choice('general.date',1)}} {{trans_choice('general.range',1)}}</h4>
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">
                
                
            <div class="col-xs-5 col-lg-4">
                    {!! Form::text('start_date',$start_date, array('class' => 'form-control date-picker', 'placeholder'=>"First Date")) !!}
                </div>
                
                <div class="col-xs-5  col-lg-4">
                    {!! Form::text('second_date',$second_date, array('class' => 'form-control date-picker', 'placeholder'=>"Second Date" ,'required' => 'required')) !!}
                </div>
             <div class="col-xs-5  col-lg-4">
                    {!! Form::text('end_date',$end_date, array('class' => 'form-control date-picker', 'placeholder'=>"Third Date")) !!}
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

  <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
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

  <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
  @endforeach
 
           <tr> style="text-align: right">
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

  <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
  @endforeach
 
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
                    <th>{{trans_choice('general.debit',1)}}</th>
                        <th>{{trans_choice('general.credit',1)}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="4" style="text-align: center"><b>{{trans_choice('general.asset',2)}}</b></td>
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
  <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
  @endforeach
 
           <tr>
                        <td colspan="2" style="text-align: center ">
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.asset',2)}}</b></td>
                        <td><b>{{ number_format($total_debit_assets,2) }}</b></td>
                        <td><b>{{ number_format($total_credit_assets,2) }}</b></td>

                    </tr>            
                   


                    <tr>
                        <td colspan="4" style="text-align: center "><b>{{trans_choice('general.liability',2)}}</b></td>
                    </tr>
                     @foreach($liability  as $account_class)
<?php    $c++ ;  ?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>                                                       
                                  <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
             ​

 ​@endforeach


  ​<tr>
                         <td colspan="2" style="text-align: center ">
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
                 <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
 ​@endforeach
                   
                                      <tr>
                     <td colspan="2" style="text-align: center">
                            <b>{{trans_choice('general.total',1)}} {{trans_choice('general.equity',2)}}</b></td>
                       ​<td><b>{{ number_format($total_debit_equity ,2) }}</b></td>
                       ​<td><b>{{ number_format($total_credit_equity,2) }}</b></td>
                    </tr>

                    </tbody>
                    <tfoot>
                    
                            
                    
                    <tr>
                        <td colspan="2" style="text-align: center">
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

  <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
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
 <tr>

  <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
  @endforeach
 
           <tr>



                       ​<td><b>{{ number_format($total_debit_liability ,2) }}</b></td>
                       ​<td><b>{{ number_format($total_credit_liability,2) }}</b></td>

                   ​</tr>     
                       


<tr>
                        <td colspan="1" style="text-align: center"><b>&nbsp;</b></td>
                    </tr>
    @foreach($equity   as $account_class)
<?php    $c++ ;  ?>
                          <tr>

  <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
  @endforeach
 
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

  <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
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

  <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
  @endforeach
 
           <tr>

                       ​<td><b>{{ number_format($total_debit_liability ,2) }}</b></td>
                       ​<td><b>{{ number_format($total_credit_liability,2) }}</b></td>

                   ​</tr>     
                       


<tr>
                        <td colspan="1" style="text-align: center"><b>&nbsp</b></td>
                    </tr>
    @foreach($equity   as $account_class)
<?php    $c++ ;  ?>
                           <tr>

  <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
  @endforeach
 
           <tr>
                   
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
