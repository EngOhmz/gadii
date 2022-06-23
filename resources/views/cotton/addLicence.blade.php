<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Add Insurance</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
           <form id="addLicenceForm" method="post" action="javascript:void(0)">
            @csrf
        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

 <div class="form-row">
              <div class="form-group col-md-6 col-lg-6 col-xl-6">
                <label for="insurancename">Insurance Company</label>
                <input type="text" name='insurancename' class="form-control" id="insurancenameid" placeholder="">
                    @error('insurancename')
                <div class="text-danger">{{$message }}</div>
                @enderror
              </div>
              <div class="form-group col-md-6 col-lg-6 col-xl-6">
                <label for="insuranceamount">Insurance Amount</label>
                <input type="text" name='insuranceamount' class="form-control" id="insuranceamountid" placeholder="">
                    @error('insuranceamount')
                <div class="text-danger">{{$message }}</div>
                @enderror
              </div>
            </div>
            <div class="form-group col-md-12 col-lg-12 col-xl-12">
              <label for="assetvalue">Asset Value</label>
              <input type="text" name='assetvalue' class="form-control" id="assetvalueid" placeholder="">
                  @error('assetvalue')
              <div class="text-danger">{{$message }}</div>
              @enderror
            </div>
            <div class="form-group col-md-12 col-lg-12 col-xl-12">
                  <label for="insurancetype">Insurance Type</label>
                  <select name="insurancetype" id="insurancetypeid" class="form-control">
                      <option value=''>Select Insurance Type</option>
                      <option value='private'>Compressive</option>
                      <option value="hired">Third Part</option>
                  </select>
                </div>
            <div class="form-group col-md-12 col-lg-12 col-xl-12">
              <label for="coveringage">Covering Age (Year)</label>
              <input type="number" name='coveringage' class="form-control" id="coveringageid" placeholder="">
                  @error('coveringage')
              <div class="text-danger">{{$message }}</div>
              @enderror
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 col-lg-6 col-xl-6">
                  <label for="startdate">Start Date</label>
                  <input type="date" name='startdate' class="form-control" id="startdateid" placeholder="Starting date">
                  
                </div>
                <div class="form-group col-md-6 col-lg-6 col-xl-6">
                  <label for="enddate">End Date</label>
                  <input type="date" name='enddate' class="form-control" id="enddateid" placeholder="Ending date">
                </div>
              </div>
                                                    </div>


        </div>
 </div>
              </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary" id="save" onclick=" saveLicence(this)" data-dismiss="modal">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


       </form>


    </div>
</div>

<script>    

</script> 