@extends('layouts.master')


@section('content')

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Items</h6>
            </div>

            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-solid">
                    <li class="nav-item"><a href="#solid-tab1" class="nav-link active" data-toggle="tab">Item List</a>
                    </li>
                    <li class="nav-item"><a href="#solid-tab2" class="nav-link" data-toggle="tab">New Items</a></li>

                </ul>

                <div class="tab-content">
                    <div class="tab-pane  active" id="solid-tab1">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Items</h5>
                            </div>

                            <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="itemsDatatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item Name</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Unit Type</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                     
                                    </tbody>
                                </table>
                            </div>
                            </div>

                          
                        </div>
                    </div>

                    <div class="tab-pane fade" id="solid-tab2">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">ITems</h5>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{route('items.store')}}">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">Item Name</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="item_name"
                                                value="{{ isset($data)? $data->item_name : ''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">Unit Price</label>
                                        <div class="col-lg-10">
                                            <input type="number" class="form-control" name="price"
                                                value="{{ isset($data)? $data->price : ''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">Desription</label>
                                        <div class="col-lg-10">
                                            <textarea name="description"
                                                class="form-control">{{isset($data)? $data->description : ''}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">unit Type</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="type"
                                                value="{{ isset($data)? $data->type : ''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">Quantity</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" name="quantity"
                                                value="{{ isset($data)? $data->quantity : ''}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-2">Tax</label>
                                        <div class="col-lg-10">
                                            <select class="custom-select" name="Tax">
                                                <option value="opt1">Select Tax</option>
                                                <option value="1">Option 2</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-right">
											<button type="submit" class="btn btn-teal">Submit form <i class="icon-paperplane ml-2"></i></button>
										</div>
                                </form>
                                </diiv>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>


    </div>

    @endsection

    @section('scripts')
<script>
$(function() {
    let urlcontract = "{{ route('items.index') }}";
    $('#itemsDatatable').DataTable({
        processing: true,
        serverSide: true,
        lengthChange: false,
        searching: true,
        type: 'GET',
        ajax: {
            url: urlcontract,
            data: function(d) {
                d.start_date = $('#date1').val();
                d.end_date = $('#date2').val();
                d.from = $('#from').val();
                d.to = $('#to').val();
                d.status = $('#status').val();

            }
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'item_name',
                name: 'item_name'
            },
            {
                data: 'quantity',
                name: 'quantity'
            },
            {
                data: 'price',
                name: 'price'
            },
            {
                data: 'tax',
                name: 'tax'
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: 'unit',
                name: 'unit',
                orderable: false,
                searchable: true
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: true
            },

        ]
    })
});
</script>
    @endsection