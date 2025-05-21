<?PHP
session_start();
require('fpdf.php');
$conn=new mysqli("localhost", "root", "", "dbfinalproject");

$height = 150;
$h=$conn->query("SELECT * FROM tblsales where status='print'");  
while($r=$h->fetch_assoc()){
    $height += 5;
}
$pdf = new FPDF("P", "mm", array($height,107.95));
$pdf->AddPage();

$pdf->Image("../1photo/logo.png", 39,6,30,);

$pdf->SetFont('Arial', '',10);
$pdf->Cell(85,10,"",0,1,'C');//filler
$pdf->Cell(85,10,"",0,1,'C');//filler
$pdf->Cell(85,5,"Promeat Product",0,1,'C');
$pdf->Cell(85,5,"Tangob Padre Garcia Batangas",0,1,'C');
date_default_timezone_set("Asia/Manila");
$pdf->Cell(85,5,date("m/d/Y(D) H:i:s"),0,1,'C');
$pdf->Cell(85,5,"",0,1,'C');//filler
$pdf->Cell(85,5,"Cashier: $_SESSION[user_lastname], $_SESSION[user_givenname]" ,0,1,'');
$pdf->Cell(85,5,"Con #: $_SESSION[user_contact]" ,0,1,'');
$pdf->Cell(85,5,"",0,1,'C');//filler
$pdf->Cell(85,0,"",1,1,'C');//dashline
$pdf->Cell(85,5,"",0,1,'C');
// CONTENT HERE
$result=$conn->query("SELECT * FROM tblsales where status='print' and cashier='$_GET[cashier]'");
$count = mysqli_num_rows($result);

$total = 0;
$pdf->Cell(50.5,5,"Product",0,0,'L');
$pdf->Cell(15,5,"Quantity",0,0,'C');
$pdf->Cell(20,5,"Price",0,1,'R');    
while($row=$result->fetch_assoc()){
    $total += $row['tprice'];
    $change = $_GET["cash"] - $total;
    $pdf->Cell(50.5,5,"$row[product]",0,0,'');
    $pdf->Cell(15,5,"$row[quan]",0,0,'C');
    $pdf->Cell(20,5,"P $row[tprice]",0,1,'R');
}
$pdf->Cell(85,5,"",0,1,'C');
$pdf->Cell(85,0,"",1,1,'C');//dashline
$pdf->Cell(85,5,"",0,1,'C');

$pdf->Cell(42.5,5,"TOTAL ($count)",0,0,'');
$pdf->Cell(42.5,5,"P $total",0,1,'R');

$pdf->Cell(42.5,5,"CASH",0,0,'');
$pdf->Cell(42.5,5,"P $_GET[cash]",0,1,'R');

$pdf->Cell(42.5,5,"CHANGE",0,0,'');
$pdf->Cell(42.5,5,"P $change",0,1,'R');

$pdf->Cell(85,15,"",0,1,'C');
$pdf->Cell(85,5,"THANK YOU FOR PURCHASE",0,1,'C');
$pdf->Cell(85,5,"*THIS IS AN OFFICIAL RECEIPT*",0,1,'C');


$pdf->Output();
?>