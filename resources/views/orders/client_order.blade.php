@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
      <div class="row mt-sm-4">
    
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Welcome User name to make your order</h4>
            </div>
            <div class="padding-20">
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
                                style="width: 186.484px;">Crops Type</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                rowspan="1" colspan="1"
                                aria-label="Engine version: activate to sort column ascending"
                                style="width: 141.219px;">Quantity</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                rowspan="1" colspan="1"
                                aria-label="Engine version: activate to sort column ascending"
                                style="width: 141.219px;">Region</th>

                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                rowspan="1" colspan="1"
                                aria-label="Engine version: activate to sort column ascending"
                                style="width: 141.219px;">Destrict</th>
        
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                rowspan="1" colspan="1"
                                aria-label="CSS grade: activate to sort column ascending"
                                style="width: 98.1094px;">Actions</th>
                        </tr>
                        <tr>
                          <th><input type="text" name='state.warehouse' class="form-control" id="warehouseid" placeholder="search by warehouse"></th>
                          <th> <input type="text"  name='crop_type' class="form-control" id="crop_typeid" placeholder="search by Crops Type"></th>
                          <th> <input type="number"  name='quantity' class="form-control" id="quantityid" placeholder="search by Quantity"></th>
                          <th> <input type="text" name='region' class="form-control" id="regionid" placeholder="search by Region"></th>
                          <th> <input type="text" name='destrict' class="form-control" id="destrictid" placeholder="search by Destrict"></th>
                          <th> </th>
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
      </div>
    </div>

    
    <div class="modal inmodal" id="makeOrderForm" tabindex="-1" role="dialog" >
      <div class="dealogbox">
     <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Order Form</h5>
                      <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                        <span  >&times;</span>
                      </button>
                    </div>
           
                        <div class="card-body">
                          <input type="hidden"  name='warehouseid' class="form-control" id="warehouseid_id">
                          <input type="hidden"  name='cropy_type' class="form-control" id="crop_type_id">
                          <input type="hidden"  name='region_name' class="form-control" id="region_name_id">
                          <input type="hidden"  name='district_name' class="form-control" id="district_name_id">
              <div class="form-group col-md-12 col-lg-12 col-xl-12">
                 <label for="orderquantity">Quantity in Kilogram(Kg)</label>
                  <input type="number"  name='orderquantity' class="form-control" id="orderquantityid" placeholder="Enter Quantity in Kilogram(Kg)">
                     
              </div>
              <div class="form-group col-md-12 col-lg-12 col-xl-12">
                  <label for="offerAmount">Offer Amount</label>
                   <input type="number" name='offerAmount' class="form-control" id="offerAmount_id" placeholder="Offer Amount in Tsh">
               </div>
               <div class="form-row">
                <div class="form-group col-md-12 col-lg-12">
                    <label for="warehouselocation">Destination Location</label>
              </div>
              <div class="form-group col-md-6 col-lg-6">
              <label for="selectRegion">Region</label>
              <select id="selectRegionid" name="selectRegion" class="form-control" placeholder="Select Region">
                  <option value="" selected="">Select Region</option>
              </select>
              </div>
                <div class="form-group col-md-6 col-lg-6">
                  <label for="district">District</label>
                  <select  id="selectDistrictid" name="district" class="form-control">
                    <option value="" selected="">Select District</option>
                  </select>
                </div>
             </div>
              <div class="form-row">
                 <div class="form-group col-md-12 col-lg-12">
                  <button type="submit" id="submit_order_id" value="" name="save" class="btn btn-block btn-primary">Submit Order</button>
                </div>
              </div>
            </div>
              
                  </div>
                </div>
      </div>
  </div>
    
  </section>
  {{-- <create-Order-form-component></create-Order-form-component> --}}
  @endsection


  @section('scripts')
  <script >
  $(document).ready(function(){
    $('.table').DataTable();//its make all tables in this page to be data table
    var selectRegionElement = document.getElementById("selectRegionid"),
  selectDistrictElement = document.getElementById("selectDistrictid");
    getWarehouseDetails();//get warehouses data
    function getWarehouseDetails(){
      let url = '{{route("manipulation.index")}}';
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
           console.log(response);
          //adding row to the account table
       
          $('#table-1').DataTable().clear();
          $.each(response.accounts,function(key,data){
            const warehouse_details = JSON.stringify(data)
            $('#table-1').DataTable().row.add([
              data.warehouse.warehouse_name,
              data.crops_type.crop_name,
              data.total_quantity,
              data.warehouse.region.name,
              data.warehouse.district.name,
              '<button class="btn btn-xs btn-success order"  value=\''+warehouse_details+'\' data-toggle="modal"   data-target="#makeOrderForm" href="#">Order</button>',
            ]).draw();
              });

            // selectDistrictElement.length = 1; // remove all options bar first
           selectRegionElement.length = 1; // remove all options bar first
          //control selection of region and destrict
          $.each(response.regions,function(key,region){
            $('#selectRegionid').append('<option value="'+region.name+'">\
                                       '+region.name+'\
                                  </option>');
           });

          
          //  function called when selecting region 
          selectRegionElement.onchange = function () {
            selectDistrictElement.length = 1;
            if (this.selectedIndex < 1) return; // done
            const new_reg = response.regions.filter(data => data.name == selectRegionElement.value);
            $.each(new_reg[0].districts,function(key,district){
            $('#selectDistrictid').append('<option value="'+district.name+'">\
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
        $(document).on('click','.order',function(e){
          e.preventDefault();
          const warehouse_id = $(this).val()
          const json_warehouse_details = JSON.parse(warehouse_id)
          // alert(json_warehouse_details.warehouse_id);
        $('#warehouseid_id').val(json_warehouse_details.warehouse_id);
        $('#crop_type_id').val(json_warehouse_details.crops_type_id);
        $('#region_name_id').val(json_warehouse_details.warehouse.region.name);
        $('#district_name_id').val(json_warehouse_details.warehouse.district.name);
        });

         //function called on event of withdraw
      $(document).on('click','#submit_order_id',function(e){
          e.preventDefault();
          //data used on adding insurance
          var ordersData = {
            "type":"makeorder",
            "warehouse_id":$('#warehouseid_id').val(),
            "crop_type":$('#crop_type_id').val(),
            "start_location":$('#district_name_id').val()+", "+$('#region_name_id').val(),
            "end_location":$('#selectDistrictid').val()+", "+$('#selectRegionid').val(),
            "route_type":1,
            "offer_amount":$('#offerAmount_id').val(),
            "quantity":$('#orderquantityid').val(),
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
            url:'{{ route("manipulation.store") }}',
            data:ordersData,
            dataType:"json",
            success:function(response){
              // getAccountsData();//reload account data
              $('#makeOrderForm').modal('hide');//it hide modal
                 Swal.fire({
                icon: 'success',
                title: response,
                showConfirmButton: false,
                timer: 1500
              });
              $('#makeOrderForm').find('input').val("");//it clear input in modal
              console.log(response);
            },
            error: function(response) {
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
              })
                console.log(response);
            }
          }) ;

        });
  
  
  });

   
</script>
@endsection