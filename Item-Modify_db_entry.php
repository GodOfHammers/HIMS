<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "";
echo "<head>";
echo "    <title> HIMS : Item Modify</title>";
echo "    <link rel='stylesheet' href='hims.css' type='text/css'>";
echo "    <link href='https://fonts.googleapis.com/css?family=Fjalla One' rel='stylesheet'>";
echo "    <link rel='stylesheet' type='text/css' href='/fontawesome-free-5.12.1-web/css/all.css'>";
echo "    <meta charset='UTF-8' name='viewport' content='width=device-width,initial-scale=1.0'>";
echo "</head>";

echo "<body>";

$loginId=$_POST["loginId"];
$name=$_POST["name"];
$company=$_POST["company"];
$composition=$_POST["composition"];
$price=$_POST["price"];
$minStock=$_POST["minStock"];
$stockAvailable=$_POST["stockAvailable"];

echo "    <h1> Hospital Inventory Management System </h1>";
echo "<BR><BR><BR>";
displayAdminMenu ($loginId);

$conn = OpenCon();

$sql = "update item set item_company='" . $company . "', item_composition='" . $composition . "', item_price='" . $price . "', minimumStockRequired='" . $minStock . "', stockAvailable='" . $stockAvailable . "' where item_name='" . $name . "';";
if (!$result = $conn->query($sql)) 
{
    echo "<br>Sorry, this website is experiencing problems.";
    echo "Error: Query failed to update item, here is why: <br>";
    echo "Query: " . $sql . "<br>";
    echo "Errno: " . $conn->errno . "<br>";
    echo "Error: " . $conn->error . "<br>";
}
else 
{
    echo "<br><br><center>Item with name '" . $name . "' is modified successfully</center>";
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

