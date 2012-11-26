<?php

class Navigation {
	
	public static function section(){
		$route=Request::route();
		return $route->controller;
	}
	
	public static function is_tools(){
		$route=Request::route();print_r($route);
		return (isset($route->parameters[0]) && $route->parameters[0]=="manage");
	}
	
	public static function is_admin(){
		$route=Request::route();
		return (isset($route->parameters[0]) && $route->parameters[0]=="manage");
	}
}