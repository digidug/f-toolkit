<?php

class PatternCategories_Controller extends Base_Controller {

	public $restful = true;
	
	public function get_create($styleguide_id){
    	$styleguide=Styleguide::find($styleguide_id);
    	$category = new PatternCategory();
    	if (Input::old()){
			$category->name=Input::old('name');
			$category->description=Input::old('description');
			$category->css=Input::old('html');
			$category->html=Input::old('css');
			$category->javascript=Input::old('javascript');
			$styleguide_id=Input::old('styleguide');
		}else{
			$styleguide_id=$styleguide->id;
		}
		$css="";//addslashes(preg_replace('/\s\s+/', ' ', strip_tags($category->meta->css)));
    	return View::make('forms.pattern-category-form')
    		->with(array(
    			'category'=>$category,
    			'styleguide_id'=>$styleguide_id,
    			'pageTitle'=>'Create New <em>'.$styleguide->name.'</em> Category',
    			'css'=>$css,
    			'submitButtonTitle'=>'Save',
    			'cancelButtonLink'=>URL::to_action('styleguides@one',array($styleguide->name))
    			));
    }
    
    public function post_create(){
    	$styleguide=Styleguide::find(Input::get('styleguide'));
        $category = new PatternCategory(); 
        if (!$category->add(Input::get())){
	    	return Redirect::to(URL::current())
        		->with_errors($category->validator)
        		->with_input();
        } else return Redirect::to_action('styleguides@one',array($styleguide->name));
    }
    
    public function get_edit($category_id) {
    	$category=PatternCategory::find($category_id);
		$patterns = Pattern::where_pattern_category_id($category->id)->where_active('1')->order_by('sort')->get();
		$inactive_patterns = Pattern::where_active('0')->get();	
		if (Input::old()){
			$category->name=Input::old('name');
			$category->meta->lead=Input::old('lead');
			$category->meta->description=Input::old('description');
			$category->meta->css=Input::old('css');
			$category->meta->javascript=Input::old('javascript');
		}
		return View::make('forms.pattern-category-form')
		    ->with(array(
		    	'category'=>$category,
		    	'patterns'=>$patterns,
		    	'inactive_patterns'=>$inactive_patterns,
		    	'pageTitle'=>'Edit <em> '.$category->name.' </em> Category',
		    	'submitButtonTitle'=>'Save',
    			'cancelButtonLink'=>URL::to_action('styleguides@category',array($category->styleguide->name, $category->name))
    			));
    }
    
    public function post_edit($category_id) {
    	$category = PatternCategory::find($category_id);
        if (!$category->edit(Input::get())){
	    	return Redirect::to_action(URL::current())
        		->with_errors($category->validator)
        		->with_input();
        } else return Redirect::to_action('styleguides@category',array($category->styleguide->name, $category->name));
    }    
}