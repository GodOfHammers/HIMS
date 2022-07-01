<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>"; 
echo "<html lang='en'>";
echo "";
echo "<head>";
echo "    <title> HIMS : Password Modify </title>";
echo "    <link rel='stylesheet' href='hims.css' type='text/css'>";
echo "    <link href='https://fonts.googleapis.com/css?family=Fjalla One' rel='stylesheet'>";
echo "    <link rel='stylesheet' type='text/css' href='/fontawesome-free-5.12.1-web/css/all.css'>";
echo "    <meta charset='UTF-8' name='viewport' content='width=device-width,initial-scale=1.0'>";
echo "</head>";
 
echo "<body>";
echo "    <h1> Hospital Inventory Management System </h1><br><br><br>"; 

$loginId=$_POST["name"];
$password=$_POST["npwd"];

#echo "<BR><BR><BR>";

if ($loginId == 'admin')
{
	displayAdminMenu ($loginId);

}
elseif ($loginId == 'manager')
{
	displayManagerMenu ($loginId);

}
elseif ($loginId == "sales")
{
	displaySalesMenu ($loginId);

}
else
{
 // to be coded
}

$conn = OpenCon();
$sql = "update user set password='" . $password . "' where user_name = '" . $loginId . "';";

//echo "Debug : Query: " . $sql . "<br>";

// run the query 
if (!$result = $conn->query($sql)) 
{
    // Handle error
    echo "Sorry, this website is experiencing problems.";
    echo "Error: Query failed to execute, here is why: <br>";
    echo "Query: " . $sql . "<br>";
    echo "Errno: " . $conn->errno . "<br>";
    echo "Error: " . $conn->error . "<br>";
}
else 
{
    echo "<br><br><center>Password is changed for User " . $loginId . " successfully</center>";
}
CloseCon($conn);


echo "";
echo "    <footer>";
echo "        <ul>";
echo "            <li><a href='#'><i class='fab fa-facebook-f' aria-hidden='true'> </i> </a> </li>";
echo "            <li><a href='#'><i class='fab fa-twitter' aria hidden='true'> </i> </a> </li>";
echo "            <li><a href='#'><i class='fab fa-instagram' aria-hidden='true'> </i> </a></li>";
echo "            <li><a href='#'><i class='fab fa-linkedin-in' aria-hidden='true'> </i> </a></li>";
echo "        </ul>";
echo "    </footer>";
echo "";
echo "</body>";
echo "";
echo "</html>";
?>

