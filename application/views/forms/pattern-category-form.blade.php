@layout('templates.main')
@section('content')
	<div class="page-header">
		<h1>{{ $pageTitle }}</h1>
	</div>
	{{ Form::open('#', 'POST', array('id'=>'patternForm','class' => 'form-vertical')) }}
		<div class="control-group {{ $errors->first('name')?'error':'' }}">
        	{{ Form::label('name', 'Name',array('class'=>'control-label')) }}
        	<div class="controls">
            	{{ Form::text('name',@$category->name)}}
            	{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
            </div>
        </div>
		<div class="control-group {{ $errors->first('lead')?'error':'' }}">
        	{{ Form::label('lead', 'Lead',array('class'=>'control-label')) }}
        	<div class="controls">
            	{{ Form::textarea('lead',@$category->lead,array('style'=>'width:98%;height:100px;'))}}
            	{{ $errors->first('category', '<span class="help-inline">:message</span>') }}
            </div>
        </div>
        <div class="control-group {{ $errors->first('description')?'error':'' }}">
        	{{ Form::label('description', 'Description',array('class'=>'control-label')) }}
        	<div class="controls">
            	{{ Form::textarea('description',@$category->description,array('style'=>'width:98%;height:400px;'))}}
            	{{ $errors->first('description', '<span class="help-inline">:message</span>') }}
            </div>
        </div>
        <div>
        	<span>Patterns</span>
        	@foreach ($patterns as $pattern)
	        	<ul>
					<li>{{ $pattern->name }}</li>
				</ul>
			@endforeach
        </div>
        <div class="form-actions">
        	<button class='btn btn-primary'><i class='icon-ok'></i> {{ $submitButtonTitle }}</button> <a href="{{ URL::to($cancelButtonLink) }}" class="btn"><i class="icon-remove"></i> Cancel</a>
        </div>
	{{ Form::close() }}
@endsection