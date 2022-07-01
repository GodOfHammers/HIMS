<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "";
echo "<head>";
echo "    <title> HIMS : Pharma Company Modify</title>";
echo "    <link rel='stylesheet' href='hims.css' type='text/css'>";
echo "</head>";

echo "<body>";

$loginId=$_POST["loginId"];
$name=$_POST["name"];
$city=$_POST["city"];
$email=$_POST["email"];
$spName=$_POST["spName"];
$spPhone=$_POST["spPhone"];
$discount=$_POST["discount"];

echo "    <h1> Hospital Inventory Management System </h1>";
echo "<BR><BR><BR>";
displayAdminMenu ($loginId);

$conn = OpenCon();

$sql = "update pharma_company set pharma_city='" . $city . "', pharma_email='" . $email . "', pharma_spName='" . $spName . "', pharma_spPhone='" . $spPhone . "', pharma_discount='" . $discount . "' where pharma_name='" . $name . "';";
if (!$result = $conn->query($sql)) 
{
    echo "<br>Sorry, this website is experiencing problems.";
    echo "Error: Query failed to update pharma_company, here is why: <br>";
    echo "Query: " . $sql . "<br>";
    echo "Errno: " . $conn->errno . "<br>";
    echo "Error: " . $conn->error . "<br>";
}
else 
{
    echo "<br><br><center>Pharma Company '" . $name . "' is modified successfully</center>";
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

