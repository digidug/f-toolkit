@layout('templates.main')
@section('content')
	<div class="page-header">
		<div class="pattern-header-left">
			<h1 class="styleguide-headline">{{ $styleguide->name }}<br>Styleguide</h1>
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
	<p>This section illustrates how the Global Look + Style should be represented in {{Str::lower($styleguide->name)}} applications, taking into account digital production specifications while bringing to life GL+S in this important media touchpoint. The use of letterbox white space has been maintained whenever possible, as well as GL+S colour and typographic specifications. Navigational styles have been streamlined to ensure global brand language consistency, minimizing duplication of efforts globally while maintaining best practices across all digital channels.</p>
	<p class="styleguide-note">Please note that the styles on the following pages may not mirror what is on the live sites (i.e., ford.com), but that this is the direction rolling out globally. Moving forward, all new initiatives should be designed with the Global Look + Style in mind.</p>
	<ul class='category-links'>
		@foreach ($categories AS $category)
        	<li><i class="{{$category->icon}}"></i> <a href="{{ URL::to_action('styleguides/category', array($styleguide->name,$category->name)); }}">{{ $category->name }}</a><i class='icon-caret-right'></i></li>
        @endforeach
	</ul>
@endsection