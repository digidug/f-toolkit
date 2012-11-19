<?php

class Styleguide extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'styleguides';
    
    public $validator,$version,$edit_mode;
    
    public $rules = array(
        'name'     => 'required|alpha_dash|unique:styleguides,name,',
        'guid'      => 'required|numeric|unique:styleguides,guid,'
    );

    
    public function categories(){
    	//print_r(StyleguideVersionPatternCategory::where_styleguide_version_id($this->version()->id)->get());
    	if ($this->version!=null) return $this->version_categories();
    	else return $this->active_categories();
    }
    
    public function version_categories(){
	    $ids=array();
    	$result=StyleguideVersionPatternCategory::where_styleguide_version_id($this->version()->id)->get();
    	foreach ($result AS $version_category){
    		$category=PatternCategory::find($version_category->pattern_category_id);
    		$category->version_id=$this->version()->id;
    		$category->styleguide_version_pattern_category_id=$version_category->id;
    		if (count($category->version_patterns())>0){
    			$ids[]=$version_category->pattern_category_id;
    		}
    	}
    	if (count($ids)>0){
	        $pattern_categories=PatternCategory::where_in('id',$ids)->get();
	    }else{
		    $pattern_categories=array();    
	    }
        foreach ($pattern_categories AS $id=>$pattern_category){
	        $pattern_categories[$id]->version_id=$this->version()->id;
        }
        
        return $pattern_categories;
    }
    
    public function active_categories(){
	    return PatternCategory::where_styleguide_id($this->id)->get();
    }
    
    public function setVersion($version){
    	$this->version=$version;
    }
    
    public function version(){
    	
    	if ($this->version==null){
	    	$styleguide_version=StyleguideVersion::latest($this->id);
	    }else{
	    	$styleguide_version=StyleguideVersion::version($this->id,$this->version);
	    }
	    
	    return $styleguide_version;
    }
    
    static function all(){
	    return Styleguide::get()->order_by('guid');
    }
    
    static function one($name){
        return Styleguide::where_name($name)->first();
    }
    
    public function category($name){
    	if ($this->version!=null) return $this->active_category($name);
    	else return $this->active_category($name);
    }
    
    public function version_category($name){
    	$result=StyleguideVersionPatternCategory::select(array('styleguide_version_pattern_categories.id AS styleguide_version_pattern_category_id','pattern_categories.id AS pattern_category_id','styleguide_version_pattern_categories.pattern_category_meta_id'))
    		->where('styleguide_version_id','=',$this->version()->id)
    		->join('pattern_categories', 'pattern_categories.id', '=', 'styleguide_version_pattern_categories.pattern_category_id')
    		->where('pattern_categories.name','=',$name)
    		->first();
        
        $pattern_category=PatternCategory::where_id($result->pattern_category_id)->first();
        $pattern_category->version_id=$this->version()->id;
        $pattern_category->styleguide_version_pattern_category_id=$result->styleguide_version_pattern_category_id;
        $pattern_category->pattern_category_meta_id=$result->pattern_category_meta_id;
        return $pattern_category;
    }
    
    public function active_category($name){
        $pattern_category=PatternCategory::where_styleguide_id($this->id)->where_name($name)->first();
        return $pattern_category;
    }

    
    static function active(){
	    return Styleguide::where_active('1')->order_by('guid')->get();
    }
    
    static function inactive(){
	    return Styleguide::where_active('0')->order_by('guid')->get();
    }
    
    public function category_name(){
    	//acquire url knowledge
		$route=Request::route();
        $aux=explode("@",$route->action['uses']);
        $controller=array_shift($aux);
        $action=array_shift($route->parameters);
        $parameters=$route->parameters;
		
	    if (isset($parameters[1])){
	        return $parameters[1];
        }else return false;
    }
    
    public function add($data){
	    $new_styleguide = array(
        	'name' => $data['name'],
        	'guid' => $data['guid'],
        );
        $this->validator = Validator::make($new_styleguide, $this->rules);
	    if ( $this->validator->fails() ){
	    	return false;
	    }
	    $this->fill($new_styleguide);
	    $this->save();
	    
	    return true;
    }
    
    public function edit($styleguide_id,$data){
		$edit_styleguide = array(
	    	'name'      => $data['name'],
	    	'guid'		=> $data['guid']
	    );
	    $rules=$this->rules;
	    $rules['name']=$rules['name'].$styleguide_id;
	    $rules['guid']=$rules['guid'].$styleguide_id;
	    $this->validator = Validator::make($edit_styleguide, $rules);
	    if ( $this->validator->fails() ){
	    	return false;
	    }
	    $this->fill($edit_styleguide);
	    $this->save();
	    
	    return true;
    }

}