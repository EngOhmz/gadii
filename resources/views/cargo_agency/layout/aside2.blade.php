<div class="sidebar sidebar-light sidebar-main sidebar-expand-lg">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-section">
            <div class="sidebar-user-material">
                <div class="sidebar-section-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <button type="button"
                                class="btn btn-outline-light border-transparent btn-icon btn-sm rounded-pill">
                                <i class="icon-wrench"></i>
                            </button>
                        </div>
                        <a href="#" class="flex-1 text-center"><img
                                src="../../../../global_assets/images/placeholders/placeholder.jpg"
                                class="img-fluid rounded-circle shadow-sm" width="80" height="80" alt=""></a>
                        <div class="flex-1 text-right">
                            <button type="button"
                                class="btn btn-outline-light border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                                <i class="icon-transmission"></i>
                            </button>

                            <button type="button"
                                class="btn btn-outline-light border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
                                <i class="icon-cross2"></i>
                            </button>
                        </div>
                    </div>

                    <div class="text-center">
                        <h6 class="mb-0 text-white text-shadow-dark mt-3">Madekenya</h6>

                        @php  $email = App\Models\User::find(auth()->user()->id)->email;@endphp
                        
                        <h6 class="mb-0 text-white text-shadow-dark mt-3">@php echo $email  @endphp</h6>
                        
                        <span class="font-size-sm text-white text-shadow-dark"></span>
                    </div>
                </div>

              
            </div>

            
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
             
                <li class="nav-item">
                    <a href="{{url('home')}}"
                        class="nav-link  {{ (request()->is('home')) ? 'active' : ''  }}">
                        <i class="icon-magazine"></i>
                        <span>
                            Sajili Wateja & Mizigo
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('list_ya_wateja')}}"
                        class="nav-link  {{ (request()->is('home')) ? 'active' : ''  }}">
                        <i class="icon-users4"></i>
                        <span>
                            List ya Wateja 
                        </span>
                    </a>
                </li>



             <!--   <li class="nav-item">
                <a class="nav-link {{ (request()->is('management/driver.*')) ? 'active' : ''  }}"
                                href="{{ url('management/driver') }}"> <i class="icon-user-check"></i>
                        <span>{{__('Sajili Madereva')}} </span></a>
                </li>


                <li class="nav-item">
                <a class="nav-link {{ (request()->is('management/car.*')) ? 'active' : ''  }}"
                                href="{{ url('management/car') }}"> <i class="icon-truck"></i>
                        <span>{{__('Sajili Magari')}}</span> </a>
                </li>  -->


                <li class="nav-item">
                <a class="nav-link {{ (request()->is('management/pacel_store.*')) ? 'active' : ''  }}"
                                href="{{ url('management/pacel_store') }}"> <i class="icon-list-unordered"></i>
                        <span>{{__('Store records')}}</span> </a>
                </li>


                <li class="nav-item">
                <a class="nav-link {{ (request()->is('management/search_store.*')) ? 'active' : ''  }}"
                                href="{{ url('management/search_store') }}"> <i class="icon-bus"></i>
                        <span>{{__('delivery note')}}</span> </a>
                </li>
                <li class="nav-item">
                <a class="nav-link {{ (request()->is('management/search.*')) ? 'active' : ''  }}"
                                href="{{ url('management/search') }}"> <i class="icon-file-media"></i>
                        <span>{{__('customer history')}}</span> </a>
                </li>



                
                <li class="nav-item">
                <a class="nav-link {{ (request()->is('management/car_today2.*')) ? 'active' : ''  }}"
                                href="{{ url('management/car_today2') }}"> <i class="icon-sync"></i>
                        <span>{{__('active cars')}}</span> </a>
                </li>
                <li class="nav-item">
                <a class="nav-link {{ (request()->is('management/arrived_car.*')) ? 'active' : ''  }}"
                                href="{{ url('management/arrived_car') }}"> <i class="icon-sort-time-asc"></i>
                        <span>{{__('arrived cars')}}</span> </a>
                </li>

                <li class="nav-item">
                <a class="nav-link {{ (request()->is('management/all_car.*')) ? 'active' : ''  }}"
                                href="{{ url('management/all_car') }}"> <i class="icon-car2"></i>
                        <span>{{__('all cars')}}</span> </a>
                </li>
                <li class="nav-item">
                <!-- <a class="nav-link {{ (request()->is('management/old_car.*')) ? 'active' : ''  }}"
                                href="{{ url('management/old_car') }}"> <i class="icon-car2"></i>
                        <span>{{__('magari ya zamani')}}</span> </a>
                </li> -->


                


                

                <li class="nav-item nav-item-submenu"> <a href="#" class="nav-link"><i class="icon-cog7"></i> <span> Access Control</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">

                        <li class=" nav-item "><a class="nav-link {{ (request()->is('users*')) ? 'active' : ''  }}" href="{{url('users')}}">User Management</a></li>
                       
                         <li class="nav-item">  <a class="nav-link " href="{{ url('change_password') }}">Change Password</a> </li>

                        <li class=" nav-item"><a class="nav-link {{ (request()->is('access_control/roleGroup*')) ? 'active' : ''  }}"
                                 href="{{ route('roles.index') }}">Role</a>
                        </li>

                        <li class=" nav-item "><a class="nav-link {{ (request()->is('access_control/roleGroup*')) ? 'active' : ''  }}"
                            <a href="{{ route('permissions.index') }}"> Permission</a>
                        </li>

                    </ul>
                </li>


                   

                <!-- /page kits -->


       

 

        
    
    </ul>

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>