<?php

class PatternCss extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'pattern_css';
     
    public function patterns(){
        return $this->belongs_to('Pattern');
    }
}