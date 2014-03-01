<?php
require_once("WebPage.php");

class DocumentPage extends WebPage {
    public function __construct() {
        $this->set_title("Documents");
    }

    function content() {
        echo <<< EOT
<h2>User Basics</h2>
<div>
    <h3>User Manual</h3>
    &#8212; detailed and
    comprehensive information on navigating and
    utilizing the PADMA Database
    [<a href="documents/USER_MANUAL_v1.0.pdf">DOWNLOAD</a>]
</div>

<div>
    <h3>Terms of Use</h3>
    &#8212; terms and conditions for using the PADMA Database and website
    [<a href="documents/Terms of Use v1.0.pdf">DOWNLOAD</a>].
</div>

<div>
    <h3>Upload Template</h3>
    &#8212;
    use the attached spreadsheet with
    pre-populated list of
    Affymetrix<sup>&reg;</sup> probe set ID
    (PID). <br />
    <br />
    There are 2 versions of the
    Drosophila genome: Genome v1 and Genome
    v2. Download and use the pertinent template.

    <ul>
        <li>Version 1 [<a href="documents/Upload Template v1.0.xls">DOWNLOAD</a>]</li>
        <li>Version 2 [<a href="documents/Upload Template v2.0.xls">DOWNLOAD</a>]</li>
    </ul>
</div>

<div>
    <h2>Data Related Documents</h2>
    <hr />
    <div>
        <h3>Affy Genome 2</h3>
        &#8212; Due to
        multiple gene targets binding to a single
        specific probe (oligonucleotide sequence),
        a probe set ID may represent several
        genes. Thus, expression of a probe set ID
        may be over/under stated, and non-specifc
        to a gene target. Refer to this
        spreadsheet from
        Affymetrix<sup>&reg;</sup> listing all the
        individual probe set ID in the
        Affymetrix<sup>&reg;</sup> Genome 2
        associated with multiple possible gene
        targets <br />
        [<a href="documents/Affy V1 Full
			    PID for PADMA.csv">DOWNLOAD</a>].
    </div>
</div>
EOT;
    }
}