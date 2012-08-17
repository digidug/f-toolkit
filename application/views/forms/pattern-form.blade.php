@layout('templates.main')
@section('content')
	<h1>{{ $pageTitle }}</h1>
	{{ Form::open('#', 'POST', array('id'=>'patternForm','class' => 'form-vertical')) }}
		<div class="control-group {{ $errors->first('name')?'error':'' }}">
        	{{ Form::label('name', 'Name',array('class'=>'control-label')) }}
        	<div class="controls">
            	{{ Form::text('name',@$pattern->name)}}
            	{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
            </div>
        </div>
        <div class="control-group {{ $errors->first('description')?'error':'' }}">
        	{{ Form::label('category', 'Category',array('class'=>'control-label')) }}
        	<div class="controls">
            	{{ Form::select('category', $categories, isset($pattern->category->id)?$pattern->category->id:$pattern->category); }}
            	{{ $errors->first('category', '<span class="help-inline">:message</span>') }}
            </div>
        </div>
        <div class="tabbable">
		  <ul class="nav nav-pills">
		  	<li class="active"><a href="#description" data-toggle="tab">Description</a></li>
		    <li><a href="#html" data-toggle="tab">HTML</a></li>
		    <li><a href="#css" data-toggle="tab">CSS</a></li>
		  </ul>
		  <div class="control-group {{ $errors->first('description')?'error':'' }}{{ $errors->first('html')?'error':'' }}{{ $errors->first('css')?'error':'' }}">
		  	{{ $errors->first('description', '<span class="help-inline">:message</span>') }}
		  	{{ $errors->first('html', '<span class="help-inline">:message</span>') }}
		  	{{ $errors->first('css', '<span class="help-inline">:message</span>') }}
		  <div class="tab-content">
		  	<div class="tab-pane active" id="description">
		    	{{ Form::textarea('description',isset($pattern->description->content)?$pattern->description->content:$pattern->description,array('class'=>'tinymce','style'=>'width:98%;height:400px;')) }}
		  	</div>
		  	<div class="tab-pane" id="html">
			    {{ Form::textarea('html',isset($pattern->html->content)?$pattern->html->content:$pattern->html,array('style'=>'width:98%;height:400px;')) }}
		    </div>
		    <div class="tab-pane" id="css">
			    {{ Form::textarea('css',isset($pattern->css->content)?$pattern->css->content:$pattern->css,array('style'=>'width:98%;height:400px;')) }}
		    </div>
		  </div>
		</div>
     
        <div class="form-actions">
        	<button class='btn btn-primary'><i class='icon-ok'></i> {{ $submitButtonTitle }}</button> <a href="{{ URL::to($cancelButtonLink) }}" class="btn"><i class="icon-remove"></i> Cancel</a>
        </div>
    {{ Form::close() }}
@endsection

@section('jsready')
    @parent
    $('textarea').tabOverride(true);
    tinyMCE.init({
        // General options
        mode : "specific_textareas",
        editor_selector : "tinymce",
	
        // Example content CSS (should be your site CSS)
        content_css : "/css/styles.css",
        elements : "",
        plugins : "advimage,imagemanager",
        theme : "advanced",
	    theme_advanced_buttons1 : "mylistbox,mysplitbutton,bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,undo,redo,link,unlink,image,code",
	    theme_advanced_buttons2 : "",
	    theme_advanced_buttons3 : "",
	    theme_advanced_toolbar_location : "top",
	    theme_advanced_toolbar_align : "left",
	    theme_advanced_statusbar_location : "bottom"
	});
@endsection
@section('jsfiles')
	@parent
	{{ HTML::script('tiny_mce/tiny_mce.js') }}
@endsection