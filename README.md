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


* /components/ Contains *Maker classes, which generate HTML, including HeaderMaker, FooterMaker, using static functions
* /css/ Bootstrap and custom css
* /data_admin/ Classes, Scripts and AJAX files for Administering Data (Experiments and Versions) on the site
* /extensions/ Files for Datatables.js
* /fonts/ Files for Bootstrap
* /functions_and_consts/ Contains *FunctionsAndConsts classes, which contain static functions and static constants that are used throughout the application
* /info_pages/  Contain purely informational *Pages about the PADMA Project.  They directly extend the WebPage class, but not the DatabasePage class, because they have no perform no CRUD tasks.
* /js/ jquery.js, bootstrap.js, datatables.js, parsely.js
* /public/ alias of /webpages/
* /search/ For searching the FULL_VIEW view in the Database.  Only Advanced Search is currently implemented, which allows for a  search of all columns of the database.  QuickSearch and RefinedSearch are not implemented in the current version.  
* /page_templates/  Contains base pages of all Pages: (1) WebPage for the creation of all HTML for each Page echoed from the server, and (2) DatabasePage for those pages which require perform CRUD data retrieval tasks against the Database.
* /user_admin/ Classes, Scripts and AJAX files for Administering User Administration (Permissions and Profiles) on the site
* /webpages/  all user-facing pages are served echoed from this folder 


User Facing Pages
=================
* All in /webpages/ directory 

* documentation/  Project Documentation Folder
* about.php	: Information about PADMA project
* advanced_search.php	: Search all columns of FULL_VIEW
* change_password_page.php	: User change password
* contact.php	: Contact PADMA staff
* delete_experiment.php	: Administrator or Researcher delete experiment.
* delete_reference.php	: Administrator delete version reference.
* documentation.php	: Links to documents in documentation/ folder
* edit_experiment.php :  Administrator or Researcher edit experiment description
* edit_profile.php	: User edit profile information.
* experiment_list.php	: Display lists of experiment.
* faq.php	: Frequently Asked Questions
* index.php	: Main page
* manage_data_main.php : Navigation page for Admin or Researcher manage experiments and reference versions.	
* manage_users.php	: Administrator manage PADMA users.
* new_user_terms.php	: New User agreement
* registration.php	: New User profile creation
* search_main.php	: Navigation page for search choices 
* search_result.php	: Result of search of FULL_VIEW 
* support.php	: Support information for PADMA
* upload_agreement.php : Agreement for uploading experiment
* upload_experiment.php	: Administrator or Researcher upload experiment
* upload_reference.php	: Administrator upload version reference

Tests
=====
No automated test infrastructure has yet been implemented.

End users should confirm that the above pages can be reached.

Furthermore, they should make sure that the various roles of users (No Role, User, Researcher, Administrator) are allowed or prohibited to perform the tasks available from the pages listed above.  
 
The following tasks should be verified by end users before adopting the code base.

(1) about.php
* Guests, Users, Researchers, and Administrators can visit the page and learn information about the project 

(2) advanced_search.php
* Guests, Users, Researchers, and Administrators can visit the page, where they can thoroughly search the database

(3) change_password_page.php	
* Users, Researchers, and Administrators can visit the page and change their passwords
* Guests can not reach this page

(4) contact.php	
* Guests, Users, Researchers, and Administrators can visit the page and contact PADMA staff

(5) delete_experiment.php	
*  Administrator or Researcher can visit the page and delete experiments.
*  Guests and Users can not reach this page

(6)  delete_reference.php	 
* Administrator can visit the page and delete version reference.
* Guests, Users, and Researchers can not reach this page

(7) documentation.php	
* Guests, Users, Researchers, and Administrators can visit the page and links to documents in documentation/ folder

(8) edit_experiment.php  
* Administrator or Researcher can visit the page and edit experiment description
*  Guests and Users can not reach this page

(9) edit_profile.php	
* Users, Researchers, and Administrators can visit the page and edit profile information.
*  Guests can not reach this page

(10) experiment_list.php 
* Guests, Users, Researchers, and Administrators can visit the page and can view a list of experiment.

(11) faq.php	
* Guests, Users, Researchers, and Administrators can visit the page and can view the Frequently Asked Questions

(12) index.php 
* Guests, Users, Researchers, and Administrators can visit the page and can view the Main page

(13) manage_data_main.php 
* Researchers and Administrators can visit the page and manage experiments and reference versions.	
*  Guests and Users can not reach this page

(14) manage_users.php	 
* Administrators can visit the page and  manage PADMA users.
*  Guests, Users, and Researchers can not reach this page
  
(15) new_user_terms.php	: New User agreement

(16) registration.php	: New User profile creation

(17) search_main.php	: Navigation page for search choices 

(18) search_result.php	: Result of search of FULL_VIEW 

(20) support.php	: Support information for PADMA

(21) upload_agreement.php : Agreement for uploading experiment

(22) upload_experiment.php	: Administrator or Researcher upload experiment

(23) upload_reference.php	: Administrator upload version reference


 
Remaining Issues: Code Style
=============================

* Consts_And_Functions
+ Overdetermined
+ Too much happening?
+ Refactor UPLOAD consts_and_functions into DATA_ADMIN?

* WidgetMaker class
+ Needs Refactoring
+ Use Named Arguments. Hard to keep track of positional arguments
+ Remove unused arguments: (eg) onsubmit() from Form widget

Remaining Issues:  Functionality
================================
* Allow different search parameters
* Refined Search
* Delete Users doesn't delete from DB, only sets delete flag: bug or feature?
