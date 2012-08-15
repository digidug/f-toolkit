<?php

class Inspiration extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'inspirations';

    public $rules = array(
        'name'     => 'required',
    );
    
    public function tags(){
        return $this->has_many('InspirationTag');
    }
    
    public function users(){
        return $this->has_many('User');
    }
        
    public function add($data){
	    $new_pattern = array(
        	'name' => $data['name'],
        	'description' => $data['description'],
        	'image' => $data['image'],
        	'url' => $data['url'],
        	'user_id' => Auth::User->id,
        );
        $this->validator = Validator::make($new_pattern, $this->rules);
	    if ( $this->validator->fails() ){
	    	return false;
	    }
	    $this->fill($new_pattern);
	    $this->save();

	    $this->tags()->setTags($data['tags']);
	    
	    return true;
    }
    /*
    public function edit($pattern_id,$data){
		$edit_pattern = array(
	    	'name'      => $data['name'],
	        'pattern_category_id'      => $data['category']
	    );
	    $rules=$this->rules;
	    $this->validator = Validator::make($edit_pattern, $rules);
	    if ( $this->validator->fails() ){
	    	return false;
	    }
	    $this->name=$data['name'];
	    $this->pattern_category_id=$data['category'];	    
	    $this->description->content=$data['description'];
	    $this->html->content=$data['html'];
	    $this->css->content=$data['css'];
	    $this->save();
	    
	    $this->description->save();
	    $this->html->save();
	    $this->css->save();
	    
	    return true;
    }
*/
}