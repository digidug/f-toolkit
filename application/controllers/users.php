<?php

class Users_Controller extends Base_Controller {

	public $restful = true;
	
	public function get_index() {
		$users = User::all();
		return View::make('pages.users')
		    ->with('users', $users);
    }
    
    public function get_user($user_id) {
	    $user = User::find($user_id);
	    return View::make('pages.user')
    		->with(array('user'=>$user,'roles'=>$user->roles));
    }
        
    public function get_create(){
    	$role=Role::order_by('name', 'asc')->lists('name', 'id');
    	$user = new User();
    	if (Input::old()){
			$user->username=Input::old('username');
			$user->email=Input::old('email');
			$user->roles=Input::old('roles');
		}
    	return View::make('forms.user-form')
    		->with(array(
    			'roles'=>$role,
    			'user'=>$user,
    			'pageTitle'=>'Create New User',
    			'submitButtonTitle'=>'Save',
    			'cancelButtonLink'=>URL::to_action('users@index')
    			));
    }
    
    public function post_create(){
        $user = new User(); 
        if (!$user->add(Input::get())){
	    	return Redirect::to('users/create')
        		->with_errors($user->validator)
        		->with_input();
        } else return Redirect::to_action('users@user',array($user->id));
    }
    
    public function get_edit($user_id){
    	$role=Role::order_by('name', 'asc')->lists('name', 'id');
    	$user=User::find($user_id);
		$user->roles=@$user->roles()->lists('name', 'id');
		
		if (Input::old()){
			$user->username=Input::old('username');
			$user->email=Input::old('email');
			$user->roles=Input::old('roles');
		}
    	return View::make('forms.user-form')
    		->with(array(
    			'roles'=>$role,
    			'user'=>$user,
    			'pageTitle'=>'Edit User',
    			'submitButtonTitle'=>'Save',
    			'cancelButtonLink'=>URL::to_action('users@user',array($user_id))
    			));
    }
    
    public function post_edit($user_id){
        $user = User::find($user_id);
        if (!$user->edit($user_id,Input::get())){
	    	return Redirect::to_action('users/edit',array($user_id))
        		->with_errors($user->validator)
        		->with_input();
        } else return Redirect::to_action('users@user',array($user_id));
    }

}