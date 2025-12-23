
<div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="formModal" >Performance Appraisal Details for {{$data->assign->name}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
       <br>
        <div class="modal-body">
        
        <table class="table datatable-basic table-borderless">
                                       @php $dep=App\Models\Departments::find($data->assign->department_id); @endphp
                                   <tr><td><strong>Department   </strong></td><td>{{$dep->name}}</td></tr>                                                                                                  
                                  <tr><td><strong>Appraisal Month </strong></td><td><?php echo date('F Y', strtotime($data->appraisal_month)); ?></td> </tr>
                      
                   </table>

    
<hr>
 <div class="row">
<!-- Technical Competency Starts ---->
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="panel-title">Technical Competencies</h4>
                    </div>
                     <div class="table-responsive">
 <table class="table table-striped">
                                            
                                                     <thead>
                                                          <tr>
                                                    <th>Indicator</th>
                                                   <th>Expected Value</th>
                                                   <th>Set Value</th>
                                                         </tr>
                                                      </thead>
                                                      
                                                       <tbody>
                                                       
                                                          <tr>
                                                <td>Customer Experience Management</td>
                                                    <td>
                                                    <?php
                                if (!empty($list->customer_experiece_management) && $list->customer_experiece_management == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($list->customer_experiece_management) && $list->customer_experiece_management == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($list->customer_experiece_management) && $list->customer_experiece_management == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($list->customer_experiece_management) && $list->customer_experiece_management == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?>
                                                    </td>
                                                    <td>
                                                   <?php
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
                                ?>
                                                    </td>
                                                    </tr>
                                                    
                                                    
                                                    <tr>
                                                <td>Marketing</td>
                                                    <td>
                                                    <?php
                                if (!empty($list->marketing) && $list->marketing == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($list->marketing) && $list->marketing == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($list->marketing) && $list->marketing == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($list->marketing) && $list->marketing == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?>
                                                    </td>
                                                    <td>
                                                   <?php
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
                                ?>
                                                    </td>
                                                    </tr>
                                                    
                                                    
                                                      <tr>
                                                <td>Management</td>
                                                    <td>
                                                    <?php
                                  if (!empty($list->management) && $list->management == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($list->management) && $list->management == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($list->management) && $list->management == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($list->management) && $list->management == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?>
                                    </td>
                                                    <td>
                                                   
                                                   <?php
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
                                ?>
                                                    </td>
                                                    </tr>
                                                    
                                                    
                                                    <tr>
                                                <td>Administration</td>
                                                    <td>
                                                    <?php
                                 if (!empty($list->administration) && $list->administration == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($list->administration) && $list->administration == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($list->administration) && $list->administration == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($list->administration) && $list->administration == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?>
                                    </td>
                                                    <td>
                                                   <?php
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
                                ?>
                                                    </td>
                                                    </tr>
                                                    
                                                    
                                                                                <tr>
                                                <td>Presentation Skill</td>
                                                    <td>
                                                    <?php
                                  if (!empty($list->presentation_skill) && $list->presentation_skill == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($list->presentation_skill) && $list->presentation_skill == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($list->presentation_skill) && $list->management == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($list->presentation_skill) && $list->presentation_skill == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?>
                                    </td>
                                                    <td>
                                                   <?php
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
                                ?>
                                                    </td>
                                                    </tr>
                                                    
                                                    
                                                     <tr>
                                                <td>Quality Of Work</td>
                                                    <td>
                                                    <?php
                                  if (!empty($list->quality_of_work) && $list->quality_of_work == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($list->quality_of_work) && $list->quality_of_work == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($list->quality_of_work) && $list->quality_of_work == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($list->quality_of_work) && $list->quality_of_work == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?>
                                    </td>
                                                    <td>
                                                   <?php
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
                                ?>
                                                    </td>
                                                    </tr>
                                               
                                               
                                                
                                                
                                                 <tr>
                                                <td>Efficiency</td>
                                                    <td>
                                                    <?php
                                  if (!empty($list->efficiency) && $list->efficiency == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($list->efficiency) && $list->efficiency == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($list->efficiency) && $list->efficiency == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($list->efficiency) && $list->efficiency == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?>
                                    </td>
                                                    <td>
                                                   <?php
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
                                ?>
                                                    </td>
                                                    </tr>
                                                
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                <td>Total</td>
                                                <td><input type="text" class="form-control" value="{{ isset($list) ? $list->total_technical : '' }}" readonly></td>
                                                <td><input type="text" class="form-control" name="total_technical" id="total_tech" value="{{ isset($data) ? $data->total_technical : '' }}" readonly></td>
                                                </tr>
                                                </tfoot>
                                                </table>                  
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
                     <div class="table-responsive">
                    <table class="table table-striped">
                                            
                                                     <thead>
                                                          <tr>
                                                    <th>Indicator</th>
                                                   <th>Expected Value</th>
                                                   <th>Set Value</th>
                                                         </tr>
                                                      </thead>
                                                      
                                                       <tbody>
                                                       
                                                       <tr>
                                                <td>Integrity</td>
                                                    <td>
                                                    
                                <?php if (!empty($list->integrity) && $list->integrity == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($list->integrity) && $list->integrity == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($list->integrity) && $list->integrity == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($list->integrity) && $list->integrity == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?>
                                                    </td>
                                                    <td>
                                                   <?php
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
                                ?>
                                                    </td>
                                                    </tr>

                                                <tr>
                                                <td>Professionalism</td>
                                                    <td>
                              <?php if (!empty($list->professionalism) && $list->professionalism == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($list->professionalism) && $list->professionalism == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($list->professionalism) && $list->professionalism == 3) {
                                    echo 'Advanced';
                                }elseif (!empty($list->professionalism) && $list->professionalism == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?>
                                                    </td>
                                                  <td>
                                                   <?php
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
                                ?>
                                                    </td>
                                                </tr>
                                                
                                                 <tr>
                                                <td>Team Work</td>
                                                    <td>
                              <?php  if (!empty($list->team_work) && $list->team_work == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($list->team_work) && $list->team_work == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($list->team_work) && $list->team_work == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($list->team_work) && $list->team_work == 4) {
                                    echo 'Expert';
                                }else {
                                    echo 'Not Set';
                                }
                                ?>
                                                    </td>
                                                  <td>
                                                   <?php
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
                                ?>
                                                    </td>
                                                </tr>
                                                
  
                                                
                                                                      <tr>
                                                <td>Critical Thinking</td>
                                                    <td>
                               <?php if (!empty($list->critical_thinking) && $list->critical_thinking == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($list->critical_thinking) && $list->critical_thinking == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($list->critical_thinking) && $list->critical_thinking == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($list->critical_thinking) && $list->critical_thinking == 4) {
                                    echo 'Expert';
                                }else {
                                    echo 'Not Set';
                                }
                                ?>
                                                    </td>
                                                  <td>
                                                   <?php
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
                                ?>
                                                    </td>
                                                </tr>
                                                
                                                             
                                                                      <tr>
                                                <td>Conflict Management</td>
                                                    <td>
                                <?php if (!empty($list->conflict_management) && $list->conflict_management == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($list->conflict_management) && $list->conflict_management == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($list->conflict_management) && $list->conflict_management == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($list->conflict_management) && $list->conflict_management == 4) {
                                    echo 'Expert';
                                }else {
                                    echo 'Not Set';
                                }
                                ?>
                                                    </td>
                                                  <td>
                                                   <?php
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
                                ?>
                                                    </td>
                                                </tr>
                                               
                                                                     
                                                                      <tr>
                                                <td>Attendance</td>
                                                    <td>
                              <?php  if (!empty($list->attendance) && $list->attendance == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($list->attendance) && $list->attendance == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($list->attendance) && $list->attendance == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($list->attendance) && $list->attendance == 4) {
                                    echo 'Expert';
                                } else {
                                    echo 'Not Set';
                                }
                                ?>
                                                    </td>
                                                  <td>
                                                   <?php
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
                                ?>
                                                    </td>
                                                </tr>
                                               
                                               
                                                                     
                                                                      <tr>
                                                <td>Ability To Meet Deadline</td>
                                                    <td>
                                <?php if (!empty($list->ability_to_meed_deadline) && $list->ability_to_meed_deadline == 1) {
                                    echo 'Beginner';
                                } elseif (!empty($list->ability_to_meed_deadline) && $list->ability_to_meed_deadline == 2) {
                                    echo 'Intermediate';
                                } elseif (!empty($list->ability_to_meed_deadline) && $list->ability_to_meed_deadline == 3) {
                                    echo 'Advanced';
                                } elseif (!empty($list->ability_to_meed_deadline) && $list->ability_to_meed_deadline == 4) {
                                    echo 'Expert';
                                }else {
                                    echo 'Not Set';
                                }
                                ?>
                                                    </td>
                                                  <td>
                                                   <?php
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
                                ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                                <tfoot>
                                                <tr>
                                                <td>Total</td>
                                                <td><input type="text" class="form-control" value="{{ isset($list) ? $list->total_behaviour : '' }}" readonly></td>
                                                <td><input type="text" class="form-control" name="total_behaviour" id="total_behave" value="{{ isset($data) ? $data->total_behaviour : '' }}" readonly></td>
                                                </tr>
                                                </tfoot>
                                                </table>
            </div>
            </div>
            </div>
            <!-- Behavioural Competency Ends ---->
       
        </div>
        
          <div class="col-sm-12"> <!-- General Remarks and Save button --->
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Remarks </label>
                            <div class="col-sm-6">
                            <blockquote >{{ isset($data) ? $data->general_remarks : '' }} </blockquote>
                            </div>
                        </div>
                    </div>

        <div class="modal-footer ">
     <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
    </div>
      
    </div>
