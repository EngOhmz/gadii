<div class="modal-dialog modal-lg" role="document">
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
                                                               

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5>Allowance</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                
                                                                <div class="">
                                                                    <label class="control-label">House Rent
                                                                        Allowance
                                                                    </label>
                                                                    <input type="text" data-parsley-type="number"
                                                                        name="house_rent_allowance" value=""
                                                                        class="salary form-control">
                                                                </div>
                                                                <div class="">
                                                                    <label class="control-label">Medical Allowance
                                                                    </label>
                                                                    <input type="text" data-parsley-type="number"
                                                                        name="medical_allowance" value=""
                                                                        class="salary form-control">
                                                                </div>
                                                            
                                                                <br><div id="add_new">
                                                                </div>
                                                                <div class="margin">
                                                                    <strong><a href="javascript:void(0);" id="add_more"
                                                                            class="addCF "><i
                                                                                class="fa fa-plus"></i>&nbsp;Add
                                                                            More</a></strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5>Deductions</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                
                                                                <div class="">
                                                                    <label class="control-label">Social Security
                                                                        (NSSF) <span class="required">
                                                                            *</span>
                                                                    </label>
                                                                    <input type="text" data-parsley-type="number"
                                                                        disabled class="form-control NSSF">
                                                                    <input type="hidden" data-parsley-type="number"
                                                                        name="provident_fund"
                                                                        class="deduction form-control NSSF">
                                                                </div>
                                                                <div class="">
                                                                    <label class="control-label">PAYE <span class="required">
                                                                            *</span>
                                                                    </label>
                                                                    <input type="text" data-parsley-type="number"
                                                                        disabled class="form-control PAYE">
                                                                    <input type="hidden" data-parsley-type="number"
                                                                        name="tax_deduction"
                                                                        class="deduction form-control PAYE">
                                                                </div>
                                                                    <div class="">
                                            <label class="control-label">HESLB </label>
                                            <input type="text" data-parsley-type="number" 
                                                   class="deduction form-control HESLB">
                                            <input type="hidden" data-parsley-type="number" name="heslb"
                                                   class="deduction form-control HESLB ">
                                        </div>
                                                               
<br>
                                                                <div id="add_new_deduc">
                                                                </div>
                                                                <div class="margin">
                                                                    <strong><a href="javascript:void(0);"
                                                                            id="add_more_deduc" class="addCF "><i
                                                                                class="fa fa-plus"></i>&nbsp;Add
                                                                            More</a></strong>
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
                                                                        <th class="col-sm-8 vertical-td">
                                                                            <strong>Gross
                                                                                Salary
                                                                                :</strong>
                                                                        </th>
                                                                        <td class="">
                                                                            <input type="text" name="" disabled value="" id="total"
                                                                                class="form-control">
                                                                        </td>
                                                                    </tr> <!-- / Sub total -->
                                                                    <tr>
                                                                        <!-- Total tax -->
                                                                        <th class="col-sm-8 vertical-td">
                                                                            <strong>Total
                                                                                Deduction
                                                                                :</strong>
                                                                        </th>
                                                                        <td class="">
                                                                            <input type="text" name="" disabled value="" id="deduc"
                                                                                class="form-control">
                                                                        </td>
                                                                    </tr><!-- / Total tax -->
                                                                    <tr>
                                                                        <!-- Grand Total -->
                                                                        <th class="col-sm-8 vertical-td"><strong>Net
                                                                                Salary
                                                                                :</strong>
                                                                        </th>
                                                                        <td class="">
                                                                            <input type="text" name="" disabled required
                                                                                value="" id="net_salary"
                                                                                class="form-control">
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
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary" id="save" onclick="saveTemplate(this)">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </form>
    </div>
</div>