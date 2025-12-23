@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Debtors Report</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Debtors Report
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
@php
$center=App\Models\Pharmacy\Client::where('id',$account_id)->first();
@endphp

        <div class="panel-heading">
            <h6 class="panel-title">
              Debtors Report
                @if(!empty($start_date))
                    for the period: <b>{{$start_date}} to {{$end_date}} for {{$center->name}}</b>
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
                     <input  name="end_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($end_date)) {
                    echo $end_date;
                } else {
                    echo date('Y-m-d');
                }
                ?>">
                </div>
                <div class="col-md-4">
                    <label class="">Debtors List</label>
                    {!! Form::select('account_id',$chart_of_accounts,$account_id, array('class' => 'm-b','id'=>'account_id','placeholder'=>'Select','style'=>'width:100%','required'=>'required')) !!}
                  
                </div>

   <div class="col-md-4">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

                </div>                  
                </div>
           
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br> <br>
@if(!empty($start_date))
        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

                  <table class="table datatable-basic table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> Reference</th>
                            <th>Due Date</th>
                            <th>Current</th>
                         <th> 1-30 </th>
                            <th> 31-60 </th>
                            <th>61-90 </th>
                            <th>91-120 </th>
                            <th>Over 120 </th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>

                          <?php
            $total1 = $total2 = $total3 = $total4 = $total5 = $total6= $total7= 0; 
?>

                        @foreach($data as $key)
                          <?php
                        $dueDate = strtotime($key->due_date);
                          $todayDate= strtotime(date('d-m-Y'));
                          $datediff = $dueDate - $todayDate;
                           round($datediff / (60 * 60 * 24));
                          $dateDifferences = round($datediff / (60 * 60 * 24));
                         $invoice_due =$key->due_amount;
                        
                        ?>
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                      <td>
                        
                     <a class="nav-link" id="profile-tab2"  href="{{ route('pharmacy_invoice.show',$key->id)}}" role="tab"   aria-selected="false">{{$key->reference_no}}</a>
                        
                                 </td>                         
                       <td>{{Carbon\Carbon::parse($key->due_date)->format('d/m/Y')}} </td>
                                    <td>
                                   <?php      
                           if($dateDifferences > 0){                          
                            echo number_format($invoice_due, 2) . ' ' .$key->exchange_code; 
                            $total1 = $total1 + $invoice_due;
                         } ?>
                                       </td>
                              <td>
                                   <?php      
                          if($dateDifferences < 0 && $dateDifferences >-31){  
                           $total2 = $total2 + $invoice_due;
                            echo number_format($invoice_due, 2). ' ' .$key->exchange_code;  
                         } ?>
                                       </td>                               
                            <td>
                                   <?php      
                         if($dateDifferences < -30 && $dateDifferences >-61){  
                              $total3 = $total3 + $invoice_due;                         
                            echo number_format($invoice_due, 2). ' ' .$key->exchange_code; 
                           
                         } ?>
                                       </td>
                               <td>
                                   <?php      
                          if($dateDifferences < -60 && $dateDifferences > -91){  
                            $total4 = $total4+ $invoice_due;                        
                            echo number_format($invoice_due, 2). ' ' .$key->exchange_code; 
                         } ?>
                                       </td>
                               <td>
                                   <?php      
                        if($dateDifferences < -90 && $dateDifferences > -120){ 
                       $total5 = $total5 + $invoice_due;                         
                            echo number_format($invoice_due, 2). ' ' .$key->exchange_code;  
                         } ?>
                                       </td>                             
                             <td>
                                   <?php      
                          if($dateDifferences < -120){     
                         $total6 = $total6 + $invoice_due;                    
                            echo number_format($invoice_due, 2). ' ' .$key->exchange_code; 
                         } ?>
                                       </td>
          
                            <td>{{number_format($invoice_due,2)}} {{$key->exchange_code}}</td>                      
                           
                                           <td> 
                                                  @if($key->status == 1)
                                                    <div class="badge badge-warning badge-shadow">Not Paid</div>
                                                    @elseif($key->status == 2)
                                                    <div class="badge badge-info badge-shadow">Partially Paid</div>
                                                    @elseif($key->status == 3)
                                                    <div class="badge badge-success badge-shadow">Fully Paid</div>
                                                         @elseif($key->status == 0)
                                                    <div class="badge badge-danger badge-shadow">Not Approved</div>
                                                           @elseif($key->status == 4)
                                                    <div class="badge badge-danger badge-shadow">Cancelled</div>
                                                    @endif
                                             </td>                                
                            </tr>
                        
                        @endforeach
                        </tbody>
                        
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



@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"orderable": false, "targets": [3]}
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