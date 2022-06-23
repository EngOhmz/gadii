<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

                                <?php if(!empty(Session::get('success'))): ?>

                                <div class="alert alert-success alert-dismissible show fade" id="success-alert">
                                   <div class="alert-body">
                                  
                                            <?php echo e(Session::get('success')); ?>

                                    </div>
                                   </div>


                                


                                <?php elseif(!empty(Session::get('error'))): ?>
                            
                                   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


                                   <div class="alert alert-danger" id="success-alert">
                                              <center>Oooops!!  <?php echo e(Session::get('error')); ?> </center>
                                   </div>


                                 <?php endif; ?>
                                 <script>
                                $(".alert").delay(6000).slideUp(200, function() {
                                $(this).alert(close);
                                });
                                </script><?php /**PATH /home/admin/web/app.ema.co.tz/public_html/resources/views/layouts/alerts/message.blade.php ENDPATH**/ ?>