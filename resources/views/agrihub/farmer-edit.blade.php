@extends('layouts.master')

@section('content')

  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>2 Column</h4>
            </div>
            <div class="card-body">
              <div class="row">
               
                <div class="col-12 col-sm-12 col-lg-10 col-xl-10 col-md-10">
                 
                    
                     
                        <div class="card-body p-0">
                          <form class="form" method="post" action="{{url('farmer/update',$farmer->id)}}">
                            {{ csrf_field() }}
                              <div class="card-body">
                                <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="inputEmail4">FirstName</label>
                                  <input type="text" name='firstname' value="{{$farmer->firstname}}" class="form-control" id="inputEmail4" placeholder="">
                                      @error('firstname')
                                <div class="text-danger">{{$message }}</div>
                            @enderror
                                </div>
                          
                                <div class="form-group col-md-6">
                                  <label for="inputPassword4">LastName</label>
                                  <input type="text" value="{{$farmer->lastname}}" name='lastname' class="form-control" id="inputPassword4" placeholder="">
                                   @error('lastname')
                                <div class="text text-danger">{{$message }}</div>
                            @enderror
                                </div>
                            
                                </div>
                                <div class="form-row">
                                 <div class="form-group col-md-6 col-lg-6">
                                  <label for="inputAddress">Phone number</label>
                                  <input type="text" name='phone' value="{{$farmer->phone}}" class="form-control" id="inputAddress" placeholder="">
                                  @error('phone')
                                  <div class="text text-danger">{{$message }}</div>
                              @enderror 
                                </div>
                                  <div class="form-group col-md-6 col-lg-6">
                                  <label for="inputAddress">Email</label>
                                  <input type="email" name='email' value="{{$farmer->email}}" class="form-control" id="inputAddress" placeholder="example@example.com (optional)">
                                  </div>
                                </div>
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="inputState">Region</label>
                                    <select  id="selectRegionid" name="region_id" class="form-control region">
                                      <option ="">Select region</option>
                                      @if(!empty($region))
                                                        @foreach($region as $row)

                                                        <option @if(isset($farmer))
                                                            {{ $farmer->region_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>

                              <div class="form-group col-md-6">
                                    <label for="inputState">District</label>
                                    <select id="selectDistrictid" name="district_id" class="form-control">
                                      <option>Select district</option>
                                    @if(!empty($district))
                                                        @foreach($district as $row)

                                                        <option @if(isset($farmer))
                                                            {{ $farmer->district_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>
                             </div>

                                  <div class="form-group col-md-6">
                                    <label for="inputCity">Physical Address</label>
                                    <input type="text" name="address" value="{{$farmer->address}}" class="form-control" id="inputCity">
                                    @error('address')
                                    <div class="text text-danger">{{$message }}</div>
                                @enderror
                                  </div>
                                </div>
                                <div class="form-row">
                                  <div class="form-group col-md-12 col-lg-12 col-sm-12">
                                    <label for="inputState">Group</label>
                                    <select id="inputState" name="group_id" class="form-control">
                                      <option value="0" selected="">Select group</option>
                                    @if(count($group)>0)
                                    @foreach($group as $group)
                                      <option value="{{$group->id}}" @if(isset($data))
                                                            {{ $farmer->group_id == $group->id ? 'selected' : ''}}
                                                            @endif >{{$group->name}}</option>
                                    @endforeach
                                    @endif
                                    </select>
                                  </div>
                                  </div>
                                <!--
                                <div class="form-row">
                                  <div class="form-group col-md-6 col-lg-6">
                                  <label for="inputState">Region</label>
                                  <select id="inputState" class="form-control">
                                  <option selected="">Choose...</option>
                                  <option>...</option>
                                  </select>
                                  </div>
                                  <div class="form-group col-md-6 col-lg-6">
                                  <label for="inputCity">Physical Address</label>
                                  <input type="text" class="form-control" id="inputCity">
                                  </div>
                                </div>
                              -->
                              <div class="form-row">
                                <div class="form-group col-md-6 col-lg-6">
                        
                          <input type="submit" value="Update" name="save" class="btn btn-lg btn-primary">
                        </div>
                                </div></div>
                      </form>
                        </div>
                      
                     
                    
                 
                  
                  
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
    </div>
  </section>

<script>
$(document).ready(function() {

    $(document).on('change', '.region', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("findRegion")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#selectDistrictid").empty();
                $("#selectDistrictid").append('<option value="">Select district</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#selectDistrictid").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });


});
</script>
@endsection