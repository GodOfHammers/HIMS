<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "";
echo "<head>";
echo "    <title> HIMS : Item Create</title>";
echo "    <link rel='stylesheet' href='hims.css' type='text/css'>";
echo "    <link href='https://fonts.googleapis.com/css?family=Fjalla One' rel='stylesheet'>";
echo "    <link rel='stylesheet' type='text/css' href='/fontawesome-free-5.12.1-web/css/all.css'>";
echo "    <meta charset='UTF-8' name='viewport' content='width=device-width,initial-scale=1.0'>";
echo "</head>";

echo "<script>
  function cancelHandler()
  {
    myList = document.getElementsByTagName('form').elements;
    for (var i=0; i<myList.length; i++)
    {
      if (myList[i] instanceof HTMLInputElement)
        myList[i].value = '';
      else if (myList[i] instanceof HTMLSelectElement)
        myList[].selectedIndex = 0;
    }
  }
</script>";

echo "<body>";

echo "    <h1> Hospital Inventory Management System </h1>";

$loginId=$_GET["name"];
echo "<BR><BR><BR>";
displayAdminMenu ($loginId);

echo "<form method='POST' action='Item-Create_db_entry.php' class='form_1' style='margin-top:0px;'>";
echo "        <h3 style='margin-top:10px;'> Item Create </h3>";
echo "        <label for='name' class='required'> Item name: </label>";
echo "        <input type='text' id='name' name='name' placeholder='Enter Item Name' style='margin-left:76px;' required><br/>";

if (getPharmaList() != -1)
{
  echo "        <label for='composition' class='required'> Chemical composition: </label>";
  echo "        <input type='composition' id='composition' name='composition' placeholder='Enter composition' style='margin-left: 5px;' required><br>";

  echo "        <label for='price' class='required'> Price per unit: </label>";
  echo "        <input type='number' id='price' name='price' placeholder='Enter price per unit' style='margin-left:55px;' required><br/>";

  echo "        <label for='minStock' class='required'> Minimum stock: </label>";
  echo "        <input type='number' id='minStock' name='minStock' placeholder='Enter min stock required' style='margin-left:46px;' required><br/>";

  echo "        <label for='stockAvailable' class='required'> Stock available: </label>";
  echo "        <input type='number' id='stockAvailable' name='stockAvailable' placeholder='Enter stock available' style='margin-left:46px;' required><br/>";

  echo "        <input type='hidden' id='name' name='loginId' value= '" . $loginId . "'>";
  echo "        <button type='reset' onclick='cancelHandler()' id='reset_1'> Cancel </button>";
  echo "        <button type='submit' id='submit_1'> Submit </button><br/><br/>";
  echo "</form>";

  echo "    <footer>";
  echo "        <ul>";
  echo "            <li><a href='#'><i class='fab fa-facebook-f' aria-hidden='true'> </i> </a> </li>";
  echo "            <li><a href='#'><i class='fab fa-twitter' aria hidden='true'> </i> </a> </li>";
  echo "            <li><a href='#'><i class='fab fa-instagram' aria-hidden='true'> </i> </a></li>";
  echo "            <li><a href='#'><i class='fab fa-linkedin-in' aria-hidden='true'> </i> </a></li>";
  echo "        </ul>";
  echo "    </footer>";
}
echo "</body>";

echo "</html>";

?>
