<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>" ;
echo "<html lang='en'>" ;

echo "<head>" ;
echo "    <title> HIMS Login </title>" ;
echo "    <link rel='stylesheet' href='hims.css' type='text/css'>" ;
echo "    <link href='https://fonts.googleapis.com/css?family=Fjalla One' rel='stylesheet'>";
echo "    <link rel='stylesheet' type='text/css' href='/fontawesome-free-5.12.1-web/css/all.css'>";
echo "    <meta charset='UTF-8' name='viewport' content='width=device-width,initial-scale=1.0'>";
echo "</head>" ;

echo "<body>" ;

$loginId=$_POST["name"];
$InputPassword =$_POST["password"];

$conn = OpenCon();
$DbPassword = getPassword ($conn, $loginId);
CloseCon($conn);

echo "    <h1> Hospital Inventory Management System </h1> <br><br><br>" ;

if ($DbPassword == "" )
{
	displayLoginMenu();
        echo "<br><br><center>Unknown user : " . $loginId . " <br>Please try again.</center>";

	// echo "<br>Debug: SQL query used is: " . $sql;
}
elseif ($InputPassword != $DbPassword)
{
	displayLoginMenu();
        echo "<br><br><center>Password did not match for user : " . $loginId . " <br>Please try again.</center>";
}
else // User exists and passwords matched
{

	if ($loginId == 'admin')
	{
		displayAdminMenu($loginId);
	}
	elseif ($loginId == 'manager')
	{
		displayManagerMenu($loginId);
	}
	elseif ($loginId == "sales")
	{
		displaySalesMenu($loginId);
	}
	else // Ideally this case should not occur. Unless someone entered a new user ID in DB, without my knowledge.
	{
		displayLoginMenu();
	        echo "<br><br><center>Unknown user : " . $loginId . " <br>Please try again.</center>";
	}
}

echo "    <form method='POST' action='Login.php' class='form_1'>" ;

if ($DbPassword == "" or $InputPassword != $DbPassword)
{
	#displayLoginScreen();
}
elseif ($loginId == "admin" || $loginId == "manager" || $loginId == "sales")
{
	echo "<center>" ;
	echo "<h3> Welcome,  $loginId </h3>" ;
	echo "</center>" ; 

	echo "<input type='hidden' value=$loginId name='name' />" ;
	echo "</form>" ;
}
else
{
	#displayLoginScreen();
}

echo "    <footer>" ;
echo "        <ul>" ;
echo "            <li><a href='#'><i class='fab fa-facebook-f' aria-hidden='true'> </i> </a> </li>" ;
echo "            <li><a href='#'><i class='fab fa-twitter' aria hidden='true'> </i> </a> </li>" ;
echo "            <li><a href='#'><i class='fab fa-instagram' aria-hidden='true'> </i> </a></li>" ;
echo "            <li><a href='#'><i class='fab fa-linkedin-in' aria-hidden='true'> </i> </a></li>" ;
echo "        </ul>" ;
echo "    </footer>" ;
echo "</body>" ;
echo "</html>" ;



?>