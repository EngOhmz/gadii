<div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li>
            <li>
              <form class="form-inline mr-auto">
                <div class="search-element">
                  <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
                  <button class="btn" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          
          <?php 
          $unseensms = \App\Models\ChMessage::where('to_id', Auth::user()->id )->where('seen', 0 )->get();
          $numberofunseensms = $unseensms->count();

                ?>
          <li class="dropdown dropdown-list-toggle">
            <a href="" data-toggle="dropdown"
              class="nav-link notification-toggle nav-link-lg  <?php echo e($numberofunseensms >0?'message-toggle' :''); ?>"><i data-feather="bell" class="<?php echo e($numberofunseensms >0?'bell' :''); ?>"></i>
              <span class="badge headerBadge1">
                <?php echo e($numberofunseensms >0?$numberofunseensms :""); ?> </span>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
              <div class="dropdown-header">
                Notifications
                
              </div>
              <div class="dropdown-list-content dropdown-list-icons">
                <a href="<?php echo e(url('chatify')); ?>" class="dropdown-item"> <span class="dropdown-item-icon bg-info text-white"> <i class="far
                  fa-envelope"></i></i>
                </span> <span class="dropdown-item-desc"> see all messages  </span>
                </a>
              </div>
             
            </div>
          </li>
          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="assets/img/user.png"
                class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Hello Sarah Smith</div>
              <a href="<?php echo e(url('user_details')); ?>" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Profile
              </a> <a href="timeline.html" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                Activities
              </a> 
              <div class="dropdown-divider"></div>
             
             
                <a href="<?php echo e(route('logout')); ?>"   class="dropdown-item has-icon text-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> <?php echo e(__('Logout')); ?>

                </a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
           
            </div>
          </li>
        </ul>
      </nav><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/layouts/top.blade.php ENDPATH**/ ?>