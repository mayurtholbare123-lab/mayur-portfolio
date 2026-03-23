<?php
session_start();
include 'db.php';

$order_id = $_POST['order_id'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];

$conn->query("UPDATE orders 
SET delivery_name='$name',
delivery_phone='$phone',
delivery_address='$address'
WHERE id='$order_id'");

header("Location: review_order.php?order_id=$order_id");
exit();
?>

/* Update customer table */
$conn->query("UPDATE customers 
SET name='$name', phone='$phone', address='$address'
WHERE email='$email'");

/* OPTIONAL: Also update current order */
$conn->query("UPDATE orders 
SET delivery_name='$name',
delivery_phone='$phone',
delivery_address='$address'
WHERE id='$order_id'");

echo "<script>
window.location='review_order.php?order_id=$order_id';
</script>";
exit();
?>