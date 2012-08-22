<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Creative Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    {{ HTML::style('css/styles.css') }}
    {{ HTML::style('css/bootstrap.css') }}
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    {{ HTML::style('css/bootstrap-responsive.css') }}
    {{ HTML::style('css/font-awesome.css') }}
    {{ HTML::style('css/site.css') }}
    {{ HTML::style('css/prettify.css') }}
    
    {{ HTML::script('js/jquery.min.js') }}

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <!--
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
    -->
  </head>

  <body>
		<div class="container">
			@include('navigations.global')
			<div class="row">
				<div class="span3">
					<div class="well" style="padding: 8px 0;">
						@include('navigations.side')
					</div>
				</div>
				<div class="span9">
					@yield('content')
				</div>
			</div>
		</div>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    @section('jsfiles')
    	{{ HTML::script('js/bootstrap.min.js') }}
    	{{ HTML::script('js/google-code-prettify/prettify.js') }}
    	{{ HTML::script('js/google-code-prettify/lang-css.js') }}
    	{{ HTML::script('js/jquery.taboverride.js') }}
    @yield_section
    <script>
    	$(document).ready(function() {
	    	@section('jsready')
            	prettyPrint();
            @yield_section
	    });
	    @section('js')
	    
        @yield_section
    </script>
  </body>
</html>