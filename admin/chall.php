<?php
function rmdir_recursive($dir)
{
    foreach (scandir($dir) as $file) {
        if ('.' === $file || '..' === $file)
            continue;
        if (is_dir("$dir/$file"))
            rmdir_recursive("$dir/$file");
        else
            unlink("$dir/$file");
    }
    rmdir($dir);
}

if (isset(($_FILES["zip_file"]["name"]))) {
    $filename = $_FILES["zip_file"]["name"];
    $source = $_FILES["zip_file"]["tmp_name"];
    $type = $_FILES["zip_file"]["type"];

    $name = explode(".", $filename);
    $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
    foreach ($accepted_types as $mime_type) {
        if ($mime_type == $type) {
            $okay = true;
            break;
        }
    }

    $continue = strtolower($name[1]) == 'zip' ? true : false;
    if (!$continue) {
        $message = "The file you are trying to upload is not a .zip file. Please try again.";
    }

    /* PHP current path */
    $path = dirname(__FILE__) . '/';  // absolute path to the directory where zipper.php is in
    $filenoext = basename($filename, '.zip');  // absolute path to the directory where zipper.php is in (lowercase)
    $filenoext = basename($filenoext, '.ZIP');  // absolute path to the directory where zipper.php is in (when uppercase)

    $targetdir = $path . $filenoext; // target directory
    $targetzip = $path . $filename; // target zip file

    /* create directory if not exists', otherwise overwrite */
    /* target directory is same as filename without extension */

    if (is_dir($targetdir))  rmdir_recursive($targetdir);


    mkdir($targetdir, 0777);


    /* here it is really happening */

    if (move_uploaded_file($source, $targetzip)) {
        $zip = new ZipArchive();
        $x = $zip->open($targetzip);  // open the zip file to extract
        if ($x === true) {
            $zip->extractTo($targetdir); // place in the directory with same name  
            $zip->close();

            unlink($targetzip);
            system('echo ' . $targetdir . ' > challname');
        }
        $message = "Your .zip file was uploaded and unpacked.";
        shell_exec('bash /var/www/html/docker.sh');
    } else {
        $message = "There was a problem with the upload. Please try again.";
    }
}
?>


<!doctype html>
<html>

    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
        <title>Chall</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
        <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
        <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
        <link rel="stylesheet" href="assets/css/Card-Group1-Shadow.css">
        <link rel="stylesheet" href="assets/css/Dark-NavBar-1.css">
        <link rel="stylesheet" href="assets/css/Dark-NavBar-2.css">
        <link rel="stylesheet" href="assets/css/Dark-NavBar.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <link rel="stylesheet" href="assets/css/Search-Input-responsive.css">
        <link rel="stylesheet" href="assets/css/styles.css">
    </head>

    <body>
        <nav class="navbar navbar-light navbar-expand-md sticky-top border rounded float-none navigation-clean-button"
            style="height: 80px;background-color: #37434d;color: #ffffff;">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.php"
                    style="filter: blur(0px);width: 182px;margin: -18px;">CTFD_like</a>

                <a class="d-xl-flex justify-content-xl-end" style="color: #ffffff;" href="../logout.php">
                    <i class="fa fa-sign-in" style="height: -5px;width: 13px;padding: 4px;"></i>
                    &nbsp; LogOut
                </a>
            </div>
        </nav>

        <center>
            <form enctype="multipart/form-data" method="post" action="">
                <label>Envoyez les fichiers à dockeriser (Le nom du fichier doit correspondre au nom du challenge) <br>
                    <input type="file" name="zip_file" /></label>
                <br />
                <input type="submit" name="submit" value="Upload" />
            </form>
        </center>

</html>
