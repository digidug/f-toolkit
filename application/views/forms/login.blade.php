@layout('templates.blank')
@section('content')

<div id='login-page' class='container' style='margin-top:20px;'>
	{{ Form::open('#', 'POST', array('class' => 'well')) }}
		<h1>Login</h1>
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