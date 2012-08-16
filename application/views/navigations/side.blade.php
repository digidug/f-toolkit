						    <ul class="nav nav-list">
							@foreach($sidenav AS $title=>$items)
								<li class="nav-header">
									{{ $title }}
								</li>
								@foreach ($items AS $item)
									<li class="{{ URI::is($item['regexp'])?'active':'' }}">
										<a href="{{ URL::to($item['url']) }}"><i class="{{ $item['icon'] }}"></i> {{ $item['name'] }}</a>
									</li>
								@endforeach
							@endforeach
							
							<li class="nav-header">
								Your Account
							</li>
							<li class="{{ URI::is('users/user*')?'active':'' }}">
								<a href="{{ URL::to_action('users@user',array(Auth::user()->id)) }}"><i class="icon-user"></i> Profile</a>
							</li>
							<li class="{{ URI::is('settings*')?'active':'' }}">
								<a href="settings.htm"><i class="icon-cog"></i> Settings</a>
							</li>
							@if (Auth::user()->hasRole('Administrator'))
							<li class="nav-header">
								Admin
							</li>
							<li class="{{ URI::is('users*') && !URI::is('users/user*')?'active':'' }}">
								<a href="{{ URL::to('users') }}"><i class="icon-group"></i> Manage Users</a>
							</li>
							<li class="{{ URI::is('configure*')?'active':'' }}">
								<a href="blank.htm"><i class="icon-wrench"></i> Configure</a>
							</li>
							@endif
							<li class="divider">
							</li>
							<li class="{{ URI::is('help*')?'active':'' }}">
								<a href="help.htm"><i class="icon-info-sign"></i> Help</a>
							</li>
						</ul>