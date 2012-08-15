<?php

class Inspirations_Controller extends Base_Controller {

	public $restful = true;
	
	public function get_index() {
		return View::make('pages.inspirations');
    }
    
    public function post_url(){
	    return json_encode($this->fetchURL(Input::get('url')));
		
    }
    
	function CURL($url){
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	
	    $data = curl_exec($ch);
		$info = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
		
		//checking mime types
		if(strstr($info,'text/html')) {
			curl_close($ch);
	    	return $data;
		} else {
			return false;
		}
	}

	function fetchURL($url){
		/*
		$html=$this->CURL($url);
		if (!$html) return false;
		$doc = new DOMDocument();
		@$doc->loadHTML($html);
		$nodes = $doc->getElementsByTagName('title');

		//get and display what you need:
		$title = trim($nodes->item(0)->nodeValue);
		$metas = $doc->getElementsByTagName('meta');
		$description="";
		
		for ($i = 0; $i < $metas->length; $i++){
			$meta = $metas->item($i);
			if($meta->getAttribute('name') == 'description'){
				$description = trim($meta->getAttribute('content'));
				break;
			}
		}
		*/
		$html=$this->CURL("https://developers.facebook.com/tools/debug/og/object?q=".$url);
		$data=explode('http://graph.facebook.com/', $html);
		$data=explode('"',$data[1]);
		$id=$data[0];
		$data=json_decode(file_get_contents('https://graph.facebook.com/'.$id));
		$title=$data->title;
		$description=$data->description;
		$images_urls[0]="http://api.snapito.com/web/e58ef146f5393b4e3e6f244ae153c358f3cca882/full?url=".$url;

		
		/*
		$config = array('api_key' => '','service_url'=>'http://detroitdigitalrevolution.com/thumbalizrproxy.php');
		$image = new thumbalizrRequest($config);
		$image->request($url);
		$images_urls[0]='/tk/thumbnails/'.$image->filename;
		*/
		/*
		$nodes = $doc->getElementsByTagName('body');
		$body = $nodes->item(0)->nodeValue;
		$image_regex = '/<img[^>]*'.'src=[\"|\'](.*)[\"|\']/Ui';
		preg_match_all($image_regex, $html, $images, PREG_PATTERN_ORDER);
		
		$images_urls=array();
		foreach ($images[1] AS $src) {
			if (substr($src, 0, 7) == 'http://' || substr($src, 0, 8) == 'https://') {
				$imgSize = getimagesize(str_replace(" ", "%20", $src));
				if ($imgSize[0] >= 140 && $imgSize[1] >= 100) {
					$images_urls[] = $src;
				}
			}
		}
		*/
		
		return array('title'=>$title,'description'=>$description,'images'=>$images_urls);
	}
}