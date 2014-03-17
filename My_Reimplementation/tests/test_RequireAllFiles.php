<?php

    $handle = opendir(__DIR__ . "/../webpages");
    while ($webpage = readdir($handle)) {
        $bn = basename($webpage);
        print "Checking {$bn} \n";
        require_once(__DIR__ . "/../webpages/" . $webpage);
    }
/*
require_once(__DIR__ . "/../widgets/DB_WidgetMaker.php");
require_once(__DIR__ . "/../data_admin/ConfirmEditDescriptionPage.php");
require_once(__DIR__ . "/../search/QuickSearch.php");
require_once(__DIR__ . "/../search/SearchBase.php");
require_once(__DIR__ . "/../data_admin/DeleteExperimentPage.php");
require_once(__DIR__ . "/../search/SearchResultPage.php");
require_once(__DIR__ . "/../search/SearchType.php");
require_once(__DIR__ . "/../search/SelectSearchPage.php");
require_once(__DIR__ . "/../data_admin/ExpDescription.php");
require_once(__DIR__ . "/../templates/DatabaseConnectionPage.php");
require_once(__DIR__ . "/../data_admin/expLoaderStart.php");
require_once(__DIR__ . "/../templates/WebPage.php");
require_once(__DIR__ . "/../data_admin/expUploader.php");
require_once(__DIR__ . "/../tests/PageTest.php");
require_once(__DIR__ . "/../data_admin/fileloader.php");
require_once(__DIR__ . "/../user/CreateNewUserPage.php");
require_once(__DIR__ . "/../data_admin/insertExperiment.php");
require_once(__DIR__ . "/../user/CreateProfilePage.php");
require_once(__DIR__ . "/../user/EditProfilePage.php");
require_once(__DIR__ . "/../data_admin/loaderStart.php");
require_once(__DIR__ . "/../user/LoginPage.php");
require_once(__DIR__ . "/../user/PasswordRecoveryPage.php");
require_once(__DIR__ . "/../user/SubmitNewUserPage.php");
require_once(__DIR__ . "/../data_admin/uploadagreement.php");
require_once(__DIR__ . "/../user/SubmitProfilePage.php");
require_once(__DIR__ . "/../data_admin/uploader.php");
require_once(__DIR__ . "/../functions/PageControlFunctions.php");
require_once(__DIR__ . "/../user/UserManagementPage.php");
require_once(__DIR__ . "/../functions/utility.php");
require_once(__DIR__ . "/../webpages/about_us.php");
require_once(__DIR__ . "/../information/AboutUsPage.php");
require_once(__DIR__ . "/../webpages/admin_main.php");
require_once(__DIR__ . "/../information/ContactPage.php");
require_once(__DIR__ . "/../webpages/advanced_search.php");
require_once(__DIR__ . "/../information/DocumentPage.php");
require_once(__DIR__ . "/../webpages/contact.php");
require_once(__DIR__ . "/../information/FaqPage.php");
require_once(__DIR__ . "/../webpages/create_profile.php");
require_once(__DIR__ . "/../information/FormToEmail.php");
require_once(__DIR__ . "/../webpages/create_user.php");
require_once(__DIR__ . "/../information/IndexPage.php");
require_once(__DIR__ . "/../information/IndexPage.php");
require_once(__DIR__ . "/../webpages/documents.php");
require_once(__DIR__ . "/../information/SupportPage.php");
require_once(__DIR__ . "/../webpages/edit_profile.php");
require_once(__DIR__ . "/../partials/footer.php");
require_once(__DIR__ . "/../webpages/faq.php");
require_once(__DIR__ . "/../partials/header.php");
require_once(__DIR__ . "/../webpages/index.php");
require_once(__DIR__ . "/../search/AdvancedSearchPage.php");
require_once(__DIR__ . "/../webpages/login.php");
require_once(__DIR__ . "/../search/exportCustomQuery.php");
require_once(__DIR__ . "/../webpages/researcher_main.php");
require_once(__DIR__ . "/../search/exportQuickSearch.php");
require_once(__DIR__ . "/../webpages/search_result.php");
require_once(__DIR__ . "/../search/exportRefinedSearchAll.php");
require_once(__DIR__ . "/../webpages/advanced_search.php");
require_once(__DIR__ . "/../search/exportRefinedSearchRefined.php");
require_once(__DIR__ . "/../webpages/user_main.php");
require_once(__DIR__ . "/../search/exportTest.php");
require_once(__DIR__ . "/../widgets/DB_WidgetMaker.php");
require_once(__DIR__ . "/../search/exportToExcel.php");
require_once(__DIR__ . "/../widgets/WidgetMaker.php");
require_once(__DIR__ . "/../search/ListofExperiment.php");

#errors
require_once(__DIR__ . "/../data_admin/DeleteReference.php");
require_once(__DIR__ . "/../data_admin/EditDescriptionPage.php");
require_once(__DIR__ . "/../data_admin/DataManagementIndexPage.php");
require_once(__DIR__ . "/../data_admin/insertReference.php");
require_once(__DIR__ . "/../data_admin/SelectExperiment.php");
require_once(__DIR__ . "/../user/MainPage.php");
require_once(__DIR__ . "/../data_admin/SelectExperimentResearcher.php");
require_once(__DIR__ . "/../user/PasswordChangePage.php");
require_once(__DIR__ . "/../data_admin/terms.php");
require_once(__DIR__ . "/../user/UserInfoPage.php");

 */
?>