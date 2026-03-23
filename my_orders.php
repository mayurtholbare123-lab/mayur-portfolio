<?php
session_start();
include 'db.php';

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

$getUser = $conn->query("SELECT * FROM customers WHERE email='$email'");
$user = $getUser->fetch_assoc();

$name = $user['name'];
$phone = $user['mobile'];
$address = $user['address'];

$conn->query("INSERT INTO orders 
(customer_id, items, total, delivery_name, delivery_phone, delivery_address, order_date) 
VALUES 
('{$user['id']}', '$items', '$total', '$name', '$phone', '$address', NOW())");
?>

<h2 style="text-align:center;margin-top:20px;">🧾 My Orders</h2>

<?php while($order=$result->fetch_assoc()){ ?>

<div style="background:#fff;padding:20px;margin:20px;border-radius:12px;
box-shadow:0 5px 15px rgba(0,0,0,0.1);">

<h3>Order #<?php echo $order['id']; ?></h3>
<p><strong>Date:</strong> <?php echo $order['order_date']; ?></p>
<p><strong>Status:</strong> 
<span style="color:green;"><?php echo $order['order_status']; ?></span>
</p>

<hr>

<?php
$order_id = $order['id'];
$items = $conn->query("SELECT * FROM order_items WHERE order_id='$order_id'");
?>

<?php while($item=$items->fetch_assoc()){ ?>

<p>
<?php echo $item['item_name']; ?>  
(<?php echo $item['quantity']; ?> × ₹<?php echo $item['price']; ?>)
</p>

<?php } ?>

<hr>

<h4 style="color:#ff5722;">
Total: ₹<?php echo $order['total_amount']; ?>
</h4>

</div>
<a href="download_bill.php?order_id=<?php echo $order['id']; ?>">
<button style="padding:8px 15px;background:#ff5722;color:white;border:none;border-radius:6px;cursor:pointer;">
Download Bill
</button>
</a>
<?php } ?>