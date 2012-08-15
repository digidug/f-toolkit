@layout('templates.main')
@section('content')
	<a class="btn btn-success pull-right" href="{{ URL::to_action('patterns@create') }}"><i class="icon-plus"></i> Add</a>
	<div class="page-header">
		<h1>Patterns</h1>
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
			          	<th colspan=4>Active</th>
			          </tr>
			          <tr>
			            <th>ID</th>
			            <th>Name</th>
			            <th>Category</th>
			            <th>Action</th>
			          </tr>
			        </thead>
			        <tbody>
			          <tr>
			          @foreach ($patterns as $pattern)
			            <td>{{ $pattern->id }}</td>
			            <td>{{ $pattern->name }}</td>
			            <td><span class="label label-info">{{ $pattern->category->name }}</span></td>
			            <td>
			            	<a class="btn btn-mini" href="{{ URL::to_action('patterns@pattern', array($pattern->id)); }}"><i class="icon-eye-open"></i> View</a>&nbsp;&nbsp;
			            	<a class="btn btn-primary btn-mini" href="{{ URL::to_action('patterns@edit', array($pattern->id)); }}"><i class="icon-edit icon-white"></i> Edit</a>
			            	<a class="btn btn-warning btn-mini" data-toggle="modal" href="#deactivateModal" onclick="prepareDeactivate('{{ $pattern->id }}','{{ $pattern->name }}')"><i class="icon-remove icon-white"></i> Deactivate</a>
						</td>
			          </tr>
			          @endforeach
			        </tbody>
			    </table>
			</div>
			<div class="tab-pane" id="inactive">
			    <table class="table table-striped table-bordered">
			        <thead>
			          <tr>
			          	<th colspan=4>Inactive</th>
			          </tr>
			          <tr>
			            <th>ID</th>
			            <th>Name</th>
			            <th>Category</th>
			            <th>Action</th>
			          </tr>
			        </thead>
			        <tbody>
			          <tr>
			          @foreach ($inactive_patterns as $pattern)
			            <td>{{ $pattern->id }}</td>
			            <td>{{ $pattern->name }}</td>
			            <td><span class="label label-info">{{ $pattern->category->name }}</span></td>
			            <td>
			            	<a class="btn btn-mini" href="{{ URL::to_action('patterns@pattern', array($pattern->id)); }}"><i class="icon-eye-open"></i> View</a>&nbsp;&nbsp;
			            	<a class="btn btn-primary btn-mini" href="{{ URL::to_action('patterns@edit', array($pattern->id)); }}"><i class="icon-edit icon-white"></i> Edit</a>
			            	<a class="btn btn-success btn-mini" href="{{ URL::to_action('patterns@activate', array($pattern->id)); }}"><i class="icon-ok icon-white"></i> Activate</a>
			            	<a class="btn btn-danger btn-mini" data-toggle="modal" href="#deleteModal" onclick="prepareDelete('{{ $pattern->id }}','{{ $pattern->name }}')"><i class="icon-trash icon-white"></i> Delete</a>
						</td>
			          </tr>
			          @endforeach
			        </tbody>
			    </table>
			</div>
		</div>
	</div>
    <div class="modal hide fade" id="deactivateModal">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal">×</button>
	    <h3>Deactivate pattern</h3>
	  </div>
	  <div class="modal-body">
	  	Are you sure you want to deactivate <strong id="deactivatename"></strong>?
	  </div>
	  <div class="modal-footer">
	    <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	    <a href="#" class="btn btn-primary" id='deactivatebutton'>Deactivate</a>
	  </div>
	</div>
    <div class="modal hide fade" id="deleteModal">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal">×</button>
	    <h3>Delete pattern</h3>
	  </div>
	  <div class="modal-body">
	  	Are you sure you want to delete <strong id="deletename"></strong>?
	  </div>
	  <div class="modal-footer">
	    <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	    <a href="#" class="btn btn-primary" id='deletebutton'>Delete</a>
	  </div>
	</div>
	<script>
		function prepareDeactivate(id,name){
			$('#deactivatename').html(name);
			$('#deactivatebutton').attr('href','{{ URL::to_action('patterns@deactivate') }}'+'/'+id);
		}
		function prepareDelete(id,name){
			$('#deletename').html(name);
			$('#deletebutton').attr('href','{{ URL::to_action('patterns@delete') }}'+'/'+id);
		}
	</script>
@endsection