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

        $sql = 'select * from pharma_company ;';
        if (!$result = $conn->query($sql)) 
        {
            echo "<br><br>Sorry, this website is experiencing problems.";
            echo "Error: Query failed to search for list of companies, here is why: <br>";
            echo "Query: " . $sql . "<br>";
            echo "Errno: " . $conn->errno . "<br>";
            echo "Error: " . $conn->error . "<br>";
            CloseCon($conn);
            return -1;
        }
        else
        {
            show_confirm_form ($loginId, $name, $company, $composition, $price, $minStock, $stockAvailable, $result);
        }
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


//-------------------------------------------------------------------------------------------------------
// Last parameter of this function contains list of company names.
// Show them as a list in the modify window. Default selection should be the current value of the company
//-------------------------------------------------------------------------------------------------------

function show_confirm_form ($loginId, $name, $company, $composition, $price, $minStock, $stockAvailable, $result)
{
    echo "    <form method='POST' action='Item-Modify_db_entry.php' class='form_1' style='padding-top:25px;'>";
    echo "        <h3> Item Modify </h3>";

    echo "        <label for='name' > Item Name:</label>";
    echo "        <input type='text' id='name' name='name' value='" . $name . "' style='margin-left: 95px;' readonly><br>";

    echo "        <label for='company' > Company name:</label>";

    echo " <select id='companyList' name='company' style='margin-left: 60px;'>";
    while($row = $result->fetch_assoc())
    {
        $compListItem = $row['pharma_name'];
        if ($company == $compListItem)
        {
             echo "<option selected value='". $compListItem . "'> " . $compListItem . " </option>";
        }
        else
        {
             echo "<option value='". $compListItem . "'> " . $compListItem . " </option>";
        }
    }
    echo " </select> <br>";

    echo "        <label for='composition' class='required'> Chemical composition :</label>";
    echo "        <input type='text' id='composition' name='composition' value='" . $composition . "' required><br>";

    echo "        <label for='price' class='required'> Price per unit :</label>";
    echo "        <input type='number' id='price' name='price' value='" . $price . "' style='margin-left: 56px;' required><br>";

    echo "        <label for='minStock' class='required'> Minimum stock:</label>";
    echo "        <input type='number' id='minStock' name='minStock' value='" . $minStock . "' style='margin-left: 50px;' required><br>";

    echo "        <label for='stockAvailable' class='required'> Stock available:</label>";
    echo "        <input type='number' id='stockAvailable' name='stockAvailable' value='" . $stockAvailable . "' style='margin-left: 50px;' required><br>";

    echo "        <input type='hidden' id='loginId' name='loginId' value= '" . $loginId . "'>";
    echo "        <button type='reset' onclick='cancelHandler()' id='reset_1'> Cancel </button>";
    echo "        <button type='submit' id='submit_1'> Modify </button><br/><br/>";
    echo "    </form>";
}

?>

