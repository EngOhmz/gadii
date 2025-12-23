@extends('layouts.master')


@section('content')
<div class="row">
    <div class="col-sm-12" >
        <div class="card">
            <!-- *********     Employee Search Panel ***************** -->
            <div class="card-header">
                <h4>Salary Control</h4>
            </div>

            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal form-groups-bordered', 'name' => 'form')) !!}  
                {{csrf_field()}}
                <div class="card-body">
                      <div class="form-group offset-3">
                        <label  for="field-1" class="col-sm-3 control-label">Search Type <span
                                class="required"> *</span></label>

                        <div class="col-sm-5">
                            <select required name="search_type" id="search_type" class="form-control m-b search" required >
                                <option value="">Select Search Type</option>
                                <option value="bank" <?php if (!empty($search_type)) {
                                    echo $search_type == 'bank' ? 'selected' : '';
                                } ?>>Bank Report</option>

                                <option value="nssf" <?php if (!empty($search_type)) {
                                    echo $search_type == 'nssf' ? 'selected' : '';
                                } ?>>NSSF Report</option>

                                <option value="tra" <?php if (!empty($search_type)) {
                                    echo $search_type == 'tra' ? 'selected' : '';
                                } ?>>TRA Report</option>
                           <option value="vicoba" <?php if (!empty($search_type)) {
                                    echo $search_type == 'vicoba' ? 'selected' : '';
                                } ?>>VICOBA Report</option>
                              <option value="cotwu" <?php if (!empty($search_type)) {
                                    echo $search_type == 'cotwu' ? 'selected' : '';
                                } ?>>COTWU Report</option>

                            </select>
                        </div>
                    </div>

               

                    
                    <div class="by_month" id="month"
                        >
                       <div class="form-group offset-3">
                            <label class="col-sm-3 control-label">Select Month <span
                                    class="required"> *</span></label>
                            <div class="col-sm-5">
                              
                                    <input  type="month" value="<?php
                                    if (!empty($by_month)) {
                                        echo $by_month;
                                    }
                                    ?>" class="form-control monthyear by_month" name="by_month"
                                           data-format="yyyy/mm/dd" required>

                                 
                            </div>
                        </div>
                    </div>
                   

                  
                      <div class="form-group offset-3" id="border-none">
                        <label for="field-1" class="col-sm-3 control-label"></label>
                        <div class="col-sm-5">
                            <button id="submit" type="submit" name="flag" value="1"
                                    class="btn btn-primary btn-block">Go
                            </button>
                        </div>
                    </div>
                </div>
  </div>
            </form>
        </div><!-- ******************** Employee Search Panel Ends ******************** -->
</div>
<!-- ******************** Employee Search Result ******************** -->



<?php if (!empty($search_type)) {
if ($search_type == 'bank') {
    $by = 'Bank Report the month of  ' . date('F Y', strtotime($by_month));
}
elseif ($search_type == 'nssf') {
    $by = 'NSSF Report the month of  ' . date('F Y', strtotime($by_month));
}
elseif ($search_type == 'tra') {
   $by = 'TRA Report the month of  ' . date('F Y', strtotime($by_month));
}
elseif ($search_type == 'vicoba') {
   $by = 'VICOBA Report the month of  ' . date('F Y', strtotime($by_month));
}
elseif ($search_type == 'cotwu') {
   $by = 'COTWU Report the month of  ' . date('F Y', strtotime($by_month));
}
?>
  <div class="card">
                            <!-- Default panel contents -->
                            <div class="card-header header-elements-sm-inline"><strong> <?php echo $by ?></strong> 
                  
<div class="header-elements">
               <a  class="text-primary pull-right"  href="{{ route('salary_control',['month'=>isset($by_month)? $by_month : '','report_type'=>isset($search_type )? $search_type  : '','type'=>'print_pdf']) }}" >
            Download Report</a>
      </div>      
     
  

</div>

                            <div class="card-body">  
   <!-- Table -->
                   <div class="table-responsive">

                    <?php if ($search_type == 'bank') { 
                     $total_net = 0;
                              ?>
                <table class="table datatable-basic table-striped" id="table-1">
                        <thead>
                        <tr> 
                       <th>#</th>                        
                                 <th>Name</th>
                                <th>Account Name</th>
                             <th>Bank Name</th>
                            <th>Account Number</th>                            
                            <th>Net Salary</th>

                        </tr>
                        </thead>
                        <tbody>
                      
                          @if (!empty($check_existing_payment))
                    <?php $total_paid_amount=0; ?>
                        @foreach ($check_existing_payment as $row)
                        <tr>
                           <td> <?php echo $loop->iteration; ?></td>
                             
                                <?php
                                       $a = App\Models\User::where('id', $row->user_id)->first();
                                       ?>
                                 <td><?php echo $a->name; ?></td>



                              <?php
                   $ttl_deduction =App\Models\Payroll\SalaryPaymentDeduction::all()->where('salary_payment_id', $row->id)->sum('salary_payment_deduction_value');;;         
                    $ttl_allowance  = App\Models\Payroll\SalaryPaymentAllowance::all()->where('salary_payment_id', $row->id)->sum('salary_payment_allowance_value');;
                     $total_salary = App\Models\Payroll\ SalaryPaymentDetails::where('salary_payment_id', $row->id)->where('salary_payment_details_label', '!=', 'Salary Grade')->sum('salary_payment_details_value');
                       $total_paid_amount= $total_salary +  $ttl_allowance;     

                        $details = App\Models\UserDetails\BankDetails::where('user_id',$row->user_id)->first();   

?>
                            <td>{{ !empty($details) ? $details->bank_name : ''}}</td>
                              <td>{{ !empty($details) ? $details->account_name : ''}}</td>
                                <td>{{ !empty($details) ? $details->account_number : ''}}</td>                               
                        <td><?php echo  number_format(($total_paid_amount - $ttl_deduction)- $row->fine_deduction,2) ;;?> TSHS</td>   
                            
                        </tr>
                       
                     <?php                                      
                   $total_net += ($total_paid_amount - $ttl_deduction)- ($row->fine_deduction);                                 
                                       ?>
                         @endforeach
                           @endif
                        </tbody>

            <tfoot>
<tr>
                                     <td></td>
                                     <td><b>Total</b></td>
                                       <td></td>
                                             <td></td>                           
                                 <td></td>
                                 <td><b>{{number_format( $total_net,2)}} </b></td>


</tr>
</tfoot>
                    </table>
                 <?php } ?>


                         <?php if ($search_type == 'nssf') { ?>
                <table class="table datatable-basic table-striped" id="table-1">
                        <thead>
                        <tr> 
                       <th>#</th>                        
                                 <th>Name</th>
                                <th>NSSF Number</th>
                             <th>Gross Salary</th>
                            <th>Contributions</th>                            


                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                                        $nssf_amount = 0;;
                                       $total_salary = 0;
                                  $total_nssf=0;
                                       ?>

                      
                          @if (!empty($check_existing_payment))
                    <?php $total_paid_amount=0; ?>
                        @foreach ($check_existing_payment as $row)
                        <tr>
                           <td> <?php echo $loop->iteration; ?></td>
                             <?php
                                       $a = App\Models\User::where('id', $row->user_id)->first();
                                       ?>
                                 <td><?php echo $a->name; ?></td>


                              <?php
                    $nssf = App\Models\JournalEntry::where('payment_id', $row->id)->where('name', 'NSSF Payment')->whereNotNull('debit')->first();; 
                        $details = App\Models\UserDetails\SalaryDetails::where('user_id',$row->user_id)->first();   
                 $salary = App\Models\Payroll\ SalaryPaymentDetails::where('salary_payment_id', $row->id)->where('salary_payment_details_label', 'Basic Salary')->sum('salary_payment_details_value'); 

                              if(!empty($nssf)){
                               $nssf_amount=$nssf->debit;
                             }
                               else{
                                 $nssf_amount=0;
                           }

?>
                            <td>{{ !empty($details) ? $details->NSSF : ''}}</td>
                              <td>{{number_format($salary ,2)}} </td>
                              <td>{{number_format( $nssf_amount + $nssf_amount ,2)}} </td>                               
     
                            
                          
                         
                        </tr>
                       
                     <?php 
                                     
                                    $total_salary += $salary;  
                                  $total_nssf += $nssf_amount + $nssf_amount ;                               
                                       ?>
                         @endforeach
                           @endif
                        </tbody>
                     <tfoot>
<tr>
                                     <td><b>Total</b></td>
                                     <td></td>
                                       <td></td>                          
                                 <td><b>{{number_format( $total_salary,2)}}</b></td>
                                 <td><b>{{number_format( $total_nssf,2)}} </b></td>


</tr>
</tfoot>
                    </table>
                 <?php } ?>


                         <?php if ($search_type == 'tra') { ?>
                <table class="table datatable-basic table-striped" id="table-1">
                        <thead>
                        <tr> 
                       <th>#</th>                        
                                 <th>Name</th>
                                 <th>TIN Number</th>
                                <th>NSSF Number</th>
                           <th>Gross Salary</th>
                             <th>PAYE</th>
                            <th>NSSF Contribution</th>                            
                              <th>Net Salary</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                                       $total_gross=0;
                                    $total_net = 0;                                 
                                 $paye_amount  = 0;
                                        $nssf_amount = 0;;
                                     $total_paye  = 0;
                                        $total_nssf = 0;;
                                       ?>

                      
                          @if (!empty($check_existing_payment))
                    <?php $total_paid_amount=0; ?>
                        @foreach ($check_existing_payment as $row)
                        <tr>
                           <td> <?php echo $loop->iteration; ?></td>
                             <?php
                                       $a = App\Models\User::where('id', $row->user_id)->first();
                                       ?>
                                 <td><?php echo $a->name; ?></td>


                              <?php
                      $ttl_deduction =App\Models\Payroll\SalaryPaymentDeduction::all()->where('salary_payment_id', $row->id)->sum('salary_payment_deduction_value');;;         
                    $ttl_allowance  = App\Models\Payroll\SalaryPaymentAllowance::all()->where('salary_payment_id', $row->id)->sum('salary_payment_allowance_value');;
                     $total_salary = App\Models\Payroll\ SalaryPaymentDetails::where('salary_payment_id', $row->id)->where('salary_payment_details_label', '!=', 'Salary Grade')->sum('salary_payment_details_value');
                       $total_paid_amount= $total_salary +  $ttl_allowance; 
   
                    $paye  = App\Models\JournalEntry::where('payment_id', $row->id)->where('name', 'PAYE Payment')->whereNotNull('debit')->first();; 
                    $nssf = App\Models\JournalEntry::where('payment_id', $row->id)->where('name', 'NSSF Payment')->whereNotNull('debit')->first();; 
                        $details = App\Models\UserDetails\SalaryDetails::where('user_id',$row->user_id)->first();   

                              if(!empty($nssf)){
                               $nssf_amount=$nssf->debit;
                             }
                               else{
                                 $nssf_amount=0;
                           }

                          if(!empty($paye)){
                               $paye_amount=$paye->debit;
                             }
                               else{
                                 $paye_amount=0;
                           }

?>
                              <td>{{ !empty($details) ? $details->TIN : ''}}</td>
                            <td>{{ !empty($details) ? $details->NSSF : ''}}</td>
                            <td><?php echo  number_format($total_paid_amount,2) ;;?></td>
                              <td>{{number_format( $paye_amount,2)}} </td>
                              <td>{{number_format( $nssf_amount,2)}} </td>                               
                              <td><?php echo  number_format(($total_paid_amount - $ttl_deduction)- $row->fine_deduction,2) ;;?></td> 
                            
                          
                         
                        </tr>

                      <?php 
                                     
                                    $total_net += ($total_paid_amount - $ttl_deduction)- $row->fine_deduction;                                 
                                      $total_gross+=$total_paid_amount;
                                      $total_paye  += $paye_amount;
                                        $total_nssf += $nssf_amount;;
                                       ?>
                       
                         @endforeach
                           @endif
                        </tbody>
                    <tfoot>
<tr>
                                     <td></td><td><b>Total</b></td><td></td>                          
                                 <td></td>
                                    <td><b>{{number_format( $total_gross,2)}} </b></td>
                                     <td><b>{{number_format( $total_paye,2)}} </b></td>
                                     <td><b>{{number_format( $total_nssf,2)}} </b></td>
                                 <td><b>{{number_format( $total_net,2)}}</b> </td>


</tr>
</tfoot>
                    </table>
                 <?php } ?>


 <?php if ($search_type == 'vicoba') { ?>
                <table class="table datatable-basic table-striped" id="table-1">
                        <thead>
                        <tr> 
                       <th>#</th>                        
                                 <th>Name</th>
                                <th>Basic Salary</th>
                             <th>Amount</th>                        


                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                                        $vic_amount = 0;;
                                       $total_salary = 0;
                                  $total_amount=0;
                                       ?>

                      
                          @if (!empty($check_existing_payment))
                    <?php $total_paid_amount=0; ?>
                        @foreach ($check_existing_payment as $row)
                        <tr>
                           <td> <?php echo $loop->iteration; ?></td>
                             <?php
                                       $a = App\Models\User::where('id', $row->user_id)->first();
                                       ?>
                                 <td><?php echo $a->name; ?></td>


                              <?php
    
                 $salary = App\Models\Payroll\SalaryPaymentDetails::where('salary_payment_id', $row->id)->where('salary_payment_details_label', 'Basic Salary')->sum('salary_payment_details_value'); 
                   $amount = App\Models\Payroll\SalaryPaymentDeduction::where('salary_payment_id', $row->id)->where('salary_payment_deduction_label', 'VICOBA/LOAN')->sum('salary_payment_deduction_value'); 

                              if(!empty($amount)){
                               $vic_amount=$amount;
                             }
                               else{
                                 $vic_amount=0;
                           }

?>
                              <td>{{number_format($salary ,2)}} </td>
                              <td>{{number_format( $vic_amount  ,2)}} </td>                               
     
                            
                          
                         
                        </tr>
                       
                     <?php 
                                     
                                    $total_salary += $salary;  
                                  $total_amount+= $vic_amount ;                               
                                       ?>
                         @endforeach
                           @endif
                        </tbody>
                     <tfoot>
<tr>
                                     <td><b>Total</b></td>
                                     <td></td>                       
                                 <td><b>{{number_format( $total_salary,2)}}</b></td>
                                 <td><b>{{number_format( $total_amount,2)}} </b></td>


</tr>
</tfoot>
                    </table>
                 <?php } ?>



 <?php if ($search_type == 'cotwu') { ?>
                <table class="table datatable-basic table-striped" id="table-1">
                        <thead>
                        <tr> 
                       <th>#</th>                        
                                 <th>Name</th>
                                <th>Basic Salary</th>
                             <th>Amount</th>                        


                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                                        $cot_amount = 0;;
                                       $total_salary = 0;
                                  $total_amount=0;
                                       ?>

                      
                          @if (!empty($check_existing_payment))
                    <?php $total_paid_amount=0; ?>
                        @foreach ($check_existing_payment as $row)
                        <tr>
                           <td> <?php echo $loop->iteration; ?></td>
                             <?php
                                       $a = App\Models\User::where('id', $row->user_id)->first();
                                       ?>
                                 <td><?php echo $a->name; ?></td>


                              <?php
    
                 $salary = App\Models\Payroll\SalaryPaymentDetails::where('salary_payment_id', $row->id)->where('salary_payment_details_label', 'Basic Salary')->sum('salary_payment_details_value'); 
                   $amount = App\Models\Payroll\SalaryPaymentDeduction::where('salary_payment_id', $row->id)->where('salary_payment_deduction_label', 'COTWU')->sum('salary_payment_deduction_value'); 

                              if(!empty($amount)){
                               $cot_amount=$amount;
                             }
                               else{
                                 $cot_amount=0;
                           }

?>
                              <td>{{number_format($salary ,2)}} </td>
                              <td>{{number_format( $cot_amount  ,2)}} </td>                               
     
                            
                          
                         
                        </tr>
                       
                     <?php 
                                     
                                    $total_salary += $salary;  
                                  $total_amount+= $cot_amount ;                               
                                       ?>
                         @endforeach
                           @endif
                        </tbody>
                     <tfoot>
<tr>
                                     <td><b>Total</b></td>
                                     <td></td>                       
                                 <td><b>{{number_format( $total_salary,2)}}</b></td>
                                 <td><b>{{number_format( $total_amount,2)}} </b></td>


</tr>
</tfoot>
                    </table>
                 <?php } ?>



                </div>
</div>
</div>

<?php } ?>  
<!--************ Employee Result End***********-->





<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>

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

<script type="text/javascript">
    function model(id, type) {

        let url = '{{ route("salary_template.show", ":id") }}';
        url = url.replace(':id', id)

        $.ajax({
            type: 'GET',
            url: url,
            data: {
                'type': type,
               
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