@layout('templates.main')
@section('content')
	<div class="page-header">
		<div class="pattern-header-left">
			<h3>{{ $styleguide->name }} Styleguide</h3>
			<h1>{{ $category->name }}</h1>
		</div>
		<div class="pattern-header-right">
			<ul>
				<li>Version <span>{{$styleguide->version()->version}}</span></li>
				<li>Date Created <span>{{ date('jS M Y',strtotime('last week')) }}</span></li>
				<li>Last Modified <span>{{ date('jS M Y') }}</span></li>
				<li>Feedback <a href="">GLSfeedback@teamdetroit.com</a></li>
			</ul>
		</div>
	</div>
	<p class="lead">{{ $category->meta()->first()->lead }}</p>
	<div>{{ $category->meta()->first()->description }}</div>
	<ul class='pattern-links'>
		@foreach ($patterns AS $ptn)
        	<li><a href="#pattern_{{$ptn->id}}">{{ $ptn->name }}</a><i class='icon-caret-right'></i></li>
        @endforeach
	</ul>
	@foreach ($patterns as $pattern)
		@if (Auth::user()->hasRole('Administrator'))
			<div class="pattern" id="pattern_{{$pattern->id}}">
				<!--
				@if ($pattern->version_meta()->first()->html!='')
					<div class="btn-group pull-right" data-toggle="buttons-radio">
						<button type="button" class="btn btn-info btn-mini active" onclick="changeOutputWidth(this,{{$pattern->id}},'320px');">320px</button>
						<button type="button" class="btn btn-info btn-mini" onclick="changeOutputWidth(this,{{$pattern->id}},'480px');">480px</button>
						<button type="button" class="btn btn-info btn-mini" onclick="changeOutputWidth(this,{{$pattern->id}},'600px');">600px</button>
					</div>
				@endif
				-->
				<div class="actions pull-right">
					<a href="">History</a> | <a href="#">Preview</a>
				</div>
				<h3>{{ $pattern->name }}</h3>
				<div class="pattern-date">Last Modified: {{ date('jS M Y',strtotime('last week')) }}</div>
				<div class="description">{{ $pattern->version_meta()->first()->description }}</div>
		        <div class="output" id="output_{{$pattern->id}}" contenteditable="true">{{ $pattern->version_meta()->first()->html }}</div>
		        @if ($pattern->version_meta()->first()->html!='' || $pattern->version_meta()->first()->css!='')
			        <div class="tabbable" style="clear:both;">
					  <ul class="nav nav-tabs">
					    <li class="active"><a href="#html_{{$pattern->version_meta()->first()->id}}" data-toggle="tab">HTML</a></li>
					    <li><a href="#css_{{$pattern->version_meta()->first()->id}}" data-toggle="tab">CSS</a></li>
					  </ul>
					  <div class="tab-content">
					  	<pre class="tab-pane active prettyprint pre-scrollable" id="html_{{$pattern->version_meta()->first()->id}}">{{ htmlentities(str_replace(array(' editable','editable ','editable'),'',$pattern->version_meta()->first()->html)) }}</pre>
					    <pre class="tab-pane prettyprint lang-css pre-scrollable" id="css_{{$pattern->version_meta()->first()->id}}">{{ $pattern->version_meta()->first()->css }}</pre>
					  </div>
					</div>
				@endif
		    </div>
		@endif
	@endforeach
	</div>
@endsection

@section('css')
	@parent
	{{ $category->meta()->first()->css }}
@endsection

@section('js')
	@parent
	{{ $category->meta()->first()->javascript }}
	function changeOutputWidth(button,output_id,size){
		$(button).siblings().removeClass('active');
		$(button).addClass('active');
		$('#output_'+output_id).animate({'width':size});
	}
@endsection

@section('jsready')
	@parent
	$('.isusereditable').attr('contentEditable','true');
@endsection