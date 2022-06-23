<template>
    <div>
       <div class="card">
            <div class="card-header">
              <h4>{{warehouse.warehouse_name}}</h4>
            </div>
            <div class="row">
            <div class="col-12 col-sm-12 col-lg-2 col-xl-2 col-md-2">
                  <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                     <li class="nav-item">
                      <a class="nav-link  active" id="profile-tab4" data-toggle="tab" href="#accounts" role="tab" aria-controls="accounts" aria-selected="true">Accounts</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="home-tab4" data-toggle="tab" href="#orders" role="tab" aria-controls="home" aria-selected="false">Orders</a>
                    </li>
                  </ul>
            </div>




             <div class="col-12 col-sm-12 col-lg-10 col-xl-10 col-md-10">
                  <div class="tab-content no-padding" id="myTab2Content">
          <div class="tab-pane fade active show" id="accounts" role="tabpanel" aria-labelledby="accounts">
                    <div class="padding-20">
              <ul class="nav nav-tabs" id="myTab2" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about1" role="tab"
                    aria-selected="true">Famer Accounts</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#deposity1" role="tab"
                    aria-selected="false">Deposite History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="farm land" data-toggle="tab" href="#withdraw1" role="tab"
                      aria-selected="false">Withdraw History</a>
                  </li>
              </ul>
              
              <div class="tab-content tab-bordered" id="myTab3Content">
                
                
                <div class="tab-pane fade show active" id="about1" role="tabpanel" aria-labelledby="home-tab2">
                  <h4><button class="btn btn-primary"  data-toggle="modal" data-target="#newacount_form">Add New Account <i class="fa fa-plus"></i></button></h4>
                 <div class="table-responsive">
                     
                            <table class="table table-striped table-md">
                              <tbody><tr>
                          
                                <th>Account Name</th>
                                <th>Famer Name</th>
                                <th>Crops Type</th>
                                <th>Total Quantity</th>
                                <th>Action</th>
                              </tr>
                                 <tr v-for="(account,index) in accounts" :key="index">
                                   <td> {{account.farmer.firstname}}{{account.farmer.lastname}}_{{account.crops_type.crop_name}}</td>
                                   <td>{{account.farmer.firstname}} {{account.farmer.lastname}}</td>
                                <td>{{account.crops_type.crop_name}}</td>
                                <td>{{account.total_quantity}}kg</td>
                                <td>
                                  <div class="row">
                                  <div class="col-lg-12 col-sm-12 col-md-12">
                                  <a class="btn btn-primary"  data-toggle="modal" onclick="model('deposity',{{account.id}},{{warehouse.id}})"  data-target="#appFormModal" href="#" >deposite <i class="fas fa-plus"></i></a>
                                  <a  class="btn btn-primary"  data-toggle="modal" onclick="model('withdraw',{{account.id}},{{warehouse.id}})" data-target="#appFormModal" href="#">withdraw <i class="fas fa-minus"></i></a>

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
                
                <div class="tab-pane fade" id="deposity1" role="tabpanel" aria-labelledby="profile-tab2">
                    <div class="table-responsive">
                 
                            <table class="table table-striped table-md">
                              <tbody><tr>
                          
                                <th>Famer Account</th>
                                <th>Crops Type</th>
                                <th>Date</th>
                                <th>Quantity</th>
                                <th>Price</th>
                              </tr>
                             
                                <tr v-for="(single_deposity,index) in deposity" :key="index">
                                <td>{{single_deposity.farmer_account}}{{single_deposity.farmer_account}}_{{single_deposity.farmer_account}}</td>
                                <td>{{single_deposity.farmer_account}}</td>
                                <td>{{single_deposity.created_at}}</td>
                                <td>{{single_deposity.quantity}}kg</td>
                                <td>{{single_deposity.cost}}</td>
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
                
                
                   <div class="tab-pane fade" id="withdraw1" role="tabpanel" aria-labelledby="profile-tab2">
                    <div class="table-responsive">
               
                            <table class="table table-striped table-md">
                              <tbody><tr>
                          
                                <th>Famer Account</th>
                                <th>Crops Type</th>
                                <th>Date</th>
                                <th>Quantity</th>
                              </tr>
                                <tr v-for="(single_withdraw,index) in withdraw" :key="index">
                                <td>{{single_withdraw}}{{single_withdraw}}_{{single_withdraw}}</td>
                                <td>{{single_withdraw}}</td>
                                <td>{{single_withdraw.created_at}}</td>
                                <td> {{single_withdraw.quantity}}kg</td>
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
                
                
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="profile-tab4">
                    <div class="padding-20">
              <ul class="nav nav-tabs" id="myTab2" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
                    aria-selected="true">Order Request</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#deposity" role="tab"
                    aria-selected="false">Created Order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="farm land" data-toggle="tab" href="#withdraw" role="tab"
                      aria-selected="false">Order Progress</a>
                  </li>
              </ul>
              
              <div class="tab-content tab-bordered" id="myTab3Content">
                
                
                <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                 <div class="table-responsive">
                            <table class="table table-striped table-md">
                              <tbody><tr>
                                <th>Crops Type</th>
                                <th>Quantity</th>
                                <th>Requested By</th>
                                <th>Requested at</th>
                                <th>Action</th>
                              </tr>
                              <tr v-for="(single_order,index) in state.orders" :key="index">
                              <td>{{single_order.crops_type.crop_name}} </td>
                              <td>{{single_order.total_quantity}} </td>
                              <td></td>
                              <td>{{single_order.total_quantity}}</td>
                              <td>
                                <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12">
                                  <button class="btn btn-primary"  data-toggle="modal" @click="state.dialog_state = true"  data-target="#createOrder" href="#">Order</button>
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
                
                <div class="tab-pane fade" id="deposity" role="tabpanel" aria-labelledby="profile-tab2">
                    <div class="table-responsive">
                    
                            <table class="table table-striped table-md">
                              <tbody><tr>
                                <th>Crops Type</th>
                                <th>Quantity</th>
                                <th>Requested By</th>
                                <th>Requested at</th>
                                <th>Created at</th>
                              </tr>
                              <tr v-for="(single_order,index) in state.orders" :key="index">
                              <td>{{single_order.crops_type.crop_name}} </td>
                              <td>{{single_order.total_quantity}} </td>
                              <td></td>
                              <td>{{single_order.total_quantity}}</td>
                              <td>
                                
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
                
                
                   <div class="tab-pane fade" id="withdraw" role="tabpanel" aria-labelledby="profile-tab2">
                    <div class="table-responsive">
                            <table class="table table-striped table-md">
                              <tbody>
                                 <tr>
                                <th>Crops Type</th>
                                <th>Quantity</th>
                                <th>Requested By</th>
                                <th>Requested at</th>
                                <th>Order Status</th>
                              </tr>
                              <tr v-for="(single_order,index) in state.orders" :key="index">
                              <td>{{single_order.crops_type.crop_name}} </td>
                              <td>{{single_order.total_quantity}} </td>
                              <td></td>
                              <td>{{single_order.total_quantity}}</td>
                              <td>
                               
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
                
                
              </div>
            </div>   
            </div>
                    <div class="tab-pane fade" id="contact4" role="tabpanel" aria-labelledby="contact-tab4">
                    </div>

                  </div>
                </div>
            </div>
            
          </div>
<Teleport to="#teleport-target">
<div class="modal inmodal" id="createOrder" tabindex="-1" role="dialog" v-if="state.dialog_state">
    <div class="dealogbox" >
   <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Order Form</h5>
                    <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                      <span @click="state.dialog_state = false" >&times;</span>
                    </button>
                  </div>
         
                      <div class="card-body">
            <div class="form-group col-md-12 col-lg-12 col-xl-12">
               <label for="orderquantity">Quantity in Kilogram(Kg)</label>
                <input type="number" name='orderquantity' class="form-control" id="orderquantityid" placeholder="Enter Quantity in Kilogram(Kg)">
                   
            </div>
            <div class="form-group col-md-12 col-lg-12 col-xl-12">
                <label for="offerAmount">Offer Amount</label>
                 <input type="number"  name='offerAmount' class="form-control" id="offerAmountid" placeholder="Offer Amount in Tsh">
             </div>
            <div class="form-row">
               <div class="form-group col-md-12 col-lg-12">
                <input type="submit"  value="Submit Order" name="save" class="btn btn-block btn-primary">
              </div>
            </div>
          </div>
            
                </div>
              </div>
    </div>
</div>
</Teleport>
    </div>
</template>

<script>
import { reactive,onMounted,computed} from "vue";
import axios from 'axios'
export default {
   props: ['warehouse','accounts','deposity','withdraw','farmer','crops_types'],   
   setup(props) {
    // data used in state of component
    // const {warehouse_props}=toRefs(props)
    // const {account_props}=toRefs(props)
    const state = reactive({
        dialog_state: false,
        orders:'',
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
       const id = Number(props.warehouse.id);
       await axios.get("/manipulation",{id}).then(
           response=>{
               console.log(response.data);
               state.orders=response.data;
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
            //  console.log(response.data)
             }else{
            response_data.message = response.data.message;
            response_data.successful=false;
            response_data.error=true;
             }}).catch(error =>{  
            response_data.message = "sorry fill all data";
            response_data.successful=false;
            response_data.error=true
            })
    };


    return { state,warehouse_form_data,response_data,register_warehouse,getdata };
  },
       
     
       
       
    }
</script>
