<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/3/14
 * Time: 11:34 AM
 */

require_once (__DIR__ . "/SearchBase.php");

abstract class SearchResultsBase extends SearchBase {
    abstract function search_query();
    abstract function print_results();
    abstract function export();
} 