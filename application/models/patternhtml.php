<?php

class PatternHtml extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'pattern_html';
     
    public function patterns(){
        return $this->belongs_to('Pattern');
    }
}