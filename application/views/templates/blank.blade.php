<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Creative Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    @section('cssfiles')
    	{{ HTML::style('css/bootstrap.css') }}
    	{{ HTML::style('css/bootstrap-responsive.css') }}
    	{{ HTML::style('css/site.css') }}
    	{{ HTML::style('css/prettify.css') }}
    @yield_section
    <style>
    	@section('css')
    		body {
	    		padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
	    	}
	    @yield_section
    </style>
    
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
  	@yield('content')

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    @section('jsfiles')
    	{{ HTML::script('js/bootstrap.min.js') }}
    	{{ HTML::script('js/google-code-prettify/prettify.js') }}
    	{{ HTML::script('js/jquery.taboverride.js') }}
    	{{ HTML::script('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js') }}
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