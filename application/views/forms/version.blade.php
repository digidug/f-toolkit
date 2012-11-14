@layout('templates.main')
@section('content')
<div class="twelve columns">
	<h1>{{ $pageTitle }}</h1>
	<div>
	{{ Form::open() }}
		<div class="well summary">
			<h4 style="padding:0px 0px 0px 19px;">Current Version</h4>
			<ul>
				<li><span class="count">{{$current_styleguide->version()->version}}</span> Published {{date("F jS Y",strtotime($current_styleguide->version()->created_at))}}</a></li>
			</ul>
		</div>
		<div class="well summary">
			<h4 style="padding:19px 0px 0px 19px;">Approved Changes</h4>
			<ul>
				<li><span class="count">{{count($current_styleguide->version()->categories_added())}}</span> New {{Str::plural('Category', count($current_styleguide->version()->categories_added()))}}</li>
				<li><span class="count">{{count($current_styleguide->version()->categories_edited())}}</span> Revised {{Str::plural('Category', count($current_styleguide->version()->categories_edited()))}}</li>
				<li><span class="count">{{count($current_styleguide->version()->categories_purged())}}</span> Purged {{Str::plural('Category', count($current_styleguide->version()->categories_purged()))}}</li>
				<li><span class="count">{{count($current_styleguide->version()->patterns_added())}}</span> New {{Str::plural('Pattern', count($current_styleguide->version()->patterns_added()))}}</li>
				<li><span class="count">{{count($current_styleguide->version()->patterns_edited())}}</span> Revised {{Str::plural('Pattern', count($current_styleguide->version()->patterns_purged()))}}</li>
				<li><span class="count">{{count($current_styleguide->version()->patterns_purged())}}</span> Purged {{Str::plural('Pattern', count($current_styleguide->version()->patterns_edited()))}}</li>
			</ul>
		</div>
		<div class="alert alert-error">
			It is recommended that this version be published as a <strong>Major Update</strong>.
		</div>
		<div class="control-group">
        	{{ Form::label('update-type', 'Choose Update:',array('class'=>'control-label')) }}
        	<div class="controls">
            	<ul>
            		<li>{{ Form::radio('version',$current_styleguide->version()->nextVersion('design'),false) }} Design Update</li>
            		<li>{{ Form::radio('version',$current_styleguide->version()->nextVersion('major'),true) }} Major Update</li>
            		<li>{{ Form::radio('version',$current_styleguide->version()->nextVersion('minor'),false) }} Minor Update</li>
            	</ul>
            </div>
        </div>
        <div class="well summary">
			<h4 style="padding:0px 0px 0px 19px;">New Version</h4>
			<ul>
				<li><span class="count next-version"></span></li>
			</ul>
		</div>
        <div class="form-actions">
			<button class='btn btn-primary'><i class='icon-ok'></i> {{ $submitButtonTitle }}</button> <a href="{{ URL::to($cancelButtonLink) }}" class="btn"><i class="icon-remove"></i> Cancel</a>
		</div>
    {{ Form::close() }}
	</div>
</div>
@endsection

@section('js')
	@parent
	
	$('.next-version').html($('input:radio[name="version"]:checked').val());
	$('input:radio[name="version"]').change(function(){
		$('.next-version').html($(this).val());
	});
@endsection