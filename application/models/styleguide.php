<?php

class Styleguide extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'styleguides';
    
    public $validator;
    
    public $rules = array(
        'name'     => 'required',
    );
    
    public function categories(){
        return $this->has_many('PatternCategory','styleguide_id')->order_by('sort')->get();
    }
    
    public function version($version_name=null){
	    return StyleguideVersion::latest($this->id);
    }
    
    static function all(){
	    return Styleguide::get()->order_by('guid');
    }
    
    static function one($name){
        return Styleguide::where_name($name)->first();
    }
    
    static function category($styleguide_id,$name){
        return PatternCategory::where_styleguide_id($styleguide_id)->where_name($name)->first();
    }
    
    static function active(){
	    return Styleguide::where_active('1')->order_by('guid')->get();
    }
    
    static function inactive(){
	    return Styleguide::where_active('0')->order_by('guid')->get();
    }

}