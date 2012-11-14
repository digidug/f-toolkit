@layout('templates.main')
@section('content')
	<h1>{{ $pageTitle }}</h1>
	{{ Form::open(URL::current(), 'POST', array('id'=>'patternForm','class' => 'form-vertical')) }}
		<div class="control-group {{ $errors->first('name')?'error':'' }}">
        	{{ Form::label('name', 'Name',array('class'=>'control-label')) }}
        	<div class="controls">
            	{{ Form::text('name',@$pattern->name)}}
            	{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
            </div>
        </div>
        <div class="control-group {{ $errors->first('url')?'error':'' }}">
        	{{ Form::label('url', 'URL',array('class'=>'control-label')) }}
        	<div class="controls">
            	{{ Form::text('url',isset($pattern->meta()->first()->url)?$pattern->meta()->first()->url:$pattern->url)}}
            	{{ $errors->first('url', '<span class="help-inline">:message</span>') }}
            </div>
        </div>
        <div class="control-group {{ $errors->first('published')?'error':'' }}">
        	{{ Form::label('published', 'Published',array('class'=>'control-label')) }}
        	<div class="controls">
            	{{ Form::select('published', array('0'=>'Unpublished','1'=>'Published'), isset($pattern->published)?$pattern->published:0); }}
            	{{ $errors->first('published', '<span class="help-inline">:message</span>') }}
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
		  </div>
		  <div class="tab-content">
		  	<div class="tab-pane active" id="description">
		  		<button type="button" id="toggleEditor" style="display:none;">Toggle Editor</button> 
		    	{{ Form::textarea('description',isset($pattern->meta()->first()->description)?$pattern->meta()->first()->description:$pattern->description,array('class'=>'tinymce','id'=>'editor-description','class'=>'description','style'=>'width:98%;height:400px;')) }}
		  	</div>
		  	<div class="tab-pane" id="html">
			    {{ Form::textarea('html',isset($pattern->meta()->first()->html)?$pattern->meta()->first()->html:$pattern->html,array('style'=>'width:98%;height:400px;')) }}
		    </div>
		    <div class="tab-pane" id="css">
			    {{ Form::textarea('css',isset($pattern->meta()->first()->css)?$pattern->meta()->first()->css:$pattern->css,array('style'=>'width:98%;height:400px;')) }}
		    </div>
		  </div>
		</div>
		{{ Form::hidden('category', $category_id) }}
		@if (count($pattern->history)>0)
        <div>
        	<h3>Revisions</h3>
        	<ul>
        	@foreach ($pattern->revisions AS $item)
        		<li>{{ $item->updated_at }} by {{ $item->user->username }}</li>
        	@endforeach
        	</ul>
        </div>
        @endif
        <div class="form-actions">
        	<button class='btn btn-primary'><i class='icon-ok'></i> {{ $submitButtonTitle }}</button> <a href="{{ URL::to($cancelButtonLink) }}" class="btn"><i class="icon-remove"></i> Cancel</a>
        </div>
    {{ Form::close() }}
    
	<div class="modal hide fade" id="imagesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-remote="{{URL::to_action('images@browse',array($category_id))}}">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <h3 id="myModalLabel">Insert Image</h3>
	  </div>
	  <div class="modal-body"></div>
	  <div class="modal-footer">@include('forms.uploadimage')</div>
	</div>
@endsection

@section('jsready')
	@parent
	$('body').addClass('yui-skin-sam');
    (function() {
	    var Dom = YAHOO.util.Dom,
	        Event = YAHOO.util.Event;
	    
	    var myConfig = {
	    	collapse: false,
	    	titlebar: 'Editor',
	        height: '500px',
	        width: '92%',
	        animate: true,
	        dompath: true,
	        focusAtStart: true,
	        toolbar: {
	        	buttons: [
	        		{ group: 'textstyle', label: 'Font Style',
	        			buttons: [
	        				{ type: 'push', label: 'Bold', value: 'bold' },
	        				{ type: 'push', label: 'Italic', value: 'italic' },
	        				{ type: 'push', label: 'Underline', value: 'underline' },
	        				{ type: 'separator' },
				            { type: 'push', label: 'Subscript', value: 'subscript', disabled: true },
				            { type: 'push', label: 'Superscript', value: 'superscript', disabled: true },
				            { type: 'separator' },
				            { type: 'color', label: 'Font Color', value: 'forecolor', disabled: true },
				            { type: 'color', label: 'Background Color', value: 'backcolor', disabled: true },
				            { type: 'separator' },
				            { type: 'push', label: 'Remove Formatting', value: 'removeformat', disabled: true },
				            { type: 'push', label: 'Show/Hide Hidden Elements', value: 'hiddenelements' },
	        				{ type: 'separator' },
	        				{ type: 'spin', label: '13', value: 'fontsize', range: [ 9, 75 ], disabled: true },
	        				{ type: 'separator' },
	        				{ type: 'color', label: 'Font Color', value: 'forecolor', disabled: true },
	        				{ type: 'color', label: 'Background Color', value: 'backcolor', disabled: true },
	        				{ type: 'separator' },
	        			]
	        		},
	        		{ type: 'separator' },
				    { group: 'alignment', label: 'Alignment',
				        buttons: [
				            { type: 'push', label: 'Align Left CTRL + SHIFT + [', value: 'justifyleft' },
				            { type: 'push', label: 'Align Center CTRL + SHIFT + |', value: 'justifycenter' },
				            { type: 'push', label: 'Align Right CTRL + SHIFT + ]', value: 'justifyright' },
				            { type: 'push', label: 'Justify', value: 'justifyfull' }
				        ]
				    },
				    { type: 'separator' },
				    { group: 'parastyle', label: 'Paragraph Style',
				        buttons: [
				        { type: 'select', label: 'Normal', value: 'heading', disabled: true,
				            menu: [
				                { text: 'Normal', value: 'none', checked: true },
				                { text: 'Header 1', value: 'h1' },
				                { text: 'Header 2', value: 'h2' },
				                { text: 'Header 3', value: 'h3' },
				                { text: 'Header 4', value: 'h4' },
				                { text: 'Header 5', value: 'h5' },
				                { text: 'Header 6', value: 'h6' }
				            ]
				        }
				        ]
				    },
				    { type: 'separator' },
				    { group: 'indentlist', label: 'Indenting and Lists',
				        buttons: [
				            { type: 'push', label: 'Indent', value: 'indent', disabled: true },
				            { type: 'push', label: 'Outdent', value: 'outdent', disabled: true },
				            { type: 'push', label: 'Create an Unordered List', value: 'insertunorderedlist' },
				            { type: 'push', label: 'Create an Ordered List', value: 'insertorderedlist' }
				        ]
				    },
				    { type: 'separator' },
				    { group: 'insertitem', label: 'Insert Item',
				        buttons: [
				            { type: 'push', label: 'HTML Link CTRL + SHIFT + L', value: 'createlink', disabled: true },
				            { type: 'push', label: 'Insert Image', value: 'insertimage' }
				        ]
				    }
	        	]
	        }
	    };
	
	    var state = 'off';
	    YAHOO.log('Set state to off..', 'info', 'example');
	    
	    YAHOO.log('Create the Editor..', 'info', 'example');
	    var myEditor = new YAHOO.widget.Editor('editor-description', myConfig);
	    myEditor.on('toolbarLoaded', function() {
	    	//safari bug fix
	    	this.filter_safari=function(html) {return html;}
	    
	        var sourceConfig = {
            	group: 'source',
            	label: 'Edit Source',
            	buttons: [
            	    { type: 'push', label: 'Edit HTML Code', value: 'editcode' }
            	]
            };
	        this.toolbar.addSeparator();
	        this.toolbar.addButtonGroup(sourceConfig);
	        
	        this.toolbar.on('editcodeClick', function() {
	            var ta = this.get('element'),
	                iframe = this.get('iframe').get('element');
	
	            if (state == 'on') {
	                state = 'off';
	                this.toolbar.set('disabled', false);
	                YAHOO.log('Show the Editor', 'info', 'example');
	                YAHOO.log('Inject the HTML from the textarea into the editor', 'info', 'example');
	                this.setEditorHTML(ta.value);
	                if (!this.browser.ie) {
	                    this._setDesignMode('on');
	                }
	
	                Dom.removeClass(iframe, 'editor-hidden');
	                Dom.addClass(ta, 'editor-hidden');
	                this.show();
	                this._focusWindow();
	            } else {
	                state = 'on';
	                YAHOO.log('Show the Code Editor', 'info', 'example');
	                this.cleanHTML();
	                YAHOO.log('Save the Editors HTML', 'info', 'example');
	                Dom.addClass(iframe, 'editor-hidden');
	                Dom.removeClass(ta, 'editor-hidden');
	                this.toolbar.set('disabled', true);
	                this.toolbar.getButtonByValue('editcode').set('disabled', false);
	                this.toolbar.selectButton('editcode');
	                this.dompath.innerHTML = 'Editing HTML Code';
	                this.hide();
	            }
	            return false;
	        }, this, true);
	
	        this.on('cleanHTML', function(ev) { 
	            YAHOO.log('cleanHTML callback fired..', 'info', 'example'); 
	            this.get('element').value = ev.html; 
	            console.log(this.invalidHTML);
	            //webkit bug
	            //if (state=="on" && code!="") this.get('element').value=code;
	        }, this, true)
	        
	        this.on('afterRender', function() {
	            var wrapper = this.get('editor_wrapper');
	            wrapper.appendChild(this.get('element'));
	            this.setStyle('width', '98%');
	            this.setStyle('height', '100%');
	            this.setStyle('visibility', '');
	            this.setStyle('top', '');
	            this.setStyle('left', '');
	            this.setStyle('position', '');
	
	            this.addClass('editor-hidden');
	        }, this, true);
	        
	        //When the toolbar is loaded, add a listener to the insertimage button
	        this.toolbar.on('insertimageClick', function() {
	            //Get the selected element
	            var _sel = this._getSelectedElement();
	            //If the selected element is an image, do the normal thing so they can manipulate the image
	            var _sel=this._lastImage;
	            if (_sel && _sel.tagName && (_sel.tagName.toLowerCase() == 'img')) {
	                //Do the normal thing here..
	            } else {
	            	$('#imagesModal').modal('show');
	                //This is important.. Return false here to not fire the rest of the listeners
	                return false;
	            }
	        }, this, true);
	        
	    }, myEditor, true);
	    
	    myEditor.on('editorContentLoaded', function() {
			var head = this._getDoc().getElementsByTagName('head')[0];
			var style = this._getDoc().createElement('style');
			var link = this._getDoc().createElement('link');
			var link2 = this._getDoc().createElement('link');
			
			css="{{$css}}";
			if (style.styleSheet) style.styleSheet.cssText = css;
			else style.appendChild(document.createTextNode(css));
			head.appendChild(style);
			
			link2.setAttribute('rel', 'stylesheet'); 
	        link2.setAttribute('type', 'text/css'); 
	        link2.setAttribute('href', '/css/styles.css'); 
	        head.appendChild(link2);
			
		}, myEditor, true);
	    
	    myEditor.on('editorWindowBlur', function() {
			this.cleanHTML();
		}, myEditor, true);
	    
	    myEditor.on('afterOpenWindow', function() {
	        //When the window opens, disable the url of the image so they can't change it
	        var url = Dom.get(myEditor.get('id') + '_insertimage_url');
	        if (url) {
	            url.disabled = true;
	        }
	    }, myEditor, true);
    
	    myEditor.render();
	
	})();

@endsection

@section('css')
	@parent
	.yui-skin-sam .yui-toolbar-container .yui-toolbar-editcode span.yui-toolbar-icon {
	    background-image: url( http://developer.yahoo.com/yui/examples/editor/assets/html_editor.gif );
	    background-position: 0 1px;
	    left: 5px;
	}
	.yui-skin-sam .yui-toolbar-container .yui-button-editcode-selected span.yui-toolbar-icon {
	    background-image: url( http://developer.yahoo.com/yui/examples/editor/assets/html_editor.gif );
	    background-position: 0 1px;
	    left: 5px;
	}
	.editor-hidden {
	    visibility: hidden;
	    top: -9999px;
	    left: -9999px;
	    position: absolute;
	}
	.yui-editor-container {
	    border: 0;
	    margin: 0;
	    padding: 0;
	    font-family: verdana,arial;
	}
	.yui-toolbar-container h3{
		font-weight: normal;
		width: auto;
	}
@endsection

@section('cssfiles')
	@parent
    {{ HTML::style('http://yui.yahooapis.com/2.9.0/build/menu/assets/skins/sam/menu.css') }}
    {{ HTML::style('http://yui.yahooapis.com/2.9.0/build/button/assets/skins/sam/button.css') }}
    {{ HTML::style('http://yui.yahooapis.com/2.9.0/build/container/assets/skins/sam/container.css') }}
    {{ HTML::style('http://yui.yahooapis.com/2.9.0/build/editor/assets/skins/sam/editor.css') }}
@endsection
@section('jsfiles')
	@parent
	{{ HTML::script('http://yui.yahooapis.com/2.9.0/build/yuiloader/yuiloader-min.js') }}
	{{ HTML::script('http://yui.yahooapis.com/2.9.0/build/event/event-min.js') }}
	{{ HTML::script('http://yui.yahooapis.com/2.9.0/build/dom/dom-min.js') }}
	{{ HTML::script('http://yui.yahooapis.com/2.9.0/build/animation/animation-min.js') }}
	{{ HTML::script('http://yui.yahooapis.com/2.9.0/build/element/element-min.js') }}
	{{ HTML::script('http://yui.yahooapis.com/2.9.0/build/container/container-min.js') }}
	{{ HTML::script('http://yui.yahooapis.com/2.9.0/build/menu/menu-min.js') }}
	{{ HTML::script('http://yui.yahooapis.com/2.9.0/build/button/button-min.js') }}
	{{ HTML::script('http://yui.yahooapis.com/2.9.0/build/editor/editor-min.js') }}
	{{ HTML::script('http://yui.yahooapis.com/2.9.0/build/resize/resize-min.js') }}
@endsection