<!-- Main sidebar -->
		<div class="sidebar sidebar-light sidebar-main sidebar-expand-lg">

			<!-- Sidebar content -->
			<div class="sidebar-content">

				<!-- User menu -->
				<div class="sidebar-section">
					<div class="sidebar-user-material">
						<div class="sidebar-section-body">
							<div class="d-flex">
								<div class="flex-1">
									<button type="button" class="btn btn-outline-light border-transparent btn-icon btn-sm rounded-pill">
										<i class="icon-wrench"></i>
									</button>
								</div>
								<a href="#" class="flex-1 text-center"><img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="img-fluid rounded-circle shadow-sm" width="80" height="80" alt=""></a>
								<div class="flex-1 text-right">
									<button type="button" class="btn btn-outline-light border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
										<i class="icon-transmission"></i>
									</button>

									<button type="button" class="btn btn-outline-light border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
										<i class="icon-cross2"></i>
									</button>
								</div>
							</div>


							<div class="text-center">
								<h6 class="mb-0 text-white text-shadow-dark mt-3"></h6>
								<span class="font-size-sm text-white text-shadow-dark"></span>
							</div>
						</div>
													
						<div class="sidebar-user-material-footer">
							<a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle" data-toggle="collapse"><span>My account</span></a>
						</div>
					</div>

					<div class="collapse border-bottom" id="user-nav">
						<ul class="nav nav-sidebar">
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="icon-user-plus"></i>
									<span>My profile</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="icon-coins"></i>
									<span>My balance</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="icon-comment-discussion"></i>
									<span>Messages</span>
									<span class="badge badge-teal badge-pill align-self-center ml-auto">58</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="icon-cog5"></i>
									<span>Account settings</span>
								</a>
							</li>
							 <li class="nav-item">
                        <!-- <a href="{{ route('logout') }}" class="nav-link">
                            <i class="icon-switch2"></i>
                            <span>Logout</span>
                        </a> -->
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
						<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs mt-1">Main</div> <i class="icon-menu" title="Main"></i></li>

					  <li class="nav-item">
               <a href="{{url('home')}}"
                        class="nav-link  {{ (request()->is('home')) ? 'active' : ''  }}">
                <i class="icon-home4"></i>
                <span>
                  Dashboard
                </span>
              </a>
            </li>
            
            
                                <li class="nav-item"><a
                                class="nav-link {{ (request()->is('affiliate.users*')) ? 'active' : ''  }}"
                                href="{{url('affiliate/users')}}"><i class="icon-location4"></i><span>Affiliatees</span></a></li>
                                
                                <li class="nav-item"><a
                                class="nav-link"
                                href="{{url('affiliate/withdraw/settings')}}"><i class="icon-location4"></i><span> Affiliator Settings</span></a></li>
                                
                                
                                <li class="nav-item"><a
                                class="nav-link"
                                href="{{url('affiliate/withdraw/methods')}}"><i class="icon-location4"></i><span> Withdrawal Methods</span></a></li>
                                
                                <li class="nav-item"><a
                                class="nav-link"
                                href="{{url('affiliate/withdraw/request')}}"><i class="icon-location4"></i><span>Withdrawal Requests</span></a></li>

               


                <!-- /page kits -->


						
					</ul>
				</div>
				<!-- /main navigation -->

			</div>
			<!-- /sidebar content -->
			
		</div>
		<!-- /main sidebar -->