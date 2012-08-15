@layout('templates.main')
@section('content')
	<div class="page-header">
		<h1>Users <small>Manage roles and permissions</small></h1>
	</div>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>
					Name
				</th>
				<th>
					Email
				</th>
				<th>
					Roles
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
			<tr>
				<td>
					{{ $user->username }}
				</td>
				<td>
					{{ $user->email }}
				</td>
				<td>
					@foreach ($user->roles as $role)
						<span class="label">{{ $role->name }}</span>
					@endforeach
				</td>
				<td>
					<a href="{{ URL::to_action('users@user',array($user->id)) }}" class="btn btn-mini"><i class="icon-eye-open"></i> View</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
@endsection