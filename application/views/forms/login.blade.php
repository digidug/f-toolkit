@layout('templates.blank')
@section('content')
	<div class="container" style="background-image: -webkit-gradient(radial, 50% 50%,0,50% 50%,200, from(#21435E), to(#133247));height:600px;position:relative;">
	    <div class="content">
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
			<div>
        </div>
        <h2 style="position:absolute;right:50px;bottom:150px;color:#fff;">Ford Global Look + Style Guidelines</h2>
        <img src="/img/Ford_Motor_Company_logo.png" style="width:200px;position:absolute;right:50px;bottom:-40px;">
    </div>
@endsection