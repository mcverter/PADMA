<?php

/**
 * Class FooterMaker
 *
 * Creates the page footer.
 * Consisting of a bottom navbar with the copyright below
 *
 */
    class FooterMaker
    {

        /**
         * Creates the footer navbar plus the copyright notice.
         *
         * @return string
         */
        static function make_footer()
        {

            $returnString = <<< EOT

<nav class="navbar navbar-default nav-justified navbar-inverse" role="navigation">
    <div class="container-fluid">

        <div class="">
            <ul class="nav navbar-nav">
                <li><a href="../webpages/documentation.php" title="See Our Product Details!">Documents</a></li>
                <li><a href="../webpages/faq.php" title="See Frequently Asked Questions!">FAQ</a></li>
                <li><a href="../webpages/contact.php" title="See Our Contact Information!">Contact Us</a></li>
                <li><a href="../webpages/support.php" title="See Our Development Status!">Support</a></li>
                <li><a href="../webpages/about.php" title="See Develper Information!">About Us</a></li>
            </ul>
        </div>
    </div>
</nav>
<br>
<div id="ccnytrademark" class ="text-center">
    <small>
        &copy;2008-2010, The City College of The City University of New York, All Rights Reserved.
    </small>
</div>
EOT;
            return $returnString;
        }
    }






