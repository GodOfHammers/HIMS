<?php

include 'db_connection.php';
include 'display_titles.php';

echo "<!DOCTYPE html>";
echo "<html lang='en'>";

echo "<head>";
echo "    <title> HIMS : Indent Approve - Confirmation</title>";
echo "    <link rel='stylesheet' href='sales.css' type='text/css'>";
echo "    <link href='https://fonts.googleapis.com/css?family=Fjalla One' rel='stylesheet'>";
echo "    <link rel='stylesheet' type='text/css' href='/fontawesome-free-5.12.1-web/css/all.css'>";
echo "    <meta charset='UTF-8' name='viewport' content='width=device-width,initial-scale=1.0'>";

echo "<script>
        
        function OnChangeOfQtyRequired(obj) {
            var table = document.getElementById('inner_table');
            var rowCount = table.rows.length;   

            var qty = obj.value;
            if (qty < 1) {
                alert('Please specify valid value');
                obj.focus();
            } 
            else {
                currentRow = obj.parentElement.parentElement;
                pricePerUnit = parseFloat(currentRow.cells[3].childNodes[1].value);
                currentRow.cells[7].childNodes[0].value = (qty * pricePerUnit).toFixed(2);
                var i,indentValue=0;
                var x;
                    
                for(i=1; i < rowCount;i++){
                    indentValue+=parseFloat(table.rows[i].cells[7].childNodes[0].value);
                }
                document.getElementById('indentValue').value = indentValue.toFixed(2);
            }
        }

        function cancelHandler() {
            var table = document.getElementById('inner_table');
            var rowCount = table.rows.length;
            for (var i = 0; i < rowCount; i++) {
                document.getElementById('indentedQty_' + i).value = document.getElementById('indentedQtyHidden_' + i).value;
            }
        }
</script>";

echo "</head>";

echo "<body>";

$loginId=$_POST["loginId"];
$pendingIndent=$_POST["pendingIndent"]; // contains all columns of indent table for selected row with || separation 

echo "    <h1> Hospital Inventory Management System </h1>";
echo "<BR><BR><BR>";
displayManagerMenu ($loginId);

$conn = OpenCon();

$myArray = explode ("||", $pendingIndent);
$indentId = $myArray[0];
$indentDate = $myArray[1];
$indentTime = $myArray[2];
$indentValue = intval($myArray[3]); // to remove INR at the end
//$indentValue = substr($myArray[3], 0, -3); // to remove INR at the end

$sql = "select * from indented_items where indent_id = '" . $indentId . "';";
if (!$result1 = $conn->query($sql)) 
{
    echo "<br><br>Sorry, this website is experiencing problems.";
    echo "Error: Query failed to search for indent details for a specified indent_id, here is why: <br>";
    echo "Query: " . $sql . "<br>";
    echo "Errno: " . $conn->errno . "<br>";
    echo "Error: " . $conn->error . "<br>";
    CloseCon($conn);
    return -1;
}
else
{   
    echo "    <form method='POST' action='Indent-Approve_db_entry.php' class='form_1'>";
    echo "        <h3 style='margin-top:0'> Indent Approve - Confirmation </h3>";

    echo "        <label for='number' > Indent Id:</label>";
    echo "        <input type='number' id='indentId' name='indentId' value='" . $indentId . "' style='margin-left:20px;' readonly><br>";

    echo "        <label for='indentDate' > Indent Date:</label>";
    echo "        <input type='text' id='indentDate' name='indentDate' value='" . $indentDate . "' style='margin-left: 5px;' readonly><br>";

    echo "        <label for='indentTime'> Indent Time :</label>";
    echo "        <input type='text' id='indentTime' name='indentTime' value='" . $indentTime . "' readonly><br>";


    $rowCount = 0;
    while($row1 = $result1->fetch_assoc())
    {
        $itemName = $row1["item_name"];
        $indentedQty = $row1["indented_quantity"];

	    $sql = "select * from item where item_name = '" . $itemName . "';";
	    if (!$result2 = $conn->query($sql)) 
	    {
	        echo "<br><br>Sorry, this website is experiencing problems.";
	        echo "Error: Query failed to fetch all item details for a specified indent_id, here is why: <br>";
	        echo "Query: " . $sql . "<br>";
	        echo "Errno: " . $conn->errno . "<br>";
	        echo "Error: " . $conn->error . "<br>";
	        CloseCon($conn);
	        return -1;
	    }
	    else
	    {
            // Get the details corresponding to current item
            if($row2 = $result2->fetch_assoc())
	        {
	            $company = $row2['item_company'];
        	    $composition = $row2['item_composition'];
	            $price = $row2['item_price'];
        	    $minStock = $row2['minimumStockRequired'];
	            $stockAvailable = $row2['stockAvailable'];
                $totalPrice=number_format(($price*$indentedQty),2);
                $totalPrice=str_replace(",","",$totalPrice);

                if ($rowCount == 0){
                    echo "<table id='outer_table' border='1'>";
                    echo "<td>";
                    echo "<table id='inner_table' border='1'>";
                    echo "<tr>";
                    echo "        <th> Item Name</th>";
                    echo "        <th> Company name</th>";
                    echo "        <th> Chemical composition</th>";
                    echo "        <th> Price per unit</th>";
                    echo "        <th> Minimum stock</th>";
                    echo "        <th> Stock available</th>";
                    echo "        <th> Indent quantity</th>";
                    echo "        <th> Price</th>";
                    echo "</tr>";          
                }
                echo "<TR>";
                echo "<TD>    <input type='text' id='name' name='itemName_".$rowCount."' value='" . $itemName . "' readonly></TD>";
                echo "<TD>    <input type='text' id='company' name='company' value='" . $company . "' readonly></TD>";
                echo "<TD>    <input type='text' id='composition' name='composition' value='" . $composition . "' readonly></TD>";
                echo "<TD>    <input type='number' id='price' name='price' value='" . $price . "' readonly></TD>";
                echo "<TD>    <input type='number' id='minStock' name='minStock' value='" . $minStock . "' readonly></TD>";
                echo "<TD>    <input type='number' id='stockAvailable' name='stockAvailable_" . $rowCount . "' value='" . $stockAvailable . "' readonly></TD>";

                echo "<TD>    <input type='hidden' id='indentedQtyHidden' name='indentedQtyHidden_" . $rowCount . "value='" . $indentedQty . "' >";
                echo "        <input type='number' id='indentedQty' name='indentedQty_" . $rowCount . "' onchange='OnChangeOfQtyRequired(this);' value='" . $indentedQty . "' required></TD>";

                echo "<td><input type='text' id='priceOfItem' name='priceOfItem' value='" . $totalPrice . "' readonly></td>";

                echo "</TR>";
                $rowCount++;
            }
            else
            {
                echo "<br><br><center> There is no item with name " . $itemName . "</center>";
                CloseCon($conn);
                return -1;
            }
	    }
    }  // while
    if ($rowCount > 0){
        echo "        </TABLE>";
        echo "</TD></TR><TR><TD align='right'>";
        echo "        <label for='indentValue'> Indent Value :</label>";
        echo "        <input type='number' id='indentValue' name='indentValue' value='" . $indentValue . "' readonly><br>";
        echo "</TD></TR></TABLE>";
    }    
    else {
        echo "<br><center>There are no items to approve in this indent</center>";
    }
    
    
    echo "        <input type='hidden' id='loginId' name='loginId' value= '" . $loginId . "'>";
    echo "        <input type='hidden' id='rowCount' name='rowCount' value= '" . $rowCount . "'>";

    echo "        <button type='reset' onclick='cancelHandler()' style='margin-left: 600px' class='buttons' id='reset_1'> Cancel </button>";
    echo "        <button type='submit' class='buttons' id='submit_1'> Confirm </button><br/><br/>";

    echo "    </form>";
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