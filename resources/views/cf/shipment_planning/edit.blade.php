@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Shipment</h4>
                    </div>
                    <div class="card-body">
                        {{ Form::model($shipment, ['route' => ['cf.shipment-planning.update', $shipment->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Supplier ID</label>
                                    <div class="col-lg-10">
                                        <select name="supplier_id" class="form-control" required>
                                            <option value="">Select Supplier</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" {{ $shipment->supplier_id == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->name }} ({{ $supplier->id }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Shipment ID</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="shipment_id" class="form-control" value="{{ $shipment->shipment_id }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Type</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="type" class="form-control" value="{{ $shipment->type }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Quantity</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="quantity" class="form-control" value="{{ $shipment->quantity }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Value</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="value" class="form-control" value="{{ $shipment->value }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Port Origin</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="port_origin" class="form-control" value="{{ $shipment->port_origin }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Port Entry</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="port_entry" class="form-control" value="{{ $shipment->port_entry }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">ETD</label>
                                    <div class="col-lg-10">
                                        <input type="date" name="etd" class="form-control" value="{{ $shipment->etd }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">ETA</label>
                                    <div class="col-lg-10">
                                        <input type="date" name="eta" class="form-control" value="{{ $shipment->eta }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">B/L- Document</label>
                                    <div class="col-lg-10">
                                        @if($shipment->document)
                                            <p>Current file: <a href="{{ asset($shipment->document) }}" target="_blank">View Document</a></p>
                                        @endif
                                        <input type="file" name="document" class="form-control" accept=".pdf,.doc,.docx">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Packing List Document</label>
                                    <div class="col-lg-10">
                                        @if($shipment->pl_document)
                                            <p>Current file: <a href="{{ asset($shipment->pl_document) }}" target="_blank">View Document</a></p>
                                        @endif
                                        <input type="file" name="pl_document" class="form-control" accept=".pdf,.doc,.docx">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Invoice Document</label>
                                    <div class="col-lg-10">
                                        @if($shipment->inv_document)
                                            <p>Current file: <a href="{{ asset($shipment->inv_document) }}" target="_blank">View Document</a></p>
                                        @endif
                                        <input type="file" name="inv_document" class="form-control" accept=".pdf,.doc,.docx">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Status</label>
                                    <div class="col-lg-10">
                                        <select name="status" class="form-control" required>
                                            <option value="Ready at Supplier" {{ $shipment->status == 'Ready at Supplier' ? 'selected' : '' }}>Ready at Supplier</option>
                                            <option value="Shipped" {{ $shipment->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="In Transit" {{ $shipment->status == 'In Transit' ? 'selected' : '' }}>In Transit</option>
                                            <option value="Arrived at Port" {{ $shipment->status == 'Arrived at Port' ? 'selected' : '' }}>Arrived at Port</option>
                                            <option value="Custom Clearance Started" {{ $shipment->status == 'Custom Clearance Started' ? 'selected' : '' }}>Custom Clearance Started</option>
                                            <option value="Cleared" {{ $shipment->status == 'Cleared' ? 'selected' : '' }}>Cleared</option>
                                            <option value="Delivered to Warehouse" {{ $shipment->status == 'Delivered to Warehouse' ? 'selected' : '' }}>Delivered to Warehouse</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-offset-2 col-lg-12">
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit">Update</button>
                                        <a href="{{ route('cf.shipment-planning.index') }}" class="btn btn-sm btn-secondary float-right m-t-n-xs mr-2">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection