@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-body text-primary">
                <h2 class="h3 mb-0 text-gray-800">
                    <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/40C057/total-sales-1.png" />
                    Sales Report 2
                </h2>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Sales Report 2</h4>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['url' => request()->fullUrl(), 'method' => 'GET', 'class' => 'form-horizontal']) !!}
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Start Date</label>
                                    <input name="start_date" type="date" class="form-control"
                                        value="{{ request('start_date', date('Y-m-d', strtotime('first day of january this year'))) }}">
                                </div>
                                <div class="col-md-3">
                                    <label>End Date</label>
                                    <input name="end_date" type="date" class="form-control"
                                        value="{{ request('end_date', date('Y-m-d')) }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Location</label>
                                    <select name="location" class="form-control">
                                        <option value="">Select Location</option>
                                        @foreach ($locations as $loc)
                                            <option value="{{ $loc->id }}"
                                                {{ request('location') == $loc->id ? 'selected' : '' }}>{{ $loc->name }}
                                            </option>
                                        @endforeach
                                        <option value="all" {{ request('location') == 'all' ? 'selected' : '' }}>All
                                            Locations</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Sales Type</label>
                                    <select name="sales_type" class="form-control">
                                        <option value="">Select Sales Type</option>
                                        <option value="Cash Sales"
                                            {{ request('sales_type') == 'Cash Sales' ? 'selected' : '' }}>Cash Sales
                                        </option>
                                        <option value="Credit Sales"
                                            {{ request('sales_type') == 'Credit Sales' ? 'selected' : '' }}>Credit Sales
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <button type="submit" class="btn btn-success">Search</button>
                                    <a href="{{ url()->current() }}" class="btn btn-danger">Reset</a>
                                </div>
                            </div>
                            {!! Form::close() !!}

                            @if ($salesReport->count())
                                <!-- Dynamic Header Based on Filters -->
                                <div class="mt-4">
                                    <h5>Showing results from
                                        <strong>{{ request('start_date', date('Y-m-d', strtotime('first day of january this year'))) }}</strong>
                                        to <strong>{{ request('end_date', date('Y-m-d')) }}</strong>
                                        @if (request('location'))
                                            at
                                            <strong>{{ request('location') == 'all' ? 'All Locations' : ($locations->where('id', request('location'))->first()->name ?? 'Unknown') }}</strong>
                                        @endif
                                        @if (request('sales_type'))
                                            for <strong>{{ request('sales_type') }}</strong>
                                        @endif
                                    </h5>
                                </div>

                                <div class="table-responsive mt-4">
                                    <table class="table datatable-button-html5-basic">
                                        <thead>
                                            <tr>
                                                <th style="border-bottom: 2px solid black;">Heading</th>
                                                <th style="border-bottom: 2px solid black;">Invoice</th>
                                                <th style="border-bottom: 2px solid black;">Client Name</th>
                                                <th style="border-bottom: 2px solid black;">Items</th>
                                                <th style="border-bottom: 2px solid black;">Due Amount</th>
                                                <th style="border-bottom: 2px solid black;">Paid Amount</th>
                                                <th style="border-bottom: 2px solid black;">Status</th>
                                                <th style="border-bottom: 2px solid black;">Agent Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total_due = 0;
                                                $total_paid = 0;
                                            @endphp
                                            @foreach ($salesReport as $report)
                                                @php
                                                    $total_due += $report['due_amount'];
                                                    $total_paid += $report['paid_amount'];
                                                @endphp
                                                <tr>
                                                    <!-- Invoice ID + Heading -->
                                                    <td>{{ $report['heading'] }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-primary text-white">{{ $report['invoice_id'] }}</span>
                                                    </td>

                                                    <!-- Client Name -->
                                                    <td>{{ $report['client_name'] }}</td>

                                                    <!-- All Items with Quantities -->
                                                    <td>
                                                        @if (!empty($report['items']))
                                                            @foreach ($report['items'] as $item)
                                                                <span
                                                                    class="badge bg-info text-white">{{ $item['name'] }}: {{ $item['quantity'] }}</span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">No Items</span>
                                                        @endif
                                                    </td>

                                                    <!-- Amounts -->
                                                    <td>{{ number_format($report['due_amount'], 2) }}</td>
                                                    <td>{{ number_format($report['paid_amount'], 2) }}</td>

                                                    <!-- Status -->
                                                    <td>
                                                        @if ($report['status'] == 'Not Paid' || $report['status'] == 1)
                                                            <span class="badge bg-danger text-white">Not Paid</span>
                                                        @elseif ($report['status'] == 'Partial Payment' || $report['status'] == 2)
                                                            <span class="badge bg-warning text-white">Partial Payment</span>
                                                        @elseif ($report['status'] == 'Fully Paid' || $report['status'] == 3)
                                                            <span class="badge bg-success text-white">Fully Paid</span>
                                                        @else
                                                            <span class="badge bg-secondary text-white">No Status ({{ $report['status'] }})</span>
                                                        @endif
                                                    </td>

                                                    <!-- Agent -->
                                                    <td>{{ $report['user_agent'] }}</td>
                                                </tr>
                                            @endforeach

                                            <!-- Totals Row -->
                                            <tr style="border-top: 2px solid black; font-weight: bold;">
                                                <td colspan="4">TOTALS</td>
                                                <td>{{ number_format($total_due, 2) }}</td>
                                                <td>{{ number_format($total_paid, 2) }}</td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="mt-3">
                                        {{ $salesReport->appends(request()->query())->links() }}
                                    </div>
                                </div>
                            @else
                                <p class="mt-3 text-center">No sales records found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
