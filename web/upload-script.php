<?php
//The folder that our file should be moved to
//once it is uploaded
$uploadDirectory = '/var/www/html/uploads/';

//If our uploaded file exists.
if(isset($_FILES['user_file'])){
    
    //The extensions that are allowed to be uploaded.
    $allowedExtensions = array(
        'zip'
    );
    
    //Get our file details from the $_FILES array.
    $file = $_FILES['user_file'];
    
    //The name of the file that has been uploaded.
    //Example: image.png or data.csv
    //This is what the user named it.
    $name = $file['name'];
    
    //Get the extension of the file.
    $extension = pathinfo($name, PATHINFO_EXTENSION);
    //Force the file extension into a lower case.
    $extension = strtolower($extension);
    
    //If it isn't a valid extension.
    if(!in_array($extension, $allowedExtensions)){
        //Print out a message to the user.
        echo 'That extension is not allowed!';
    } else{
        //If it is a valid extension, move it to our uploads directory.
        
        //The current / temporary location of the uploaded file.
        //We will need to move it from here to our uploads directory.
        $tmpLocation = $file['tmp_name'];

        //The location that we want to move the uploaded file to.
        $newLocation = $uploadDirectory . $name;

        //Move the file using PHP's move_uploaded_file function.
        $move = move_uploaded_file($tmpLocation, $newLocation);
  
    }    
    header('Location: index.php');
    exit;

}
?>