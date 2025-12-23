<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

                                @if(!empty(Session::get('success')))

                                <div class="bootstrap-growl alert alert-success " style="position:absolute;margin:0px;z-index:9999; top:20px;width:250px;right:20px">
                                
                                   <a class="close" data-dismiss="alert" href="#">&times;</a>
                                  
                                            {{Session::get('success')}}
                                   
                                   </div>


                                


                                @elseif(!empty(Session::get('error')))
                            
                                   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


                                   <div class="bootstrap-growl alert alert-danger " style="position:absolute;margin:0px;z-index:9999; top:20px;width:250px;right:20px">
                                
                                   <a class="close" data-dismiss="alert" href="#">&times;</a>
                                                {{Session::get('error')}} 
                                   </div>
                                   
                                  



                                 @endif
                                 <script>
                                $(".alert").delay(6000).slideUp(200, function() {
                                $(this).alert(close);
                                });
                                </script>