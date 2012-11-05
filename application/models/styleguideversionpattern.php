<?php

class StyleguideVersionPattern extends Eloquent {
    
    public static $table = 'styleguide_version_patterns';

    
    public function category(){
        return $this->has_one('StyleguideVersionPatternCategory','styleguide_version_pattern_category_id');
    }
    
}