<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "";
echo "<head>";
echo "    <title> HIMS : Item Delete</title>";
echo "    <link rel='stylesheet' href='hims.css' type='text/css'>";
echo "    <link href='https://fonts.googleapis.com/css?family=Fjalla One' rel='stylesheet'>";
echo "    <link rel='stylesheet' type='text/css' href='/fontawesome-free-5.12.1-web/css/all.css'>";
echo "    <meta charset='UTF-8' name='viewport' content='width=device-width,initial-scale=1.0'>";
echo "</head>";

echo "<body>";

$loginId=$_POST["loginId"];
$name=$_POST["name"];

echo "    <h1> Hospital Inventory Management System </h1>";
echo "<BR><BR><BR>";
displayAdminMenu ($loginId);

$conn = OpenCon();

$sql = 'delete from item where item_name=\'' . $name . '\';';
if (!$result = $conn->query($sql)) 
{
    // Below error comes when an item can't be deleted because it is associated with ordered_items_of_bill
    if($conn->errno == 1451)
    {
				$sql = "update item set stockAvailable='0', minimumStockRequired='0', item_status='0' where item_name='" . $name . "';";
				if (!$result = $conn->query($sql)) 
				{
								echo "<br><br>Sorry, this website is experiencing problems.";
						echo "Error: Query failed to update stockAvailable = 0 for the item, here is why: <br>";
						echo "Query: " . $sql . "<br>";
						echo "Errno: " . $conn->errno . "<br>";
						echo "Error: " . $conn->error . "<br>";
				}
        else
        {
            echo "<BR><BR><center> Since this item is already purchased by someone, It can't be deleted.<BR>";
            echo "So, instead of deleting it from DB, setting the status of the item to inactive</center>";
        }
    }
    else
    {
	    echo "<BR><BR>Sorry, this website is experiencing problems.";
	    echo "Error: Query failed to delete item, here is why: <br>";
	    echo "Query: " . $sql . "<br>";
	    echo "Errno: " . $conn->errno . "<br>";
	    echo "Error: " . $conn->error . "<br>";
    }
}
else 
{
    echo "<br><br><center>Item name '" . $name . "' is deleted successfully</center>";
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

