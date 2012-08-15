<?php

class Tags extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'tags';
     
    public function inspirations(){
        return $this->has_many('InspirationTag','tag_id');
    }
    
    public function setTags($tagsString){
	    $tags=explode(" ", $tagsString);
	    $tag_ids=array();
	    foreach ($tags AS $tag{
	    	$new_tag = User::where_name($tag)->first();
	    	if (!$tag){
		    	$new_tag = new Tag;
		    	$new_tag->name = $tag;
		    	$new_tag->save();
	    	}
	    	tag_ids[]=$new_tag->id;
	    }
	    return $tag_ids;
    }
}