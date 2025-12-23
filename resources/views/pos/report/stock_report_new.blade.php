@extends('layouts.master')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-body text-primary">
            <h2 class="h3 mb-0 text-gray-800">
                <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/40C057/total-sales-1.png" /> Stock Value Report
            </h2>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Stock Value</h4>
                    </div>
                    <div class="card-body">
                        <div class="tab-content tab-bordered">
                            <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                <br>
                                <div class="panel-heading">
                                    <h6 class="panel-title">
                                        @if(!empty($start_date))
                                            For the period: <b>{{ Carbon\Carbon::parse($start_date)->format('d/m/Y') }} to {{ Carbon\Carbon::parse($end_date)->format('d/m/Y') }}</b>
                                        @endif
                                    </h6>
                                </div>
                                <br>
                                <div class="panel-body hidden-print">
                                    {!! Form::open(array('url' => route('pos.stock_report'), 'method' => 'get', 'class'=>'form-horizontal', 'name' => 'form')) !!}
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Start Date</label>
                                            <input name="start_date" id="start_date" type="date" class="form-control date-picker" required value="{{ $start_date ?? date('Y-m-d', strtotime('first day of january this year')) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label>End Date</label>
                                            <input name="end_date" id="end_date" type="date" class="form-control date-picker" required value="{{ $end_date ?? date('Y-m-d') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Location</label>
                                            <select name="location" class="form-control m-b location" id="location">
                                                <!-- If no location is selected, it sends an empty value for 'location' -->
                                                <option value="" @if($location == '') selected @endif>All Locations</option>
                                                @foreach($locations as $br)
                                                    <option value="{{ $br->id }}" @if($location == $br->id) selected @endif>{{ $br->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        
                                        
                                        
                                        
                                        <div class="col-md-4">
                                            <br><button type="submit" class="btn btn-success">Search</button>
                                            <a href="{{ Request::url() }}" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                                <br>

                                @if(!empty($items) && count($items) > 0)
                                    <div class="panel panel-white">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table datatable-button-html5-basic">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Item Name</th>
                                                            <th>Location</th>
                                                            <th>Item Type</th>
                                                            <th>Quantity</th>
                                                            <th>Cost Price</th>
                                                            <th>Sales Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($items as $item)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $item['item_name'] }}</td>
                                                                <td>{{ $item['location_name'] }}</td>
                                                                <td>
                                                                    @if($item['item_type'] == 1)
                                                                        <span class="badge badge-primary">Inventory</span>
                                                                    @elseif($item['item_type'] == 6)
                                                                        <span class="badge badge-secondary">Dual/Dozen Inventory</span>
                                                                    @endif
                                                                </td>
                                                                
                                                                <td>
                                                                    @if($item['item_type'] == 6)
                                                                        <?php
                                                                            $crates = floor($item['quantity'] / $item['crate_size']);
                                                                            $remaining = $item['quantity'] % $item['crate_size'];
                                                                        ?>
                                                                        {{ $crates }} crate(s), {{ $remaining }} qty.
                                                                    @else
                                                                        {{ number_format($item['quantity']) }} qty.
                                                                    @endif
                                                                </td>
                                                                <td>{{ number_format($item['cost_price'], 2) }}</td>
                                                                <td>{{ number_format($item['sales_price'], 2) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p>No records found for the selected period.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

