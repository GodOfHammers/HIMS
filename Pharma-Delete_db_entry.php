<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "";
echo "<head>";
echo "    <title> HIMS : Pharma Company Delete</title>";
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

$sql = 'delete from pharma_company where pharma_name=\'' . $name . '\';';
if (!$result = $conn->query($sql)) 
{    
    // Below error comes when an pharma_company can't be deleted because there are some items created for this company
    if($conn->errno == 1451)
    {
        $sql2 = "select item_name from item where item_company='" . $name . "';";
        if (!$result2 = $conn->query($sql2)) 
        {
            echo "<br><br>Sorry, this website is experiencing problems.";
            echo "Error: Query failed to search for list of items from a given company, here is why: <br>";
            echo "Query: " . $sql2 . "<br>";
            echo "Errno: " . $conn->errno . "<br>";
            echo "Error: " . $conn->error . "<br>";
            CloseCon($conn);
            return -1;
        }
        else
        {
            while($row2 = $result2->fetch_assoc())
            {
                $itemName = $row2['item_name'];
		        $sql3 = "update item set stockAvailable='0', minimumStockRequired='0', item_status='0' where item_name='" . $itemName . "';";
		        if (!$result3 = $conn->query($sql3)) 
		        {
			        echo "<br><br>Sorry, this website is experiencing problems.";
			        echo "Error: Query failed to update item_status = 0 for the item, here is why: <br>";
			        echo "Query: " . $sql3 . "<br>";
			        echo "Errno: " . $conn->errno . "<br>";
			        echo "Error: " . $conn->error . "<br>";
                    CloseCon($conn);
                    return -1;
                }
            }
            $sql4 = "update pharma_company set pharma_status='0' where pharma_name='" . $name . "';";
		    if (!$result4 = $conn->query($sql4)) 
		    {
			    echo "<br><br>Sorry, this website is experiencing problems.";
			    echo "Error: Query failed to update pharma_status = 0 for the pharma company, here is why: <br>";
			    echo "Query: " . $sql4 . "<br>";
			    echo "Errno: " . $conn->errno . "<br>";
			    echo "Error: " . $conn->error . "<br>";
                CloseCon($conn);
                return -1;
            }
            echo "<BR><BR><center> Since this company is already associated with some items, It can't be deleted.<BR>";
            echo "So, instead of deleting them from DB, setting their status to inactive</center>";
        }
    }
    else
    {
	    echo "<BR><BR>Sorry, this website is experiencing problems.";
	    echo "Error: Query failed to delete pharma_company, here is why: <br>";
	    echo "Query: " . $sql . "<br>";
	    echo "Errno: " . $conn->errno . "<br>";
	    echo "Error: " . $conn->error . "<br>";
        CloseCon($conn);
        return -1;
    }
}
else 
{
    echo "<br><br><center>Pharma Company '" . $name . "' is deleted successfully</center>";
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

