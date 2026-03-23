<?php
session_start();
include 'db.php';

if(!isset($_SESSION['order_number'])){
    echo "No Order Found";
    exit();
}
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,'Bill To:',0,1);

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,6,$user_data['name'],0,1);
$pdf->Cell(0,6,$user_data['mobile'],0,1);
$pdf->MultiCell(0,6,$user_data['address'],0,1);
$pdf->Ln(5);

$order_number = $_SESSION['order_number'];

$result = $conn->query("SELECT * FROM orders WHERE order_number='$order_number'");

$grand_total = 0;
$date = date("d M Y, h:i A");
?>

<!DOCTYPE html>
<html>
<head>
<title>Premium Invoice</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

body{
margin:0;
font-family:'Segoe UI', sans-serif;
background:#f4f6f9;
}

.invoice-container{
max-width:800px;
margin:40px auto;
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

.header{
    $pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,'Bill To:',0,1);

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,6,$user_data['name'],0,1);
$pdf->Cell(0,6,$user_data['mobile'],0,1);
$pdf->MultiCell(0,6,$user_data['address'],0,1);
$pdf->Ln(5);
display:flex;
justify-content:space-between;
align-items:center;
border-bottom:2px solid #eee;
padding-bottom:15px;
}
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,6,'GST No: 27ABCDE1234F1Z5',0,1,'R');
.logo{
font-size:22px;
font-weight:bold;
color:#ff5722;
}

.order-info{
text-align:right;
font-size:14px;
color:#555;
}

h3{
margin-top:20px;
}

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

th{
background:#ff5722;
color:white;
padding:12px;
font-size:14px;
}

td{
padding:12px;
border-bottom:1px solid #eee;
font-size:14px;
}

.total-box{
margin-top:20px;
text-align:right;
font-size:18px;
font-weight:bold;
}

.gst{
font-size:14px;
color:#777;
}

.print-btn{
margin-top:30px;
display:block;
width:100%;
padding:12px;
background:#ff5722;
color:white;
border:none;
border-radius:8px;
font-size:16px;
cursor:pointer;
transition:0.3s;
}

.print-btn:hover{
background:#e64a19;
}

.footer{
margin-top:30px;
text-align:center;
font-size:13px;
color:#888;
}

@media print{
.print-btn{
display:none;
}
body{
background:white;
}
.invoice-container{
box-shadow:none;
margin:0;
}
}

</style>
</head>

<body>

<div class="invoice-container">

<div class="header">
<div class="logo">🍽️ Garva Biryani</div>
<div class="order-info">
Order ID: <?php echo $order_number; ?><br>
Date: <?php echo $date; ?>
</div>
</div>

<h3>Order Summary</h3>

<table>
<tr>
<th>Item ID</th>
<th>Quantity</th>
<th>Amount</th>
</tr>

<?php
while($row=$result->fetch_assoc()){
$grand_total += $row['total_price'];
?>

<tr>
<td>#<?php echo $row['item_id']; ?></td>
<td><?php echo $row['quantity']; ?></td>
<td>₹<?php echo $row['total_price']; ?></td>
</tr>

<?php } ?>

</table>

<?php
$gst = $grand_total * 0.05;
$final_total = $grand_total + $gst;
?>

<div class="total-box">
Subtotal: ₹<?php echo $grand_total; ?><br>
<span class="gst">GST (5%): ₹<?php echo round($gst,2); ?></span><br><br>
Total Payable: ₹<?php echo round($final_total,2); ?>
</div>

<button onclick="window.print()" class="print-btn">
🧾 Download / Print Invoice
</button>

<div class="footer">
Thank you for ordering with us ❤️ <br>
Visit Again!
</div>

</div>

</body>
</html>