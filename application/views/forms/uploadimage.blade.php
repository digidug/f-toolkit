<form id="imageUploadForm" action="{{URL::to_action('images@upload',array($category_id))}}" enctype="multipart/form-data" method="post" target="tunnel">
	<span id="imageUploadMessage" class="alert-info" style="margin-right:20px;"></span>
	<input type="file" class="hide" id="imageUpload" name="imageUpload" size="20" />
	<label for="imageUpload" class="btn btn-primary"><i class="icon-upload"></i>&nbsp;Upload</label>
</form>
<iframe name="tunnel" id="tunnel" style="width:0px;height:0px;visibility:none;"></iframe>

@section('cssfiles')
	@parent

@endsection

@section('js')

@endsection

@section('jsfiles')
	@parent

@endsection

@section('jsready')
	@parent
	
	$('#imageUploadForm').submit(function(e){
		//e.preventDefault();
		$('#imageUploadMessage').html("Uploading "+$("#imageUpload").attr('value'));
		$('#imageUploadMessage').removeClass('alert-success').addClass('alert-info');
	});
	
	$('#imageUpload').change(function(){
		$('#imageUploadForm').submit();
	});
	
	$('#tunnel').load(function(){
        response=$('#tunnel').contents().find('body').html();
        if (response!="error"){
        	addImage(response);
        	$('#imageUploadMessage').html("File uploaded.");
        	$('#imageUploadMessage').removeClass('alert-info').addClass('alert-success');
        }
    });
@endsection