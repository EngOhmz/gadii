@extends('layouts.master')
@section('title'){{trans_choice('general.edit',1)}}  {{trans_choice('general.group_account',1)}}
@endsection
@section('content')
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">{{trans_choice('general.edit',1)}}  {{trans_choice('general.group_account',1)}}</h6>

            <div class="heading-elements">

            </div>
        </div>
  {!! Form::open(array('url' => url('group_account/'.$group_account->id.'/update'), 'method' => 'post', 'class' => 'form-horizontal')) !!}
   
   <div class="panel-body">
            <div class="form-group">
                {!! Form::label('Group ID',trans_choice('general.group_id',1),array('class'=>'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    {!! Form::text('group_id',$group_account->group_id, array('class' => 'form-control', 'placeholder'=>"",'required'=>'required')) !!}
                </div>
            </div>
    <div class="form-group">
                {!! Form::label('name',trans_choice('general.name',1),array('class'=>'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    {!! Form::text('name',$group_account->name, array('class' => 'form-control', 'placeholder'=>"",'required'=>'required')) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('class',trans_choice('general.group_class',1),array('class'=>'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
        <select class="form-control "  name="class"  required="required">
                                                        <option value="">Select Class</option>                                                     
                                                            @foreach ($class_account as $class)                                                             
                                                                <option value="{{$class->class_name}}" {{(!empty($group_account))?($class->class_name==$group_account->class)?'selected':'':''}}>{{$class->class_name}}</option>
                                                               @endforeach
                                                    </select>
                </div>
            </div>
          

        </div>

      <!-- /.panel-body -->
        <div class="panel-footer">
            <div class="heading-elements">
                <button type="submit" class="btn btn-primary pull-right">{{trans_choice('general.save',1)}}</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
@endsection

