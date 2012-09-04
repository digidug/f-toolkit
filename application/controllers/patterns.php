<?php

class Patterns_Controller extends Base_Controller {

	public $restful = true;
	
	public function get_index() {
		$patterns = Pattern::with('category')->where_active('1')->get();
		$inactive_patterns = Pattern::with('category')->where_active('0')->get();
		return View::make('pages.patterns')
		    ->with('patterns', $patterns)
		    ->with('inactive_patterns', $inactive_patterns);
    }
    
    public function get_category($category_name) {
    	$categories=PatternCategory::where_name($category_name)->get();
    	$category=$categories[0];
		$patterns = Pattern::with('category')->where_pattern_category_id($category->id)->where_active('1')->order_by('sort')->get();
		return View::make('pages.patternsbycategory')
		    ->with('category', $category)
		    ->with('patterns', $patterns);
    }
    
    public function get_category_edit($category_id) {
    	$category=PatternCategory::find($category_id);
		$patterns = Pattern::with('category')->where_pattern_category_id($category->id)->where_active('1')->order_by('sort')->get();
		$inactive_patterns = Pattern::where_active('0')->get();
		return View::make('forms.pattern-category-form')
		    ->with(array(
		    	'category'=>$category,
		    	'patterns'=>$patterns,
		    	'inactive_patterns'=>$inactive_patterns,
		    	'pageTitle'=>'Edit <em> '.$category->name.' </em> Category',
		    	'submitButtonTitle'=>'Save',
    			'cancelButtonLink'=>URL::to_action('patterns@category',array($category->name))
    			));
    }
    
    public function post_category_edit($category_id) {
    	$category = PatternCategory::find($category_id);
        if (!$category->edit(Input::get())){
	    	return Redirect::to_action('patterns@category_edit',array($category_id))
        		->with_errors($category->validator)
        		->with_input();
        } else return Redirect::to_action('patterns@category',array($category->name));
    }
    
    public function get_categories() {
		$categories = PatternCategory::where_active('1')->get();
		return View::make('pages.patterncategories')
		    ->with('categories', $categories);
    }
    
    public function get_pattern($pattern_id) {
	    $pattern = Pattern::find($pattern_id);

	    return View::make('pages.pattern')
    		->with(array('pattern'=>$pattern));
    }

    public function post_createcategory(){
        $category = new PatternCategory(); 
        if (!$category->add(Input::get())){
	    	return 'fail';
        } else return 'success';
    }
    
    public function get_create($category_id){
    	$category=PatternCategory::find($category_id);
    	$pattern = new Pattern();
    	if (Input::old()){
			$pattern->name=Input::old('name');
			$pattern->description=Input::old('description');
			$pattern->html=Input::old('html');
			$pattern->css=Input::old('css');
			$pattern->category=Input::old('category');
		}else{
			$pattern->category=$category->id;
		}
    	return View::make('forms.pattern-form')
    		->with(array(
    			'pattern'=>$pattern,
    			'pageTitle'=>'Create New <em>'.$category->name.'</em> Pattern',
    			'submitButtonTitle'=>'Save',
    			'cancelButtonLink'=>URL::to_action('patterns@category',array($category->name))
    			));
    }
    
    public function post_create(){
        $pattern = new Pattern(); 
        if (!$pattern->add(Input::get())){
	    	return Redirect::to_action('patterns@create')
        		->with_errors($pattern->validator)
        		->with_input();
        } else return Redirect::to_action('patterns@category',array($pattern->category->name));
    }
    
    public function get_edit($pattern_id){
    	$pattern=Pattern::find($pattern_id);
		if (Input::old()){
			$pattern->name=Input::old('name');
			$pattern->description->content=Input::old('description');
			$pattern->html->content=Input::old('html');
			$pattern->css->content=Input::old('css');
			$pattern->category=Input::old('category');
		}
    	return View::make('forms.pattern-form')
    		->with(array(
    			'pattern'=>$pattern,
    			'pageTitle'=>'Edit Pattern',
    			'submitButtonTitle'=>'Save',
    			'cancelButtonLink'=>URL::to_action('patterns@category',array($pattern->category->name))
    			));
    }
    
    public function post_edit($pattern_id){
        $pattern = Pattern::find($pattern_id);
        if (!$pattern->edit(Input::get())){
	    	return Redirect::to_action('patterns@edit',array($pattern_id))
        		->with_errors($pattern->validator)
        		->with_input();
        } else return Redirect::to_action('patterns@category',array($pattern->category->name));
    }
    
    public function get_deactivate($pattern_id){
        $pattern = Pattern::find($pattern_id);
        $pattern->deactivate();
        return Redirect::to_action('patterns@index');
    }
    
    public function get_activate($pattern_id){
        $pattern = Pattern::find($pattern_id);
        $pattern->activate();
        return Redirect::to_action('patterns@index');
    }
    
    public function get_delete($pattern_id){
        $pattern = Pattern::find($pattern_id);
        if ($pattern->active==0) $pattern->delete();
        return Redirect::to_action('patterns@index');
    }
    
}