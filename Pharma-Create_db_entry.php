<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";

echo "<head>";
echo "    <title> HIMS : Pharma Create</title>";
echo "    <link rel='stylesheet' href='hims.css' type='text/css'>";
echo "    <link href='https://fonts.googleapis.com/css?family=Fjalla One' rel='stylesheet'>";
echo "    <link rel='stylesheet' type='text/css' href='/fontawesome-free-5.12.1-web/css/all.css'>";
echo "    <meta charset='UTF-8' name='viewport' content='width=device-width,initial-scale=1.0'>";
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

$sql = "DESCRIBE pharma_company;";
$result = $conn->query( $sql );
if (!$result) 
{
    if ($conn->errno == 1146) // if the table does not exist, create it!
    {
        $sql = "create table pharma_company (pharma_id smallint auto_increment, pharma_name varchar(20) unique not null, pharma_city varchar(20) not null, pharma_email varchar(30) not null, pharma_spName varchar(30) not null, pharma_spPhone varchar(20) not null, pharma_discount tinyint not null, pharma_status boolean not null, constraint primary key(pharma_id) );";
        $result = $conn->query( $sql );
        if (!$result)
        {
             echo "<br>Sorry, this website is experiencing problems.";
             echo "Error: Query failed to create the table, here is why: <br>";
             echo "Query: " . $sql . "<br>";
             echo "Errno: " . $conn->errno . "<br>";
             echo "Error: " . $conn->error . "<br>";
             return -1;
        }
    }
    else
    {
         echo "<br>Sorry, this website is experiencing problems.";
         echo "Error: Query failed to find the existance of the table, here is why: <br>";
         echo "Query: " . $sql . "<br>";
         echo "Errno: " . $conn->errno . "<br>";
         echo "Error: " . $conn->error . "<br>";
         return -1;
    }
}

$sql = "insert into pharma_company (pharma_name, pharma_city, pharma_email, pharma_spName, pharma_spPhone, pharma_discount, pharma_status) values ( '" . $name . "', '" . $city . "', '" . $email . "', '" . $spName . "', '" . $spPhone . "', '" . $discount . "', '1');";
if (!$result = $conn->query($sql)) 
{
    echo "<br>Sorry, this website is experiencing problems.";
    echo "Error: Query failed to execute, here is why: <br>";
    echo "Query: " . $sql . "<br>";
    echo "Errno: " . $conn->errno . "<br>";
    echo "Error: " . $conn->error . "<br>";
    return -1;
}
else
{
    echo "<br><br><center>Pharma Company \"" . $name . "\" is created successfully</center>";
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
