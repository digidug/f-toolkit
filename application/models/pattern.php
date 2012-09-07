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
    
    public function meta(){
        return $this->has_one('PatternMeta')->order_by('created_at','desc');
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
	    
	    $this->meta()->insert(array('description'=>$data['description'],'html'=>$data['html'],'css'=>$data['css']));
	    
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
	    $this->published=$data['published'];	
	    $this->save();
	    
	    $this->meta()->insert(array('description'=>$data['description'],'html'=>$data['html'],'css'=>$data['css']));
	    
	    return true;
    }
    
    public static function bulkDeactivate($pattern_ids){
	    foreach ($pattern_ids AS $pattern_id){
		    $pattern=Pattern::find($pattern_id);
		    $pattern->deactivate();
	    }
	    
	    return true;
    }
    
    public static function order($pattern_category_id,$pattern_ids){
    	$order=1;
	    foreach ($pattern_ids AS $pattern_id){
	    	$pattern=Pattern::find($pattern_id);
		    $pattern->sort=$order;
		    $pattern->pattern_category_id=$pattern_category_id;
		    $pattern->activate();
		    $order++;
	    }
	    
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