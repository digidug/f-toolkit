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
		$patterns = Pattern::where_pattern_category_id($category->id)->where_active('1')->order_by('sort')->get();
		return View::make('pages.patternsbycategory')
		    ->with('category', $category)
		    ->with('patterns', $patterns);
    }
    
    public function get_categorycss($category_name) {
    	$categories=PatternCategory::where_name($category_name)->get();
    	$category=$categories[0];
		return strip_tags($category->meta->css);
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
    
    public function get_create($category_id){
    	$category=PatternCategory::find($category_id);
    	$pattern = new Pattern();
    	if (Input::old()){
			$pattern->name=Input::old('name');
			$pattern->url=Input::old('url');
			$pattern->description=Input::old('description');
			$pattern->html=Input::old('html');
			$pattern->css=Input::old('css');
			$category_id=Input::old('category');
		}else{
			$category_id=$category->id;
		}
		$css=addslashes(preg_replace('/\s\s+/', ' ', strip_tags($category->meta->css)));
    	return View::make('forms.pattern-form')
    		->with(array(
    			'pattern'=>$pattern,
    			'category_id'=>$category_id,
    			'pageTitle'=>'Create New <em>'.$category->name.'</em> Pattern',
    			'css'=>$css,
    			'submitButtonTitle'=>'Save',
    			'cancelButtonLink'=>URL::to_action('styleguides@editcategory',array($category->styleguide->name))
    			));
    }
    
    public function post_create(){
    	$category=PatternCategory::find(Input::get('category'));
    	$pattern = new Pattern();
        if (!$pattern->add(Input::get())){
	    	return Redirect::to(URL::current())
        		->with_errors($category->validator)
        		->with_input();
        } else return Redirect::to_action('styleguides@editcategory',array($category->styleguide->name,$category->name));
    }
    
    public function get_edit($pattern_id){
	    $pattern=Pattern::find($pattern_id);
		if (Input::old()){
			$pattern->name=Input::old('name');
			$pattern->url=Input::old('url');
			$pattern->description->content=Input::old('description');
			$pattern->html->content=Input::old('html');
			$pattern->css->content=Input::old('css');
			$pattern->category->id=Input::old('category');
		}
		$css=addslashes(preg_replace('/\s+/', ' ', strip_tags($pattern->category->meta()->first()->css)));
    	return View::make('forms.pattern-form')
    		->with(array(
    			'pattern'=>$pattern,
    			'category_id'=>$pattern->category->id,
    			'pageTitle'=>'Edit Pattern',
    			'css'=>$css,
    			'submitButtonTitle'=>'Save',
    			'cancelButtonLink'=>URL::to_action('styleguides@editcategory',array($pattern->styleguide()->name,$pattern->category->name))
    			));
    }
    
    public function post_edit($pattern_id){
        $pattern = Pattern::find($pattern_id);
        if (!$pattern->edit(Input::get())){
	    	return Redirect::to(URL::current())
        		->with_errors($pattern->validator)
        		->with_input();
        } else return Redirect::to_action('styleguides@editcategory',array($pattern->styleguide()->name,$pattern->category->name));
    }
    
}