<div class="accordion" id="sidenav">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#sidenav" href="#collapse_tools">
        Tools
      </a>
    </div>
    <div id="collapse_tools" class="accordion-body collapse {{ isset($nav_section) && $nav_section=='tools'?'in':'' }}">
      <div class="accordion-inner">
      	<ul>
	      	<li><i class="icon-home"></i> <a href="/">Dashboard</a></li>
	      	<li><i class="icon-user"></i> <a href="{{ URL::to_action('users@user',array(Auth::user()->id)) }}">Manage Profile</a></li>
      	</ul>
      </div>
    </div>
  </div>
@foreach ($styleguides AS $sg)
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#sidenav" href="#collapse_styleguide_{{$sg->name}}">
        {{$sg->name}} Style Guide
      </a>
    </div>
    <div id="collapse_styleguide_{{$sg->name}}" class="accordion-body collapse {{isset($styleguide) && $styleguide->id==$sg->id?'in':''}}">
      <div class="accordion-inner">
      	<ul>
        @foreach ($sg->categories(!$edit_mode) AS $cat)
        	<li><i class="{{$cat->icon}}"></i> <a href="{{ URL::to_action('styleguides@category',array($sg->name,str_replace(' ','_',$cat->name))) }}">{{$cat->name}}</a>
        	@if (Request::route()->controller_action!="one" && isset($category) && $category->id==$cat->id)
        		<ul>
        		@foreach ($category->patterns() AS $ptn)
        			<li><a href="#pattern_{{$ptn->id}}">{{ $ptn->name }}</li>
        		@endforeach
        		</ul>
        	@endif
        	</li>
        @endforeach
      	</ul>
      </div>
    </div>
  </div>
@endforeach
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#sidenav" href="#collapse_admin">
        Admin
      </a>
    </div>
    <div id="collapse_admin" class="accordion-body collapse {{ URI::is('manage*') || URI::is('users*')?'in':'' }}">
      <div class="accordion-inner">
      	<ul>
	      	<li><i class="icon-group"></i> <a href="{{ URL::to('users') }}">Manage Users</a></li>
	      	<li><i class="icon-tint"></i> <a href="{{ URL::to_action('styleguides@manage',array('list','all')) }}">Manage Style Guides</a></li>
	      	<li><i class="icon-wrench"></i> <a href="{{ URL::to_action('users@user',array(Auth::user()->id)) }}">Configure</a></li>
      	</ul>
      </div>
    </div>
  </div>
</div>