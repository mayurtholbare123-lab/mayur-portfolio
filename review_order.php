<?php
session_start();
include 'db.php';

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

if(!isset($_GET['order_id'])){
    header("Location: menu.php");
    exit();
}

$order_id = $_GET['order_id'];

if(isset($_GET['remove_item'])){
    $remove_id = $_GET['remove_item'];
    $conn->query("DELETE FROM order_items WHERE id='$remove_id' AND order_id='$order_id'");
    header("Location: review_order.php?order_id=".$order_id);
    exit();
}

$order_query = $conn->query("SELECT * FROM orders WHERE id='$order_id'");
$order = $order_query->fetch_assoc();

$items_query = $conn->query("
SELECT order_items.*, menu_items.image 
FROM order_items 
LEFT JOIN menu_items ON order_items.item_name = menu_items.item_name
WHERE order_items.order_id='$order_id'
");

$delivery_charge = 40;
$subtotal = 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Review Order</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

/* 🔥 SAME DARK BACKGROUND AS LOGIN */

body{
background:
linear-gradient(rgba(0,0,0,0.85),rgba(0,0,0,0.85)),
url("images/biryani-bg.jpg");
background-size:cover;
background-position:center;
color:white;
}

/* 🔥 HEADER */

.header{
background:rgba(0,0,0,0.7);
padding:25px 20px;
border-bottom:1px solid #f4b400;
text-align:center;
backdrop-filter:blur(8px);
}

.header h2{
color:#f4b400;
}

/* 🔥 CONTAINER */

.container{
max-width:600px;
margin:auto;
padding:30px 20px 120px 20px;
}

/* 🔥 GLASS CARD */

.card{
background:rgba(0,0,0,0.6);
padding:20px;
border-radius:20px;
border:1px solid #f4b40040;
backdrop-filter:blur(10px);
box-shadow:0 10px 30px rgba(0,0,0,0.6);
margin-bottom:25px;
transition:0.3s;
}

.card:hover{
box-shadow:0 0 20px #f4b40070;
}

/* 🔥 ITEM ROW */

.item{
display:flex;
align-items:center;
justify-content:space-between;
margin-bottom:15px;
padding-bottom:15px;
border-bottom:1px solid #ffffff20;
transition:all .35s ease;
}

.item:last-child{
border-bottom:none;
}

.item.fade-out{
opacity:0;
transform:translateX(60px);
height:0;
margin:0;
padding:0;
overflow:hidden;
}

/* 🔥 ITEM LEFT */

.item-left{
display:flex;
align-items:center;
gap:15px;
}

.item img{
width:75px;
height:75px;
object-fit:cover;
border-radius:12px;
box-shadow:0 4px 15px rgba(0,0,0,0.6);
}

/* 🔥 REMOVE BUTTON */

.remove-btn{
background:#dc2626;
color:white;
padding:6px 12px;
border-radius:8px;
border:none;
cursor:pointer;
font-size:12px;
transition:0.3s;
}

.remove-btn:hover{
transform:scale(1.1);
}

/* 🔥 PRICE */

.price{
font-weight:bold;
color:#f4b400;
}

/* 🔥 SUMMARY */

.summary p{
display:flex;
justify-content:space-between;
margin:10px 0;
font-size:15px;
}

.total{
font-size:20px;
font-weight:bold;
color:#f4b400;
}

/* 🔥 DELIVERY */

.delivery-header{
display:flex;
justify-content:space-between;
align-items:center;
}

.change-btn{
background:#f4b400;
color:black;
border:none;
padding:7px 16px;
border-radius:25px;
font-size:12px;
cursor:pointer;
font-weight:bold;
transition:0.3s;
}

.change-btn:hover{
transform:scale(1.05);
}

/* 🔥 INPUTS */

.input{
width:100%;
padding:12px;
margin-bottom:12px;
border-radius:12px;
border:1px solid #f4b40040;
background:rgba(0,0,0,0.5);
color:white;
}

.save-btn{
background:#f4b400;
color:black;
padding:12px;
width:100%;
border:none;
border-radius:12px;
font-weight:bold;
cursor:pointer;
transition:0.3s;
}

.save-btn:hover{
transform:scale(1.05);
}

/* 🔥 PAYMENT BAR */

.payment-bar{
position:fixed;
bottom:0;
left:0;
right:0;
background:rgba(0,0,0,0.95);
padding:15px;
border-top:1px solid #f4b400;
backdrop-filter:blur(8px);
}

.payment-btn{
background:#f4b400;
color:black;
padding:15px;
width:100%;
border:none;
border-radius:15px;
font-size:16px;
font-weight:bold;
cursor:pointer;
transition:0.3s;
}

.payment-btn:hover{
transform:scale(1.03);
box-shadow:0 0 15px #f4b40080;
}

/* 🔥 FADE IN ANIMATION */

.card{
animation:fadeInUp 0.6s ease;
}

@keyframes fadeInUp{
from{
opacity:0;
transform:translateY(30px);
}
to{
opacity:1;
transform:translateY(0);
}
}

/* 🔥 MOBILE OPTIMIZATION */

@media(max-width:768px){

.container{
padding:20px 15px 120px 15px;
}

.item img{
width:65px;
height:65px;
}

}

</style>
</head>

<body>

<div class="header">
<h2>🧾 Review Your Order</h2>
</div>

<div class="container">

<div class="card">

<?php while($item = $items_query->fetch_assoc()){ 
$line_total = $item['price'] * $item['quantity'];
$subtotal += $line_total;
$image_path = "images/".$item['image'];
?>

<div class="item" id="item-<?php echo $item['id']; ?>">

<div class="item-left">
<img src="<?php echo $image_path; ?>" alt="Food">

<div>
<strong><?php echo $item['item_name']; ?></strong><br>
Qty: <?php echo $item['quantity']; ?>
</div>
</div>

<div style="text-align:right;">
<div class="price">₹<?php echo number_format($line_total,2); ?></div>

<button class="remove-btn"
onclick="animateRemove(<?php echo $item['id']; ?>)">
Remove
</button>

</div>

</div>

<?php } ?>

</div>

<div class="card summary">

<p>
<span>Subtotal</span>
<span>₹<?php echo number_format($subtotal,2); ?></span>
</p>

<p>
<span>Delivery Charge</span>
<span>₹<?php echo $delivery_charge; ?></span>
</p>

<?php $grand_total = $subtotal + $delivery_charge; ?>

<p class="total">
<span>Total</span>
<span>₹<?php echo number_format($grand_total,2); ?></span>
</p>

</div>

<div class="card">

<div class="delivery-header">
<h3 style="margin:0;">📍 Delivery Details</h3>
<button class="change-btn" onclick="toggleForm()">Change</button>
</div>

<div id="deliveryView" style="margin-top:15px;">
<strong><?php echo $order['delivery_name']; ?></strong><br>
<?php echo $order['delivery_phone']; ?><br>
<?php echo $order['delivery_address']; ?>
</div>

<div id="deliveryForm" style="display:none; margin-top:15px;">

<form action="update_details.php" method="POST">
<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">

<label style="font-size:13px;color:#f4b400;font-weight:600;">
Name * <span style="color:#22c55e;font-size:11px;"></span>
</label>
<input type="text" name="name" class="input"
value="<?php echo $order['delivery_name']; ?>" required>

<label style="font-size:13px;color:#f4b400;font-weight:600;">
Number * <span style="color:#22c55e;font-size:11px;"></span>
</label>
<input type="text" name="phone" class="input"
value="<?php echo $order['delivery_phone']; ?>" required>

<label style="font-size:13px;color:#f4b400;font-weight:600;">
Address * <span style="color:#22c55e;font-size:11px;"></span>
</label>
<textarea name="address" class="input" required><?php echo $order['delivery_address']; ?></textarea>

<button type="submit" class="save-btn">Save Changes</button>
</form>

</div>

</div>

</div>

<div class="payment-bar">
<a href="payment.php?order_id=<?php echo $order_id; ?>&total=<?php echo $grand_total; ?>">
<button class="payment-btn">
Continue to Payment →
</button>
</a>
</div>

<script>
function toggleForm(){
let form = document.getElementById("deliveryForm");
let view = document.getElementById("deliveryView");
form.style.display = form.style.display === "none" ? "block" : "none";
view.style.display = view.style.display === "none" ? "block" : "none";
}

function animateRemove(id){
let item = document.getElementById("item-"+id);
item.classList.add("fade-out");

setTimeout(function(){
window.location.href = "review_order.php?order_id=<?php echo $order_id; ?>&remove_item="+id;
},350);
}
</script>

</body>
</html>