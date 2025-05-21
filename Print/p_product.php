<?PHP
session_start();
require('fpdf.php');
ob_end_clean();
ob_start();

$conn=new mysqli("localhost", "root", "", "dbfinalproject");

$pdf = new FPDF("P", "mm", array(170,107.95));
$pdf->AddPage();

$pdf->Image("../1photo/logo.png", 39,6,30,);

$pdf->SetFont('Arial', '',10);
$pdf->Cell(85,10,"",0,1,'C');//filler
$pdf->Cell(85,10,"",0,1,'C');//filler
$pdf->Cell(85,5,"Promeat Product",0,1,'C');
$pdf->Cell(85,5,"Terminal Report",0,1,'C');
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

$pdf->Cell(31,5,"Product",0,0,'L');
$pdf->Cell(18,5,"Unit Price",0,0,'L');
$pdf->Cell(18,5,"Quantity",0,0,'L');
$pdf->Cell(18,5,"Total Sales",0,1,'R');

$date = $_GET["date"];
$prod = $conn->query("select * from tblstock");
while($col=$prod->fetch_assoc()){
    $pdf->Cell(31,5,"$col[fldproduct]",0,0,'L');
    $result = $conn->query("SELECT * FROM tblsales where product='$col[fldproduct]' and daily='$date'");
        $quan = 0;
        $sales = 0;
        $pdf->Cell(18,5,"P$col[fldfprice]",0,0,'C');
        while($row=$result->fetch_assoc()){
            $quan += $row["quan"];
            $sales += $row["tprice"];
        }
        $pdf->Cell(18,5,"$quan",0,0,'C');
        $pdf->Cell(18,5,"P$sales",0,1,'C');
    }
    
$pdf->Cell(85,5,"",0,1,'C');
$pdf->Cell(85,0,"",1,1,'C');//dashline
$pdf->Cell(85,5,"",0,1,'C');

$pdf->Cell(85,5,"*THIS IS AN OFFICIAL RECEIPT*",0,1,'C');

$pdf->Output();
ob_end_flush();
?>