<?php

class Images_Controller extends Base_Controller {

	public $restful = true;
    
    public function get_browse($category_id){
    	$images=glob(path('public')."img/uploads/styleguides/".$category_id."/*.*");
    	usort($images, create_function('$a,$b', 'return filemtime($b) - filemtime($a);'));
    	
	    return View::make('forms.browseimages')
	    	->with('category_id', $category_id)
		    ->with('images', $images);

    }
    
    public function get_upload($category_id){
    	return View::make('forms.uploadimage');
    }
    
    public function post_upload($category_id){
    	$name=md5(time()).".".File::extension(Input::file('imageUpload.name'));
    	$path='/img/uploads/styleguides/'.$category_id;
    	Input::upload('imageUpload', 'public/'.$path, $name);
    	
    	return $path."/".$name;
    }
}