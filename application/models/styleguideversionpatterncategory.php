<?php

class StyleguideVersionPatternCategory extends Eloquent {
    
    public static $timestamps = false;
    public static $table = 'styleguide_version_pattern_categories';
    
    public function name(){
	    $cat=PatternCategory::where_id($this->pattern_category_id)->first();
	    return $cat->name;
    }
    
    public function category(){
	    return PatternCategory::where_id($this->pattern_category_id)->first();
    }
    public function patterns(){
        return $this->has_many('StyleguideVersionPattern','styleguide_version_pattern_category_id')->order_by('sort','desc');
    }
    
    public function add($styleguide_id,$pattern_category_id){
	    $this->styleguide_id=$styleguide_id;
	    $this->pattern_category_id=$pattern_category_id;
	    $this->save();
    }
}