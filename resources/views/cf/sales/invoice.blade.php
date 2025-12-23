<div class="card-header"> <strong></strong> </div>

<div class="card-body">
    <ul class="nav nav-tabs" id="myTab2" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if (
                $type == 'credit' ||
                    $type == 'details' ||
                    $type == 'calendar' ||
                    $type == 'purchase' ||
                    $type == 'debit' ||
                    $type == 'invoice' ||
                    $type == 'comments' ||
                    $type == 'attachment' ||
                    $type == 'milestone' ||
                    $type == 'tasks' ||
                    $type == 'expenses' ||
                    $type == 'estimate' ||
                    $type == 'notes' ||
                    $type == 'activities' ||
                    $type == 'logistic' ||
                    $type == 'cargo' ||
                    $type == 'storage' ||
                    $type == 'charge') active @endif" id="home-tab2" data-toggle="tab"
                href="#invoice-home2" role="tab" aria-controls="home" aria-selected="true">Invoice
                List</a>
        </li>
                               @if ($type == 'edit-invoice' || $type == 'approve-invoice')
                                <li class="nav-item">
                                    <a class="nav-link @if ($type == 'edit-invoice' || $type == 'approve-invoice') active @endif"
                                        id="profile-tab2" data-toggle="tab" href="#invoice-profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Invoice</a>
                                </li>
                                @endif

                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (
            $type == 'credit' ||
                $type == 'details' ||
                $type == 'calendar' ||
                $type == 'purchase' ||
                $type == 'debit' ||
                $type == 'invoice' ||
                $type == 'comments' ||
                $type == 'attachment' ||
                $type == 'milestone' ||
                $type == 'tasks' ||
                $type == 'expenses' ||
                $type == 'estimate' ||
                $type == 'notes' ||
                $type == 'activities' ||
                $type == 'logistic' ||
                $type == 'cargo' ||
                $type == 'storage' ||
                $type == 'charge') active show @endif " id="invoice-home2"
            role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table datatable-basic table-striped">
                                            <thead>
                                                <tr>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 106.484px;">Ref No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 186.484px;">Client Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 126.484px;">Invoice Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 161.219px;">Amount</th>
                                                    
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 121.219px;">Status</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 168.1094px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!@empty($invoices))
                                                    @foreach ($invoices as $row)
                                                     
                                                      @php $cl= App\Models\Client::find($row->client_id); $dep = App\Models\Departments::find($row->department_id); @endphp  

                                                        <tr class="gradeA even" role="row">

                                                <td><a href="" data-toggle="modal" value="{{ $row->id }}"  data-target="#app2FormModal" onclick="model({{ $row->id }},'invoice')">{{ $row->reference_no }}</a></td>
                                                <td>@if($row->related == 'Clients') {{ $cl->name }} @else {{$dep->name}} @endif</td>

                                                <td>{{ Carbon\Carbon::parse($row->invoice_date)->format('d/m/Y') }}</td>

                                                <td>{{ number_format(($row->invoice_amount + $row->invoice_tax +  $row->shipping_cost)  - $row->discount, 2) }}</td>
                                                           
                                                            <td>
                                                                @if ($row->status == 0)
                                                                <div class="badge badge-danger badge-shadow">Not Approved</div>
                                                                @elseif($row->status == 1)
                                                                    <div class="badge badge-warning badge-shadow">Completed
                                                                @elseif($row->status == 2)
                                                                    <div class="badge badge-success badge-shadow">Approved</div>
                                                                @elseif($row->status == 3)
                                                                    <div class="badge badge-info badge-shadow">Partially Paid
                                                                @elseif($row->status == 4)
                                                                    <div class="badge badge-success badge-shadow">Fully Paid</div>
                                                                
                                                                @endif
                                                            </td>


                                                            <td>
                                                             <?php
                                                   $today = date('Y-m-d');
                                                   $next= date('Y-m-d', strtotime("+1 month", strtotime($row->created_at))) ;
                                                   ?>
                                                   
                                                    <div class="form-inline">
                                                         @if($row->status == 0 || $row->status == 1)
                                                        
                                                        <a class="list-icons-item text-primary" title="Edit"
                                                href="{{ route('edit.cf_details', ['id' => $id,'type' => 'edit-invoice', 'type_id' => $row->id]) }}"><i
                                                    class="icon-pencil7"></i></a>&nbsp
                                            <a class="list-icons-item text-danger" title="Edit"
                                                href="{{ route('delete.cf_details', ['type' => 'delete-invoice', 'type_id' => $row->id]) }}"
                                                onclick="return confirm('Are you sure, you want to delete?')"><i
                                                    class="icon-trash"></i></a>&nbsp
                                                            
                                                            @endif
                                                           

                                                        <div class="dropdown">
                                                        <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>

                                                            <div class="dropdown-menu">
                                                            
                                                              @if ($row->status == 0)
                                                        
                                <a class="nav-link" title="Approve" href="{{ route('cf.approve_invoice', $row->id) }}" onclick="return confirm('Are you sure, you want to complete?')">Complete Invoice</a>
                                                            
                                            @endif 
                                            
                                            
                                                              @if ($row->status == 1)
                                                        
                                <a class="nav-link" title="Approve" href="{{ route('edit.cf_details', ['id' => $id,'type' => 'approve-invoice', 'type_id' => $row->id]) }}" onclick="return confirm('Are you sure, you want to approve?')">Approve Invoice</a>
                                                            
                                            @endif 

                            @if($row->status == 3 || $row->status == 2)
                             <li>
                            <a class="nav-link" href="" data-toggle="modal" value="{{ $row->id }}"  data-target="#app2FormModal" onclick="model({{ $row->id }},'invoice_payment')">Make Payments</a>
                             </li>
                            @endif
                                                                            
  
                            <a class="nav-link" id="profile-tab2" href="{{ route('cf_invoice_pdfview', ['download' => 'pdf', 'id' => $row->id]) }}">Download PDF</a>
                             <a class="nav-link" id="profile-tab2" href="{{ route('cf_invoice_receipt', ['download' => 'pdf', 'id' => $row->id]) }}">Download Receipt</a>
                             
                              @if($row->status == 3 || $row->status == 4)
                 <a class="nav-link"  href="{{ route('cf_invoice_history_pdfview',['download'=>'pdf','id'=>$row->id]) }}"  title="" > Download Payment History </a>
                   @endif 
                   
                    <a class="nav-link" id="profile-tab2" target="_blank" href="{{ route('cf_invoice_print', ['download' => 'pdf', 'id' => $row->id]) }}">Print PDF</a>
                    <a class="nav-link" id="profile-tab2" target="_blank" href="{{ route('cf_receipt_print', ['download' => 'pdf', 'id' => $row->id]) }}">Print Receipt</a>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </td>

                                                        </tr>
                                                    @endforeach

                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade  @if ($type == 'edit-invoice' || $type == 'approve-invoice') active show @endif"
                                    id="invoice-profile2" role="tabpanel" aria-labelledby="profile-tab2">

                                    <div class="card">
                                        <div class="card-header">
                                           @if ($type == 'edit-invoice' || $type == 'approve-invoice')
                                                <h5>Edit Invoice</h5>
                                            @else
                                                <h5>Create Invoice</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                   @if ($type == 'edit-invoice' || $type == 'approve-invoice')

                                {!! Form::open(['route' => 'update.cf_details', 'enctype' => 'multipart/form-data']) !!}
                                <input type="hidden" name="id" value="{{ $type_id }}">
                            @else
                                {!! Form::open(['route' => 'save.cf_details', 'enctype' => 'multipart/form-data']) !!}
                                @method('POST')
                            @endif
                            <input type="hidden" name="project_id" value="{{ $id }}">
                            <input type="hidden" name="type" value="invoice">
                            <input type="hidden" name="receive" value="{{ isset($receive) ? $receive : '' }}">


                                        <input type="hidden" name="edit_type" class="form-control name_type"
                                            value="{{ $type }}" />
                                             <input type="hidden" name="inv_id" class="form-control inv_id"
                                            value="{{ isset($edit_data) ? $type_id : '' }}" />

                                                   
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Invoice Date <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                            <input type="date" name="invoice_date"
                                                                placeholder="0 if does not exist"
                                                                value="{{ isset($edit_data) ? $edit_data->invoice_date : date('Y-m-d') }}"
                                                                class="form-control">
                                                        </div>
                                                        <label class="col-lg-2 col-form-label">Due Date <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                            <input type="date" name="due_date"
                                                                placeholder="0 if does not exist"
                                                                value="{{ isset($edit_data) ? $edit_data->due_date : strftime(date('Y-m-d', strtotime('+10 days'))) }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                    

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Sales Agent <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                            @if (!empty($edit_data->user_agent))

                                                                <select class="form-control m-b" name="user_agent"
                                                                    id="user_agent" required>
                                                                    <option value="{{ old('user_agent') }}" disabled
                                                                        selected>Select User</option>
                                                                    @if (isset($users))
                                                                        @foreach ($users as $row)
                                                                            <option
                                                                                @if (isset($edit_data)) {{ $edit_data->user_agent == $row->id ? 'selected' : 'TZS' }} @endif
                                                                                value="{{ $row->id }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            @else
                                                                <select class="form-control m-b" name="user_agent"
                                                                    id="user_agent" required>
                                                                    <option value="{{ old('user_agent') }}" disabled
                                                                        selected>Select User</option>
                                                                    @if (isset($users))
                                                                        @foreach ($users as $row)
                                                                            @if ($row->id == auth()->user()->id)
                                                                                <option value="{{ $row->id }}"
                                                                                    selected>{{ $row->name }}</option>
                                                                            @else
                                                                                <option value="{{ $row->id }}">
                                                                                    {{ $row->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>


                                                            @endif
                                                        </div>
                                                        
                                                        <label class="col-lg-2 col-form-label">Branch</label>
                                                            <div class="form-group col-md-4">
                                                                <select class="form-control m-b" name="branch_id">
                                                                    <option>Select Branch</option>
                                                                    @if (!empty($branch))
                                                                        @foreach ($branch as $row)
                                                                            <option value="{{ $row->id }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                    </div>
                                                    
                                                   
                                                    
                                                     <div class="form-group row">
                                                     <label class="col-lg-2 col-form-label">Notes</label>

                                                        <div class="col-lg-10">
                                                    <textarea name="notes" class="form-control" rows="4">{{ isset($edit_data) ? $edit_data->notes : '' }}</textarea>
                                                        </div>
                                                    </div>


                                                        


                                                    <br>
                                                    <h4 align="center">Enter Item Details</h4>
                                                    <hr>
                                
                                                     <div class=""> <p class="form-control-static item_ierrors" id="ierrors" style="text-align:center;color:red;"></p>   </div>
                                                    <button type="button" name="add"
                                                        class="btn btn-success btn-xs iadd"><i class="fas fa-plus"></i> Add
                                                            item</button><br>
                                                    <br>
                                              <div class="table-responsive">
                                        
                                        <div class="icart" id="icart">
                                        
                                        <div class="row body">
                                        
                                        
                                        </div>
                                        </div>
                                        
                                        
                                        
                                        <br>

<div class="icart1" id="icart1">
<div class="row body1">
 <div class="table-responsive">
            <br><table class="table" id="table1">
                                                     <thead style="display: @if(!empty($items))  @else none @endif ;">
                                                    <tr>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Total Cost</th>
                                                    <th scope="col">Total Tax</th>
                                                     <th scope="col">Action</th>
                                                    </tr>
                                                    </thead>
                                                     <tbody>
              @if (!empty($id))
                                                    @if (!empty($items))
                                                    @foreach ($items as $i)
                                                    
                                                    @php
                                                     $it=App\Models\CF\CFService::where('id',$i->item_name)->first();
                                                       
                                                            $a =  $it->name ; 
                                                    @endphp
                                                    <tr class="trlst{{$i->id}}_edit">
                                                      <td>{{$a}}</td>
                                                      <td>{{ isset($i) ? number_format($i->quantity,2) : '' }}</td>
                                                      <td>{{ isset($i) ? number_format($i->price,2) : '' }}</td>
                                                      <td>{{ isset($i) ? number_format($i->total_cost,2) : '' }}</td>
                                                      <td>{{ isset($i) ? number_format($i->total_tax,2) : '' }}</td>
  <td>
<a class="list-icons-item text-info iedit1" title="Check" href="javascript:void(0)" data-target="#app2FormModal" data-toggle="modal" data-button_id="{{$i->id}}_edit"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp;&nbsp;
<a class="list-icons-item text-danger irem" title="Delete" href="javascript:void(0)" data-button_id="{{$i->id}}_edit" value="{{$i->id}}"><i class="icon-trash" style="font-size:18px;"></i></a>
</td>
                                                    </tr>
                                                     
                                                     
                                                     @endforeach
                                                    @endif
                                                    @endif
                                                                 
                                                     </tbody>
                                                    </table>

</div>

@if (!empty($id))
                                                    @if (!empty($items))
                                                    @foreach ($items as $i)
                                                    
                                                    <div class="line_items" id="lst{{$i->id}}_edit">
  <input type="hidden" name="item_name[]" class="form-control iitem_name" id="name lst{{$i->id}}_edit" value="{{ isset($i) ? $i->item_name : '' }}" required="">
  <input type="hidden" name="description[]" class="form-control iitem_desc" id="desc lst{{$i->id}}_edit" value="{{ isset($i) ? $i->description : '' }}">
  <input type="hidden" name="quantity[]" class="form-control iitem_quantity" id="qty lst{{$i->id}}_edit" data-category_id="lst{{$i->id}}_edit" value="{{ isset($i) ? $i->quantity : '' }}" required="">
  <input type="hidden" name="price[]" class="form-control iitem_price" id="price lst{{$i->id}}_edit" value="{{ isset($i) ? $i->price : '' }}" required="">
  <input type="hidden" name="tax_rate[]" class="form-control iitem_rate" id="rate lst{{$i->id}}_edit" value="{{ isset($i) ? $i->tax_rate : '' }}" required="">
  <input type="hidden" name="total_cost[]" class="form-control iitem_cost" id="cost lst{{$i->id}}_edit" value="{{ isset($i) ? $i->total_cost : '' }}" required="">
  <input type="hidden" name="total_tax[]" class="form-control iitem_tax" id="tax lst{{$i->id}}_edit" value="{{ isset($i) ? $i->total_tax : '' }}" required="">
  <input type="hidden" name="unit[]" class="form-control iitem_unit" id="unit lst{{$i->id}}_edit" value="{{ isset($i) ? $i->unit : '' }}">
  <input type="hidden" name="modal_type" class="form-control iitem_type" id="type lst{{$i->id}}_edit" value="edit">
  <input type="hidden" name="no[]" class="form-control iitem_type" id="no lst{{$i->id}}_edit" value="{{$i->id}}_edit">
  <input type="hidden" name="saved_items_id[]" class="form-control iitem_savedlst{{$i->id}}_edit" value="{{$i->id}}">
  <input type="hidden" id="item_id" class="form-control iitem_idlst{{$i->id}}_edit" value="{{ isset($i) ? $i->item_name : '' }}">
</div>
                                                     @endforeach
                                                    @endif
                                                    @endif

                                                 

</div>
       
     <br> <br>
<div class="row">



<div class="col-lg-1"></div><label class="col-lg-3 col-form-label"> Sub Total (+):</label>
<div class="col-lg-6 line_items">
<input type="text" name="subtotal[]" class="form-control item_total" value="{{ isset($edit_data) ? '' : '0.00' }}" required="" jautocalc="SUM({total_cost})" readonly=""> <br>
</div><div class="col-lg-2"></div>

<div class="col-lg-1"></div><label class="col-lg-3 col-form-label">Tax (+):</label>
<div class="col-lg-6 line_items">
<input type="text" name="tax[]" class="form-control item_total" value="{{ isset($edit_data) ? '' : '0.00' }}" required="" jautocalc="SUM({total_tax})" readonly=""> <br>
</div><div class="col-lg-2"></div>


<div class="col-lg-1"></div><label class="col-lg-3 col-form-label"> Total :</label>
<div class="col-lg-6 line_items">
<input type="text" name="amount[]" class="form-control item_total" value="{{ isset($edit_data) ? '' : '0.00' }}" required="" jautocalc="{subtotal} + {tax} " readonly="readonly" ><br> 
</div><div class="col-lg-2"></div>



</div>


</div>





</div>



                                                    <br>
                                                    <div class="form-group row">
                                                        <div class="col-lg-offset-2 col-lg-12">
                                                             @if ($type == 'edit-invoice')

                 
                                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs isave"
                                                                   
                                                                    type="submit" id="save">Update</button>
                                                            @else
                                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs isave"
                                                                    type="submit" id="save">Save</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}
                                               </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

    
   
  


<script type="text/javascript">
    $(document).ready(function() {



        var count = 0;


        function autoCalcSetup3() {
            $('div#icart').jAutoCalc('destroy');
            $('div#icart div.line_items').jAutoCalc({
                keyEventsFire: true,
                decimalPlaces: 2,
                emptyAsZero: true
            });
            $('div#icart').jAutoCalc({
                decimalPlaces: 2
            });
        }
        autoCalcSetup3();

        $('.iadd').on("click", function(e) {

            count++;
            var html = '';
            html +=
                 '<div class="col-lg-3 line_items" id="td'+count + '"><br><div class="input-group mb-3"><select name="checked_item_name[]" class="form-control m-b iitem_name"  id="iitem_name' +
                count + '" data-sub_category_id="' + count +'" required><option value="">Select Item Name</option>@foreach ($name as $n) <option value="{{ $n->id }}">{{ $n->name }} </option>@endforeach</select></div><br><textarea name="checked_description[]"  class="form-control idesc' + count +'" placeholder="Description"  ></textarea><br></div>';
            html +='<div class="col-lg-6 line_items" id="td'+count + '"><br>Quantity <input type="number" name="checked_quantity[]" class="form-control iitem_quantity" min="0.01" step="0.01" data-category_id="' +count +'"placeholder ="quantity" id ="quantity" required /><br>Price <input type="text" name="checked_price[]" class="form-control iitem_price' + count +'" placeholder ="price" id="price td'+count + '" required  value=""/><br>Total Cost <input type="text" name="checked_total_cost[]" class="form-control iitem_total' +
                count + '" placeholder ="total" id="total td'+count + '" required readonly jAutoCalc="{checked_quantity} * {checked_price}" /><br>Tax <input type="text" name="checked_total_tax[]" class="form-control iitem_total_tax' +
                count +'" placeholder ="tax" id="tax_rate td'+count + '" required readonly jAutoCalc="{checked_quantity} * {checked_price} * {checked_tax_rate}"   readonly/><br>';
                 html += '<input type="hidden" name="checked_no[]" class="form-control iitem_no' + count +'" id="no td'+count + '" value="' + count +'" required />';
            html += '<input type="hidden" name="checked_unit[]" class="form-control iitem_unit' + count +'" id="unit td'+count + '" placeholder ="unit" required />';
            html += '<input type="hidden" name="checked_tax_rate[]" class="form-control iitem_tax' + count +'" placeholder ="total" id="tax td'+count + '"required />';
            html += '<input type="hidden" id="item_id"  class="form-control iitem_id' + count +'" value="" /></div>';
            html +='<div class="col-lg-3 text-center line_items" id="td'+count + '"><br><a class="list-icons-item text-info iadd1" title="Check" href="javascript:void(0)" data-save_id="' +count + '"><i class="icon-check2" style="font-size:30px;font-weight:bold;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger iremove" title="Delete" href="javascript:void(0)" data-button_id="' +count + '"><i class="icon-trash" style="font-size:18px;"></i></a><br><div class=""> <p class="form-control-static body_ierrors' +count + '" id="ierrors" style="text-align:center;color:red;"></p></div></div>';


          
            if ( $('#icart > .body div').length == 0 ) {
            $('#icart > .body').append(html);
            autoCalcSetup3();
            
              }

            /*
             * Multiple drop down select
             */
            $('.m-b').select2({});


               $(document).on('change', '.iitem_price'+ count, function() {
                var id = $(this).val();
                $.ajax({
                url: '{{ url('format_number') }}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                 console.log(data);
                $('.iitem_price' + count).val(data);
                   
                    }

                });

            });
        
        
      
                        
                        
        });
        
         $(document).on('change', '.iitem_name', function() {
            var id = $(this).val();
            var sub_category_id = $(this).data('sub_category_id');
            $.ajax({
                url: '{{ url('cf/findService') }}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('.iitem_price' + sub_category_id).val(numberWithCommas(data[0]["amount"]));
                    $(".iitem_tax" + sub_category_id).val(data[0]["tax_rate"]);
                    $('.iitem_id' + sub_category_id).val(id);
                      autoCalcSetup3();
                }

            });

        });
        

      


        $(document).on('click', '.iremove', function() {
            var button_id = $(this).data('button_id');
            var contentToRemove = document.querySelectorAll('#td' + button_id);
            $(contentToRemove).remove(); 
            autoCalcSetup3();
        });

    });
</script>


<script type="text/javascript">
    $(document).ready(function() {


     
        function autoCalcSetup4() {
            $('div#icart1').jAutoCalc('destroy');
            $('div#icart1.div.line_items').jAutoCalc({
                keyEventsFire: true,
                decimalPlaces: 2,
                emptyAsZero: true
            });
            $('div#icart1').jAutoCalc({
                decimalPlaces: 2
            });
        }
        autoCalcSetup4();
        
        

         $(document).on('click', '.iadd1', function() {
            console.log(1);
            
            
            
        var button_id = $(this).data('save_id');
        $('.body_ierrors'+ button_id).empty();
        //$('.body').find('select, textarea, input').serialize();
        
        var b=$('#td' + button_id).find('.iitem_name').val();
        var c=$('div#td' + button_id +'.col-lg-6.line_items').find('.iitem_quantity').val();
        var d=$('.iitem_price' + button_id).val();
        
         
        
        if( b == '' || c == '' || d == '' ){
           $('.body_ierrors'+ button_id).append('Please Fill Required Fields.');
        
     }
     
     else{
        
        
         $.ajax({
                type: 'GET',
                 url: '{{ url('cf/add_item') }}',
               data: $('#icart > .body').find('select, textarea, input').serialize(),
                cache: false,
                async: true,
                success: function(data) {
                    console.log(data);
                    
           $('#icart1 > .body1 table thead').show();
             $('#icart1 > .body1 table tbody').append(data['list']);
             $('#icart1 > .body1').append(data['list1']);
              autoCalcSetup4();
 
                },
              


            });
            
            
            var contentToRemove = document.querySelectorAll('#td' + button_id);
            $(contentToRemove).remove(); 
            
     }
     

        });



        $(document).on('click', '.iremove1', function() {
            var button_id = $(this).data('button_id');
            var contentToRemove = document.querySelectorAll('#lst' + button_id);
            $(contentToRemove).remove(); 
             $(this).closest('tr').remove();
             $(".iitem_quantity").change();
            autoCalcSetup4();
        });
        
        
          $(document).on('click', '.irem', function() {
            var button_id = $(this).data('button_id');
            var btn_value = $(this).attr("value");
            var contentToRemove = document.querySelectorAll('#lst' + button_id);
            $(contentToRemove).remove(); 
             $(this).closest('tr').remove();
              $('#icart1 > .body1').append('<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +btn_value + '"/>');
              $(".iitem_quantity").change();
            autoCalcSetup4();
        });



  $(document).on('click', '.iedit1', function() {
            var button_id = $(this).data('button_id');
            
            console.log(button_id);
            $.ajax({
                type: 'GET',
                 url: '{{ url('cf/cfModal') }}',
                 data: $('#icart1 > .body1 #lst'+button_id).find('select, textarea, input').serialize(),
                cache: false,
                async: true,
                success: function(data) {
                    //alert(data);

                    $('#app2FormModal > .modal-dialog').html(data);
                     
                },
                error: function(error) {
                    $('#app2FormModal').modal('toggle');

                }


            });
           
            
        });
        
        
            $(document).on('click', '.qadd_edit_form', function(e) {
            e.preventDefault();
           
            var sub = $(this).data('button_id');
            console.log(sub);
            
            $.ajax({
                data: $('.addEditForm').serialize(),
                type: 'GET',
                 url: '{{ url('cf/add_item') }}',
                dataType: "json",
                success: function(data) {
                    console.log(data);
                  
                  $('#icart1 > .body1 table tbody').find('.trlst'+sub).html(data['list']);
                  $('#icart1 > .body1').find('#lst'+sub).html(data['list1']);
                    $(".iitem_quantity").change();
              autoCalcSetup4();
           

                }
            })
        });



    });
</script>






   

    
    

    
    <script>
    $(document).ready(function() {
      
         $(document).on('click', '.isave', function(event) {
   
         $('.item_ierrors').empty();

          if ( $('#icart1 > .body1 .line_items').length == 0 ) {
               event.preventDefault(); 
    $('.item_ierrors').append('Please Add Items.');
}
         
         else{
            
         
          
         }
        
    });
    
    
    
    });
    </script>
    
    
  
    </script>
    
    
    <script type="text/javascript">


function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}




    </script> 
     
    


