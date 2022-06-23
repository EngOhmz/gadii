<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Ledger  </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Ledger Report
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade <?php if(empty($id)): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
        <div class="panel-heading">
            <h6 class="panel-title">
               Ledger
              <?php if(!empty($start_date)): ?>
                    for the period: <b><?php echo e($start_date); ?> to  <?php echo e($end_date); ?></b>
                <?php endif; ?>
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            <?php echo Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')); ?>

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
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="<?php echo e(Request::url()); ?>"class="btn btn-danger">Reset</a>

                </div>                  
                </div>
           
            <?php echo Form::close(); ?>


        </div>

        <!-- /.panel-body -->

   <br>
  <!-- /.box -->
    <?php if(!empty($start_date)): ?>



               <table id="data-table" class="table table-striped ">
                    <thead>
                    <tr>
                        <th>GL Code</th>
                        <th>Account</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                    </tr>
                    </thead>
                    <tbody>
               
                    <?php
                    $credit_total = 0;
                    $debit_total = 0;
                    ?>
                    <?php $__currentLoopData = \App\Models\ChartOfAccount::orderBy('gl_code','asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <?php
                        $cr = 0;
                        $dr = 0;
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $key->id)->whereBetween('date',
                            [$start_date, $end_date])->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $key->id)->whereBetween('date',
                            [$start_date, $end_date])->sum('debit');
                        //$credit_total = $credit_total + $cr + $net_profit['net_profit_cr'] + $net_tax['tax_profit_cr'] ;
                        //$debit_total = $debit_total + $dr + $net_profit['net_profit_dr'] + $net_tax['tax_profit_dr'];

                          $credit_total = $credit_total + $cr  ;
                        $debit_total = $debit_total + $dr ;
                        ?>

                        <tr>
                            <td>
 <a href="#view<?php echo e($key->id); ?>" data-toggle="modal""><?php echo e($key->gl_code); ?></a>
</td>
                            <td><?php echo e($key->name); ?></td>

                                 <?php if($key->account_codes == 31101): ?>
                            <td><?php echo e(number_format($net_profit['net_profit_dr'],2)); ?></td>
                            <td><?php echo e(number_format($net_profit['net_profit_cr'],2)); ?></td>
                             <?php if($net_profit['net_profit_cr'] - $net_profit['net_profit_dr'] > 0): ?>
                               <td><?php echo e(number_format($net_profit['net_profit_cr'] - $net_profit['net_profit_dr'] ,2)); ?> Cr</td>
                           <?php elseif($net_profit['net_profit_cr'] - $net_profit['net_profit_dr']== 0): ?>
                               <td><?php echo e(number_format($net_profit['net_profit_cr'] - $net_profit['net_profit_dr'] ,2)); ?> </td>
                           <?php else: ?>
                               <td><?php echo e(number_format(abs($net_profit['net_profit_cr'] - $net_profit['net_profit_dr']),2)); ?> Dr </td>
                           <?php endif; ?> 

                           <?php elseif($key->account_name == 'Deffered Tax'): ?>
                            <td><?php echo e(number_format($net_tax['tax_profit_dr'],2)); ?></td>
                            <td><?php echo e(number_format($net_tax['tax_profit_cr'],2)); ?></td>
                             <?php if($net_tax['tax_profit_cr'] - $net_tax['tax_profit_dr'] > 0): ?>
                               <td ><?php echo e(number_format($net_tax['tax_profit_cr'] - $net_tax['tax_profit_dr'] ,2)); ?> Cr</td>
                           <?php elseif($net_tax['tax_profit_cr'] - $net_tax['tax_profit_dr'] == 0): ?>
                               <td><?php echo e(number_format($net_tax['tax_profit_cr'] - $net_tax['tax_profit_dr'] ,2)); ?> </td>
                           <?php else: ?>
                               <td><?php echo e(number_format(abs($net_tax['tax_profit_cr'] - $net_tax['tax_profit_dr']),2)); ?> Dr </td>
                           <?php endif; ?> 
                        
                        <?php else: ?>
                             <td><?php echo e(number_format($dr,2)); ?></td>
                            <td><?php echo e(number_format($cr,2)); ?></td>
                             <td>
                                <?php if($dr>$cr): ?>
                                    <?php echo e(number_format($dr-$cr,2)); ?> Dr
                                <?php elseif($cr>$dr): ?>
                                    <?php echo e(number_format($cr-$dr,2)); ?> Cr
                                <?php else: ?>
                                    <?php echo e(number_format(0,2)); ?>

                                <?php endif; ?>
                            </td>
                         <?php endif; ?> 
                        </tr>

             
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2"><b>Total</b></td>
                        <td><?php echo e(number_format($debit_total,2)); ?></td>
                        <td><?php echo e(number_format($credit_total,2)); ?></td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>


    <?php else: ?>
       <div class="panel panel-white col-lg-12">
            <div class="panel-body table-responsive no-padding">


                <table id="data-table" class="table table-striped ">
                    <thead>
                    <tr>
                        <th>GL Code</th>
                        <th>Account</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                    </tr>
                    </thead>
                    <tbody>
               
                    <?php
                    $credit_total = 0;
                    $debit_total = 0;
                    ?>
                    <?php $__currentLoopData = \App\Models\ChartOfAccount::orderBy('gl_code','asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <?php
                        $cr = 0;
                        $dr = 0;
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $key->id)->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $key->id)->sum('debit');
                        //$credit_total = $credit_total + $cr + $net_p['net_profit_cr'] + $net_t['tax_profit_cr'] ;
                        //$debit_total = $debit_total + $dr + $net_p['net_profit_dr'] + $net_t['tax_profit_dr'];

                          $credit_total = $credit_total + $cr  ;
                        $debit_total = $debit_total + $dr ;
                        ?>

                        <tr>
                            <td>
 <a href="#view<?php echo e($key->id); ?>" data-toggle="modal""><?php echo e($key->gl_code); ?></a></td>
                            <td><?php echo e($key->name); ?></td>

                                 <?php if($key->account_codes == 31101): ?>
                            <td><?php echo e(number_format($net_p['net_profit_dr'],2)); ?></td>
                            <td><?php echo e(number_format($net_p['net_profit_cr'],2)); ?></td>
                             <?php if($net_p['net_profit_cr'] - $net_p['net_profit_dr'] > 0): ?>
                               <td ><?php echo e(number_format($net_p['net_profit_cr'] - $net_p['net_profit_dr'] ,2)); ?> Cr </td>
                           <?php elseif($net_p['net_profit_cr'] - $net_p['net_profit_dr']== 0): ?>
                               <td><?php echo e(number_format($net_p['net_profit_cr'] - $net_p['net_profit_dr'] ,2)); ?> </td>
                           <?php else: ?>
                               <td><?php echo e(number_format(abs($net_p['net_profit_cr'] - $net_p['net_profit_dr']),2)); ?> Dr </td>
                           <?php endif; ?> 

                           <?php elseif($key->account_name == 'Deffered Tax'): ?>
                            <td><?php echo e(number_format($net_t['tax_profit_dr'],2)); ?></td>
                            <td><?php echo e(number_format($net_t['tax_profit_cr'],2)); ?></td>
                             <?php if($net_t['tax_profit_cr'] - $net_t['tax_profit_dr'] > 0): ?>
                               <td ><?php echo e(number_format($net_t['tax_profit_cr'] - $net_t['tax_profit_dr'] ,2)); ?> Cr </td>
                           <?php elseif($net_t['tax_profit_cr'] - $net_t['tax_profit_dr'] == 0): ?>
                               <td><?php echo e(number_format($net_t['tax_profit_cr'] - $net_t['tax_profit_dr'] ,2)); ?>  </td>
                           <?php else: ?>
                               <td><?php echo e(number_format(abs($net_t['tax_profit_cr'] - $net_t['tax_profit_dr']),2)); ?> Dr </td>
                           <?php endif; ?> 
                        
                        <?php else: ?>
                             <td><?php echo e(number_format($dr,2)); ?></td>
                            <td><?php echo e(number_format($cr,2)); ?></td>
                             <td>
                                <?php if($dr>$cr): ?>
                                    <?php echo e(number_format($dr-$cr,2)); ?> Dr
                                <?php elseif($cr>$dr): ?>
                                    <?php echo e(number_format($cr-$dr,2)); ?> Cr
                                <?php else: ?>
                                          <?php echo e(number_format(0,2)); ?>

                                <?php endif; ?>
                            </td>
                         <?php endif; ?> 
                        </tr>

             
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2"><b>Total</b></td>
                        <td><?php echo e(number_format($debit_total,2)); ?></td>
                        <td><?php echo e(number_format($credit_total,2)); ?></td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    <?php endif; ?>


        

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
 <?php if(!empty($start_date)): ?>
 <?php $__currentLoopData = \App\Models\ChartOfAccount::orderBy('gl_code','asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       
  <!-- Modal -->
  <div class="modal inmodal " id="view<?php echo e($key->id); ?>"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> <?php echo e($key->account_codes); ?> - <?php echo e($key->account_name); ?><h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>

        <div class="modal-body">
             <div class="table-responsive">
                            <table class="table table-bordered table-striped">

                    <?php        
                       if($key->account_codes ==  31101){
?>
<thead>
                    <tr>
                   <th>Account Name</th>
                        <th>Account Code</th>
                          <th>Debit</th>
                        <th>Credit</th>
                      <th>Note</th>
                         
                    </tr>
                    </thead>
                              <tbody>
 <tr>
                        <td colspan="5" style="text-align: left"><b>Income</b></td>
                    </tr>
  <?php   
$total_incomes_start   = 0;
$total_incomes_start1   = 0;
$total_other_incomes_start   = 0;
$total_other_incomes_start1   = 0;
$cost_balance_start   = 0;
$cost_balance_start1   = 0;
$total_cost_start   = 0;
$total_cost_start1   = 0;
$expense_balance_start   = 0;
$expense_balance_start1   = 0;
$total_expense_start   = 0;
$total_expense_start1   = 0;
$gross_start   = 0;
$gross_start1   = 0;
$profit_start =0;
$profit_start1 =0;
$tax_start =0;
$tax_start1 =0;
$net_profit_start =0;
$net_profit_start1 =0;
$total_debit_income_balance_start  =0 ;
$total_debit_income_balance_start1  =0 ;
 $total_credit_income_balance_start   =0 ;
 $total_credit_income_balance_start1   =0 ;
  $total_debit_other_income_balance_start    =0 ;
  $total_debit_other_income_balance_start1    =0 ;
  $total_credit_other_income_balance_start   =0 ;
  $total_credit_other_income_balance_start1   =0 ;
   $total_debit_cost_balance_start    =0 ;
   $total_debit_cost_balance_start1    =0 ;
   $total_credit_cost_balance_start   =0 ;
   $total_credit_cost_balance_start1   =0 ;
   $total_debit_expense_balance_start    =0 ;
   $total_debit_expense_balance_start1    =0 ;
   $total_credit_expense_balance_start   =0 ;
   $total_credit_expense_balance_start1   =0 ;
$gross_dr_start   = 0;
$gross_dr_start1   = 0;
$gross_cr_start   = 0;
$gross_cr_start1   = 0;
$tax_dr_start =0;
$tax_dr_start1 =0;
$tax_cr_start =0;
$tax_cr_start1 =0;
$profit_dr_start =0;
$profit_dr_start1 =0;
$profit_cr_start =0;
$profit_cr_start1 =0; 
$net_profit_dr_start =0;
$net_profit_dr_start1 =0;
$net_profit_cr_start =0;
$net_profit_cr_start1 =0;

$net_dr_start =0;
$net_cr_start =0;



           
           
foreach($income as $account_class_modal){
foreach($account_class_modal->groupAccount as $group_modal) {  
foreach($group_modal->accountCodes as $account_code_modal){
     
     
                         $cr_start = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                         $total_debit_income_balance_start +=$dr_start  ;
                         $total_credit_income_balance_start  +=$cr_start ;

                          $income_balance_start =$dr_start - $cr_start ;
                          $total_incomes_start +=$income_balance_start  ;

                          ?>
<tr>
  <td><?php echo e($account_code_modal->account_name); ?></td>
<td><?php echo e($account_code_modal->account_codes); ?></td>
  <td><?php echo e(number_format($dr_start ,2)); ?></td>
      <td><?php echo e(number_format($cr_start ,2)); ?></td>
   <td><?php echo e($account_code_modal->notes); ?></td>  
</tr>                
  <?php  

    }}}           
?>



 <tr>
                        <td colspan="5" style="text-align: left"><b> Financial Cost</b></td>
                    </tr>
  <?php  
foreach($cost as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal) {
foreach($group_modal->accountCodes as $account_code_modal){


                   $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                     
                            
                        $total_debit_cost_balance_start    +=$dr_start  ;
                         $total_credit_cost_balance_start   +=$cr_start ;

                        $cost_balance_start =$dr_start - $cr_start ;
                        $total_cost_start +=$cost_balance_start  ;

  ?>
<tr>
  <td><?php echo e($account_code_modal->account_name); ?></td>
<td><?php echo e($account_code_modal->account_codes); ?></td>
  <td><?php echo e(number_format($dr_start ,2)); ?></td>
      <td><?php echo e(number_format($cr_start ,2)); ?></td>
      
       <td><?php echo e($account_code_modal->notes); ?></td>    
</tr>                
  <?php  

                            
}}}
?>

<tr>
                        <td >
                             <b>Total Financial Cost</b></td>
                       <td></td>
                              <td><?php echo e(number_format($total_debit_cost_balance_start ,2)); ?></td>
      <td><?php echo e(number_format($total_credit_cost_balance_start,2)); ?></td>
        <td></td>
      
                    </tr> 

  <?php  
 if($total_debit_income_balance_start   < 0){
$total_s=$total_debit_income_balance_start   * -1;
$gross_dr_start =$total_s -$total_debit_cost_balance_start ;
}
else if($total_debit_income_balance_start  >= 0){
$gross_dr_start =$total_debit_income_balance_start  -$total_debit_cost_balance_start ;
}

 if($total_credit_income_balance_start   < 0){
$total_s_cr=$total_credit_income_balance_start   * -1;
$gross_cr_start =$total_s_cr-$total_credit_cost_balance_start ;
}
else if($total_credit_income_balance_start  >= 0){
$gross_cr_start =$total_credit_income_balance_start   -$total_credit_cost_balance_start ;
}


?>

  <tr>
                        <td >
                            <b>Gross Profit</b></td>
                    <td></td>
                            <td><b><?php echo e(number_format($gross_dr_start ,2)); ?></b></td>
                <td><b><?php echo e(number_format($gross_cr_start ,2)); ?></b></td>
                
            
                    </tr> 

<tr>
                        <td colspan="5" style="text-align: left"><b>Expenses</b></td>
                    </tr>
  <?php  
foreach($expense as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal)  {      
foreach($group_modal->accountCodes as $account_code_modal){

                   $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                               
                            
                           $total_debit_expense_balance_start    +=$dr_start  ;
                         $total_credit_expense_balance_start   +=$cr_start ;

                $expense_balance_start =$dr_start - $cr_start ;
                $total_expense_start +=$expense_balance_start  ;
                          
  ?>
  <tr>
  <td><?php echo e($account_code_modal->account_name); ?></td>
<td><?php echo e($account_code_modal->account_codes); ?></td>
  <td><?php echo e(number_format($dr_start ,2)); ?></td>
      <td><?php echo e(number_format($cr_start ,2)); ?></td>
         <td><?php echo e($account_code_modal->notes); ?></td>  
     
       </tr>             
  <?php  

}}}

?>

<tr>
                        <td >
                             <b>Total Expenses</b></td>
                       <td></td>
                               <td><?php echo e(number_format($total_debit_expense_balance_start ,2)); ?></td>
                                  <td><?php echo e(number_format($total_credit_expense_balance_start ,2)); ?></td>
                                    <td></td>
                                 
                    </tr> 

  <?php  

if($gross_dr_start  < 0){
$profit_dr_start =$gross_dr_start + $total_debit_expense_balance_start ;
}
else if($gross_dr_start  < 0 &&  $total_debit_expense_balance_start   < 0){
$profit_dr_start =$gross_dr_start + $total_debit_expense_balance_start ;
}
else if($gross_dr_start  >= 0 &&  $total_debit_expense_balance_start   < 0){
$profit_dr_start = $total_debit_expense_balance_start  +$gross_dr_start ;
}
else{
$profit_dr_start =$gross_dr_start -$total_debit_expense_balance_start ;
}


if($gross_cr_start  < 0){
$profit_cr_start =$gross_cr_start + $total_credit_expense_balance_start ;
}
else if($gross_cr_start  < 0 &&  $total_credit_expense_balance_start   < 0){
$profit_cr_start =$gross_cr_start + $total_credit_expense_balance_start ;
}
else if($gross_cr_start >= 0 &&  $total_credit_expense_balance_start  < 0){
$profit_cr_start = $total_credit_expense_balance_start   +$gross_cr_start ;
}
else{
$profit_cr_start =$gross_cr_start -$total_credit_expense_balance_start ;
}

  if($profit_dr_start  < 0){
$p=$profit_dr_start +$profit_cr_start;
}
else{
$p=$profit_cr_start - $profit_dr_start;
}

if($p  > 0){
$tax_dr_start =$profit_dr_start *0.3;
$tax_cr_start =$profit_cr_start *0.3;
}
$net_dr_start =$profit_dr_start -$tax_dr_start ;
$net_cr_start =$profit_cr_start -$tax_cr_start ;

if($net_cr_start  < 0){
$net_pt_start =$net_dr_start +$net_cr_start ;
}
else{
$net_pt_start =abs($net_cr_start) -abs($net_dr_start) ;
}

?>

<tr>
                        <td>
                           <b>Profit Before Tax</b></td>
                            <td></td>
                                 <td><b><?php echo e(number_format(abs($profit_dr_start) ,2)); ?></b></td>
                         <td ><b><?php echo e(number_format(abs($profit_cr_start) ,2)); ?></b></td>
                           <td></td>
                               
                    </tr>
                     <tr>
                        <td>
                            <b>Tax</b></td>
                         <td></td>
                              <td><b><?php echo e(number_format(abs($tax_dr_start) ,2)); ?></b></td>
                        <td><b><?php echo e(number_format(abs($tax_cr_start),2)); ?></b></td>
                          <td></td>
                        
                    </tr>
                     <tr>
                        <td>
                           <b>Net Profit</b></td>
<td></td>
                        <td><b><?php echo e(number_format(abs($net_dr_start) ,2)); ?></b></td>
                        <td><b><?php echo e(number_format(abs($net_cr_start) ,2)); ?></b></td>
                        
                     
                    </tr>

   <tr>
                        <td colspan="2">
                           <b><?php echo e($key->account_name); ?> Total Balance</b></td>
                              <?php if($net_pt_start > 0): ?>
                               <td colspan="3"><b><?php echo e(number_format($net_pt_start ,2)); ?> Cr </b></td>
                           <?php elseif($net_pt_start == 0): ?>
                               <td colspan="3"><b><?php echo e(number_format($net_pt_start ,2)); ?>  </b></td>
                           <?php else: ?>
                               <td colspan="3"><b><?php echo e(number_format(abs($net_pt_start),2)); ?> Dr </b></td>
                           <?php endif; ?> 
                           
                        

                      
                    </tr>




  <?php  
}

else if($key->account_name == 'Deffered Tax'){
?>
<thead>
                       <tr>
                   <th>Account Name</th>
                        <th>Account Code</th>
                          <th>Debit</th>
                        <th>Credit</th>
                      <th>Note</th>
                         
                    </tr>
                    </thead>
                              <tbody>
 <tr>
                        <td colspan="5" style="text-align: left"><b>Income</b></td>
                    </tr>

  <?php   
$total_incomes_deff   = 0;
$total_other_incomes_deff   = 0;
$cost_balance_deff   = 0;
$total_cost_deff   = 0;
$expense_balance_deff   = 0;
$total_expense_deff   = 0;
$gross_deff   = 0;
$profit_deff =0;
$tax_deff =0;
$net_profit_deff =0;
$total_debit_income_balance_deff  =0 ;
 $total_credit_income_balance_deff   =0 ;
  $total_debit_other_income_balance_deff    =0 ;
  $total_credit_other_income_balance_deff   =0 ;
   $total_debit_cost_balance_deff    =0 ;
   $total_credit_cost_balance_deff   =0 ;
   $total_debit_expense_balance_deff    =0 ;
   $total_credit_expense_balance_deff   =0 ;
$gross_dr_deff   = 0;
$gross_cr_deff   = 0;
$tax_dr_deff =0;
$tax_cr_deff =0;
$profit_dr_deff =0;
$profit_cr_deff =0;   
$net_profit_dr_deff =0;
$net_profit_cr_deff =0;   

           
foreach($income as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal) {  

foreach($group_modal->accountCodes as $account_code_modal){
     
     
                         $cr_deff = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_deff  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                         $total_debit_income_balance_deff  +=$dr_deff  ;
                         $total_credit_income_balance_deff  +=$cr_deff ;

                          $income_balance_deff =$dr_deff - $cr_deff ;
                          $total_incomes_deff +=$income_balance_deff  ;
                          ?>
<tr>
  <td><?php echo e($account_code_modal->account_name); ?></td>
<td><?php echo e($account_code_modal->account_codes); ?></td>
  <td><?php echo e(number_format(abs($dr_deff),2)); ?></td>
  <td><?php echo e(number_format(abs($cr_deff),2)); ?></td>
<td><?php echo e($account_code_modal->notes); ?></td>
</tr>                
  <?php  

    }}}         
?>

<tr>
                        <td >
                            <b>Total Income</b></td>
                       <td></td>
                            <td><?php echo e(number_format(abs($total_debit_income_balance_deff),2)); ?></td>
  <td><?php echo e(number_format(abs($total_credit_income_balance_deff),2)); ?></td>                          
                    </tr> 

 
 <tr>
                        <td colspan="5" style="text-align: left"><b>Financial Cost</b></td>
                    </tr>
  <?php  
foreach($cost as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal) {
if($group_modal->group_id == 6180){
foreach($group_modal->accountCodes as $account_code_modal){


                   $cr_deff  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_deff  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            
                        $total_debit_cost_balance_deff    +=$dr_deff  ;
                         $total_credit_cost_balance_deff   +=$cr_deff ;

                        $cost_balance_deff =$dr_deff - $cr_deff ;
                        $total_cost_deff +=$cost_balance_deff  ;

  ?>
<tr>
  <td><?php echo e($account_code_modal->account_name); ?></td>
<td><?php echo e($account_code_modal->account_codes); ?></td>
    <td><?php echo e(number_format(abs($dr_deff),2)); ?></td>
  <td><?php echo e(number_format(abs($cr_deff),2)); ?></td>
<td><?php echo e($account_code_modal->notes); ?></td>
</tr>                
  <?php  

                            
}}}}
?>

<tr>
                        <td >
                             <b>Total Financial Cost</b></td>
                       <td></td>
      <td><?php echo e(number_format(abs($total_debit_cost_balance_deff),2)); ?></td>
    <td><?php echo e(number_format(abs($total_credit_cost_balance_deff),2)); ?></td>
       <td></td>
                    </tr> 

  <?php  

 if($total_debit_income_balance_deff   < 0){
$total_s=$total_debit_income_balance_deff   * -1;
$gross_dr_deff =$total_s-$total_debit_cost_balance_deff ;
}
else if($total_debit_income_balance_deff  >= 0){
$gross_dr_deff =$total_debit_income_balance_deff  -$total_debit_cost_balance_deff ;
}

 if($total_credit_income_balance_deff   < 0){
$total_s_cr=$total_credit_income_balance_deff   * -1;
$gross_cr_deff =$total_s_cr -$total_credit_cost_balance_deff ;
}
else if($total_credit_income_balance_deff  >= 0){
$gross_cr_deff =$total_credit_income_balance_deff   -$total_credit_cost_balance_deff ;
}


?>

  <tr>
                        <td >
                            <b>Gross Profit</b></td>
                    <td></td>
                            <td><b><?php echo e(number_format($gross_dr_deff ,2)); ?></b></td>
                <td><b><?php echo e(number_format($gross_cr_deff ,2)); ?></b></td>
                
            
                    </tr> 

<tr>
                        <td colspan="5" style="text-align: left"><b>Expenses</b></td>
                    </tr>
  <?php  
foreach($expense as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal)  {      
foreach($group_modal->accountCodes as $account_code_modal){

                   $cr_deff  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_deff  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                               
                            
                           $total_debit_expense_balance_deff    +=$dr_deff  ;
                         $total_credit_expense_balance_deff   +=$cr_deff ;

                $expense_balance_deff =$dr_deff - $cr_deff ;
                $total_expense_deff +=$expense_balance_deff  ;
                          
  ?>
  <tr>
  <td><?php echo e($account_code_modal->account_name); ?></td>
<td><?php echo e($account_code_modal->account_codes); ?></td>
  <td><?php echo e(number_format($dr_deff ,2)); ?></td>
      <td><?php echo e(number_format($cr_deff ,2)); ?></td>
      <td><?php echo e($account_code_modal->notes); ?></td>
     
       </tr>             
  <?php  

}}}

?>

<tr>
                        <td >
                             <b>Total Expenses</b></td>
                       <td></td>
                               <td><?php echo e(number_format($total_debit_expense_balance_deff ,2)); ?></td>
                                  <td><?php echo e(number_format($total_credit_expense_balance_deff ,2)); ?></td>
                                         <td></td>
                                 
                    </tr> 

  <?php  

if($gross_dr_deff  < 0){
$profit_dr_deff =$gross_dr_deff + $total_debit_expense_balance_deff ;
}
else if($gross_dr_deff  < 0 &&  $total_debit_expense_balance_deff   < 0){
$profit_dr_deff =$gross_dr_deff + $total_debit_expense_balance_deff ;
}
else if($gross_dr_deff  >= 0 &&  $total_debit_expense_balance_deff   < 0){
$profit_dr_deff = $total_debit_expense_balance_deff  +$gross_dr_deff ;
}
else{
$profit_dr_deff =$gross_dr_deff -$total_debit_expense_balance_deff ;
}


if($gross_cr_deff  < 0){
$profit_cr_deff =$gross_cr_deff + $total_credit_expense_balance_deff ;
}
else if($gross_cr_deff  < 0 &&  $total_credit_expense_balance_deff   < 0){
$profit_cr_deff =$gross_cr_deff + $total_credit_expense_balance_deff ;
}
else if($gross_cr_deff >= 0 &&  $total_credit_expense_balance_deff  < 0){
$profit_cr_deff = $total_credit_expense_balance_deff   +$gross_cr_deff ;
}
else{
$profit_cr_deff =$gross_cr_deff -$total_credit_expense_balance_deff ;
}

  if($profit_dr_deff  < 0){
$p=$profit_dr_deff +$profit_cr_deff;
}
else{
$p=$profit_cr_deff - $profit_dr_deff;
}

if($p  > 0){
$tax_dr_deff =$profit_dr_deff *0.3;
$tax_cr_deff =$profit_cr_deff *0.3;
}

$tax_pt_deff =abs($tax_cr_deff) -abs($tax_dr_deff) ;

?>

<tr>
                        <td>
                           <b>Profit Before Tax</b></td>
                            <td></td>
                                 <td><b><?php echo e(number_format(abs($profit_dr_deff) ,2)); ?></b></td>
                         <td ><b><?php echo e(number_format(abs($profit_cr_deff) ,2)); ?></b></td>
                                <td></td>
                               
                    </tr>
                     <tr>
                        <td>
                            <b>Tax</b></td>
                         <td></td>
                              <td><b><?php echo e(number_format(abs($tax_dr_deff) ,2)); ?></b></td>
                        <td><b><?php echo e(number_format(abs($tax_cr_deff),2)); ?></b></td>
                                     <td></td>                 
                    </tr>
                   
                     <tr>
                        <td colspan="2">
                           <b><?php echo e($key->account_name); ?> Total Balance</b></td>
                              <?php if($tax_pt_deff> 0): ?>
                               <td colspan="3"><b><?php echo e(number_format($tax_pt_deff ,2)); ?> Cr </b></td>
                           <?php elseif($tax_pt_deff == 0): ?>
                               <td colspan="3"><b><?php echo e(number_format($tax_pt_deff ,2)); ?>  </b></td>
                           <?php else: ?>
                               <td colspan="3"><b><?php echo e(number_format(abs($tax_pt_deff),2)); ?> Dr </b></td>
                           <?php endif; ?> 
                           
                        

                      
                    </tr>
                   


  <?php  
}


else{   
  ?>
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
                        $account = \App\Models\JournalEntry::where('account_id', $key->id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->orderBy('date','asc')->get();
                            
                       $account1 = \App\Models\JournalEntry::where('account_id', $key->id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->orderBy('date','asc')->get();
                        ?>  
                 <?php $__currentLoopData = $account; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                        <td ><?php echo e($a->date); ?></td>
                          <td><?php echo e(number_format($a->debit ,2)); ?></td>
                   <td ><?php echo e(number_format($a->credit ,2)); ?></td>
                     <td ><?php echo e($a->notes); ?></td>
                    </tr> 

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
            
    
 <?php
                   
                        $cr_modal = \App\Models\JournalEntry::where('account_id', $key->id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_modal = \App\Models\JournalEntry::where('account_id', $key->id)->whereBetween('date',
                            [$start_date, $end_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                       
                        ?>  
                    <tr>     
                        <td>
                            <b>Total</b></td>
                           <td><b><?php echo e(number_format($dr_modal,2)); ?></b></td>
                            <td><b><?php echo e(number_format($cr_modal,2)); ?></b></td>
                             <td></td>
                             
                    </tr> 
  <tr>
                        <td >
                              <b><?php echo e($key->account_name); ?> Total Balance</b></td>                           
                            <?php if($key->account_type == 'Assets' || $key->account_type  == 'Expense'): ?>
     <td colspan="2"> 
<?php if($dr_modal-$cr_modal < 0): ?>
<b><?php echo e(number_format(abs($dr_modal-$cr_modal) ,2)); ?> Cr</b>
<?php elseif($dr_modal-$cr_modal == 0): ?>
<b><?php echo e(number_format($dr_modal-$cr_modal ,2)); ?> </b>
<?php else: ?>
<b><?php echo e(number_format($dr_modal-$cr_modal ,2)); ?> Dr</b>
<?php endif; ?> 
</td>                                
                           <?php else: ?>
                         <td colspan="2">
                    <?php if($cr_modal-$dr_modal > 0): ?>
<b><?php echo e(number_format(abs($dr_modal-$cr_modal) ,2)); ?> Cr</b>
<?php elseif($cr_modal-$dr_modal == 0): ?>
<b><?php echo e(number_format($dr_modal-$cr_modal ,2)); ?> </b>
<?php else: ?>
<b><?php echo e(number_format($cr_modal-$dr_modal ,2)); ?> Dr</b>
<?php endif; ?> 

                           <?php endif; ?> 
                       
   <td></td>
                    </tr> 
<?php
}
?>
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
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php else: ?>
                    <?php $__currentLoopData = \App\Models\ChartOfAccount::orderBy('gl_code','asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       
  <!-- Modal -->
  <div class="modal inmodal " id="view<?php echo e($key->id); ?>"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> <?php echo e($key->account_codes); ?> - <?php echo e($key->account_name); ?><h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>

        <div class="modal-body">
             <div class="table-responsive">
                            <table class="table table-bordered table-striped">

                    <?php        
                       if($key->account_codes == 31101){
?>
<thead>
                    <tr>
                   <th>Account Name</th>
                        <th>Account Code</th>
                          <th>Debit</th>
                        <th>Credit</th>
                      <th>Note</th>
                         
                    </tr>
                    </thead>
                              <tbody>
 <tr>
                        <td colspan="5" style="text-align: left"><b>Income</b></td>
                    </tr>
  <?php   
$total_incomes_start   = 0;
$total_incomes_start1   = 0;
$total_other_incomes_start   = 0;
$total_other_incomes_start1   = 0;
$cost_balance_start   = 0;
$cost_balance_start1   = 0;
$total_cost_start   = 0;
$total_cost_start1   = 0;
$expense_balance_start   = 0;
$expense_balance_start1   = 0;
$total_expense_start   = 0;
$total_expense_start1   = 0;
$gross_start   = 0;
$gross_start1   = 0;
$profit_start =0;
$profit_start1 =0;
$tax_start =0;
$tax_start1 =0;
$net_profit_start =0;
$net_profit_start1 =0;
$total_debit_income_balance_start  =0 ;
$total_debit_income_balance_start1  =0 ;
 $total_credit_income_balance_start   =0 ;
 $total_credit_income_balance_start1   =0 ;
  $total_debit_other_income_balance_start    =0 ;
  $total_debit_other_income_balance_start1    =0 ;
  $total_credit_other_income_balance_start   =0 ;
  $total_credit_other_income_balance_start1   =0 ;
   $total_debit_cost_balance_start    =0 ;
   $total_debit_cost_balance_start1    =0 ;
   $total_credit_cost_balance_start   =0 ;
   $total_credit_cost_balance_start1   =0 ;
   $total_debit_expense_balance_start    =0 ;
   $total_debit_expense_balance_start1    =0 ;
   $total_credit_expense_balance_start   =0 ;
   $total_credit_expense_balance_start1   =0 ;
$gross_dr_start   = 0;
$gross_dr_start1   = 0;
$gross_cr_start   = 0;
$gross_cr_start1   = 0;
$tax_dr_start =0;
$tax_dr_start1 =0;
$tax_cr_start =0;
$tax_cr_start1 =0;
$profit_dr_start =0;
$profit_dr_start1 =0;
$profit_cr_start =0;
$profit_cr_start1 =0; 
$net_profit_dr_start =0;
$net_profit_dr_start1 =0;
$net_profit_cr_start =0;
$net_profit_cr_start1 =0;

$net_dr_start =0;
$net_cr_start =0;



           
           
foreach($income as $account_class_modal){
foreach($account_class_modal->groupAccount as $group_modal) {  
if($group_modal->group_id != 5110){
foreach($group_modal->accountCodes as $account_code_modal){
     
     
                         $cr_start = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                         $total_debit_income_balance_start +=$dr_start  ;
                         $total_credit_income_balance_start  +=$cr_start ;

                          $income_balance_start =$dr_start - $cr_start ;
                          $total_incomes_start +=$income_balance_start  ;

                          ?>
<tr>
  <td><?php echo e($account_code_modal->account_name); ?></td>
<td><?php echo e($account_code_modal->account_codes); ?></td>
  <td><?php echo e(number_format($dr_start ,2)); ?></td>
      <td><?php echo e(number_format($cr_start ,2)); ?></td>
   <td><?php echo e($account_code_modal->notes); ?></td>  
</tr>                
  <?php  

    }}}}           
?>


<!--
 <tr>
                        <td colspan="5" style="text-align: left"><b> Financial Cost</b></td>
                    </tr>
  <?php  
foreach($cost as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal) {
if($group_modal->group_id == 6180){
foreach($group_modal->accountCodes as $account_code_modal){


                   $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');
                     
                            
                        $total_debit_cost_balance_start    +=$dr_start  ;
                         $total_credit_cost_balance_start   +=$cr_start ;

                        $cost_balance_start =$dr_start - $cr_start ;
                        $total_cost_start +=$cost_balance_start  ;

  ?>
<tr>
  <td><?php echo e($account_code_modal->account_name); ?></td>
<td><?php echo e($account_code_modal->account_codes); ?></td>
  <td><?php echo e(number_format($dr_start ,2)); ?></td>
      <td><?php echo e(number_format($cr_start ,2)); ?></td>
      
       <td><?php echo e($account_code_modal->notes); ?></td>    
</tr>                
  <?php  

                            
}}}}
?>

<tr>
                        <td >
                             <b>Total Financial Cost</b></td>
                       <td></td>
                              <td><?php echo e(number_format($total_debit_cost_balance_start ,2)); ?></td>
      <td><?php echo e(number_format($total_credit_cost_balance_start,2)); ?></td>
        <td></td>
      
                    </tr> 
-->

  <?php  
 if($total_debit_income_balance_start   < 0){
$total_s=$total_debit_income_balance_start   * -1;
$gross_dr_start =$total_s+$total_debit_other_income_balance_start -$total_debit_cost_balance_start ;
}
else if($total_debit_income_balance_start  >= 0){
$gross_dr_start =$total_debit_income_balance_start +$total_debit_other_income_balance_start -$total_debit_cost_balance_start ;
}

 if($total_credit_income_balance_start   < 0){
$total_s_cr=$total_credit_income_balance_start   * -1;
$gross_cr_start =$total_s_cr+$total_credit_other_income_balance_start -$total_credit_cost_balance_start ;
}
else if($total_credit_income_balance_start  >= 0){
$gross_cr_start =$total_credit_income_balance_start  + $total_credit_other_income_balance_start -$total_credit_cost_balance_start ;
}


?>

  <tr>
                        <td >
                            <b>Total Income</b></td>
                    <td></td>
                            <td><b><?php echo e(number_format($gross_dr_start ,2)); ?></b></td>
                <td><b><?php echo e(number_format($gross_cr_start ,2)); ?></b></td>
                <td></td>
            
                    </tr> 


<tr>
                        <td colspan="5" style="text-align: left"><b>Expenses</b></td>
                    </tr>
  <?php  
foreach($expense as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal)  {      
if($group_modal->group_id != 6180){
foreach($group_modal->accountCodes as $account_code_modal){

                   $cr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_start  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');
                               
                            
                           $total_debit_expense_balance_start    +=$dr_start  ;
                         $total_credit_expense_balance_start   +=$cr_start ;

                $expense_balance_start =$dr_start - $cr_start ;
                $total_expense_start +=$expense_balance_start  ;
                          
  ?>
  <tr>
  <td><?php echo e($account_code_modal->account_name); ?></td>
<td><?php echo e($account_code_modal->account_codes); ?></td>
  <td><?php echo e(number_format($dr_start ,2)); ?></td>
      <td><?php echo e(number_format($cr_start ,2)); ?></td>
         <td><?php echo e($account_code_modal->notes); ?></td>  
     
       </tr>             
  <?php  

}}}}

?>

<tr>
                        <td >
                             <b>Total Expenses</b></td>
                       <td></td>
                               <td><?php echo e(number_format($total_debit_expense_balance_start ,2)); ?></td>
                                  <td><?php echo e(number_format($total_credit_expense_balance_start ,2)); ?></td>
                                    <td></td>
                                 
                    </tr> 

  <?php  

if($gross_dr_start  < 0){
$profit_dr_start =$gross_dr_start + $total_debit_expense_balance_start ;
}
else if($gross_dr_start  < 0 &&  $total_debit_expense_balance_start   < 0){
$profit_dr_start =$gross_dr_start + $total_debit_expense_balance_start ;
}
else if($gross_dr_start  >= 0 &&  $total_debit_expense_balance_start   < 0){
$profit_dr_start = $total_debit_expense_balance_start  +$gross_dr_start ;
}
else{
$profit_dr_start =$gross_dr_start -$total_debit_expense_balance_start ;
}


if($gross_cr_start  < 0){
$profit_cr_start =$gross_cr_start + $total_credit_expense_balance_start ;
}
else if($gross_cr_start  < 0 &&  $total_credit_expense_balance_start   < 0){
$profit_cr_start =$gross_cr_start + $total_credit_expense_balance_start ;
}
else if($gross_cr_start >= 0 &&  $total_credit_expense_balance_start  < 0){
$profit_cr_start = $total_credit_expense_balance_start   +$gross_cr_start ;
}
else{
$profit_cr_start =$gross_cr_start -$total_credit_expense_balance_start ;
}

  if($profit_dr_start  < 0){
$p=$profit_dr_start +$profit_cr_start;
}
else{
$p=$profit_cr_start - $profit_dr_start;
}

if($p  > 0){
$tax_dr_start =$profit_dr_start *0.3;
$tax_cr_start =$profit_cr_start *0.3;
}
$net_dr_start =$profit_dr_start -$tax_dr_start ;
$net_cr_start =$profit_cr_start -$tax_cr_start ;

if($net_cr_start  < 0){
$net_pt_start =$net_dr_start +$net_cr_start ;
}
else{
$net_pt_start =abs($net_cr_start) -abs($net_dr_start) ;
}

?>

<tr>
                        <td>
                           <b>Profit Before Tax</b></td>
                            <td></td>
                                 <td><b><?php echo e(number_format(abs($profit_dr_start) ,2)); ?></b></td>
                         <td ><b><?php echo e(number_format(abs($profit_cr_start) ,2)); ?></b></td>
                           <td></td>
                               
                    </tr>
                     <tr>
                        <td>
                            <b>Tax</b></td>
                         <td></td>
                              <td><b><?php echo e(number_format(abs($tax_dr_start) ,2)); ?></b></td>
                        <td><b><?php echo e(number_format(abs($tax_cr_start),2)); ?></b></td>
                          <td></td>
                        
                    </tr>
                     <tr>
                        <td>
                           <b>Net Profit</b></td>
<td></td>
                        <td><b><?php echo e(number_format(abs($net_dr_start) ,2)); ?></b></td>
                        <td><b><?php echo e(number_format(abs($net_cr_start) ,2)); ?></b></td>
                        
                     
                    </tr>

   <tr>
                        <td colspan="2">
                           <b><?php echo e($key->account_name); ?> Total Balance</b></td>
                              <?php if($net_pt_start > 0): ?>
                               <td colspan="3"><b><?php echo e(number_format($net_pt_start ,2)); ?> Cr </b></td>
                           <?php elseif($net_pt_start == 0): ?>
                               <td colspan="3"><b><?php echo e(number_format($net_pt_start ,2)); ?>  </b></td>
                           <?php else: ?>
                               <td colspan="3"><b><?php echo e(number_format(abs($net_pt_start),2)); ?> Dr </b></td>
                           <?php endif; ?> 
                           
                        

                      
                    </tr>




  <?php  
}

else if($key->account_name == 'Deffered Tax'){
?>
<thead>
                       <tr>
                   <th>Account Name</th>
                        <th>Account Code</th>
                          <th>Debit</th>
                        <th>Credit</th>
                      <th>Note</th>
                         
                    </tr>
                    </thead>
                              <tbody>
 <tr>
                        <td colspan="5" style="text-align: left"><b>Income</b></td>
                    </tr>

  <?php   
$total_incomes_deff   = 0;
$total_other_incomes_deff   = 0;
$cost_balance_deff   = 0;
$total_cost_deff   = 0;
$expense_balance_deff   = 0;
$total_expense_deff   = 0;
$gross_deff   = 0;
$profit_deff =0;
$tax_deff =0;
$net_profit_deff =0;
$total_debit_income_balance_deff  =0 ;
 $total_credit_income_balance_deff   =0 ;
  $total_debit_other_income_balance_deff    =0 ;
  $total_credit_other_income_balance_deff   =0 ;
   $total_debit_cost_balance_deff    =0 ;
   $total_credit_cost_balance_deff   =0 ;
   $total_debit_expense_balance_deff    =0 ;
   $total_credit_expense_balance_deff   =0 ;
$gross_dr_deff   = 0;
$gross_cr_deff   = 0;
$tax_dr_deff =0;
$tax_cr_deff =0;
$profit_dr_deff =0;
$profit_cr_deff =0;   
$net_profit_dr_deff =0;
$net_profit_cr_deff =0;   

           
foreach($income as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal) {  
if($group_modal->group_id != 5110){
foreach($group_modal->accountCodes as $account_code_modal){
     
     
                         $cr_deff = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_deff  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');

                         $total_debit_income_balance_deff  +=$dr_deff  ;
                         $total_credit_income_balance_deff  +=$cr_deff ;

                          $income_balance_deff =$dr_deff - $cr_deff ;
                          $total_incomes_deff +=$income_balance_deff  ;
                          ?>
<tr>
  <td><?php echo e($account_code_modal->account_name); ?></td>
<td><?php echo e($account_code_modal->account_codes); ?></td>
  <td><?php echo e(number_format(abs($dr_deff),2)); ?></td>
  <td><?php echo e(number_format(abs($cr_deff),2)); ?></td>
<td><?php echo e($account_code_modal->notes); ?></td>
</tr>                
  <?php  

    }}}}           
?>

<tr>
                        <td >
                            <b>Total Income</b></td>
                       <td></td>
                            <td><?php echo e(number_format(abs($total_debit_income_balance_deff),2)); ?></td>
  <td><?php echo e(number_format(abs($total_credit_income_balance_deff),2)); ?></td>   
<td></td>                       
                    </tr> 

<!--  
 <tr>
                        <td colspan="5" style="text-align: left"><b>Financial Cost</b></td>
                    </tr>
  <?php  
foreach($cost as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal) {
if($group_modal->group_id == 6180){
foreach($group_modal->accountCodes as $account_code_modal){


                   $cr_deff  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_deff  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');
                            
                        $total_debit_cost_balance_deff    +=$dr_deff  ;
                         $total_credit_cost_balance_deff   +=$cr_deff ;

                        $cost_balance_deff =$dr_deff - $cr_deff ;
                        $total_cost_deff +=$cost_balance_deff  ;

  ?>
<tr>
  <td><?php echo e($account_code_modal->account_name); ?></td>
<td><?php echo e($account_code_modal->account_codes); ?></td>
    <td><?php echo e(number_format(abs($dr_deff),2)); ?></td>
  <td><?php echo e(number_format(abs($cr_deff),2)); ?></td>
<td><?php echo e($account_code_modal->notes); ?></td>
</tr>                
  <?php  

                            
}}}}
?>

<tr>
                        <td >
                             <b>Total Financial Cost</b></td>
                       <td></td>
      <td><?php echo e(number_format(abs($total_debit_cost_balance_deff),2)); ?></td>
    <td><?php echo e(number_format(abs($total_credit_cost_balance_deff),2)); ?></td>
       <td></td>
                    </tr> 
-->

  <?php  

 if($total_debit_income_balance_deff   < 0){
$total_s=$total_debit_income_balance_deff   * -1;
$gross_dr_deff =$total_s+$total_debit_other_income_balance_deff -$total_debit_cost_balance_deff ;
}
else if($total_debit_income_balance_deff  >= 0){
$gross_dr_deff =$total_debit_income_balance_deff +$total_debit_other_income_balance_deff -$total_debit_cost_balance_deff ;
}

 if($total_credit_income_balance_deff   < 0){
$total_s_cr=$total_credit_income_balance_deff   * -1;
$gross_cr_deff =$total_s_cr+$total_credit_other_income_balance_deff -$total_credit_cost_balance_deff ;
}
else if($total_credit_income_balance_deff  >= 0){
$gross_cr_deff =$total_credit_income_balance_deff  + $total_credit_other_income_balance_deff -$total_credit_cost_balance_deff ;
}


?>
<!--
  <tr>
                        <td >
                            <b>Gross Profit</b></td>
                    <td></td>
                            <td><b><?php echo e(number_format($gross_dr_deff ,2)); ?></b></td>
                <td><b><?php echo e(number_format($gross_cr_deff ,2)); ?></b></td>
                
            
                    </tr> 
-->
<tr>
                        <td colspan="5" style="text-align: left"><b>Expenses</b></td>
                    </tr>
  <?php  
foreach($expense as $account_class_modal){
foreach($account_class_modal->groupAccount  as $group_modal)  {      
if($group_modal->group_id != 6180){
foreach($group_modal->accountCodes as $account_code_modal){

                   $cr_deff  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_deff  = \App\Models\JournalEntry::where('account_id', $account_code_modal->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit');
                               
                            
                           $total_debit_expense_balance_deff    +=$dr_deff  ;
                         $total_credit_expense_balance_deff   +=$cr_deff ;

                $expense_balance_deff =$dr_deff - $cr_deff ;
                $total_expense_deff +=$expense_balance_deff  ;
                          
  ?>
  <tr>
  <td><?php echo e($account_code_modal->account_name); ?></td>
<td><?php echo e($account_code_modal->account_codes); ?></td>
  <td><?php echo e(number_format($dr_deff ,2)); ?></td>
      <td><?php echo e(number_format($cr_deff ,2)); ?></td>
      <td><?php echo e($account_code_modal->notes); ?></td>
     
       </tr>             
  <?php  

}}}}

?>

<tr>
                        <td >
                             <b>Total Expenses</b></td>
                       <td></td>
                               <td><?php echo e(number_format($total_debit_expense_balance_deff ,2)); ?></td>
                                  <td><?php echo e(number_format($total_credit_expense_balance_deff ,2)); ?></td>
                                         <td></td>
                                 
                    </tr> 

  <?php  

if($gross_dr_deff  < 0){
$profit_dr_deff =$gross_dr_deff + $total_debit_expense_balance_deff ;
}
else if($gross_dr_deff  < 0 &&  $total_debit_expense_balance_deff   < 0){
$profit_dr_deff =$gross_dr_deff + $total_debit_expense_balance_deff ;
}
else if($gross_dr_deff  >= 0 &&  $total_debit_expense_balance_deff   < 0){
$profit_dr_deff = $total_debit_expense_balance_deff  +$gross_dr_deff ;
}
else{
$profit_dr_deff =$gross_dr_deff -$total_debit_expense_balance_deff ;
}


if($gross_cr_deff  < 0){
$profit_cr_deff =$gross_cr_deff + $total_credit_expense_balance_deff ;
}
else if($gross_cr_deff  < 0 &&  $total_credit_expense_balance_deff   < 0){
$profit_cr_deff =$gross_cr_deff + $total_credit_expense_balance_deff ;
}
else if($gross_cr_deff >= 0 &&  $total_credit_expense_balance_deff  < 0){
$profit_cr_deff = $total_credit_expense_balance_deff   +$gross_cr_deff ;
}
else{
$profit_cr_deff =$gross_cr_deff -$total_credit_expense_balance_deff ;
}

  if($profit_dr_deff  < 0){
$p=$profit_dr_deff +$profit_cr_deff;
}
else{
$p=$profit_cr_deff - $profit_dr_deff;
}

if($p  > 0){
$tax_dr_deff =$profit_dr_deff *0.3;
$tax_cr_deff =$profit_cr_deff *0.3;
}

$tax_pt_deff =abs($tax_cr_deff) -abs($tax_dr_deff) ;

?>

<tr>
                        <td>
                           <b>Profit Before Tax</b></td>
                            <td></td>
                                 <td><b><?php echo e(number_format(abs($profit_dr_deff) ,2)); ?></b></td>
                         <td ><b><?php echo e(number_format(abs($profit_cr_deff) ,2)); ?></b></td>
                                <td></td>
                               
                    </tr>
                     <tr>
                        <td>
                            <b>Tax</b></td>
                         <td></td>
                              <td><b><?php echo e(number_format(abs($tax_dr_deff) ,2)); ?></b></td>
                        <td><b><?php echo e(number_format(abs($tax_cr_deff),2)); ?></b></td>
                                     <td></td>                 
                    </tr>
                   
                     <tr>
                        <td colspan="2">
                           <b><?php echo e($key->account_name); ?> Total Balance</b></td>
                              <?php if($tax_pt_deff> 0): ?>
                               <td colspan="3"><b><?php echo e(number_format($tax_pt_deff ,2)); ?> Cr </b></td>
                           <?php elseif($tax_pt_deff == 0): ?>
                               <td colspan="3"><b><?php echo e(number_format($tax_pt_deff ,2)); ?>  </b></td>
                           <?php else: ?>
                               <td colspan="3"><b><?php echo e(number_format(abs($tax_pt_deff),2)); ?> Dr </b></td>
                           <?php endif; ?> 
                           
                        

                      
                    </tr>
                   


  <?php  
}


else{   
  ?>
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
                        $account = \App\Models\JournalEntry::where('account_id', $key->id)->where('branch_id',
                            session('branch_id'))->orderBy('date','asc')->get();
                            
                       $account1 = \App\Models\JournalEntry::where('account_id', $key->id)->where('branch_id',
                            session('branch_id'))->orderBy('date','asc')->get();
                        ?>  
                 <?php $__currentLoopData = $account; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                        <td ><?php echo e($a->date); ?></td>
                          <td><?php echo e(number_format($a->debit ,2)); ?></td>
                   <td ><?php echo e(number_format($a->credit ,2)); ?></td>
                     <td ><?php echo e($a->notes); ?></td>
                    </tr> 

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
            
    
 <?php
                   
                        $cr_modal = \App\Models\JournalEntry::where('account_id', $key->id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_modal = \App\Models\JournalEntry::where('account_id', $key->id)->where('branch_id',
                            session('branch_id'))->sum('debit');
                       
                        ?>  
                    <tr>     
                        <td>
                            <b>Total</b></td>
                           <td><b><?php echo e(number_format($dr_modal,2)); ?></b></td>
                            <td><b><?php echo e(number_format($cr_modal,2)); ?></b></td>
                             <td></td>
                             
                    </tr> 
  <tr>
                        <td >
                              <b><?php echo e($key->account_name); ?> Total Balance</b></td>                           
                            <?php if($key->account_type == 'Assets' || $key->account_type  == 'Expense'): ?>
     <td colspan="2"> 
<?php if($dr_modal-$cr_modal < 0): ?>
<b><?php echo e(number_format(abs($dr_modal-$cr_modal) ,2)); ?> Cr</b>
<?php elseif($dr_modal-$cr_modal == 0): ?>
<b><?php echo e(number_format($dr_modal-$cr_modal ,2)); ?> </b>
<?php else: ?>
<b><?php echo e(number_format($dr_modal-$cr_modal ,2)); ?> Dr</b>
<?php endif; ?> 
</td>                                
                           <?php else: ?>
                         <td colspan="2">
                    <?php if($cr_modal-$dr_modal > 0): ?>
<b><?php echo e(number_format(abs($dr_modal-$cr_modal) ,2)); ?> Cr</b>
<?php elseif($cr_modal-$dr_modal == 0): ?>
<b><?php echo e(number_format($dr_modal-$cr_modal ,2)); ?> </b>
<?php else: ?>
<b><?php echo e(number_format($cr_modal-$dr_modal ,2)); ?> Dr</b>
<?php endif; ?> 

                           <?php endif; ?> 
                       
   <td></td>
                    </tr> 
<?php
}
?>
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
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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
<script src="<?php echo e(url('assets/js/plugins/sweetalert/sweetalert.min.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/accounting/ledger.blade.php ENDPATH**/ ?>