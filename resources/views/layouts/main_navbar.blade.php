<div class="navbar navbar-expand-lg navbar-dark bg-indigo navbar-static">
    <div class="d-flex flex-1 d-lg-none">
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>

        <a href="tel:+0618330260" class="navbar-nav-link navbar-nav-link-toggler" >
          Contact us : +255618330260
        </a>
        
    </div>

    <div class="navbar-brand text-center text-lg-left">

    </div>

   <div class="navbar-collapse collapse flex-lg-1 mx-lg-3 order-2 order-lg-1" id="navbar-search">
        <div class="navbar-search d-flex align-items-center py-2 py-lg-0">
            <div class="form-group-feedback form-group-feedback-left flex-grow-1">
     
    <a href="tel:+255618330260" class="navbar-nav-link navbar-nav-link-toggler" >Please feel free to contact us for any inquiries : +255620650846</i></a>
               
            </div>
        </div>
    </div>
    

    <div class="d-flex justify-content-end align-items-center flex-1 flex-lg-0 order-1 order-lg-2">
        <ul class="navbar-nav flex-row">


            <li class="nav-item nav-item-dropdown-lg dropdown">
                <a href="{{route('addShortCut.index')}}" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle" data-toggle="dropdown">
                   <i class="icon-plus-circle2"></i>
                    <span class="d-none d-lg-inline-block ml-2"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-lg-150">
                    
                   <div class="dropdown-content-body p-2">
                        <ul class="media-list">
                        @can('view-supplier-menu')
                <li><a class="dropdown-item" href="#" aria-expanded="false" data-toggle="modal" value="" data-type="supplier"
                    data-target="#appShortCutFormModal" onclick="modelShortCut('shortcut_supplier')">New Supplier</a></li>
                    @endcan
                    
                    
                    @can('view-client-menu')
                    <li><a class="dropdown-item" href="#" aria-expanded="false" data-toggle="modal" value="" data-type="client"
                    data-target="#appShortCutFormModal" onclick="modelShortCut('shortcut_client')">New Client</a></li>
                    @endcan
                    
                     @can('view-driver')
                    <li><a class="dropdown-item" href="#">New Driver</a></li>
                    @endcan
                    
                     @can('view-purchase')
                   
                     <li><a class="dropdown-item"  href="{{url('pos/purchases/purchase')}}">New Purchase</a></li>
                    @endcan
                    
                     @can('view-sales')
                     
                     <li><a class="dropdown-item"   href="{{url('pos/sales/invoice')}}">New Invoice</a></li>
                    @endcan
                    
                    {{--
                      @can('view-manual_entry')
                     <li><a class="dropdown-item"   href="{{route('subscribe')}}">subscribe</a></li>
                     @endcan
                     --}}
                    
                    <li><a class="dropdown-item"  href="{{ url('accounting/manual_entry') }}">View Journal Entry</a></li>
                    
                     @can('view-chart_of_account')
                    <li><a class="dropdown-item" href="{{ url('gl_setup/chart_of_account') }}">View Chart Of Account</a></li>
                    @endcan
                    
                        </ul>
                    </div>

                    
                </div>
            </li>
            
            
            
             <li class="nav-item nav-item-dropdown-lg dropdown">
                <a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle" data-toggle="dropdown">
                  <i class="icon-bell2"></i>
						<span class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1">{{$countUnreadNotifications}}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-lg-350">
                    <div class="dropdown-content-header">
                        <span class="font-size-sm line-height-sm text-uppercase font-weight-semibold">Latest
                            activity</span>
                       
                    </div>
                    
                    <div class="dropdown-content-body dropdown-scrollable">
                        <ul class="media-list">
                       @php 
                       if(auth()->user()->added_by == auth()->user()->id){
                           $unreadNotifications =  App\Models\Notification::where('added_by', auth()->user()->added_by)->orderBy('created_at','desc')->take(10)->get(); ;
                       }
                       
                       else{
                $unreadNotifications =  App\Models\Notification::where('added_by', auth()->user()->added_by)->where('from_user_id', auth()->user()->id)->orWhere->where('added_by', auth()->user()->added_by)->where('to_user_id', auth()->user()->id)
                ->orderBy('created_at','desc')->take(10)->get(); ;  
                       }
                       
                       
                       @endphp
                            @if(!empty($unreadNotifications[0]))
                             @foreach($unreadNotifications as $notif)
                            <li class="media">
                                <div class="mr-3">
                                    <a href="#" class="btn btn-pink rounded-pill btn-icon"><i class="icon-paperplane"></i></a>
                                </div>

                                <div class="media-body">
                                <span class="n-title text-sm block"> {{$notif->description}}</span>
                                
                                 @if ($notif->read == 0) 
                          <span class="text-muted float-right mark-as-read-inline" onclick="" >
                    <a href="{{ route('notif.read', $notif->id) }}"><i style="font-size:10px;" class="icon-circle" data-bs-placement="top" data-bs-popup="tooltip" data-toggle="tooltip" title="Mark as read"></i></a>
                                </span>
                                    @endif
                              
                               <div class="row">  
                        <div class="col-lg-6">
                        <small class="text-muted pull-left" style="margin-top: -4px"><i style="font-size:12px;"class="icon-watch2"></i>{{$notif->created_at->diffForHumans()}} </small>
                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                            
                            <div class="dropdown-divider"></div>
                            
                            <div class="row">
                        <div class="col-lg-6"><li class="text-center"><a href="{{ route('notif.read_all') }}">Mark all as read </a></li></div>
                        <div class="col-lg-6"><li class="text-center"><a href="{{ route('notif.view_all', auth()->user()->id) }}">View All Notifications</a></li></div>
                        </div>
                        @else
                      <li class="text-center"><h6>No Notifications</h6></li>
                            
                            @endif
                        </ul>
                    </div>

                    
                </div>
            </li>
            
            <li class="nav-item nav-item-dropdown-lg dropdown">
                <a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle" data-toggle="dropdown">
                  <img src="{{url('public/assets/img/default_avatar.jpg')}}" class="w-20px h-20px rounded-pill" alt="" width="20px" height="20px">
                    <span class="d-none d-lg-inline-block ml-2"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-lg-150">
                    
                   <div class="dropdown-content-body p-2">
                        <ul class="media-list">
                <li><a class="dropdown-item" href="{{ route('user.details', auth()->user()->id)}}">	<i class="icon-user"></i>My Details</a></li>
               <li><a class="dropdown-item" href="{{ url('change_password') }}">	<i class="icon-lock4"></i>Change Password</a></li>
                     @if(auth()->user()->id == auth()->user()->added_by)
                    <li><a class="dropdown-item" href="{{ route('azampay.index')}}"><i class="icon-coin-dollar"></i> My Subscription</a></li>
                    @endif
                    <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> 
                    <i class="icon-exit"></i>Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                </li>
                        </ul>
                    </div>

                    
                </div>
            </li>
            
             

        </ul>
    </div>
</div>


<div class="modal fade" id="appShortCutFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    
    </div>
</div>

<script type="text/javascript">
        function modelShortCut(type) {

            $.ajax({
                type: 'GET',
                url: '{{ url('shortCutModal') }}',
                data: {
                    'type': type,
                },
                cache: false,
                async: true,
                success: function(data) {
                    //alert(data);
                    $('.modal-dialog').html(data);
                },
                error: function(error) {
                    $('#appShortCutFormModal').modal('toggle');

                }
            });

        }
    </script> 

