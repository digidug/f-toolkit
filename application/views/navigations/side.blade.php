						<ul class="nav nav-list">
							<ul class="nav-group <?php echo (!Navigation::is_admin() && !isset($styleguide))?'open':'closed'?>">
								<li class="nav-header">
									<a href="/index.php">TOOLS</a>
								</li>
								<li class="">
									<a href="/index.php"><i class="icon-home"></i> Dashboard</a>
								</li>
							</ul>
							@if (isset($styleguide))
							<ul class="nav-group open">
								<li class="nav-header">
									<a href="{{ URL::to_action('styleguides@one',array($styleguide->name)) }}">{{ $styleguide->name }} Styleguide</a>
								</li>
								@foreach ($styleguide->categories() AS $category)
								<li class="">
									<a href="{{ URL::to_action('styleguides@category',array($styleguide->name,str_replace(' ','_',$category->name))) }}"><i class="{{$category->icon}}"></i> {{ $category->name }}</a>
									@if (isset($category_name) && $category_name==$category->name)
										<ul class="patternsNav">
										@foreach ($styleguide->category($category_name)->activePatterns() AS $pattern)
											<li><small>{{$pattern->name}}</small></li>
										@endforeach
										</ul>
									@endif
								</li>
								@endforeach
							</ul>
							@endif
							@if (Auth::user()->hasRole('Administrator'))
							<ul class="nav-group <?php echo (Navigation::is_admin())?'open':'closed'?>">
								<li class="nav-header">
									<a href="{{ URL::to_action('styleguides@manage',array('list','all')) }}">Admin</a>
								</li>
								
								<li class="{{ URI::is('users*') && !URI::is('users/user*')?'active':'' }}">
									<a href="{{ URL::to('users') }}"><i class="icon-group"></i> Manage Users</a>
								</li>
								<li class="{{ URI::is('styleguides/manage*')?'active':'' }}">
									<a href="{{ URL::to_action('styleguides@manage',array('list','all')) }}"><i class="icon-tint"></i> Manage Style Guides</a>
								</li>
								<li class="{{ URI::is('configure*')?'active':'' }}">
									<a href="#"><i class="icon-wrench"></i> Configure</a>
								</li>
							</ul>
							@endif
						</ul>