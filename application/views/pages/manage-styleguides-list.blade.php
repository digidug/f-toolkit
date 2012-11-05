@layout('templates.main')
@section('content')
	<!--<a class="btn btn-success pull-right" href="{{ URL::to_action('patterns@create') }}"><i class="icon-plus"></i> Add</a>-->
	<div class="page-header">
		<h1>Styleguides</h1>
	</div>
	<div class="tabbable">
		<ul class="nav nav-pills">
			<li class="active"><a href="#active" data-toggle="tab">Active</a></li>
			<li><a href="#inactive" data-toggle="tab">Inactive</a></li>
		</ul>
		<div class="tab-content">
			<div  class="tab-pane active" id="active">
				<table class="table table-striped table-bordered">
			        <thead>
			          <tr>
			            <th>ID</th>
			            <th>Version</th>
			            <th>Name</th>
			          </tr>
			        </thead>
			        <tbody>
			          @foreach ($styleguides as $styleguide)
			          <tr>
			            <td>{{ $styleguide->id }}</td>
			            <td>{{ $styleguide->version()->version }}</td>
			            <td><a href="{{ URL::to_action('styleguides/manage/version/commit', array($styleguide->name)); }}">{{ $styleguide->name }}</a></td>
			          </tr>
			          @endforeach
			        </tbody>
			    </table>
			</div>
			<div class="tab-pane" id="inactive">
			    <table class="table table-striped table-bordered">
			        <thead>
			          <tr>
			            <th>ID</th>
			            <th>GUID</th>
			            <th>Name</th>
			          </tr>
			        </thead>
			        <tbody>
			          @foreach ($inactive_styleguides as $styleguide)
			          <tr>
			            <td>{{ $styleguide->id }}</td>
			            <td>{{ $styleguide->guid }}</td>
			            <td>{{ $styleguide->name }}</td>
			          </tr>
			          @endforeach
			        </tbody>
			    </table>
			</div>
		</div>
	</div>
@endsection