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
    
    public function meta(){
        return $this->has_one('PatternCategoryMeta','pattern_category_id')->order_by('created_at','desc');
    }
    
    public function history(){
        return $this->has_many('PatternCategoryMeta','pattern_category_id')->order_by('created_at','desc');
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
	    
	    $this->meta()->insert(array('lead'=>$data['lead'],'description'=>$data['description'],'css'=>$data['css'],'javascript'=>$data['javascript']));
	    
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
	    $this->save();
	    
	    $this->meta()->insert(array('lead'=>$data['lead'],'description'=>$data['description'],'css'=>$data['css'],'javascript'=>$data['javascript']));
	    
	    if (isset($data['activePatterns'])){
		    parse_str($data['activePatterns'],$activePatterns);
		    if (isset($activePatterns['pattern'])){
			    Pattern::order($this->id,$activePatterns['pattern']);
			}
		}
		if (isset($data['inactivePatterns'])){
	    	parse_str($data['inactivePatterns'],$inactivePatterns);
	    	if (isset($inactivePatterns['pattern'])){
		    	Pattern::bulkDeactivate($inactivePatterns['pattern']);
		    }
	    }
	    
	    return true;
    }
    
    public function activePatterns(){
	    return true;
    }
    
    public function inactivePatterns(){
	    return true;
    }
}