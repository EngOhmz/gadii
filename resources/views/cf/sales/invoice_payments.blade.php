
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Invoice Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
             
              {!! Form::open(['route' => 'save.cf_details', 'enctype' => 'multipart/form-data']) !!}
                @method('POST')

            <input type="hidden" name="project_id" value="{{ $invoice->cf_id }}">
            <input type="hidden" name="type" value="invoice_payment">
            
        <div class="modal-body">
                               

            <div class="card-body">
            <div class="row">
             <div class="col-sm-12 ">                             
                                            
                 <div class="form-group row">

                                    <label class="col-lg-2 col-form-label">Amount
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="number" name="amount" value="{{ $invoice->due_amount}}" min="1" max="{{ $invoice->due_amount}}" class="form-control">

                                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}" class="form-control">
                                    </div>
                                </div>


                                <div class="form-group row"><label class="col-lg-2 col-form-label">Payment Date</label>

                                    <div class="col-lg-10">
                                        <input type="date" name="date" value="{{ date('Y-m-d')}}" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group row"><label class="col-lg-2 col-form-label">Payment
                                        Method</label>

                                    <div class="col-lg-10">
                                        <select class="form-control m-b" name="payment_method">
                                            <option value="">Select
                                            </option>
                                            @if(!empty($payment_method))
                                            @foreach($payment_method as $row)
                                            <option value="{{$row->id}}">From {{$row->name}}</option>

                                            @endforeach
                                            @endif
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row"><label class="col-lg-2 col-form-label">Notes</label>

                                    <div class="col-lg-10">
                                        <textarea name="notes" class="form-control"></textarea>
                                    </div>
                                </div>



                              
                                <div class="form-group row"><label  class="col-lg-2 col-form-label">Bank/Cash Account</label>

                                    <div class="col-lg-10">
                                       <select class="form-control m-b" name="account_id" required>
                                    <option value="">Select Payment Account</option> 
                                          @foreach ($bank_accounts as $bank)                                                             
                                            <option value="{{$bank->id}}">{{$bank->account_name}}</option>
                                               @endforeach
                                              </select>
                                    </div>
                                </div>

                                  
 


 
                            
     
    


                 
               
         </div>     
        </div>
  </div>


</div>
        <div class="modal-footer bg-whitesmoke br">
         <button class="btn btn-primary"  type="submit" id="save"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>


      {!! Form::close() !!}

            </div>
            
            
            
@yield('scripts')            
             <script>
        $(document).ready(function() {
            /*
             * Multiple drop down select
             */
            $('.m-b').select2({
                width: '100%',
            });



        });
    </script>
       