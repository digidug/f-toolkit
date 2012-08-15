@layout('templates.main')
@section('content')
	<div class="page-header">
		<h1>{{ $pageTitle }}</h1>
	</div>
	<div class="six columns">
	{{ Form::open() }}
		<p>{{ Form::label('username', 'Username') }}</p>
        {{ $errors->first('username', '<p class="error">:message</p>') }}
        <p>{{ Form::text('username',$user->username)}}</p>
        <p>{{ Form::label('email', 'Email') }}</p>
        {{ $errors->first('email', '<p class="error">:message</p>') }}
        <p>{{ Form::text('email',$user->email) }}</p>
        <p>{{ Form::label('password', 'Password') }}</p>
        {{ $errors->first('password', '<p class="error">:message</p>') }}
        <p>{{ Form::password('password') }}</p>
        <p>{{ Form::label('password_confirmation', 'Confirm Password') }}</p>
        <p>{{ Form::password('password_confirmation') }}</p>
        <p>Roles</p>
        <ul class="unstyled">
        @foreach ($roles as $id=>$name)
        	@if (Auth::user()->hasRole('Administrator'))
        		<li>{{ Form::checkbox('roles['.$id.']',$id,isset($user->roles[$id])) }} {{ $name }}</li>
        	@else
        		<li>{{ $name }}</li>
        	@endif
        @endforeach
        </ul>
        <div class="form-actions">
			<button class='btn btn-primary'><i class='icon-ok'></i> {{ $submitButtonTitle }}</button> <a href="{{ URL::to($cancelButtonLink) }}" class="btn"><i class="icon-remove"></i> Cancel</a>
		</div>
    {{ Form::close() }}
	</div>
@endsection
