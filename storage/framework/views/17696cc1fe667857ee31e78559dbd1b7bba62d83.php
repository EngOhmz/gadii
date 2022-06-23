<div class="tab-pane fade <?php if($type =='bank' || $type =='edit-bank'): ?> active show  <?php endif; ?>" id="tab2" role="tabpanel"
    aria-labelledby="tab1">
    <?php $id = 1; ?>
    <div class="card">
        <div class="card-header">
            <h4>Bank Details</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php if($type =='basic'): ?>active show <?php endif; ?>" id="home-tab2" data-toggle="tab"
                        href="#home2" role="tab" aria-controls="home" aria-selected="true">Details
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if($type =='edit-basic'): ?> active show <?php endif; ?>" id="profile-tab2"
                        data-toggle="tab" href="#profile2" role="tab" aria-controls="profile" aria-selected="false">Edit
                        Details</a>
                </li>

            </ul>
            <div class="tab-content tab-bordered" id="myTab3Content">
                <div class="tab-pane fade <?php if($type =='basic'): ?> active show <?php endif; ?>" id="home2" role="tabpanel"
                    aria-labelledby="home-tab2">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <table>
                                <tr>
                                    <td>Bank Name: </td>
                                    <td colspan="1"><?php echo e(!empty($bank_details) ? $bank_details->bank_name : ''); ?></td>
                                   
                                </tr>
                                <tr>
                                <td>Routing Number: </td>
                                    <td colspan="1"><?php echo e(!empty($bank_details) ? $bank_details->routing_number : ''); ?></td>
                                </tr>
                              
                            
                              

                               
                            </table>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <table>
                            <tr>
                                    <td>Account Number: </td>
                                    <td colspan="1"><?php echo e(!empty($bank_details) ? $bank_details->account_number : ''); ?></td>
                                    
                                </tr>
                                <tr>
                                <td>Account Name: </td>
                                    <td colspan="1"><?php echo e(!empty($bank_details) ? $bank_details->account_name : ''); ?></td>
                                </tr>
                               
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade <?php if($type =='edit-basic'): ?> active show <?php endif; ?>" id="profile2"
                    role="tabpanel" aria-labelledby="profile-tab2">

                    <div class="card">
                        <div class="card-header">
                           
                            <h5>Edit Details</h5>
                         
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 ">
                                   
                                   
                                    
                                    <?php echo e(Form::open(['route' => 'user_details.store'])); ?>

                                    <?php echo method_field('POST'); ?>

                                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                        <input type="hidden" value="bank" name="type">
                            <table>
                                <tr>
                                    <td>Bank Name: </td>
                                    <td colspan="1"><input type="text" value="<?php echo e(!empty($bank_details) ? $bank_details->bank_name : ''); ?>" name="bank_name" ></td>
                                </tr>
                                <tr>
                                    <td>Routing Number: </td>
                                    <td colspan="1"><input type="text" value="<?php echo e(!empty($bank_details) ? $bank_details->routing_number : ''); ?>" name="routing_number" ></td>
                                </tr>
                            
  
                            </table>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <table>
                                <tr>
                                    <td>Account Name: </td>
                                    <td colspan="1"><input type="text" value="<?php echo e(!empty($bank_details) ? $bank_details->account_name : ''); ?>" name="account_name" ></td>
                                </tr>
                              
                                <tr>
                                    <td>Account Number: </td>
                                    <td colspan="1"><input type="text" value="<?php echo e(!empty($bank_details) ? $bank_details->account_number : ''); ?>" name="account_number" ></td>
                                </tr>
                                
                            
                            </table>
                        </div>
                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-offset-2 col-lg-12">
                                            <?php if($type =='edit-preparation'): ?>
                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                data-toggle="modal" data-target="#myModal" type="submit">Update</button>
                                            <?php else: ?>
                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                type="submit">Save</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php echo Form::close(); ?>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/user_details/tabs/tab2.blade.php ENDPATH**/ ?>