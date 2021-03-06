@layout('templates.main')
@section('content')
	<a class="btn btn-success pull-right" href="{{ URL::to_action('styleguides@create',array('styleguide','')) }}"><i class="icon-plus"></i> New Style Guide</a>
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
			            <th>GUID</th>
			            <th>Name</th>
			          </tr>
			        </thead>
			        <tbody>
			          @foreach ($styleguides as $styleguide)
			          <tr>
			            <td>{{ $styleguide->id }}</td>
			            <td>{{ $styleguide->guid }}</td>
			            <td><a href="{{ URL::to_action('styleguides/one', array($styleguide->name)); }}">{{ $styleguide->name }}</a></td>
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