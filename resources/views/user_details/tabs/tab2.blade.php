<div class="tab-pane fade @if($type =='bank' || $type =='edit-bank') active show  @endif" id="tab2" role="tabpanel"
    aria-labelledby="tab1">
    <?php $id = 1; ?>
<div class="row">
  <div class="col-lg-12 col-md-12">
    <div class="card">
        <div class="card-header">
            <h4>Bank Details</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if($type =='basic' || $type =='bank'   || $type =='salary' || $type =='notification')active show @endif" id="home-tab2" data-toggle="tab"
                        href="#home2" role="tab" aria-controls="home" aria-selected="true">Details
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($type =='edit-basic') active show @endif" id="profile-tab2"
                        data-toggle="tab" href="#profile2" role="tab" aria-controls="profile" aria-selected="false">Edit
                        Details</a>
                </li>

            </ul>
            <div class="tab-content tab-bordered" id="myTab3Content">
                <div class="tab-pane fade @if($type =='basic' || $type =='bank'  || $type =='salary' || $type =='notification') active show @endif" id="home2" role="tabpanel"
                    aria-labelledby="home-tab2">
                     <div class="table-responsive">
                                        <table class="table datatable-basic table-striped">
                                    <tbody>
                                           
                                          
                                          
                             <tr>
                      <td>Bank Name: </td>  <td >{{ !empty($bank_details) ? $bank_details->bank_name : ''}}</td>
                          <td>Routing Number: </td><td >{{ !empty($bank_details) ? $bank_details->routing_number : ''}}</td>                                 
                           </tr>


                <tr>
                                      <td>Account Number: </td> <td>{{ !empty($bank_details) ? $bank_details->account_number : ''}}</td>
                                                                                                       
                                     <td>Account Name: </td><td >{{ !empty($bank_details) ? $bank_details->account_name : ''}}</td>
                                                                      
                                </tr>
               
                            
                                        </tbody>

                            </table>
                        </div>
                    </div>
               

                <div class="tab-pane fade @if($type =='edit-basic') active show @endif" id="profile2"
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

                                  
                        <input type="hidden" value="bank" name="type">
                          <input type="hidden" value="{{$user_id}}" name="user_id">


                           <div class="form-group row">
                                     <label class="col-lg-2 col-form-label">Bank Name</label>
                                                    <div class="col-lg-4">
                                   <input type="text" class="form-control" value="{{ !empty($bank_details) ? $bank_details->bank_name : ''}}" name="bank_name" required>
                                </div>
                                 <label class="col-lg-2 col-form-label">Routing Number</label>
                                                    <div class="col-lg-4">
                                    <input type="text"  class="form-control"  value="{{ !empty($bank_details) ? $bank_details->routing_number : ''}}" name="routing_number" >
                                </div>
                                    </div>
   
                                     <div class="form-group row">
                                     <label class="col-lg-2 col-form-label">Account Name</label>
                                                    <div class="col-lg-4">
                                   <input type="text" class="form-control" value="{{ !empty($bank_details) ? $bank_details->account_name : ''}}" name="account_name" required>
                                </div>
                                 <label class="col-lg-2 col-form-label">Account Number</label>
                                                    <div class="col-lg-4">
                                    <input type="text"  class="form-control" value="{{ !empty($bank_details) ? $bank_details->account_number : ''}}" name="account_number" required>
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