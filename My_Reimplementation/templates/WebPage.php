<?php

require_once(__DIR__ . "/../functions/PageControlFunctionsAndConsts.php");
require_once(__DIR__ . "/../components/HeaderMaker.php");
require_once(__DIR__ . "/../components/FooterMaker.php");
require_once(__DIR__ . "/../components/WidgetMaker.php");

/**
 * Class WebPage
 */
abstract class WebPage
{

    protected $userid;
    protected $role;

    // Overridden in subclass with Late Static Binding
    const PG_TITLE = '';

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
     * Constructor()
     * $role, $userid initialized from SESSION variables
     * $title initialized in subclass
     */
    public function __construct()
    {
        PageControlFunctionsAndConsts::initialize_session();
        $this->userid = isset($_SESSION[pgFn::USERID_SESSVAR]) ? $_SESSION[pgFn::USERID_SESSVAR] : "";
        $this->role = isset($_SESSION[pgFn::ROLE_SESSVAR]) ? $_SESSION[pgFn::ROLE_SESSVAR] : "";
    }

    /**
     * @Abstract
     * Determine formatting of Main Page Image relative to
     *     Page Logical Content
     *
     * Abstract Function
     * Sublasses modify the display by redefining the functions contained within, particularly make_content() as well as make_js(), where needed.
     *
     * @param $userid : Logged in User
     * @param $role : Role of Logged in User
     * @return string : HTML for middle of Page
     */


    abstract function make_page_middle($userid, $role);

    /**
     * @param $userid
     * @param $role
     * @param $imgOrientation
     * @param $imgWidth
     * @return string
     */
    function make_image_content_columns ($userid, $role,  $imgOrientation, $imgWidth) {
        $reflectionClass = new ReflectionClass($this);
        $filename = $reflectionClass->getFileName();


        $returnString = '';

        $image_name = preg_replace('/php/', 'jpg', basename($filename));
        $image_dir = "../images/PadmaPix/";
        $image_path = $image_dir . $image_name;
        error_log($image_path);
        $remainingWidth = 12 - $imgWidth;
        if ( $imgOrientation && $imgWidth) {
            if ($imgOrientation === 'R') {

                $returnString .= <<< EOT

    <div class="row">
        <div class="col-md-{$imgWidth}"><img height="100%" width="100%" src="{$image_path}"></div>
        <div class="col-md-{$remainingWidth}">
EOT;

                $returnString .= $this->make_main_content($userid, $role);

                $returnString .= <<< EOT
        </div>
    </div>
EOT;

            }
            elseif ($imgOrientation === 'L') {

                $returnString .= <<< EOT

    <div class="row">
        <div class="col-md-{$remainingWidth}">
EOT;

                $returnString .= $this->make_main_content($userid, $role);

                $returnString .= <<< EOT
        </div>
        <div class="col-md-{$imgWidth}">
            <img height="100%" width="100%" src="{$image_path}">
        </div>
    </div>
EOT;


            }
            // Bad value for orientation
            else {
                $returnString .= $this->make_main_content($userid, $role);
            }
        }
        // No value for orientation or image
        else {
            $returnString .= $this->make_main_content($userid, $role);
        }
        return $returnString;
    }


    public final function display_page()
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
        <h1> $title </h1>
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
     * Prints the footer , the js, and closes the page.
     * Final method.
     * Add additional js by overriding make_js()
     *
     * @return string
     */
    final protected function make_page_bottom()
    {
        $returnString = FooterMaker::make_footer()
            . <<< EOT
        </div> <!-- end main container div -->
EOT
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