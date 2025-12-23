@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Expired and Expiring Products</h4>
                    </div>
                    <div class="card-body">
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade active show" id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                <br>
                                <div class="panel-heading">
                                    <h6 class="panel-title">
                                        For the period: <b>{{ ucfirst(str_replace('_', ' ', $selectedRange)) }}</b>
                                    </h6>
                                </div>
                                <br>
                                <div class="panel-body hidden-print">
                                    {!! Form::open(['url' => route('expire_report.search'), 'method' => 'post', 'class' => 'form-horizontal', 'name' => 'form']) !!}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Expiration Range</label>
                                            <select name="range" class="form-control">
                                                <option value="one_week" {{ $selectedRange == 'one_week' ? 'selected' : '' }}>One Week</option>
                                                <option value="two_weeks" {{ $selectedRange == 'two_weeks' ? 'selected' : '' }}>Two Weeks</option>
                                                <option value="three_weeks" {{ $selectedRange == 'three_weeks' ? 'selected' : '' }}>Three Weeks</option>
                                                <option value="one_month" {{ $selectedRange == 'one_month' ? 'selected' : '' }}>One Month</option>
                                                <option value="two_months" {{ $selectedRange == 'two_months' ? 'selected' : '' }}>Two Months</option>
                                                <option value="three_months" {{ $selectedRange == 'three_months' ? 'selected' : '' }}>Three Months</option>
                                                <option value="six_months" {{ $selectedRange == 'six_months' ? 'selected' : '' }}>Six Months</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <br>
                                            <button type="submit" class="btn btn-success">Search</button>
                                            <a href="{{ url('reports/pos/expire_report') }}" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                                <br>
                                <div class="panel panel-white">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table datatable-button-html5-basic">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Type</th>
                                                        <th>Cost Price</th>
                                                        <th>Sales Price</th>
                                                        <th>Minimum Quantity Alert</th>
                                                        <th>Tax Rate</th>
                                                        <th>Crate Size</th>
                                                        <th>Quantity</th>
                                                        <th>Unit</th>
                                                        <th>Expire Date</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($items as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ ucwords($item['name']) }}</td>
                                                            <td>
                                                                @if($item['type'] == 1)
                                                                    Inventory
                                                                @elseif($item['type'] == 6)
                                                                    Inventory (Dozen/Crates)
                                                                @else
                                                                    {{ $item['type'] }} <!-- Default display for other types -->
                                                                @endif
                                                            </td>
                                                            <td>{{ $item['cost_price'] }}</td>
                                                            <td>{{ $item['sales_price'] }}</td>
                                                            <td>{{ $item['minimum_balance'] }}</td>
                                                            <td>{{ $item['tax_rate'] }}</td>
                                                            <td>{{ $item['crate_size'] }}</td>
                                                            <td>
                                                                @if($item['type'] == 6)
                                                                    @php
                                                                        $numOfCrates = intdiv($item['quantity'], $item['crate_size']); // Get number of crates (integer division)
                                                                        $remainingQuantity = $item['quantity'] % $item['crate_size']; // Get the remaining quantity (modulus)
                                                                    @endphp
                                                                    [{{ $numOfCrates }} Crates, {{ $remainingQuantity }}]
                                                                @else
                                                                    {{ $item['quantity'] }}
                                                                @endif
                                                            </td>
                                                            
                                                            <td>{{ $item['unit'] }}</td>
                                                            <td>{{ $item['expire_date'] }}</td>
                                                            <td><span class="badge {{ $item['status'] == 'expired' ? 'badge-danger' : 'badge-warning' }}">{{ ucfirst($item['status']) }}</span></td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="12" class="text-center">No records found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
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

