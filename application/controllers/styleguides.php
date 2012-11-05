<?php

class Styleguides_Controller extends Base_Controller {

	public $restful = true;
	static $guide_name;
	static $styleguide;
	
	public function __construct(){
	
		// styleguide nav
		$page=$this->url();
		
        if ($page->controller=="styleguides"){
        	self::$guide_name=array_shift($page->parameters);
	        self::$styleguide = Styleguide::one(self::$guide_name);
	        
	        if (isset(self::$styleguide)) self::$styleguide->category=isset($page->parameters[0])?Styleguide::category(self::$styleguide->id,$page->parameters[0]):"";
	        View::share('styleguide', self::$styleguide);
        }
	}
    
    public function get_one($styleguide_name) {
    	$styleguide = Styleguide::one($styleguide_name);
    	$categories=$styleguide->categories();
    	
    	return View::make('pages.styleguide')
		    ->with('styleguide', $styleguide)
		    ->with('categories', $categories);
    }
    
    public function get_category($styleguide_name,$category_name) {
    	$styleguide = Styleguide::one($styleguide_name);
    	$category=$styleguide->category($styleguide->id,$category_name);
    	$patterns = $category->activePatterns();
    	return View::make('pages.patternsbycategory')
		    ->with('category', $category)
		    ->with('patterns', $patterns);
    }
    
    public function get_create($type,$id){
	    switch ($type){
		    case "pattern": return Controller::call('Patterns@create',array($id));
		    case "category": return Controller::call('PatternCategories@create',array($id));
	    }
    }
    
    public function post_create($type,$id){
	    switch ($type){
		    case "pattern": return Controller::call('Patterns@create',array($id));
		    case "category": return Controller::call('PatternCategories@create',array($id));
	    }
    }
    
    public function get_edit($type,$id){
	    switch ($type){
		    case "pattern": return Controller::call('Patterns@edit',array($id));
		    case "category": return Controller::call('PatternCategories@edit',array($id));
	    }
	    
    }
    
    public function post_edit($type,$id){
	    switch ($type){
		    case "pattern": return Controller::call('Patterns@edit',array($id));
		    case "category": return Controller::call('PatternCategories@edit',array($id));
	    }
	    
    }
    
    public function get_manage($controller,$action,$id=null) {
		switch ($controller){
		    case "version": return Controller::call('StyleguideVersions@'.$action,array($id));
	    }
    }
    
    public function get_list($category_name){
	    $styleguides = Styleguide::active();
		$inactive_styleguides = Styleguide::inactive();
		return View::make('pages.styleguides')
		    ->with('styleguides', $styleguides)
		    ->with('inactive_styleguides', $inactive_styleguides);
    }
}