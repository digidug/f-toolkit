@layout('templates.main')
@section('content')
	<a class="btn btn-success pull-right" data-toggle="modal" href="#inspirationAddModal"><i class="icon-plus"></i> Add</a>
	<h1>Inspiration</h1>
	<ul class="thumbnails">
		<li class="span3">
			<div class="thumbnail">
				<img src="img/tmp/260x180.gif" alt="" />
				<div class="caption">
					<h5>Thumbnail label</h5>
					<p>Thumbnail caption right here...</p>
				</div>
			</div>
		</li>
		<li class="span3">
			<div class="thumbnail">
				<img src="img/tmp/260x180.gif" alt="" />
				<div class="caption">
					<h5>Thumbnail label</h5>
					<p>Thumbnail caption right here...</p>
				</div>
			</div>
		</li>
		<li class="span3">
			<div class="thumbnail">
				<img src="img/tmp/260x180.gif" alt="" />
				<div class="caption">
					<h5>Thumbnail label</h5>
					<p>Thumbnail caption right here...</p>
				</div>
			</div>
		</li>
		<li class="span3">
			<div class="thumbnail">
				<img src="img/tmp/260x180.gif" alt="" />
				<div class="caption">
					<h5>Thumbnail label</h5>
					<p>Thumbnail caption right here...</p>
				</div>
			</div>
		</li>
		<li class="span3">
			<div class="thumbnail">
				<img src="img/tmp/260x180.gif" alt="" />
				<div class="caption">
					<h5>Thumbnail label</h5>
					<p>Thumbnail caption right here...</p>
				</div>
			</div>
		</li>
		<li class="span3">
			<div class="thumbnail">
				<img src="img/tmp/260x180.gif" alt="" />
				<div class="caption">
					<h5>Thumbnail label</h5>
					<p>Thumbnail caption right here...</p>
				</div>
			</div>
		</li>
	</ul>
	<div class="modal hide fade" id="inspirationAddModal">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal">×</button>
	    <h3>Add New</h3>
	  </div>
	  <div class="modal-body">
	  	<fieldset>
	  		<label>Website Address</label>
	  		<div class="input-append">
          		<input class="span2" id="addURL-url" size="50" type="text" placeholder="http://www.example.com" onkeypress="$('#addURL-error').addClass('hide');$('#addURL').addClass('hide');"><button class="btn" type="button" onClick="fetchURL();">Fetch</button>
          	</div>
          	<div id="addURL-error" class="alert alert-error hide">Unable to fetch website. Check URL and try again.</div>
	  	</fieldset>
	  	<div class="row-fluid">
		    <form id="addURL" class="hide">
	          <fieldset id="addURL-meta" class="span6 columns">
		          <div class="control-group">
		            <label class="control-label" for="addURL-title">Title</label>
		            <div class="controls">
		              <input type="text" class="input-xlarge" id="addURL-title">
		            </div>
		          </div>
		          <div class="control-group">
		            <label class="control-label" for="addURL-description">Description</label>
		            <div class="controls">
		              <textarea class="input-xlarge" id="addURL-description" rows="5"></textarea>
		            </div>
		          </div>
		          <div class="control-group">
		            <label class="control-label" for="addURL-tags">Tags</label>
		            <div class="controls">
		              <input class="input-xlarge" id="addURL-tags"/>
		            </div>
		          </div>
	          </fieldset>
	          <div class="span6 columns">
	          	<img id="addURL-image" src="" class="pull-right" style="width:80%;">
	          </div>
			</form>
	  	</div>
	  </div>
	  <div class="modal-footer">
	    <a href="#" class="btn" data-dismiss="modal">Cancel</a>
	    <a href="#" class="btn btn-primary">Save</a>
	  </div>
	</div>
	
	<script>
		function fetchURL(){
			website=$("#addURL-url").val();
			$.post('{{ URL::to_action('inspirations.url') }}',{url:website},function(response){
				console.log(response);
				if (response=="false"){
					$('#addURL-error').removeClass('hide');
				}else{
					website=JSON.parse(response);
					$('#addURL-title').val(website['title']);
					$('#addURL-description').val(website['description']);
					$('#addURL-image').attr('src',website['images'][0]);
					$('#addURL').removeClass('hide');
				}
			});
		};
	</script>
@endsection