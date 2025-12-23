           

<div class="" id="test">
     <div class="form-group" >
                <label class="col-lg-6 col-form-label">Truck </label>

                <div class="col-lg-12">
                    <select class="form-control m-b truck_id" name="truck_id"  id="truck" required>
                                                      
                                                        <option value="">Select Truck</option>
                                                                        @if(!empty($truck))
                                                        @foreach($truck as $row)

                                                        <option @if(isset($data))
                                                            {{  $data->truck_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{ $row->id}}">{{$row->reg_no}} </option>

                                                        @endforeach
                                                        @endif


                                                    </select>
                </div>
  <p class"errors" id="errors" style="color:red;"></p>
            </div> 

        </div>
      
@yield('scripts')
<script>
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
</script>
