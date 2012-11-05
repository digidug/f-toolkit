<?php

class StyleguideVersionPatternCategory extends Eloquent {
    
    public static $table = 'styleguide_version_pattern_categories';
        
    public function patterns(){
        return $this->has_many('StyleguideVersionPattern','styleguide_version_pattern_category_id');
    }
    
    public function add($styleguide_id,$pattern_category_id){
	    $this->styleguide_id=$styleguide_id;
	    $this->pattern_category_id=$pattern_category_id;
	    $this->save();
    }
}