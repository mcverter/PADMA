<?php
error_log("foo");
require_once(__DIR__ .   "/../user_admin/UserManagementPage.php");
error_log("bost");
$p = new UserManagementPage();
error_log("zrr");

$p->display_page();
error_log("qqqqq");
