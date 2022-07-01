<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";

echo "<head>";
echo "    <title> HIMS : Indent Approve</title>";
echo "    <link rel='stylesheet' href='hims.css' type='text/css'>";
echo "    <link href='https://fonts.googleapis.com/css?family=Fjalla One' rel='stylesheet'>";
echo "    <link rel='stylesheet' type='text/css' href='/fontawesome-free-5.12.1-web/css/all.css'>";
echo "    <meta charset='UTF-8' name='viewport' content='width=device-width,initial-scale=1.0'>";

echo "</head>";

echo "<body>";

$loginId=$_POST["loginId"];
$rowCount=$_POST["rowCount"];
$indentId=$_POST["indentId"];
$indentValue=$_POST["indentValue"];

echo "    <h1> Hospital Inventory Management System </h1>";
echo "<BR><BR><BR>";
displayManagerMenu ($loginId);

$conn = OpenCon();

$sql = "update indent set indent_status='1', indent_value='". $indentValue . "' where indent_id='" . $indentId . "';";

if (!$result = $conn->query($sql)) 
{
    echo "<br><br>Sorry, this website is experiencing problems.";
    echo "Error: Query failed to update Indent details, here is why: <br>";
    echo "Query: " . $sql . "<br>";
    echo "Errno: " . $conn->errno . "<br>";
    echo "Error: " . $conn->error . "<br>";
    CloseCon($conn);
    return -1;
}

 
  // Store data in indented_items
  
  for ($i = 0; $i < $rowCount; $i++)
  {
    $item_name_full=$_POST["itemName_".$i];
    $itemName = explode("||", $item_name_full)[0];
    $indentedQty=$_POST["indentedQty_".$i];
    $stockAvailable=$_POST["stockAvailable_".$i];
    $stockAvailable+=$indentedQty;
    
    //$sql = 'insert into indented_items values ("'. $indentId . '","' . $itemName .'","'. $indentedQty .'");';
    $sql = "update indented_items set indented_quantity = $indentedQty where item_name='" . $itemName . "' and indent_id='". $indentId . "';";
    if (!$result = $conn->query($sql)) 
    {
        echo "<br><br>Sorry, this website is experiencing problems.";
        echo "Error: Query failed to insert values in Table indented_items, here is why: <br>";
        echo "Query: " . $sql . "<br>";
        echo "Errno: " . $conn->errno . "<br>";
        echo "Error: " . $conn->error . "<br>";
        CloseCon($conn);
        return -1;
    }

    $sql = "update item set stockAvailable = $stockAvailable where item_name= '".$itemName."';";
    if (!$result = $conn->query($sql)) 
    {
        echo "<br><br>Sorry, this website is experiencing problems.";
        echo "Error: Query failed to update stock available in Table item, here is why: <br>";
        echo "Query: " . $sql . "<br>";
        echo "Errno: " . $conn->errno . "<br>";
        echo "Error: " . $conn->error . "<br>";
        CloseCon($conn);
        return -1;
    }
  }
  echo "<p align='center'> Indent " . $indentId . " successfully approved </p>"; 

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