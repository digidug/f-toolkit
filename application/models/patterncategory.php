<?php

class PatternCategory extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'pattern_categories';
    
    public $validator;
    
    public $rules = array(
        'name'     => 'required|unique:pattern_categories,name,',
    );
    
    public function patterns(){
        return $this->has_many('Pattern','pattern_category_id');
    }
    
    public function add($data){
	    $new_category = array(
        	'name' => $data['name']
        );
        $this->validator = Validator::make($new_category, $this->rules);
	    if ( $this->validator->fails() ){
	    	return false;
	    }
	    $this->fill($new_category);
	    $this->active=1;
	    $this->save();
	    
	    return true;
    }
    
    public function edit($data){
		$edit_category = array(
	    	'name'      => $data['name']
	    );
	    $rules=$this->rules;
	    $rules['name']=$rules['name'].$this->id;
	    $this->validator = Validator::make($edit_category, $rules);
	    if ( $this->validator->fails() ){
	    	return false;
	    }
	    $this->name=$data['name'];    
	    $this->lead=$data['lead'];
	    $this->description=$data['description'];
	    $this->css=$data['css'];

	    $this->save();
	    
	    if (isset($data['activePatterns'])){
		    parse_str($data['activePatterns'],$activePatterns);
		    parse_str($data['inactivePatterns'],$inactivePatterns);
		}
		/*
	    Pattern::bulk_deactivate(unserialize($data['activePatterns']));
	    Pattern::order($this->id,unserialize($data['inactivePatterns']));
	    */
	    return true;
    }
    
    public function activePatterns(){
	    return true;
    }
    
    public function inactivePatterns(){
	    return true;
    }
}