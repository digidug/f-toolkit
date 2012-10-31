<?php

class Base_Controller extends Controller {

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}
	
	public function url(){
	
		//acquire url knowledge
		$route=Request::route();
        $aux=explode("@",$route->action['uses']);
        $controller=array_shift($aux);
        $action=array_shift($route->parameters);
        $parameters=$route->parameters;
        
        $page=new stdClass;
        $page->controller=$controller;
        $page->action=$action;
        $page->parameters=$parameters;
	
        return $page;
        
    }
}