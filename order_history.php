<?php
session_start();
include 'db.php';

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['email'];

/* Get User ID (Secure Way) */
$stmt = $conn->prepare("SELECT id FROM customers WHERE email=?");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$user_id = $user_data['id'];

/* Get Orders */
$stmt2 = $conn->prepare("
SELECT orders.*, order_items.item_name, order_items.quantity
FROM orders
LEFT JOIN order_items ON orders.id = order_items.order_id
WHERE orders.user_id=?
ORDER BY orders.order_date DESC
");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$orders = $stmt2->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Order History</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

/* 🔥 Premium Dark Background */

body{
background:
linear-gradient(rgba(0,0,0,0.85),rgba(0,0,0,0.85)),
url("images/biryani-bg.jpg");
background-size:cover;
background-position:center;
color:white;
}

/* 🔥 Glass Container */

.container{
width:95%;
max-width:1100px;
margin:50px auto;
background:rgba(0,0,0,0.6);
padding:35px;
border-radius:20px;
backdrop-filter:blur(12px);
border:1px solid #f4b40040;
box-shadow:0 15px 40px rgba(0,0,0,0.6);
animation:fadeIn 0.6s ease;
}

h2{
text-align:center;
margin-bottom:30px;
font-weight:700;
color:#f4b400;
letter-spacing:1px;
}

/* 🔥 Modern Table */

table{
width:100%;
border-collapse:collapse;
overflow:hidden;
border-radius:15px;
}

th{
background:#f4b400;
color:black;
padding:14px;
font-weight:600;
font-size:14px;
text-transform:uppercase;
letter-spacing:0.5px;
}

td{
padding:15px;
text-align:center;
border-bottom:1px solid rgba(255,255,255,0.08);
font-size:14px;
}

tr{
transition:0.3s;
}

tr:hover{
background:rgba(244,180,0,0.08);
}

/* 🔥 Status Badges */

.status{
padding:7px 14px;
border-radius:30px;
font-weight:600;
font-size:12px;
letter-spacing:0.5px;
}

.pending{
background:#e74c3c;
}

.preparing{
background:#f39c12;
}

.delivered{
background:#2ecc71;
}

/* 🔥 Download Button */

a{
text-decoration:none;
background:#f4b400;
color:black;
padding:8px 16px;
border-radius:20px;
font-size:12px;
font-weight:600;
transition:0.3s;
display:inline-block;
}

a:hover{
background:white;
color:black;
transform:scale(1.05);
box-shadow:0 0 15px #f4b40080;
}

/* 🔥 Empty State */

.empty{
text-align:center;
padding:40px;
color:#ccc;
font-size:15px;
}

/* 🔥 Fade Animation */

@keyframes fadeIn{
from{
opacity:0;
transform:translateY(20px);
}
to{
opacity:1;
transform:translateY(0);
}
}

/* 🔥 Responsive */

@media(max-width:768px){

.container{
padding:20px;
}

th,td{
padding:10px;
font-size:12px;
}

}

</style>
</head>
<body>

<div class="container">

<h2>📜 My Order History</h2>

<table>
<tr>
  <th>Order ID</th>
<th>Date</th>
<th>Time</th>
<th>Menu</th>
<th>Qty</th>
<th>Total</th>
<th>Status</th>
<th>Invoice</th>
</tr>

<?php 
if($orders->num_rows > 0){
    $last_order_id = 0;
while($order = $orders->fetch_assoc()){ 

$status = strtolower($order['order_status'] ?? 'pending');
$status_class = 'pending';

if($status == 'preparing'){
    $status_class = 'preparing';
}
elseif($status == 'delivered'){
    $status_class = 'delivered';
}
?>

<tr>
<td>#<?php echo $order['id']; ?></td>

<td><?php echo date("d-m-Y", strtotime($order['order_date'])); ?></td>

<td><?php echo date("h:i A", strtotime($order['order_date'])); ?></td>

<td><?php echo $order['item_name']; ?></td>

<td><?php echo $order['quantity']; ?></td>

<td>₹<?php echo number_format($order['total_amount'],2); ?></td>
    <td>
        <span class="status <?php echo $status_class; ?>">
            <?php echo ucfirst($status); ?>
        </span>
    </td>
   <td>

<?php
if($last_order_id != $order['id']){
?>

<a href="download_bill.php?order_id=<?php echo $order['id']; ?>">
Download Bill
</a>

<?php
$last_order_id = $order['id'];
}
?>

</td>
</tr>

<?php 
}
}else{
    echo "<tr><td colspan='8' class='empty'>No Orders Found</td></tr>";
}
?>

</table>

</div>

</body>
</html>