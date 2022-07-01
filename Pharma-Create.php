<?php

include 'display_titles.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "";
echo "<head>";
echo "    <title> HIMS : Pharma Create</title>";
echo "    <link rel='stylesheet' href='hims.css' type='text/css'>";
echo "    <link href='https://fonts.googleapis.com/css?family=Fjalla One' rel='stylesheet'>";
echo "    <link rel='stylesheet' type='text/css' href='/fontawesome-free-5.12.1-web/css/all.css'>";
echo "</head>";

echo "<script>
  function cancelHandler()
  {
    myList = document.getElementsByTagName('form').elements;
    for (var i=0; i<myList.length; i++)
      myList[i].value = '';
  }
</script>";

echo "<body>";

echo "    <h1> Hospital Inventory Management System </h1>";

$loginId=$_GET["name"];
echo "<BR><BR><BR>";
displayAdminMenu ($loginId);

echo "<form method='POST' action='Pharma-Create_db_entry.php' class='form_1'>";
echo "        <h3 style='margin-top: 10px'> Pharma Create </h3>";
echo "        <label for='name' class='required'> Pharma Company Name: </label>";
echo "        <input type='text' id='name' name='name' placeholder='Enter Company Name' required><br/>";

echo "        <label for='city' class='required'> City Name: </label>";
echo "        <input type='text' id='city' name='city' placeholder='Enter City Name' style='margin-left: 88px;' required><br/>";

echo "        <label for='email' class='required'> Email ID: </label>";
echo "        <input type='email' id='email' name='email' placeholder='Enter email ID' style='margin-left: 96px;' required><br>";

echo "        <label for='spName' class='required'> Sales Person Name: </label>";
echo "        <input type='text' id='spName' name='spName' placeholder='Enter Sales Person Name' style='margin-left: 28px;' required><br/>";

echo "        <label for='spPhone' class='required'> Sales Person Phone: </label>";
echo "        <input type='number' id='spPhone' name='spPhone' placeholder='Enter Sales Person Phone' style='margin-left: 24px;' required><br/>";

echo "        <label for='discount' class='required'> Discount: </label>";
echo "        <input type='number' id='discount' name='discount' min='0' max='20' placeholder='Enter Discount Offered' style='margin-left: 94px;' required><br/>";

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

echo "</body>";

echo "</html>";


?>
