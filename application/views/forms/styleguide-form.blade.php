@layout('templates.main')
@section('content')
	<div class="page-header">
		<h1>{{ $pageTitle }}</h1>
	</div>
	{{ Form::open(URL::current(), 'POST', array('id'=>'styleguideForm','class' => 'form-vertical')) }}
		<div class="control-group {{ $errors->first('name')?'error':'' }}">
        	{{ Form::label('name', 'Name',array('class'=>'control-label')) }}
        	<div class="controls">
            	{{ Form::text('name',@$styleguide->name)}}
            	{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
            </div>
        </div>
        <div class="control-group {{ $errors->first('guid')?'error':'' }}">
        	{{ Form::label('guid', 'GUID',array('class'=>'control-label')) }}
        	<div class="controls">
            	{{ Form::text('guid',@$styleguide->guid)}}
            	{{ $errors->first('guid', '<span class="help-inline">:message</span>') }}
            </div>
        </div>
        <div class="form-actions">
        	<button class='btn btn-primary'><i class='icon-ok'></i> {{ $submitButtonTitle }}</button> <a href="{{ URL::to($cancelButtonLink) }}" class="btn"><i class="icon-remove"></i> Cancel</a>
        </div>
	{{ Form::close() }}
@endsection