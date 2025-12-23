<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="formModal" >Student Invoice Details</h2>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
       
<div class="modal-body" id="printTable">
                    <div class="">                            
                        <p class="form-control-static" style="text-align:center;"><strong>Full Name  : </strong><?php echo $student->fname; ?>&nbsp<?php echo $student->mname; ?>&nbsp<?php echo $student->lname; ?></p>
                    </div>
                    <div class="">
                            <p class="form-control-static" style="text-align:center;"><strong>Registration Date  : </strong><?php echo $student->yearStudy; ?></p>    
                    </div>
                    <div class="">
                            <p class="form-control-static" style="text-align:center;"><strong>Level Of School : </strong><?php echo $student->level; ?></p>    
                    </div>
                    <div class="">
                            <p class="form-control-static" style="text-align:center;"><strong>Class/standard/form level  : </strong><?php echo $student->class; ?></p>    
                    </div>
 <hr><br>                   
<div class="row">
<div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-xs-12">
    <div class="panel panel-custom">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h5> SCHOOL FEES REQUIRED TO PAY</h5><br>
                        </div>
                    </div>

                    <div class="panel-body">

                    <?php
                        $i = 0;

                        if (!empty($student_infos[0])):foreach ($student_infos as $v_student_info):
                            ?>
                            <div class="">
                                <p class="form-control-static"><strong><?php echo $v_student_info->feeType; ?> : </strong><?php echo number_format($v_student_info->price) ?></p>
                                       
                            </div>&nbsp;&nbsp;&nbsp;&nbsp;
                            <div class="">
                                <p class="form-control-static"><strong> SCHOOL FEES PAID </strong><?php echo number_format($v_student_info->paid) ?></p>
                                       
                            </div>
                            <?php $i += $v_student_info->price; ?>
                        <?php endforeach; ?>
                        <?php else : ?>
                             <p class="form-control-static"><strong> NO DATA FOUND</strong></p>
                        <?php endif; ?>

                    </div>



    </div>

</div>






               
            </div><!-- ********************Allowance End ******************-->

<!-- ********************Deduction End  ******************-->

         

         
           

</div>
        </div>
        <div class="modal-footer">
        <a class="btn btn-warning" href="#null"  onclick="printContent('printTable')">Print</a>
        </div>
        <div class="modal-footer bg-whitesmoke br">
         
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      
    </div>
</div>

<script type="text/javascript">

    function printContent(id){
        str=document.getElementById(id).innerHTML
        newwin=window.open('','printwin','left=100,top=100,width=400,height=400')
        newwin.document.write('<HTML><HEAD> <link rel=\"stylesheet\" type=\"text/css\" href=\"CSS/style.css\"/>')
        newwin.document.write('<TITLE>Print Page</TITLE>\n')
        newwin.document.write('<script>\n')
        newwin.document.write('function chkstate(){\n')
        newwin.document.write('if(document.readyState=="complete"){\n')
        newwin.document.write('window.close()\n')
        newwin.document.write('}\n')
        newwin.document.write('else{\n')
        newwin.document.write('setTimeout("chkstate()",2000)\n')
        newwin.document.write('}\n')
        newwin.document.write('}\n')
        newwin.document.write('function print_win(){\n')
        newwin.document.write('window.print();\n')
        newwin.document.write('chkstate();\n')
        newwin.document.write('}\n')
        newwin.document.write('<\/script>\n')
        newwin.document.write('</HEAD>\n')
        newwin.document.write('<BODY onload="print_win()">\n')
        newwin.document.write(str)
        newwin.document.write('</BODY>\n')
        newwin.document.write('</HTML>\n')
        newwin.document.close()
    }

</script>