<?php

class PatternCategory extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'pattern_categories';
    
    public $validator;
    
    public $rules = array(
        'name'     => 'required|unique:pattern_categories,name',
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
}