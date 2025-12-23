@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
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
                    <label class="">Start Date <span class="required"> * </span></label>
                   <input name="start_date" id="start_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                    echo date('Y-m-d', strtotime('first day of january this year'));
                }
                ?>">

                </div>
                <div class="col-md-4">
                    <label class="">End Date <span class="required"> * </span></label>
                     <input name="second_date" id="second_date" type="date" class="form-control date-picker" required value="<?php
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
                         <th colspan="5"><center>TRIAL BALANCE FOR THE PERIOD BETWEEN {{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} to {{Carbon\Carbon::parse($second_date)->format('d/m/Y')}}   </center></th>
                       
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

 @php
     $account_id=$account_code->id;
      $amount=App\Traits\Calculate_Account::get_amount($start_date,$second_date,$branch_id,$account_id);
     
     @endphp

 @if($account_code->account_name != 'Deffered Tax' && $account_code->account_name != 'Value Added Tax (VAT)' && $account_code->account_codes != '31101')
 
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
 <td><a onclick="model({{ $account_code->id }},'account')" href="#view{{$account_code->id}}" data-toggle="modal" data-target="#appFormModal">{{$account_code->account_codes }}</a>
</td>

                       
                       <?php
                            $debit_total += $amount['debit'] ;
                            $credit_total += $amount['credit'] ;
                        
                      ?>
                         
 

                 <td>{{ number_format($amount['debit'] ,2) }} </td>
                 <td>{{ number_format($amount['credit'] ,2) }} </td>
                      
                           
                          
                
                        
</tr>

@elseif($account_code->account_name == 'Value Added Tax (VAT)')
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
 <td><a onclick="model({{ $account_code->id }},'vat')" href="#view{{$account_code->id}}" data-toggle="modal" data-target="#appFormModal">{{$account_code->account_codes }}</a>

</td>
<?php
                   
                      

                         if ($amount['debit'] == 0){
                        $total_vat_cr=$amount['credit'];
                       }
                       else{
                         $total_vat_dr=$amount['debit'];
                         }
  ?>
                          
                         <td>{{ number_format($amount['debit'] ,2) }} </td>
                        <td>{{ number_format($amount['credit'] ,2) }} </td>
                           
                          
                              

                           
                        
</tr>


@elseif($account_code->account_name == 'Deffered Tax')
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
 <td><a onclick="model({{ $account_code->id }},'deff')" href="#view{{$account_code->id}}" data-toggle="modal" data-target="#appFormModal">{{$account_code->account_codes }}</a>

</td>
                    <?php
                  
                            
                             $credit_total +=  ($amount['credit']-$amount['debit']) +$net_profit['tax_for_second_date']; ;

                                     ?>
                          
                         

                                    <td>{{ number_format(0 ,2) }} </td>
                                    <td>{{ number_format(($amount['credit']+$net_profit['tax_for_second_date']) - $amount['debit'],2) }}  </td>
                                
                          
</tr>


@elseif($account_code->account_codes  == 31101)
<tr>
 <td></td>
 <td>{{$account_code->account_name }}</td>
 <td><a onclick="model({{ $account_code->id }},'np')" href="#view{{$account_code->id}}" data-toggle="modal" data-target="#appFormModal">{{$account_code->account_codes }}</a>

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