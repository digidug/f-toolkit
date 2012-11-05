<?php

class StyleguideVersion extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'styleguide_versions';
    
    public function categories(){
        return $this->has_many('StyleguideVersionPatternCategory','styleguide_version_id')->get();
    }
    
    public function categories_added(){
	    return PatternCategory::where_styleguide_id($this->styleguide_id)->where_state(9)->get();
    }
    
    public function categories_edited(){
	    return PatternCategory::where_styleguide_id($this->styleguide_id)->where_state(8)->get();
    }
    
    public function categories_purged(){
	    return PatternCategory::where_styleguide_id($this->styleguide_id)->where_state(7)->get();
    }
    
    public function patterns_added(){
	    return DB::table('patterns')
	    	->join('pattern_categories', 'pattern_categories.id', '=', 'patterns.pattern_category_id')
	    	->where('pattern_categories.styleguide_id', '=', $this->styleguide_id)
	    	->where('patterns.state', '=', '9')
	    	->get();
    }
    
    public function patterns_edited(){
	    return DB::table('patterns')
	    	->join('pattern_categories', 'pattern_categories.id', '=', 'patterns.pattern_category_id')
	    	->where('pattern_categories.styleguide_id', '=', $this->styleguide_id)
	    	->where('patterns.state', '=', '8')
	    	->get();
    }
    
    public function patterns_purged(){
    	return DB::table('patterns')
	    	->join('pattern_categories', 'pattern_categories.id', '=', 'patterns.pattern_category_id')
	    	->where('pattern_categories.styleguide_id', '=', $this->styleguide_id)
	    	->where('patterns.state', '=', '7')
	    	->get();
    }
    
    public function add($version){
    	$styleguide_version=new StyleguideVersion();
    	$styleguide_version->styleguide_id=$this->styleguide_id;
    	$styleguide_version->version=$version;
    	$styleguide_version->save();
    	
    	//categories
    	foreach ($this->categories_added() AS $category){
	    	$category->state=0;
	    	$category->active=1;
	    	$category->save();
    	}
    	foreach ($this->categories_edited() AS $category){
	    	$category->state=0;
	    	$category->active=1;
	    	$category->save();
    	}
    	foreach ($this->categories_purged() AS $category){
	    	$category->state=0;
	    	$category->active=0;
	    	$category->save();
    	}
    	$categories=PatternCategories::where_styleguide_id($this->styleguide_id)->where_active(1)->get();
    	foreach($categories AS $category){
	    	$versionCategory=new StyleguideVersionPatternCategory();
	    	$versionCategory->styleguide_version_id=$styleguide_version->id;
	    	$versionCategory->pattern_category_meta_id=$category->meta()->first()->id;
	    	$versionCategory->save();
    	}
    	
    	//patterns
    	foreach ($this->patterns_added() AS $pattern){
	    	$pattern->state=0;
	    	$pattern->active=1;
	    	$pattern->save();
    	}
    	foreach ($this->patterns_edited() AS $pattern){
	    	$pattern->state=0;
	    	$pattern->active=1;
	    	$pattern->save();
    	}
    	foreach ($this->patterns_purged() AS $pattern){
	    	$pattern->state=0;
	    	$pattern->active=0;
	    	$pattern->save();
    	}
    	$patterns=DB::table('patterns')
	    	->join('pattern_categories', 'pattern_categories.id', '=', 'patterns.pattern_category_id')
	    	->where('pattern_categories.styleguide_id', '=', $this->styleguide_id)
	    	->where('patterns.active', '=', '1')
	    	->get();
	    	
    	foreach($patterns AS $pattern){
	    	$versionPattern=new StyleguideVersionPattern();
	    	$versionPattern->styleguide_version_id=$styleguide_version->id;
	    	$versionPattern->pattern_meta_id=$pattern->meta()->first()->id;
	    	$versionPattern->save();
    	}
    }
    
    public function nextVersion($type){
    	$bits=explode(".",$this->version);
	    switch ($type){
		    case "design": $bits[0]++;break;
		    case "major": $bits[1]++;break;
		    case "minor": $bits[2]++;break;
	    }
	    $version=implode(".",$bits);
	    return $version;
    }

    static function latest($styleguide_id){
	    $styleguide=self::where_styleguide_id($styleguide_id)->first();
	    return $styleguide;
    }
    
    static function previous($styleguide_id){
	    $styleguide=self::where_styleguide_id($styleguide_id,2)->get();
	    if (!isset($styleguide[1])) $styleguide[1]=false;
	    
	    return $styleguide[1];
    }
    
    static function version($styleguide_id,$version_name){
	    $styleguide=self::where_styleguide_id($styleguide_id)->where_name($version_name)->get();
	    
	    return $styleguide;
    }
}