@layout('templates.main')
@section('content')
	<div class="page-header">
		<h1>{{ $pattern->name }}</h1>
		<span class="label label-info">{{ $pattern->category->name }}</span>
	</div>
    <div>
        <div class="output">{{ $pattern->description->content }}</div>
        <p>{{ $pattern->html->content }}</p>
        @if ($pattern->html->content!='' || $pattern->css->content!='')
	        <div class="tabbable">
			  <ul class="nav nav-pills">
			    <li class="active"><a href="#html" data-toggle="tab">HTML</a></li>
			    <li><a href="#css" data-toggle="tab">CSS</a></li>
			  </ul>
			  <div class="tab-content">
			  	<pre class="tab-pane active prettyprint pre-scrollable" id="html">{{ htmlentities($pattern->html->content) }}</pre>
			    <pre class="tab-pane prettyprint lang-css pre-scrollable" id="css">{{ $pattern->css->content }}</pre>
			  </div>
			</div>
		@endif
    </div>
    <div class="form-actions">
    	<a class="btn" href="{{ URL::to_action('patterns@index'); }}"><i class="icon-arrow-left"></i> Back</a> <a class="btn btn-primary" href="{{ URL::to_action('patterns@edit', array($pattern->id)); }}"><i class="icon-edit icon-white"></i> Edit</a>

    </div>
@endsection