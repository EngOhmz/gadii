<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Reverse Top up to Bank/Cash Account</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
           {{ Form::open(['url' => url('newreverseOperator')]) }}
       @method('POST')
            @csrf

        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

                                 <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Reference </label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="reference" 
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->reference : ''}}"
                                                            class="form-control ">
                                                    </div>
                                          
                                                </div>


 <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="date" required
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->date: ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                               
                                               <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Amount</label>
                                                    <div class="col-lg-8">
                                                        <input type="number" name="amount" required
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->amount : ''}}"
                                                            class="form-control reverse_amount">
                                                    </div>
                                      <div class=""> <p class="form-control-static" id="errors" style="text-align:center;color:red;"></p>   </div> 
                                                </div>

 
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Payment
                                                    Method</label>
            
                                                <div class="col-lg-8">
                                                    <select class="m-b" name="payment_method" id="select-payment" required>
                                                        <option value="">Select
                                                        </option>
                                                        @if(!empty($payment_method))
                                                        @foreach($payment_method as $row)
                                                        <option value="{{$row->id}}" @if(isset($data))@if($data->
                                                            payment_method == $row->id) selected @endif @endif >From
                                                            {{$row->name}}
                                                        </option>
            
                                                        @endforeach
                                                        @endif
                                                    </select>
            
                                                </div>
                                            </div>

                                <div class="form-group row"><label  class="col-lg-2 col-form-label">Bank/Cash Account</label>

                                                    <div class="col-lg-10">
                                                       <select class="m-b" id="to_account_id" name="to_account_id" required>
                                                    <option value="">Select Payment Account</option> 
                                                          @foreach ($bank_accounts as $bank)                                                             
                                                            <option value="{{$bank->id}}" @if(isset($data))@if($data->account_id == $bank->id) selected @endif @endif >{{$bank->account_name}}</option>
                                                               @endforeach
                                                              </select>
                                                    </div>
                                                </div>


                                 <div class="form-group row"><label class="col-lg-2 col-form-label">Notes</label>

                                    <div class="col-lg-10">
                                        <textarea name="notes" 
                                            class="form-control"></textarea>
                                    </div>
                                </div>

                  <input type="hidden" name="id" required id="operator"
                                                            placeholder=""
                                                            value="{{$id}}"
                                                            class="form-control">
               
              </div>
</div>
                                                    </div>


        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary" id="reverse_save">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


       </form>


    </div>
</div>
<script>
    $(document).ready(function() {
        
        new TomSelect("#to_account_id",{
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
        new TomSelect("#select-payment",{
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    }); 
    </script>  


