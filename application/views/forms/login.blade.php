@layout('templates.blank')
@section('content')

<div id='login-page' class='container'>
	<h1>Login</h1>
	{{ Form::open('#', 'POST', array('class' => 'well')) }}
    	@if (Session::has('login_errors'))
        	<span class="error">Username or password incorrect.</span>
        @endif
		{{ Form::text('username',Input::old('username')) }}
		{{ Form::password('password') }}
		<label class="checkbox"> <input type="checkbox" /> Remember me </label>
		<button type="submit" class="btn btn-primary">Sign in</button>
		<button type="submit" class="btn">Forgot Password</button>
	{{ Form::close() }}
		</form>
<div>
		
@endsection