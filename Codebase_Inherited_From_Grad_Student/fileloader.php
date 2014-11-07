<?php 
if ($HTTP_POST_VARS['submit']) 
{ 
    if (!is_uploaded_file($HTTP_POST_FILES['file']['tmp_name'])) 
    { 
    $error = "You did not upload a file!"; 
    unlink($HTTP_POST_FILES['file']['tmp_name']); 
    // assign error message, remove uploaded file, redisplay form. 
    } 
    else 
    { 
    //A file was uploaded 
    $maxfilesize=300000; 
        if ($HTTP_POST_FILES['file']['size'] > $maxfilesize) 
        { 
            $error = "File is too large."; 
            unlink($HTTP_POST_FILES['file']['tmp_name']); 
            // assign error message, remove uploaded file, redisplay form. 
        } 
        else 
        { 
             //File has passed all validation, copy it to the final destination and remove the temporary file: 
             copy($HTTP_POST_FILES['file']['tmp_name'],$HTTP_POST_FILES['file']['name']); 
             unlink($HTTP_POST_FILES['file']['tmp_name']); 
         print "File has been successfully uploaded!"; 
             exit;    
            } 
      } 
} 
?> 

<html> 
<head></head> 
<body> 
<form action="<?=$PHP_SELF?>" method="post" enctype="multipart/form-data"> 
<br><br> 
Choose a file to upload:<br> 
<input type="file" name="file"><br> 
<input type="submit" name="submit" value="submit"> 
</form> 
</body> 
</html>