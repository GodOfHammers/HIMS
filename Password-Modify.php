<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>"; 
echo "<html lang='en'>";
echo "";
echo "<head>";
echo "    <meta charset='UTF-8' name='viewport' content='width=device-width,initial-scale=1.0'>";
echo "    <title> HIMS - Password Change </title>";
echo "    <link rel='stylesheet' href='hims.css' type='text/css'>";
echo "    <link href='https://fonts.googleapis.com/css?family=Fjalla One' rel='stylesheet'>";
echo "    <link rel='stylesheet' type='text/css' href='/fontawesome-free-5.12.1-web/css/all.css'>";

echo "
<script>
	function clearScreen()
	{
		document.getElementById('password').value = '';
		document.getElementById('npwd').value = '';
		document.getElementById('cnpwd').value = '';
	}
</script>
";
echo "</head>";
 
echo "<body>";


echo "    <h1> Hospital Inventory Management System </h1><br><br><br>"; 

$loginId=$_GET["name"];

if ($loginId == 'admin')
{
	displayAdminMenu ($loginId);
}
elseif ($loginId == 'manager')
{
	displayManagerMenu ($loginId);
}
elseif ($loginId == "sales")
{
	displaySalesMenu ($loginId);
}
else
{
	echo "Invalid User from " . $loginId . "in file Password-Modify.php";
}

$conn = OpenCon();
$password_in_db = getPassword($conn, $loginId);
CloseCon($conn);

echo "    <form name='changePasswordForm' method='POST' onSubmit='a=this.elements.password.value; b=this.elements.password_in_db.value; c=this.elements.npwd.value; d=this.elements.cnpwd.value; if(a != b) {alert(\"Current Password didnt match\"); return false;} else if (c != d) {alert(\"New Passwords didnt match\"); return false;} else {return true;}' action='Password-Modify_db_entry.php' class='form_1'>\n";

echo "        <h3> Change Password </h3>\n";
echo "        <label for='name' class='required'> Username: </label>";
echo "        <input type='text' id='name' name='name' value='" . $loginId . "' style='margin-left: 80px;' readonly><br/>";

echo "        <label for='password' class='required'> Current Password: </label>";
echo "        <input type='password' id='password' name='password' placeholder='Enter Current Password' style='margin-left: 30px;' required><br/>";
echo "        <input type='hidden' id=password_in_db' name='password_in_db' value='" . $password_in_db . "'>";

echo "        <label for='npwd' class='required'> New Password: </label>";
echo "        <input type='password' id='npwd' name='npwd' placeholder='Enter New Password' style='margin-left: 55px;' required><br/>";

echo "        <label for='cnpwd' class='required'> Confirm New Password: </label>";
echo "        <input type='password' id='cnpwd' name='cnpwd' placeholder='Confirm New Password' style='margin-left: 0px;' required><br/>";

echo "        <button type='reset' id='reset_1' onclick='clearScreen();'> Cancel </button>";
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
echo "";
echo "</body>";
echo "";
echo "</html>";
?>


