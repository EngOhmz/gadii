@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-body text-primary">
                        <h2 class="h3 mb-0 text-gray-800">
                            <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/40C057/total-sales-1.png" /> Stock Movement Report
                        </h2>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Stock Movement Report</h4>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ url('reports/pos/stock_movement_report') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Start Date</label>
                                    <input name="start_date" type="date" class="form-control" value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-4">
                                    <label>End Date</label>
                                    <input name="end_date" type="date" class="form-control" value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-success">Search</button>
                                    <a href="{{ url('reports/pos/stock_movement_report') }}" class="btn btn-danger ml-2">Reset</a>
                                </div>
                            </div>
                        </form>
                        <br>
                        @if(!empty($stockMovementDetails))
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Receipt Name</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Movement Date</th>
                                        <th>Staff Name</th>
                                        <th>Source Name</th>
                                        <th>Destination Name</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stockMovementDetails as $movement)
                                    <tr>
                                        <td>{{ $movement['name'] }}</td>
                                        <td>{{ $movement['items'][0]['item_name'] }}</td>
                                        <td>{{ $movement['items'][0]['quantity'] }}</td>
                                        <td>{{ $movement['movement_date'] }}</td>
                                        <td>{{ $movement['staff_name'] }}</td>
                                        <td>{{ $movement['source_name'] }}</td>
                                        <td>{{ $movement['destination_name'] }}</td>
                                        <td>
                                            <span class="badge {{ $movement['status'] == 1 ? 'badge-success' : 'badge-warning' }}">
                                                {{ $movement['status'] == 1 ? 'Completed' : 'Pending' }}
                                            </span>
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p>No stock movement records found for the selected period.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

