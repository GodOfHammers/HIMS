<?php

include 'display_titles.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "";
echo "<head>";
echo "    <meta charset='UTF-8' name='viewport' content='width=devive-width,initial-scale=1.0'>";
echo "    <title> HIMS : User Create</title>";
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

echo "    <form method='POST' action='User-Create_db_entry.php' class='form_1'>";
echo "        <h3> User Create </h3>";
echo "        <label for='name' class='required'> User Name: </label>";
echo "        <input type='text' id='name' name='name' placeholder='Enter user name' required><br/>";

echo "        <label for='fname' class='required'> Full Name: </label>";
echo "        <input type='text' id='name' name='fname' placeholder='Enter Full Name' style='margin-left:2px;' required><br/>";

echo "        <label for='email' class='required'> Email ID: </label>";
echo "        <input type='email' id='name' name='email' placeholder='Enter email ID' style='margin-left:8px;' required><br>";

echo "        <label for='password' class='required'> Password: </label>";
echo "        <input type='password' id='password' name='password' placeholder='Enter password' style='margin-left:3px;' required><br/>";

echo "        <input type='hidden' id='name' name='loginId' value='" . $loginId . "'>";

echo "        <button type='reset' onclick='cancelHandler()' id='reset_1'> Cancel </button>";
echo "        <button type='submit' id='submit_1'> Submit </button><br/><br/>";
echo "    </form>";

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
