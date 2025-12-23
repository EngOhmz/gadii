@extends('layouts.master')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-body text-primary">
            <h2 class="h3 mb-0 text-gray-800">
                <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/40C057/total-sales-1.png" /> Profit Report
            </h2>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Profit Report</h4>
                    </div>
                    <div class="card-body">
                        <div class="tab-content tab-bordered">
                            <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                <br>
                                <div class="panel-heading">
                                    <h6 class="panel-title">
                                        @if(!empty($startDate))
                                            For the period: <b>{{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</b>
                                        @endif
                                    </h6>
                                </div>
                                <br>
                                <div class="panel-body hidden-print">
                                    {!! Form::open(['url' => route('pos.stock_profit_report'), 'method' => 'get', 'class' => 'form-horizontal', 'name' => 'form']) !!}
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Start Date</label>
                                            <input name="start_date" id="start_date" type="date" class="form-control date-picker" value="{{ $startDate ?? date('Y-m-d', strtotime('first day of january this year')) }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label>End Date</label>
                                            <input name="end_date" id="end_date" type="date" class="form-control date-picker" value="{{ $endDate ?? date('Y-m-d') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Location</label>
                                            <select name="location" class="form-control m-b location" id="location">
                                                <option value="" @if($locationId == '') selected @endif>All Locations</option>
                                                @foreach($locations as $location)
                                                    <option value="{{ $location->id }}" @if($locationId == $location->id) selected @endif>{{ $location->name }}</option>
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

                                @if(!empty($reportData) && count($reportData) > 0)
                                    <div class="panel panel-white">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table datatable-button-html5-basic">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Item Name</th>
                                                            <th>Sales Balance</th>
                                                            <th>Cost Balance</th>
                                                            <th>Balance</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($reportData as $item)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $item['item_name'] }}</td>
                                                                <td>{{ number_format($item['sales'], 2) }}</td>
                                                                <td>{{ number_format($item['purchases'], 2) }}</td>
                                                                <td>{{ number_format($item['balance'], 2) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="2">Total</th>
                                                            <th>{{ number_format(collect($reportData)->sum('sales'), 2) }}</th>
                                                            <th>{{ number_format(collect($reportData)->sum('purchases'), 2) }}</th>
                                                            <th>{{ number_format(collect($reportData)->sum('balance'), 2) }}</th>
                                                        </tr>
                                                    </tfoot>
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

