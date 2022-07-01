<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "";
echo "<head>";
echo "    <title> HIMS : User Delete - Confirmation</title>";
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

if ($name == "admin")
{
    echo "<br><br><center>Sorry, 'admin' login ID can't be deleted.<br>";
    echo "Try something else. <br></center>";
    echo "</body>";
    echo "</html>";

    return -1;   
}

$conn = OpenCon();

$sql = 'select user_name, user_fname, user_email from user where user_name=\'' . $name . '\';';
if (!$result = $conn->query($sql)) 
{
    // Handle error
    echo "<br><br>Sorry, this website is experiencing problems.";
    echo "Error: Query failed to search for user, here is why: <br>";
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
        $email = $row['user_email'];
        $fname = $row['user_fname'];

        show_confirm_form ($loginId, $name, $fname, $email);
    }
    else
    {
        echo "<br><br><center> There is no user with name " . $name . "</center>";
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

function show_confirm_form ($loginId, $name, $fname, $email)
{
    echo "    <form method='POST' action='User-Delete_db_entry.php' class='form_1'>";
    echo "        <h3> User Delete - Confirmation </h3>";

    echo "        <label for='name' > Login:</label>";
    echo "        <input type='text' id='name' name='name' value='" . $name . "' style='margin-left: 30px;' readonly><br>";

    echo "        <label for='fname' > Full Name:</label>";
    echo "        <input type='text' id='fname' name='fname' value='" . $fname . "' readonly><br>";

    echo "        <label for='email'> Email ID :</label>";
    echo "        <input type='email' id='name' name='email' value='" . $email . "' style='margin-left: 3px;' readonly><br>";

    echo "        <input type='hidden' id='loginId' name='loginId' value='" . $loginId . "'>";
    echo "        <button type='reset' onclick='cancelHandler()' id='reset_1'> Cancel </button>";
    echo "        <button type='submit' id='submit_1'> Confirm </button><br/><br/>";
    echo "    </form>";
}

?>

