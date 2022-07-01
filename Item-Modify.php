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

echo "    <form method='POST' action='Item-Modify_confirm.php' class='form_1'>";

echo "        <h3> Item Modify </h3>";

if (getItemNamesList() != -1)
{
  echo "        <input type='hidden' id='name' name='loginId' value= '" . $loginId . "'>";

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
}
echo "</body>";

echo "</html>";


?>
