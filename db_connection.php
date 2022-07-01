<?php

function OpenCon()
{
$servername = "localhost";
$username = "root";
$password = "BlueDragon12";
$db = "HIMS";

// Create connection : Call Type-1
$conn = new mysqli($servername, $username, $password,$db) or die("Connect failed: %s\n". $conn -> error);

// Create connection : Call Type-2
//$conn = new mysqli($servername, $username, $password);
// Check connection
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}

// Create connection : Call Type-3
//$conn = mysqli_connect($servername, $username, $password);
// Check connection
//if (!$conn) 
//   {
//       die("Connection failed: " . mysqli_connect_error());
//   }

//echo "Connected successfully";

return $conn;
}

function CloseCon($conn)
{
$conn -> close();
}

//---------------------------------------------------
// Get the password for given user name
// Returns "" if given user name not found in DB
// Returns password if given user name is found in DB
//---------------------------------------------------
function getPassword($conn, $name) { 

    $sql = 'select * from user where user_name = \'' . $name . '\'';


    // run the query 
    if (!$result = $conn->query($sql)) {
      // Handle error
      echo "Sorry, this website is experiencing problems.";
      echo "Error: Query failed to execute, here is why: \n";
      echo "Query: " . $sql . "\n";
      echo "Errno: " . $conn->errno . "\n";
      echo "Error: " . $conn->error . "\n";
      exit;
    }

    // If zero rows....
    if ($result->num_rows === 0) {
        return "";
    }

    //output data in HTML table 
    //echo "<table border=1>\n"; 
    //while ($row = $result->fetch_assoc()) {     
    //    echo "  <tr>\n";
    //    echo "    <td>" . $row['user_name'] . "</td>\n";
    //    echo "    <td>" . $row['password'] . "</td>\n";
    //    echo "  </tr>\n"; 
    //}
    //echo "</table>"; 

    if($row = $result->fetch_assoc())
    {
       $password = $row['password'];
       //echo "Debug: Password for user : " . $name . " is : " . $password ;
       return $password;
    }
    else
    {
        return "";
    }
}

function getPharmaList ()
{
  $conn = OpenCon();

  $sql = "select * from pharma_company where pharma_status='1';";

  if (!$result = $conn->query($sql)) 
  {
      echo "<br><br>Sorry, this website is experiencing problems.";
      echo "Error: Query failed to search for list of pharma companies, here is why: <br>";
      echo "Query: " . $sql . "<br>";
      echo "Errno: " . $conn->errno . "<br>";
      echo "Error: " . $conn->error . "<br>";
      CloseCon($conn);
      return -1;
  }
  else
  {
      $pharmaCount = 0;

      while($row = $result->fetch_assoc())
      {
        if ($pharmaCount == 0)
        {
          echo "        <label for='name' class='required'> Pharma Company Name: </label>";
          echo "<select name='company' id='companyList' >\n";
        }
        echo "<option value='" . $row['pharma_name'] . "'> " . $row['pharma_name'] . "</option>\n";

        $pharmaCount++;
      }

      CloseCon($conn);

      if ($pharmaCount > 0){
        echo "</select>\n";
      }
      else {
        echo "<BR><center>There are no companies </center>";
        return -1;
    }
}

}

function getItemNamesList ()
{
  $conn = OpenCon();

  $sql = "select item_name from item where item_status='1';";

  if (!$result = $conn->query($sql)) 
  {
      echo "<br><br>Sorry, this website is experiencing problems.";
      echo "Error: Query failed to search for list of items, here is why: <br>";
      echo "Query: " . $sql . "<br>";
      echo "Errno: " . $conn->errno . "<br>";
      echo "Error: " . $conn->error . "<br>";
      CloseCon($conn);
      return -1;
  }
  else
  {
      $itemCount = 0;

      while($row = $result->fetch_assoc())
      {
        if ($itemCount == 0)
        {
          echo "        <label for='name' class='required'> Item Name: </label>";
          echo "        <select name='name' id='companyList' >\n";
        }
        echo "<option value='" . $row['item_name'] . "'> " . $row['item_name'] . "</option>\n";

        $itemCount++;
      }

      CloseCon($conn);

      if ($itemCount > 0){
        echo "</select>\n";
      }
      else {
        echo "<BR><center>There are no items </center>";
        return -1;
      }
  }

}
?>
