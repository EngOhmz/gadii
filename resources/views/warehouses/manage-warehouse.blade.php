@extends('layouts.master')

@section('content')

  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
               <!-- end of alert -->
               <div class="card">
                 <div class="card-header">
                   <h4>Warehouses</h4>
                 </div>
                 <div class="card-body">
                   <div class="row">
                     <div class="col-12 col-sm-12 col-lg-2 col-xl-2 col-md-2">
                       <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                          <li class="nav-item">
                           <a class="nav-link  active" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile" aria-selected="true">Manage Warehouses</a>
                         </li>
                         <li class="nav-item">
                           <a class="nav-link" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="false">Register Warehouse </a>
                         </li>
                       </ul>
                     </div>
                     
                     <div class="col-12 col-sm-12 col-lg-10 col-xl-10 col-md-10">
                       <div class="tab-content no-padding" id="myTab2Content">
                         <div class="tab-pane fade" id="home4" role="tabpanel" aria-labelledby="home-tab4">
                           <div class="card">
                             <div class="card-header">
                               <h4>Register Warehouse</h4>
                             </div>
                             <!-- stating register warehause form -->
                             <div class="card-body p-0">
                                   <div class="card-body" id ="register_warehouse_form">
                                     <div class="form-row">
                                     <div class="form-group col-md-12">
                                       <label for="warehousename">Warehouse Name</label>
                                       <input type="text"  name='warehousename' class="form-control" id="warehousenameid" placeholder="Enter Warehouse Name">
                                            @error('warehousename')
                                     <div class="text-danger">{{$message }}</div>
                                 @enderror 
                                     </div>
                                 
                                     </div>
                                      
                                        <div class="form-row">
                                       <div class="form-group col-md-6">
                                         <label for="insurance">Insurance</label>
                                         <select id="selectInsurance"  name="insurance" class="form-control">
                                           <option selected="">Select Insurance</option>
                                         </select>
                                       </div>
                                       <div class="form-group col-md-6 col-lg-6">
                                       <label for="newinsurance">Add Insurance</label>
                                       <div class="input-group">
                                         <h4 class="btn btn-primary"  data-toggle="modal" data-target="#insurance_form">Add new insurance <i class="fa fa-plus"></i></h4>
                                      </div>
                                       </div>
                                     </div>
                                       <div class="form-row">
                                       <div class="form-group col-md-6">
                                         <label for="warehousemanage">Full Name of Manager</label>
                                         <input type="text" v-model="warehouse_form_data.warehousemanager" name='warehousemanage' class="form-control" id="warehousemanagerid" placeholder="Enter Manager Name">
                                         
                                       </div>
                                       <div class="form-group col-md-6">
                                         <label for="managercontact">Manager Contact</label>
                                         <input type="number" name="managercontact" class="form-control" id="managercontactid" placeholder="Enter Manager Contact">
                                         <!-- @error('managercontact')
                                         <div class="text text-danger">{{$message }}</div>
                                     @enderror -->
                                       </div>
                                     </div> 
                                     <div class="form-row">
                                          <div class="form-group col-md-12 col-lg-12">
                                          <label for="warehouselocation">Warehouse Location</label>
                                     </div>
                                     <div class="form-group col-md-6 col-lg-6">
                                     <label for="selectRegion">Region</label>
                                     <select id="selectRegionid" name="selectRegion" class="form-control" placeholder="Select Region">
                                         <option value="" selected="">Select Region</option>
                                     </select>
                                     </div>
                                       <div class="form-group col-md-6 col-lg-6">
                                         <label for="warehouseowner">District</label>
                                         <select  id="selectDistrictid" name="warehouseowner" class="form-control">
                                           <option value="" selected="">Select District</option>
                                         </select>
                                       </div>
                                       </div>
                                    <div class="form-row">
                                     <div class="form-group col-md-6 col-lg-6">
                             
                                     <input type="submit" click="register_warehouse()" value="Save" id="register_warehouseid" name="save" class="btn btn-lg btn-primary">
                                    </div>
                                     </div>
                                   </div>
                                   <!-- Ending register warehause form -->
                             </div>
                           
                           </div>
                         </div>
                      <div class="tab-pane fade  active show" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
                        
                        <div class="table-responsive">
                          <table class="table table-striped" id="table-1">
                              <thead>
                                  <tr>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Platform(s): activate to sort column ascending"
                                          style="width: 186.484px;">Warehouse Name</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Platform(s): activate to sort column ascending"
                                          style="width: 186.484px;">Warehouse Owner</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Engine version: activate to sort column ascending"
                                          style="width: 141.219px;">Manager Phone</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Engine version: activate to sort column ascending"
                                          style="width: 141.219px;">Warehouse Location</th>
                  
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="CSS grade: activate to sort column ascending"
                                          style="width: 98.1094px;">Actions</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                      </div>   
                 </div>
                         <div class="tab-pane fade" id="contact4" role="tabpanel" aria-labelledby="contact-tab4">
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
    
  </section>
  <!-- delete modal -->
  <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete?
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" type="submit"  class="btn btn-danger"><a href="farmer/{{$flist->id ?? ''}}/delete" style="color:white;font-weight:bold">Delete</a></button>
        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- end of the delete model -->

 <!--Add new insurance model -->
  <div class="modal fade" id="insurance_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new Insurance</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
          <div class="card-body">
            <div class="form-row">
              <div class="form-group col-md-6 col-lg-6 col-xl-6">
                <label for="insurancename">Insurance Company</label>
                <input type="text" name='insurancename' class="form-control" id="insurancenameid" placeholder="">
                    @error('insurancename')
                <div class="text-danger">{{$message }}</div>
                @enderror
              </div>
              <div class="form-group col-md-6 col-lg-6 col-xl-6">
                <label for="insuranceamount">Insurance Amount</label>
                <input type="text" name='insuranceamount' class="form-control" id="insuranceamountid" placeholder="">
                    @error('insuranceamount')
                <div class="text-danger">{{$message }}</div>
                @enderror
              </div>
            </div>
            <div class="form-group col-md-12 col-lg-12 col-xl-12">
              <label for="assetvalue">Asset Value</label>
              <input type="text" name='assetvalue' class="form-control" id="assetvalueid" placeholder="">
                  @error('assetvalue')
              <div class="text-danger">{{$message }}</div>
              @enderror
            </div>
            <div class="form-group col-md-12 col-lg-12 col-xl-12">
                  <label for="insurancetype">Insurance Type</label>
                  <select name="insurancetype" id="insurancetypeid" class="form-control">
                      <option value=''>Select Insurance Type</option>
                      <option value='private'>Compressive</option>
                      <option value="hired">Third Part</option>
                  </select>
                </div>
            <div class="form-group col-md-12 col-lg-12 col-xl-12">
              <label for="coveringage">Covering Age (Year)</label>
              <input type="number" name='coveringage' class="form-control" id="coveringageid" placeholder="">
                  @error('coveringage')
              <div class="text-danger">{{$message }}</div>
              @enderror
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 col-lg-6 col-xl-6">
                  <label for="startdate">Start Date</label>
                  <input type="date" name='startdate' class="form-control" id="startdateid" placeholder="Starting date">
                  
                </div>
                <div class="form-group col-md-6 col-lg-6 col-xl-6">
                  <label for="enddate">End Date</label>
                  <input type="date" name='enddate' class="form-control" id="enddateid" placeholder="Ending date">
                </div>
              </div>
             
            <div class="form-row">
               <div class="form-group col-md-12 col-lg-12">
    
                <input type="submit" value="Add" id="addingInsurance" name="save" class="btn btn-block btn-primary">
              </div>
            </div>
          </div>

    </div>
  </div>
</div>
<!-- end of Add new insurance model -->
@endsection

@section('scripts')
<script >
$(document).ready(function(){

  //refernce table of warehouses
  var table = $('#table-1').DataTable();
  var selectRegionElement = document.getElementById("selectRegionid"),
  selectDistrictElement = document.getElementById("selectDistrictid"),
  selectInsuranceElement = document.getElementById("selectInsurance");
  getPageData();
function getPageData(){
  //ajax for get all page data 
  $.ajax({
        type: "GET",
        url: "warehouse_backend",
        dataType: "json",
        success: function(response) {
          $.each(response.warehouse,function(key,item){
           //adding row to the warehouse table
            table.row.add( [
              item.warehouse_name,
              item.user.name,
              item.manager_contact,
              item.district.name+","+item.region.name,
              '<a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"\
                                              title="Edit" onclick=""\
                                              href=""><i\
                                                  class="fa fa-edit"></i></a>\
                                                  <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"\
                                              title="desplay detail"  href="warehouse/'+item.id+'/show" ><i class="fa fa-tv"></i></a>'
                                             ,
        ] ).draw();
          });

          selectInsuranceElement.length = 1; // remove all options bar first
           //adding options to the selection of insurence
           $.each(response.insurances,function(key,insurance){
            $('#selectInsurance').append('<option value="'+insurance.id+'">\
                                       '+insurance.insurance_name+'\
                                  </option>');
           });

           selectDistrictElement.length = 1; // remove all options bar first
           selectRegionElement.length = 1; // remove all options bar first
          //control selection of region and destrict
          $.each(response.regions,function(key,region){
            $('#selectRegionid').append('<option value="'+region.id+'">\
                                       '+region.name+'\
                                  </option>');
           });

          
          //  function called when selecting region 
          selectRegionElement.onchange = function () {
            if (this.selectedIndex < 1) return; // done
            $("#selectDistrictid").empty();
           $("#selectDistrictid").append('<option value="">Select</option>');
            $.each(response.regions[selectRegionElement.value-1].districts,function(key,district){
          
            $('#selectDistrictid').append('<option value="'+district.id+'">\
                                       '+district.name+'\
                                      </option>');
              });
                }
                console.log(response);
            },
            error: function(response) {
                console.log(response);
            }
        });
     }  

          //function of on click save button ibn add insurance modle
          $(document).on('click','#addingInsurance',function(e){
          e.preventDefault();
          //data used on adding insurance
          var insuranceData = {
            "type":"addInsurance",
            "insurancename":$('#insurancenameid').val(),
            "insuranceamount":$('#insuranceamountid').val(),
            "assetvalue":$('#assetvalueid').val(),
            "insurancetype":$('#insurancetypeid').val(),
            "coveringage":$('#coveringageid').val(),
            "startdate":$('#startdateid').val(),
            "enddate":$('#enddateid').val(),

          }
          //setting the x-csrf-token in ajax request
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          //ajax for adding insurance
          $.ajax({
            type:"POST",
            url:'{{ route("warehouse_backend.store") }}',
            data:insuranceData,
            dataType:"json",
            success:function(response){
              getPageData();//reload page data
              $('#insurance_form').modal('hide');//it hide modal
              $('#insurance_form').find('input').val("");//it clear input in modal
              console.log(response);
            },
            error: function(response) {
                console.log(response);
            }
          }) ;

        });


        //function of on click save button ibn add insurance modle
        $(document).on('click','#register_warehouseid',function(e){
          e.preventDefault();
          //data used on adding insurance
          var insuranceData = {
            "type":"addWarehouse",
            "warehousename":$('#warehousenameid').val(),
            "region_id":$('#selectRegionid').val(),
            "district_id":$('#selectDistrictid').val(),
            "warehousemanager":$('#warehousemanagerid').val(),
            "insurence":$('#selectInsurance').val(),
            "managercontact":$('#managercontactid').val(),
          }
          //setting the x-csrf-token in ajax request
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          //ajax for adding insurance
          $.ajax({
            type:"POST",
            url:'{{ route("warehouse_backend.store") }}',
            data:insuranceData,
            dataType:"json",
            success:function(response){
              getPageData();//reload page data
              $('#register_warehouse_form').find('input').val("");//it clear input in modal
              console.log(response);
            },
            error: function(response) {
                console.log(response);
            }
          }) ;

        });


        

});
</script>
@endsection