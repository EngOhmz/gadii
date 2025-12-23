@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Balance Sheet  </h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
        <div class="panel-heading">
            <h6 class="panel-title">
            @if(!empty($start_date))
                    as at: <b>{{Carbon\Carbon::parse($start_date)->format('d/m/Y')}}</b>
                   @endif
            </h6>
        </div>

<br>
 <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

                 <div class="col-md-4">
                    <label class="">As at Date <span class="required"> * </span></label>
                   <input id="start_date" name="start_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                     echo date('Y-m-d');
                }
                ?>">
                </div>

                <?php $a=  trim(json_encode($x), '[]');  ?>
                
               

                <div class="col-md-4">
                    <label class="">Branch</label> 
                   
                    <select name="branch_id" class="form-control m-b branch" id="branch_id">
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
                            <ul class="dropdown-menu dropdown-menu-right">
                               
                                    <li class="nav-item"><a class="nav-link"  href="{{url('financial_report/balance_sheet/pdf?start_date='.$start_date.'&branch_id='.$branch_id)}}"
                                       target="_blank"><i
                                                class="icon-file-pdf"></i>  Download PDF
                                    </a></li>
                                
                                    <li class="nav-item"><a class="nav-link"  href="{{url('financial_report/balance_sheet/excel?start_date='.$start_date.'&branch_id='.$branch_id)}}"
                                       target="_blank"><i
                                                class="icon-file-excel"></i> Download Excel
                                    </a></li>
                                
                            </ul>
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
                    <tr>
                 <th>#</th>
                        <th colspan="3" style="text-align: center">STATEMENT OF FINANCIAL POSITION FOR THE PERIOD ENDING {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="4" style="text-align: center"><b>Assets</b></td>
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
     
     @foreach($asset->where('added_by',auth()->user()->added_by) as $account_class)
<?php    $c++ ; 

 $unit_total1   = 0;
 $unit_total2   = 0;

?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td ></td>
                  <?php   if($c == 1){ ?>
                   <?php  } else{ ?>
                     <td ></td>
                   
                    <?php  }  ?>
                    </tr>

  
               
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group)
  
                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code)


 @php
     $account_id=$account_code->id;
      $amount=App\Traits\Calculate_Balance::get_amount($start_date,$branch_id,$account_id);
     
     @endphp
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
<td><a onclick="model({{ $account_code->id }},'b_account')" href="#view{{$account_code->id}}" data-toggle="modal" data-target="#appFormModal">{{$account_code->account_codes }}</a>
</td>
 <?php
 
                         $total_credit_assets +=($amount['debit']);
                         $unit_total1  +=($amount['debit']);
                        ?>                           
                            <td>{{ number_format($amount['debit'],2) }}</td>
                        </tr>
             
                                 
                  
 @endforeach              
  @endforeach
                <tr>
                        <td colspan="3" style="text-align: right">
                            <b>Total {{ $account_class->class_name  }}</b></td>

                        <td><b>{{ number_format($unit_total1,2) }}</b></td>
                  </tr> 


  
  @endforeach
                      
 
           <tr>
                        <td colspan="3" style="text-align: right">
                            <b>Total Assets</b></td>
                        <td><b>{{ number_format($total_credit_assets,2) }}</b></td>

                    </tr>            
                   


                    <tr>
                        <td colspan="4" style="text-align: center "><b>Liabilities</b></td> <!-- sehemu ya liabilitty==================================================== -->
                    </tr>
                     @foreach($liability  as $account_class)
<?php    $c++ ; 

 $unit_total1  =0;
 $unit_total2  =0;

?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="2"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group)
                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code)
 @php
     $account_id=$account_code->id;
      $amount=App\Traits\Calculate_Balance::get_amount($start_date,$branch_id,$account_id);
     
     @endphp
     
@if($account_code->account_name == 'Value Added Tax (VAT)')
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
 <td><a onclick="model({{ $account_code->id }},'b_vat')" href="#view{{$account_code->id}}" data-toggle="modal" data-target="#appFormModal">{{$account_code->account_codes }}</a>

</td>
<?php
                     
                       
                         if ($amount['debit'] == 0){
                        $total_vat=$amount['credit'];
                       }
                       else{
                         $total_vat=$amount['debit'];
                         }
                    $unit_total2  =$unit_total2+$total_vat ; ;
                         
  ?>
                          

                    <td>{{ number_format($total_vat,2) }}  </td>
                                
                          
                        
</tr>

@else
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
<td>
@if($account_code->account_name == 'Deffered Tax')
<a onclick="model({{ $account_code->id }},'deff')" href="#view{{$account_code->id}}" data-toggle="modal" data-target="#appFormModal">{{$account_code->account_codes }}</a>
@else
<a onclick="model({{ $account_code->id }},'b_account')" href="#view{{$account_code->id}}" data-toggle="modal" data-target="#appFormModal">{{$account_code->account_codes }}</a>   
@endif
</td>
 <?php
                   

                            
                      if($account_code->account_name == 'Deffered Tax'){
                       $total_credit_liability  =    $total_credit_liability + ($amount['credit']-$amount['debit']) +$net_profit['tax_for_second_date'];
                                              
                         $unit_total2  +=($amount['credit']-$amount['debit']) +  $net_profit['tax_for_second_date'];

                         }
                         else{
                          
                         $total_credit_liability  +=($amount['credit']-$amount['debit']);                     
                         
                         $unit_total2  +=($amount['credit']-$amount['debit'])  ;
                           }

                       
                        ?>                           
                              @if($account_code->account_name != 'Deffered Tax')
                                                 
                            <td>{{ number_format($amount['credit']-$amount['debit'],2) }}</td>
                         </tr>
                       
                         @else
                             
                            <td>{{ number_format( ($amount['credit']+$net_profit['tax_for_second_date']) - $amount['debit'],2) }}</td>
                        </tr>
                         @endif

                    
             
                                 
  @endif                  
 @endforeach              
 ​@endforeach
   ​<tr>
                       ​<td colspan="3" style="text-align: right">
                           ​<b>Total {{$account_class->class_name}}</b></td>
                       ​<td><b>{{ number_format($unit_total2 ,2) }}</b></td>

                   ​</tr>    
 ​@endforeach


  ​<tr>
                       ​<td colspan="3" style="text-align: right">
                           ​<b>Total Liabilities</b></td>
                       ​<td><b>{{ number_format($total_credit_liability + $total_vat,2) }}</b></td>

                   ​</tr>     
                       


<tr>
                        <td colspan="4" style="text-align: center"><b>Equities</b></td>   <!-- //sehemu ya equity ==================================================================== -->
                    </tr>
    @foreach($equity   as $account_class)
<?php    $c++ ; 
  
     $unit_cost  = 0;
     $unit_cost1 = 0;

?>
                          <tr>
                        <td >{{ $c }} . </td>
                        <td ><b>{{ $account_class->class_name  }}</b></td>
                  <td colspan="2"></td>
                    </tr>

  
               
  @foreach($account_class->groupAccount->where('added_by',auth()->user()->added_by)->where('disabled','0')  as $group)
                             
@foreach($group->accountCodes->where('added_by',auth()->user()->added_by)->where('disabled','0') as $account_code)
 @php
     $account_id=$account_code->id;
      $amount=App\Traits\Calculate_Balance::get_amount($start_date,$branch_id,$account_id);
     
     @endphp
     
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
​<td>
@if($account_code->account_codes == 31101)
<a onclick="model({{ $account_code->id }},'np')" href="#view{{$account_code->id}}" data-toggle="modal" data-target="#appFormModal">{{$account_code->account_codes }}</a>
@else
 <a onclick="model({{ $account_code->id }},'b_account')" href="#view{{$account_code->id}}" data-toggle="modal" data-target="#appFormModal">{{$account_code->account_codes }}</a>   
@endif
</td>
 <?php

                     
                     
                         if($account_code->account_codes == 31101){
                         $total_credit_equity    =$total_credit_equity + $net_profit['profit_for_second_date'];
                         $unit_cost1 = $unit_cost1 + $net_profit['profit_for_second_date'];  
                          
                        //   $unit_cost =1000 ;
                        //  $unit_cost1 = 1000;
                         }else{
                         $total_credit_equity    +=($amount['credit']-$amount['debit']) ;
                         $unit_cost1 +=($amount['credit']-$amount['debit']);
                         } ?>
                         @if($account_code->account_codes != 31101)
                                                 
                            <td>{{ number_format($amount['credit']-$amount['debit'],2) }}</td>
                       
                       
                         @else
                             
                            <td>{{ number_format($net_profit['profit_for_second_date'],2) }}</td>
                        </tr>
                         @endif
                                 
                  
 @endforeach              ​
 ​@endforeach
                <tr>
                        <td colspan="3" style="text-align: right">
                            <b>Total {{ $account_class->class_name }}</b></td>
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

<!-- Modal -->
 @if(!empty($start_date))
                
  <div class="modal fade"  data-backdrop="" id="appFormModal"  tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg">
   
</div>
  </div>
  
@endif


@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"targets": [3]}
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
        
         $('.datatable-li').DataTable({
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
        
         $('.datatable-eq').DataTable({
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
    
         <script>
     
        function model(id, type) {
            
            var start_date = $('#start_date').val();
            var second_date = $('#second_date').val();
            var end_date = $('#end_date').val();
            var branch_id = $('.branch').val();

            $.ajax({
                type: 'GET',
                url: '{{ url('financial_report/reportModal') }}',
                data: {
                    'id': id,
                    'type': type,
                    'start_date': start_date,
                    'second_date': second_date,
                     'end_date': end_date,
                    'branch_id': branch_id,
                },
                cache: false,
                async: true,
                success: function(data) {
                    //alert(data);
                    $('#appFormModal > .modal-dialog').html(data);
                     
                },
                error: function(error) {
                    $('#appFormModal').modal('toggle');

                }
            });

        }
        
     
    </script>

@endsection