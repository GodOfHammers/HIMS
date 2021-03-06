<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";

echo "<head>";
echo "    <title> HIMS : Item Create</title>";
echo "    <link rel='stylesheet' href='hims.css' type='text/css'>";
echo "    <link href='https://fonts.googleapis.com/css?family=Fjalla One' rel='stylesheet'>";
echo "    <link rel='stylesheet' type='text/css' href='/fontawesome-free-5.12.1-web/css/all.css'>";
echo "    <meta charset='UTF-8' name='viewport' content='width=device-width,initial-scale=1.0'>";

echo "</head>";

echo "<body>";

$loginId=$_POST["loginId"];
$rowCount=$_POST["rowCount"];
$indentValue=$_POST["indentValue"];

echo "    <h1> Hospital Inventory Management System </h1>";
echo "<br><br><br>";
displaySalesMenu ($loginId);

$conn = OpenCon();

$sql = "DESCRIBE indent;";
$result = $conn->query( $sql );
if (!$result) 
{
    if ($conn->errno == 1146) // if the table does not exist, create it!
    {
        $sql = "create table indent(indent_id smallint auto_increment primary key, indent_date date, indent_time time, indent_status boolean not null, indent_value float not null );";
        $result = $conn->query( $sql );
        if (!$result)
        {
             echo "<br>Sorry, this website is experiencing problems.";
             echo "Error: Query failed to create the indent table, here is why: <br>";
             echo "Query: " . $sql . "<br>";
             echo "Errno: " . $conn->errno . "<br>";
             echo "Error: " . $conn->error . "<br>";
             CloseCon($conn);
             return -1;
        }
    }
    else
    {
         echo "<br>Sorry, this website is experiencing problems.";
         echo "Error: Query failed to find the existance of the indent table, here is why: <br>";
         echo "Query: " . $sql . "<br>";
         echo "Errno: " . $conn->errno . "<br>";
         echo "Error: " . $conn->error . "<br>";
         CloseCon($conn);
         return -1;
    }
}

$sql = "DESCRIBE indented_items;";
$result = $conn->query( $sql );
if (!$result) 
{
    if ($conn->errno == 1146) // if the table does not exist, create it!
    {
        $sql = "create table indented_items (indent_id smallint not null, item_name varchar(20) not null, indented_quantity int not null, primary key (indent_id, item_name), foreign key (item_name) references item(item_name), foreign key (indent_id) references indent(indent_id));";
        $result = $conn->query( $sql );
        if (!$result)
        {
             echo "<br>Sorry, this website is experiencing problems.";
             echo "Error: Query failed to create the indented_items table, here is why: <br>";
             echo "Query: " . $sql . "<br>";
             echo "Errno: " . $conn->errno . "<br>";
             echo "Error: " . $conn->error . "<br>";
             CloseCon($conn);
             return -1;
        }
    }
    else
    {
         echo "<br>Sorry, this website is experiencing problems.";
         echo "Error: Query failed to find the existance of the indented_items table, here is why: <br>";
         echo "Query: " . $sql . "<br>";
         echo "Errno: " . $conn->errno . "<br>";
         echo "Error: " . $conn->error . "<br>";
         CloseCon($conn);
         return -1;
    }
}

// 1. Store data in indent table
$sql = "insert into indent(indent_date,indent_time,indent_status,indent_value) values(curdate(),now(),'0','" . $indentValue . "');";

if (!$result = $conn->query($sql)) 
{
    echo "<br><br>Sorry, this website is experiencing problems.";
    echo "Error: Query failed to insert Indent details, here is why: <br>";
    echo "Query: " . $sql . "<br>";
    echo "Errno: " . $conn->errno . "<br>";
    echo "Error: " . $conn->error . "<br>";
    CloseCon($conn);
    return -1;
}

$sql = 'select indent_id from indent where indent_id = (select max(indent_id) from indent);';

if (!$result = $conn->query($sql)) 
{
    echo "<br><br>Sorry, this website is experiencing problems.";
    echo "Error: Query failed to search for indent_id from latest entry added in Table Indent, here is why: <br>";
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
    $indentId = $row["indent_id"];
  }

  else
  {
    echo "<br><br>Sorry, this website is experiencing problems.";
    echo "Error: Query failed to search for specified indent_id from the Table Bill";
    CloseCon($conn);
    return -1;
  }
  
  // 2. Store data in indented_items
  
  for ($i = 0; $i < $rowCount; $i++)
  {
    $item_name_full=$_POST["itemName_".$i];
    $itemName = explode("||", $item_name_full)[0];
    $indentedQty=$_POST["indentedQty_".$i];
    
    $sql = 'insert into indented_items values ("'. $indentId . '","' . $itemName .'","'. $indentedQty .'");';
    if (!$result = $conn->query($sql)) 
    {
        echo "<br><br>Sorry, this website is experiencing problems.";
        echo "Error: Query failed to search for bill_id from latest entry added in Table Bill, here is why: <br>";
        echo "Query: " . $sql . "<br>";
        echo "Errno: " . $conn->errno . "<br>";
        echo "Error: " . $conn->error . "<br>";
        CloseCon($conn);
        return -1;
    }
  } 

  echo "<p align='center'>Indent ".$indentId." is successfully created</p>";
  
  /*$to="pbhaskar@synopsys.com";
  $subject="HTML email";
  $message="Hi there, how're you doin'";
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $headers .= "From: <polis.srikanth@gmail.com>" . "\r\n";
  mail($to,$subject,$message,$headers);*/
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