PADMA
=====

This README is directed towards two audiences
* Users of PADMA
* People interested in my work

History of the Project
======================

PADMA was written by a graduate student from between 2008-2010.
A professor originally asked to make a minor modification to the permissions settings on a few pages, which I did quickly.  

I was then asked to redesign the style of the site.  However, I could not make sense of the spaghetti code which the previous coder has written,
so I found it hard to redesign.  This project had a few false starts:  initially, I just tried to hack the css, then I tried to modularize the html somewhat,
but only in September was able to begin in earnest to redesign everything from scratch.

The end users did not communicate any requirements to me, so I did my best to reverse engineer the code, 
trying to figure out what the graduate student had been trying to do with such a complicated code base.  
The more I struggled with the code, however, the more I realized that the complexity of the code had more
to do with the skill of the previous designer than the requirements of the task.

Due to the nature of this task, this repository includes both the original codebase and the redesign.

Design Goals and Strategy
=========================

Because my own involvement will end soon, my primary design goal has been to create something that will be easy for a future designer to fix and update.  To that end, I have always chosen to make code clarity to be the paramount virtue, even at the cost of verbosity and minor inefficiency.  

To reduce the risk of sloppy syntax and spelling errors, I have chosen throughout to 
* Always use static constants rather than using plaintext strings
* Always use static PHP methods to create HTML strings rather than writing raw HTML.

For all pages in the site, the return string is built in a modular manner: First the Head Section, then the Top Nav, then the Middle, then the Bottom Nav, then the Javascript, then the closing HTML.  Only after the entire string is build will the result be echoed.


This code was written to be compatible with the minimum possible settings of the end-user's server, so make the transfer between the old PHP codebase to the new codebase would be as painless as possible.  It therefore is compliant PHP 5.3.x, and makes no usage of any of the contemporary frameworks for modularizing code.


File Naming Conventions
=======================

*  *Page.php:  Extends WebPage.php.  A Class which is used to display a Webpage
*  *Script.php:  A standalone CGI script for processing POST data.  Not a class.
*  *AJAX.php:  A standalone script for processing AJAX data.   Not a class.
*  *FunctionsAndConsts:  A class which contains a library of static constants and functions
*  *Maker.php:  Generates the string for an HTML component

Directory Structure
===================


components: Contains *Maker classes, which generate HTML using static functions
css	: Bootstrap and custom css
data_admin	: Classes and Scripts for Administering Data (Experiments and Versions) on the site
extensions	: Files for Datatables.js
fonts : Files for Bootstrap
functions_and_consts	: Contains *FunctionsAndConsts classes, which contain static functions and static constants that are used throughout the application
info_pages
js	
search	
templates	
user_admin
webpages	
