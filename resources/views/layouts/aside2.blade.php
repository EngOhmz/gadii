

<!-- Main sidebar -->
<div class="sidebar sidebar-light sidebar-main sidebar-expand-md">

    <!-- Sidebar content -->
    <div class="sidebar-content">
  
        <?php
        $settings = App\Models\System::where('added_by', auth()->user()->added_by)->first();
        
        ?>
        
        <style>
            .sibebarEma {
                background: url('{{ asset('/assets/img/logo/' .$settings->picture) }}') center center no-repeat;               
                background-size: cover;
            }
        </style>
        <!-- User menu -->
        <div class="sidebar-section">
            <div class="sibebarEma">
                <div class="sidebar-section-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <button type="button"
                                class="btn btn-outline-dark border-transparent btn-icon btn-sm rounded-pill">
                                <i class="icon-wrench"></i>
                            </button>
                        </div>
                        <a href="" class="flex-1 text-center"></a>
                        <div class="flex-1 text-right">
                            <button type="button"
                                class="btn btn-outline-dark border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                                <i class="icon-transmission"></i>
                            </button>
  
                            <button type="button"
                                class="btn btn-outline-dark border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
                                <i class="icon-cross2"></i>
                            </button>
                        </div>
                    </div>
  
  
                    <!--	<div class="text-center">
                        <h6 class="mb-0 text-white text-shadow-dark mt-3">{{ $settings->name }}</h6>
                        <span class="font-size-sm text-white text-shadow-dark"></span>
                    </div> -->
                </div>
  
                <div class="sidebar-user-material-footer">
                    <a href="#user-nav" class="d-flex justify-content-between align-items-center  dropdown-toggle"
                        data-toggle="collapse"></a>
                </div>
  
            </div>
  
            <div class="collapse border-bottom" id="user-nav">
                <ul class="nav nav-sidebar">
  
                    <li class="nav-item">
  
                        <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /user menu -->
  
  
        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
  
                <!-- Main -->
                <li class="nav-item-header">
                    <div class="text-uppercase font-size-xs line-height-xs mt-1">Main</div> <i class="icon-menu"
                        title="Main"></i>
                </li>
  
                <li class="nav-item">
                    <a href="{{ url('home') }}" class="nav-link  {{ request()->is('home') ? 'active' : '' }}">
                        <i class="icon-home4"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>
  
                   @can('view-supplier-menu')
                    <li class="nav-item"><a
                            class="nav-link {{ request()->is('pos/purchases/supplier*') ? 'active' : '' }}"
                            href="{{ url('pos/purchases/supplier') }}"><i
                                class="icon-briefcase"></i><span>Suppliers</span></a></li>
                @endcan
  
                @can('view-client-menu')
                    <li class="nav-item"><a class="nav-link {{ request()->is('pos/sales/client*') ? 'active' : '' }}"
                            href="{{ url('pos/sales/client') }}"><i class="icon-users"></i><span>Clients</span></a></li>
                @endcan
          
                @can('view-locaton-menu')
                    <li class="nav-item"><a class="nav-link {{ request()->is('inventory/location*') ? 'active' : '' }}"
                            href="{{ url('inventory/location') }}"><i class="icon-location4"></i><span>Store</span></a>
                    </li>
                @endcan
                
                 @can('view-destination-menu')
                    <li class="nav-item"><a class="nav-link {{ request()->is('destination.*') ? 'active' : '' }}"
                            href="{{ url('destination') }}"><i data-feather="command"
                                class="icon-airplane2"></i><span>Destination/Arrival<span></a>
                    </li>
                @endcan
                
  
                @can('view-route-menu')
                    <li class="nav-item"><a class="nav-link {{ request()->is('routes.*') ? 'active' : '' }}"
                            href="{{ url('routes') }}"><i data-feather="command"
                                class="icon-road"></i><span>Routes<span></a>
                    </li>
                @endcan
                
                        
  
                @can('view-collector')
                    <li class="nav-item"><a
                            class="nav-link {{ request()->is('logistic_driver/driver*') ? 'active' : '' }}"
                            href="{{ url('logistic_driver/driver') }}"><i
                                class="icon-gift"></i><span>Collector</span></a></li>
                @endcan
  
  
  
  
                @can('view-project-menu')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('project/project*') ? 'active' : '' }}"><i
                                class="icon-file-text"></i> <span>Project Management </span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
  
                            @can('view-project')
                            
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('project/project*') ? 'active' : '' }}"
                                        href="{{ url('project/project_categories') }}"><i></i></i>
                                        Project Categories</span></a></li>
                                        
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('project/project*') ? 'active' : '' }}"href="{{ url('project/project') }}"><i></i></i>Manage
                                        Project</span></a></li>
                            @endcan
  
  
                            @can('manage-project-items')
                            
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('pos/purchases/items*') ? 'active' : '' }}"
                                        href="{{ url('pos/purchases/items') }}"><i></i></i> 
                                        Items2</a></li>
                                        
                               
            
                            @endcan
  
  
                        </ul>
                    </li>
  
  
                @endcan

                @can('view-clearing-forwarding-menu')
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link {{ request()->is('cf/shipment/planning*') ? 'active' : '' }}"><i
                            class="icon-boat"></i> <span> Cargo Managment </span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                    
                     @can('clear-forward-client')
                            <li class="nav-item"><a class="nav-link {{ request()->is('cf/shipment/planning') ? 'active' : '' }}"
                                    href="{{ url('cf/shipment/planning') }}"><i></i> Shipment Planning & Registration </a></li>
                        @endcan
                        
                           @can('clear-forward-client')
                            <li class="nav-item"><a class="nav-link {{ request()->is('cf/shipment/tracking') ? 'active' : '' }}"
                                    href="{{ url('cf/shipment/tracking') }}"><i></i></i> Shipment Tracking </a></li>
                        @endcan                       
                
                    </ul>
                </li>


            @endcan
  
                @can('view-clearing-forwarding-menu')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('cf/*') ? 'active' : '' }}"><i
                                class="icon-ship"></i> <span>Clearing and Forwarding </span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        
                         @can('clear-forward-client')
                                <li class="nav-item"><a class="nav-link {{ request()->is('cf/cf_service') ? 'active' : '' }}"
                                        href="{{ url('cf/cf_service') }}"><i></i></i> CF Service</a></li>
                            @endcan
                            
                               @can('clear-forward-client')
                                <li class="nav-item"><a class="nav-link {{ request()->is('cf/cargo_type') ? 'active' : '' }}"
                                        href="{{ url('cf/cargo_type') }}"><i></i></i> Cargo</a></li>
                            @endcan
  
                            @can('clear-forward-file')
                                <li class="nav-item"><a class="nav-link {{ request()->is('cf/cf') ? 'active' : '' }}"
                                        href="{{ url('cf/cf') }}"><i></i></i>File</span></a></li>
                            @endcan
  
  
                         
                           
                    
                        </ul>
                    </li>
  
  
                @endcan
  
                @can('view-cargo-agency')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('project/project*') ? 'active' : '' }}"><i
                                class="icon-truck"></i> <span>Cargo Agency</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                                <li class="nav-item"><a href="{{ url('pos/sales/client') }}"
                                        class="nav-link  {{ request()->is('home') ? 'active' : '' }}">Client</span></a></li>
                                <a href="{{url('sajili_mizigo')}}"
                                        class="nav-link active' }}">Cargo</span></a></li>
                                <li class="nav-item"> <a href="{{ url('list_ya_wateja') }}"
                                        class="nav-link  {{ request()->is('home') ? 'active' : '' }}">Customer List</span></a></li>
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('management/pacel_store.*') ? 'active' : '' }}"
                                        href="{{ url('management/pacel_store') }}"> Store Records</a></li>
                                <li class="nav-item"> <a
                                        class="nav-link {{ request()->is('management/search_store.*') ? 'active' : '' }}"
                                        href="{{ url('management/search_store') }}"> Delivery Note</a></li>
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('management/search.*') ? 'active' : '' }}"
                                        href="{{ url('management/search') }}"> Customer History</a></li>
                                <li class="nav-item"> <a
                                        class="nav-link {{ request()->is('management/car_today2.*') ? 'active' : '' }}"
                                        href="{{ url('management/car_today2') }}"> Active Cars</a></li>
                                <li class="nav-item"> <a
                                        class="nav-link {{ request()->is('management/arrived_car.*') ? 'active' : '' }}"
                                        href="{{ url('management/arrived_car') }}"> Arrived Cars</a></li>
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('management/all_car.*') ? 'active' : '' }}"
                                        href="{{ url('management/all_car') }}"> All Cars</a></li>
                        </ul>
                    </li>
  
  
                @endcan
  
                @can('view-goal-menu')
                    <li class="nav-item"><a class="nav-link {{ request()->is('project/ticket*') ? 'active' : '' }}"
                            href="{{ route('goal.index') }}"><i class="icon-move"></i><span>Goal Tracking </span></a>
                    </li>
                @endcan
  
  
  
  
                @can('view-ticket-menu')
                    <li class="nav-item"><a class="nav-link {{ request()->is('project/ticket*') ? 'active' : '' }}"
                            href="{{ url('project/ticket') }}"><i class="icon-ticket"></i><span>Ticket
                                Management</span></a>
                    </li>
                @endcan
  
                @can('milestone-menu')
                    <li class="nav-item"><a class="nav-link {{ request()->is('project/milestone*') ? 'active' : '' }}"
                            href="{{ url('project/milestone') }}"><i class="icon-rocket"></i><span>Milestone
                                Management</span></a>
                    </li>
                @endcan
  
                @can('view-calendar-menu')
                    <li class="nav-item"><a class="nav-link {{ request()->is('project/calendar*') ? 'active' : '' }}"
                            href="{{ url('project/calendar') }}"><i class="icon-calendar2"></i><span>Calendar</span></a>
                    </li>
                @endcan
  
                @can('view-tasks-menu')
                    <li class="nav-item"><a class="nav-link {{ request()->is('project/task*') ? 'active' : '' }}"
                            href="{{ url('project/task') }}"><i class="icon-task"></i><span>Task Management</span></a>
                    </li>
                @endcan
  
                @can('view-leads-menu')
                    {{--<li class="nav-item"><a class="nav-link {{ request()->is('leads*') ? 'active' : '' }}"
                            href="{{ url('leads') }}"><i class="icon-people"></i><span>
                            Leads</span></a>
                    </li>--}}
                    
                  
                  <li class="nav-item nav-item-submenu">
                      <a href="#" class="nav-link {{ request()->is('leads*') ? 'active' : '' }}"><i
                          class="icon-people"></i> <span>Leads</span></a>
                              <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                              
                                <li class="nav-item"> <a href="{{ url('leads') }}"
                                class="nav-link  {{ request()->is('leads') ? 'active' : '' }}">
                                Leads</span></a></li>
                                
                                <li class="nav-item"> <a href="{{ url('leads_source') }}"
                                class="nav-link  {{ request()->is('leads_source') ? 'active' : '' }}">
                                Lead Source</span></a></li>
                                
                                <li class="nav-item"> <a href="{{ url('leads_status') }}"
                                class="nav-link  {{ request()->is('leads_status') ? 'active' : '' }}">
                                Lead Status</span></a></li>
                                
                              </ul>
                    </li>
          
          
                @endcan
  
  
  
  
  
                @can('view-cargo-menu')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('courier/*') ? 'active' : '' }}"><i
                                class="icon-package"></i> <span>Cargo Management</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Sidebars">
  
                            <li class="nav-item nav-item-submenu">
                                <a href="#" class="nav-link {{ request()->is('pacel/*') ? 'active' : '' }} ">
                                    Cargo Management</a>
                                <ul class="nav nav-group-sub">
                               
                                    @can('view-cargo-quotation')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pacel/pacel_quotation*') ? 'active' : '' }}"
                                                href="{{ url('pacel/pacel_quotation') }}">Quotation</a></li>
                                    @endcan
                                    @can('view-cargo-invoice')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pacel/pacel_invoice*') ? 'active' : '' }}"
                                                href="{{ url('pacel/pacel_invoice') }}">Invoice</a></li>
                                    @endcan
                                    @can('view-cargo-mileage')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pacel/mileage*') ? 'active' : '' }}"
                                                href="{{ url('pacel/mileage') }}">Mileage List</a></li>
  
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pacel/multiple_mileage.*') ? 'active' : '' }}"
                                                href="{{ url('pacel/multiple_mileage') }}">Multiple Mileage Payment</a></li>
                                    @endcan
                                    @can('view-cargo-permit')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('permit.*') ? 'active' : '' }}"
                                                href="{{ url('permit') }}">Border Permit List</a></li>
  
  
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('multiple_permit.*') ? 'active' : '' }}"
                                                href="{{ url('multiple_permit') }}">Multiple Border Payment</a></li>
                                    @endcan
                                </ul>
                            </li>
  
  
  
                            <li class="nav-item nav-item-submenu">
                                <a href="#" class="nav-link {{ request()->is('tracking/*') ? 'active' : '' }}">
                                    <span>Cargo Tracking</span></a>
  
                                <ul class="nav nav-group-sub">
                                    @can('view-cargo-collection')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('tracking/collection*') ? 'active' : '' }}"
                                                href="{{ url('tracking/collection') }}"> Cargo List</a></li>
                                    @endcan
                                    @can('view-cargo-loading')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('tracking/loading*') ? 'active' : '' }}"
                                                href="{{ url('tracking/loading') }}"> Loading</a></li>
                                    @endcan
                                    @can('view-cargo-offloading')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('tracking/offloading*') ? 'active' : '' }}"
                                                href="{{ url('tracking/offloading') }}"> Offloading</a></li>
                                    @endcan
                                    @can('view-cargo-delivering')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('tracking/delivering*') ? 'active' : '' }}"
                                                href="{{ url('tracking/delivering') }}">Delivery</a></li>
                                    @endcan
                                    @can('view-cargo-wb')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('tracking/wb*') ? 'active' : '' }}"
                                                href="{{ url('tracking/wb') }}">Create WB</a></li>
                                    @endcan
                                    @can('view-cargo-activity')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('tracking/activity*') ? 'active' : '' }}"
                                                href="{{ url('tracking/activity') }}">Track Logistic Activity</a>
                                        </li>
                                    @endcan
                                    @can('view-cargo-order_report')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('tracking/order_report*') ? 'active' : '' }}"
                                                href="{{ url('tracking/order_report') }}">Uplift Report</a></li>
                                    @endcan
                                    @can('view-cargo-truck_mileage')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('tracking/truck_mileage*') ? 'active' : '' }}"
                                                href="{{ url('tracking/truck_mileage') }}">Return Truck Fuel &
                                                Mileage</a></li>
                                    @endcan
                                </ul>
                            </li>
  
                        </ul>
                    </li>
                @endcan
  
  
  
  
  
                @can('view-courier-menu')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('courier/*') ? 'active' : '' }}"><i
                                class="icon-car"></i> <span>Courier Management</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Sidebars">
  
  
                            <li class="nav-item nav-item-submenu">
                                <a href="#"
                                    class="nav-link {{ request()->is('courier/courier_client*') ? 'active' : '' }}">Courier
                                    Settings</a>
                                <ul class="nav nav-group-sub">
                                    @can('view-courier_client')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/courier_settings*') ? 'active' : '' }}"
                                                href="{{ url('courier/courier_settings') }}">Courier Settings</a></li>
                                    @endcan
                                    @can('view-courier_client')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/courier_client*') ? 'active' : '' }}"
                                                href="{{ url('courier/courier_client') }}">Client List</a></li>
                                    @endcan
                                    @can('view-courier_tariff')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/zones*') ? 'active' : '' }}"
                                                href="{{ url('courier/zones') }}">Zones</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/tariff*') ? 'active' : '' }}"
                                                href="{{ url('courier/tariff') }}">Tariff</a></li>
                                    @endcan
                                </ul>
                            </li>
  
  
  
                            <li class="nav-item nav-item-submenu">
                                <a href="#"
                                    class="nav-link {{ request()->is('courier/courier_*') ? 'active' : '' }}">Courier
                                    Tracking</a>
                                <ul class="nav nav-group-sub">
                                    @can('view-courier_pickup')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/courier_pickup*') ? 'active' : '' }}"
                                                href="{{ url('courier/courier_pickup') }}">Request Pickup</a></li>
                                    @endcan
                                    @can('view-courier_quotation')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/courier_quotation*') ? 'active' : '' }}"
                                                href="{{ url('courier/courier_quotation') }}">Courier Quotation</a></li>
                                    @endcan
  
                                    @can('view-courier_collection')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/courier_collection*') ? 'active' : '' }}"
                                                href="{{ url('courier/courier_collection') }}"> Courier
                                                Packaging</a></li>
                                    @endcan
                                    @can('view-courier_loading')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/courier_loading*') ? 'active' : '' }}"
                                                href="{{ url('courier/courier_loading') }}"> Courier Freight</a>
                                        </li>
                                    @endcan
                                    @can('view-courier_offloading')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/courier_offloading*') ? 'active' : '' }}"
                                                href="{{ url('courier/courier_offloading') }}"> Courier
                                                Destination</a></li>
                                    @endcan
                                    @can('view-courier_delivering')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/courier_delivering*') ? 'active' : '' }}"
                                                href="{{ url('courier/courier_delivering') }}"> Courier
                                                Delivery</a></li>
                                    @endcan
                                    @can('view-courier_delivering')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/courier_delivered*') ? 'active' : '' }}"
                                                href="{{ url('courier/courier_delivered') }}"> Courier Delivered
                                            </a></li>
                                    @endcan
  
  
                                </ul>
                            </li>
  
                            <li class="nav-item nav-item-submenu">
                                <a href="#"
                                    class="nav-link {{ request()->is('courier/courier_invoice*') ? 'active' : '' }}">Courier
                                    Sales</a>
                                <ul class="nav nav-group-sub">
                                    @can('view-courier_delivering')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/courier_wb*') ? 'active' : '' }}"
                                                href="{{ url('courier/courier_wb') }}"> Delivered Package
                                            </a></li>
                                    @endcan
  
                                    @can('view-courier_invoice')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/courier_invoice*') ? 'active' : '' }}"
                                                href="{{ url('courier/courier_invoice') }}">Invoice</a></li>
                                    @endcan
  
                                    @can('view-courier-proforma')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/courier_profoma_invoice*') ? 'active' : '' }}"
                                                href="{{ url('courier/courier_profoma_invoice') }}">Proforma Invoice
                                            </a></li>
                                    @endcan
  
  
                                </ul>
                            </li>
  
  
  
  
                            <li class="nav-item nav-item-submenu">
                                <a href="#"
                                    class="nav-link {{ request()->is('courier/payment*') ? 'active' : '' }}">Courier
                                    Payment</a>
                                <ul class="nav nav-group-sub">
                                    @can('courier-payment-list')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/payment_list') ? 'active' : '' }}"
                                                href="{{ url('courier/payment_list') }}">Payment List</a></li>
                                    @endcan
  
                                    @can('courier-multiple-payment')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/multiple_payment') ? 'active' : '' }}"
                                                href="{{ url('courier/multiple_payment') }}"> Multiple Payment</a></li>
                                    @endcan
                                </ul>
                            </li>
  
  
  
  
                            <li class="nav-item nav-item-submenu">
                                <a href="#"
                                    class="nav-link {{ request()->is('courier/courier_*') ? 'active' : '' }}">Courier
                                    Report</a>
                                <ul class="nav nav-group-sub">
                                    {{--
                  @can('view-courier_loading')
                <li class="nav-item"><a
                        class="nav-link {{ (request()->is('courier/freight_list*')) ? 'active' : ''  }}"
                        href="{{url('courier/freight_list')}}"> Courier Freight List</a>
                </li>
                @endcan
  --}}
                                    @can('view-courier_activity')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/courier_activity*') ? 'active' : '' }}"
                                                href="{{ url('courier/courier_activity') }}">Track Courier
                                                Activity</a></li>
                                    @endcan
                                    @can('view-courier_report')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/courier_report*') ? 'active' : '' }}"
                                                href="{{ url('courier/courier_report') }}"> Courier Management
                                                Report</a></li>
                                    @endcan
  
                                    @can('view-courier_report')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/cost_report*') ? 'active' : '' }}"
                                                href="{{ url('courier/cost_report') }}"> Courier Cost
                                                Report</a></li>
                                    @endcan
                                    @can('view-courier_activity')
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('courier/courier_tracking*') ? 'active' : '' }}"
                                                href="{{ url('courier/courier_tracking') }}">Courier Tracking
                                            </a></li>
                                    @endcan
  
                                </ul>
                            </li>
  
  
                        </ul>
                    </li>
                @endcan


                @can('view-pos-menu')
                    <li class="nav-item"><a
                            class="nav-link {{ request()->is('management/assets*') ? 'active' : '' }}"
                            href="{{ url('management/assets') }}"><i
                                class="icon-gift"></i><span>Assets</span></a></li>
                @endcan
  
      
  
                @can('view-pos-menu')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('pos/*') ? 'active' : '' }}"><i
                                class="icon-basket"></i> <span>POS</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Sidebars">
  
                            @can('view-purchase')
                                <li class="nav-item nav-item-submenu">
                                    <a href="#"
                                        class="nav-link {{ request()->is('pos/purchases*') ? 'active' : '' }}">Purchases</a>
                                    <ul class="nav nav-group-sub">
  
                                        @can('view-items')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('pos/purchases/items*') ? 'active' : '' }}"
                                                    href="{{ url('pos/purchases/items') }}">Manage Items</a></li>
  
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('pos/purchases/category*') ? 'active' : '' }}"
                                                    href="{{ url('pos/purchases/category') }}">Manage Categories</a></li>
                                                    
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('pos/purchases/color*') ? 'active' : '' }}"
                                                    href="{{ url('pos/purchases/color') }}">Manage Color</a></li>
                                                     <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('pos/purchases/size*') ? 'active' : '' }}"
                                                    href="{{ url('pos/purchases/size') }}">Manage Size</a></li>
                                            
                                        @endcan
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/purchases/purchase*') ? 'active' : '' }}"
                                                href="{{ url('pos/purchases/purchase') }}">Manage Purchases</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/purchases/debit_note*') ? 'active' : '' }}"
                                                href="{{ url('pos/purchases/debit_note') }}">Debit Note</a></li>
  
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/purchases/purchase_payment*') ? 'active' : '' }}"
                                                href="{{ url('pos/purchases/purchase_payment') }}">Purchase Payments</a></li>
  
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/purchases/creditors_report*') ? 'active' : '' }}"
                                                href="{{ url('pos/purchases/creditors_report') }}">Creditors Report</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/purchases/creditors_summary_report*') ? 'active' : '' }}"
                                                href="{{ url('pos/purchases/creditors_summary_report') }}">Creditors Summary
                                                Report</a></li>
  
  
                                    </ul>
                                </li>
                            @endcan
  
  
                            @can('manage-stock')
                                <li class="nav-item nav-item-submenu">
                                    <a href="#"
                                        class="nav-link {{ request()->is('pos/purchases*') ? 'active' : '' }}">Manage
                                        Stock</a>
                                    <ul class="nav nav-group-sub">
  
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/purchases/pos_issue*') ? 'active' : '' }}"
                                                href="{{ url('pos/purchases/pos_issue') }}">Good Issue</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/purchases/stock_movement*') ? 'active' : '' }}"
                                                href="{{ url('pos/purchases/stock_movement') }}">Stock Movement</a></li>
                                               
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/purchases/disposal*') ? 'active' : '' }}"
                                                href="{{ url('pos/purchases/disposal') }}">Good Disposal</a></li>
                                             {{--    
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/purchases/assign_expire*') ? 'active' : '' }}"
                                                href="{{ url('pos/purchases/assign_expire') }}">Assign Expire Date</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/purchases/expire_list*') ? 'active' : '' }}"
                                                href="{{ url('pos/purchases/expire_list') }}">Dispose Expired Item</a></li>
                                  --}}
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/activity*') ? 'active' : '' }}"
                                                href="{{ url('pos/activity') }}"> Track POS Activity</a></li>
  
                                    </ul>
                                </li>
                            @endcan
  
                            @can('view-sales')
                                <li class="nav-item nav-item-submenu">
                                    <a href="#"
                                        class="nav-link {{ request()->is('pos/sales*') ? 'active' : '' }}">Sales</a>
                                    <ul class="nav nav-group-sub">
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/sales/profoma_invoice*') ? 'active' : '' }}"
                                                href="{{ url('pos/sales/profoma_invoice') }}">Profoma Invoice</a></li>
                                        
                                            @can('view-invoice-menu')
                                                <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/sales/invoice*') ? 'active' : '' }}"
                                                href="{{ url('pos/sales/invoice') }}">Invoices</a></li>
  
                                                @endcan

                                             @can('view-invoice-menu')
                                                <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/sales/delivery_note*') ? 'active' : '' }}"
                                                href="{{ url('pos/sales/delivery_note') }}">Delivery Note</a></li>
  
                                                @endcan
  
                                                @can('view-sales-menu')
                                                <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('pos/sales/create_sales*') ? 'active' : '' }}"
                                                    href="{{ url('pos/sales/create_sales') }}">Sales</a></li>
  
                                                @endcan
  
  
                                    @can('view-make-sales-menu')
                                    <li class="nav-item"><a
                                        class="nav-link {{ request()->is('pos/sales/modified_sales*') ? 'active' : '' }}"
                                        href="{{ url('pos/sales/modified_sales') }}">Make Sales</a></li>
  
                                    @endcan
  
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/sales/credit_note*') ? 'active' : '' }}"
                                                href="{{ url('pos/sales/credit_note') }}">Credit Note</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/sales/pos_invoice_payment*') ? 'active' : '' }}"
                                                href="{{ url('pos/sales/pos_invoice_payment') }}">Invoice Payments</a></li>
  
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/sales/debtors_report*') ? 'active' : '' }}"
                                                href="{{ url('pos/sales/debtors_report') }}">Debtors Report</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/sales/debtors_summary_report*') ? 'active' : '' }}"
                                                href="{{ url('pos/sales/debtors_summary_report') }}">Debtors Summary
                                                Report</a></li>
                                                
                                                 <li class="nav-item"><a
                                                class="nav-link {{ request()->is('pos/sales/commission_report*') ? 'active' : '' }}"
                                                href="{{ url('pos/sales/commission_report') }}">Sales Commission Report</a></li>
  
                                    </ul>
                                </li>
                            @endcan
  
  
  
                        </ul>
                    </li>
                @endcan
  
  
  
  
                @can('manage-restaurant-menu')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('restaurant/*') ? 'active' : '' }}"><i
                                class="icon-store2"></i><span>Manage Restaurant</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Sidebars">
  
  
  
                            @can('view-restaurant-items')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('restaurant/restaurant_items*') ? 'active' : '' }}"
                                        href="{{ url('restaurant/restaurant_items') }}">Manage Items</a></li>
                            @endcan
  
  
  
                            @can('view-restaurant_menu')
                                <li class="nav-item ">
                                    <a class="nav-link {{ request()->is('menu-items') ? 'active' : '' }}"
                                        href="{{ url('restaurant/menu-items') }}"> Menu items
  
                                    </a>
                                </li>
                            @endcan
  
  
                            @can('view-restaurant-orders')
                                <li class="nav-item ">
                                    <a class="nav-link {{ request()->is('orders') ? 'active' : '' }}"
                                        href="{{ url('restaurant/orders') }}"> Make Order
  
                                    </a>
                                </li>
                            @endcan
                            
                            
                            
                            
                            @can('view-restaurant-activity')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('restaurant/pos_activity*') ? 'active' : '' }}"
                                        href="{{ url('restaurant/pos_activity') }}">Track Restaurant Activity</a></li>
                            @endcan
  
  
  
                        </ul>
  
                    </li>
                @endcan
  
  
                @can('manage-property-menu')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('hotel/*') ? 'active' : '' }}"><i
                                class="icon-city"></i><span>Manage Property</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Sidebars">
  
  
  
                            @can('view-hotel')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('hotel/room_type*') ? 'active' : '' }}"
                                        href="{{ url('hotel/room_type') }}">Property Room Type</a></li>
                                        
                             <li class="nav-item"><a class="nav-link {{ request()->is('hotel/hotel*') ? 'active' : '' }}"
                                        href="{{ url('hotel/hotel') }}">Property List</a></li>            
  
                             @endcan
  
  
                                 @can('view-property-asset')
                               
                                 <li class="nav-item"><a class="nav-link {{ request()->is('hotel/asset*') ? 'active' : '' }}"
                                        href="{{ url('hotel/asset') }}">Property Asset</a></li>        
                            @endcan
  
  
  
                            @can('view-hotel-client')
                                <li class="nav-item ">
                                    <a class="nav-link {{ request()->is('hotel/visitor') ? 'active' : '' }}"
                                        href="{{ url('hotel/visitor') }}"> Property Client
  
                                    </a>
                                </li>
                            @endcan
  
  
                            @can('view-availability')
                                <li class="nav-item ">
                                    <a class="nav-link {{ request()->is('hotel/check_availability') ? 'active' : '' }}"
                                        href="{{ url('hotel/check_availability') }}"> Checking Availability
  
                                    </a>
                                </li>
                            @endcan
  
  
                            @can('view-booking')
                                <li class="nav-item ">
                                    <a class="nav-link {{ request()->is('hotel/booking') ? 'active' : '' }}"
                                        href="{{ url('hotel/booking') }}"> Manage Booking
  
                                    </a>
                                </li>
                            @endcan
  
  
  
  
  
  
                        </ul>
  
                    </li>
                @endcan
  
  
  
  
  
  
                @canany(['manage-truck-menu', 'manage-driver-menu','manage-tire-menu'])
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('logistic_truck/*') ? 'active' : '' }}"><i
                                class="icon-truck"></i> <span>
                                Truck Management</span></a>
  
                        <ul class="nav nav-group-sub" data-submenu-title="Sidebars">
  
                            @can('view-truck')
                                <li class="nav-item nav-item-submenu">
                                    <a href="#"
                                        class="nav-link {{ request()->is('logistic_truck/truck*') ? 'active' : '' }}">Truck</a>
                                    <ul class="nav nav-group-sub">
  
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('logistic_truck/truck*') ? 'active' : '' }}"
                                                href="{{ url('logistic_truck/truck') }}">Manage Truck</a></li>
  
  
                                        @can('view-connect')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('logistic_truck/connect_trailer*') ? 'active' : '' }}"
                                                    href="{{ url('logistic_truck/connect_trailer') }}">Connect & Disconnect
                                                    Trailer</a></li>
                                                     <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('logistic_truck/equipment*') ? 'active' : '' }}"
                                                    href="{{ url('logistic_truck/equipment') }}">Manage Equipment 
                                                   </a></li>
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('logistic_truck/assign_equipment*') ? 'active' : '' }}"
                                                    href="{{ url('logistic_truck/assign_equipment') }}">Assign Equipment to Truck</a></li>
                                                    
                                                     <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('logistic_truck/equipment_report*') ? 'active' : '' }}"
                                                    href="{{ url('logistic_truck/equipment_report') }}">Equipment Report</a></li>
                                          
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('logistic_truck/truck_report.*') ? 'active' : '' }}"
                                                    href="{{ url('logistic_truck/truck_report') }}">Truck Report</a></li>
                                                    
                                                      @can('view-cargo-activity')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('logistic_truck/truck_summary.*') ? 'active' : '' }}"
                                                    href="{{ url('logistic_truck/truck_summary') }}">Truck Summary</a></li>
                                                    @endcan
                                                    
                                                  
                                                    
                                        @endcan
                                    </ul>
                                </li>
  @endcan
                         
  
  
  
  
  
                            @can('view-driver')
                                <li class="nav-item nav-item-submenu">
                                    <a href="#"
                                        class="nav-link {{ request()->is('logistic_driver/driver*') ? 'active' : '' }}">Driver</a>
                                    <ul class="nav nav-group-sub">
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('logistic_driver/driver*') ? 'active' : '' }}"
                                                href="{{ url('logistic_driver/driver') }}">Driver Management</a></li>
  
  
                                        @can('view-connect')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('logistic_truck/connect_driver*') ? 'active' : '' }}"
                                                    href="{{ url('logistic_truck/connect_driver') }}">Assign & Remove
                                                    Driver</a></li>
                                        @endcan
  
  
                                    </ul>
                                </li>
                            @endcan
  
  
                            @can('view-fuel')
                                <li class="nav-item nav-item-submenu">
                                    <a href="#" class="nav-link {{ request()->is('fuel*') ? 'active' : '' }}">Fuel</a>
                                    <ul class="nav nav-group-sub">
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('fuel.*') ? 'active' : '' }}"
                                                href="{{ url('fuel') }}">Fuel Control</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('return_fuel*') ? 'active' : '' }}"
                                                href="{{ url('return_fuel') }}">Return Fuel </a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('refill_list') ? 'active' : '' }}"
                                                href="{{ url('refill_list') }}">Refill List</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('multiple_refill_payment') ? 'active' : '' }}"
                                                href="{{ url('multiple_refill_payment') }}"> Multiple Refill Payment</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('fuel_report') ? 'active' : '' }}"
                                                href="{{ url('fuel_report') }}">Fuel Report</a></li>
  
  
                                    </ul>
                                </li>
                            @endcan
                            
                              
  
                            @can('manage-tire-menu')
                                <li class="nav-item nav-item-submenu">
                                    <a href="#" class="nav-link {{ request()->is('tyre/*') ? 'active' : '' }}">
                                        <span>Tire</span></a>
  
                                    <ul class="nav nav-group-sub">
                                        @can('view-tyre_brand')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('tyre/tyre_brand*') ? 'active' : '' }}"
                                                    href="{{ url('tyre/tyre_brand') }}">Tire Brand</a></li>
                                        @endcan
                                        @can('view-purchase_tyre')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('tyre/purchase_tyre*') ? 'active' : '' }}"
                                                    href="{{ url('tyre/purchase_tyre') }}">Purchase Tire</a></li>
                                                    
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('tyre/tyre_debit_note') ? 'active' : '' }}"
                                                href="{{ url('tyre/tyre_debit_note') }}">Debit Note</a></li>            
                                        @endcan
                                        @can('view-tyre_list')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('tyre/tyre_list*') ? 'active' : '' }}"
                                                    href="{{ url('tyre/tyre_list') }}">Tire List</a></li>
                                        @endcan
                                        @can('view-assign_truck')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('tyre/assign_truck*') ? 'active' : '' }}"
                                                    href="{{ url('tyre/assign_truck') }}">Assign Truck</a></li>
                                        @endcan
                                        @can('view-tyre_return')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('tyre/tyre_return*') ? 'active' : '' }}"
                                                    href="{{ url('tyre/tyre_return') }}">Tire Return</a></li>
                                        @endcan
                                        @can('view-tyre_reallocation')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('tyre/tyre_reallocation*') ? 'active' : '' }}"
                                                    href="{{ url('tyre/tyre_reallocation') }}">Tire
                                                    Reallocation</a></li>
                                        @endcan
                                        @can('view-tyre_disposal')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('tyre/tyre_disposal*') ? 'active' : '' }}"
                                                    href="{{ url('tyre/tyre_disposal') }}">Tire Disposal</a></li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
  
                           
  
  
  
  
                        </ul>
                    </li>
                @endcan
                
             
  
  
                           @can('manage-inventory-menu')
  
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('inventory/*') ? 'active' : '' }}"><i
                                class="icon-stack3"></i> <span>Inventory</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Sidebars">
  
  @can('view-inventory')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('inventory/inventory*') ? 'active' : '' }}"
                                                    href="{{ url('inventory/inventory') }}">Inventory Items</a></li>
                                        @endcan
                                        @can('view-fieldstaff')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('inventory/fieldstaff*') ? 'active' : '' }}"
                                                    href="{{ url('inventory/fieldstaff') }}">Field Staff</a></li>
                                        @endcan
                                        @can('view-requisition')
                                            <li class="nav-item"><a
                                                class="nav-link {{ request()->is('inventory/requisition*') ? 'active' : '' }}"
                                                href="{{ url('inventory/requisition') }}">Requisition</a></li>
                                        @endcan
                                        @can('view-purchase_inventory')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('inventory/purchase_inventory*') ? 'active' : '' }}"
                                                    href="{{ url('inventory/purchase_inventory') }}">Purchase
                                                    Inventory</a></li>
                                                    
                                                    
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('inventory/inventory_debit_note*') ? 'active' : '' }}"
                                                href="{{ url('inventory/inventory_debit_note') }}">Debit Note</a></li>
                                        @endcan
                                        @can('view-inventory_list')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('inventory/inventory_list*') ? 'active' : '' }}"
                                                    href="{{ url('inventory/inventory_list') }}">Inventory List</a>
                                            </li>
                                        @endcan
                                        @can('view-inventory_list')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('inventory/service_type*') ? 'active' : '' }}"
                                                    href="{{ url('inventory/service_type') }}">Service Type</a></li>
                                        @endcan
                                        {{--
                                        @can('view-maintainance')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('inventory/maintainance*') ? 'active' : '' }}"
                                                    href="{{ url('inventory/maintainance') }}">Maintainance</a></li>
                                        @endcan
                                        --}}
                                        @can('view-service')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('inventory/service*') ? 'active' : '' }}"
                                                    href="{{ url('inventory/service') }}">Service</a></li>
                                        @endcan
                                        @can('view-service')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('inventory/good_issue*') ? 'active' : '' }}"
                                                    href="{{ url('inventory/good_issue') }}">Good Issue</a></li>
                                        @endcan
                                        {{--
                                        @can('view-good_return')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('inventory/good_return*') ? 'active' : '' }}"
                                                    href="{{ url('inventory/good_return') }}">Good Return</a></li>
                                        @endcan
                                        --}}
                                        @can('view-good_movement')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('inventory/good_movement*') ? 'active' : '' }}"
                                                    href="{{ url('inventory/good_movement') }}">Good Movement</a></li>
                                        @endcan
                                        @can('view-good_reallocation')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('inventory/good_reallocation*') ? 'active' : '' }}"
                                                    href="{{ url('inventory/good_reallocation') }}">Good
                                                    Reallocation</a></li>
                                        @endcan
                                        @can('view-good_disposal')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('inventory/good_disposal*') ? 'active' : '' }}"
                                                    href="{{ url('inventory/good_disposal') }}">Good Disposal</a></li>
                                        @endcan
                                        
                                         @can('view-sales-inventory')
                                          <li class="nav-item"><a
                                                class="nav-link {{ request()->is('inventory/inventory_invoice*') ? 'active' : '' }}"
                                                href="{{ url('inventory/inventory_invoice') }}">Sales</a></li>
                                        
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('inventory/inventory_credit_note*') ? 'active' : '' }}"
                                                href="{{ url('inventory/inventory_credit_note') }}">Credit Note</a></li>
                                        @endcan
  
                        </ul>
                    </li>
  
  
  
                @endcan
  
  
  
  
  
  
  
  
                @can('view-radio-menu')
  
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('radio/*') ? 'active' : '' }}"><i
                                class="icon-radio"></i> <span>Radio Order</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Sidebars">
  
  
                            @can('view-radio')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('radio/radio_pickup*') ? 'active' : '' }}"
                                        href="{{ url('radio/radio_pickup') }}">Request Order</a></li>
  
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('radio/radio_quotation*') ? 'active' : '' }}"
                                        href="{{ url('radio/radio_quotation') }}">Radio Quotation </a></li>
                            @endcan
  
                        </ul>
                    </li>
  
  
  
                @endcan
  
  
                @can('view-manufacture-menu')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('manufacturing/*') ? 'active' : '' }}"><i
                                class="icon-hammer"></i>
                            <span>
                                Manage Manufacturing</span></a>
  
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
  
  
                            @can('view-manufacture')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('manufacturing/manufacturing_package*') ? 'active' : '' }}"
                                        href="{{ url('manufacturing/manufacturing_package') }}">Product</a>
                                </li>
                            @endcan
  
  
                            @can('view-manufacture')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('manufacturing/manufacturing_location*') ? 'active' : '' }}"
                                        href="{{ url('manufacturing/manufacturing_location') }}">Location</a>
                                </li>
                            @endcan
  
                            @can('view-manufacture')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('manufacturing/items2*') ? 'active' : '' }}"
                                        href="{{ url('manufacturing/items2/index') }}">Manage
                                        Inventory</a></li>
                            @endcan
  
                            <!--  @can('view-manufacture')
        <li class="nav-item"><a
                                          class="nav-link {{ request()->is('manufacturing/manufacturing_inventory*') ? 'active' : '' }}"
                                          href="{{ url('manufacturing/manufacturing_inventory') }}">Inventory
                                          Items</a></li>
    @endcan
                      @can('view-manufacture')
        <li class="nav-item"><a
                                          class="nav-link {{ request()->is('inventory/fieldstaff*') ? 'active' : '' }}"
                                          href="{{ url('inventory/fieldstaff') }}">Field Staff</a></li> -->
                            @endcan
                            @can('view-manufacture')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('manufacturing/bill_of_material*') ? 'active' : '' }}"
                                        href="{{ url('manufacturing/bill_of_material') }}">Bill Of Material</a>
                                </li>
                            @endcan
                            @can('view-manufacture')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('manufacturing/work_order*') ? 'active' : '' }}"
                                        href="{{ url('manufacturing/work_order') }}">Work Order</a></li>
                            @endcan
                            <!--  @can('view-manufacture')
        <li class="nav-item"><a
                                          class="nav-link {{ request()->is('inventory/purchase_inventory*') ? 'active' : '' }}"
                                          href="{{ url('inventory/purchase_inventory') }}">Purchase Inventory</a>
                                  </li>
    @endcan
                      @can('view-manufacture')
        <li class="nav-item"><a
                                          class="nav-link {{ request()->is('inventory/inventory_list*') ? 'active' : '' }}"
                                          href="{{ url('inventory/inventory_list') }}">Inventory List</a>
                                  </li>
    @endcan
                      @can('view-manufacture')
        <li class="nav-item"><a
                                          class="nav-link {{ request()->is('inventory/maintainance*') ? 'active' : '' }}"
                                          href="{{ url('inventory/maintainance') }}">Maintainance</a></li>
    @endcan
                      @can('view-manufacture')
        <li class="nav-item"><a
                                          class="nav-link {{ request()->is('inventory/service*') ? 'active' : '' }}"
                                          href="{{ url('inventory/service') }}">Service</a></li>
    @endcan
                      @can('view-manufacture')
        <li class="nav-item"><a
                                          class="nav-link {{ request()->is('inventory/good_issue*') ? 'active' : '' }}"
                                          href="{{ url('inventory/good_issue') }}">Good Issue</a></li>
    @endcan
                      @can('view-manufacture')
        <li class="nav-item"><a
                                          class="nav-link {{ request()->is('inventory/good_return*') ? 'active' : '' }}"
                                          href="{{ url('inventory/good_return') }}">Good Return</a></li>
    @endcan
                      @can('view-manufacture')
        <li class="nav-item"><a
                                          class="nav-link {{ request()->is('inventory/good_movement*') ? 'active' : '' }}"
                                          href="{{ url('inventory/good_movement') }}">Good Movement</a></li>
    @endcan
                      @can('view-manufacture')
        <li class="nav-item"><a
                                          class="nav-link {{ request()->is('inventory/good_reallocation*') ? 'active' : '' }}"
                                          href="{{ url('inventory/good_reallocation') }}">Good
                                          Reallocation</a></li>
    @endcan
                      @can('view-manufacture')
        <li class="nav-item"><a
                                          class="nav-link {{ request()->is('inventory/good_disposal*') ? 'active' : '' }}"
                                          href="{{ url('inventory/good_disposal') }}">Good Disposal</a></li>
    @endcan
                      -->
                        </ul>
                    </li>
                @endcan
  
  
  
                @canany(['view-payroll-menu', 'view-leave-menu', 'view-training-menu'])
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('payroll/*') ? 'active' : '' }}"><i
                                class="icon-calculator"></i> <span>HR</span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Sidebars">
  
                            @can('view-payroll-menu')
                                <li class="nav-item nav-item-submenu">
                                    <a href="#" class="nav-link {{ request()->is('payroll/*') ? 'active' : '' }}">
                                        <span>Payroll</span></a>
  
                                    <ul class="nav nav-group-sub">
                                        @can('view-salary_template')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('payroll/salary_template*') ? 'active' : '' }}"
                                                    href="{{ url('payroll/salary_template') }}"> Salary
                                                    Template</a></li>
                                        @endcan
                                        @can('view-manage_salary')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('payroll/manage_salary*') ? 'active' : '' }}"
                                                    href="{{ url('payroll/manage_salary') }}"> Manage
                                                    Salary</a></li>
                                        @endcan
                                        @can('view-employee_salary_list')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('payroll/employee_salary_list*') ? 'active' : '' }}"
                                                    href="{{ url('payroll/employee_salary_list') }}">
                                                    Employee Salary List</a>
                                            </li>
                                        @endcan
                                        @can('view-make_payment')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('payroll/make_payment*') ? 'active' : '' }}"
                                                    href="{{ url('payroll/make_payment') }}">Make Payment</a>
                                            </li>
                                        @endcan
                                        @can('view-make_payment')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('payroll/multiple_payment*') ? 'active' : '' }}"
                                                    href="{{ url('payroll/multiple_payment') }}">Make Multiple Payments</a>
                                            </li>
                                        @endcan
                                        @can('view-generate_payslip')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('payroll/generate_payslip*') ? 'active' : '' }}"
                                                    href="{{ url('payroll/generate_payslip') }}">Generate
                                                    Payslip</a></li>
                                        @endcan
                                        @can('view-payroll_summary')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('payroll/payroll_summary*') ? 'active' : '' }}"
                                                    href="{{ url('payroll/payroll_summary') }}">Payroll
                                                    Summary</a></li>
                                        @endcan
                                        @can('view-salary_control')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('payroll/salary_control*') ? 'active' : '' }}"
                                                    href="{{ url('payroll/salary_control') }}">Salary Control</a></li>
                                        @endcan
                                        @can('view-advance_salary')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('payroll/advance_salary*') ? 'active' : '' }}"
                                                    href="{{ url('payroll/advance_salary') }}">Advance
                                                    Salary</a></li>
                                        @endcan
                                        @can('view-employee_loan')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('payroll/employee_loan*') ? 'active' : '' }}"
                                                    href="{{ url('payroll/employee_loan') }}">Employee
                                                    Loan</a></li>
                                        @endcan
                                        @can('view-overtime')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('payroll/overtime*') ? 'active' : '' }}"
                                                    href="{{ url('payroll/overtime') }}">Overtime</a></li>
                                        @endcan
                                        @can('view-nssf')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('payroll/nssf*') ? 'active' : '' }}"
                                                    href="{{ url('payroll/nssf') }}">NSSF
                                                </a></li>
                                        @endcan
                                        @can('view-tax')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('payroll/tax*') ? 'active' : '' }}"
                                                    href="{{ url('payroll/tax') }}">Tax </a></li>
                                        @endcan
                                        @can('view-nhif')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('payroll/nhif*') ? 'active' : '' }}"
                                                    href="{{ url('payroll/nhif') }}">Health Contribution</a>
                                            </li>
                                        @endcan
                                        @can('view-wcf')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('payroll/wcf*') ? 'active' : '' }}"
                                                    href="{{ url('payroll/wcf') }}">WCF Contribution</a></li>
                                        @endcan
                                        @can('view-sdl')
                                            <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('payroll/sdl*') ? 'active' : '' }}"
                                                    href="{{ url('payroll/sdl') }}">SDL Contribution</a></li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcan
  
  
  
  
                            @can('view-leave-menu')
  
                                <li class="nav-item nav-item-submenu">
                                    <a href="#" class="nav-link {{ request()->is('leave/*') ? 'active' : '' }}">
                                        <span>Leave Management</span></a>
  
                                    <ul class="nav nav-group-sub">
                                        @can('view-leave-category')
                                            <li class="nav-item">
                                                <a
                                                    class="nav-link {{ request()->is('leave/leave_category*') ? 'active' : '' }}"href="{{ url('leave/leave_category') }}">
                                                    Leave Category</a>
                                            </li>
                                        @endcan
                                        @can('view-leave')
                                            <li class="nav-item">
                                                <a
                                                    class="nav-link {{ request()->is('leave/leave*') ? 'active' : '' }}"href="{{ url('leave/leave') }}">
                                                    Manage Leave</a>
                                            </li>
                                        @endcan
  
                                    </ul>
                                </li>
                            @endcan
  
  
                            @can('view-training')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('training/training*') ? 'active' : '' }}"
                                        href="{{ url('training/training') }}"><span>Training</span></a>
                                </li>
                            @endcan
  
  
                        </ul>
                    </li>
                @endcan
  
  
  
  
                @can('view-performance-menu')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('performance/*') ? 'active' : '' }}"> <i
                                class="icon-stats-bars"></i><span>Performance</span></a>
  
                        <ul class="nav nav-group-sub">
                            @can('manage-kpi')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('performance/kpi') ? 'active' : '' }}"
                                        href="{{ url('performance/kpi') }}"> Key Performance Indicator</a></li>
                            @endcan
                            @can('assign-kpi')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('performance/assign_kpi') ? 'active' : '' }}"
                                        href="{{ url('performance/assign_kpi') }}"> Assign Performance Indicator</a></li>
                            @endcan
                            @can('manage-kpi-result')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('performance/kpi_result') ? 'active' : '' }}"
                                        href="{{ url('performance/kpi_result') }}">Performance Indicator Result</a></li>
                            @endcan
                            @can('manage-indicator')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('performance/indicator*') ? 'active' : '' }}"
                                        href="{{ url('performance/indicator') }}"> Behaviour Indicator</a></li>
                            @endcan
                            @can('manage-appraisal')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('performance/appraisal*') ? 'active' : '' }}"
                                        href="{{ url('performance/appraisal') }}"> Behaviour Appraisal</a></li>
                            @endcan
                            @can('manage-performance-report')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('performance/performance_report') ? 'active' : '' }}"
                                        href="{{ url('performance/performance_report') }}">Behaviour Report</a></li>
                            @endcan
  
                        </ul>
                    </li>
                @endcan
  
  
  
  
  
                @can('view-school-menu')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('school/*') ? 'active' : '' }}"><i
                                class="icon-graduation2"></i> <span>
                                School Management</span></a>
  
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
  
                            @can('view-students')


                            <li class="nav-item nav-item-submenu">
                                <a href="#" 
                                class="nav-link {{ request()->is('school/*') ? 'active' : '' }}">
                                    <span>Student Register</span></a>

                                <ul class="nav nav-group-sub">
                                    
                                        <li class="nav-item">
                                            <a
                                                class="nav-link {{ request()->is('school/studentlevels*') ? 'active' : '' }}"href="{{ url('school/studentlevels') }}">
                                                School Level</a>
                                        </li>
                                    
                                    
                                        <li class="nav-item">
                                            <a
                                                class="nav-link {{ request()->is('school/studentsclass*') ? 'active' : '' }}"href="{{ url('school/studentsclass') }}">
                                                Class </a>
                                        </li>

                                        <li class="nav-item">
                                            <a
                                                class="nav-link {{ request()->is('school/schoolstreams*') ? 'active' : '' }}"href="{{ url('school/schoolstreams') }}">
                                                Stream </a>
                                        </li>
                                    
                                    
                                        <li class="nav-item">
                                            <a
                                                class="nav-link {{ request()->is('school/schoolbranch*') ? 'active' : '' }}"href="{{ url('school/schoolbranch') }}">
                                                Branch </a>
                                        </li>

                                        <li class="nav-item">
                                            <a
                                                class="nav-link {{ request()->is('school/studentsubject*') ? 'active' : '' }}"href="{{ url('school/studentsubject') }}">
                                                Subject </a>
                                        </li>

                                        <li class="nav-item">
                                            <a
                                                class="nav-link {{ request()->is('school/gradesregister*') ? 'active' : '' }}"href="{{ url('school/gradesregister') }}">
                                                Grades </a>
                                        </li>

                                        <li class="nav-item">
                                            <a
                                                class="nav-link {{ request()->is('school/teachersregister*') ? 'active' : '' }}"href="{{ url('school/teachersregister') }}">
                                                Teachers </a>
                                        </li>
                                    
                                        <li class="nav-item">
                                            <a
                                                class="nav-link {{ request()->is('school/examtype*') ? 'active' : '' }}"href="{{ url('school/examtype') }}">
                                                Exam </a>
                                        </li>

                                        <li class="nav-item">
                                            <a
                                                class="nav-link {{ request()->is('school/schoolterms*') ? 'active' : '' }}"href="{{ url('school/schoolterms') }}">
                                                School Terms </a>
                                        </li>

                                        <li class="nav-item">
                                            <a
                                                class="nav-link {{ request()->is('school/schoolyears*') ? 'active' : '' }}"href="{{ url('school/schoolyears') }}">
                                                School Year </a>
                                        </li>

                                        <li class="nav-item">
                                            <a
                                                class="nav-link {{ request()->is('school/academyregisters*') ? 'active' : '' }}"href="{{ url('school/academyregisters') }}">
                                                Academy Register </a>
                                        </li>

                                </ul>
                            </li>



                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('school/student*') ? 'active' : '' }}"
                                        href="{{ url('school/student') }}"> Student Registration</a></li>
                                
                                <li class="nav-item"><a
                                    class="nav-link {{ request()->is('school/school_results') ? 'active' : '' }}"
                                    href="{{ url('school/school_results') }}"> Student Results</a></li>

                                <li class="nav-item"><a
                                    class="nav-link {{ request()->is('school/school_report') ? 'active' : '' }}"
                                    href="{{ url('school/school_report') }}"> Student Report</a></li>

                            @endcan
                            @can('view-school-fees')
                                <li class="nav-item "><a
                                        class="nav-link {{ request()->is('school/school*') ? 'active' : '' }}"
                                        href="{{ url('school/school') }}">School Fees Registration</a></li>
                            @endcan
                            @can('view-school-invoice')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('school/invoice_general*') ? 'active' : '' }}"
                                        href="{{ url('school/invoice_general') }}">Invoice Generation</a></li>
                            @endcan
                            @can('view-school-collection')
                                <li class="nav-item "><a
                                        class="nav-link {{ request()->is('school/fees_collection*') ? 'active' : '' }}"
                                        href="{{ url('school/fees_collection') }}">School Fees Collection</a></li>
                            @endcan
                             
                             @can('view-school-payments')
                                <li class="nav-item "><a
                                        class="nav-link {{ request()->is('school/payments*') ? 'active' : '' }}"
                                        href="{{ url('school/payments') }}">Payments Collected</a></li>
                            @endcan
                            @can('view-school-collection')
                                <li class="nav-item "><a
                                        class="nav-link {{ request()->is('school/import_payments*') ? 'active' : '' }}"
                                        href="{{ url('school/import_payments') }}">Import Student Payments</a></li>
                            @endcan
                            @can('view-school-payments')
                                <li class="nav-item "><a
                                        class="nav-link {{ request()->is('school/fees_collection_list*') ? 'active' : '' }}"
                                        href="{{ url('school/fees_collection_list') }}">School Fees Payment Views</a></li>
                            @endcan
                            
                            @can('send-sms')
                                <li class="nav-item "><a
                                        class="nav-link {{ request()->is('school/messages*') ? 'active' : '' }}"
                                        href="{{ url('school/messages') }}">Message Board</a></li>
                            @endcan
                            
                             @can('view-promote-student')
                                <li class="nav-item "><a
                                        class="nav-link {{ request()->is('school/promote_students*') ? 'active' : '' }}"
                                        href="{{ url('school/promote_students') }}">Promote Students</a></li>
                            @endcan
                             @can('view-disable-student')
                                <li class="nav-item "><a
                                        class="nav-link {{ request()->is('school/disable_students*') ? 'active' : '' }}"
                                        href="{{ url('school/disable_students') }}">Disable Students</a></li>
                            @endcan
  
                        </ul>
                    </li>
                @endcan
  
  
                @if (auth()->user()->email == 'info@ujuzinet.com')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('subscription/*') ? 'active' : '' }}"><i
                                class="icon-pie-chart2"></i> <span>
                                Subscription</span></a>
  
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
  
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->is('subscription/subscription_list*') ? 'active' : '' }}"
                                    href="{{ url('subscription/subscription_list') }}">Subscription List</a></li>
                                    
                            <li class=" nav-item "><a
                                    class="nav-link {{ request()->is('subscription/expire*') ? 'active' : '' }}"
                                    href="{{ url('subscription/expire') }}">Message For Expired Users</a></li>        
  
                            <li class="nav-item "><a
                                    class="nav-link {{ request()->is('subscription/subscription_report*') ? 'active' : '' }}"
                                    href="{{ url('subscription/subscription_report') }}">Subscription Payment
                                    Report</a>
  
                            </li>
                             <li class="nav-item "><a
                                    class="nav-link {{ request()->is('subscription/expired_users*') ? 'active' : '' }}"
                                    href="{{ url('subscription/expired_users') }}">Expired Users</a>
  
                            </li>
                            
                             <li class="nav-item "><a
                                    class="nav-link {{ request()->is('subscription/deposit*') ? 'active' : '' }}"
                                    href="{{ url('subscription/deposit') }}">Deposits</a>
  
                            </li>
  
                        </ul>
                    </li>
                @endif
  
  
                @can('view-gl-setup-menu')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('gl_setup/*') ? 'active' : '' }}"><i
                                class="icon-wrench3"></i> <span>
                                GL SETUP</span></a>
  
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
  
                            @can('view-class_account')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('gl_setup/class_account*') ? 'active' : '' }}"
                                        href="{{ url('gl_setup/class_account') }}">Class Account </a>
                                </li>
                            @endcan
                            @can('view-group_account')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('gl_setup/group_account*') ? 'active' : '' }}"
                                        href="{{ url('gl_setup/group_account') }}">Group Account</a>
                                </li>
                            @endcan
                            @can('view-account_codes')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('gl_setup/account_codes*') ? 'active' : '' }}"
                                        href="{{ url('gl_setup/account_codes') }}">Account Codes</a>
                                </li>
                            @endcan
                            @can('view-chart_of_account')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('gl_setup/chart_of_account*') ? 'active' : '' }}"
                                        href="{{ url('gl_setup/chart_of_account') }}">Chart of Accounts
                                    </a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
  
                @can('view-transaction-menu')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('gl_setup/*') ? 'active' : '' }}"><i
                                class="icon-diamond"></i> <span>
                                Transactions</span></a>
  
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
  
                            @can('view-deposit')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('gl_setup/deposit*') ? 'active' : '' }}"
                                        href="{{ url('gl_setup/deposit') }}">Deposit</a></li>
                            @endcan
                            @can('view-expenses')
                                <li class="nav-item "><a
                                        class="nav-link {{ request()->is('gl_setup/expenses*') ? 'active' : '' }}"
                                        href="{{ url('gl_setup/expenses') }}">Payments</a></li>
                            @endcan
                            @can('view-transfer')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('gl_setup/transfer*') ? 'active' : '' }}"
                                        href="{{ url('gl_setup/transfer') }}">Transfer</a></li>
                            @endcan
  
                            @can('view-expenses')
                                <li class="nav-item "><a
                                        class="nav-link {{ request()->is('gl_setup/payment_report*') ? 'active' : '' }}"
                                        href="{{ url('gl_setup/payment_report') }}">Payments Report</a></li>
                            @endcan
                            @can('view-expenses')
                                <li class="nav-item "><a
                                        class="nav-link {{ request()->is('gl_setup/account*') ? 'active' : '' }}"
                                        href="{{ url('gl_setup/account') }}">Bank & Cash</a></li>
                            @endcan
                            @can('view-bank_statement')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('accounting/bank_statement*') ? 'active' : '' }}"
                                        href="{{ url('accounting/bank_statement') }}">Bank
                                        Statement</a>
                                </li>
                            @endcan
                            @can('view-bank_reconciliation')
                                <li class=" nav-item"><a
                                        class="nav-link {{ request()->is('accounting/bank_reconciliation*') ? 'active' : '' }}"
                                        href="{{ url('accounting/bank_reconciliation') }}">Bank
                                        Reconciliation</a></li>
                            @endcan
                            @can('view-reconciliation_report')
                                <li class="nav-item "><a
                                        class="nav-link {{ request()->is('accounting/reconciliation_report*') ? 'active' : '' }}"
                                        href="{{ url('accounting/reconciliation_report') }}">Bank
                                        Reconciliation Report</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
  
                @can('view-accounting-menu')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('accounting/*') ? 'active' : '' }}"><i
                                class="icon-stats-growth"></i> <span>
                                Accounting</span></a>
  
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            @can('view-manual_entry')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('accounting/manual_entry*') ? 'active' : '' }}"
                                        href="{{ url('accounting/manual_entry') }}">Journal
                                        Entry</a></li>
                            @endcan
                            @can('view-journal')
                                <li class="nav-item "><a
                                        class="nav-link {{ request()->is('accounting/journal*') ? 'active' : '' }}"
                                        href="{{ url('accounting/journal') }}">Journal Entry
                                        Report</a>
  
                                </li>
                            @endcan
                            
                              @can('view-budgeting')
                                <li class="nav-item "><a
                                        class="nav-link {{ request()->is('accounting/budgets*') ? 'active' : '' }}"
                                        href="{{ url('accounting/budgets') }}">Budgets</a>
  
                                </li>
                            @endcan
                            
                            {{--
                @can('view-ledger')
                <li class="nav-item"><a
                        class="nav-link {{ (request()->is('accounting/ledger*')) ? 'active' : ''  }}"
                        href="{{ url('accounting/ledger') }}">Ledger</a></li>
                @endcan
  --}}
                            @can('view-trial_balance')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('financial_report/trial_balance*') ? 'active' : '' }}"
                                        href="{{ url('financial_report/trial_balance') }}">Trial
                                        Balance </a>
                                </li>
                            @endcan
                            @can('view-trial_balance')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('financial_report/trial_balance_summary*') ? 'active' : '' }}"
                                        href="{{ url('financial_report/trial_balance_summary') }}">Trial
                                        Balance Summary </a>
                                </li>
                            @endcan
                            @can('view-income_statement')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('financial_report/income_statement*') ? 'active' : '' }}"
                                        href="{{ url('financial_report/income_statement') }}">Income
                                        Statement</a></li>
                            @endcan
                            @can('view-income_statement')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('financial_report/income_statement_summary*') ? 'active' : '' }}"
                                        href="{{ url('financial_report/income_statement_summary') }}">Income
                                        Statement Summary</a></li>
                            @endcan
                            @can('view-balance_sheet')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('financial_report/balance_sheet*') ? 'active' : '' }}"
                                        href="{{ url('financial_report/balance_sheet') }}">Balance Sheet </a>
                                </li>
                            @endcan
                            @can('view-balance_sheet')
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('financial_report/balance_sheet_summary*') ? 'active' : '' }}"
                                        href="{{ url('financial_report/balance_sheet_summary') }}">Balance
                                        Sheet Summary </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
  
  
               
  
  
  
                @can('view-report-menu')
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link {{ request()->is('reports/*') ? 'active' : '' }}"><i
                                class="icon-grid6"></i> <span>Reports</span></a>





                                

                        <ul class="nav nav-group-sub" data-submenu-title="Sidebars">

                            <a
                                                class="nav-link {{ request()->is('reports/pos/general_operation_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/pos/general_operation_report') }}"><i></i></i>General Report </a>
  
                            @can('view-pos-report')
                                <li class="nav-item nav-item-submenu">
                                    <a href="#"
                                        class="nav-link {{ request()->is('reports/pos*') ? 'active' : '' }}">POS Report</a>
                                    <ul class="nav nav-group-sub">
                                        {{--
  <li class="nav-item"><a class="nav-link {{ (request()->is('reports/pos/purchase_report*')) ? 'active' : ''  }}"  href="{{url('reports/pos/purchase_report')}}"><i></i></i>Inventory Purchase Report</a></li>
  <li class="nav-item"><a class="nav-link {{ (request()->is('reports/pos/sales_report*')) ? 'active' : ''  }}" href="{{url('reports/pos/sales_report')}}"><i></i></i>Inventory Sales Report</a></li>   
  <li class="nav-item"><a class="nav-link {{ (request()->is('reports/pos/balance_report*')) ? 'active' : ''  }}"  href="{{url('reports/pos/balance_report')}}"><i></i></i>Inventory Report</a></li>
  
  --}}
  
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/pos/report_by_date*') ? 'active' : '' }}"
                                                href="{{ url('reports/pos/report_by_date') }}"><i></i></i>Report By Date </a>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/pos/stock_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/pos/stock_report') }}"><i></i></i>Stock Value </a></li>
                                        <li class="nav-item"><a
                                            class="nav-link {{ request()->is('reports/pos/sales_report*') ? 'active' : '' }}"
                                            href="{{ url('reports/pos/sales_report') }}"><i></i></i>Sales Report </a></li>
                                        <li class="nav-item"><a
                                            class="nav-link {{ request()->is('reports/pos/min_quantity_report*') ? 'active' : '' }}"
                                            href="{{ url('reports/pos/min_quantity_report') }}"><i></i></i>Minimum Quantity Alert Report </a></li>
                                        <li class="nav-item"><a
                                            class="nav-link {{ request()->is('reports/pos/expire_report*') ? 'active' : '' }}"
                                            href="{{ url('reports/pos/expire_report') }}"><i></i></i>Product Expire Report </a></li>
                                        
                                            {{-- <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/pos/profit_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/pos/profit_report') }}"><i></i></i>Profit Report </a></li> --}}
  
                                         <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/pos/service_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/pos/service_report') }}"><i></i></i>Service Report</a></li> 
                                                
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/pos/client_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/pos/client_report') }}"><i></i></i>Client Report</a></li>  
                                          
                                        <li class="nav-item"><a
                                          class="nav-link {{ request()->is('reports/pos/client_point_report*') ? 'active' : '' }}"
                                          href="{{ url('reports/pos/client_point_report') }}"><i></i></i>Client Point Report</a></li>  
                                                
                                                {{--
                                        <li class="nav-item"><a 
                                        class="nav-link {{ (request()->is('reports/pos/store_value*')) ? 'active' : ''  }}"  
                                        href="{{url('reports/pos/store_value')}}"><i></i></i>Store Value</a></li>
                                        --}}
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/pos/good_issue_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/pos/good_issue_report') }}"><i></i></i>Good Issue
                                                Report</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/pos/stock_movement_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/pos/stock_movement_report') }}"><i></i></i>Stock
                                                Movement Report</a></li>
  
                                                <li class="nav-item"><a
                                                    class="nav-link {{ request()->is('reports/pos/stock_profit_report*') ? 'active' : '' }}"
                                                    href="{{ url('reports/pos/stock_profit_report') }}"><i></i></i>
                                                    Profit Report</a></li>
  
                                        
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/pos/good_disposal_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/pos/good_disposal_report') }}"><i></i></i>Good Disposal
                                                Report</a></li>
                                                {{--
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/pos/expire_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/pos/expire_report') }}"><i></i></i>Expired Item
                                                Report</a></li>
                                      --}}
                                        </li>
                                    </ul>
                                </li>
                            @endcan
  
  
  
                            @can('view-restaurant-report')
                                <li class="nav-item nav-item-submenu">
                                    <a href="#"
                                        class="nav-link {{ request()->is('reports/restaurant*') ? 'active' : '' }}">Restaurant
                                        Report</a>
                                    <ul class="nav nav-group-sub">
                                        {{--
  <li class="nav-item"><a class="nav-link {{ (request()->is('reports/restaurant/purchase_report*')) ? 'active' : ''  }}"  href="{{url('reports/restaurant/purchase_report')}}"><i></i></i>Inventory Purchase Report</a></li>
  <li class="nav-item"><a class="nav-link {{ (request()->is('reports/restaurant/sales_report*')) ? 'active' : ''  }}" href="{{url('reports/restaurant/sales_report')}}"><i></i></i>Inventory Sales Report</a></li>   
  <li class="nav-item"><a class="nav-link {{ (request()->is('reports/restaurant/store_value*')) ? 'active' : ''  }}"  href="{{url('reports/restaurant/store_value')}}"><i></i></i>Store Value</a></li>
  <li class="nav-item"><a class="nav-link {{ (request()->is('reports/restaurant/profit_report*')) ? 'active' : ''  }}"  href="{{url('reports/restaurant/profit_report')}}"><i></i></i>Profit Report  </a>
  --}}
  
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/restaurant/report_by_date*') ? 'active' : '' }}"
                                                href="{{ url('reports/restaurant/report_by_date') }}"><i></i></i>Report By
                                                Date </a>
                                                 <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/restaurant/stock_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/restaurant/stock_report') }}"><i></i></i>Stock Value
                                            </a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/restaurant/kitchen_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/restaurant/kitchen_report') }}"><i></i></i>Kitchen
                                                Report</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/restaurant/balance_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/restaurant/balance_report') }}"><i></i></i>Drinks
                                                Report</a></li>
                                                 <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/restaurant/kitchen_sales*') ? 'active' : '' }}"
                                                href="{{ url('reports/restaurant/kitchen_sales') }}"><i></i></i>Kitchen Sales
                                                Report</a></li>
                                                <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/restaurant/drink_sales*') ? 'active' : '' }}"
                                                href="{{ url('reports/restaurant/drink_sales') }}"><i></i></i>Drink Sales
                                                Report</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/restaurant/stock_movement_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/restaurant/stock_movement_report') }}"><i></i></i>Stock
                                                Movement Report</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/restaurant/good_disposal_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/restaurant/good_disposal_report') }}"><i></i></i>Good
                                                Disposal Report</a></li>
                                                
                                                {{--
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/restaurant/expire_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/restaurant/expire_report') }}"><i></i></i>Expired Item
                                                Report</a></li>
                                                --}}
                                       
  
  
                                </li>
                            </ul>
                        </li>
                    @endcan
                    
                    
                    
                            @can('view-pms-report')
                                <li class="nav-item nav-item-submenu">
                                    <a href="#"
                                        class="nav-link {{ request()->is('reports/pms*') ? 'active' : '' }}">Property Report</a>
                                    <ul class="nav nav-group-sub">
  
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/pms/room_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/pms/room_report') }}"><i></i></i>Room Report </a>
                                                
                             
                                       
  
  
                                </li>
                            </ul>
                        </li>
                    @endcan
                    
                    
                    
                    
                               @can('view-inventory-report')
                                <li class="nav-item nav-item-submenu">
                                    <a href="#"
                                        class="nav-link {{ request()->is('reports/inventory*') ? 'active' : '' }}">Inventory Report</a>
                                    <ul class="nav nav-group-sub">
                                      
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/inventory/report_by_date*') ? 'active' : '' }}"
                                                href="{{ url('reports/inventory/report_by_date') }}"><i></i></i>Report By Date </a>
                                                <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/inventory/requisition_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/inventory/requisition_report') }}"><i></i></i>Requisition
                                                Report</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/inventory/stock_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/inventory/stock_report') }}"><i></i></i>Stock Value </a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/inventory/profit_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/inventory/profit_report') }}"><i></i></i>Profit Report </a>
                                                
                                            
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/inventory/good_issue_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/inventory/good_issue_report') }}"><i></i></i>Good Issue
                                                Report</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/inventory/stock_movement_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/inventory/stock_movement_report') }}"><i></i></i>Stock
                                                Movement Report</a></li>
                                        <li class="nav-item"><a
                                                class="nav-link {{ request()->is('reports/inventory/good_disposal_report*') ? 'active' : '' }}"
                                                href="{{ url('reports/inventory/good_disposal_report') }}"><i></i></i>Good Disposal
                                                Report</a></li>
                                              
                                        </li>
                                    </ul>
                                </li>
                            @endcan
  
                    
                    
                    
                    @can('view-cargo-report')
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link {{ request()->is('reports/tracking*') ? 'active' : '' }}">Cargo Management Report</a>
                            <ul class="nav nav-group-sub">
                               
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('reports/tracking/debtors_report.*')) ? 'active' : ''  }}"
                                href="{{url('reports/tracking/debtors_report')}}"> Debtors
                                Report</a></li>
  
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('reports/tracking/debtors_summary_report.*')) ? 'active' : ''  }}"
                                href="{{url('reports/tracking/debtors_summary_report')}}"> Debtors Summary
                                Report</a></li>
  
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('reports/tracking/client_summary.*')) ? 'active' : ''  }}"
                                href="{{url('reports/tracking/client_summary')}}"> Client Summary
                                Report</a></li>
  
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('reports/tracking/creditors_report*')) ? 'active' : ''  }}"
                                href="{{url('reports/tracking/creditors_report')}}"> Creditors Report</a></li>
                       
  
                        <li class="nav-item"><a
                                class="nav-link {{ (request()->is('reports/creditors_refill_report*')) ? 'active' : ''  }}"
                                href="{{url('reports/tracking/creditors_refill_report')}}"> Creditors Refill Report</a></li>
                        
  
                            </ul>
                        </li>
                    @endcan
  
  
  
  
                    @can('view-school-report')
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link {{ request()->is('reports/school*') ? 'active' : '' }}">School
                                Management
                                Report</a>
                            <ul class="nav nav-group-sub">
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('reports/school/student_report*') ? 'active' : '' }}"
                                        href="{{ url('reports/school/student_report') }}"><i></i></i>Student Fees Report</a>
                                </li>
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('reports/school/class_report*') ? 'active' : '' }}"
                                        href="{{ url('reports/school/class_report') }}"><i></i></i>School Fees Report</a>
                                </li>
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('reports/school/payments_report*') ? 'active' : '' }}"
                                        href="{{ url('reports/school/payments_report') }}"><i></i></i>Payment Report</a>
                                </li>
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('reports/school/uncollected_fees*') ? 'active' : '' }}"
                                        href="{{ url('reports/school/uncollected_fees') }}"><i></i></i>Uncollected School
                                        Fees</a></li>
  
                            </ul>
                        </li>
                    @endcan
  
                    @can('view-project-report')
                        <li class="nav-item nav-item-submenu">
                            <a href="#"
                                class="nav-link {{ request()->is('reports/project*') ? 'active' : '' }}">Project Report</a>
                            <ul class="nav nav-group-sub">
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('reports/project/profit_report*') ? 'active' : '' }}"
                                        href="{{ url('reports/project/profit_report') }}"><i></i></i>Profit Report</a></li>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    
                    
                     @can('view-leave-menu')
                        <li class="nav-item nav-item-submenu">
                            <a href="#"
                                class="nav-link {{ request()->is('reports/leave*') ? 'active' : '' }}">Leave Report</a>
                            <ul class="nav nav-group-sub">
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->is('reports/leave/leave_report*') ? 'active' : '' }}"
                                        href="{{ url('reports/leave/leave_report') }}"><i></i></i>Leave Report</a></li>
                                </li>
                            </ul>
                        </li>
                    @endcan
  
  
  
  
                </ul>
                </li>
            @endcan
  
            <li class="nav-item"><a href="{{ url('chatify') }}"
                    class="nav-link {{ request()->is('chatify*') ? 'active' : '' }}"><i class="icon-envelop5"></i>
                    <span>Chattings</span> </a></li>
                    
       
  
            @can('view-access-control-menu')
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link {{ request()->is('access_control/*') ? 'active' : '' }}"><i
                            class="icon-cog7"></i> <span>
                            {{ __('permission.access_control') }}</span></a>
  
                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
  
  
                        @can('view-system-roles')
                            <li class=" nav-item"><a
                                    class="nav-link {{ request()->is('access_control/system_role*') ? 'active' : '' }}"
                                    href="{{ url('access_control/system_role') }}">System Roles</a>
                            </li>
  
                            <li class=" nav-item"><a
                                class="nav-link {{ request()->is('send-sms*') ? 'active' : '' }}"
                                href="{{ url('send-sms') }}">Send SMS</a>
                            </li>
  
                        @endcan
  
                        @if (auth()->user()->email == 'info@ujuzinet.com')
                            <li class=" nav-item"><a
                                    class="nav-link {{ request()->is('access_control/system_role*') ? 'active' : '' }}"
                                    href="{{ url('access_control/system_role') }}">System Roles</a>
                            </li>
  
                            <li class=" nav-item"><a
                                class="nav-link {{ request()->is('send-sms*') ? 'active' : '' }}"
                                href="{{ url('send-sms') }}">Send SMS</a>
                            </li>
  
                        @endif
  
  
                        @can('view-module')
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->is('access_control/system_module*') ? 'active' : '' }}"
                                    href="{{ url('access_control/system_module') }}">System Module</a>
  
                            </li>
                        @endcan
  
  
  
  
  
                        @can('view-roles')
                            <li class=" nav-item"><a
                                    class="nav-link {{ request()->is('access_control/roles*') ? 'active' : '' }}"
                                    href="{{ url('access_control/roles') }}">
                                    {{ __('permission.roles') }}</a>
                            </li>
                        @endcan
  
  
  
                        @can('view-permission')
                            <li class=" nav-item "><a
                                    class="nav-link {{ request()->is('access_control/permissions*') ? 'active' : '' }}"
                                    href="{{ url('access_control/permissions') }}">{{ __('permission.permissions') }}</a>
  
                            </li>
                        @endcan
  
  
  
                        @can('view-branch')
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->is('access_control/branch*') ? 'active' : '' }}"
                                    href="{{ url('access_control/branch') }}">Branch</a>
  
                            </li>
                        @endcan
                        
                         @can('view-fiscal')
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->is('access_control/fiscal_year*') ? 'active' : '' }}"
                                    href="{{ url('access_control/fiscal_year') }}">Fiscal Year</a>
  
                            </li>
                        @endcan
  
                        @can('view-user')
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->is('access_control/system*') ? 'active' : '' }}"
                                    href="{{ url('access_control/system') }}">{{ __('permission.system_setings') }}</a>
  
                            </li>
                        @endcan
  
                        @can('view-user')
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->is('access_control/departments*') ? 'active' : '' }}"
                                    href="{{ url('access_control/departments') }}">Departments
                                </a></li>
                        @endcan
  
                        @can('view-user')
                            <li class="nav-item"><a
                                    class="nav-link {{ request()->is('access_control/designations*') ? 'active' : '' }}"
                                    href="{{ url('access_control/designations') }}">Designations
                                </a></li>
                        @endcan
  
                        @can('view-user')
                            <li class=" nav-item "><a
                                    class="nav-link {{ request()->is('access_control/users*') ? 'active' : '' }}"
                                    href="{{ url('access_control/users') }}">{{ __('permission.user') }}
                                    Management</a></li>
                        @endcan
                        <li class="nav-item">
                            <a class="nav-link " href="{{ url('change_password') }}">Change Password</a>
                        </li>
  
  
  
  
                        @can('view-user-all')
                            <li class=" nav-item "><a
                                    class="nav-link {{ request()->is('access_control/users*') ? 'active' : '' }}"
                                    href="{{ url('access_control/users_all') }}">View All Users Details</a></li>
                      
                            <li class=" nav-item "><a
                                    class="nav-link {{ request()->is('access_control/users*') ? 'active' : '' }}"
                                    href="{{ url('access_control/affiliate_users_all') }}">View All Affiliate Users</a></li>
                        @endcan
  
  
  
                        @if (auth()->user()->id == 1)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('enhacement*') ? 'active' : '' }}"
                                    href="{{ url('enhacement') }}">Role in Enhancement</a>
                            </li>
                        @endif
  
  
                        @if (auth()->user()->email == 'info@ujuzinet.com')
                            <li class=" nav-item "><a
                                    class="nav-link {{ request()->is('access_control/users*') ? 'active' : '' }}"
                                    href="{{ url('access_control/users_all') }}">View All Users Details</a></li>
                            <li class=" nav-item "><a
                                    class="nav-link {{ request()->is('access_control/users*') ? 'active' : '' }}"
                                    href="{{ url('access_control/affiliate_users_all') }}">View All Affiliate Users</a>
                            </li>
                        @endif
  
                        @if (auth()->user()->id == 1)
                            <li class="nav-item"><a class="nav-link {{ request()->is('azamPay*') ? 'active' : '' }}"
                                    href="{{ route('azampay.index') }}">Subscription</a>
                            </li>
                        @endif
  
  
                    </ul>
                </li>
            @endcan
            
             
                    <li class="nav-item"><a class="nav-link {{ request()->is('view_features*') ? 'active' : '' }}"
                            href="{{ url('view_features') }}" target="_blank"><i class="icon-cabinet"></i><span>View System Features</span></a>
                    </li>
                    
                    
                       <li class="nav-item"><a class="nav-link {{ request()->is('system.auditing*') ? 'active' : '' }}"
                            href="{{ route('system.auditing') }}" ><i class="icon-cabinet"></i><span>Audit Trails</span></a>
                    </li>
                
            
            <!-- /page kits -->
  
  
  
            </ul>
        </div>
        <!-- /main navigation -->
  
    </div>
    <!-- /sidebar content -->
  
  </div>
  <!-- /main sidebar -->