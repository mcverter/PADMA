<?php

require_once("../functions_and_consts/PageControlFunctionsAndConsts.php");
require_once("../components/HeaderMaker.php");
require_once("../components/FooterMaker.php");
require_once("../components/WidgetMaker.php");

/**
 * Class WebPage
 *
 * This is the base class for the contents of all
 *  User-Displayable Webpages.
 *
 * Any class whose name ends with "Page.php"
 *   inherits from this.
 *
 * Files in the /webpages/ directory load Page.php files
 *
 * Other types of Files are "Script.php" and "AJAX.php"
 *
 */
abstract class WebPage
{

    protected $userid;
    protected $role;

    // Overridden in subclass with Late Static Binding
    const PG_TITLE = '';

    /**
     * Constructor()
     * $role, $userid initialized from SESSION variables
     */
    public function __construct()
    {
        PageControlFunctionsAndConsts::initialize_session();
        $this->userid = isset($_SESSION[PageControlFunctionsAndConsts::USERID_SESSVAR]) ? $_SESSION[PageControlFunctionsAndConsts::USERID_SESSVAR] : "";
        $this->role = isset($_SESSION[PageControlFunctionsAndConsts::ROLE_SESSVAR]) ? $_SESSION[PageControlFunctionsAndConsts::ROLE_SESSVAR] : "";
    }

    /**
     * This is the primary interface to the page.
     * Each file in the /webpages/ directory instantiates
     *   a memeber of the corresponding Page.php class
     *   and then calls display_page on it.
     *
     * Display page checks to see whether page access
     *   is legitimate.
     * Then it creates the top, middle, and bottom of the page.
     * Then this string is echoed out
     *
     * Note that each step of this process involves the
     *   creation and appending of the $returnString variable
     * At no point should there be any calls to
     *   echo() or print() until the entire string is built.
     *
     *
     */
    public function display_page()
    {
        if ($this->isAuthorizedToViewPage()) {
            $role = $this->role;
            $userid = $this->userid;

            $displayString = $this->make_page_top($userid, $role)
                . $this->make_page_middle($userid, $role)
                . $this->make_page_bottom();

            echo $displayString;

        }
        $this->cleanup();
    }



    /**
     * Checks whether the current user has a $role to view page
     * Called in constructor.
     * Should be overridden by any restricted page
     *
     * @return bool
     */
    protected  function isAuthorizedToViewPage() {
        return true;
    }

    /**
     * In the future
     * It might be useful to have a check_referrer() funciton
     *   to make sure that requests are coming from the appropriate
     *   place, and to do checks of CSRF tokens, etc.
     *
     * Currently, check_refferer functions are being used to make
     *   sure that Agreement Forms are properly signed
     *
     * Nothing is yet implemented for the general case.
     * This is added to the file as a reminder to reconsider this.
     *
     */
    function check_referrer(){}

    /**
     * @Abstract
     * Must be overridden by subclass
     *
     * Makes the main functional content block of the page
     *
     * @param $userid:  Logged in User
     * @param $role:  User's Role
     * @return string: HTML for page
     */
    abstract protected function make_main_content($userid, $role);


    /**
     * @Abstract
     * Determine formatting of Main Page Image relative to
     *     Page Logical Content
     *
     * Abstract Function
     * This function is used to provide parameters to
     *   make_image_content_columns(), below
      *
     * @param $userid : Logged in User
     * @param $role : Role of Logged in User
     * @return string : HTML for middle of Page
     */
     abstract function make_page_middle($userid, $role);

    /**
     * This is a lazy way to add minimal design to pages.
     * Each webpage has a single correponding image in the
     *    /images/PadmaPix directory.
     * This function determines the way that image is oriented
     *    relative to the main logical content
     *
     * So far, there are five options:
     * (1) No image
     * (2) Right Column Image
     * (3) Left Column Image
     * (4) Right Floated Image
     * (5) Left Floated Image
     *
     * @param $userid : Id of User
     * @param $role : User Role
     * @param $imgOrientation : Either "N" for no orientation, "R" for Right Column,
     *     "L" for Left COlumn, "RF" for Right Float, "LF" for Left Float
     * @param $imgWidth : number of columns for "R" or "L" or
     *        pixel width for "RF" or "LF"
     *
     * @return string
     */
    function make_image_content_columns ($userid, $role,  $imgOrientation, $imgWidth='')
    {
        $reflectionClass = new ReflectionClass($this);
        $filename = $reflectionClass->getFileName();


        $returnString = '';

        $image_name = preg_replace('/php/', 'jpg', basename($filename));
        $image_dir = "../images/PadmaPix/";
        $image_path = $image_dir . $image_name;
        $remainingWidth = 12 - $imgWidth;
        if (!$imgOrientation || !$imgWidth) {
            $returnString .= "<h1> " . self::PG_TITLE . " </h1> \n" .
                $this->make_main_content($userid, $role);
        } else {
            switch ($imgOrientation) {
                case 'N':
                    $returnString .=  "<h1> " . self::PG_TITLE . " </h1> \n" .
                         $this->make_main_content($userid, $role);
                    break;
                case 'FL':
                    $returnString .= <<< EOT
        <div class="media">
            <a class="media-left" href="#">
                <img class="media-left" alt="Padma Image" height={$imgWidth} width={$imgWidth} src="{$image_path}">
            </a>
            <div class="media=body">
EOT;
                    $returnString .= "<h1> " . self::PG_TITLE . " </h1> \n" .
                        $this->make_main_content($userid, $role);
                    $returnString .= <<< EOT
            </div>
        </div>
EOT;
                    break;
                case 'FR':
                    $returnString .= <<< EOT
        <div class="media">
            <div class="media=body">
EOT;
                    $returnString .= "<h1> " . self::PG_TITLE . " </h1> \n" .
                        $this->make_main_content($userid, $role);
                    $returnString .= <<< EOT
            </div>
            <a class="media-right" href="#">
                <img class="media-left" alt="Padma Image" height={$imgWidth} width={$imgWidth} src="{$image_path}">
            </a>
        </div>
EOT;
                    break;
                case 'R':
                    $returnString .= <<< EOT

    <div class="row">
        <div class="col-md-{$imgWidth}"><img height="100%" width="100%" src="{$image_path}"></div>
        <div class="col-md-{$remainingWidth}">
EOT;

                    $returnString .= "<h1> " . static::PG_TITLE . " </h1> \n" .
                        $this->make_main_content($userid, $role);

                    $returnString .= <<< EOT
        </div>
    </div>
EOT;
                    break;
                case 'L':

                    $returnString .= <<< EOT

    <div class="row">
        <div class="col-md-{$remainingWidth}">
EOT;

                    $returnString .= "<h1> " . self::PG_TITLE . " </h1> \n" .
                        $this->make_main_content($userid, $role);

                    $returnString .= <<< EOT
        </div>
        <div class="col-md-{$imgWidth}">
            <img height="100%" width="100%" src="{$image_path}">
        </div>
    </div>
EOT;

                    break;
                default:
                    $returnString .= "<h1> " . self::PG_TITLE . " </h1> \n" .
                        $this->make_main_content($userid, $role);
                    break;
            }
        }
        return $returnString;
    }



    /**
     * Prints out the leading HTML, the css, and the Header.
     * Function is final.
     * Subclasses can override this by overriding make_css
     *
     * @param $userid
     * @param $role
     * @return string
     */
    final protected function  make_page_top($userid, $role)
    {
        $title = static::PG_TITLE;
        $returnString = <<< EOT
<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> PADMA: $title </title>
    <meta charset="UTF-8">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
EOT;
        $returnString .= $this->make_css();

        $returnString .= <<< EOT
    </head>
    <body>
EOT;
        $returnString .= HeaderMaker::make_header($userid, $role);
        $returnString .= <<< EOT
    <div class="main container">
EOT;

        return $returnString;
    }

    /**
     * Returns css string
     * Subclasses can add additional css (as well as js, when needed at the top) by overriding
     *
     * @return string
     */
    protected function make_css()
    {
        $returnString  =<<< EOT
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">

EOT;
        return $returnString;
    }

    /**
     * Prints the footer , the js, and closes the page.
     * Final method.
     * Add additional js by overriding make_js()
     *
     * @return string
     */
    final protected function make_page_bottom()
    {
        $returnString = <<< EOT
        </div> <!-- end main container div -->
EOT
            . FooterMaker::make_footer()
            .    $this->make_js()

            . <<< EOT

    </body>
  </html>
EOT;

        return $returnString;
    }


    /**
     *  Returns a string the necessary Javascript.
     *
     * By default, it adds jquery and bootstrap dependencies.
     * Then it checks the js directory for a .js.php file
     * that corresponds to the current filepath.
     *
     * This should be sufficient.  In rare cases, it may be necessary to override
     */
    protected function make_js()
    {
        $returnString = <<< EOT
     <script src="../js/jquery.js"></script>
     <!-- Include all compiled plugins (below), or include individual files as needed -->
     <script src="../js/bootstrap.min.js"></script>
     <script src="../js/parsley.js"></script>

EOT;
        return $returnString;
    }

    /**
     * Releases any resources
     */
    public function cleanup()
    {
    }
}


class_alias("WebPage", "wPg");