<?php
require_once(__DIR__ . "/../templates/WebPage.php");

class FAQPage extends WebPage {
  function make_page_middle($title, $userid, $role){
    return $this->make_image_content_columns ($title, $userid, $role, 'R', 8) ;
      }
    function __construct() {
        parent::__construct();
    }

    public function make_main_frame($title, $userid, $role) {
        $returnString = <<<EOT

<div class="central_widget">

    <h2>New User/Log-In</h2>
    <hr>
    <ul>
        <li><a href="faq.php#n1">What is involved in the Registration Process?</a></li>
        <li><a href="faq.php#n2">What information do I need to provide to register?</a></li>
        <li><a href="faq.php#n3">What is the Check button on part 2 of the registration process?</a></li>
        <li><a href="faq.php#n4">Is there a Password format requirement?</a></li>
        <li><a href="faq.php#n5">What if I cant remember my password?</a></li>
    </ul>

    <h2>Query</h2>
    <ul>
        <li><a href="faq.php#q1">What is the difference between the three query types?</a></li>
        <li><a href="faq.php#q2">Can I search multiple entries (i.e. genes, GC Number, etc.)?</a></li>
        <li><a href="faq.php#q3">Where can I find a list of genes thats in PADMA?</a></li>
        <li><a href="faq.php#q4">Is a Probe ID associated with only one gene?</a></li>
        <li><a href="faq.php#q5">Is a gene associated with only one Probe ID?</a></li>
    </ul>

    <br>
    <h2>Export Files</h2>
    <hr>
    <ul>
        <li><a href="faq.php#e1">What format is the Query Result Table exported in?</a></li>
        <li><a href="faq.php#e2">Can I export a full dataset from an experiment?</a></li>
    </ul>


    <br>
    <h2>Upload Files</h2>
    <hr>
    <ul>
        <li><a href="faq.php#u1">Why do I get a Invalid file type, file was not uploaded. message?</a></li>
        <li><a href="faq.php#u2">Why do I get a File is not in Right Format message?</a></li>
        <li><a href="faq.php#u3">What is the Upload File format?</a></li>
        <li><a href="faq.php#u4">If my raw file is not in csv or excel, can I still use PADMA?</a></li>
        <li><a href="faq.php#u5">Does PADMA provide user/tech support for file upload?</a></li>
    </ul>


    <br>
    <h3>New User/Log-In</h3>
    <hr>
    <a name="n1">
        <h2>What is involved in the Registration Process?</h2>
    </a>
    You need to:
    <ol>
        <li>Click on New User</li>
        <li>Complete and submit the registration form</li>
        <li>PADMA Admin will contact you when your user set-up is complete</li>
    </ol>
    <a href="faq.php">&lt;&lt;Back to FAQ</a>

    <a name="n2">
        <h2>What information do I need to provide to register?</h2>
    </a>
    <p> Please fill out the registration form as complete as possible.  Please ensure to provide us with your most current email address, since we will communicate with you via email.  Please be assured that information you provide will not be shared to a third party. Please refer to the Terms of Use for details on privacy notice.</p>

    <a href="faq.php">&lt;&lt;Back to FAQ</a>


    <a name="n3">What is the Check button on part 2 of the registration process?</a>

    <p>      The system will verify whether your name, email address, or User ID is already in the system to avoid duplicate entry.  If we already have your information, the system will automatically reject your registration.</p>

    <a href="faq.php">&lt;&lt;Back to FAQ</a>

    <a name="n4">Is there a Password format requirement?</a>
    No.  You are free to choose any password youd like.  However, we recommend that you choose a password thats easy for you to remember has a combination of alpha numeric, and its difficult for others to guess.

    <a href="faq.php">&lt;&lt;Back to FAQ</a>

    <a name="n5">What if I cant remember my password?</a>
    <p>Contact PADMA Admin under Contact Us for password reset.</p>

    <a href="faq.php">&lt;&lt;Back to FAQ</a>
    <br>
    <h2>Query</h2>
    <hr>

    <a name="q1">What is the difference between the three query types?</a>

    <p>While all three query type will essentially give you the same gene profile results, each query is uniquely design to optimize your search based on information available to you (i.e. gene name, probe set ID, bio function etc.).  We recommend the following brief guidelines:</p>
    <ul>
        <li><h2>Quick Gene Search:</h2> if you have a gene name/CG number/Probe ID/FlyBase number, but are not interested in/dont know specific bio function associated with the genes.  Thus, the query result table will not show any bio functions associated with the gene you are querying.</li>

        <li><h2>Advanced Query:</h2> it let you search ALL criteria in PADMA.  Thus, your query result table will contain all the information for that gene, including all the bio function associated.  So, if your gene of interest has 4 bio function associated, and your query is restricted to 4 experiments with 3 time points each, you will have a total of 48 results.</li>

        <li><h2>Refine Query:</h2> unlike Quick Gene Search and Advanced Query, Refine Query is divided into two layers.  The first layer lets you search by either gene related info or bio function.  The second layer (a separate pop window when you submit the search criteria of the first layer) lets you search by experiment criteria like Category, Subject, Regulation Value, etc.</li>
    </ul>

    <a href="faq.php">&lt;&lt;Back to FAQ</a>

    <a name="q2">Can I search multiple entries (i.e. genes, GC Number, etc.)?</a>
    <p>Yes! All you need to do is add a comma after each entry. Example: IM2,Myd88,AttA</p>
    <a href="faq.php">&lt;&lt;Back to FAQ</a>

    <a name="q3">Where can I find a list of genes thats in PADMA?</a>
    <p>You can either click on the list next to Gene Name or go to the Document tab on the top of the website to download the list of all genes associated with a specific probe set and GO number.</p>
    <a href="faq.php">&lt;&lt;Back to FAQ</a>

    <a name="q4">Is a Probe ID associated with only one gene?</a>
    <p>For the most part, one probe set will have a oligonucleotides sequences that is associated with sequences for a particular gene.  However, there are many instances where genes share similar probe sequence.  You can find these associations by downloading the gene list found in the Document tab on the top of the website.</p>

    <a href="faq.php">&lt;&lt;Back to FAQ</a>

    <a name="q5">Is a gene associated with only one Probe ID?</a>
    <p>For the most part, one gene will only have one probe set that is associated.  However, alternative splicing, degenerative codes, and other biological complexity makes it possible for one gene to be picked-up by multiple probe set.  You can find these associations by downloading the gene list found in the Document tab on the top of the website.</p>
    <a href="faq.php">&lt;&lt;Back to FAQ</a>

    <br><h3><h2>Export Files</h2></h3><hr>
    <a name="e1">What format is the Query Result Table exported in?</a>
    <p>PADMA only exports file in Excel.  You can later convert this file into any format you wish, if possible with your software application/operating system.</p>
    <a href="faq.php">&lt;&lt;Back to FAQ</a>

    <a name="e2">Can I export a full dataset from an experiment?</a>
    <p>While this is possible, by specifying your query, it will take considerable about of time.  We suggest you query and search on PADMA and export specific results of interest.</p>

    <a href="faq.php">&lt;&lt;Back to FAQ</a>

    <br><h3><h2>Upload Files</h2></h3><hr>
    <a name="u1">Why do I get a Invalid file type, file was not uploaded. message?</a>
    <p>To upload file, you must use a Comma Separated Value (csv) format.  Any other format will be rejected.</p>
    <a href="faq.php">&lt;&lt;Back to FAQ</a>
    <a name="u2">Why do I get a File is not in Right Format message?</a>
    <p>More than likely, this message was followed by a second message indicating to check a specific Row or Column.  Please open your load file and check the format of the row/column specified in the error message.  Sometimes, this results from skipped rows/columns, invalid text or special characters.</p>
    <a href="faq.php">&lt;&lt;Back to FAQ</a>

    <a name="u3">What is the Upload File format?</a>
    <p> You need a total of 8 columns, with specific layout.  The file has to be saved as a Comma Separated Value (csv) file.  Please refer to the User Manual, Section 5.0 and 5.1 for specific details.  </p>
    <a href="faq.php">&lt;&lt;Back to FAQ</a>

    <a name="u4">If my raw file is not in csv or excel, can I still use PADMA?</a>
    <p>Absolutely.  While PADMA Format is restricted to csv file (and Excel file saved as csv), other file formats can be easily converted into a csv file.  Please refer to a computer guidebook or contact a data analyst for support.</p>
    <a href="faq.php">&lt;&lt;Back to FAQ</a>

    <a name="u5">Does PADMA provide user/tech support for file upload?</a>
    <p>While we dont have the resources to provide user/tech support, should you have any questions, dont hesitate to email us.</p>
    <a href="faq.php">&lt;&lt;Back to FAQ</a>
</div>


EOT;
        return $returnString;
    }

    function get_title() {
        return "Frequently Asked Questions";
    }

}











