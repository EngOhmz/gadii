    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">
  
                New Salary Template
                      
</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
              <form id="addClientForm" method="post" action="javascript:void(0)">
                @csrf
        <div class="modal-body">

    <div class="row">
                                                    <div
                                                        class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 offset-lg-3">
                                                        <div class="card">

                                                            <div class="card-body">
                                                                <div class="">
                                                                    <label class="control-label">Salary
                                                                        Grade<span class="required">
                                                                            *</span></label> </label>
                                                                    <input type="text" required name="salary_grade" value="" class="form-control" required
                                                                        placeholder="Enter Salary Grade">
                                                                </div>
                                                                <div class="">
                                                                    <label class="control-label">Basic
                                                                        Salary <span class="required">
                                                                            *</span>
                                                                    </label>
                                                                    <input type="text" data-parsley-type="number"
                                                                        name="basic_salary" required value="" class="salary form-control basic_salary"
                                                                        required placeholder="Basic Salary">
                                                                </div>
                                                               
                                                                  <br>

                                                                <input name="checked" id="inc"  type="checkbox"  value="1" class="inc" checked="checked" > Include NSSF
                                                                 &nbsp&nbsp <input name="heslb_check" id="heslb_inc"  type="checkbox"  value="1" class="heslb_inc" checked="checked" > Include HESLB
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="card">
                                                            <div class="card-header header-elements-sm-inline">
                                                                <h5>Allowance</h5>
                                                                 <div class="header-elements">  
                                                                <strong><a href="javascript:void(0);" id="add_more" class="addCF"><i class="fa fa-plus"></i>&nbsp;Add More</a></strong>
                                                            </div></div>
                                                            <div class="card-body">
                                                                
                                                                
                                                            
                                                                <div id="add_new" class="add_new">
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="card">
                                                           <div class="card-header header-elements-sm-inline">
                                                                <h5>Deductions</h5>
                                                                 <div class="header-elements">  
                                                                
                                                                 <strong><a href="javascript:void(0);"
                                                                            id="add_more_deduc" class="addCF2"><i
                                                                                class="fa fa-plus"></i>&nbsp;Add
                                                                            More</a></strong>
                                                            </div></div>
                                                            <div class="card-body">
                                                                
                                                                <div class="">
                                                                    <label class="control-label">NSSF
                                                                    </label>
                                                                    <input type="text" data-parsley-type="number"
                                                                        disabled class="form-control NSSF">
                                                                    <input type="hidden" data-parsley-type="number"
                                                                        name="provident_fund" id="NSSF"
                                                                        class="deduction form-control NSSF">
                                                                </div>
                                                                <div class="">
                                                                    <label class="control-label">PAYE 
                                                                    </label>
                                                                    <input type="text" data-parsley-type="number"
                                                                        disabled class="form-control PAYE">
                                                                    <input type="hidden" data-parsley-type="number"
                                                                        name="tax_deduction"
                                                                        class="deduction form-control PAYE">
                                                                </div>
                                                                    <div class="">
                                            <label class="control-label">HESLB </label>
                                            <input type="text" data-parsley-type="number" disabled
                                                   class="form-control HESLB">
                                            <input type="hidden" data-parsley-type="number" name="heslb" id="heslb"
                                                   class="deduction form-control HESLB">
                                        </div>
                                                               
<br>
                                                                <div id="add_new_deduc" class="add_new_deduc">
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div
                                                        class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 offset-lg-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <strong>Total Salary Details</strong>
                                                            </div>
                                                            <div class="card-body">
                                                                <table class="table table-bordered custom-table">
                                                                    <tr>
                                                                        <!-- Sub total -->
                                                                        <th class="col-sm-6 vertical-td">
                                                                            <strong>Gross
                                                                                Salary
                                                                                :</strong>
                                                                        </th>
                                                                        <td class="">
                                                                            <input type="text" name="" disabled value="" id="total"
                                                                                class="form-control total">
                                                                        </td>
                                                                    </tr> <!-- / Sub total -->
                                                                    <tr>
                                                                        <!-- Total tax -->
                                                                        <th class="col-sm-6 vertical-td">
                                                                            <strong>Total
                                                                                Deduction
                                                                                :</strong>
                                                                        </th>
                                                                        <td class="">
                                                                            <input type="text" name="" disabled value="" id="deduc"
                                                                                class="form-control deduc">
                                                                        </td>
                                                                    </tr><!-- / Total tax -->
                                                                    <tr>
                                                                        <!-- Grand Total -->
                                                                        <th class="col-sm-6 vertical-td"><strong>Net
                                                                                Salary
                                                                                :</strong>
                                                                        </th>
                                                                        <td class="">
                                                                            <input type="text" name="" disabled required
                                                                                value="" id="net_salary"
                                                                                class="form-control net_salary">
                                                                        </td>
                                                                    </tr><!-- Grand Total -->
                                                                </table>

                                                              <input type="hidden" id="category" value="{{$id}}">

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- ****************** Total Salary Details End  *******************-->

                                                </div>

     

        

        </div>
        <div class="modal-footer ">
             <button class="btn btn-primary"  type="submit" id="save" onclick="saveTemplate(this)"><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
        </form>
    </div>


@yield('scripts')

<script type="text/javascript">
$(document).ready(function() {
    var maxAppend = 0;
    $(".addCF").click(function() {
        var add_new = $(
            '<div class="row">\n\
    <div class="col-sm-12"><input type="text" name="allowance_label[]" style="margin:5px 0px;height: 28px;width: 56%;" class="form-control"  placeholder="Enter Allowance label" required ></div>\n\
<div class="col-sm-9"><input  type="text" data-parsley-type="number" name="allowance_value[]" placeholder="Enter Allowance Value" required  value=""  class="salary form-control"></div>\n\
<div class="col-sm-3"><strong><a href="javascript:void(0);" class="remCF"><i class="icon-cross2"></i>&nbsp;Remove</a></strong></div></div>'
        );
        maxAppend++;
        console.log(1);
        $(".add_new").append(add_new);
    });

    $(".add_new").on('click', '.remCF', function() {
        $(this).parent().parent().parent().remove();
    });
});
</script>
<script type="text/javascript">
 $(document).ready(function () {
        var maxAppend = 0;
        $(".addCF2").click(function () {
            var add_new = $('<div class="row">\n\
    <div class="col-sm-12"><input type="text" name="deduction_label[]" style="margin:5px 0px;height: 28px;width: 56%;" class="form-control" placeholder="Enter Deductions Label" required></div>\n\
<div class="col-sm-9"><input  type="text" data-parsley-type="number" name="deduction_value[]" placeholder="Enter Deductions Value" required  value=""  class="deduction form-control"></div>\n\
<div class="col-sm-3"><strong><a href="javascript:void(0);" class="remCF_deduc"><i class="icon-cross2"></i>&nbsp;Remove</a></strong></div></div>');
            maxAppend++;
            $(".add_new_deduc").append(add_new);

        });

        $(".add_new_deduc").on('click', '.remCF_deduc', function () {
            $(this).parent().parent().parent().remove();
        });
    });
</script>

<script type="text/javascript">
 $(document).on("change", function () {
        var sum = 0;
        var basic_salary= 0;
         var provident_fund= 0;
         var heslb= 0;
        var nssf= 0;
        var deduc = 0;

        $(".salary").each(function () {
            sum += +$(this).val();
         console.log(sum);
        });
         $(".basic_salary").each(function () {
            basic_salary += +$(this).val();
        });
        
          $(".heslb_inc").each(function () {
            if($(this).is(':checked')){ 
         var heslb = ((basic_salary * 15 / 100 )).toFixed(2);
         $(".HESLB").val(heslb)
            }
            else{
                var heslb = (0).toFixed(2);    
                $(".HESLB").val(heslb);
            }
        });
        
        
         $(".inc").each(function () {
            if($(this).is(':checked')){ 
         var nssf = ((sum * 10 / 100 )).toFixed(2);
         $(".NSSF").val(nssf);
            }
            else{
                var nssf = 0;   
                $(".NSSF").val(nssf);
            }
        });
        
        
         $("#NSSF").each(function () {
            provident_fund += +$(this).val();
            
        });
              
        

      var sub_total=sum- provident_fund ;


        var total_tax = tax_deduction_rule(sub_total);

        $(".PAYE").val(total_tax);

    

        $(".deduction").each(function () {
            deduc += +$(this).val();
        });
        
        var ctc = $("#ctc").val();
        $(".total").val(sum.toFixed(2));

        $(".deduc").val(deduc.toFixed(2));
        var net_salary = 0;
        net_salary = (sum - deduc).toFixed(2);
        $(".net_salary").val(net_salary);
    });

    function tax_deduction_rule(tax) {
        if (tax < 270000) {
            return "0";
        }
        else if (tax >= 270000 && tax < 520000) {
            return (0.08 * (tax - 270000)).toFixed(2);
        }
        else if (tax >= 520000 && tax < 760000) {
            var tr = (tax - 520000);
            var ttotal = ( tr * 20 / 100 );
            return ((20000 + ttotal)).toFixed(2);
        }
        else if (tax >= 760000 && tax < 1000000) {
            var tr = (tax - 760000);
            var ttotal = ( tr * 25 / 100 );
            return ((68000 + ttotal)).toFixed(2);
        } else if (tax >= 1000000) {
            var tr = (tax - 1000000);
            var ttotal = ( tr * 30 / 100 );
            return ((128000 + ttotal)).toFixed(2);
        }
    }


</script>
