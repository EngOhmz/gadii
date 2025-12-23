
  
<a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle" data-toggle="dropdown">
   
    <span class="d-none d-lg-inline-block ml-2"></span>
</a>

<div class="dropdown-menu dropdown-menu-right dropdown-content wmin-lg-150">

    <div class="dropdown-content-body p-2">
        <ul class="media-list">

            <li>
           <a href="{{ route('list_ya_wateja.detail',  $row->id) }}" class="edit btn btn-primary btn-sm">View</a> <br>

            </li>
            <br>
            <li>
           <a href="{{ route('list_ya_wateja.editmzigo',  $row->id) }}" class="edit btn btn-warning btn-sm">Ongeza Mzigo</a>
           </li>
           
        </ul>
    </div>
</div>