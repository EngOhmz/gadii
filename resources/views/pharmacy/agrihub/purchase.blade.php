@extends('layouts.master')

@section('content')

<section class="section">
<h3>Purchase Form </h3>
<div class="card">
   <form name="contact" method="post" id="purchaseForm">
      @csrf
      <div class="alert alert-success d-none" id="msg_div">
       <span id="res_message"></span>
      </div>
      <div class="card-header">Please fill up all the Field's.</div>
      <div class="card-body">
         <div class="row">
            <div class="col-md-2 col-lg-2 col-sm-2">
               <label for="Price">Supplier Name:</label>
               <select class="form-control select2" id='supply'  name='supply'>
                  <option selected="selected" disabled="disabled">Select Supplier</option>
                  @if(count($supply)>0)
                     @foreach($supply as $sup)
                      
                        <option  value='{{$sup->id}}'>{{$sup->name}}</option>
                     @endforeach
                  @endif
                
               </select>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-2">
               <label for="Name">Select Product :</label>
               <select class="form-control select2" id='product' onchange="data(this.value)"  name='product'>
                  <option selected="selected" disabled="disabled">Please Select product</option>
                  @if(count($product)>0)
                     @foreach($product as $prod)
                        <option  data-price="{{$prod->buyprice}}" value='{{$prod->id}}'>{{$prod->name}}</option>
                     @endforeach
                  @endif
                
               </select>
            </div>
        
            <div class="col-md-2 col-lg-2 col-sm-2">
               <label for="Price">Price:</label>
               <input type="text" class="form-control" id="price" placeholder="Enter Amount" required>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-2">
               <label for="Quantity">Quantity:</label>
               <input type="number" class="form-control" id="amount" placeholder="Enter Amount" required>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-2">
               <label for="Name">Select Payment:</label>
               <select class="form-control" id='payment'  name='payment'>
                  <option selected="selected" disabled="disabled">Select payment</option>
                  <option value="cash">Cash</option>
                  <option value="loan">Loan</option>
                  <option value="grant">Grant</option>
                
               </select>
            </div>
      
      <div class="col-md-2 col-lg-2 col-sm-2">
         <label for="Phone"></label>
         <button type="submit" class="btn btn-icon icon-left btn-primary form-control">Add <i  class="fas fa-plus"></i></button>
      </div>
         </div>
      <br/>

</form>


@if ($message = Session::get('success'))
   <div class="alert alert-success">
       <p>{{ $message }}</p>
   </div>
@endif
<div class="row">
   <div class="col-lg-5 col-xl-5 col-md-5"></div>
   <div class="col-lg-4 col-xl-4 col-md-4 col-12">
   <p style="font-size: 20px;align:left:color:black">Total Cost:  <b id="out"></b> Tshs</p>
   </div>
   <div class="col-lg-3 col-xl-3 col-md-3"><input type="submit" value="Save Purchase" onClick="update()"  class="btn btn-icon icon-left btn-primary "></div>
</div>
<table id="records_table" class="table table-bordered table-sm">
  <thead>
   <tr>
       <th>S/N</th>
       <th>Supplier</th>
       <th>Product</th>
       <th>Quantity</th>
       <th>Price</th>
     <th>Cost</th>
     <th>Payment</th>
       <th>remove</th>
   </tr>
  </thead>
  <tbody id="tablebody">

  </tbody>  
</table>

<script type = "text/javascript" >





   fetch_data();
   $('#records_table > tbody').append("");
   function fetch_data() 
     {
   $.ajax(
             {
               type: 'GET',
               url: '{{url('get')}}',
               dataType: 'json',
               success: function(response) 
               {
                   //console.log(response.userdata)
                   var data=response.userdata;
                   var data2=response.product;
                   var data3=response.supply;
                   $('#records_table > tbody').empty();
                   var trHTML = '';
                   var total=0;
                   for(var i=0;i<data.length;i++)
                   {
                      
                      total+=Number((data[i].purchase)*(data[i].cost));
                   }
                   var outpu=total;
                   document.getElementById('out').innerHTML=outpu;

                   $.each(data, function(i, item)
                    {   var name;
                        var dat=item.product_id;
                        $.each(data2, function(d, products)
                        {
                           if(products.id==item.product_id)
                           {
                              name=products.name;
                           }
                        }
                        );
                 $.each(data3, function(s, supplies)
                        {
                           if(supplies.id==item.supply_id)
                           {
                              supplier=supplies.name;
                           }
                        }
                        );
                       trHTML += '<tr>' +
                           '<td>' + (1+i) + '</td>' +
                           '<td>' + supplier+ '</td>' +
                           '<td>' + name + '</td>' +
                           '<td>' + item.purchase + '</td>' +
                           '<td>' + item.cost + '</td>' +
                           '<td >' + item.purchase*item.cost + '</td>' +
                           '<td>' + item.payment + '</td>' +
                           '<td ><button  class="btn btn-danger" onClick=deletedata('+item.id+','+item.product_id+','+item.purchase+')><i class="fas fa-big fa-trash-alt" ></i></button>' +  '</td>' +
                           '</tr>';
                   }
                   );
                   $('#records_table > tbody').append(trHTML);
                   
               }
            


            }
         );
    }
  
   
    $('#purchaseForm').on('submit', function(event) 
    {
                        event.preventDefault();
                        // Get Alll Text Box Id's
                        product_id= $('#product').val();
                        cost= $('#price').val();
                        purchase= $('#amount').val();
                        supplier=$('#supply').val();
                        payment=$('#payment').val();


               $.ajax({
               url: "{{url('input/add')}}", //Define Post URL
               type: "POST",
               data: {
                  "_token": "{{ csrf_token() }}",
                  product_id: product_id,
                  purchase: purchase,
                  cost: cost,
                  supply_id:supplier,
                  payment:payment,
                  
               },
               //Display Response Success Message
               cache: false,

               success: function(response) {
                  //$('#res_message').show();
                  //$('#res_message').html(response.msg);
                  //$('#msg_div').removeClass('d-none');
               
                  document.getElementById("purchaseForm").reset();
                  setTimeout(function() {
                     $('#res_message').hide();
                     $('#msg_div').hide();
                  }, 4000);
                  
               
                  fetch_data();
               },
               });
 



               }
               );
               function deletedata(dat,product,purchase)
               {

                  var id=dat;
                  var product_id=product;
                  event.preventDefault();
                  $.ajax(
                        {
                          
                           url: "order/"+id+"/"+product_id+"/"+purchase+"/delete", //Define Post URL
                              type: "GET",
                             
                              //Display Response Success Message
                              cache: false,
                           success: function(response) 
                           {
                              if(response.status)
                              {
                                  //console.log(response.msg);
                   //$('#res_message').show();
                  //$('#res_message').html(response.msg);
                 // $('#msg_div').removeClass('d-none');
               
                  
                  setTimeout(function() {
                     $('#res_message').hide();
                     $('#msg_div').hide();
                  }, 4000);
                                  fetch_data();
                              }
                             
                              
                           },
                        }
                        
                     );
                     
                   
               }
               
      function update()
      {
         event.preventDefault();
         $.ajax(
                        {
                          
                           url: "order/{{Auth::user()->id}}/update", //Define Post URL
                              type: "POST",
                              data: {
                                 "_token": "{{ csrf_token() }}",
   
                              },
                              //Display Response Success Message
                              cache: false,
                           success: function(response) 
                           {
                              if(response.status)
                              {
                                 
                                  //console.log(response.msg);
                                  $('#records_table > tbody').empty();
                                  document.getElementById('out').innerHTML="";
                                  swal("Purchase data was saved successful!", "", "success");
                              }
                             
                              
                           },
                        }
                        
                     );
                     
      }
      function data(price)
{
   event.preventDefault();
   $.ajax(
                        {
                          
                           url: "purchase/"+price+"/product", //Define Post URL
                              type: "get",
                              data: {
                                 "_token": "{{ csrf_token() }}",
   
                              },
                              //Display Response Success Message
                              cache: false,
                           success: function(response) 
                           {
                              $.each(response.product, function(d, products)
                                  {
                                 
                                 document.getElementById("price").value =products.buyprice;
                    
                                    }); 
                                 
                             
                              
                           },
                        }
                        
                     );
   
}         
              
</script>
@endsection