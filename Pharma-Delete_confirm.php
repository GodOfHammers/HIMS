<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "";
echo "<head>";
echo "    <title> HIMS : Pharma Company Delete - Confirmation</title>";
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

echo "<body style='font-family: Fjalla One;'>";

$loginId=$_POST["loginId"];
$name=$_POST["company"];

echo "    <h1> Hospital Inventory Management System </h1>";
echo "<BR><BR><BR>";
displayAdminMenu ($loginId);

$conn = OpenCon();

$sql = 'select pharma_name, pharma_city, pharma_email, pharma_spName, pharma_spPhone, pharma_discount from pharma_company where pharma_name=\'' . $name . '\';';
if (!$result = $conn->query($sql)) 
{
    // Handle error
    echo "<br><br>Sorry, this website is experiencing problems.";
    echo "Error: Query failed to search for company, here is why: <br>";
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
        $city = $row['pharma_city'];
        $email = $row['pharma_email'];
        $spName = $row['pharma_spName'];
        $spPhone = $row['pharma_spPhone'];
        $discount = $row['pharma_discount'];

        $sql2 = "select item_name from item where item_company='" . $name . "';";
        $itemNames = "";
        if (!$result2 = $conn->query($sql2)) 
        {
            echo "<br><br>Sorry, this website is experiencing problems.";
            echo "Error: Query failed to search for list of items from a given company, here is why: <br>";
            echo "Query: " . $sql . "<br>";
            echo "Errno: " . $conn->errno . "<br>";
            echo "Error: " . $conn->error . "<br>";
            CloseCon($conn);
            return -1;
        }
        else
        {
            $itemCount=0;
            while($row2 = $result2->fetch_assoc())
            {
              //echo "ItemCount = " . $itemCount . " latest ItemName= " . $row2['item_name'];
              if ($itemCount == 0)
              {
                $itemNames = $row2['item_name'];
              }
              else {
                $itemNames = $itemNames . ", " . $row2['item_name'];
              }
              $itemCount++;
            }

            show_confirm_form ($loginId, $name, $city, $email, $spName, $spPhone, $discount, $itemNames);
        }
    }
    else
    {
        echo "<br><br><center> There is no company with name " . $name . "</center>";
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

function show_confirm_form ($loginId, $name, $city, $email, $spName, $spPhone, $discount, $itemNames)
{
    echo "    <form method='POST' action='Pharma-Delete_db_entry.php' class='form_1' style='padding-top: 25px;'>";
    echo "        <h3> Pharma Company Delete - Confirmation </h3>";

    echo "        <label for='name' > Company Name:</label>";
    echo "        <input type='text' id='name' name='name' value='" . $name . "' style='margin-left: 25px;' readonly><br>";

    echo "        <label for='fname' > City:</label>";
    echo "        <input type='text' id='city' name='city' value='" . $city . "' style='margin-left: 95px;' readonly><br>";

    echo "        <label for='email'> Email ID :</label>";
    echo "        <input type='email' id='name' name='email' value='" . $email . "' style='margin-left: 65px;' readonly><br>";

    echo "        <label for='spName'> Sales Person :</label>";
    echo "        <input type='text' id='spName' name='spName' value='" . $spName . "' style='margin-left: 40px;' readonly><br>";

    echo "        <label for='spPhone'> Sales Person Phone:</label>";
    echo "        <input type='text' id='spPhone' name='spPhone' value='" . $spPhone . "' readonly>";

    echo "        <label for='discount'> Discount:</label>";
    echo "        <input type='text' id='discount' name='discount' value='" . $discount . "' style='margin-left: 70px;' readonly>";

    if ($itemNames != ""){
        echo "        <label for='name' > Item Names: </label>";
        echo "        <input type='text' name='itemList' value='" . $itemNames . "' style='margin-left: 50px;'></input>";    
    }

    echo "        <input type='hidden' id='loginId' name='loginId' value= '" . $loginId . "'>";
    echo "        <button type='reset' onclick='cancelHandler()' id='reset_1'> Cancel </button>";
    echo "        <button type='submit' id='submit_1'> Confirm </button><br/><br/>";
    echo "    </form>";

}


?>

