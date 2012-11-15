<?php

class StyleguideVersion extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'styleguide_versions';
        
    public function styleguide(){
        return Styleguide::where_id($this->styleguide_id)->first();
    }
    
    public function categories(){
    	return $categories=$this->has_many('StyleguideVersionPatternCategory','styleguide_version_id')->get();
    	
    	//print_r($categories);
    	/*
    	return DB::table('styleguide_version_pattern_categories')
	    	->join('pattern_categories', 'styleguide_version_pattern_categories.pattern_category_id', '=', 'pattern_categories.id')
	    	->where('styleguide_version_pattern_categories.styleguide_version_id', '=', $this->id)
	    	->where('pattern_categories.styleguide_id', '=', $this->styleguide_id)
	    	->get();
	    */
    }
    
    public function category($category_name){
    	//return $categories=$this->has_one('StyleguideVersionPatternCategory','styleguide_version_id')->get();
    	$category= DB::table('pattern_categories')
	    	->join('styleguide_version_pattern_categories', 'styleguide_version_pattern_categories.pattern_category_id', '=', 'pattern_categories.id')
	    	->where('pattern_categories.name', '=', $category_name)
	    	->first();
	    return PatternCategory::find($category->pattern_category_id);
	    
    }
    
    public function patterns(){
        //return Pattern::wherstyleguide_version_id')->get();
    }
    
    public function categories_added(){
	    return PatternCategory::where_styleguide_id($this->styleguide_id)->where_state(7)->get();
    }
    
    public function categories_edited(){
	    return PatternCategory::where_styleguide_id($this->styleguide_id)->where_state(8)->get();
    }
    
    public function categories_purged(){
	    return PatternCategory::where_styleguide_id($this->styleguide_id)->where_state(9)->get();
    }
    
    public function patterns_added(){
	    return DB::table('pattern_categories')
	    	->join('patterns', 'patterns.pattern_category_id', '=', 'pattern_categories.id')
	    	->where('pattern_categories.styleguide_id', '=', $this->styleguide_id)
	    	->where('patterns.state', '=', '7')
	    	->get();
    }
    
    public function patterns_edited(){
	    return DB::table('pattern_categories')
	    	->join('patterns', 'patterns.pattern_category_id', '=', 'pattern_categories.id')
	    	->where('pattern_categories.styleguide_id', '=', $this->styleguide_id)
	    	->where('patterns.state', '=', '8')
	    	->get();
    }
    
    public function patterns_purged(){
    	return DB::table('pattern_categories')
	    	->join('patterns', 'patterns.pattern_category_id', '=', 'pattern_categories.id')
	    	->where('pattern_categories.styleguide_id', '=', $this->styleguide_id)
	    	->where('patterns.state', '=', '9')
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
    	
    	//patterns
    	foreach ($this->patterns_added() AS $pattern){
    		$pattern=Pattern::find($pattern->id);
	    	$pattern->state=0;
	    	$pattern->active=1;
	    	$pattern->save();
    	}
    	foreach ($this->patterns_edited() AS $pattern){
    		$pattern=Pattern::find($pattern->id);
	    	$pattern->state=0;
	    	$pattern->active=1;
	    	$pattern->save();
    	}
    	foreach ($this->patterns_purged() AS $pattern){
    		$pattern=Pattern::find($pattern->id);
	    	$pattern->state=0;
	    	$pattern->active=0;
	    	$pattern->save();
    	}
    	
    	$categories=PatternCategory::where_styleguide_id($this->styleguide_id)->where_active(1)->get();
    	
    	foreach($categories AS $category){
	    	$versionCategory=StyleguideVersionPatternCategory::create(
	    		array(
	    			'styleguide_version_id'=>$styleguide_version->id,
	    			'pattern_category_id'=>$category->id,
	    			'pattern_category_meta_id'=>$category->meta()->first()->id,
	    			'sort'=>$category->sort
	    		)
	    	);
	    	
	    	$patterns=DB::table('pattern_categories')
		    	->join('patterns', 'patterns.pattern_category_id', '=', 'pattern_categories.id')
		    	->where('pattern_categories.styleguide_id', '=', $this->styleguide_id)
		    	->where('patterns.pattern_category_id', '=', $category->id)
		    	->where('patterns.active', '=', '1')
		    	->get();	
	    	foreach($patterns AS $pattern){
	    		$pattern=Pattern::find($pattern->id);
		    	$versionPattern=new StyleguideVersionPattern();
		    	$versionPattern->styleguide_version_id=$styleguide_version->id;
		    	$versionPattern->pattern_id=$pattern->id;
		    	$versionPattern->pattern_meta_id=$pattern->meta()->first()->id;
		    	$versionPattern->styleguide_version_pattern_category_id=$versionCategory->id;
		    	$versionPattern->sort=$pattern->sort;
		    	$versionPattern->save();
	    	}
    	}
    }
    
    public function nextVersion($type){
    	$bits=explode(".",$this->version);
	    switch ($type){
		    case "design":  $bits[0]++;
		    				$bits[1]=0;
		    				$bits[2]=0;
		    				break;
		    				
		    case "major":   $bits[1]++;
		    				$bits[2]=0;
		    				break;
		    				
		    case "minor":   $bits[2]++;
		    				break;
	    }
	    $version=implode(".",$bits);
	    return $version;
    }

    static function latest($styleguide_id){
	    $styleguide=self::where_styleguide_id($styleguide_id)->order_by('id','desc')->first();
	    return $styleguide;
    }
    
    static function previous($styleguide_id){
	    $styleguide=self::where_styleguide_id($styleguide_id)->get();
	    if (!isset($styleguide[1])) $styleguide[1]=false;
	    
	    return $styleguide[1];
    }
    
    static function version($styleguide_id,$version){
	    $styleguide=self::where_styleguide_id($styleguide_id)->where_version($version)->order_by('id','desc')->first();
	    return $styleguide;
    }
}