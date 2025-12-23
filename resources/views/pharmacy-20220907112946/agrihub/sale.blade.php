@extends('layouts.master')

@section('content')

<section class="section">
<h3>Sales Form </h3>
<div class="card">
   <form name="" method="post" id="salesForm">
      @csrf
      <div class="alert alert-success d-none" id="msg_div">
       <span id="res_message"></span>
      </div>
      <div class="card-header">Please fill up all the Field's.</div>
      <div class="card-body">
         <div class="row">
            <div class="col-md-2 col-lg-2 col-sm-2">
               <label for="Price">Farmer Name:</label>
               <select class="form-control select2" id='farmer'  name='farmer'>
                  <option selected="selected" disabled="disabled">Select Farmer</option>
                  @if(count($farmer)>0)
                     @foreach($farmer as $farmers)
                        <option  value='{{$farmers->id}}'>{{$farmers->firstname}} {{$farmers->lastname}}</option>
                     @endforeach
                  @endif
                
               </select>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-2">
               <label for="Name">Select Product :</label>

               <select class="form-control select2" id='product' onchange="data(this.value)" name="product">
                  <option selected="selected" disabled="disabled">Select product</option>
                  @if(count($product)>0)
                     @foreach($product as $prod)
                      
                        <option  data-price="{{$prod->sellprice}}" value='{{$prod->id}}'>{{$prod->name}}</option>
                     @endforeach
                  @endif
                
               </select>
            </div>
        
            <div class="col-md-2 col-lg-2 col-sm-2">
               <label for="Price">Price:</label>
               <input type="text" class="form-control" id="price" placeholder="Enter Amount" required>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-2">
               <label for="Quantity">Quantity:<p id="priced"></p></label>
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
       <th>Farmer</th>
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
               url: '{{url('get/sales')}}',
               dataType: 'json',
               success: function(response) 
               {
                   //console.log(response.userdata)
                   var data=response.userdata;
                   var data2=response.product;
                   var data3=response.farmer;
                   $('#records_table > tbody').empty();
                   var trHTML = '';
                   var total=0;
                   for(var i=0;i<data.length;i++)
                   {
                      
                      total+=Number((data[i].sale)*(data[i].cost));
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
                              product=products.name;
                           }
                        }
                        );
                 $.each(data3, function(s, farmers)
                        {
                           if(farmers.id==item.farmer_id)
                           {
                              farmer=farmers.firstname+" "+farmers.lastname ;
                           }
                        }
                        );
                       trHTML += '<tr>' +
                           '<td>' + (1+i) + '</td>' +
                           '<td>' + farmer + '</td>' +
                           '<td>' + product + '</td>' +
                           '<td>' + item.sale + '</td>' +
                           '<td>' + item.cost + '</td>' +
                           '<td >' + item.sale*item.cost + '</td>' +
                           '<td>' + item.payment + '</td>' +
                           '<td ><button  class="btn btn-danger" onClick=deletedata('+item.id+','+item.product_id+','+item.sale+')><i class="fas fa-big fa-trash-alt" ></i></button>' +  '</td>' +
                           '</tr>';
                   }
                   );
                   $('#records_table > tbody').append(trHTML);
                   
               }
            


            }
         );
    }
  
   
    $('#salesForm').on('submit', function(event) 
    {
                        event.preventDefault();
                        // Get Alll Text Box Id's
                        farmer_id= $('#farmer').val();
                        product_id= $('#product').val();
                        sale= $('#amount').val();
                        cost= $('#price').val();
                        payment=$('#payment').val();


               $.ajax({
               url: "{{url('sales/add')}}", //Define Post URL
               type: "POST",
               data: {
                  "_token": "{{ csrf_token() }}",
                  farmer_id:farmer_id,
                  product_id: product_id,
                  sale: sale,
                  cost: cost,
                  payment:payment,
                  
               },
               //Display Response Success Message
               cache: false,

               success: function(response) {
                  //$('#res_message').show();
                  //$('#res_message').html(response.msg);
                  //$('#msg_div').removeClass('d-none');
               
                  document.getElementById("salesForm").reset();
                  setTimeout(function() {
                     $('#res_message').hide();
                     $('#msg_div').hide();
                  }, 4000);
                  
                  //swal("Good job!", "You clicked the button!", "success");

                  fetch_data();
                  
               },
               });
 



               }
               );

               function deletedata(dat,product,sale)
               {

                  var id=dat;
                  var product_id=product;
                  event.preventDefault();
                  $.ajax(
                        {
                          
                           url: "sales/"+id+"/"+product_id+"/"+sale+"/delete", //Define Post URL
                              type: "GET",
                             
                              //Display Response Success Message
                              cache: false,
                           success: function(response) 
                           {
                              if(response.status)
                              {
                                  //console.log(response.msg);
                   //$('#res_message').show();
                  $('#res_message').html(response.msg);
                  $('#msg_div').removeClass('d-none');
               
                  
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
                          
                           url: "sales/{{Auth::user()->id}}/update", //Define get URL
                              type: "GET",
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
                                   swal("Sales data was successful saved", "", "success");
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
                                 
                                 document.getElementById("price").value =products.sellprice;
                    
                                    }); 
                                 
                             
                              
                           },
                        }
                        
                     );
   
}         

           
   
</script>
@endsection