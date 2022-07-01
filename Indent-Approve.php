<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";

echo "<head>";
echo "    <title> HIMS : Indent Approve</title>";
echo "    <link rel='stylesheet' href='hims.css' type='text/css'>";
echo "    <link href='https://fonts.googleapis.com/css?family=Fjalla One' rel='stylesheet'>";
echo "    <link rel='stylesheet' type='text/css' href='/fontawesome-free-5.12.1-web/css/all.css'>";
echo "    <meta charset='UTF-8' name='viewport' content='width=device-width,initial-scale=1.0'>";

echo "<script>
    function cancelForm(){
        if (object = document.getElementById('pendingIndent')){
            object.selectedIndex =0;
        }
    }
</script>";
echo "</head>";

echo "<body>";

$loginId=$_GET["name"];

echo "    <h1> Hospital Inventory Management System </h1>";
echo "<BR><BR><BR>";
displayManagerMenu ($loginId);

$conn = OpenCon();

// Query for pending i.e, unapproved indents
$sql = "select * from indent where indent_status='0';";
if (!$result = $conn->query($sql)) 
{
    echo "<br><br>Sorry, this website is experiencing problems.";
    echo "Error: Query failed to search for Indent details, here is why: <br>";
    echo "Query: " . $sql . "<br>";
    echo "Errno: " . $conn->errno . "<br>";
    echo "Error: " . $conn->error . "<br>";
    CloseCon($conn);
    return -1;
}
else
{
    $indentCount = 0;
    while($row = $result->fetch_assoc())
    {
        $indentId = $row["indent_id"];
        $indentDate = $row["indent_date"];
        $indentTime = $row["indent_time"];
        $indentValue = $row["indent_value"];

        if ($indentCount == 0)
        {
	     echo "    <form method='POST' action='Indent-Approve_confirm.php' class='form_1'>";
	     echo "        <h3> Indent Approve </h3>";
	     echo "        <label for='name' class='required'> Pending Indents : </label>";

             echo "        <select name='pendingIndent'> ";
        }
        echo "                  <option value=" . $indentId . "||" . $indentDate . "||" . $indentTime . "||" . $indentValue . "INR>"  . $indentId . "||" . $indentDate . "||" . $indentTime . "||" . $indentValue . "INR</option>" ;
        $indentCount ++;
    }

    if($indentCount > 0)
    {
        echo "</select>";
        echo "        <input type='hidden' id='name' name='loginId' value= '" . $loginId . "'>";
        echo "        <button type='reset' id='reset_1' onclick='cancelForm()'> Cancel </button>";
	echo "        <button type='submit' id='submit_1'> Submit </button><br/><br/>";
	echo "</form>";
    }
    else
    {
        echo "<br><center>There are no pending indents to approve</center>";
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

?>