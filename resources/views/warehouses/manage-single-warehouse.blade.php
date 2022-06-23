@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
      <div class="row mt-sm-4">
    
        <div class="col-12 col-md-12 col-lg-12">
          <div id="single_warehouse">
            <div>
              <div class="card">
                   <div class="card-header">
                     <h4>{{$warehouse->warehouse_name}}</h4>
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
                          <table class="table table-striped single_warehouse_table" id="acounts_table_id">
                              <thead>
                                  <tr>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Platform(s): activate to sort column ascending"
                                          style="width: 186.484px;">Account Name</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Platform(s): activate to sort column ascending"
                                          style="width: 186.484px;">Famer Name</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Engine version: activate to sort column ascending"
                                          style="width: 141.219px;">Crops Type</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Engine version: activate to sort column ascending"
                                          style="width: 141.219px;">Total Quantity</th>
                  
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
                       
                       <div class="tab-pane fade" id="deposity1" role="tabpanel" aria-labelledby="profile-tab2">
                        <div class="table-responsive">
                          <table class="table table-striped single_warehouse_table" id="deposity_table_id">
                              <thead>
                                  <tr>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Platform(s): activate to sort column ascending"
                                          style="width: 186.484px;">Famer Account</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Platform(s): activate to sort column ascending"
                                          style="width: 186.484px;">Crops Typer</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Engine version: activate to sort column ascending"
                                          style="width: 141.219px;">Date</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Engine version: activate to sort column ascending"
                                          style="width: 141.219px;">Quantity</th>
                  
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="CSS grade: activate to sort column ascending"
                                          style="width: 98.1094px;">Price</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                      </div>   
                       </div>
                       
                       
                          <div class="tab-pane fade" id="withdraw1" role="tabpanel" aria-labelledby="profile-tab2">
                            <div class="table-responsive">
                              <table class="table table-striped single_warehouse_table" id="withdraw_table_id">
                                  <thead>
                                      <tr>
                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                              rowspan="1" colspan="1"
                                              aria-label="Platform(s): activate to sort column ascending"
                                              style="width: 186.484px;">Famer Account</th>
                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                              rowspan="1" colspan="1"
                                              aria-label="Platform(s): activate to sort column ascending"
                                              style="width: 186.484px;">Crops Type</th>
                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                              rowspan="1" colspan="1"
                                              aria-label="Engine version: activate to sort column ascending"
                                              style="width: 141.219px;">Date</th>
                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                              rowspan="1" colspan="1"
                                              aria-label="Engine version: activate to sort column ascending"
                                              style="width: 141.219px;">Quantity</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
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
                           <a class="nav-link" id="farmland" data-toggle="tab" href="#withdraw" role="tab"
                             aria-selected="false">Order Progress</a>
                         </li>
                     </ul>
                     
                     <div class="tab-content tab-bordered" id="myTab3Content">
                       
                       
                       <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                        <div class="table-responsive">
                          <table class="table table-striped single_warehouse_table" id="order_request_table_id">
                              <thead>
                                  <tr>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Platform(s): activate to sort column ascending"
                                          style="width: 186.484px;">Crops Type</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Platform(s): activate to sort column ascending"
                                          style="width: 186.484px;">Quantity</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Engine version: activate to sort column ascending"
                                          style="width: 141.219px;">Requested By</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Engine version: activate to sort column ascending"
                                          style="width: 141.219px;">Requested at</th>
                  
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
                       
                       <div class="tab-pane fade" id="deposity" role="tabpanel" aria-labelledby="profile-tab2">
                        <div class="table-responsive">
                          <table class="table table-striped single_warehouse_table" id="created_order_table_id">
                              <thead>
                                  <tr>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Platform(s): activate to sort column ascending"
                                          style="width: 186.484px;">Crops Type</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Platform(s): activate to sort column ascending"
                                          style="width: 186.484px;">Quantity</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Engine version: activate to sort column ascending"
                                          style="width: 141.219px;">Requested By</th>
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="Engine version: activate to sort column ascending"
                                          style="width: 141.219px;">Requested at</th>
                  
                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                          rowspan="1" colspan="1"
                                          aria-label="CSS grade: activate to sort column ascending"
                                          style="width: 98.1094px;">Created at</th>
                                  </tr>
                              </thead>
                              <tbody>
                              </tbody>
                          </table>
                      </div> 
                    </div>
                       
                       
                          <div class="tab-pane fade" id="withdraw" role="tabpanel" aria-labelledby="profile-tab2">
                            <div class="table-responsive">
                              <table class="table table-striped single_warehouse_table" id="order_progress_table_id">
                                  <thead>
                                      <tr>
                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                              rowspan="1" colspan="1"
                                              aria-label="Platform(s): activate to sort column ascending"
                                              style="width: 186.484px;">Crops Type</th>
                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                              rowspan="1" colspan="1"
                                              aria-label="Platform(s): activate to sort column ascending"
                                              style="width: 186.484px;">Quantity</th>
                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                              rowspan="1" colspan="1"
                                              aria-label="Engine version: activate to sort column ascending"
                                              style="width: 141.219px;">Requested By</th>
                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                              rowspan="1" colspan="1"
                                              aria-label="Engine version: activate to sort column ascending"
                                              style="width: 141.219px;">Requested at</th>
                      
                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                              rowspan="1" colspan="1"
                                              aria-label="CSS grade: activate to sort column ascending"
                                              style="width: 98.1094px;">Order Status</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
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
           </div>
          </div>
        </div>
      </div>
    </div>
    {{-- <script type="text/javascript">
    function model( type,account_id,warehouse_id) {

        let url = '{{ route("singlewarehouse.show", ":id") }}';
        url = url.replace(':id', account_id)

        $.ajax({
            type: 'GET',
            url: url,
            data: {
                'type': type,
                'warehouse_id':warehouse_id,
                'account_id':account_id,
            },
            cache: false,
            async: true,
            success: function(data) {
                //alert(data);
                $('.dealogbox').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });

    }
    </script> --}}
  </section>
  {{-- make order modal --}}
  <div class="modal inmodal" id="createOrder1" tabindex="-1"  data-backdrop="static" data-keyboard="false" role="dialog" style="padding-right: 17px;" >
    <div class="dealogbox" >
   <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Order Form</h5>
              <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                <span  >&times;</span>
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
  {{-- eend of make order modal --}}
  
   <!--Add new Account model -->
  <div class="modal fade" id="newacount_form" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new Famer Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
          <div class="card-body">
            <div class="form-group col-md-12 col-lg-12 col-xl-12">
                  <label for="selectfamer">Select Famer</label>
                  <select name="selectfamer" id="select_farmer_id" class="form-control">
                  <option value="">Select Famer</option>
                  </select>
                </div>
                <div class="form-group col-md-12 col-lg-12 col-xl-12">
                  <label for="cropstype">Crops Type</label>
                  <select name="cropstype" id="select_crops_type_id" class="form-control">
                      <option value=''>Select Crops Type</option>
                  </select>
                </div>
            
            <div class="form-row">
               <div class="form-group col-md-12 col-lg-12">
    
                <button type="submit" id="register_account_id" value="Add" name="save" class="btn btn-block btn-primary">Add</button>
              </div>
            </div>
          </div>
    </div>
  </div>
</div>
<!-- end of Add new account model -->

 <!--Deposity model -->
              <div class="modal fade" id="deposity_form" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deposity Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                      <div class="card-body">
                       <!-- intput for capture warehouseid hidden-->
                        <input type="hidden" id="deposity_account_id" name='account_id' >
                        <div class="form-group col-md-12 col-lg-12 col-xl-12">
                           <label for="deposityquantity">Quantity in Kilogram(Kg)</label>
                            <input type="number"  name='deposityquantity' class="form-control" id="deposityquantityid" placeholder="Enter Quantity in Kilogram(Kg)">
                        </div>
                         <div class="form-group col-md-12 col-lg-12 col-xl-12">
                           <label for="deposityprice">Deposity Cost</label>
                            <input type="number" name='deposityprice' class="form-control" id="depositypriceid" placeholder="Enter Deposity Cost in Tsh">
                        </div>
                        <div class="form-row">
                           <div class="form-group col-md-12 col-lg-12">
                            <input type="submit" id="make_deposity_id" value="Add" name="save" class="btn btn-block btn-primary">
                          </div>
                        </div>
                      </div>
                </div>
              </div>
            </div>
            <!-- end of Deposity model -->
            
            <!--Withdraw model -->
              <div class="modal fade" id="withdraw_form" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Withdraw Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                      <div class="card-body">
                          <!-- intput for capture warehouseid hidden-->
                          <input type="hidden" id="withdraw_account_id" name='warehouseid' >
                        <div class="form-group col-md-12 col-lg-12 col-xl-12">
                           <label for="withquantity">Quantity in Kilogram(Kg)</label>
                            <input type="text" name='withquantity' class="form-control" id="withquantityid" placeholder="Enter Quantity in Kilogram(Kg)">
                        </div>
                        
                        <div class="form-row">
                           <div class="form-group col-md-12 col-lg-12">
                
                            <input type="submit" id="make_withdraw_id" value="Add" name="save" class="btn btn-block btn-primary">
                          </div>
                        </div>
                      </div>
                </div>
              </div>
            </div>
<!-- end of withdraw model -->

<div class="modal inmodal" id="createOrder" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="padding-right: 17px;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myLargeModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <hr>
        <div class="table-responsive">
          <input type="hidden" id="hidden_order_id" name="hidden_order" class="form-control item_total_tax"/>
        <table class="table table-bordered" id="cart">
            <thead>
                <tr>
                    <th>Accounts</th>
                    <th>Account Quantity</th>
                    <th>Reduced Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="add_order_tbody">
              <tr class="line_items">
                <td><select name="select_account_name[]" class="form-control item_name dropdawn_class select_account0" required  data-sub_category_id=""><option value="">Select Account</option></select></td>
                    <td id="quantity_model_id"><input type="number" name="total_tax[]" class="form-control " placeholder ="Quantity" required readonly /></td>
                    <td><input type="number" name="quantity[]" class="form-control item_total" placeholder ="Enter Quantity" /></td>
                    <td></td>
              </tr>
                


            </tbody>
            <tfoot>
                <tr class="line_items">
                    <td colspan="1"></td>
                    <td><span class="bold">Total Quantity </span>: </td>
                    <td><input type="text" name="total_quantity[]"
                            class="form-control item_total"
                            placeholder="total quantity" required
                            jAutoCalc="SUM({quantity})" readonly></td>
                    <td colspan="1"><button type="button" name="add" class="btn btn-success btn-xs add"><i
                              class="fas fa-plus"> Add Row</i></button></td>
                </tr>
                <tr class="line_items">
                  <td colspan="1"></td>
                    <td><span class="bold">Remaining Quantity</span>: </td>
                    <td><input type="text" name="remain_quantity[]"
                            class="form-control item_total" placeholder="Remaining"
                            required jAutoCalc="{requred_quantity}-{total_quantity}" readonly>
                    </td>
                    <td colspan="1"></td>
                </tr>

                <tr class="line_items">
                  <td colspan="1"></td>
                    <td><span class="bold">Requared Quantity</span>: </td>
                    <td><input type="text" name="requred_quantity[]"
                            class="form-control item_total" id='requred_quantiy_id' placeholder="Requred Quantity"
                             readonly>
                    </td>
                    <td colspan="1"></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <hr>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="button" id="save_order_id" class="btn btn-primary">Save Order</button>
    </div>
       
      </div>
    </div>
  </div>
</div>

  @endsection



  @section('scripts')
      <script >
      $(document).ready(function(){
        var warehousedetail = {!! json_encode($warehouse->toArray(), JSON_HEX_TAG) !!};//get data from controller
        var account_dropdawn;
        var temp_account_dropdawn;
        var count =0;
        function setOptionData(){
           //adding opption to the drop down
           $.each(temp_account_dropdawn,function(key,account){
            const account_details = JSON.stringify(account);
                $('.select_account'+count).append('<option value=\''+account_details+'\'>\
                  '+account.farmer.firstname+"_"+account.farmer.lastname+"_"+account.crops_type.crop_name,'\
                                      </option>');
                  });
        }
        $('.single_warehouse_table').DataTable();//its make all tables in this page to be data table
        getAccountsData();//get accounts accounts  data
        getOrdersData();//get orders data
        //function for get account data 
        function getAccountsData(){
          let url = '{{ route("warehouse_backend.show", ":id") }}';
          url = url.replace(':id', warehousedetail.id)

           //setting the x-csrf-token in ajax request
           $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          //ajax for get account data
          $.ajax({
            type:"GET",
            url:url,
            data:{"require":"accounts_data"},
            dataType:"json",
            cache: false,
            async: true,
            success: function(response) {
              //filter withdraw and deposite history
              const withdraw_history = response.history.filter(data => data.status === 1);
              const deposity_history = response.history.filter(data => data.status === 2);
              console.log(deposity_history);
              account_dropdawn = response.accounts;
              $('#acounts_table_id').DataTable().clear();
              //adding row to the account table
              $.each(response.accounts,function(key,account){
                $('#acounts_table_id').DataTable().row.add([
                  account.farmer.firstname+"_"+account.farmer.lastname+"_"+account.crops_type.crop_name,
                  account.farmer.firstname+"  "+account.farmer.lastname,
                  account.crops_type.crop_name,
                  account.total_quantity+" kg",
                  '<div class="btn-group">\
                              <button class="btn btn-xs btn-success dropdown-toggle"data-toggle="dropdown">Action<span class="caret"></span></button>\
                              <ul class="dropdown-menu animated zoomIn">\
                                  <li class="nav-item deposity" value="'+ account.id+'"> <a class="nav-link"  data-toggle="modal"   data-target="#deposity_form" href="#" >deposite <i class="fas fa-plus"></i></a></li>\
                                  <li class="nav-item withdraw" value="'+ account.id+'"><a  class="nav-link"  data-toggle="modal"  data-target="#withdraw_form" href="#">withdraw <i class="fas fa-minus"></i></a></li>\
                              </ul>\
                          </div>',
                ]).draw();
                  });
                  
                  $('#deposity_table_id').DataTable().clear();
              //adding row to the deposity table
              $.each(deposity_history ,function(key,deposity){
                    $('#deposity_table_id').DataTable().row.add([
                      deposity.farmer_account.farmer.firstname+"_"+deposity.farmer_account.farmer.lastname+"_"+deposity.farmer_account.crops_type.crop_name,
                      deposity.farmer_account.crops_type.crop_name,
                      deposity.created_at,
                      deposity.quantity+" kg",
                      deposity.cost,
            ]).draw();
              });
              $('#withdraw_table_id').DataTable().clear();
              //adding row to the deposity table
              $.each(withdraw_history ,function(key,withdraw){
                  $('#withdraw_table_id').DataTable().row.add([
                    withdraw.farmer_account.farmer.firstname+"_"+withdraw.farmer_account.farmer.lastname+"_"+withdraw.farmer_account.crops_type.crop_name,
                    withdraw.farmer_account.crops_type.crop_name,
                    withdraw.created_at,
                    withdraw.quantity+" kg",
            ]).draw();
              });

              //adding options on salect former dropdown
              $.each(response.farmers,function(key,farmer){
                $('#select_farmer_id').append('<option value="'+farmer.id+'">\
                                          '+farmer.firstname+" "+farmer.lastname+'\
                                      </option>');
              });

               //adding options on salect crops type dropdown
               $.each(response.crops_types,function(key,crops_type){
                $('#select_crops_type_id').append('<option value="'+crops_type.id+'">\
                                          '+crops_type.crop_name+'\
                                      </option>');
              });
                console.log(response);
            },
            error: function(response) {
                console.log(response);
            }
        });
     }  

     //functin for get data ogf orders in specific warehouse
     function getOrdersData(){
          let url = '{{ route("manipulation.show", ":id") }}';
          url = url.replace(':id', warehousedetail.id);
           //setting the x-csrf-token in ajax request
           $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          //ajax for get account data
          $.ajax({
            type:"GET",
            url:url,
            dataType:"json",
            cache: false,
            async: true,
            success: function(response) {
              //filter withdraw and deposite history
              const requested_order = response.filter(data => data.status == 1);
              const created_order = response.filter(data => data.status == 2);
              const progress_order = response.filter(data => data.status >= 3);
              console.log(response);
            
              $('#order_request_table_id').DataTable().clear();
              //adding row to the account table
              $.each(requested_order,function(key,order_request){
                const order_details = JSON.stringify(order_request)
                $('#order_request_table_id').DataTable().row.add([
                  order_request.crop_types.crop_name,
                  order_request.quantity,
                  order_request.user.name,
                  order_request.created_at,
                  '<div class="row">\
                  <div class="col-lg-12 col-sm-12 col-md-12">\
                    <button class="btn btn-primary makeorder" value=\''+order_details+'\' data-toggle="modal"  data-target="#createOrder" href="#">Order</button>\
                  </div>\
                  </div>',
                ]).draw();
                  });
              $('#created_order_table_id').DataTable().clear();
              //adding row to the deposity table
              $.each(created_order ,function(key,order_created){
                    $('#created_order_table_id').DataTable().row.add([
                      order_created.crop_types.crop_name,
                      order_created.quantity,
                      order_created.user.name,
                      order_created.created_at,
                      order_created.updated_at,
            ]).draw();
              });
              $('#order_progress_table_id').DataTable().clear();
              //adding row to the deposity table
              $.each(progress_order ,function(key,order){
                  $('#order_progress_table_id').DataTable().row.add([
                    order.crop_types.crop_name,
                    order.quantity,
                    order.user.name,
                    order.created_at,
                    order.updated_at,
                    order.created_at,
            ]).draw();
              });
                console.log(response);
            },
            error: function(response) {
                console.log(response);
            }
        });
     }
     
      //function of on click save button ibn add insurance modle
      $(document).on('click','#register_account_id',function(e){
          e.preventDefault();
          //data used on adding insurance
          var insuranceData = {
            "type":"register_farmer_account",
            "warehouseid":warehousedetail.id,
            "selectfamer":$('#select_farmer_id').val(),
            "cropstype":$('#select_crops_type_id').val(),
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
            url:'{{ route("singlewarehouse.store") }}',
            data:insuranceData,
            dataType:"json",
            success:function(response){
              getAccountsData();//reload account data
              $('#newacount_form').modal('hide');//it hide modal
              Swal.fire({
                icon: 'success',
                title: response,
                showConfirmButton: false,
                timer: 1500
              });
              $('#newacount_form').find('input').val("");//it clear input in modal
              console.log(response);
            },
            error: function(response) {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
              });
                console.log(response);
            }
          }) ;

        });

        //function called on event of depositing
      $(document).on('click','#make_deposity_id',function(e){
          e.preventDefault();
          //data used on adding insurance
          var insuranceData = {
            "type":"deposity",
            "warehouseid":warehousedetail.id,
            "account_id":$('#deposity_account_id').val(),
            "deposityquantity":$('#deposityquantityid').val(),
            "deposityprice":$('#depositypriceid').val(),
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
            url:'{{ route("singlewarehouse.store") }}',
            data:insuranceData,
            dataType:"json",
            success:function(response){
              getAccountsData();//reload account data
              $('#deposity_form').modal('hide');//it hide modal
              Swal.fire({
                icon: 'success',
                title: response,
                showConfirmButton: false,
                timer: 1500
              });
              $('#deposity_form').find('input').val("");//it clear input in modal
              console.log(response);
            },
            error: function(response) {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
              });
                console.log(response);
            }
          }) ;

        });

      //function called on event of withdraw
      $(document).on('click','#make_withdraw_id',function(e){
          e.preventDefault();
          //data used on adding insurance
          var insuranceData = {
            "type":"withdraw",
            "warehouseid":warehousedetail.id,
            "account_id":$('#withdraw_account_id').val(),
            "withquantity":$('#withquantityid').val(),
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
            url:'{{ route("singlewarehouse.store") }}',
            data:insuranceData,
            dataType:"json",
            success:function(response){
              getAccountsData();//reload account data
              $('#withdraw_form').modal('hide');//it hide modal
              Swal.fire({
                icon: 'success',
                title: response,
                showConfirmButton: false,
                timer: 1500
              });
              $('#withdraw_form').find('input').val("");//it clear input in modal
              console.log(response);
            },
            error: function(response) {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
              });
                console.log(response);
            }
          }) ;

        });


        //function setting the value of account id input (hiden) on deposity action
      $(document).on('click','.deposity',function(e){
          e.preventDefault();
          var account_id = $(this).val();
          $('#deposity_account_id').val(account_id);
        });

      //function setting the value of account id input (hiden) on deposity action
      $(document).on('click','.withdraw',function(e){
          e.preventDefault();
          var account_id = $(this).val();
          $('#withdraw_account_id').val(account_id);
      });



      // function of modify offer form table
    function autoCalcSetup() {
        $('table#cart').jAutoCalc('destroy');
        $('table#cart').jAutoCalc({
            keyEventsFire: true,
            decimalPlaces: 2,
            emptyAsZero: true
        });
    }
    autoCalcSetup();
    $(document).on("click",'#save_order_id', function(e) {
      //get all accounts selected
      var account_data = $('[name="select_account_name[]"]').map(function () {
            return this.value;
        }).get();
        //get all quantity reduced in account
        var quantity_data = $('[name="quantity[]"]').map(function () {
            return this.value;
        }).get();

      // alert($('#hidden_order_id').val())

      let url = '{{ route("manipulation.update", ":id") }}';
          url = url.replace(':id', $('#hidden_order_id').val());
           //setting the x-csrf-token in ajax request
           $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          //ajax for get account data
          $.ajax({
            type:"PUT",
            url:url,
            dataType:"json",
            cache: false,
            async: true,
            success: function(response) {
              getOrdersData();//reload orders data
              $('#createOrder').modal('hide');//it hide modal
              $('.remove').click();
              Swal.fire({
                icon: 'success',
                title: response,
                showConfirmButton: false,
                timer: 1500
              });
              $('#createOrder').find('input').val("");//it clear input in modal
              console.log(response);
            },
            error: function(response) {
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
              });
                console.log(response);
            }
          }) ;
      // const taget_order = $(this).val();
      // const json_order_details = JSON.parse(taget_order);
      // $('#requred_quantiy_id').val(json_order_details.quantity)
      // temp_account_dropdawn = account_dropdawn.filter(data => data.crops_type.crop_name == json_order_details.crop_types.crop_name);
      // setOptionData();
    });

    //function of get data when order button clickes
    $(document).on("click",'.makeorder', function(e) {
      const taget_order = $(this).val();
      const json_order_details = JSON.parse(taget_order);
      $('#requred_quantiy_id').val(json_order_details.quantity);
      $('#hidden_order_id').val(json_order_details.id);
      temp_account_dropdawn = account_dropdawn.filter(data => data.crops_type.crop_name == json_order_details.crop_types.crop_name);
      setOptionData();
    });
      $('.add').on("click", function(e) {
count++;
var html = '';
html += '<tr class="line_items">';
html +=
    '<td><select name="select_account_name[]" class="form-control item_name dropdawn_class select_account' +
    count +
    '" required  data-sub_category_id="' +
    count +
    '"><option value="">Select Account</option></select></td>';
html += '<td id="quantity_model_id"><input type="number" name="total_tax[]" class="form-control item_total_tax' + count +
    '" placeholder ="Quantity"  required readonly  /></td>';
html += '<td><input type="number" name="quantity[]" class="form-control item_total' + count +
    '" placeholder ="Enter Quantity"  /></td>';
html +=
    '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';

    $('#add_order_tbody').append(html);
    autoCalcSetup();
    setOptionData();
    });
$(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
        autoCalcSetup();
    });

    // fuction to control changes of dropdawn
    $(document).on('change', '.dropdawn_class', function() {
      const taget_account = $(this).val();//we get value of select input
      const json_taget_account = JSON.parse(taget_account);//convert the string to json
      //change value of account fun
      $(this).closest('tr').children('td#quantity_model_id').children('input').val(json_taget_account.total_quantity);
      autoCalcSetup();
    });
   

   

        console.log(warehousedetail);


      });
      
    </script>
@endsection