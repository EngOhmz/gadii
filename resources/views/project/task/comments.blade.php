 <div class="card-header"> <strong>Discussion</strong> </div>
                                                
                                            <div class="card-body">
                                                
                                                <br>
                                                 
                                                                <div class="row">
                                                                    <div class="col-sm-12 ">


                                                                        {!! Form::open(array('route' => 'save.task_details',"enctype"=>"multipart/form-data")) !!}                                                                                                                             
                                                                        @method('POST')
                                                                                                                                          
                                                                        
                                                                     <input type="hidden" name="task_id" value="{{ $id}}">
                                                                          <input type="hidden" name="type" value="comments">

                                                                        <div class="form-group row">
                                                                            <label class="col-lg-2 col-form-label"> Discussion <span class="text-danger">*</span></label>
                                                                           <div class="col-lg-10">
                                                                              <textarea name="comment"  rows="5" class="form-control" required ></textarea>
                                                                    
                                                                            </div>
                                                                        </div>
                                                                       
                                                                       
                                                                    <div class="form-group row">
                                                                        <div class="col-lg-offset-2 col-lg-12">
                                                                           
                                                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                                type="submit">Save</button>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                        {!! Form::close() !!}
                                                                    </div>

                                                </div>
                                            </div>


                                    <!-- Stacked layout -->
                                                    
							<div class="card">
							
								<div class="card-body">
									<div class="media-chat-scrollable mb-3">
										<div class="media-chat vstack gap-3">

                                                                                      @if (!empty($comment_details))
                                                                                    @foreach ($comment_details as $v_comment) 
											
                                                                                          <hr>
											<div class="hstack align-items-start gap-3">
												
												<div class="flex-fill">
													<div>
														<a href="#" class="fw-semibold">{{$v_comment->user->name}}</a>
														<span class="text-muted fs-sm ms-2"> &nbsp;&nbsp; {{\Carbon\Carbon::parse($v_comment->comment_datetime)->diffForHumans()}}</span>
													</div>
													{{$v_comment->comment}}
												</div>

                                                                                           <br>
<button style = "border:none;background: none;" class="text-primary reply" data-toggle="tooltip" data-placement="top" title="Click to reply"  id="reply__<?php echo $v_comment->id ?>"  data-sub_category_id="<?php echo $v_comment->id ?>"><i  class="icon-reply"></i> Reply</button> &nbsp
@if ($v_comment->user_id == auth()->user()->id)

                  <a class="text-danger delete" title="Edit"  href="{{route('delete.task_details',['type'=>'delete-comments','type_id'=>$v_comment->id])}}" onclick= "return confirm('Are you sure, you want to delete?')"><i class="icon-trash"></i> Delete</a>
    @endif						
											
											

                     <?php
                            $comment_reply=App\Models\Project\Comment::where('task_id',$id)->where('comments_reply_id', $v_comment->id)->where('disabled','0')->orderBy('comment_datetime', 'ASC')->get();  
                       ?>
                      @if (!empty($comment_reply))
                                         @foreach ($comment_reply as $v_reply) 


                   <div id="new-projects-reply-comment-form-container-<?php echo $v_reply->id ?>"> 
   <div class="row">
<div class="col-lg-1"></div>

<div class="col-lg-10"><br>
        <div class="hstack align-items-start gap-3">
												
												<div class="flex-fill">
													<div>
														<a href="#" class="fw-semibold">{{$v_reply->user->name}}</a>
														<span class="text-muted fs-sm ms-2"> &nbsp;&nbsp; {{\Carbon\Carbon::parse($v_reply->comment_datetime)->diffForHumans()}}</span>
													</div>
													{{$v_reply->comment}}
												</div>

                                                                                         
@if ($v_reply->user_id == auth()->user()->id)

                  <a class="text-danger delete" title="Edit"  href="{{route('delete.task_details',['type'=>'delete-comments','type_id'=>$v_reply->id])}}" onclick= "return confirm('Are you sure, you want to delete?')"><i class="icon-trash"></i> Delete</a>
    @endif						
											
	</div>  
  						
        </div>       
        </div>
</div>
          @endforeach
@endif
                        
     

                <div class="reply__" id="reply_<?php echo $v_comment->id ?>" style="display: none;">
                    <form id="projects-reply-comment-form-<?php echo $v_comment->id ?>"  action="{{route('save.task_details')}}" method="post">
                         @csrf
                        <input type="hidden" name="task_id" value="{{$id}}"   class="form-control">
                         <input type="hidden" name="type" value="comments-reply">
                  <input type="hidden" name="comments_reply_id" value="{{$v_comment->id}}">

                        <div class="form-group mb-sm">
                          <textarea name="comment" class="form-control reply_comments"  rows="3"></textarea>                                                            
                        </div>
                        <button type="submit" id="reply-<?php echo $v_comment->id ?>"
                                class="btn btn-xs btn-primary">Save</button>
                        
 <button type="button" style = "border:none;background: none;" class="text-danger remove" data-toggle="tooltip" data-placement="top" title="" id="cancel-<?php echo $v_comment->id ?>" data-original-title="Remove" data-category_id="<?php echo $v_comment->id ?>"><i class="icon-x"></i> Remove </button>
                        
                    </form>
<br>

                </div>
               

            </div>
       


@endforeach

@endif


	
</div>			                    	</div>
								</div>
							</div>


<!-- /stacked layout -->
