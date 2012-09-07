<?php

class PatternMeta extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'pattern_meta';
    
    public $validator;
    
    public $rules = array();
    
    public function pattern(){
        return $this->has_one('Pattern');
    }
    
    public function user(){
        return $this->belongs_to('User');
    }
    
}