@layout('templates.main')
@section('content')
	<div class="page-header">
		<h1>{{ $pageTitle }}</h1>
	</div>
	{{ Form::open(URL::current(), 'POST', array('id'=>'patternForm','class' => 'form-vertical')) }}
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
            	{{ Form::textarea('description',@$category->description,array('class'=>'tinymce','style'=>'width:98%;height:400px;'))}}
            	{{ $errors->first('description', '<span class="help-inline">:message</span>') }}
            </div>
        </div>
        <div class="control-group {{ $errors->first('css')?'error':'' }}">
        	{{ Form::label('css', 'CSS',array('class'=>'control-label')) }}
        	<div class="controls">
            	{{ Form::textarea('css',@$category->css,array('style'=>'width:98%;height:400px;'))}}
            	{{ $errors->first('css', '<span class="help-inline">:message</span>') }}
            </div>
        </div>
        <div>
        	<h3>Patterns</h3>
        	<div class="row">
				<div class="span4">
					<h4>{{ $category->name }} Patterns</h4>
		        	<ul id="active-patterns" class="sortable unstyled" style="min-height:200px;">
		        	@foreach ($patterns as $pattern)
						<li class="well {{ $pattern->published==1?'':'unpublished' }}" id="pattern_{{ $pattern->id }}">{{ $pattern->name }}</li>
					@endforeach
		        	</ul>
				</div>
				<div class="span4">
					<h4>Inactive Patterns</h4>
		        	<ul id="inactive-patterns" class="sortable unstyled" style="min-height:200px;">
		        	@foreach ($inactive_patterns as $pattern)
						<li class="well {{ $pattern->published==1?'':'unpublished' }}" id="pattern_{{ $pattern->id }}">{{ $pattern->name }}</li>
					@endforeach
		        	</ul>
				</div>
				{{ Form::hidden('activePatterns',@$category->activePatterns()) }}
				{{ Form::hidden('inactivePatterns',@$category->inactivePatterns()) }}
        	</div>
        </div>
        <div class="form-actions">
        	<button class='btn btn-primary'><i class='icon-ok'></i> {{ $submitButtonTitle }}</button> <a href="{{ URL::to($cancelButtonLink) }}" class="btn"><i class="icon-remove"></i> Cancel</a>
        </div>
	{{ Form::close() }}
@endsection
@section('jsfiles')
	@parent
	{{ HTML::script('tiny_mce/tiny_mce.js') }}
@endsection
@section('jsready')
	@parent
	tinyMCE.init({
        // General options
        mode : "specific_textareas",
        editor_selector : "tinymce",
	
        // Example content CSS (should be your site CSS)
        content_css : "/css/styles.css",
        elements : "",
        inline_styles : true,
        plugins : "advimage,imagemanager",
        theme : "advanced",
	    theme_advanced_buttons1 : "mylistbox,mysplitbutton,bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,undo,redo,link,unlink,image,code",
	    theme_advanced_buttons2 : "",
	    theme_advanced_buttons3 : "",
	    theme_advanced_toolbar_location : "top",
	    theme_advanced_toolbar_align : "left",
	    theme_advanced_statusbar_location : "bottom"
	});
	
	$("#active-patterns, #inactive-patterns").sortable({
    	connectWith: $('.sortable'),
    	update: function(event, ui) {
    		$("input[name='activePatterns']").val($('#active-patterns').sortable('serialize'));
    		$("input[name='inactivePatterns']").val($('#inactive-patterns').sortable('serialize'));
    	}
    });
	$(".sortable").disableSelection();
@endsection