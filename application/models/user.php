<?php

class User extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'users';
    
    public $rules = array(
        'username'     => 'required|alpha_dash|unique:users,username,',
        'email'      => 'required|email|unique:users,email,',
        'password' => 'required|alpha_dash|min:5|max:15|confirmed'
    );
    
    public $validator;
     
    public function roles(){
        return $this->has_many_and_belongs_to('Role', 'role_user');
    }
    
    public function add($data){
	    $new_user = array(
        	'username'     => $data['username'],
        	'email'      => $data['email'],
        	'password' => $data['password'],
        	'password_confirmation' => $data['password_confirmation']
        );
        $this->validator = Validator::make($new_user, $this->rules);
	    if ( $this->validator->fails() ){
	    	return false;
	    }
	    unset($new_user['password_confirmation']);
	    $this->fill($new_user);
	    $this->password=Hash::make($this->password);
	    $this->save();
	    
	    $this->roles()->sync(isset($data['roles'])?$data['roles']:array());
	    return true;
    }
    
    public function edit($user_id,$data){
		$edit_user = array(
	    	'username'      => $data['username'],
	        'email'      => $data['email']
	    );
	    $rules=$this->rules;
	    $rules['username']=$rules['username'].$user_id;
	    $rules['email']=$rules['email'].$user_id;
	    if ($data['password']!=='') {
		    $edit_user['password'] = $data['password'];
	        $edit_user['password_confirmation'] = $data['password_confirmation'];
	    }else unset($rules['password']);
	    $this->validator = Validator::make($edit_user, $rules);
	    if ( $this->validator->fails() ){
	    	return false;
	    }
	    unset($edit_user['password_confirmation']);
	    $this->username=$edit_user['username'];
	    $this->email=$edit_user['email'];
	    if($data['password']!==''){
	    	$this->password=Hash::make($edit_user['password']);
	    }
	    $this->save();
	    
	    if (Auth::user()->hasRole('Administrator')){
		    $this->roles()->sync(isset($data['roles'])?$data['roles']:array());
		}
	    return true;
    }
    
    public function hasRole($role){
	    @$roles=Auth::user()->roles()->order_by('name', 'asc')->lists('name', 'id');
	    return @array_search($role, $roles);
    }
    
}