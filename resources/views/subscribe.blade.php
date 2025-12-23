@extends('layouts.master23')

@section('content')
    <section class="section">
            <div class="row">
            
                <div class="col-12">
                <div class="card">
                 <div class="card-body">
                 @if(auth()->user()->added_by == auth()->user()->id )
                 <center>
                        <p>Your Subscription time has ended.Please Subscribe.</p>
                    </center>
                    <center>
                        <img class="pl-lg" src="{{ asset('subs_image.jpg') }}" width="60%"/>
                        <p><a href="{{ route('azampay.index2')}}">Please, Subscribe now</a></p>
                    </center>
                    @else
                     <center>
                        <p>Your Subscription time has ended.Please Contact your Sytem Admin to subscribe now.</p>
                    </center>
                    <center>
                        <img class="pl-lg" src="{{ asset('subs_image.jpg') }}" width="60%"/>
                        
                    </center>
                    @endif
                </div>
            </div>
           </div>
            
        </div>
    </section>
@endsection
