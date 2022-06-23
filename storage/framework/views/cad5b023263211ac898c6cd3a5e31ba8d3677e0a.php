<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Income Statement </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Income Statement Report
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade <?php if(empty($id)): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
        <div class="panel-heading">
            <h6 class="panel-title">
                Income Statement
               <?php if(!empty($start_date)): ?>
                    for the period: <b><?php echo e($start_date); ?> to <?php echo e($second_date); ?></b>
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
                     <input  name="second_date" type="date" class="form-control date-picker" required value="<?php
                if (!empty($second_date)) {
                    echo $second_date;
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
 <?php if(!empty($start_date)): ?>
        <div class="panel panel-white col-lg-12">
            <div class="panel-body table-responsive no-padding">

                  <table id="data-table" class="table table-striped ">
                    <thead>
                    <tr>
                        <th colspan="5">STATEMENT OF COMPRENHESIVE FOR THE PERIOD</th>
                         
                    </tr>
                    </thead>
                      <tbody>
                    <tr>
                        <td colspan="4" style="text-align: left"><b>Income</b></td>
                    </tr>
                                 <?php
                     $c=0;     
                    $sales_balance  = 0;
                     $sales_balance1  = 0;
                    $total_incomes  = 0;
                    $total_incomes1 = 0;
                     $total_other_incomes  = 0;
                    $total_other_incomes1 = 0;
                    $cost_balance  = 0;
                    $cost_balance1  = 0;
                    $total_cost  = 0;
                    $total_cost1  = 0;
                    $expense_balance  = 0;
                    $expense_balance1 = 0;
                    $total_expense  = 0;
                    $total_expense1  = 0;
                    $gross  = 0;
                    $gross1  = 0;
                   $profit=0;
                   $profit1=0;
                  $tax=0;
                  $tax1=0;
                $net_profit=0;
                $net_profit1=0;
?>            
     
     <?php $__currentLoopData = $income; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php $__currentLoopData = $account_class->groupAccount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
<?php $__currentLoopData = $group->accountCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
  <td><?php echo e($account_code->account_name); ?></td>
<td><a href="#view<?php echo e($account_code->account_id); ?>" data-toggle="modal""><?php echo e($account_code->account_codes); ?></a>
 
</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                              [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            
                        
                            
                            
                        //   $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                        //     session('branch_id'))->sum('credit');
                        // $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                        //     session('branch_id'))->sum('debit');
                            
                        //   $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                        //     session('branch_id'))->sum('credit');
                        // $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                        //     session('branch_id'))->sum('debit');

                       $income_balance=$dr- $cr;
                          $total_incomes+=$income_balance ;
                          

                        ?>                          
                             <td><?php echo e(number_format(abs($income_balance),2)); ?></td>
                           
                             

                        </tr>
                                                                
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 
           <tr>
                        <td >
                            <b>Total Income</b></td>
                           <td colspan="5" style="text-align: right"><b><?php echo e(number_format(abs($total_incomes),2)); ?></b></td>
                           
                         
                    </tr> 
                    
            
  <!--   
 <tr>
                        <td colspan="4" style="text-align: left"><b>Financial Cost</b></td>
                    </tr>
  <?php $__currentLoopData = $cost; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php $__currentLoopData = $account_class->groupAccount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
  <?php if($group->group_id == 6180): ?>
<?php $__currentLoopData = $group->accountCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
 <td><?php echo e($account_code->account_name); ?></td>
<td><a href="#view<?php echo e($account_code->account_id); ?>" data-toggle="modal""><?php echo e($account_code->account_codes); ?></a>

</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date,$second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');


                            
                       $cost_balance=$dr- $cr;
                        
                          $total_cost+=$cost_balance ;
                        ?>                        
                             <td><?php echo e(number_format(abs($cost_balance),2)); ?></td>
                            

                        </tr>
                                                                
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
 <?php endif; ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

   
           <tr>
                        <td >
                            <b>Total Financial Cost</b></td>
                          <td colspan="5" style="text-align: right"><b><?php echo e(number_format(abs($total_cost),2)); ?></b></td>
                      
                    </tr> 
      <tr>
                        <td >
                            <b>Gross Profit</b></td>


                     
                <td colspan="5" style="text-align: right"><b><?php echo e(number_format($gross,2)); ?></b></td>
                    </tr> 
                 
  -->

                     
                       <?php

if($total_other_incomes < 0){
$total_o=$total_other_incomes * -1;
}
else if($total_other_incomes >= 0){
$total_o=$total_other_incomes ;
}




if($total_incomes < 0){
$total_s=$total_incomes * -1;
$gross=$total_s+$total_o-$total_cost;
}
else if($total_incomes >= 0){
$gross=$total_incomes+$total_o-$total_cost;
}


?>
                    
                       <tr>
                        <td colspan="7" style="text-align: left"><b>Expenses</b></td>
                    </tr>



                  <?php $__currentLoopData = $expense; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php $__currentLoopData = $account_class->groupAccount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>        
    <?php if($group->group_id != 6180): ?>
<?php $__currentLoopData = $group->accountCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
 <td><?php echo e($account_code->account_name); ?></td>
<td><a href="#view<?php echo e($account_code->account_id); ?>" data-toggle="modal""><?php echo e($account_code->account_codes); ?></a>
  
</td>
 <?php
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            
                        

                       $expense_balance=$dr- $cr;
                          $total_expense+=$expense_balance ;
                          
                        ?>                           
                             <td><?php echo e(number_format(abs($expense_balance),2)); ?></td>

                        </tr>
                                                               
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
 <?php endif; ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

   
           <tr>
                        <td >
                            <b>Total Expenses</b></td>
                           <td colspan="5" style="text-align: right"><b><?php echo e(number_format($total_expense,2)); ?></b></td>
                    </tr> 
                    </tbody>
                    <tfoot>
                    <tr>
                        <td>
                           <b>Profit Before Tax</b></td>
                        <?php

if($gross < 0){
$profit=$gross+$total_expense;
}
else if($gross < 0 && $total_expense < 0){
$profit=$gross+$total_expense;
}
else if($gross >= 0 && $total_expense < 0){
$profit=$total_expense +$gross;
}
else{
$profit=$gross-$total_expense;
}


?>
                         <td colspan="5" style="text-align: right"><b><?php echo e(number_format($profit,2)); ?></b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>Tax</b></td>
                               <?php
if($profit > 0){
$tax=$profit*0.3;
}


?>
                        <td colspan="5" style="text-align: right"><b><?php echo e(number_format($tax,2)); ?></b></td>
                    </tr>
                     <tr>
                        <td>
                            <b>Net Profit</b></td>
                        <td colspan="5" style="text-align: right"><b><?php echo e(number_format($profit-$tax,2)); ?></b></td>
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
<?php $__currentLoopData = $income; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php $__currentLoopData = $account_class->groupAccount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                             
<?php $__currentLoopData = $group->accountCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 

                       
  <!-- Modal -->
  <div class="modal inmodal "id="view<?php echo e($account_code->account_id); ?>"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> <?php echo e($account_code->account_codes); ?> - <?php echo e($account_code->account_name); ?><h5>
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
                            [$start_date, $second_date])->where('branch_id',
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
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            

                        ?>  
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b><?php echo e(number_format($dr,2)); ?></b></td>
                            <td><b><?php echo e(number_format($cr,2)); ?></b></td>
                           <td></td>
                            
                            
                    </tr> 
  <tr>
                        <td >
                          <b><?php echo e($account_code->account_name); ?> Total Balance</b></td>
                           <td colspan="3"><b><?php echo e(number_format($cr-$dr,2)); ?></b></td>

                         

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
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>              
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<!-- //sehemu ya equity ==================================================================== -->
  <?php $__currentLoopData = $cost; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php $__currentLoopData = $account_class->groupAccount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
 <?php if($group->group_id == 6180): ?>                              
<?php $__currentLoopData = $group->accountCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 

                       
  <!-- Modal -->
<div class="modal inmodal "id="view<?php echo e($account_code->account_id); ?>"  tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> <?php echo e($account_code->account_codes); ?> - <?php echo e($account_code->account_name); ?><h5>
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
                            [$start_date, $second_date])->where('branch_id',
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
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b><?php echo e(number_format($dr,2)); ?></b></td>
                            <td><b><?php echo e(number_format($cr,2)); ?></b></td>
 <td></td>
                    </tr> 
  <tr>
                        <td >
                               <b><?php echo e($account_code->account_name); ?> Total Balance</b></td>
                           <td colspan="3"><b><?php echo e(number_format($dr-$cr,2)); ?></b></td>

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
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>              
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<!-- sehemu ya liabilitty==================================================== -->
                   
 <?php $__currentLoopData = $expense; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php $__currentLoopData = $account_class->groupAccount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                             
<?php $__currentLoopData = $group->accountCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 

                      
  <!-- Modal -->
<div class="modal inmodal "id="view<?php echo e($account_code->account_id); ?>"  tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg"><div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> <?php echo e($account_code->account_codes); ?> - <?php echo e($account_code->account_name); ?><h5>
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
                            [$start_date, $second_date])->where('branch_id',
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
                   
                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b><?php echo e(number_format($dr,2)); ?></b></td>
                            <td><b><?php echo e(number_format($cr,2)); ?></b></td>
                           <td></td>
                    </tr> 
  <tr>
                        <td >
                            <b><?php echo e($account_code->account_name); ?> Total Balance</b></td>
                           <td colspan="3"><b><?php echo e(number_format($dr-$cr,2)); ?></b></td>

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
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>              
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/financial_report/income_statement.blade.php ENDPATH**/ ?>