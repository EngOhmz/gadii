@extends('layouts.master')


@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Profit Report</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
@php
$center=App\Models\Project\Project::where('id',$name)->first();

@endphp

        <div class="panel-heading">
            <h6 class="panel-title">
    
                @if(!empty($name))
                {{ strtoupper($center->project_name) }} - {{ $center->project_no }} for the period: <b>{{Carbon\Carbon::parse($start)->format('d/m/Y')}} to {{Carbon\Carbon::parse($end)->format('d/m/Y')}}</b>
                @endif
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

               <div class="col-md-4">
                    <label class="">Start Date</label>
                   <input  name="start_date" type="date"  id="start" class="form-control date-picker" required value="<?php
                if (!empty($start)) {
                    echo $start;
                } else {
                    echo date('Y-m-d', strtotime('first day of january this year'));
                }
                ?>">

                </div>
                <div class="col-md-4">
                    <label class="">End Date</label>
                     <input  name="end_date" type="date" id="end" class="form-control date-picker" required value="<?php
                if (!empty($end)) {
                    echo $end;
                } else {
                    echo date('Y-m-d');
                }
                ?>">
                </div>

                <div class="col-md-4">
                   <label class="">Projects</label>
                    
                      <select name="name" class="form-control m-b project" id="project" required > 
                          <option value="">Select Project </option>
                            @foreach($list as $row)
                         <option @if(isset($name))   {{  $name == $row->id  ? 'selected' : ''}}  @endif value="{{ $row->id}}">{{$row->project_name}} - {{$row->project_no}}</option>
                       @endforeach  
                         </select>
                    
                      
                </div>

               

 <div class="col-md-12">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

                         @if(!empty($name))
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle "
                                    data-toggle="dropdown">Download Report
                                <span class="caret"></span></button>
                            <div class="dropdown-menu">
                              
                         <li class="nav-item"><a class="nav-link" href="{{ route('profit_report',['name'=>isset($name)? $name : '','start_date'=>isset($start)? $start : '' ,'end_date'=>isset($end)? $end : '' ,'type'=>'print_pdf']) }}">
                                       <i   class="icon-file-pdf"></i>  Download PDF </a>                                             
                                   </li>
                                
                                    <li class="nav-item"><a class="nav-link" href="{{route('profit_report.excel',['name'=>$name,'start'=>$start,'end'=>$end])}}">
                                     <i   class="icon-file-excel"></i> Download Excel </a>                                              
                                    </li>
                                
                            </div>
                        </div>
                        @endif

                </div>  

  
           
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br> <br>
@if(!empty($name))
        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

<?php
$total_income=($invoice - $sdiscount) - $credit;
$total_paid=( ($purchase - $pdiscount) + $expense) - $debit ;
?>


    
                   <table class="table table-striped"  style="width:49.8%;display: inline-table;">
                        <thead>
                        <tr>
                           
                            <th> Particulars</th>
                            <th> Amount</th>
                      
                        </tr>
                        </thead>
                        <tbody>


                   <tr>
                      <td><a class="nav-link" href="#"  data-toggle="modal"  onclick="model('invoice')" value="{{ $row->id}}" data-type="issue" data-target="#appFormModal" >Invoice</a></td> 
                      <td>{{number_format($invoice - $sdiscount,2)}} </td>
                        </tr>
                            <tr>
                      <td><a class="nav-link" href="#"  data-toggle="modal"  onclick="model('credit')" value="{{ $row->id}}" data-type="issue" data-target="#appFormModal" >Credit Note</a></td>
                       <td>{{number_format($credit,2)}} </td>                                                                        
                            </tr>
                        </tbody>
                        <tfoot>
 <tr>
                                
                      <td>Total</td>
                     <td>{{number_format($total_income,2)}}</td>                     
                       
                                                                        
                            </tr>
                        
</tfoot>
                    </table>





<table class="table table-striped"  style="width:49.8%;display: inline-table;">
                        <thead>
                        <tr>
                            <th> Particulars</th>
                            <th> Amount</th>
                      
                        </tr>
                        </thead>
                        <tbody>

 <tr>
                      <td><a class="nav-link" href="#"  data-toggle="modal"  onclick="model('purchase')" value="{{ $row->id}}" data-type="issue" data-target="#appFormModal" >Purchases</a></td> 
                      <td>{{number_format($purchase - $pdiscount,2)}} </td>
                         </tr>
                            <tr>
                      <td><a class="nav-link" href="#"  data-toggle="modal"  onclick="model('debit')" value="{{ $row->id}}" data-type="issue" data-target="#appFormModal" >Debit Note</a></td>
                       <td>{{number_format($debit,2)}} </td>
                            </tr>
                            <tr>
                          <td><a class="nav-link" href="#"  data-toggle="modal"  onclick="model('expense')" value="{{ $row->id}}" data-type="issue" data-target="#appFormModal" >Expenses</a></td>
                       <td>{{number_format($expense,2)}} </td>                                              
                            </tr>
                       
                        

                  
                        </tbody>
                        <tfoot>
 <tr>
                               
                      <td>Total</td>
                     <td>{{number_format($total_paid,2)}}</td>                     
                                                                     
                            </tr>
                        
</tfoot>
                    </table>




<table class="table table-striped"  >
                        <tfoot>

<tr>
                                
                      <td><strong>Balance</strong></td>
                     <td><strong>{{number_format($total_income-$total_paid,2)}}<strong></td>                     
                                                                     
                            </tr>
                        
</tfoot>
                    </table>

                  
                </div>
            </div>
            <!-- /.panel-body -->
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

<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">
    function model(type) {

var start= $('#start').val();
var end= $('#end').val();
 var project= $('#project').val();

$.ajax({
    type: 'GET',
     url: '{{url("project/projectModal")}}',
    data: {
        'type': type,
         project:project,
        start:start,
        end:end,
    },
    cache: false,
    async: true,
    success: function(data) {
        //alert(data);
        $('.modal-dialog').html(data);
    },
    error: function(error) {
        $('#appFormModal').modal('toggle');

    }
});

}

    </script>




@endsection