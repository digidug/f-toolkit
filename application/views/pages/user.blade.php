@layout('templates.main')
@section('content')
	<div class="page-header">
		<h1>View User</h1>
	</div>
    <table class="table table-bordered table-striped">
		<tbody>
        <tr><td>Username</td><td><strong>{{ $user->username }}</strong></td></tr>
        <tr><td>Email</td><td><strong>{{ $user->email }}</strong></td></tr>
        <tr><td>Roles</td><td>
        	@foreach ($roles as $role)
	        	<span class="label">{{ $role->name }}</span>
	        @endforeach
	    </td></tr>
    </table>
    <div class="form-actions">
    	<a href="{{ URL::to_action('users@index') }}" class="btn"><i class="icon-white icon-arrow-left"></i> Back</a> 
		<a href="{{ URL::to_action('users@edit',array($user->id)) }}" class="btn btn-primary"><i class="icon-white icon-edit"></i> Edit</a>
	</div>
@endsection