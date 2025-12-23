    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Assign Location & WBN</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
           
              <form id="addAssignForm" role="form" enctype="multipart/form-data" action="{{route('courier.assign_wbn')}}"  method="post" >
            @csrf
        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

 

                                 <div class="form-group row">
                                      <label class="col-lg-2 col-form-label" for="inputState">Arrival Region</label>
                                   <div class="col-lg-4">
                                    <select name="to_region_id" class="form-control m-b to_region" id="to_region_id" required>
                                      <option value="">Select Arrival Region</option>
                                      @if(!empty($region))
                                                        @foreach($region as $row)

                                                        <option @if(isset($old))
                                                            {{ $old->to_region_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>

                     
            @if(!empty($old))
                    
                                    <label for="inputState"  class="col-lg-2 col-form-label">Arrival District</label>
                                 <div class="col-lg-4">
                                    <select name="to_district_id" class="form-control m-b to_district" id="to_district_id">
                                      <option value="">Select Arrival District</option>
                                    @if(!empty($to_district))
                                                        @foreach($to_district as $row)

                                                        <option @if(isset($old))
                                                            {{ $old->to_district_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>
                 @else
             <label for="inputState"  class="col-lg-2 col-form-label">Arrival District</label>
                                 <div class="col-lg-4">
                                     <select name="to_district_id" class="form-control m-b to_district" id="to_district_id">
                                      <option value="">Select Arrival District</option>
                                    
                                    </select>
                                  </div>
  @endif

                            </div> 


                             <div class="form-group row">
                       <label  class="col-lg-2 col-form-label">Arrival Location</label>

                                                    <div class="col-lg-4">
                                                       <input type="text" name="to_location"  value="{{ isset($old) ? $old->location : ''}}"  class="form-control" >
                                                           
                                                    </div>

                                            <label
                                                            class="col-lg-2 col-form-label">WBN No</label>

                                                        <div class="col-lg-4">
                                                           <input type="text" name="wbn_no" class="form-control" value="{{ isset($old) ? $old->wbn_no : ''}}" required>
                                                        </div>
                                                </div>

                                                      <input type="hidden" name="id"
                                                                class="form-control" value="{{$id}}"> 

                 
               
              </div>
</div>
                                                    </div>


        </div>
         <div class="modal-footer ">
             <button class="btn btn-primary"  type="submit" id="save" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
   


       </form>


    </div>


@yield('scripts')
<script>
            $('.m-b').select2({
                            });

  
</script>

<script>
$(document).ready(function() {

    $(document).on('change', '.to_region', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("fuel/findToRegion")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#to_district_id").empty();
                $("#to_district_id").append('<option value="">Select Arrival District</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#to_district_id").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>
