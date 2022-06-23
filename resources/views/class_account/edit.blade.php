@extends('layouts.master')
@section('title'){{trans_choice('general.edit',1)}} {{trans_choice('general.class_account',1)}}
@endsection
@section('content')
 <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title">{{trans_choice('general.edit',1)}}  {{trans_choice('general.class_account',1)}}</h6>

            <div class="heading-elements">

            </div>
        </div>
        {!! Form::open(array('url' => url('class_account/'.$class_account->id.'/update'), 'method' => 'post', 'class' => 'form-horizontal')) !!}
        <div class="panel-body">

               <div class="form-group">
                {!! Form::label('Class ID',trans_choice('general.class_id',1),array('class'=>'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    {!! Form::text('class_id',$class_account->class_id, array('class' => 'form-control', 'placeholder'=>"",'required'=>'required')) !!}
                </div>
 </div>
            <div class="form-group">
                {!! Form::label('name',trans_choice('general.name',1),array('class'=>'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    {!! Form::text('class_name',$class_account->class_name, array('class' => 'form-control', 'placeholder'=>"",'required'=>'required')) !!}
                </div>
            </div>
         
           
            <div class="form-group">
                {!! Form::label('Class Type',trans_choice('general.class_type',1),array('class'=>'col-sm-3 control-label')) !!}
                <div class="col-sm-9">
                    {!! Form::select('class_type',
['s' => 'Please Select', 'Expense'=>trans_choice('general.expense',1),'Assets'=>trans_choice('general.asset',2),'Equity'=>trans_choice('general.equity',1),'Liability'=>trans_choice('general.liability',1),
'Income'=>trans_choice('general.income',1)],$class_account->class_type, array('class' => 'form-control', 'placeholder'=>"",'required'=>'required')) !!}
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

