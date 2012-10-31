<div id="images">
	@foreach($images AS $image)
		<p><img src="/img/uploads/styleguides/{{$category_id}}/{{basename($image)}}"></p>
	@endforeach
</div>
<style>
	#images p {
        float: left;
        padding: 3px;
        margin: 3px;
        cursor: pointer;
    }
    #images img{
	    max-width:100%;
    }
</style>
<script>
	(function() {
	    var Dom = YAHOO.util.Dom,
	        Event = YAHOO.util.Event,
	        myEditor = YAHOO.widget.EditorInfo.getEditorById('editor-description');
	        //Get a reference to the editor on the other page
	    
	    //Add a listener to the parent of the images
	    Event.on('images', 'click', function(ev) {
	        var tar = Event.getTarget(ev);
	        //Check to see if we clicked on an image
	        if (tar && tar.tagName && (tar.tagName.toLowerCase() == 'img')) {
	            //Focus the editor's window
	            myEditor._focusWindow();
	            //Fire the execCommand for insertimage
	            myEditor.execCommand('insertimage', tar.getAttribute('src', 2));
	            
	            myEditor.cleanHTML();
	            
	            $('.close').click();
	        }
	    });
	    //Internet Explorer will throw this window to the back, this brings it to the front on load
	    Event.on(window, 'load', function() {
	        window.focus();
	    });    
	})();
	
	function addImage(path){
		$('#images').prepend('<p><img src="'+path+'"></p>');
	}
</script>