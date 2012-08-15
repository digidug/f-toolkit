<?php

class InspirationTags extends Eloquent {
    
    public static $timestamps = true;
    public static $table = 'inspiration_tags';
     
    public function tags(){
        return $this->has_many('Tag','tag_id');
    }
    
    public function setTags($tags){
    	$tag_ids=Tag::setTags($tags);
    	
        $user->roles()->sync($tag_ids);
    }

}