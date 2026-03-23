<?php
include 'db.php';

$order_id = $_POST['order_id'];

$method = $_POST['payment_method'];

$conn->query("UPDATE orders 
SET payment_method='$method',
payment_status='Pending'
WHERE id='$order_id'");

echo "<script>
window.location='checkout_success.php';
</script>";
exit();
?>