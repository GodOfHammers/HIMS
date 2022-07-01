<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";

echo "<head>";
echo "    <title> HIMS : Item Create</title>";
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

$sql = "DESCRIBE item;";
$result = $conn->query( $sql );
if (!$result) 
{
    if ($conn->errno == 1146) // if the item table does not exist, create it!
    {
        $sql = "create table item (item_id smallint auto_increment primary key, item_name varchar(20) unique not null, item_company varchar(20) not null, item_composition varchar(100) , item_price float not null, minimumStockRequired int not null, stockAvailable int not null, item_status boolean not null, FOREIGN KEY (item_company) references pharma_company (pharma_name) );";
        $result = $conn->query( $sql );
        if (!$result)
        {
             echo "<br>Sorry, this website is experiencing problems.";
             echo "Error: Query failed to create the item table, here is why: <br>";
             echo "Query: " . $sql . "<br>";
             echo "Errno: " . $conn->errno . "<br>";
             echo "Error: " . $conn->error . "<br>";
             CloseCon($conn);
             return -1;
        }
    }
    else
    {
         echo "<br>Sorry, this website is experiencing problems.";
         echo "Error: Query failed to find the existance of the item table, here is why: <br>";
         echo "Query: " . $sql . "<br>";
         echo "Errno: " . $conn->errno . "<br>";
         echo "Error: " . $conn->error . "<br>";
         CloseCon($conn);
         return -1;
    }
}

$sql = "insert into item (item_name, item_company, item_composition, item_price, minimumStockRequired, stockAvailable, item_status) values ( '" . $name . "', '" . $company . "', '" . $composition . "', '" . $price . "', '" . $minStock . "', '" . $stockAvailable . "', '1');";
if (!$result = $conn->query($sql)) 
{
    echo "<br>Sorry, this website is experiencing problems.";
    echo "Error: Query failed to add item in the table, here is why: <br>";
    echo "Query: " . $sql . "<br>";
    echo "Errno: " . $conn->errno . "<br>";
    echo "Error: " . $conn->error . "<br>";
    CloseCon($conn);
    return -1;
}
else
{
    echo "<br><br><center>Item with name \"" . $name . "\" is created successfully</center>";
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
