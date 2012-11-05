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
				<li><span class="count">{{count($current_styleguide->version()->categories_edited())}}</span> Purged {{Str::plural('Category', count($current_styleguide->version()->categories_edited()))}}</li>
				<li><span class="count">{{count($current_styleguide->version()->categories_purged())}}</span> Revised {{Str::plural('Category', count($current_styleguide->version()->categories_purged()))}}</li>
				<li><span class="count">{{count($current_styleguide->version()->patterns_added())}}</span> New {{Str::plural('Pattern', count($current_styleguide->version()->patterns_added()))}}</li>
				<li><span class="count">{{count($current_styleguide->version()->patterns_edited())}}</span> Purged {{Str::plural('Pattern', count($current_styleguide->version()->patterns_edited()))}}</li>
				<li><span class="count">{{count($current_styleguide->version()->patterns_purged())}}</span> Revised {{Str::plural('Pattern', count($current_styleguide->version()->patterns_purged()))}}</li>
			</ul>
		</div>
		<div class="alert alert-error">
			It is recommended that this version be published as a <strong>Major Update</strong>.
		</div>
		<div class="control-group">
        	{{ Form::label('update-type', 'Choose Update:',array('class'=>'control-label')) }}
        	<div class="controls">
            	<ul>
            		<li>{{ Form::radio('roles[]','Design',false) }} Design Update</li>
            		<li>{{ Form::radio('roles[]','Major',true) }} Major Update</li>
            		<li>{{ Form::radio('roles[]','Minor',false) }} Minor Update</li>
            	</ul>
            </div>
        </div>
        <div class="well summary">
			<h4 style="padding:0px 0px 0px 19px;">New Version</h4>
			<ul>
				<li><span class="count">{{$current_styleguide->version()->nextVersion('major')}}</span></li>
			</ul>
		</div>
        <div class="form-actions">
			<button class='btn btn-primary'><i class='icon-ok'></i> {{ $submitButtonTitle }}</button> <a href="{{ URL::to($cancelButtonLink) }}" class="btn"><i class="icon-remove"></i> Cancel</a>
		</div>
    {{ Form::close() }}
	</div>
</div>
@endsection
