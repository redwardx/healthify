<?php
session_start();
//memeriksa apakah sudah memiliki sesi
if(!isset($_SESSION['email'])){
	echo '<script language="javascript">alert("Anda belum Login!"); document.location="index.php";</script>';
}
if(!isset($_SESSION['user'])){
	echo '<script language="javascript">alert("Anda bukan User!"); document.location="admin/index.php";</script>';
}
include("connections/localhost.php");
if (!isset($_SESSION['email']) || !isset($_SESSION['totalCost']) || (int)$_SESSION['totalCost'] <= 0) {
    //KICK USER OUT OF THIS PAGE
    header('product.php');
}
global $name;
$name = $_SESSION['name'];


global $totalCost;
$totalCost = '';
$totalCost = $_SESSION['totalCost'];
require('lib/fpdf/fpdf.php');

$customeremail = mysqli_real_escape_string( $conn, $_SESSION[ 'email' ] );
$query = "SELECT * FROM `cart` INNER JOIN `products` ON cart.product_id = products.productID AND cart.customer_email = '$customeremail' ORDER BY `date_added` DESC";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

$qty =  mysqli_query($conn, "SELECT sum(quantity) as total FROM `cart` INNER JOIN `products` ON cart.product_id = products.productID AND cart.customer_email = '$customeremail' ORDER BY `date_added` DESC") or die(mysqli_error($conn));
$data=mysqli_fetch_assoc($qty);
	
if ($data['total'] == 0) exit('<p align="center"> Your Cart is Empty</p>'); 
 
// intance object dan memberikan pengaturan halaman PDF
$pdf=new FPDF('P','mm','A4');
$pdf->AddPage();
 
$pdf->SetFont('Arial','B',14);

//Cell(width , height , text , border , end line , [align] )

$pdf->Cell(130 ,5,'Healthify Corp.',0,0);
$pdf->Cell(59 ,5,'INVOICE',0,1);//end of line

//mengatur font ke arial, regular, 12pt
$pdf->SetFont('Arial','',12);

$pdf->Cell(130 ,5,'Jalan Ahmad Yani',0,0);
$pdf->Cell(59 ,5,'',0,1);//end of line

date_default_timezone_set('Asia/Jakarta');

$pdf->Cell(130 ,5,'Surabaya, Rungkut, 60293',0,0);
$pdf->Cell(25 ,5,'Date',0,0);
$pdf->Cell(34 ,5,date("d-m-Y"),0,1);//end of line


$pdf->Cell(189 ,10,'',0,1);//end of line

$pdf->Cell(100 ,5,'Info Tagihan',0,1);//end of line

$pdf->Cell(5 ,5,'',0,0);
$pdf->Cell(30 ,5,'Nama ',0,0);
$pdf->Cell(60 ,5, $name,0,1);

$pdf->Cell(5 ,5,'',0,0);
$pdf->Cell(30 ,5,'Alamat ',0,0);
$pdf->Cell(90 ,5,$_POST['address'],0,1);

$pdf->Cell(5 ,5,'',0,0);
$pdf->Cell(30 ,5,'Pembayaran ',0,0);
if (isset($_POST['norek'])) {
    $bank = "Rekening " . $_POST['norek'];
    $pdf->Cell(90 ,5,$bank,0,1);
} else {
    $pdf->Cell(90 ,5,'Cash On Delivery (COD)',0,1);
}

$pdf->Cell(189 ,10,'',0,1);//end of line

//membuat tabel produk
$pdf->SetFont('Arial','B',12);

$pdf->Cell(130 ,5,'Nama Produk',1,0);
$pdf->Cell(25 ,5,'Qty.',1,0);
$pdf->Cell(34 ,5,'Harga',1,1);//end of line


//'R' untuk membuat align rata kanan
$pdf->SetFont('Arial','',12);
$query = "SELECT * FROM `cart` INNER JOIN `products` ON cart.product_id = products.productID AND cart.customer_email = '$customeremail' ORDER BY `date_added` DESC";
$data = mysqli_query($conn,$query);
while($d = mysqli_fetch_array($data)){
    $pdf->Cell(130 ,5,$d['productname'],1,0);
    $pdf->Cell(25 ,5,$d['quantity'],1,0);
    $pdf->Cell(34 ,5,$d['price']*$d['quantity'],1,1,'R');
}//end of line

//summary
$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'Subtotal',0,0);
$pdf->Cell(8 ,5,'Rp.',1,0);
$pdf->Cell(26 ,5,$totalCost,1,0,'R');//end of line

 
$pdf->Output();
 
?>