<?php

require_once(__DIR__ . '/../page_templates/DatabaseConnectionPage.php');

/**
 * Class UploadReferencePage
 */
class UploadReferencePage extends DatabaseConnectionPage {

    const FILE_POSTVAR = 'referenceFile';
    const UPLOAD_DIR = "/var/www/html/drosoReference/";


    /**
     * @param $db_conn
     */
    function upload_file($db_conn)
    {
        $version = $_POST['version'];
        $userid = $_SESSION['userid'];
        $date=date("m/d/y");

        $uploadedFileName = $_FILES['referenceFile']['name'];
        if (strtolower(substr($uploadedFileName, -3, 3)) != "csv") {
            return PageControlFunctions::redirectDueToError("Invalid File Type.  Only csv files are accepted");
        }
        $destinationFileName = self::UPLOAD_DIR . $uploadedFileName;
        if (move_uploaded_file($_FILES['experimentFile']['tmp_name'], $destinationFileName)) {
            return PageControlFunctions::redirectDueToError("File could not be uploaded to path {$destinationFileName}. Please check with
        PADMA support");
        }

        if (!($fileHandle = fopen($destinationFileName, "rb"))) {
            return PageControlFunctions::redirectDueToError("Could not open uploaded file {$destinationFileName}.  Please report error to support");
        }
        // first line is header
        if (! fgets($fileHandle)) {
            return PageControlFunctions::redirectDueToError("Empty File");
        }
        while (($line = fgets($fileHandle)) !== false) {
            if (substr_count($line, ",") != 4) {
                return PageControlFunctions::redirectDueToError("There must be 5 columns in each line of {$destinationFileName}.  The following line does not:\n'{$line}'' ");
            }

            list ($probeid, $cgname, $genename, $flybasenum, $godata) =
                explode($line, ",");
            DBFunctions::insertReference($db_conn, $probeid, $cgname, $genename, $flybasenum, $version, $userid, $date);

            // if godata not empty
            if (preg_match("/\d/", $godata)) {
                foreach (explode("///", $godata) as $goentry) {
                    $gospecification = explode("//", $goentry);
                    $gonumber = array_shift($gospecification);
                    DBFunctions::insertReferenceGo($probeid, $gonumber, $version, $userid, $date);
                    foreach ($gospecification as $description) {
                        DBFunctions::insertReferenceBio($gonumber, $description, $version, $userid, $date);
                    }
                }
            }
        }
    }

    /**
     *
     */
    function __construct()
    {
        $_SESSION['role'] = 'Administrator';
        PageControlFunctions::check_role('ar');
        parent::__construct();
    }


    /**
     *
     */
    function print_content() {
        if(empty($_FILES) || ($_FILES['size'] < 1) ||
            empty($_FILES[self::FILE_POSTVAR]) || empty($_FILES[self::FILE_POSTVAR]["name"]) ||
            ! is_uploaded_file($_FILES[self::FILE_POSTVAR]["name"])) {
            $actionUrl = $_SERVER['PHP_SELF'];

//        <form name="uploadReferenceForm" action="$actionUrl" method="POST" enctype="multipart/form-data">
//            <h1>Load Reference Data</h1>

        echo WidgetMaker::start_form($actionUrl, '') .
            WidgetMaker::text_input('Version Number', 'version') .
            WidgetMaker::file_input("Upload File", self::FILE_POSTVAR) .
            WidgetMaker::submit_button() .
            WidgetMaker::end_form();

        }
        else {
            $this->upload_file($this->db_conn);
        }

    }
}




/**
 *
Home Discussions
Uploading Files with PHP
GoJS is a fast and powerful JavaScript library for implementing interactive diagrams.
via AdPacks
Introduction

You can't go on any site nowadays without seeing an option to upload an image. All of the big sites are doing it, however it's one of those things that is very poorly covered in PHP articles across the internet. We'll cover the basic upload process and then in a future article move on to additional things like image resizing and cropping.
The HTML Form

With this, you'll be using an input of type file, this will give the user an input which when clicked will give the user a browse box to choose the file to upload. The form that you put this in must have an enctype of multipart/form-data.

<form method='post' enctype='multipart/form-data' action='upload.php'>
File: <input type='file' name='file_upload'>
<input type='submit'>
</form>

The PHP

Normally when a form is posted to a PHP page, you can get the values of fields by looking in the $_POST global array, however, file uploads get put in a separate one called $_FILES. This is indexed with the name of the file input that you chose before, so in our case we'll be looking into the $_FILES['file_upload'] array. There are a few different values within this array that you use: name, type, size, tmp_name, error.

When uploading, running a print_r on $_FILES will return something similar to this:

Array
(
[file_upload] => Array
(
[name] => e4f.png
[type] => image/png
[tmp_name] => /Applications/MAMP/tmp/php/phpodzfRk
[error] => 0
[size] => 328119
)
)

The process we're going to use is pretty straight forward:

Check if there are any errors in the upload.
Check if the file type is allowed.
Check that the file is under our file size limit.
Check that the file doesn't already exist (based on name).
Finally upload the file.

Check if there are any errors in the upload.

If the error number is greater than 0, there's an error. So simply, we can do:

if($_FILES['file_upload']['error'] > 0){
die('An error ocurred when uploading.');
}

Check if the file type is allowed.

We only want to allow .png files to be uploaded, so we're going to have to make sure that the type is image/png, again simply:

if($_FILES['file_upload']['type'] != 'image/png'){
die('Unsupported filetype uploaded.');
}

Check that the file is under our file size limit.

Sizes are all based in bytes, so if we don't want any files bigger than 500kb uploading, we'll have to check that the size is less than 500000:

if($_FILES['file_upload']['size'] > 500000){
die('File uploaded exceeds maximum upload size.');
}

Check that the file doesn't already exist (based on name).

We're going to be putting our files in a directory called upload. You need to make sure that you CHMOD this directory to have the required permissions for writing. We will simply use the PHP function file_exists():

if(file_exists('upload/' . $_FILES['file_upload']['name'])){
die('File with that name already exists.');
}

There is no reason that you can't prepend, or append the timestamp of the upload to the name to make it unique, and in some cases might be a sensible thing to do.
Finally upload the file.

Finally, we want to upload the file, as at this point if the script is still running the file is safe to upload. We will simply move the file using the move_uploaded_file function from its current temporary location to where we want it:

if(!move_uploaded_file($_FILES['file_upload']['tmp_name'], 'upload/' . $_FILES['file_upload']['name'])){
die('Error uploading file - check destination is writeable.');
}

Upload Security

One of the vital things to realise is that are potentially allowing anything to be uploaded to your site which could be used to maliciously take over your server. You should be sure to employ some common sense when doing this, and some of the below methods will help you go someway to making your uploads secure. There are plenty of other methods you could use.
Storage location

When allowing a user to upload files, you should store them outside the web root, this means a directory that is not inside the www or public_html directory on most systems. This means that if someone manages to upload a script or something to your site intead of an image they will not be able to access it.

You can then display the images through a separate PHP file that will load the image and explicitly set the headers for the image and output it to the user using specific PHP image functions such as imagecreatefrompng so if it's not an image the display will fail.

Make sure you never allow direct access to the file from the web, that could just get very nasty
Verify upload is an image

One of the best things to do when uploading is to ensure that it is an actual image that is being uploaded, you can do this by passing the uploaded file through a PHP image function such as getimagesize(), this will return false if the file is not an image:

if(!getimagesize($_FILES['file_upload']['tmp_name'])){
die('Please ensure you are uploading an image.');
}

This will check that the file is an image, and die telling the user to ensure that it's an image that is being uploaded and not just a malicious file pretending to be an image.
Disable script execution

Another thing to do, is to use some .htaccess code to disable the execution of scripts within your uploads file. Something along the lines of the code below in a .htaccess file in your uploads directory should help:

AddHandler cgi-script .php .php3 .php4 .phtml .pl .py .jsp .asp .htm .shtml .sh .cgi
Options -ExecCGI

Chown Uploads Directory

You should definitely change the owner of the uploads directory, make it so that it's owned by apache and that it has the permissions 770 and it shouldn't be accessible by any user. However, the directory will still be modifiable through your various PHP scripts. This method might not be possible on shared hosting environments where you don't have root permissions.
Other ideas

You can check the extension against a list of blacklisted extensions such as .php, .js, .pl, .py etc. But you shouldn't rely on this as your only security check that you use.
Complete

It's as simple as that, one thing to think about is if you're uploading files, you will probably want to store a history of who uploaded the file and when in a database. Find below the complete PHP code:

<?php

// Check for errors
if($_FILES['file_upload']['error'] > 0){
die('An error ocurred when uploading.');
}

if(!getimagesize($_FILES['file_upload']['tmp_name'])){
die('Please ensure you are uploading an image.');
}

// Check filetype
if($_FILES['file_upload']['type'] != 'image/png'){
die('Unsupported filetype uploaded.');
}

// Check filesize
if($_FILES['file_upload']['size'] > 500000){
die('File uploaded exceeds maximum upload size.');
}

// Check if the file exists
if(file_exists('upload/' . $_FILES['file_upload']['name'])){
die('File with that name already exists.');
}

// Upload file
if(!move_uploaded_file($_FILES['file_upload']['tmp_name'], 'upload/' . $_FILES['file_upload']['name'])){
die('Error uploading file - check destination is writeable.');
}

die('File uploaded successfully.');

Tag: PHP
Top

Posted 12th July 2012 by Michael


 */