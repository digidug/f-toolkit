@layout('templates.main')
@section('content')
	{{ $category->css }}
	<div class="page-header">
		@if (Auth::user()->hasRole('Administrator'))
			<div class="pull-right">
				<a class="btn btn-success" href="{{ URL::to_action('patterns@create', array($category->id)) }}"><i class="icon-plus"></i> Add</a> 
				<a class="btn btn-primary" href="{{ URL::to_action('patterns@category_edit', array($category->id)); }}"><i class="icon-edit icon-white"></i> Edit</a>
			</div>
		@endif
		<h1>{{ $category->name }}</h1>
	</div>
	<p class="lead">{{ $category->lead }}</p>
	<div>{{ $category->description }}</div>
	@foreach ($patterns as $pattern)
		<div>
			@if (Auth::user()->hasRole('Administrator'))
				<a class="btn btn-primary btn-mini pull-right" href="{{ URL::to_action('patterns@edit', array($pattern->id)); }}"><i class="icon-edit icon-white"></i> Edit</a>
			@endif
			<h3>{{ $pattern->name }}</h3>
			<div>{{ $pattern->description->content }}</div>
	        <div class="output">{{ $pattern->html->content }}</div>
	        @if ($pattern->html->content!='' || $pattern->css->content!='')
		        <div class="tabbable">
				  <ul class="nav nav-tabs">
				    <li class="active"><a href="#html_{{$pattern->html->id}}" data-toggle="tab">HTML</a></li>
				    <li><a href="#css_{{$pattern->css->id}}" data-toggle="tab">CSS</a></li>
				  </ul>
				  <div class="tab-content">
				  	<pre class="tab-pane active prettyprint pre-scrollable" id="html_{{$pattern->html->id}}">{{ htmlentities(str_replace(array(' editable','editable ','editable'),'',$pattern->html->content)) }}</pre>
				    <pre class="tab-pane prettyprint lang-css pre-scrollable" id="css_{{$pattern->css->id}}">{{ $pattern->css->content }}</pre>
				  </div>
				</div>
			@endif
	    </div>
	@endforeach
	</div>
@endsection

@section('jsready')
	@parent
	$('.isusereditable').attr('contentEditable','true');
@endsection