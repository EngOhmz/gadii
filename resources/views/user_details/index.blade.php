@extends('layouts.master')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>User Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-2">
                                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'basic' || $type == 'edit-basic') active  @endif" onclick="{ $type = 'preparation'}" id="#tab1" data-toggle="tab"
                                            href="#tab1" role="tab" aria-controls="home"
                                            aria-selected="true">Basic Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'bank' || $type == 'edit-bank') active  @endif" onclick="{ $type = 'bank'}" id="#tab2" data-toggle="tab"
                                            href="#tab2" role="tab" aria-controls="profile"
                                            aria-selected="false">Bank Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'fertilizer') active  @endif" onclick="{ $type = 'fertilizer'}" id="#fertilizer" data-toggle="tab"
                                            href="#fertilizer" role="tab" aria-controls="profile"
                                            aria-selected="false">Document Details</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'irrigation') active  @endif" onclick="{ $type = 'irrigation'}" id="#irrigation" data-toggle="tab"
                                            href="#irrigation" role="tab" aria-controls="profile"
                                            aria-selected="false">Sarary Details</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'sowings') active  @endif" onclick="myFunction()" id="#tab2" data-toggle="tab"
                                            href="#tab2" role="tab" aria-controls="profile"
                                            aria-selected="false">Time Cards Details</a>
                                    </li>
                                    
                                    
                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'pestiside') active  @endif" onclick="{ $type = 'pestiside'}" id="#pestiside" data-toggle="tab"
                                            href="#pestiside" role="tab" aria-controls="profile"
                                            aria-selected="false">Leave Details</a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'pre_harvest') active  @endif" onclick="{ $type = 'pre_harvest'}" id="#pre_harvest" data-toggle="tab"
                                            href="#pre_harvest" role="tab" aria-controls="profile"
                                            aria-selected="false">Provident Fund</a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'post_harvest') active  @endif" onclick="{ $type = 'post_harvest'}" id="#post_harvest" data-toggle="tab"
                                            href="#post_harvest" role="tab" aria-controls="profile"
                                            aria-selected="false">Overtime Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'post_harvest') active  @endif" onclick="{ $type = 'post_harvest'}" id="#post_harvest" data-toggle="tab"
                                            href="#post_harvest" role="tab" aria-controls="profile"
                                            aria-selected="false">Task Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'post_harvest') active  @endif" onclick="{ $type = 'post_harvest'}" id="#post_harvest" data-toggle="tab"
                                            href="#post_harvest" role="tab" aria-controls="profile"
                                            aria-selected="false">Projects Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'post_harvest') active  @endif" onclick="{ $type = 'post_harvest'}" id="#post_harvest" data-toggle="tab"
                                            href="#post_harvest" role="tab" aria-controls="profile"
                                            aria-selected="false">Client Issues</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if($type == 'post_harvest') active  @endif" onclick="{ $type = 'post_harvest'}" id="#post_harvest" data-toggle="tab"
                                            href="#post_harvest" role="tab" aria-controls="profile"
                                            aria-selected="false">Activities</a>
                                    </li>


                                </ul>
                            </div>
                            <div class="col-12 col-sm-12 col-md-10">
                                <div class="tab-content no-padding" id="myTab2Content">
                                 
                                 @include('user_details.tabs.tab1')
                                 @include('user_details.tabs.tab2')
                                 @include('user_details.tabs.tab3')
                                 @include('user_details.tabs.tab4')
                                 @include('user_details.tabs.tab5')
                                 @include('user_details.tabs.tab6')
                                 @include('user_details.tabs.tab7')
                                 @include('user_details.tabs.tab8')
                                 @include('user_details.tabs.tab9')
                                 @include('user_details.tabs.tab10')
                                 @include('user_details.tabs.tab11')
                                 @include('user_details.tabs.tab12')
                                  
                                








                               
                               
                               
 

                                </div>
         
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
 
</section>
<div class="modal fade bd-example-modal-lg" id="appFormModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

    </div>
</div>
@endsection

@section('scripts')
<script>
    function myFunction() {
       // alert('hellow')
  //var element = document.getElementById("#tab2");
  //element.classList.add("active");
}
</script>
@endsection

