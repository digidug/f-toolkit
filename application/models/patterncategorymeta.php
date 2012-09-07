<?php

class PatternCategoryMeta extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'pattern_category_meta';
    
    public $validator;
    
    public $rules = array();
    
    public function patterns(){
        return $this->has_one('PatternCategory');
    }
    
    public function user(){
        return $this->belongs_to('User');
    }
    
}