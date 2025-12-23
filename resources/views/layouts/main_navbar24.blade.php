<div class="navbar navbar-expand-lg navbar-dark bg-indigo navbar-static">
    <div class="d-flex flex-1 d-lg-none">
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>

          <a href="tel:+255618330260" class="navbar-nav-link navbar-nav-link-toggler" >
          Contact us : +255618330260
        </a>
        
    </div>

    <div class="navbar-brand text-center text-lg-left">

    </div>

    <div class="navbar-collapse collapse flex-lg-1 mx-lg-3 order-2 order-lg-1" id="navbar-search">
        <div class="navbar-search d-flex align-items-center py-2 py-lg-0">
            <div class="form-group-feedback form-group-feedback-left flex-grow-1">
     
    <a href="tel:+255618330260" class="navbar-nav-link navbar-nav-link-toggler" >Please feel free to contact us for any inquiries : +255655973248</i></a>
               
            </div>
        </div>
    </div>
    
    
<div class="d-flex justify-content-end align-items-center flex-1 flex-lg-0 order-1 order-lg-2">
        <ul class="navbar-nav flex-row">


 
            
            <li class="nav-item nav-item-dropdown-lg dropdown">
                <a href="#" class="navbar-nav-link navbar-nav-link-toggler dropdown-toggle" data-toggle="dropdown">
                  <img src="{{url('public/assets/img/default_avatar.jpg')}}" class="w-20px h-20px rounded-pill" alt="" width="20px" height="20px">
                    <span class="d-none d-lg-inline-block ml-2"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-lg-150">
                    
                   <div class="dropdown-content-body p-2">
                        <ul class="media-list">
             
                    
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

