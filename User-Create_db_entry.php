<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "";
echo "<head>";
echo "    <title> HIMS : User Create</title>";
echo "    <link rel='stylesheet' href='hims.css' type='text/css'>";
echo "    <link href='https://fonts.googleapis.com/css?family=Fjalla One' rel='stylesheet'>";
echo "    <link rel='stylesheet' type='text/css' href='/fontawesome-free-5.12.1-web/css/all.css'>";
echo "    <meta charset='UTF-8' name='viewport' content='width=device-width,initial-scale=1.0'>";
echo "</head>";

echo "<body>";

$loginId=$_POST["loginId"];
$name=$_POST["name"];
$fname=$_POST["fname"];
$email=$_POST["email"];
$password=$_POST["password"];

echo "    <h1> Hospital Inventory Management System </h1>";
echo "<BR><BR><BR>";
displayAdminMenu ($loginId);

$conn = OpenCon();

//$sql = 'create table user (user_id smallint auto_increment primary key, user_name varchar(20) unique not null, user_fname varchar(30) not null, user_email varchar(30) not null, password varchar(20) not null);';

$sql = 'insert into user (user_name, user_fname, user_email, password) values ( \'' . $name . '\', \'' . $fname . '\', \'' . $email . '\', \'' . $password . '\')';

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
      return -1;
}
else
{
    echo "<br><br><center>User " . $name . " is created successfully</center>";
}

CloseCon($conn);

echo "    <footer>";
echo "        <ul>";
echo "            <li><a href='#'><i class='fab fa-facebook-f' aria-hidden='true'> </i> </a> </li>";
echo "            <li><a href='#'><i class='fab fa-twitter' aria hidden='true'> </i> </a> </li>";
echo "            <li><a href='#'><i class='fab fa-instagram' aria-hidden='true'> </i> </a></li>";
echo "            <li><a href='#'><i class='fab fa-linkedin-in' aria-hidden='true'> </i> </a></li>";
echo "        </ul>";
echo "    </footer>";

echo "</body>";

echo "</html>";


?>
