						<ul class="nav nav-list">
							@foreach($sidenav AS $title=>$items)
								<li class="nav-header">
									{{ $title }}
								</li>
								<!--
								@foreach ($items AS $item)
									<li class="{{ URI::is(strtolower($item['regexp']))?'active':'' }}">
										<a href="{{ URL::to($item['url']) }}"><i class="{{ $item['icon'] }}"></i> {{ $item['name'] }}</a>
									</li>
								@endforeach
								-->
							@endforeach
							@if (isset($styleguide))
								<li class="nav-header">
									{{ $styleguide->name }} Styleguide
								</li>
								@foreach ($styleguide->categories() AS $category)
									<li class="{{$category->name==$styleguide->category?'active':'' }}">
										<a href="{{ URL::to_action('styleguides@category',array($styleguide->name,$category->name)) }}">{{ $category->name }}</a>
										@if (isset($styleguide->category->name) && $styleguide->category->name==$category->name)
											<ul class="patternsNav">
											@foreach ($styleguide->category->activePatterns() AS $pattern)
												<li><small>{{$pattern->name}}</small></li>
											@endforeach
											</ul>
										@endif
									</li>
								@endforeach
							@endif
							<li class="nav-header">
								Your Account
							</li>
							<!--
							<li class="{{ URI::is('users/user*')?'active':'' }}">
								<a href="{{ URL::to_action('users@user',array(Auth::user()->id)) }}"><i class="icon-user"></i> Profile</a>
							</li>
							<li class="{{ URI::is('settings*')?'active':'' }}">
								<a href="#"><i class="icon-cog"></i> Settings</a>
							</li>
							-->
							@if (Auth::user()->hasRole('Administrator'))
							<li class="nav-header">
								Admin
							</li>
							<!--
							<li class="{{ URI::is('users*') && !URI::is('users/user*')?'active':'' }}">
								<a href="{{ URL::to('users') }}"><i class="icon-group"></i> Manage Users</a>
							</li>
							<li class="{{ URI::is('styleguides/manage*')?'active':'' }}">
								<a href="{{ URL::to_action('styleguides@manage',array('list','all')) }}"><i class="icon-tint"></i> Manage Style Guides</a>
							</li>
							<li class="{{ URI::is('configure*')?'active':'' }}">
								<a href="#"><i class="icon-wrench"></i> Configure</a>
							</li>
							-->
							@endif
							<li class="divider">
							</li>
							<li class="{{ URI::is('help*')?'active':'' }}">
								<a href="#"><i class="icon-info-sign"></i> Help</a>
							</li>
						</ul>