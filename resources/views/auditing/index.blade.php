@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-body text-primary">
                <h2 class="h3 mb-0 text-gray-800">
                    <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/40C057/total-sales-1.png"/>
                    Auditing Report
                </h2>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Auditings Report</h4>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['url' => request()->fullUrl(), 'method' => 'GET', 'class'=>'form-horizontal']) !!}
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Start Date</label>
                                    <input name="start_date" type="date" class="form-control"
                                           value="{{ request('start_date', date('Y-m-d', strtotime('first day of january this year'))) }}">
                                </div>
                                <div class="col-md-4">
                                    <label>End Date</label>
                                    <input name="end_date" type="date" class="form-control"
                                           value="{{ request('end_date', date('Y-m-d')) }}">
                                </div>
                        
                                <div class="col-md-4">
                                    <label>Report Types</label>
                                    <select name="report_type" class="form-control">
                                        <option value="">Select Report Type</option>
                                        <option value="Sales" {{ request('report_type') == 'Sales' ? 'selected' : '' }}>
                                          Sales Report
                                        </option>
                                        <option
                                            value="Lead" {{ request('report_type') == 'Lead' ? 'selected' : '' }}>
                                            Leads Report
                                        </option>
                                        <option
                                            value="HR" {{ request('report_type') == 'HR' ? 'selected' : '' }}>
                                            HR Report
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <button type="submit" class="btn btn-success">Search</button>
                                    <a href="{{ url()->current() }}" class="btn btn-danger">Reset</a>
                                </div>
                            </div>
                            {!! Form::close() !!}

                            @if($salesReport->count())
                                <!-- Dynamic Header Based on Filters -->
                                <div class="mt-4">
                                    <h5>Showing results from
                                        <strong>{{ request('start_date', date('Y-m-d', strtotime('first day of january this year'))) }}</strong>
                                        to <strong>{{ request('end_date', date('Y-m-d')) }}</strong>
                                        @if(request('location'))
                                            at
                                            <strong>{{ request('location') == 'all' ? 'All Locations' : $locations->where('id', request('location'))->first()->name }}</strong>
                                        @endif
                                        @if(request('report_type'))
                                            for <strong>{{ request('report_type') }}</strong>
                                        @endif
                                    </h5>
                                </div>

                                <div class="table-responsive mt-4">
                                    <table class="table datatable-button-html5-basic">
                                        <thead>
                                        <tr>
                                            <th style="border-bottom: 2px solid black;">SN</th>
                                            <th style="border-bottom: 2px solid black;">Module</th>
                                            <th style="border-bottom: 2px solid black;">Activity</th>
                                            <th style="border-bottom: 2px solid black;">Date</th>
                              
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $total_due = 0;
                                            $total_paid = 0;
                                        @endphp
                                        @foreach ($salesReport as $report)
          
                                            <tr>
                                                <td>
                                                    <span
                                                        class=" ">{{ ++$loop->index }}</span>
                                                </td>

                                                <td>{{ $report['module'] }}</td>
                                                <td>{{ $report['activity'] }}</td>
                                                <td>{{ $report['date'] }}</td>
                                        
                                            </tr>
                                        @endforeach
                                        <!-- Totals Row -->
                                       
                                        </tbody>
                                    </table>
                                    <div class="mt-3">
                                        {{ $salesReport->appends(request()->query())->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            @else
                                <p class="mt-3 text-center">No records found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

