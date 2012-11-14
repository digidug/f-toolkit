<?php

class StyleguideVersions_Controller extends Base_Controller {

	public $restful = true;
	
	public function get_list($styleguide_name) {
		$styleguides = Styleguide::active();
		$inactive_styleguides = Styleguide::inactive();
		return View::make('pages.manage-styleguides-list')
		    ->with('styleguides', $styleguides)
		    ->with('inactive_styleguides', $inactive_styleguides);
    }
	
	public function get_commit($styleguide_name) {
		$current_styleguide = Styleguide::one($styleguide_name);
		
		return View::make('forms.version')
			->with('current_styleguide', $current_styleguide)
			->with('pageTitle', 'Commit '.$current_styleguide->name.' Style Guide Changes')
			->with('submitButtonTitle', 'Commit')
			->with('cancelButtonLink', URL::to_action('styleguides@manage',array('version','list')));
    }
    
    public function post_commit($styleguide_name) {
		$current_styleguide = Styleguide::one($styleguide_name);
		$current_styleguide->version()->add(Input::get('version'));
		//print_r(StyleguideVersion::previous($current_styleguide->id));
		return 'done';
    }
 
}