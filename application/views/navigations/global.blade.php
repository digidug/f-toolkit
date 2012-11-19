			<div class="navbar" id="topnav">
				<div class="navbar-inner">
					<div class="container">
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> <a class="brand" href="/index.php"><img src="/img/Ford_Motor_Company_logo.png"> Global Look + Style <span>Guidelines</span></a>
						<div class="nav-collapse">
							<ul class="nav pull-right">
								@if(isset($styleguide) && Auth::user()->hasRole('Administrator'))
								<li>
									@if(isset($edit_mode) && $edit_mode==true)
									<a href="{{ URL::current() }}?edit_mode=false"><i class="icon icon-unlock"></i> Close editing</a>
									@else	
									<a href="{{ URL::current() }}?edit_mode=true"><i class="icon icon-lock"></i> Open editing</a>
									@endif
								</li>
								@endif
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Style Guides <b class="caret"></b></a>
									<ul class="dropdown-menu">
										@foreach (Styleguide::active() AS $this_styleguide)
											<a href="{{ URL::to_action('styleguides@one',array($this_styleguide->name)) }}/">{{ $this_styleguide->guid }} | {{$this_styleguide->name }}</a>
										@endforeach
									</ul>
								</li>
								<li>
									<a href="{{ URL::to_action('users@user',array(Auth::user()->id)) }}" class="gray">@{{ Auth::user()->username }}</a>
								</li>
								<li>
									<a href="{{ URL::to('logout') }}"><i class="icon-off icon-white"></i> Logout</a>
								</li>
							</ul>
							<!--
							<form class="navbar-search pull-right" action="">
								<input type="text" class="search-query span2" placeholder="Search" />
							</form>
							-->
						</div>
					</div>
				</div>
			</div>