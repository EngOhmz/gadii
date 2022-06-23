<?php $__env->startSection('content'); ?>
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
                                <a class="nav-link <?php if(empty($id)): ?> active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Trial Balance  Report
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade <?php if(empty($id)): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
        <div class="panel-heading">
            <h6 class="panel-title">
              Trial Balance 
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
  <!-- /.box -->
    <?php if(!empty($start_date)): ?>
<div class="panel panel-white col-lg-12">
            <div class="panel-body table-responsive no-padding">

            <table id="data-table" class="table table-striped ">
                    <thead>
                    <tr >
                         <th colspan="7"><center>TRIAL BALANCE FOR THE PERIOD BETWEEN <?php echo e($start_date); ?> To <?php echo e($second_date); ?>   </center></th>
                       
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
     
     <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php    $c++ ;  ?>
                          <tr>
                        <td colspan="5" style="text-align: center"><b><?php echo e($c); ?> . <?php echo e($account_class->class_name); ?></b></td>
                        <?php if($c == 1){ ?>
                           
                           
                    <?php    } ?>
                    </tr>

   <?php                              

$d=0;
?>
               
  <?php $__currentLoopData = $account_class->groupAccount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <?php if($group->name != 'Retained Earnings/Loss'): ?>
                             <?php $d++ ; 
                      //  $values = explode(",",  $account_group->holidays);
?>
                                                      
                         <tr>
                   <td><?php echo e($d); ?> .</td>
                   ​<td><?php echo e($group->name); ?></td>                      
                  <td colspan="1"></td> 
                  <?php if($c == 1 && $d == 1 ){ ?>
                  <td colspan="">Dr</td>
                  <td colspan="">Cr</td>
                  <?php    }else{ ?>
                   <td colspan="4"></td>
                
                  <?php    } ?>
                   </tr>
    
<?php $__currentLoopData = $group->accountCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <?php if($account_code->account_name != 'Deffered Tax' && $account_code->account_name != 'Value Added Tax (VAT)'): ?>
<tr>
 <td></td>
 <td><?php echo e($account_code->account_name); ?></td>
 <td><a href="#view<?php echo e($account_code->account_id); ?>" data-toggle="modal""><?php echo e($account_code->account_codes); ?></a>

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

                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->sum('debit'); 

                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('debit');
                            

                          $credit_total = $credit_total + $cr  ;
                        $debit_total = $debit_total + $dr ;

                             //$balance3 = 0;
                         if($account_code->account_codes == 2206){
                      ?>
                         
                        

                  <?php

                         }

                      else{

    ?>
                         <?php if($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense'): ?>
                                        <td><?php echo e(number_format($dr-$cr ,2)); ?>  </td>
                                 <td><?php echo e(number_format(0 ,2)); ?> </td>
                           <?php else: ?>
                                <td><?php echo e(number_format(0 ,2)); ?> </td>
                            <td><?php echo e(number_format($cr-$dr ,2)); ?>  </td> 
                           <?php endif; ?> 
                           
                          
                         
<?php
                         } 
                        ?>
                        
                           

                           
                        
</tr>

<?php elseif($account_code->account_name == 'Value Added Tax (VAT)'): ?>
<tr>
 <td></td>
 <td><?php echo e($account_code->account_name); ?></td>
 <td><a href="#vat<?php echo e($account_code->account_id); ?>" data-toggle="modal""><?php echo e($account_code->account_codes); ?></a>

</td>
<?php
                        $cr_in = 0;
                        $dr_in = 0;                   
                        $cr_out  = 0;
                        $dr_out  = 0;
                        $total_vat=0;
                           $total_out=0;
                             $total_in=0;
                             
                      
                        $vat_in= \App\Models\AccountCodes::where('account_name', 'VAT IN')->first();
                        $vat_out= \App\Models\AccountCodes::where('account_name', 'VAT OUT')->first();

                        $cr_in = \App\Models\JournalEntry::where('account_id', $vat_in->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id', $vat_in->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('debit'); 

                        $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id', $vat_out->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('debit');
                            

                         $total_in= $dr_in- $cr_in ;
                          $total_out = $cr_out - $dr_out ;
                         if ($total_in - $total_out < 0){
                        $total_vat_cr=($total_in -  $total_out) * -1;
                       }
                       else{
                         $total_vat_dr=$total_in -  $total_out;
                         }
  ?>
                          
                         <?php if($total_in - $total_out < 0): ?>
                                    <td><?php echo e(number_format(0 ,2)); ?> </td>
                                        <td><?php echo e(number_format(abs(($total_in - $total_out) *-1 ),2)); ?>  </td>
                                
                           <?php else: ?>
                                  <td><?php echo e(number_format(abs($total_in - $total_out ),2)); ?>  </td>
                                <td><?php echo e(number_format(0 ,2)); ?> </td>
                           <?php endif; ?> 
                           
                          
                              

                           
                        
</tr>

<?php endif; ?>  
   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>   
 <?php endif; ?>             
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 
                    </tbody>

 <tfoot>
                    <tr>
                           <td></td>
                        <td><b>Total</b></td>
                          <td></td>
                        <td><b><?php echo e(number_format($debit_total +  $total_vat_dr,2)); ?></b></td>
                        <td><b><?php echo e(number_format($credit_total +  $total_vat_cr ,2)); ?></b></td>
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
     <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php $__currentLoopData = $account_class->groupAccount; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php $__currentLoopData = $group->accountCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   <?php if($account_code->account_name != 'Value Added Tax (VAT)'): ?>                   
  <!-- Modal -->
  <div class="modal inmodal " id="view<?php echo e($account_code->account_id); ?>"  tabindex="-1" role="dialog" aria-hidden="true">
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
                            
                       $account1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
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
                   
                        $cr_modal = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_modal = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            
                         $cr_modal1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr_modal1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');

                        ?>  
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b><?php echo e(number_format($dr_modal,2)); ?></b></td>
                            <td><b><?php echo e(number_format($cr_modal,2)); ?></b></td>
                             <td></td>
                             
                    </tr> 
  <tr>
                        <td >
                              <b><?php echo e($account_code->account_name); ?> Total Balance</b></td>                           
                            <?php if($account_class->class_type == 'Assets' || $account_class->class_type == 'Expense'): ?>
     <td colspan="3"><b><?php echo e(number_format($dr_modal-$cr_modal ,2)); ?> </b></td>                                
                           <?php else: ?>
                         <td colspan="3"><b><?php echo e(number_format($cr_modal-$dr_modal ,2)); ?> </b></td>
                           <?php endif; ?> 
                       

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
<?php else: ?>
  <!-- Modal -->
  <div class="modal inmodal " id="vat<?php echo e($account_code->account_id); ?>"  tabindex="-1" role="dialog" aria-hidden="true">
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
                            <table class="table table-bordered table-striped"><h4>VAT IN </h4>
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
                         $vat_in = \App\Models\AccountCodes::where('account_name', 'VAT IN')->first();
                        $account = \App\Models\JournalEntry::where('account_id', $vat_in->account_id)->whereBetween('date',
                            [$start_date, $second_date])->orderBy('date','asc')->get();
                            
                       
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
                   
                        $cr_in = \App\Models\JournalEntry::where('account_id',  $vat_in->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id',  $vat_in->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('debit');
                            
                       $vat_in= $dr_in- $cr_in;


                        ?>  
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b><?php echo e(number_format($dr_in,2)); ?></b></td>
                            <td><b><?php echo e(number_format($cr_in,2)); ?></b></td>
                             <td></td>
                             
                    </tr> 
 
                        </tbody>
                            </table>


                            <table class="table table-bordered table-striped"><h4>VAT OUT </h4>
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
                         $vat_out = \App\Models\AccountCodes::where('account_name', 'VAT OUT')->first();
                        $account_out = \App\Models\JournalEntry::where('account_id', $vat_out->account_id)->whereBetween('date',
                            [$start_date, $second_date])->orderBy('date','asc')->get();
                            
                       
                        ?>  
                 <?php $__currentLoopData = $account_out; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a_out): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                        <td ><?php echo e($a_out->date); ?></td>
                          <td><?php echo e(number_format($a_out->debit ,2)); ?></td>
                   <td ><?php echo e(number_format($a_out->credit ,2)); ?></td>
                       <td ><?php echo e($a_out->notes); ?></td>
                    </tr> 

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
            
    
 <?php
                   
                        $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->account_id)->whereBetween('date',
                            [$start_date, $second_date])->sum('debit');

                            $vat_out=$cr_out-$dr_out;


                        ?>  
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b><?php echo e(number_format($dr_out,2)); ?></b></td>
                            <td><b><?php echo e(number_format($cr_out,2)); ?></b></td>
                             <td></td>
                             
                    </tr> 

                        </tbody>
                            </table>


                            <table class="table table-bordered table-striped">

 <tbody>   

  <tr>
                        <td >
                              <b><?php echo e($account_code->account_name); ?> Total Balance</b></td>    
                                                          <?php if($total_in - $total_out < 0): ?>
                                    <td> </td>
                                        <td><b><?php echo e(number_format(abs($vat_in - $vat_out) ,2)); ?> </b>  </td>
                                
                           <?php else: ?>
                                  <td><b><?php echo e(number_format(abs($vat_in - $vat_out) ,2)); ?> </b> </td>
                                <td> </td>
                           <?php endif; ?> 
                       

                       

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
<?php endif; ?>

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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/financial_report/trial_balance.blade.php ENDPATH**/ ?>