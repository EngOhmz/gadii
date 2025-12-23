<div class="tab-pane fade @if($type =='notification') active show  @endif" id="tab4" role="tabpanel"
    aria-labelledby="tab1">
    <?php $id = 1; ?>
<div class="row">
                        <div class="col-lg-12 col-md-12">
    <div class="card">
        <div class="card-header">
            <h4>Notifications</h4>
        </div>
        <div class="card-body">
           
            <div class="tab-content tab-bordered" id="myTab3Content">
                <div class="tab-pane fade @if($type =='basic' || $type =='bank'  || $type =='salary' || $type =='notification') active show @endif" id="home4" role="tabpanel"
                    aria-labelledby="home-tab2">
                    
                     <div class="table-responsive">
                     
                     
                           
                        <div class="col-lg-2"><span class="text-center"><a href="{{ route('notif.read_all') }}">Mark all as read </a></span></div>
                                        <table class="table datatable-notif table-striped">
                                       <thead style="display:none;">
                                            <tr>
                                              
                                                    <th>Description</th>
                                               
                                                    
                                               
                                            </tr>
                                        </thead>
                                       
                                        <tbody>
                                           
                            @if(!empty($unreadNotifications))
                             @foreach($unreadNotifications as $notif)
                             <tr>
                             
                           
                             
                             <td>
                            <li class="media">
                                
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
                            
                            </td>
                             </tr>
                            @endforeach
                           
                            @endif
                                          
                            
                     
                                        </tbody>

                                    </table>
                        </div>
                    </div>
                
 

            </div>
        </div>
    </div>
 </div>
</div>
</div>