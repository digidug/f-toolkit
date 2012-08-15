<?php

class PatternDescription extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'pattern_descriptions';
     
    public function patterns(){
        return $this->belongs_to('Pattern','pattern_id');
    }
}