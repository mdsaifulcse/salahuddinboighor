@extends('backend.app')


@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{URL::to('home')}}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#">page Menu</a></li>

    </ol>
@endsection

@section('content')
<div class="tab_content content">


    <div class="box-header with-border">
        <h3 class="box-title">Add menu from page</h3>

        <h3 class="pull-right box-title">
            <a href="{{route('menu.index')}}" class="btn btn-primary pull-right"> <i class="ion ion-navicon-round"></i> View All </a>
            <a href="{{route('menu.create')}}" class="btn btn-primary pull-right"> <i class="fa fa-plus"></i> Add custom menu </a>
        </h3>
    </div>



	{!! Form::open(array('route' => 'menu.store','class'=>'form-horizontal','files'=>true)) !!}
         <div class="form-group  {{ $errors->has('page') ? 'has-error' : '' }}">
            
            {{Form::label('page', 'Page', array('class' => 'col-md-3 control-label'))}}
            <div class="col-md-8">
                    {{Form::select('page',$page,'null',array('class'=>'form-control','placeholder'=>'-select-','required'))}}
                @if ($errors->has('page'))
                    <span class="help-block">
                        <strong>{{ $errors->first('page') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            {{Form::label('serial_num', 'Serial', array('class' => 'col-md-3 control-label'))}}
            <div class="col-md-8">
            <? $max=$max_serial+1; ?>
                {{Form::number('serial_num',"$max",array('class'=>'form-control','placeholder'=>'Serial Number','max'=>"$max",'min'=>'0'))}}
            </div>
        </div>
        <div class="form-group">
            {{Form::label('status', 'Status', array('class' => 'col-md-3 control-label'))}}
            <div class="col-md-8">
                {{Form::select('status', array('1' => 'Active', '2' => 'Inactive'),'1', ['class' => 'form-control'])}}
            </div>
        </div>
        
	    <div class="form-group">
	        <div class="col-md-9 col-md-offset-3">
	            <button type="submit" class="btn btn-primary">Submit</button>
	        </div>
	    </div>
      </div>
	{!! Form::close() !!}

@endsection

