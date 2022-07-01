<?php

require('fpdf.php');
include 'db_connection.php';
include 'display_titles.php';

class PDF extends FPDF
{
  function Header()
  {
      global $title;
  
      // Arial bold 15
      $this->SetFont('Arial','B',15);
      // Calculate width of title and position
      $w = $this->GetStringWidth($title)+6;
      $this->SetX((210-$w)/2);
      // Colors of frame, background and text
      $this->SetDrawColor(0,80,180);
      $this->SetFillColor(230,230,0);
      $this->SetTextColor(220,50,50);
      // Thickness of frame (1 mm)
      $this->SetLineWidth(1);
      // Title
      $this->Cell($w,9,$title,1,1,'C',true);
      // Line break
      $this->Ln(10);
  }
  
  function Footer()
  {
      // Position at 1.5 cm from bottom
      $this->SetY(-15);
      // Arial italic 8
      $this->SetFont('Arial','I',8);
      // Text color in gray
      $this->SetTextColor(128);
      // Page number
      $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
  }

    // Colored table
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    //$w = array(40, 35, 40, 40);
    $w = array(40, 35, 30, 30, 30);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Cell($w[4],6,number_format($row[4]),'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}

protected $B = 0;
protected $I = 0;
protected $U = 0;
protected $HREF = '';

function WriteHTML($html)
{
    // HTML parser
    $html = str_replace("\n",' ',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extract attributes
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    // Opening tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    // Closing tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
}

function SetStyle($tag, $enable)
{
    // Modify style and select corresponding font
    $this->$tag += ($enable ? 1 : -1);
    $style = '';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style .= $s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    // Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}

}  

//echo "I came to db_entry file";
$pdf = new PDF();

//$header = array('Item Name', 'Company Name', 'Price Per Item', 'Quantity Ordered');
$header = array('Item Name', 'Company Name', 'Price Per Item', 'Quantity Ordered', 'Price');
// Data loading
//$data = $pdf->LoadData('33.txt');
$pdf->SetFont('Arial','',14);

//$pdf->AddPage();

//echo " <a href='Sale-of-Items.html'></a> ";

$loginId=$_POST["loginId"];
$customerName=$_POST["customerName"];
$customerPhone=$_POST["customerPhone"];
$doctorName=$_POST["doctorName"];
$rowCount=$_POST["rowCount"];
$subTotal=$_POST["subTotal"];
$discount=$_POST["discount"];
$tax=$_POST["tax"];
$grandTotal=$_POST["grandTotal"];

//$stringToDisplay="HIMS BILL\n";
$title = 'HIMS BILL';
$pdf->SetTitle($title);

$pdf->AddPage();
$pdf->SetFont('Arial','I',8);
$pdf->SetTextColor(128);
$pdf->Text(10,30, "Date: ");
$pdf->Text(35,30,  date("Y-m-d"));
$pdf->Text(100,30, "Time:" );
$pdf->Text(125,30,  date("h:i:sa"));

$conn = OpenCon();

$sql = "DESCRIBE bill;";
$result = $conn->query( $sql );
if (!$result) 
{
    if ($conn->errno == 1146) // if the table does not exist, create it!
    {
        $sql = "create table bill(bill_id smallint auto_increment primary key, customer_name varchar(20) not null, customer_phone varchar(12), doctor_name varchar(20) not null, sub_total int not null, discount int not null, tax int not null, grand_total int not null, bill_date date, bill_time time );";
        $result = $conn->query( $sql );
        if (!$result)
        {
             echo "<br>Sorry, this website is experiencing problems.";
             echo "Error: Query failed to create the bill table, here is why: <br>";
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
         echo "Error: Query failed to find the existance of the bill table, here is why: <br>";
         echo "Query: " . $sql . "<br>";
         echo "Errno: " . $conn->errno . "<br>";
         echo "Error: " . $conn->error . "<br>";
         CloseCon($conn);
         return -1;
    }
}

$sql = "DESCRIBE ordered_items_of_a_bill;";
$result = $conn->query( $sql );
if (!$result) 
{
    if ($conn->errno == 1146) // if the table does not exist, create it!
    {
        $sql = "create table ordered_items_of_a_bill (bill_id smallint not null, item_name varchar(20) not null, qty_ordered int not null, primary key (bill_id, item_name), foreign key (item_name) references item(item_name), foreign key (bill_id) references bill(bill_id));";
        $result = $conn->query( $sql );
        if (!$result)
        {
             echo "<br>Sorry, this website is experiencing problems.";
             echo "Error: Query failed to create the ordered_items_of_a_bill table, here is why: <br>";
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
         echo "Error: Query failed to find the existance of the ordered_items_of_a_bill table, here is why: <br>";
         echo "Query: " . $sql . "<br>";
         echo "Errno: " . $conn->errno . "<br>";
         echo "Error: " . $conn->error . "<br>";
         CloseCon($conn);
         return -1;
    }
}

// 1. Store data in bill table
$sql = 'insert into bill(customer_name,customer_phone,doctor_name,sub_total,discount,tax,grand_total,bill_date,bill_time) values("'.$customerName.'","'.$customerPhone.'","'.$doctorName.'","'.$subTotal.'","'.$discount.'","'.$tax.'","'.$grandTotal.'",curdate(),now());';

if (!$result = $conn->query($sql)) 
{
    echo "<br><br>Sorry, this website is experiencing problems.";
    echo "Error: Query failed to insert Bill details, here is why: <br>";
    echo "Query: " . $sql . "<br>";
    echo "Errno: " . $conn->errno . "<br>";
    echo "Error: " . $conn->error . "<br>";
    CloseCon($conn);
    return -1;
}

$sql = 'select bill_id from bill where bill_id = (select max(bill_id) from bill);';

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

else
{
  if($row = $result->fetch_assoc())
  {
    $bill_id = $row["bill_id"];
    //echo "Bill ID = " . $bill_id;
  }
  else
  {
    echo "<br><br>Sorry, this website is experiencing problems.";
    echo "Error: Query failed to search for specified bill_id from the Table Bill";
    CloseCon($conn);
    return -1;
  }
  //$myfile = fopen($bill_id.".txt", "w") or die("Unable to open file!");
  
  // 2. Store data in ordered_items_of_a_bill
  
  $pdf->Text(10,40, "Bill ID: ");
  $pdf->Text(35,40,  $bill_id);
  $pdf->Text(100,40, "Doctor Name: ");
  $pdf->Text(125,40,  $doctorName);
  $pdf->Text(10,50, "Customer Name: ");
  $pdf->Text(35,50,  $customerName);
  $pdf->Text(100,50, "Customer Phone: ");
  $pdf->Text(125,50,  $customerPhone);
  $pdf->Ln();
  $pdf->Ln();
  $pdf->Ln();
  $pdf->Ln();

  for($i=0;$i<$rowCount;$i++){
    //echo "<table border='1'>";
    //foreach ($_POST as $key => $value) {
    //    echo "<tr><td> $key </td><td>$value</td></tr>";
    //}
    //echo "</table>";

    $item_name_full=$_POST["itemName_".$i];
    $item_name = explode("||", $item_name_full)[0];
    $qty_ordered=$_POST["qtyRequired_".$i];
    $company_name=$_POST["company_".$i];
    $pricePerItem=$_POST["pricePerItem_".$i];
    //$Price=($pricePerItem)*($qty_ordered); 
    
    //echo "rowCount = $rowCount, bill_id = $bill_id, item_name = $item_name, qty_ordered = $qty_ordered<br>\n";
    //echo "company_name = $company_name, pricePerItem = $pricePerItem<br>\n";

    $sql = 'insert into ordered_items_of_a_bill values ("'.$bill_id.'","'.$item_name.'","'.$qty_ordered.'");';
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
  
    // 3. Reduce the "stockAvailable" in item table by number equal to "Qty required" in item table
  
    $sql = 'select stockAvailable from item where item_name ="'.$item_name.'";';
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
    if($row = $result->fetch_assoc())
    {
      $stock_available = $row["stockAvailable"];
      //echo "stock available for " . $item_name . "= " . $stock_available;
    }
    else
    {
      echo "<br><br>Sorry, this website is experiencing problems.";
      echo "Error: Query failed to get the stock available from the Table Item for item_name = " . $item_name ;
      CloseCon($conn);
      return -1;
    }

    $stock_available -= $qty_ordered;
    $sql = 'update item set stockAvailable = "'.$stock_available.'" where item_name ="'.$item_name.'" ;';
    if (!$result = $conn->query($sql)) 
    {
      echo "<br><br>Sorry, this website is experiencing problems.";
      echo "Error: Query failed to update the stock available in the Table Item, here is why: <br>";
      echo "Query: " . $sql . "<br>";
      echo "Errno: " . $conn->errno . "<br>";
      echo "Error: " . $conn->error . "<br>";
      CloseCon($conn);
      return -1;
    }
    
    $item_row = array();
    $item_row[0] = $item_name;
    $item_row[1] = $company_name;
    $item_row[2] = $pricePerItem;
    $item_row[3] = $qty_ordered;
    $item_row[4] = $pricePerItem * $qty_ordered;
       
    $data[$i] = $item_row;
  }
  
  $pdf->FancyTable($header,$data);
  $x = $pdf->GetX();
  $y = $pdf->GetY();

  $pdf->Text(145,$y+10, "Sub Total: ");
  $pdf->Text(170,$y+10,  $subTotal);
  $pdf->Text(145,$y+20, "Discount: ");
  $pdf->Text(170,$y+20, $discount);
  $pdf->Text(145,$y+30, "Tax: ");
  $pdf->Text(170,$y+30, $tax);
  $pdf->Text(145,$y+40, "Grand Total: ");
  $pdf->Text(170,$y+40, number_format($grandTotal,2));
  
  //$html = '<p> Click here to go to <a href="http://localhost/Sale-of-Items.html?name=sales">Sale-of-Items</a></p>';
  //$pdf->SetFont('Arial','',10);
  //$pdf->SetFont('','U');
  //$link = $pdf->AddLink();
  //$pdf->SetLink($link);
  //$y = $pdf->GetY();
  //$pdf->SetLeftMargin(130);
  //$pdf->SetY($y+50);
  //$pdf->SetFontSize(10);
  //$pdf->WriteHTML($html);
  $pdf->Image('SellMore.jpg',90, $y+60,30,0,'','http://localhost/Sale-of-Items.html?name=sales');
  
  $pdf->Output();
} 
CloseCon($conn);
?>