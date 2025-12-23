@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Client Points Report</h4>
                    </div>
                    <div class="card-body">
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                <br>
                                @if(!empty($start_date) && !empty($end_date))
                                    <div class="panel-heading">
                                        <h6 class="panel-title">
                                            For the period: <b>{{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} to {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}}</b>
                                        </h6>
                                    </div>
                                    <br>
                                @endif
                                <div class="panel-body hidden-print">
                                    {!! Form::open(['url' => route('pos.client_point_report'), 'method' => 'post', 'class' => 'form-horizontal', 'name' => 'form', 'id' => 'filterForm']) !!}
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="">Start Date</label>
                                            <input name="start_date" id="start_date" type="date" class="form-control date-picker" required value="{{ $default_start_date }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="">End Date</label>
                                            <input name="end_date" id="end_date" type="date" class="form-control date-picker" required value="{{ $default_end_date }}">
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <button type="submit" class="btn btn-success" id="btnFiterSubmitSearch">Search</button>
                                            <a href="{{ route('pos.client_point_report') }}" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>

                                <br>
                                @if(!empty($report))
                                    <div class="panel panel-white">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table datatable-button-html5-basic" id="clientTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Client Name</th>
                                                            <th>Amount</th>
                                                            <th>Points Collected</th>
                                                            <th>Badge</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($report as $index => $item)
                                                            <tr>
                                                                <td>{{ $item['client_name'] }}</td>
                                                                <td>{{ number_format($item['total_amount'], 2) }}</td>
                                                                <td>{{ $item['points'] }}</td>
                                                                <td>
                                                                    @if($index === 0)
                                                                        <span class="badge badge-success">Top Rated Customer</span>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td>Total</td>
                                                            <td>{{ number_format(array_sum(array_column($report, 'total_amount')), 2) }}</td>
                                                            <td>{{ array_sum(array_column($report, 'points')) }}</td>
                                                            <td>-</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
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