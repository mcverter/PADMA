<?php
include ("control_functions.php");
check_role('a');
initialize_session();
$db_conn = connect_to_db();
$userid=strtoupper($_SESSION['userid']);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>PADMA Database</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
  </head>

  <body>
    <?php
    //include the header page
    include("header.php");
    ?>

    <?php
    //include the header page
    if (session_id() == "") session_start();

    $role=$_SESSION['role'];
    //REDIRECT THE USER TO LOGIN PAGE IF USER IS NOT AUTHENTICATED
    #if($role == "Administrator" || $role =="Researcher" || $role=="GeneralUser") {}
    #else
    #{
      # 	header("location: index.php");
      #}
    ?>

    <h2>Select One...</h2>
    <?php
    if ($role == "Administrator" || $role =="Researcher" || $role=="GeneralUser")
    {
      echo "<table class='_100small_bold'>";
      echo	"<tr>";
      echo		"<td class='rc'>";
      echo			"<img src='images/j0432593SMALL.png' alt='logout'>";
      echo			"<a title='logout' href='index.php'>Log Out</a> |<a title='Change Password' href='PassChange.php'>Change Password</a><br />&nbsp;<br />";
      echo		"</td>";
      echo	"</tr>";
      echo "</table>";
    }
    else
    {
      echo "&nbsp;<br>";
    }
    if ($role=="GeneralUser")
    {
      echo <<<EOT
table class='_100'>
      	<tr>
      		<td class='_100c'>
      		<form  action='newprofile.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='Your Profile Update' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='QuickSearch.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='Quick Gene Search' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='AdvancedQuery.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='Advanced Query' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='RefineSearch.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='Refine Search' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='ListofExperiment.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='List of Experiment' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
       </table>
EOT;
    }

    else if ($role=="Researcher")
    {
      echo <<<EOT 
<table class='_100'>
      	<tr>
      		<td class='_100c'>
      		<form  action='newprofile.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='Your Profile Update' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='DataManagement.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='Data Management' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='QuickSearch.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='Quick Gene Search' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='AdvancedQuery.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='Advanced Query' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='RefineSearch.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='Refine Search' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='ListofExperiment.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='List of Experiment' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
       </table>
EOT;
    }

    else if ($role=="Administrator")
    {
      echo <<<EOT
<table class='_100'>
      	<tr>
      		<td class='_100c'>
      		<form  action='newprofile.php' method='post' name='usermanagement'>
      			<input id='btnLogin' type='submit' value='Your Profile Update' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='usermanagement.php' method='post' name='usermanagement'>
      			<input id='btnLogin' type='submit' value='User Setup' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='DataManagement.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='Data Management' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='QuickSearch.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='Quick Gene Search' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='AdvancedQuery.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='Advanced Query' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='RefineSearch.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='Refine Search' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='ListofExperiment.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='List of Experiment' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
       </table>
EOT;
    }
    else
    {
      echo <<<EOT
      	<tr>
      		<td class='_100c'>
      		<form  action='QuickSearch.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='Quick Gene Search' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='AdvancedQuery.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='Advanced Query' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='RefineSearch.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='Refine Search' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
      	<tr>
      		<td class='_100c'>
      		<form  action='ListofExperiment.php' method='post' name='index'>
      			<input id='btnLogin' type='submit' value='List of Experiment' style='width:40%;font-weight:bold;height:35px;COLOR:#4682B4'/>
      		</form>
      		</td>
      	</tr>
       </table>
EOT;
    }




    ?>
      <?php include("footer.php"); ?>
  </body>
</html>








