<?php
ob_start();

error_reporting(0);
ini_set('display_errors', 0);

session_start();
include 'db.php';
require_once('fpdf/fpdf.php');

if(!isset($_GET['order_id'])){
    die("Invalid Order");
}

$order_id = intval($_GET['order_id']);

$order = $conn->query("SELECT * FROM orders WHERE id='$order_id'");
$order_data = $order->fetch_assoc();

if(!$order_data){
    die("Order Not Found");
}

$items = $conn->query("SELECT * FROM order_items WHERE order_id='$order_id'");

$invoice_no = "INV".$order_id.date("Y");

/* CREATE PDF */
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true,20);

/* ===== HEADER ===== */

$pdf->SetFillColor(30,30,30);
$pdf->Rect(0,0,210,35,'F');

$pdf->SetTextColor(255,215,0);
$pdf->SetFont('Arial','B',22);
$pdf->Cell(0,22,'GARVA BIRYANI',0,1,'C');

$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,-5,'Premium Food & Catering Services',0,1,'C');

$pdf->Ln(15);

/* Logo */
if(file_exists('logo.png')){
    $pdf->Image('logo.png',15,10,18);
}

/* GST */
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,6,'GST No: 27ABCDE1234F1Z5',0,1,'R');

$pdf->Ln(5);

/* ===== INVOICE DETAILS ===== */

$pdf->SetFont('Arial','B',12);
$pdf->Cell(100,8,'Invoice No: '.$invoice_no,0,0);
$pdf->Cell(0,8,'Date: '.date("d-m-Y h:i A", strtotime($order_data['order_date'])),0,1);

$pdf->Ln(8);

/* ===== BILL TO ===== */

$pdf->SetFont('Arial','B',13);
$pdf->Cell(0,8,'Bill To:',0,1);

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,6,$order_data['delivery_name'],0,1);
$pdf->Cell(0,6,$order_data['delivery_phone'],0,1);
$pdf->MultiCell(0,6,$order_data['delivery_address'],0);

$pdf->Ln(8);

/* ===== TABLE HEADER ===== */

$pdf->SetFillColor(240,240,240);
$pdf->SetFont('Arial','B',12);

$pdf->Cell(80,10,'Item Name',1,0,'C',true);
$pdf->Cell(25,10,'Qty',1,0,'C',true);
$pdf->Cell(40,10,'Price',1,0,'C',true);
$pdf->Cell(45,10,'Total',1,1,'C',true);

/* ===== ITEMS ===== */

$pdf->SetFont('Arial','',11);

while($row = $items->fetch_assoc()){

    $line_total = $row['quantity'] * $row['price'];

    $pdf->Cell(80,10,$row['item_name'],1);
    $pdf->Cell(25,10,$row['quantity'],1,0,'C');
    $pdf->Cell(40,10,'Rs '.number_format($row['price'],2),1,0,'R');
    $pdf->Cell(45,10,'Rs '.number_format($line_total,2),1,1,'R');
}

$pdf->Ln(6);

/* ===== TOTAL SECTION ===== */

$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'Grand Total: Rs '.number_format($order_data['total_amount'],2),0,1,'R');

$pdf->Ln(10);

/* ===== FOOTER NOTES ===== */

$pdf->SetFont('Arial','I',9);
$pdf->SetTextColor(80,80,80);
$pdf->MultiCell(0,5,
"Order Verification Code: BH".$order_id.date("His")."\nThis is a system generated invoice and does not require signature.\nFor support contact: support@garva-biryani.com",
0,'C');

$pdf->Ln(5);

$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,10,'Thank you for choosing Garva Biryani!',0,1,'C');

$pdf->Output("D","Garva Biryani Invoice".$order_id.".pdf");
ob_end_flush();
exit;
?>