@layout('templates.main')
@section('content')
	<div class="page-header">
		@if (Auth::user()->hasRole('Administrator'))
			<a class="btn btn-primary pull-right" href="{{ URL::to_action('patterns@category_edit', array($category->id)); }}"><i class="icon-edit icon-white"></i> Edit</a>
		@endif
		<h1>{{ $category->name }}</h1>
	</div>
	<p class="lead">{{ $category->lead }}</p>
	<div>{{ $category->description }}</div>
	@foreach ($patterns as $pattern)
		<div class="output">
			@if (Auth::user()->hasRole('Administrator'))
				<a class="btn btn-primary btn-mini pull-right" href="{{ URL::to_action('patterns@edit', array($pattern->id)); }}"><i class="icon-edit icon-white"></i> Edit</a>
			@endif
			<h3>{{ $pattern->name }}</h3>
			<div>{{ $pattern->description->content }}</div>
	        <div>{{ $pattern->html->content }}</div>
	        @if ($pattern->html->content!='' || $pattern->css->content!='')
		        <div class="tabbable">
				  <ul class="nav nav-tabs">
				    <li class="active"><a href="#html_{{$pattern->html->id}}" data-toggle="tab">HTML</a></li>
				    <li><a href="#css_{{$pattern->css->id}}" data-toggle="tab">CSS</a></li>
				  </ul>
				  <div class="tab-content">
				  	<pre class="tab-pane active prettyprint pre-scrollable" id="html_{{$pattern->html->id}}">{{ htmlentities($pattern->html->content) }}</pre>
				    <pre class="tab-pane prettyprint lang-css pre-scrollable" id="css_{{$pattern->css->id}}">{{ $pattern->css->content }}</pre>
				  </div>
				</div>
			@endif
	    </div>
	@endforeach
	</div>
@endsection