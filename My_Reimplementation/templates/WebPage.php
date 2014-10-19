<?php

require_once(__DIR__ . "/../functions/PageControlFunctions.php");
require_once(__DIR__ . "/../components/HeaderMaker.php");
require_once(__DIR__ . "/../components/FooterMaker.php");
require_once(__DIR__ . "/../components/WidgetMaker.php");

abstract class WebPage
{

    protected $title;
    protected $userid;
    protected $role;

    const USERID_SESSVAR = 'userid';
    const ROLE_SESSVAR = 'role';
    const PASSWORD_POSTVAR = 'password';

    const ADMINISTRATOR_ROLE = 'Administrator';
    const RESEARCHER_ROLE = 'Researcher';
    const USER_ROLE = 'GeneralUser';
    const NOTAUTHORIZED_ROLE = 'NOTAUTHORIZED';
    const REGISTERED_ROLE = 'AnyUser';
    const SUPERVISING_ROLE = 'Supervising';


    protected  function isAuthorizedToViewPage() {
        return true;
    }

    abstract function get_title() ;
    /**
     * Constructor()
     * $role, $userid initialized from SESSION variables
     * $title initialized in subclass
     */

    public function __construct()
    {
        if ($this->isAuthorizedToViewPage()) {
            PageControlFunctions::initialize_session();
            $this->userid = isset($_SESSION[self::USERID_SESSVAR]) ? $_SESSION[self::USERID_SESSVAR] : "";
            $this->role = isset($_SESSION[self::ROLE_SESSVAR]) ? $_SESSION[self::ROLE_SESSVAR] : "";
            $this->title = $this->get_title();
        }
    }

    /**
     * Prints out the WebPage.
     * The function is final
     * Sublasses modify the display by redefining the functions contained within, particularly make_content() as well as make_js(), where needed.
     *
     */
    abstract function make_page_middle($title, $userid, $role);


    function make_image_content_columns ($title, $userid, $role,  $imgOrientation, $imgWidth) {

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

                $returnString .= $this->make_main_frame($title, $userid, $role);

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

                $returnString .= $this->make_main_frame($title, $userid, $role);

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
                $returnString .= $this->make_main_frame($title, $userid, $role);
            }
        }
        // No value for orientation or image
        else {
            $returnString .= $this->make_main_frame($title, $userid, $role);
        }
        return $returnString;
    }


    public final function display_page()
    {
        $title = $this->title;
        $role = $this->role;
        $userid = $this->userid;

        $displayString =  $this->make_page_top($title, $userid, $role)
            . $this->make_page_middle($title, $userid, $role)
            . $this->make_page_bottom();

        echo $displayString;

        $this->cleanup();
    }

    /**
     * Prints out the leading HTML, the css, and the Header.
     * Function is final.
     * Subclasses can override this by overriding make_css
     *
     * @param $title
     * @param $userid
     * @param $role
     * @return string
     */
    final protected function  make_page_top($title, $userid, $role)
    {
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
     * Returns string containing the main content block
     * Abstract method.
     * Must be overridden by subclass
     *
     * @param $title
     * @param $userid
     * @param $role
     * @return string
     */
    abstract protected function make_main_frame($title, $userid, $role);

    /**
     * Prints the footer , the js, and closes the page.
     * Final method.
     * Add additional js by overriding make_js()
     *
     * @return string
     */
    final protected function make_page_bottom()
    {
        $returnString = FooterMaker::make_footer();
        $returnString .= <<< EOT
    </body>
EOT;
        $returnString .= $this->make_js();
        $returnString .= <<< EOT
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

        $this_filename = (__FILE__);
        $parent_dirname = (dirname(__DIR__));
        $grandparent_dir = dirname(dirname(__DIR__));
        $js_dir = $grandparent_dir . "/js";
        $js_php_file = preg_replace(".php", ".js.php", $js_dir . "/" . $parent_dirname . "_" . $this_filename);
        if (file_exists($js_php_file)) {
            $returnString .= file_get_contents($js_php_file);
        }
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