<template>
    <div >
       <!-- alert -->
         
          <div v-show="response_data.successful" class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" @click="response_data.successful=false">
                <span>×</span>
              </button>
              {{response_data.message}}
            </div>
          </div>
       
          <div v-show="response_data.error" class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" @click="response_data.error=false">
                <span>×</span>
              </button>
              {{response_data.message}}
            </div>
          </div>
          

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
                              <div class="card-body">
                                <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label for="warehousename">Warehouse Name</label>
                                  <input type="text" v-model="warehouse_form_data.warehousename" name='warehousename' class="form-control" id="warehousenameid" placeholder="Enter Warehouse Name">
                                      <!-- @error('warehousename')
                                <div class="text-danger">{{$message }}</div>
                            @enderror -->
                                </div>
                            
                                </div>
                                 
                                   <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="insurance">Insurance</label>
                                    <select id="insuranceid" v-model="warehouse_form_data.insurence" name="insurance" class="form-control">
                                      <option selected="">Select Insurance</option>
                                      <option v-for="(insurance,index) in state.page_data.insurances" :key="index" :value="insurance.id">{{insurance.insurance_name}}</option>
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
                                    <input type="text" v-model="warehouse_form_data.warehousemanager" name='warehousemanage' class="form-control" id="warehousemanageid" placeholder="Enter Manager Name">
                                    
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="managercontact">Manager Contact</label>
                                    <input type="number" v-model="warehouse_form_data.managercontact" name="managercontact" class="form-control" id="managercontact" placeholder="Enter Manager Contact">
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
                                <label for="warehouseowner">Region</label>
                                <select v-model="warehouse_form_data.region_id" id="warehouseownerid" name="warehouseowner" class="form-control" placeholder="Select Region">
                                    <option value="" selected="">Select Region</option>
                                    <option v-for="(region,index) in state.page_data.regions" :key="index" :value="region.id">{{region.name}}</option>
                                </select>
                                </div>
                                  <div class="form-group col-md-6 col-lg-6">
                                    <label for="warehouseowner">District</label>
                                    <select v-model="warehouse_form_data.district_id" id="warehouseownerid" name="warehouseowner" class="form-control">
                                      <option value="" selected="">Select District</option>
                                      <option v-for="(district,index) in state.filtered_district" :key="index" :value="district.id">{{district.name}}</option>
                                    </select>
                                  </div>
                                  </div>
                               <div class="form-row">
                                <div class="form-group col-md-6 col-lg-6">
                        
                                <input type="submit" @click="register_warehouse()" value="Save" name="save" class="btn btn-lg btn-primary">
                               </div>
                                </div>
                              </div>
                              <!-- Ending register warehause form -->
                        </div>
                      
                      </div>
                    </div>
                    <div class="tab-pane fade  active show" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
                    <div class="table-responsive">
                    <table class="table table-striped table-md">
                        <tbody>
                        <tr>
                        <th>Warehouse Name</th>
                        <th>Warehouse Owner</th>
                        <th>Manager Phone</th>
                        <th>Warehouse location</th>
                        <th>Action</th>
                        </tr>
                        <tr v-for="(data,index) in state.page_data.warehouse" :key="index">
                        <td>{{data.warehouse_name}}</td>
                        <td>{{data.user.name}}</td>
                        <td>{{data.manager_contact}}</td>
                        <td> {{data.warehouse_location}}</td>
                        <td>
                          <div class="row">
                          <div class="col-lg-12 col-sm-12 col-md-12">
                          <a v-bind:href="`warehouse/${data.id}/show`" ><i class="fas fa-tv"></i></a>
                          <!-- <a href="farmer/{{$warehouse->id}}/edit"><i class="fas fa-edit"></i></a> -->
                          <!-- <a href="#"  data-toggle="modal" data-target="#basicModal"><i class="fas fa-trash-alt"></i></a> -->
                          
                          </div>
                          </div>
                        </td>
                        </tr>
                        </tbody>
                        <div class="card-footer text-right">
                            <nav class="d-inline-block">
                            <ul class="pagination mb-0">
                                <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
                                <li class="page-item">
                                <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                                </li>
                            </ul>
                            </nav>
                        </div>       
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
</template>

<script>
import { reactive,onMounted,computed} from "vue";
import axios from 'axios'
export default {
   setup() {
    // data used in state of component
    const state = reactive({
        dialog_state: false,
        region_id:'',
        page_data:{districts:[]},
        districts_data:[],
        filtered_district: computed(() => {
              return state.page_data.districts.filter(
                      district => Number(district.region_id)===Number(warehouse_form_data.region_id)
                      )}),
        
    })
    // data to handel response
    const  response_data= reactive({
      message:'',
      successful:false,
      error:false,
      });
    // data used on register warehouse
    const warehouse_form_data = reactive({
        warehousename:'',
        added_by:'',
        region_id:'',
        district_id:'',
        insurence:'',
        managercontact:'',
        warehousemanager:'',
    });
    // fuction called on component mounted
     onMounted(() => {
       getdata()
      console.log("component mounted");
    });

    // function of gate page data
     const  getdata = async() => {
       await axios.get('warehouse_backend').then(
           response=>{
               console.log(response.data);
               state.page_data=response.data
               }).catch(error =>{  console.log(error)})
    };

    const  register_warehouse = async() => {
      warehouse_form_data.added_by=state.page_data.user_id
      console.log(warehouse_form_data)
       await axios.post("warehouse_backend",warehouse_form_data).then(
         response=>{
           if(response.status==200){
            response_data.message = response.data.message;
             response_data.error=false;
            response_data.successful=true;
            warehouse_form_data.warehousename='';
            warehouse_form_data.added_by='';
            warehouse_form_data.region_id='';
            warehouse_form_data.district_id='';
            warehouse_form_data.insurence='';
            warehouse_form_data.managercontact='';
            warehouse_form_data.warehousemanager='';
            //  state.dialog_state = false,
            //  document.getElementById("close").click()
            // console.log(response.data)
             }else{
            response_data.message = response.data.message;
            response_data.successful=false;
            response_data.error=true;
             }}).catch(error =>{  response_data.message = "sorry fill all data";
             response_data.successful=false;
            response_data.error=true})
    };


    return { state,warehouse_form_data,response_data,getdata,register_warehouse };
  },
       
     
       
       
    }
</script>
