@extends('layout.master')

@push('plugin-styles')
    {!! Html::style('assets/css/tables/tables.css') !!}
    {!! Html::style('plugins/bootstrap-select/bootstrap-select.min.css') !!}
    {!! Html::style('assets/css/forms/form-widgets.css') !!}
@endpush

@section('content')
    <!--  Navbar Starts / Breadcrumb Area  -->
    <div class="sub-header-container">
        <header class="header navbar navbar-expand-sm">
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
                <i class="las la-bars"></i>
            </a>
            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">
                        <nav class="breadcrumb-one" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">{{__('Starter')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><span>{{__('Create Bar')}}</span></li>
                            </ol>
                        </nav>
                    </div>
                </li>
            </ul>
        </header>
    </div>
    <!--  Navbar Ends / Breadcrumb Area  -->
    <!-- Main Body Starts -->
    <div class="layout-px-spacing">
        <div class="layout-top-spacing mb-2">
            <div class="col-md-12">
                <div class="row">
                    <div class="container p-0">
                        <div class="row layout-top-spacing">
                            <div class="col-lg-12 layout-spacing">

                            {{-- new codes start--}}
                            <form action="{{ route('bar_home.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="statbox widget box box-shadow mb-4">
                                    <div class="widget-content widget-content-area">
                                        <div class="form-group row">
                                            <div class="col-lg-3 col-sm-12">
                                                <label class="col-form-label">{{__('Forms.bar_name')}}</label>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="name" id="name" placeholder="" value="" required="">
                                                    <span class="form-text text-muted">{{__('Forms.please_enter_your_bar_name')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-3 col-sm-12">
                                                <label class="col-form-label">{{__('Forms.manager')}}</label>
                                            </div>
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="manager"  id="name" placeholder="" value="" required="">
                                                    <span class="form-text text-muted">{{__('Forms.please_enter_manager_name')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-3 col-sm-12">
                                                <label class="col-form-label">{{__('Forms.store_location')}}</label>
                                            </div>
                                            
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <div class="form-group">
                                                    <select name="store_location_id" class="selectpicker w-100" data-live-search="true" required="">
                                                        <option selected value="">{{__('Forms.please_select_store')}}</option>
                                                        @if(!blank($locations))
                                                            @foreach($locations as $location)
                                                                <option value="{{ $location->id }}"
                                                                    {{ (old('restaurant_id') == $location->id) ? 'selected' : '' }}>{{ $location->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="form-text text-muted">{{__('Forms.please_select_store')}}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-3 col-sm-12">
                                                <label class="col-form-label">{{__('Forms.status')}}</label>
                                            </div>
                                            
                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                <div class="form-group">
                                                    <select name="status" class="selectpicker w-100" data-live-search="true" required="">
                                                        <option selected value="">{{__('Forms.please_select_status')}}</option>
                                                        @foreach(trans('statuses') as $bar_statusKey => $bar_status)
                                                        <option value="{{ $bar_statusKey }}"
                                                            {{ (old('bar_status') == $bar_statusKey) ? 'selected' : '' }}>
                                                            {{ $bar_status }}</option>
                                                    @endforeach
                                                    </select>
                                                    <span class="form-text text-muted">{{__('Forms.please_select_status')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </div>
                                    <div class="widget-footer text-right">
                                        <button type="submit" class="btn btn-primary mr-2">{{__('Forms.submit')}}</button>
                                    </div>
                                    
                                </div>
                            </form>
                                {{-- new codes ends --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Body Ends -->
@endsection

@push('plugin-scripts')
{!! Html::script('assets/js/forms/forms-layouts.js') !!}
{!! Html::script('plugins/bootstrap-select/bootstrap-select.min.js') !!}
@endpush

@push('custom-scripts')

@endpush
