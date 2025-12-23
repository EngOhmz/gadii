@extends('layouts.master')

@section('content')
<section class="section">
    <div class="section-body">
        @include('layouts.alerts.message')
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Message For Expired Users</h4>
                    </div>
                    <div class="card-body">

                    <div class="panel-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                   
                    <form class="form-horizontal" method="POST" action="{{ route('expired_users.store') }}">
                        {{ csrf_field() }}

                     
                        
                        <div class="form-group">
                                    <label for="smsBody" class="col-md-4 control-label"><strong>Message</strong></label>
                                    <div class="col-md-6">
                                        <textarea name="smsBody" id="smsBody" class="form-control"  cols="40" rows="5" placeholder="Write Your Message"  value="{{ old('smsBody') }}" autofocus></textarea>
                                    </div>
                        </div>

                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection