<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "";
echo "<head>";
echo "    <title> HIMS : Item Delete - Confirmation</title>";
echo "    <link rel='stylesheet' href='hims.css' type='text/css'>";
echo "    <link href='https://fonts.googleapis.com/css?family=Fjalla One' rel='stylesheet'>";
echo "    <link rel='stylesheet' type='text/css' href='/fontawesome-free-5.12.1-web/css/all.css'>";
echo "    <meta charset='UTF-8' name='viewport' content='width=device-width,initial-scale=1.0'>";
echo "</head>";

echo "<script>
  function cancelHandler()
  {
    window.history.back();
  }
</script>";

echo "<body>";

$loginId=$_POST["loginId"];
$name=$_POST["name"];

echo "    <h1> Hospital Inventory Management System </h1>";
echo "<BR><BR><BR>";
displayAdminMenu ($loginId);

$conn = OpenCon();

$sql = 'select * from item where item_name=\'' . $name . '\';';
if (!$result = $conn->query($sql)) 
{
    // Handle error
    echo "<br><br>Sorry, this website is experiencing problems.";
    echo "Error: Query failed to search for item, here is why: <br>";
    echo "Query: " . $sql . "<br>";
    echo "Errno: " . $conn->errno . "<br>";
    echo "Error: " . $conn->error . "<br>";
    CloseCon($conn);
    return -1;
}
else
{
    if($row = $result->fetch_assoc())
    {
        $company = $row['item_company'];
        $composition = $row['item_composition'];
        $price = $row['item_price'];
        $minStock = $row['minimumStockRequired'];
        $stockAvailable = $row['stockAvailable'];

        show_confirm_form ($loginId, $name, $company, $composition, $price, $minStock, $stockAvailable);
        
    }
    else
    {
        echo "<br><br><center> There is no item with name " . $name . "</center>";
        CloseCon($conn);
        return -1;  
    }
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

function show_confirm_form ($loginId, $name, $company, $composition, $price, $minStock, $stockAvailable)
{
    echo "    <form method='POST' action='Item-Delete_db_entry.php' class='form_1' style='padding-top:25px;'>";
    echo "        <h3> Item Delete - Confirmation </h3>";

    echo "        <label for='name' > Item Name:</label>";
    echo "        <input type='text' id='name' name='name' value='" . $name . "' style='margin-left: 84px;' readonly><br>";

    echo "        <label for='company' > Company name:</label>";
    echo "        <input type='text' id='company' name='company' value='" . $company . "' style='margin-left: 54px;' readonly><br>";

    echo "        <label for='composition'> Chemical composition :</label>";
    echo "        <input type='text' id='composition' name='composition' value='" . $composition . "' readonly><br>";

    echo "        <label for='price'> Price per unit :</label>";
    echo "        <input type='text' id='price' name='price' value='" . $price . "' style='margin-left: 55px;' readonly><br>";

    echo "        <label for='minStock'> Minimum stock:</label>";
    echo "        <input type='number' id='minStock' name='minStock' value='" . $minStock . "' style='margin-left: 50px;' readonly><br>";

    echo "        <label for='stockAvailable'> Stock available:</label>";
    echo "        <input type='number' id='stockAvailable' name='stockAvailable' value='" . $stockAvailable . "' style='margin-left: 50px;' readonly><br>";

    echo "        <input type='hidden' id='loginId' name='loginId' value= '" . $loginId . "'>";
    echo "        <button type='reset' onclick='cancelHandler()' id='reset_1'> Cancel </button>";
    echo "        <button type='submit' id='submit_1'> Confirm </button><br/><br/>";
    echo "    </form>";
}

?>

