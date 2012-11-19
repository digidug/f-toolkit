<?php

class Styleguides_Controller extends Base_Controller {

	public $restful = true;
	static $guide_name;
	static $styleguide;
	
	public function __construct(){
	    if (Input::get('edit_mode')=="true"){
		    $edit_mode=true;
	    }else if (Input::get('edit_mode')=="false"){
		    $edit_mode=false;
	    }else if (Session::get('edit_mode')!=false){
		    $edit_mode=Session::get('edit_mode');
	    }else{
		    $edit_mode=false;
	    }
	    
	    $this->edit_mode=$edit_mode;
	    Session::put('edit_mode', $edit_mode);
	    View::share('edit_mode', $edit_mode);
    }
    
    public function get_version($version,$styleguide_name) {
    	$styleguide=Styleguide::one($styleguide_name);
    	if ($version=='latest'){
	    	$categories=$styleguide->version()->categories();
    	}else{
    		$categories=$styleguide->version($version)->categories();
       	}
       	
    	return View::make('pages.styleguide-version')
		    ->with('sg', $styleguide)
		    ->with('categories', $categories);
    }
    
    public function get_one($styleguide_name) {
    	if ($this->edit_mode==false){
    		$styleguide=Styleguide::one($styleguide_name);
    		$styleguide->version=StyleguideVersion::latest($styleguide->id)->version;
    		$categories=$styleguide->categories();
    		$template='pages.versionstyleguide';
    	}else{
			$styleguide = Styleguide::one($styleguide_name);
			$categories=$styleguide->categories();
			$template='pages.styleguide';
    	}
    	return View::make($template)
		    ->with('styleguide', $styleguide)
		    ->with('categories', $categories);
    }
    
    
    
    public function get_category($styleguide_name,$category_name) {
    	$category_name=str_replace('_',' ',$category_name);
    	if ($this->edit_mode==false){
	    	$styleguide=Styleguide::one($styleguide_name);
	    	$styleguide->version=StyleguideVersion::latest($styleguide->id)->version;
	    	$category=$styleguide->category($category_name);
	    	$patterns=$category->version_patterns();
	    	$template='pages.versioncategory';
		}else{
			$styleguide = Styleguide::one($styleguide_name);
			$category=$styleguide->category($category_name);
			$patterns = $category->patterns();
			$template='pages.patternsbycategory';
		}
		return View::make($template)
			->with('styleguide', $styleguide)
			->with('category', $category)
			->with('patterns', $patterns)
			->with('category_name', $category_name);
    }
    
    public function get_editcategory($styleguide_name,$category_name) {
    	$styleguide = Styleguide::one($styleguide_name);
    	$category=$styleguide->category($category_name);
    	$patterns = $category->patterns();

       	return View::make('pages.patternsbycategory')
    		->with('styleguide', $styleguide)
		    ->with('category', $category)
		    ->with('patterns', $patterns)
		    ->with('category_name', $category_name);
    }
    
    public function get_create($type,$id){
	    switch ($type){
		    case "pattern": return Controller::call('Patterns@create',array($id));
		    case "category": return Controller::call('PatternCategories@create',array($id));
		    case "styleguide": return Controller::call('Styleguides@create_styleguide');
	    }
    }
    
    public function post_create($type,$id){
	    switch ($type){
		    case "pattern": return Controller::call('Patterns@create',array($id));
		    case "category": return Controller::call('PatternCategories@create',array($id));
		    case "styleguide": return Controller::call('Styleguides@create_styleguide');
	    }
    }
    
    public function get_edit($type,$id){
	    switch ($type){
		    case "pattern": return Controller::call('Patterns@edit',array($id));
		    case "category": return Controller::call('PatternCategories@edit',array($id));
		    case "styleguide": return Controller::call('Styleguides@edit_styleguide',array($id));
	    }
	    
    }
    
    public function post_edit($type,$id){
	    switch ($type){
		    case "pattern": return Controller::call('Patterns@edit',array($id));
		    case "category": return Controller::call('PatternCategories@edit',array($id));
		    case "styleguide": return Controller::call('Styleguides@edit_styleguide',array($id));
	    }
	    
    }
    
    public function get_manage($controller,$action,$id=null) {
		switch ($controller){
		    case "list": return Controller::call('Styleguides@list');
		    case "version": return Controller::call('StyleguideVersions@'.$action,array($id));
	    }
    }
    
    public function post_manage($controller,$action,$id=null) {
		switch ($controller){
		    case "version": return Controller::call('StyleguideVersions@'.$action,array($id));
	    }
    }
    
    public function get_list() {
		$styleguides = Styleguide::active();
		$inactive_styleguides = Styleguide::inactive();
		return View::make('pages.manage-styleguides-list')
		    ->with('styleguides', $styleguides)
		    ->with('inactive_styleguides', $inactive_styleguides);
    }
    
    public function get_create_styleguide() {
    	$styleguide=new Styleguide();
    	if (Input::old()){
			$styleguide->name=Input::old('name');
			$styleguide->guid=Input::old('guid');
		}
    	return View::make('forms.styleguide-form')
    		->with(array(
    			'styleguide'=>$styleguide,
    			'pageTitle'=>'Create New Style Guide',
    			'submitButtonTitle'=>'Save',
    			'cancelButtonLink'=>URL::to_action('styleguides@manage',array('list','all'))
    			));
    }
    
    public function post_create_styleguide(){
    	$styleguide = new Styleguide();
        if (!$styleguide->add(Input::get())){
	    	return Redirect::to(URL::current())
        		->with_errors($styleguide->validator)
        		->with_input();
        } else return Redirect::to_action('styleguides@manage',array('list','all'));
    }
    
    public function get_edit_styleguide($styleguide_id) {
    	$styleguide=Styleguide::find($styleguide_id);
    	if (Input::old()){
			$styleguide->name=Input::old('name');
		}
    	return View::make('forms.styleguide-form')
    		->with(array(
    			'styleguide'=>$styleguide,
    			'pageTitle'=>'Create New Style Guide',
    			'submitButtonTitle'=>'Save',
    			'cancelButtonLink'=>URL::to_action('styleguides@one',array($styleguide->name))
    			));
    }
    
    public function post_edit_styleguide($styleguide_id){
    	$styleguide = Styleguide::find($styleguide_id);
        if (!$styleguide->edit($styleguide->id,Input::get())){
	    	return Redirect::to(URL::current())
        		->with_errors($styleguide->validator)
        		->with_input();
        } else return Redirect::to_action('styleguides@one',array($styleguide->name));
    }
}