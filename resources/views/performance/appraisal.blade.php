@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
            
                <div class="card">
                    <div class="card-header">
                        <h4>Employee Appraisal</h4>
                    </div>
                    <div class="card-body">
                    
                         
                         @if(!empty($id))
                         
                               
                    <div class="form-group offset-3">
                        <label for="field-1" class="col-sm-3 control-label">Employee <span class="required">
                                *</span></label>

                        <div class="col-sm-5">
                            <select name="user" class="form-control m-b user" style="width:100%" disabled required>
                                            <option value="">Select</option>
                                            @if (!empty($user))
                                            @foreach ($user as $u) 
                                            <option value="{{$u->id}}" @if(isset($dept)) {{ $dept == $u->id ? 'selected' : ''  }} @endif> {{$u->name}}</option>
                                                   
                                            @endforeach
                                            @endif
                                        </select>
                        </div>
                    </div>
                    <div class="form-group offset-3">
                        <label class="col-sm-3 control-label">Select Month <span class="required"> *</span></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input required type="month" value="<?php
                                if (!empty($month)) {
                                    echo $month;
                                }
                                ?>" class="form-control monthyear" name="month" data-format="yyyy/mm/dd" readonly>

                                
                            </div>
                        </div>
                    </div>
                    
                    
                         @else
                         
                          {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
               
                    <div class="form-group offset-3">
                        <label for="field-1" class="col-sm-3 control-label">Employee <span class="required">
                                *</span></label>

                        <div class="col-sm-5">
                            <select name="user" class="form-control m-b user" style="width:100%" required>
                                            <option value="">Select</option>
                                            @if (!empty($user))
                                            @foreach ($user as $u) 
                                            <option value="{{$u->id}}" @if(isset($dept)) {{ $dept == $u->id ? 'selected' : ''  }} @endif> {{$u->name}}</option>
                                                   
                                            @endforeach
                                            @endif
                                        </select>
                        </div>
                    </div>
                    <div class="form-group offset-3">
                        <label class="col-sm-3 control-label">Select Month <span class="required"> *</span></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input required type="month" value="<?php
                                if (!empty($month)) {
                                    echo $month;
                                }
                                ?>" class="form-control monthyear" name="month" data-format="yyyy/mm/dd">

                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group offset-4" id="border-none">
                        <label for="field-1" class="col-sm-3 control-label"></label>
                        <div class="col-sm-5">
                             <button type="submit" class="btn btn-success" id="save">Go</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>
                        </div>
                    </div>
                    
                    <div class=""> <p class="form-control-static errors" id="errors" style="text-align:center;color:red;"></p> </div>
                
            </form>
            @endif
        </div><!-- ******************** Employee Search Panel Ends ******************** -->
           </div>             
                        
            <br>
@if(!empty($dept))              
                       
                           
                                <div class="card">
                                
                                 
                                 
                                    <div class="card-header">
                                       @php $name=App\Models\User::find($dept)->name;@endphp
                                        <h5>Appraisal for {{$name}}  for the month of {{Carbon\Carbon::parse($month)->format('F Y')}}</h5>
                                       
                                    </div>
                                    
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('update_appraisal', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'save_appraisal']) }}
                                                @method('POST')
                                                @endif

                                       
                               
                                
                                <!-- Technical Competency Starts ---->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="panel-title" style="margin-left: 8px;">Technical Competencies</h5>
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
                                                    @if (!empty($list->customer_experiece_management) && $list->customer_experiece_management != 0) 
                                                        <select name="customer_experiece_management" class="form-control m-b tech">
                                                            <option value="">Select Value</option>
                                                            <option value="1" @if(isset($data)) {{ $data->customer_experiece_management == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->customer_experiece_management == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->customer_experiece_management == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->customer_experiece_management == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                        @endif
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
                                                    @if (!empty($list->marketing) && $list->marketing != 0) 
                                                        <select name="marketing" class="form-control m-b tech">
                                                            <option value="">Select Value</option>
                                                            <option value="1" @if(isset($data)) {{ $data->marketing == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->marketing == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->marketing == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->marketing == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                   
                                                        @endif
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
                                                    @if (!empty($list->management) && $list->management != 0) 
                                                        <select name="management" class="form-control m-b tech">
                                                          <option value="">Select Value</option>
                                                            <option value="1" @if(isset($data)) {{ $data->management == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->management == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->management == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->management == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                   
                                                        @endif
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
                                                    @if (!empty($list->administration) && $list->administration != 0) 
                                                        <select name="administration" class="form-control m-b tech">
                                                          <option value="">Select Value</option>
                                                            <option value="1" @if(isset($data)) {{ $data->administration == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->administration == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->administration == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->administration == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                   
                                                        @endif
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
                                                    @if (!empty($list->presentation_skill) && $list->presentation_skill != 0) 
                                                        <select name="presentation_skill" class="form-control m-b tech">
                                                            <option value="">Select Value</option>
                                                            <option value="1" @if(isset($data)) {{ $data->presentation_skill == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->presentation_skill== '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->presentation_skill == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->presentation_skill == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                   
                                                        @endif
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
                                                    @if (!empty($list->quality_of_work) && $list->quality_of_work != 0) 
                                                         <select name="quality_of_work" class="form-control m-b tech">
                                                         <option value="">Select Value</option>
                                                            <option value="1" @if(isset($data)) {{ $data->quality_of_work == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->quality_of_work== '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->quality_of_work == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->quality_of_work == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                   
                                                        @endif
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
                                                    @if (!empty($list->efficiency) && $list->efficiency != 0) 
                                                        <select name="efficiency" class="form-control m-b tech">
                                                             <option value="">Select Value</option>
                                                            <option value="1" @if(isset($data)) {{ $data->efficiency == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->efficiency == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->efficiency == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->efficiency == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                   
                                                        @endif
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


                                    <!-- Behavioural Competency Ends ---->
                                    <div class="col-sm-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="panel-title" style="margin-left: 8px;">Behavioural / Organizational Competencies</h5>
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
                                                    @if (!empty($list->integrity) && $list->integrity != 0) 
                                                        <select name="integrity" class="form-control m-b behave">
                                                            <option value="">Select Value</option>
                                                            <option value="1" @if(isset($data)) {{ $data->integrity == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->integrity == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->integrity == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                        </select>
                                                        @endif
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
                                                    @if (!empty($list->professionalism) && $list->professionalism != 0) 
                                                        <select name="professionalism" class="form-control m-b behave">
                                                             <option value="">Select Value</option>
                                                            <option value="1" @if(isset($data)) {{ $data->professionalism == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->professionalism == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->professionalism == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                        </select>
                                                        @endif
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
                                                    @if (!empty($list->team_work) && $list->team_work != 0) 
                                                       <select name="team_work" class="form-control m-b behave">
                                                            <option value="">Select Value</option>
                                                            <option value="1" @if(isset($data)) {{ $data->team_work == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->team_work == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->team_work == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->team_work == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                        @endif
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
                                                    @if (!empty($list->critical_thinking) && $list->critical_thinking != 0) 
                                                      <select name="critical_thinking" class="form-control m-b behave">
                                                            <option value="">Select Value</option>
                                                            <option value="1" @if(isset($data)) {{ $data->critical_thinking == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->critical_thinking == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->critical_thinking == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->critical_thinking == '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                        @endif
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
                                                    @if (!empty($list->conflict_management) && $list->conflict_management != 0) 
                                                     <select name="conflict_management" class="form-control m-b behave">
                                                            <option value="">Select Value</option>
                                                            <option value="1" @if(isset($data)) {{ $data->conflict_management == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->conflict_management == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->conflict_management == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                            <option value="4" @if(isset($data)) {{ $data->conflict_management== '4' ? 'selected' : ''  }} @endif> Expert</option>
                                                        </select>
                                                        @endif
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
                                                    @if (!empty($list->attendance) && $list->attendance != 0) 
                                                       <select name="attendance" class="form-control m-b behave">
                                                             <option value="">Select Value</option>
                                                            <option value="1" @if(isset($data)) {{ $data->attendance == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->attendance == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->attendance == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                        </select>
                                                        @endif
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
                                                    @if (!empty($list->ability_to_meed_deadline) && $list->ability_to_meed_deadline != 0) 
                                                     <select name="ability_to_meed_deadline" class="form-control m-b behave">
                                                          <option value="">Select Value</option>
                                                            <option value="1" @if(isset($data)) {{ $data->ability_to_meed_deadline == '1' ? 'selected' : ''  }} @endif> Beginner</option>
                                                            <option value="2" @if(isset($data)) {{ $data->ability_to_meed_deadline == '2' ? 'selected' : ''  }} @endif> Intermediate</option>
                                                            <option value="3" @if(isset($data)) {{ $data->ability_to_meed_deadline == '3' ? 'selected' : ''  }} @endif> Advanced</option>
                                                        </select>
                                                        @endif
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
                            <textarea name="general_remarks" class="form-control textarea">{{ isset($data) ? $data->general_remarks : '' }} </textarea>
                            </div>
                        </div>
                    </div>
               
                                
                                  <input type="hidden" name="user_id" value="{{ isset($dept) ? $dept : '' }}">
                                     <input type="hidden" name="indicator_id" value="{{ isset($list) ? $list->id : '' }}"> 
                                     
                                      <input type="hidden" name="appraisal_month" value="{{ isset($month) ? $month : '' }}">
                                      
                                      
                                 
                                      
                                              
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit" id="save">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit" id="save">Save</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                           
                            @endif

                      
            </div>
        </div>

    </div>
</section>

<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>

@endsection

@section('scripts')
 <script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"orderable": false, "targets": [1]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>
    
<script>
$(document).ready(function() {

  

    $(document).on('change', '.user', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("performance/findUser")}}',
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
            $("#errors").empty();
            $("#save").attr("disabled", false);
             if (data != '') {
           $("#errors").append(data);
           $("#save").attr("disabled", true);
} else {
  
}
            
       
            }

        });

    });



$(document).on('change', '.monthyear', function() {
        var id = $(this).val();
    var user=$('.user').val();
        $.ajax({
            url: '{{url("performance/findMonth")}}',
            type: "GET",
            data: {
                id: id,
                  user: user,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
            $("#errors").empty();
            $("#save").attr("disabled", false);
             if (data != '') {
           $("#errors").append(data);
           $("#save").attr("disabled", true);
} else {
  
}
            
       
            }

        });
  });


});
</script>
<script type="text/javascript">
 $(document).on("change", function () {
     
      var b = 0;
        var t= 0;
     
      $(".tech").each(function () {
            t += +$(this).val();
             $("#total_tech").val(t);
        });
         $(".behave").each(function () {
               b += +$(this).val();
           $("#total_behave").val(b);
        });

 });
 </script>
 
 <script type="text/javascript">
    function model(id, type) {


        $.ajax({
            type: 'GET',
            url: '{{url("performance/performanceModal")}}',
            data: {
                'id': id,
                'type': type,
            },
            cache: false,
            async: true,
            success: function(data) {
                //alert(data);
                $('.modal-dialog').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });

    }
    </script>
@endsection