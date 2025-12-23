
<div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="formModal" >Indicator Details for {{$data->department->name}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
       <br>
        <div class="modal-body">
 <div class="row">
<!-- Technical Competency Starts ---->
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="panel-title">Technical Competencies</h4>
                    </div>
 <div class="card-body">
                    <div class="form-group row">
                        <label for="field-1"
                               class=" col-sm-8 control-label"
                              >Customer Experience Management
                            : </label>
                        <div class="col-sm-4">
                            <p class="form-control-static" style="text-align: justify;"><?php
                                if (!empty($data->customer_experiece_management) && $data->customer_experiece_management == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($data->customer_experiece_management) && $data->customer_experiece_management == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($data->customer_experiece_management) && $data->customer_experiece_management == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($data->customer_experiece_management) && $data->customer_experiece_management == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="field-1" class=" col-sm-8 control-label">Marketing
                            : </label>
                        <div class="col-sm-4">
                            <p class="form-control-static" style="text-align: justify;"><?php
                                if (!empty($data->marketing) && $data->marketing == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($data->marketing) && $data->marketing == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($data->marketing) && $data->marketing == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($data->marketing) && $data->marketing == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="field-1" class=" col-sm-8 control-label">Management
                            : </label>
                        <div class="col-sm-4">
                            <p class="form-control-static" style="text-align: justify;"><?php
                                if (!empty($data->management) && $data->management == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($data->management) && $data->management == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($data->management) && $data->management == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($data->management) && $data->management == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="field-1"
                               class=" col-sm-8 control-label">Administration
                            : </label>
                        <div class="col-sm-4">
                            <p class="form-control-static" style="text-align: justify;"><?php
                                if (!empty($data->administration) && $data->administration == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($data->administration) && $data->administration == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($data->administration) && $data->administration == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($data->administration) && $data->administration == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="field-1"
                               class=" col-sm-8 control-label">Presentation Skill
                            : </label>
                        <div class="col-sm-4">
                            <p class="form-control-static" style="text-align: justify;"><?php
                                if (!empty($data->presentation_skill) && $data->presentation_skill == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($data->presentation_skill) && $data->presentation_skill == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($data->presentation_skill) && $data->presentation_skill == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($data->presentation_skill) && $data->presentation_skill == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="field-1"
                               class=" col-sm-8 control-label">Quality Of Work
                            : </label>
                        <div class="col-sm-4">
                            <p class="form-control-static" style="text-align: justify;"><?php
                                if (!empty($data->quality_of_work) && $data->quality_of_work == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($data->quality_of_work) && $data->quality_of_work == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($data->quality_of_work) && $data->quality_of_work == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($data->quality_of_work) && $data->quality_of_work == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="field-1" class=" col-sm-8 control-label">Efficiency
                            : </label>
                        <div class="col-sm-4">
                            <p class="form-control-static" style="text-align: justify;"><?php
                                if (!empty($data->efficiency) && $data->efficiency == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($data->efficiency) && $data->efficiency == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($data->efficiency) && $data->efficiency == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($data->efficiency) && $data->efficiency == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?></p>
                        </div>
                    </div>

               </div>                               
            </div>
          </div>

   <!-- Technical Competency Ends ---->
            <div class="col-sm-6">
                <!-- Behavioural Competency Starts ---->
                <div class="card">
                    <div class="card-header">
                        <h4 class="panel-title">Behavioural / Organizational Competencies</h4>
                    </div>
                    <div class="card-body">

                    <div class="form-group row">
                        <label for="field-1" class=" col-sm-8 control-label">Integrity
                            : </label>
                        <div class="col-sm-4">
                            <p class="form-control-static" style="text-align: justify;"><?php
                                if (!empty($data->integrity) && $data->integrity == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($data->integrity) && $data->integrity == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($data->integrity) && $data->integrity == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($data->integrity) && $data->integrity == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="field-1"
                               class=" col-sm-8 control-label">Professionalism
                            : </label>
                        <div class="col-sm-4">
                            <p class="form-control-static" style="text-align: justify;"><?php
                                if (!empty($data->professionalism) && $data->professionalism == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($data->professionalism) && $data->professionalism == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($data->professionalism) && $data->professionalism == 3) {
                                    echo 'Advanced';
                                }elseif (!empty($data->professionalism) && $data->professionalism == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="field-1" class=" col-sm-8 control-label">Team Work
                            : </label>
                        <div class="col-sm-4">
                            <p class="form-control-static" style="text-align: justify;"><?php
                                if (!empty($data->team_work) && $data->team_work == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($data->team_work) && $data->team_work == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($data->team_work) && $data->team_work == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($data->team_work) && $data->team_work == 4) {
                                    echo 'Expert';
                                }else {
                                    echo 'Not Set';
                                }
                                ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="field-1"
                               class=" col-sm-8 control-label">Critical Thinking
                            : </label>
                        <div class="col-sm-4">
                            <p class="form-control-static" style="text-align: justify;"><?php
                                if (!empty($data->critical_thinking) && $data->critical_thinking == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($data->critical_thinking) && $data->critical_thinking == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($data->critical_thinking) && $data->critical_thinking == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($data->critical_thinking) && $data->critical_thinking == 4) {
                                    echo 'Expert';
                                }else {
                                    echo 'Not Set';
                                }
                                ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="field-1"
                               class=" col-sm-8 control-label">Conflict Management
                            : </label>
                        <div class="col-sm-4">
                            <p class="form-control-static" style="text-align: justify;"><?php
                                if (!empty($data->conflict_management) && $data->conflict_management == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($data->conflict_management) && $data->conflict_management == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($data->conflict_management) && $data->conflict_management == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($data->conflict_management) && $data->conflict_management == 4) {
                                    echo 'Expert';
                                }else {
                                    echo 'Not Set';
                                }
                                ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="field-1" class=" col-sm-8 control-label">Attendance
                            : </label>
                        <div class="col-sm-4">
                            <p class="form-control-static" style="text-align: justify;"><?php
                                if (!empty($data->attendance) && $data->attendance == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($data->attendance) && $data->attendance == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($data->attendance) && $data->attendance == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($data->attendance) && $data->attendance == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="field-1"
                               class=" col-sm-8 control-label">Ability To Meet Deadline
                            : </label>
                        <div class="col-sm-4">
                            <p class="form-control-static" style="text-align: justify;"><?php
                                if (!empty($data->ability_to_meed_deadline) && $data->ability_to_meed_deadline == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($data->ability_to_meed_deadline) && $data->ability_to_meed_deadline == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($data->ability_to_meed_deadline) && $data->ability_to_meed_deadline == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($data->ability_to_meed_deadline) && $data->ability_to_meed_deadline == 4) {
                                    echo 'Expert';
                                }else {
                                    echo 'Not Set';
                                }
                                ?></p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!-- Behavioural Competency Ends ---->
       
        </div>

        <div class="modal-footer ">
     <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
    </div>
      
    </div>
