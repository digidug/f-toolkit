<?php

class Pattern extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'patterns';
    
    public $validator;
    
    public $rules = array(
        'name'     => 'required',
    );
    
    public function category(){
        return $this->belongs_to('PatternCategory', 'pattern_category_id')->order_by('pattern_categories.name', 'asc');
    }
    
    public function description(){
        return $this->has_one('PatternDescription');
    }
    
    public function html(){
        return $this->has_one('PatternHtml');
    }
    
    public function css(){
        return $this->has_one('PatternCss');
    }
    
    public function tags(){
        return $this->has_many('PatternTag');
    }
    
    public function tagsbyuser(){
        return $this->has_many('PatternTagbyuser');
    }
    
    public function add($data){
	    $new_pattern = array(
        	'name' => $data['name'],
        	'pattern_category_id' => $data['category'],
        );
        $this->validator = Validator::make($new_pattern, $this->rules);
	    if ( $this->validator->fails() ){
	    	return false;
	    }
	    $this->fill($new_pattern);
	    $this->active=1;
	    $this->save();

	    $this->description()->insert(array('content'=>$data['description']));
	    $this->html()->insert(array('content'=>$data['html']));
	    $this->css()->insert(array('content'=>$data['css']));
	    
	    return true;
    }
    
    public function edit($data){
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
	    /*
	    $this->html()->save(array('content'=>$data['html']));
	    $this->css()->save(array('content'=>$data['css']));
	    */
	    
	    return true;
    }
    
    public function deactivate(){
	    $this->active=0;
	    $this->save();
    }
    
    public function activate(){
	    $this->active=1;
	    $this->save();
    }

}