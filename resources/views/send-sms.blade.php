@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Send SMS</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="single-tab" data-toggle="tab"
                                    href="#single" role="tab" aria-controls="single" aria-selected="true">Single SMS</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="bulk-tab" data-toggle="tab"
                                    href="#bulk" role="tab" aria-controls="bulk" aria-selected="false">Bulk SMS</a>
                            </li>
                        </ul>

                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade active show" id="single" role="tabpanel"
                                aria-labelledby="single-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('send.sms.single') }}">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Phone Number</label>
                                                <div class="col-lg-10">
                                                    <input type="text" name="phone" class="form-control"
                                                        placeholder="e.g., 255774208208" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Message</label>
                                                <div class="col-lg-10">
                                                    <textarea name="message" class="form-control" rows="3" 
                                                        maxlength="160" placeholder="Enter your message..." required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Reference</label>
                                                <div class="col-lg-10">
                                                    <input type="text" name="reference" class="form-control"
                                                        placeholder="e.g., xaefcgt">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-offset-2 col-lg-12">
                                                    <button type="submit" class="btn btn-sm btn-primary float-right">
                                                        Send Single SMS
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="bulk" role="tabpanel"
                                aria-labelledby="bulk-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('send.sms.bulk') }}">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Phone Numbers</label>
                                                <div class="col-lg-10">
                                                    <input type="text" name="phones" class="form-control"
                                                        placeholder="e.g., 255774208208, 255716718040" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Message</label>
                                                <div class="col-lg-10">
                                                    <textarea name="message" class="form-control" rows="3"
                                                        maxlength="160" placeholder="Enter your message..." required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Reference</label>
                                                <div class="col-lg-10">
                                                    <input type="text" name="reference" class="form-control"
                                                        placeholder="e.g., xaefcgt">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-offset-2 col-lg-12">
                                                    <button type="submit" class="btn btn-sm btn-primary float-right">
                                                        Send Bulk SMS
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (session('sms_response'))
                            <div class="table-responsive mt-4">
                                <h5>SMS Status</h5>
                                <table class="table datatable-basic table-striped">
                                    <thead>
                                        <tr>
                                            <th>To</th>
                                            <th>Status</th>
                                            <th>Message ID</th>
                                            <th>SMS Count</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (session('sms_response') as $message)
                                            <tr>
                                                <td>{{ $message['to'] }}</td>
                                                <td>{{ $message['status']['name'] }} ({{ $message['status']['description'] }})</td>
                                                <td>{{ $message['messageId'] }}</td>
                                                <td>{{ $message['smsCount'] }}</td>
                                                <td>{{ $message['message'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection