@layout('templates.main')
@section('content')
	<a class="btn btn-success pull-right" href="{{ URL::to_action('styleguides@create',array('styleguide','new')) }}"><i class="icon-plus"></i> New Style Guide</a>
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
			            <th>GUID</th>
			            <th>Name</th>
			            <th>Version</th>
			            <th>Modified</th>
			            <th></th>
			          </tr>
			        </thead>
			        <tbody>
			          @foreach ($styleguides as $this_styleguide)
			          <tr>
			            <td>{{ $this_styleguide->guid }}</td>
			            <td>{{ $this_styleguide->name }}</td>
			            <td>{{ $this_styleguide->version()->version }}</td>
			            <td>{{ date("F jS Y",strtotime($this_styleguide->version()->created_at)) }}</td>
			            <td><a class="btn btn-primary btn-small pull-right" style="margin-left:10px;" href="{{ URL::to_action('styleguides@one',array($this_styleguide->name.'?edit_mode=true')); }}"> Edit</a><a class="btn btn-inverse btn-small pull-right" href="{{ URL::to_action('styleguides/manage/version/commit', array($this_styleguide->name)); }}"> Commit</a></td>
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
			          @foreach ($inactive_styleguides as $this_styleguide)
			          <tr>
			            <td>{{ $this_styleguide->id }}</td>
			            <td>{{ $this_styleguide->guid }}</td>
			            <td>{{ $this_styleguide->name }}</td>
			          </tr>
			          @endforeach
			        </tbody>
			    </table>
			</div>
		</div>
	</div>
@endsection