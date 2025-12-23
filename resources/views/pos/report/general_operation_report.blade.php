@extends('layouts.master')


@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>General Report</h4>
                        </div>
                        <div class="card-body">

                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">


                                    <br>
                                    <div class="panel-heading">
                                        <h6 class="panel-title">

                                            @if (!empty($start_date))
                                                For the period: <b>{{ Carbon\Carbon::parse($start_date)->format('d/m/Y') }}
                                                    to {{ Carbon\Carbon::parse($end_date)->format('d/m/Y') }}</b>
                                            @endif
                                        </h6>
                                    </div>

                                    <br>
                                    <div class="panel-body hidden-print">
                                        {!! Form::open(['url' => '#', 'method' => 'post', 'class' => 'form-horizontal', 'name' => 'form']) !!}
                                        <div class="row">

                                            <div class="col-md-4">
                                                <label class="">Start Date</label>
                                                <input name="start_date" id="start_date" type="date"
                                                    class="form-control date-picker" required value="<?php
                                                    if (!empty($start_date)) {
                                                        echo $start_date;
                                                    } else {
                                                        echo date('Y-m-d', strtotime('first day of january this year'));
                                                    }
                                                    ?>">

                                            </div>
                                            <div class="col-md-4">
                                                <label class="">End Date</label>
                                                <input name="end_date" id="end_date" type="date"
                                                    class="form-control date-picker" required value="<?php
                                                    if (!empty($end_date)) {
                                                        echo $end_date;
                                                    } else {
                                                        echo date('Y-m-d');
                                                    }
                                                    ?>">
                                            </div>




                                            <div class="col-md-4">
                                                <label class="">Supplier</label>

                                                <select name="location_id" class="form-control m-b location"
                                                    id="location_id" required>
                                                    <option value="">Select Supplier</option>
                                                    @if (!empty($location[0]))
                                                        @foreach ($location as $br)
                                                            <option value="{{ $br->id }}"
                                                                @if (isset($location_id)) {{ $location_id == $br->id ? 'selected' : '' }} @endif>
                                                                {{ $br->name }}</option>
                                                        @endforeach
                                                        <option value="<?php echo trim(json_encode($x), '[]'); ?>"
                                                            @if (isset($location_id)) {{ $location_id == $a ? 'selected' : '' }} @endif>
                                                            All Location</option>
                                                    @endif
                                                </select>

                                            </div>

                                            <div class="col-md-4">
                                                <label class=""></label>Sales [PI/I/DN]

                                                <select name="location_id" class="form-control m-b location"
                                                    id="location_id" required>
                                                    <option value="">Select Sales</option>
                                                    @if (!empty($location[0]))
                                                        @foreach ($location as $br)
                                                            <option value="{{ $br->id }}"
                                                                @if (isset($location_id)) {{ $location_id == $br->id ? 'selected' : '' }} @endif>
                                                                {{ $br->name }}</option>
                                                        @endforeach
                                                        <option value="<?php echo trim(json_encode($x), '[]'); ?>"
                                                            @if (isset($location_id)) {{ $location_id == $a ? 'selected' : '' }} @endif>
                                                            All Location</option>
                                                    @endif
                                                </select>

                                            </div>


                                            <div class="col-md-4">
                                                <br><button type="submit" class="btn btn-success"
                                                    id="btnFiterSubmitSearch">Search</button>
                                                <a href="{{ Request::url() }}"class="btn btn-danger">Reset</a>

                                            </div>
                                        </div>

                                        {!! Form::close() !!}

                                    </div>

                                    <!-- /.panel-body -->



                                    <br>


                                 
                                @endsection

