<?php
error_reporting(E_ALL);
ini_set("display_errors", 1); 
if (isset($_FILES["image"]) && is_uploaded_file($_FILES["image"]["tmp_name"])) {
  //@todo Change base_dir!
  $base_dir = __DIR__.'/../../../';
  //@todo Change image location and naming (if needed)
  $image = '/img/uploads/'.$_FILES["image"]["name"];
  move_uploaded_file($_FILES["image"]["tmp_name"], $base_dir . $image);
?>
<input type="text" id="src" name="src" />
<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
<script>
  var ImageDialog = {
    init : function(ed) {
      ed.execCommand('mceInsertContent', false, 
        tinyMCEPopup.editor.dom.createHTML('img', {
          src : '<?php echo $image; ?>'
        })
      );
      
      tinyMCEPopup.editor.execCommand('mceRepaint');
      tinyMCEPopup.editor.focus();
      tinyMCEPopup.close();
    }
  };
  tinyMCEPopup.onInit.add(ImageDialog.init, ImageDialog);
</script>
<?php  } else {?>
<form name="iform" action="" method="post" enctype="multipart/form-data">
  <input id="file" accept="image/*" type="file" name="image" onchange="this.parentElement.submit()" />
</form>
<?php }?>