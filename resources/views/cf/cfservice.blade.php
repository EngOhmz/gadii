@extends('layouts.master')
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>CF Service</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#cf1" role="tab" aria-controls="home"
                                        aria-selected="true">CF Service
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#cf2" role="tab"
                                        aria-controls="profile" aria-selected="false">New CF Service</a>
                                </li>

                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="cf1" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table datatable-basic table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 41.219px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 191.219px;">Charge Center</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 171.219px;">Charge Type</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 161.219px;">Amount</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Actions</th>
                                                </tr>
                                            </thead>
                                            @if (!@empty($cfservice))
                                                @foreach ($cfservice as $row)
                                                    <tr class="gradeA even" role="row">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $row->name }}</td>
                                                        <td> @if(!empty($row->account->account_name)) {{ $row->account->account_name }} @endif</td>
                                                         <td>{{ $row->type }}</td>
                                                          <td>{{number_format($row->amount,2) }}</td>
                                                        <td>
                                                            <div class="form-inline">
                                                               
                                                                    <a class="list-icons-item text-primary"
                                                                        href="{{ route('cf_service.edit', $row->id) }}"><i
                                                                            class="icon-pencil7"></i>
                                                                    </a>
                                                                &nbsp
                                                                
                                                                    {!! Form::open(['route' => ['cf_service.destroy', $row->id], 'method' => 'delete']) !!}
                                                                    {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 
                                                                    'class' => 'list-icons-item text-danger', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                                    {{ Form::close() }}
                                                               
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade @if (!empty($id)) active show @endif"
                                    id="cf2" role="tabpanel" aria-labelledby="profile-tab2">

                                    <div class="card">
                                        <div class="card-header">
                                            @if (!empty($id))
                                                <h5>Edit CF Service</h5>
                                            @else
                                                <h5>Add New CF Service</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (isset($id))
                                                        {{ Form::model($id, ['route' => ['cf_service.update', $id], 'method' => 'PUT']) }}
                                                    @else
                                                        {{ Form::open(['route' => 'cf_service.store']) }}
                                                        @method('POST')
                                                    @endif

                                                    <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Name</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="name"
                                                                value="{{ isset($data) ? $data->name : '' }}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Charge Center</label>
                                                        <div class="col-lg-10">
                                                            <select name="gl_account_id" id="gl_account_id"
                                                                class="form-control m-b" required>
                                                                <option value="">Select Here</option>
                                                                @foreach ($gl_account as $row)
                                                                    <option value="{{ $row->id }}"
                                                                        @if (isset($data)) {{ $data->gl_account_id == $row->id ? 'selected' : '' }} @endif>
                                                                        {{ $row->account_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                     <div class="form-group row">
                                                     <label class="col-lg-2 col-form-label">Amount</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="amount" 
                                                                value="{{ isset($data) ? $data->amount : '' }}"
                                                                class="form-control amount" required>
                                                        </div>
                                                    </div>
                                                    
                            <div class="form-group row"><label class="col-lg-2 col-form-label">Charge Type</label>
                            <div class="col-lg-10">
                            <select name="type" id="type" class="form-control m-b" required>
                            <option value="">Select Here</option>
                            <option value="Invoiced" @if (isset($data)) {{ $data->type == 'Invoiced' ? 'selected' : '' }} @endif>Invoiced</option>
                            <option value="Customer Duties & Taxes" @if (isset($data)) {{ $data->type == 'Customer Duties & Taxes' ? 'selected' : '' }} @endif>Customer Duties & Taxes</option>          
                            </select>
                            </div>
                            </div>


                                                    <div class="form-group row">
                                                        <div class="col-lg-offset-2 col-lg-12">
                                                            @if (!@empty($id))
                                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                    data-toggle="modal" data-target="#myModal"
                                                                    type="submit">Update</button>
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
                    </div>
                </div>
            </div>

        </div>
    </section>


@endsection

@section('scripts')
    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [{
                "orderable": false,
                "targets": [3]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            },

        });
    </script>
    
    <script type="text/javascript">
    $(document).ready(function() {



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
   
@endsection
