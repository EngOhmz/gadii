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
                    $type == ' logistic' ||
                    $type == 'cargo' ||
                    $type == 'storage' ||
                    $type == 'charge') active @endif" id="cargo-tab1" data-toggle="tab"
                href="#cargo-home" role="tab" aria-controls="home" aria-selected="true">Cargo Type
                List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($type == 'edit-cargoType') active @endif" id="cargo-tab2" data-toggle="tab"
                href="#cargo-profile" role="tab" aria-controls="profile" aria-selected="false">New Cargo Type</a>
        </li>

    </ul>
    <br>
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
                $type == ' logistic' ||
                $type == 'cargo' ||
                $type == 'storage' ||
                $type == 'charge') active show @endif " id="cargo-home" role="tabpanel"
            aria-labelledby="cargo-tab1">
            <div class="table-responsive">
                <table class="table datatable-basic table-striped" style="width:100%">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 156.484px;">#</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 156.484px;">Cargo Name</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Activity Type</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Route</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Loaded Date</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Storage Start Date</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                style="width: 158.1094px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (!@empty($CargoType))
                            @foreach ($CargoType as $row)
                                <tr class="gradeA even" role="row">
                                    <td>{{ $loop->iteration }}</td>
                                    @php $cargo_name = App\Models\CF\Cargo::find($row->name_id)->name; @endphp
                                    <td>{{ $cargo_name }}</td>
                                    <td>{{ $row->activity_type }}</td>
                                    <td>{{ $row->Country }}</td>
                                    <td>{{ Carbon\Carbon::parse($row->loaded_date)->format('d/m/Y') }}</td>
                                    <td>{{ Carbon\Carbon::parse($row->storage_start_date)->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="form-inline">
                                            <a class="list-icons-item text-primary" title="Edit"
                                                href="{{ route('edit.cf_details', ['id' => $id,'type' => 'edit-cargoType', 'type_id' => $row->id]) }}"><i
                                                    class="icon-pencil7"></i></a>&nbsp
                                                    
                                            <a class="list-icons-item text-danger" title="Edit"
                                                href="{{ route('delete.cf_details', ['type' => 'delete-cargoType', 'type_id' => $row->id]) }}"
                                                onclick="return confirm('Are you sure, you want to delete?')"><i
                                                    class="icon-trash"></i></a>&nbsp

                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item dropdown-toggle text-teal"
                                                    data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                                <div class="dropdown-menu">
                                                   
                                                    <a class="nav-link" data-toggle="modal" href="" data-target="#charge">
                                                        Charge
                                                    </a>
                                                   
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
        <div class="tab-pane fade @if ($type == 'edit-cargoType') active show @endif" id="cargo-profile"
            role="tabpanel" aria-labelledby="cargo-tab2">
            <br>
            <div class="card">
                <div class="card-header">
                    @if ($type == 'edit-cargoType')
                        <h5>Edit Cargo Type</h5>
                    @else
                        <h5>Add New Cargo Type</h5>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 ">
                            @if ($type == 'edit-cargoType')

                                {!! Form::open(['route' => 'update.cf_details', 'enctype' => 'multipart/form-data']) !!}
                                <input type="hidden" name="id" value="{{ $type_id }}">
                                <input type="hidden" name="project_id" value="{{ $id }}">
                            @else
                                {!! Form::open(['route' => 'save.cf_details', 'enctype' => 'multipart/form-data']) !!}
                                @method('POST')
                            @endif


                            <input type="hidden" name="project_id" value="{{ $id }}">
                            <input type="hidden" name="type" value="cargoType">

                            <div class="form-group row"><label class="col-lg-2 col-form-label">Cargo Name</label>
                                <div class="col-lg-10">
                                    <select class="m-b account_id" id="user_id" name="name_id" required>
                                        <option value="">Select </option>
                                        @foreach ($Cargo as $row)
                                            <option value="{{ $row->id }}"
                                                @if (isset($edit_data)) @if ($edit_data->responsible_id == $row->id) selected @endif
                                                @endif >{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row"><label class="col-lg-2 col-form-label">Activity Type</label>
                                <div class="col-lg-10">
                                    <select class="m-b related_class" id="goal_tracking_id"
                                        name="activity_type" required>
                                        <option value="">Select Related</option>
                                        <option value="Clearing"
                                            @if (isset($edit_data)) @if ($edit_data->activity_type == 'Clearing') selected @endif
                                            @endif >Clearing</option>
                                        <option value="Forwading"
                                            @if (isset($edit_data)) @if ($edit_data->activity_type == 'Forwading') selected @endif
                                            @endif >Forwading</option>
                                    </select>
                                </div>
                            </div>

                            <div id="projectDiv" style=" display: @if(!empty($data)) block @else none @endif;">

                                <div class="form-group row"><label class="col-lg-2 col-form-label">Route</label>
                                    <div class="col-lg-10">
                                        <select class="form-control m-b country" id="client_id" name="Country">
                                            <option value="">Select Here</option>
                                            @foreach ($country as $row)
                                                <option value="{{ $row->value }}"
                                                    @if (isset($edit_data))  @if ($edit_data->Country == $row->value) selected @endif
                                            @endif >{{ $row->value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            
                             <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Loaded Date</label>
                                <div class="col-lg-10">
                                    <input type="date" name="loaded_date" required placeholder=""
                                        value="{{ isset($edit_data) ? $edit_data->loaded_date : date('Y-m-d') }}"
                                        class="form-control">
                                </div>
                            </div>

                             <div id="leadsDiv" style=" display: @if(!empty($edit_data)) block @else none @endif;">
                        
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label date"> @if(!empty($edit_data)){{ 'Clearing' == $edit_data->activity_type ? 'Discharge Date' : 'Empty Collecction Date'  }}  @endif</label>
                                <div class="col-lg-10">
                                    <input type="date" name="storage_start_date" required placeholder=""
                                        value="{{ isset($edit_data) ? $edit_data->storage_start_date : date('Y-m-d') }}"
                                        class="form-control">
                                </div>
                            </div>
                            </div>
                              <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Weight </label>
                                <div class="col-lg-10">
                                    <input type="number" name="weight" min="0" step="0.01" required placeholder=""
                                        value="{{ isset($edit_data) ? $edit_data->weight : ''}}"
                                        class="form-control">
                                </div>
                            </div>
                              <div class="form-group row">
                                <label class="col-lg-2 col-form-label">CBM </label>
                                <div class="col-lg-10">
                                     <input type="number" name="cbm" min="0" step="0.01" required placeholder=""
                                        value="{{ isset($edit_data) ? $edit_data->cbm : ''}}"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-offset-2 col-lg-12">
                                    @if ($type == 'edit-cargoType')
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                            data-toggle="modal" data-target="#myModal" type="submit">Update</button>
                                    @else
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                            type="submit">Save</button>
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


        <!-- Modal cf charge -->
        <div class="modal fade" data-backdrop=""  id="charge" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Charge</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    {{ Form::open(['route' => 'save.charge_details']) }}
                                @method('POST')
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-12 ">
                                
                                
                                <input type="hidden" name="cf_id" value="{{ $id }}">
                                <input type="hidden" name="type" value="charge">
                                <div class="form-group row"><label class="col-lg-3 col-form-label">CF Service</label>
                                    <div class="col-lg-9">
                                        <select name="cf_servece_id" id="cf_servece_id" class="form-control m-b service" required>
                                            <option value="">Select Here</option>
                                            @foreach ($CFservice as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Charge Type</label>
                                    <div class="col-lg-9">
                                        <input type="text" name="charge_type" class="form-control charge_type" readonly required>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Amount</label>
                                    <div class="col-lg-9">
                                        <input type="text" name="amount" class="form-control amount" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row bank" style="display:none;">
                                <label class="col-lg-3 col-form-label">Bank/Cash Account</label>
                                    <div class="col-lg-9">
                                      <select class="form-control m-b" name="bank_id" id="bank_id">
                                            <option value="">Select Payment Account</option>
                                            @foreach ($bank_accounts as $bank)
                                                <option value="{{ $bank->id }}">{{ $bank->account_name }}</option>
                                            @endforeach
                                                                </select>
                                    </div>
                                </div>
                                
                                 </div>
                </div>
                
                </div>

                               
                                      <div class="modal-footer bg-whitesmoke br">
                <button class="btn btn-primary"  type="submit"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
                                   
                                </div>
                                {!! Form::close() !!}
                            
                        </div>
                    </div>
                </div>
               
                
            
<!-- Modal cf storage -->
{{--       
        
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Storage Setting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 ">
                                {{ Form::open(['route' => 'save.storage_details']) }}
                                @method('POST')
                                <input type="hidden" name="cf_id" value="{{ $id }}">
                                <input type="hidden" name="type" value="storage">
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Storage Charge</label>
                                    <div class="col-lg-9">
                                        <input type="number" name="store_charge"
                                            value="{{ isset($data) ? $data->name : '' }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Storage Start
                                        Due</label>
                                    <div class="col-lg-9">
                                        <input type="date" name="store_start_date"
                                            value="{{ isset($data) ? $data->name : '' }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Due Date</label>
                                    <div class="col-lg-9">
                                        <input type="date" name="due_date"
                                            value="{{ isset($data) ? $data->name : '' }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-lg-3 col-form-label">Charge Start of Due
                                        Date</label>
                                    <div class="col-lg-9">
                                        <input type="number" name="charge_start"
                                            value="{{ isset($data) ? $data->name : '' }}" class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-offset-2 col-lg-12">

                <button class="btn btn-primary"  type="submit" data-dismiss="modal"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                           </div>
                        </div>
                    </div>
                </div>
        
        --}}
        
        
        
        
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
        
      
<script type="text/javascript">
    $(document).ready(function() {

        $(document).on('change', '.related_class', function() {


            var id = $(this).val();

            if (id == 'Clearing') {
                $('#projectDiv').show();
                $('#leadsDiv').show();
                $("#leadsDiv label").text('Discharge Date');
            } else if (id == 'Forwading') {
                $('#projectDiv').show();
                $('#leadsDiv').show();
                 $("#leadsDiv label").text('Empty Collection Date');
            }


        });
    });
</script>

   <script type="text/javascript">
    $(document).ready(function() {

   $(document).on('change', '.service', function() {
            var id = $(this).val();
            console.log(id);
            $.ajax({
                url: '{{ url('cf/findService') }}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('.amount').val(numberWithCommas(data[0]["amount"]));
                    $(".charge_type").val(data[0]["type"]);
                    
                     if (data[0]["type"] == 'Invoiced') {
                    $('.bank').hide();
                    $("#bank_id").prop('required',false);

                } else {
                    $('.bank').show();
                     $("#bank_id").prop('required',true);

                }
                
                
                }

            });

        });
        


       $(document).on('change', '.amount', function() {
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
        $('.amount').val(data);
           
            }

        });

    });

        
 

    });
</script>

 <script type="text/javascript">


function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

</script>

