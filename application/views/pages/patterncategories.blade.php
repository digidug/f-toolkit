@layout('templates.main')
@section('content')
	<a class="btn btn-success pull-right" data-toggle="modal" href="#createcategoryModal""><i class="icon-plus"></i> Add</a>
	<div class="page-header">
		<h1>Pattern Categories</h1>
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
			            <th>Action</th>
			          </tr>
			        </thead>
			        <tbody>
			          <tr>
			          @foreach ($categories as $category)
			            <td>{{ $category->id }}</td>
			            <td>{{ $category->name }}</td>
			            <td>
			            	<a class="btn btn-mini" href="{{ URL::to_action('patterns@pattern', array($category->id)); }}"><i class="icon-eye-open"></i> View</a>&nbsp;&nbsp;
			            	<a class="btn btn-primary btn-mini" href="{{ URL::to_action('patterns@edit', array($category->id)); }}"><i class="icon-edit icon-white"></i> Edit</a>
			            	<a class="btn btn-warning btn-mini" data-toggle="modal" href="#deactivateModal" onclick="prepareDeactivate('{{ $category->id }}','{{ $category->name }}')"><i class="icon-remove icon-white"></i> Deactivate</a>
						</td>
			          </tr>
			          @endforeach
			        </tbody>
			    </table>
			</div>
			<div class="tab-pane" id="inactive">
			   
			</div>
		</div>
	</div>
	<div class="modal hide fade" id="createcategoryModal">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal">×</button>
	    <h3>Create Category</h3>
	  </div>
	  <div class="modal-body">
	  	<div class="control-group" id="createnewcategoryform">
        	Name
        	<div class="controls">
            	<input type="text" name="newCategoryName" id="newCategoryName">
            	<span class="help-inline" id="createCategoryError"></span>
            </div>
        </div>
	  </div>
	  <div class="modal-footer">
	    <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	    <a href="#" class="btn btn-primary" onclick="createCategory('{{ $category->id }}','{{ $category->name }}')">Create</a>
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
		function createCategory(){
			newname=$("#newCategoryName").val();
			$.post('{{ URL::to_action('patterns.createcategory') }}',{name:newname},function(response){
				console.log(response);
				if (response!="success"){
					$('#createnewcategoryform').addClass('error');
					$('#createCategoryError').html('Category name already exists');
				}else{
					$('#createnewcategoryform').removeClass('error');
					$('#createCategoryError').html('');
				}
			});

		}
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