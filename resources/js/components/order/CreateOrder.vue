<template>
<div>
  
    <table class="table table-striped table-md">
      <tbody><tr>
        <th>Warehouse name</th>
        <th>Crops Type</th>
        <th>Quantity</th>
        <th>Region</th>
        <th>Destrict</th>
        <th>action</th>
      </tr>
      <tr>
        <th><input type="text" v-model="state.warehouse" name='state.warehouse' class="form-control" id="warehouseid" placeholder="search by warehouse"></th>
        <th> <input type="text" v-model="state.crops_type" name='crop_type' class="form-control" id="crop_typeid" placeholder="search by Crops Type"></th>
        <th> <input type="number" v-model="state.quantity" name='quantity' class="form-control" id="quantityid" placeholder="search by Quantity"></th>
        <th> <input type="text" name='region' class="form-control" id="regionid" placeholder="search by Region"></th>
        <th> <input type="text" name='destrict' class="form-control" id="destrictid" placeholder="search by Destrict"></th>
       
      </tr>
      <tr v-for="(data,index) in state.filtertabledata" :key="index">
            <td>{{data.warehouse.warehouse_name}}</td>
            <td>{{data.crops_type.crop_name}}</td>
            <td>{{data.total_quantity}}</td>
            <td>Dar es salaam</td>
            <td>ilala</td>
            <!-- <th><create-Order-form-component/></th> -->
            <td><h4><button class="btn btn-primary"  data-toggle="modal" @click="form_data.warehouse_id=data.warehouse.id,state.dialog_state = true"  data-target="#appFormModal" href="#">Order</button></h4></td>
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
               
 <Teleport to="#teleport-target">
<div class="modal inmodal" id="appFormModal" tabindex="-1" role="dialog" v-if="state.dialog_state">
    <div class="dealogbox">
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
                <input type="number" v-model="form_data.quantity" name='orderquantity' class="form-control" id="orderquantityid" placeholder="Enter Quantity in Kilogram(Kg)">
                   
            </div>
            <div class="form-group col-md-12 col-lg-12 col-xl-12">
                <label for="offerAmount">Offer Amount</label>
                 <input type="number" v-model="form_data.offer_amount" name='offerAmount' class="form-control" id="offerAmountid" placeholder="Offer Amount in Tsh">
             </div>
            <div class="form-row">
               <div class="form-group col-md-12 col-lg-12">
                <input type="submit" @click="makeOrder()" value="Submit Order" name="save" class="btn btn-block btn-primary">
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
import { reactive , onMounted, computed} from "vue";
import axios from 'axios'
export default {
   setup() {
    const state = reactive({
       dialog_state: false,
            warehouse:'',
            quantity:'',
            crops_type:'',
            filtertabledata: computed(() => { return state.tabledata.filter(datas => Number(datas.total_quantity)>=Number(state.quantity)).filter(datas => !datas.crops_type.crop_name.toLowerCase().indexOf(state.crops_type.toLowerCase())).filter(datas => !datas.warehouse.warehouse_name.toLowerCase().indexOf(state.warehouse.toLowerCase()))}),
            tabledata:[]
    })

    const form_data = reactive({
      warehouse_id:2,
      quantity:'',
      offer_amount:'',
      user_id:2,
      client_id:4,
      crop_type:1,
      start_location:'required',
      end_location:'required',
      route_type:1,
      status:1
    });
     onMounted(() => {
       getdata()
      console.log("component mounted");
    });

     const  getdata = async() => {
       await axios.get('manipulation').then(response=>{
         state.tabledata=response.data}).catch(error =>{  console.log(error)})
    };

    const  makeOrder = async() => {
      // let url = '{{ route("manipulation.store") }}';
       await axios.post("manipulation",form_data).then(
         response=>{
           if(response.status==200){
             state.dialog_state = false,
             document.getElementById("close").click()
             }}).catch(error =>{  console.log(error)})
    };


    return { state,form_data,getdata,makeOrder };
  },
       
     
       
       
    }

</script>