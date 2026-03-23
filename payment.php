<?php
session_start();
include 'db.php';

if(!isset($_GET['order_id'])){
    header("Location: menu.php");
    exit();
}

$order_id = $_GET['order_id'];

$order_check = $conn->query("SELECT * FROM orders WHERE id='$order_id'");
if($order_check->num_rows == 0){
    header("Location: menu.php");
    exit();
}

$items = $conn->query("
SELECT price, quantity 
FROM order_items 
WHERE order_id='$order_id'
");

$subtotal = 0;

while($row = $items->fetch_assoc()){
    $subtotal += ($row['price'] * $row['quantity']);
}

$delivery_charge = 40;

if($subtotal <= 0){
    header("Location: review_order.php?order_id=".$order_id);
    exit();
}

$grand_total = $subtotal + $delivery_charge;

$conn->query("UPDATE orders SET total_amount='$grand_total' WHERE id='$order_id'");
?>

<!DOCTYPE html>
<html>
<head>
<title>Secure Payment | Biryani House</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

/* 🔥 DARK GOLD BACKGROUND */

body{
height:100vh;
display:flex;
justify-content:center;
align-items:center;

background:
linear-gradient(rgba(0,0,0,0.85),rgba(0,0,0,0.85)),
url("images/biryani-bg.jpg");

background-size:cover;
background-position:center;
color:white;
}

/* 🔥 GLASS CARD */

.payment-card{
background:rgba(0,0,0,0.7);
width:380px;
padding:35px;
border-radius:20px;
border:2px solid #f4b400;
backdrop-filter:blur(12px);
box-shadow:0 0 35px rgba(0,0,0,0.6);
text-align:center;
animation:fadeIn 0.6s ease;
}

@keyframes fadeIn{
from{opacity:0; transform:translateY(30px);}
to{opacity:1; transform:translateY(0);}
}

/* 🔥 LOCK ICON */

.secure-icon{
font-size:42px;
margin-bottom:15px;
color:#f4b400;
}

/* 🔥 TOTAL */

.total-amount{
font-size:28px;
font-weight:700;
margin:20px 0;
color:#f4b400;
}

/* 🔥 PAYMENT OPTION */

.payment-option{
margin:25px 0;
text-align:left;
}

.cod-box{
display:flex;
align-items:center;
padding:15px;
border:1px solid #f4b400;
border-radius:14px;
cursor:pointer;
transition:0.3s;
background:rgba(0,0,0,0.5);
}

.cod-box:hover{
box-shadow:0 0 15px #f4b40070;
}

.cod-box input{
margin-right:10px;
accent-color:#f4b400;
}

.cod-text{
font-weight:600;
font-size:15px;
}

/* 🔥 PAY BUTTON */

.pay-btn{
background:#f4b400;
color:black;
padding:15px;
width:100%;
border:none;
border-radius:14px;
font-size:16px;
font-weight:700;
cursor:pointer;
transition:0.3s;
}

.pay-btn:hover{
transform:scale(1.05);
box-shadow:0 0 20px #f4b40080;
}

/* 🔥 TRUST TEXT */

.small-text{
font-size:12px;
color:#ccc;
margin-top:18px;
}

/* 🔥 MOBILE */

@media(max-width:768px){
.payment-card{
width:90%;
}
}

</style>
</head>

<body>

<div class="payment-card">

<div class="secure-icon">🔒</div>

<h2>Secure Payment</h2>

<div class="total-amount">
₹<?php echo number_format($grand_total,2); ?>
</div>

<form action="place_order.php" method="POST">

<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
<input type="hidden" name="final_amount" value="<?php echo $grand_total; ?>">

<div class="payment-option">
<label class="cod-box">
<input type="radio" name="payment_method" value="Cash On Delivery" checked>
<span class="cod-text">🚚 Cash On Delivery</span>
</label>
</div>

<button type="submit" class="pay-btn">
Confirm & Place Order
</button>

</form>

<div class="small-text">
100% Safe • Trusted • Secure Payment
</div>

</div>

</body>
</html>