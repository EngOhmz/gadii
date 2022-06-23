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
                    <?php echo Form::date('start_date',$start_date, array('class' => 'form-control date-picker', 'placeholder'=>"First Date",'required'=>'required')); ?>

                </div>
                   <div class="col-md-4">
                    <label class="">End Date</label>
                    <?php echo Form::date('second_date',$second_date, array('class' => 'form-control date-picker', 'placeholder'=>"Second Date" ,'required' => 'required')); ?>

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
 <?php if($account_code->account_codes != 2206): ?>
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

                        $cr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr1 = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->where('branch_id',
                            session('branch_id'))->sum('debit'); 

                        $cr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('credit');
                        $dr = \App\Models\JournalEntry::where('account_id', $account_code->account_id)->whereBetween('date',
                            [$start_date, $second_date])->where('branch_id',
                            session('branch_id'))->sum('debit');
                            



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
<?php endif; ?>  
   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>   
 <?php endif; ?>             
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 
                    </tbody>
<!--
 <tfoot>
                    <tr>
                        <td colspan="3" align><b><?php echo e(trans_choice('general.total',1)); ?></b></td>
                        <td><?php echo e(number_format($debit_total,2)); ?></td>
                        <td><?php echo e(number_format($credit_total,2)); ?></td>
                        <td></td>
                    </tr>
                    </tfoot>
                  
 -->                   
                    
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
                       
  <!-- Modal -->
  <div class="modal inmodal " id="view<?php echo e($account_code->account_id); ?>"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog"><div class="modal-dialog" role="document">
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
                       <td ><?php echo e($a->name); ?></td>
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/app.ema.co.tz/public_html/resources/views/financial_report/trial_balance.blade.php ENDPATH**/ ?>