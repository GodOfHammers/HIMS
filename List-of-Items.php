<?php

$myList = array();
//$itemCount = 0;


//---------------------------------------------------------------------------------
//
// getItemsList reads all the items in the DB, stores them in a array of structures
//
//---------------------------------------------------------------------------------
function getItemsList ()
{
$conn = OpenCon();

$sql = "select * from item where item_status='1';";

if (!$result = $conn->query($sql)) 
{
    echo "<br><br>Sorry, this website is experiencing problems.";
    echo "Error: Query failed to search for items, here is why: <br>";
    echo "Query: " . $sql . "<br>";
    echo "Errno: " . $conn->errno . "<br>";
    echo "Error: " . $conn->error . "<br>";
}
else
{
    $itemCount = 0;

    while($row = $result->fetch_assoc())
    {
        $myList[$itemCount] = array();

        $myList[$itemCount][0] = $row['item_name'];
        $myList[$itemCount][1] = $row['item_company'];
        $myList[$itemCount][2] = $row['item_composition'];
        $myList[$itemCount][3] = $row['item_price'];
        $myList[$itemCount][4] = $row['minimumStockRequired'];
        $myList[$itemCount][5] = $row['stockAvailable'];

        $itemCount++;
    }

    echo "<select name=\"itemName_0\" id=\"itemlist_1\" onchange=\"itemSelection(this)\">\n";
    echo "<option value=\"-Select Item-|| || ||0|| || \"> -Select Item- </option>\n";
    for ($i=0; $i < $itemCount; $i++)
    {
         echo "<option value='" . $myList[$i][0] . "||" . $myList[$i][1] . "||" . $myList[$i][2] . "||" . $myList[$i][3] . "||" . $myList[$i][4] . "||" . $myList[$i][5] . "'> " . $myList[$i][0] . "</option>\n";
    }
    echo "</select>\n";

}

CloseCon($conn);
return $itemCount;

}


?>
