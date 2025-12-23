<div class="tab-pane fade @if($type =='salary' || $type =='edit-salary') active show  @endif" id="tab3" role="tabpanel"
    aria-labelledby="tab1">
    <?php $id = 1; ?>
<div class="row">
  <div class="col-lg-12 col-md-12">
    <div class="card">
        <div class="card-header">
            <h4>Salary Details</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if($type =='basic' || $type =='bank'  || $type =='salary' || $type =='notification' )active show @endif" id="home-tab2" data-toggle="tab"
                        href="#home3" role="tab" aria-controls="home" aria-selected="true">Details
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($type =='edit-basic') active show @endif" id="profile-tab2"
                        data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="false">Edit
                        Details</a>
                </li>

            </ul>
            <div class="tab-content tab-bordered" id="myTab3Content">
                <div class="tab-pane fade @if($type =='basic' || $type =='bank' || $type =='salary' || $type =='notification' ) active show @endif" id="home3" role="tabpanel"
                    aria-labelledby="home-tab2">
                     <div class="table-responsive">
                                        <table class="table datatable-basic table-striped">
                                    <tbody>
                                           
                                          
                                          
                             <tr>
                      <td>TIN: </td>  <td >{{ !empty($salary_details) ? $salary_details->TIN : ''}}</td>
                          <td>NSSF: </td><td >{{ !empty($salary_details) ? $salary_details->NSSF : ''}}</td>                                 
                           </tr>


              
               
                            
                                        </tbody>

                            </table>
                        </div>
                    </div>
               

                <div class="tab-pane fade @if($type =='edit-basic') active show @endif" id="profile3"
                    role="tabpanel" aria-labelledby="profile-tab2">

                    <div class="card">
                        <div class="card-header">
                           
                            <h5>Edit Details</h5>
                         
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 ">
                                                                 
                                    
                                    {{ Form::open(['route' => 'details.store']) }}
                                    @method('POST')

                                  
                        <input type="hidden" value="salary" name="type">
                          <input type="hidden" value="{{$user_id}}" name="user_id">


                           <div class="form-group row">
                                     <label class="col-lg-2 col-form-label">TIN</label>
                                                    <div class="col-lg-4">
                                   <input type="text" class="form-control" value="{{ !empty($salary_details) ? $salary_details->TIN : ''}}" name="TIN" required>
                                </div>
                                 <label class="col-lg-2 col-form-label">NSSF</label>
                                                    <div class="col-lg-4">
                                    <input type="text"  class="form-control"  value="{{ !empty($salary_details) ? $salary_details->NSSF : ''}}" name="NSSF" >
                                </div>
                                    </div>
   
                                  
                          
                     

                                    <div class="form-group row">
                                        <div class="col-lg-offset-2 col-lg-12">
                                            @if($type =='edit-preparation')
                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                data-toggle="modal" data-target="#myModal" type="submit">Update</button>
                                            @else
                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                type="submit">Save</button>
                                            @endif
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
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
</div>