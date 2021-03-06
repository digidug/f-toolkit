<?php

class Pattern extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'patterns';
    
    public $validator;
    
    public static $states = array(
    	0	=>	'Unchanged',
    	1	=>	'New',
    	2	=>	'Edited',
    	3	=>	'Deleted',
    	4	=>	'New awaiting approval',
    	5	=>	'Edited Awaiting approval',
    	6	=>	'Deleted awaiting approval',
    	7	=>	'Approved addition',
    	8	=>	'Approved changes',
    	9	=>	'Approved deleted'
    );
    
    public $rules = array(
        'name'     => 'required',
    );
    
    public function category(){
        return $this->belongs_to('PatternCategory', 'pattern_category_id');
    }
    
    public function version_meta(){
        return PatternMeta::where('id','=',$this->pattern_meta_id);
    }
    
    public function meta(){
        return $this->has_one('PatternMeta')->order_by('created_at','desc');
    }
    
    public function styleguide(){
	    return Styleguide::find($this->category->styleguide_id);
    }
    
    public function history(){
        return $this->has_many('PatternMeta','pattern_id')->order_by('created_at','desc');
    }
    
    public function revisions(){
    	$updated_at=$this->category()->first()->styleguide()->first()->updated_at;
        return $this->has_many('PatternMeta','pattern_id')->order_by('created_at','desc')->where('created_at','>',$updated_at);
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
	    $this->state=1;
	    $this->save();
	    
	    $this->meta()->insert(array('url'=>$data['url'],'description'=>$data['description'],'html'=>$data['html'],'css'=>$data['css']));
	    
	    return true;
    }
    
    public function edit($data){
		$edit_pattern = array(
	    	'name'      => $data['name']
	    );
	    $rules=$this->rules;
	    $this->validator = Validator::make($edit_pattern, $rules);
	    if ( $this->validator->fails() ){
	    	return false;
	    }
	    $this->name=$data['name'];
	    $this->pattern_category_id=$data['category'];
	    if ($this->state==0) $this->state=2;
	    //$this->published=$data['published'];	
	    $this->save();
	    
	    $this->meta()->insert(array('url'=>$data['url'],'description'=>$data['description'],'html'=>$data['html'],'css'=>$data['css']));
	    return true;
    }
    
    static function bulkDeactivate($pattern_ids){
	    foreach ($pattern_ids AS $pattern_id){
		    $pattern=Pattern::find($pattern_id);
		    $pattern->deactivate();
	    }
	    
	    return true;
    }
    
    static function order($pattern_category_id,$pattern_ids){
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