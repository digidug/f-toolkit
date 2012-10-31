<?php

class StyleguideVersion extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'styleguide_versions';
    
    public function categories(){
        return $this->has_many('StyleguideVersionPatternCategories','styleguide_version_id')->order_by('sort')->get();
    }
    
    public function patterns(){
    	$categories=new array();
        foreach ($this->categories() AS $category){
	        $categories->patterns=Pattern::where_styleguide_version_pattern_category_id($category->id)->get();
        }
        return $categories;
    }

    
    static function latest($styleguide_id){
	    $styleguide=StyleguideVersion::first();
	    $styleguide->patterns();
	    return $styleguide();
    }
    
    static function version($styleguide_id,$version_name){
	    $styleguide=StyleguideVersion::where_id($styleguide_id)->where_name($version_name)->get();
	    $styleguide->patterns();
	    return $styleguide();
    }
    
    public function increaseVersion($type){
    	$bits=explode(".",$this->version);
	    switch ($type){
		    case "design": $bits[0]=$bits[0]++;
		    case "major": $bits[1]=$bits[1]++;
		    case "minor": $bits[2]=$bits[2]++;
	    }
	    $version=implode(".",$bits);
	    return $version;
    }
}