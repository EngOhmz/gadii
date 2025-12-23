@extends('layouts.master')

@section('content')

<div class="card">
    
        <form name="contact" method="post" id="contactForm">
           @csrf
           <div class="alert alert-success d-none" id="msg_div">
            <span id="res_message"></span>
           </div>
           <div class="card-header">Please fill up all the Field's.</div>
           <div class="card-body">
              <div class="row">
                 <div class="col-md-6">
                    <label for="Name"> Name :</label>
                    <input type="text" class="form-control" id="name" placeholder="Please enter name" required>
                 </div>
                 <div class="col-md-6">
                    <label for="Email">Email :</label>
                    <input type="email" class="form-control" id="email" placeholder="Please enter email" required>
                 </div>
                 <div class="col-md-6">
                    <label for="Phone">Phone :</label>
                    <input type="number" class="form-control" id="phone" placeholder="Please enter phone" required>
                 </div>
                 <div class="col-md-6">
                    <label for="Address">Message :</label>
                    <input type="text" class="form-control" id="message" placeholder="Please enter address" required>
                 </div>
              </div>
           </div>
           <div class="col-md-3">
              <button type="submit" class="btn btn-block btn-info btn-sm">Save</button>
           </div>
           <br/>
     </div>
     </form>
  </div>

<script>
    $('#contactForm').on('submit',function(event){
        // event.preventDefault();
        // Get Alll Text Box Id's
        name = $('#name').val();
        email = $('#email').val();
        phone = $('#phone').val();
        message = $('#message').val();
     
        $.ajax({
          url: "{{url('order')}}", //Define Post URL
          method:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            name:name,
            email:email,
            phone:phone,
            message:message,
          },
          //Display Response Success Message
          success: function(response){
          $('#res_message').show();
            $('#res_message').html(response.msg);
            $('#msg_div').removeClass('d-none');
     
            document.getElementById("contactForm").reset();
            setTimeout(function(){
            $('#res_message').hide();
            $('#msg_div').hide();
            },4000);
       },
      });
    });
    </script>
@endsection