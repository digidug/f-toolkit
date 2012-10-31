			<div class="navbar" id="topnav">
				<div class="navbar-inner">
					<div class="container">
						<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> <a class="brand" href="#">Creative Hub</a>
						<div class="nav-collapse">
							<ul class="nav">
							<!--
								<li class="active">
									<a href="index.htm">Dashboard</a>
								</li>
								<li>
									<a href="settings.htm">Account Settings</a>
								</li>
								<li>
									<a href="help.htm">Help</a>
								</li>
							-->
								<li class="dropdown">
									<a href="help.htm" class="dropdown-toggle" data-toggle="dropdown">Style Guides <b class="caret"></b></a>
									<ul class="dropdown-menu">
										@foreach (Styleguide::active() AS $styleguide)
											<a href="{{ URL::to_action('styleguides@one',array($styleguide->name)) }}/">{{ $styleguide->guid }} | {{$styleguide->name }}</a>
										@endforeach
									</ul>
								</li>
							</ul>
							<ul class="nav pull-right">
								<li>
									<a href="{{ URL::to_action('users@user',array(Auth::user()->id)) }}">@{{ Auth::user()->username }}</a>
								</li>
								<li>
									<a href="{{ URL::to('logout') }}"><i class="icon-off icon-white"></i> Logout</a>
								</li>
							</ul>
							<form class="navbar-search pull-right" action="">
								<input type="text" class="search-query span2" placeholder="Search" />
							</form>
						</div>
					</div>
				</div>
			</div>