<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'db.php';

date_default_timezone_set("Asia/Kolkata"); // ✅ Live Timezone Set
$current_datetime = date("Y-m-d H:i:s");   // ✅ Current Date & Time

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['email'];

/* Get customer id from customers table */
$user_query = $conn->query("SELECT id FROM customers WHERE email='$user_email'");

if(!$user_query){
    die("Customer Query Failed: " . $conn->error);
}

$user_data = $user_query->fetch_assoc();

if(!$user_data){
    die("Customer Not Found");
}

$user_id = $user_data['id'];

$order_number = "ORD".rand(10000,99999);

$total = 0;

/* Calculate total */
for($i=0; $i<count($_POST['quantity']); $i++){

    $qty = (int)$_POST['quantity'][$i];
    $price = (float)$_POST['price'][$i];

    if($qty > 0){
        $total += $qty * $price;
    }
}

if($total == 0){
    echo "<script>alert('Please select at least 1 item');window.location='menu.php';</script>";
    exit();
}

/* Get Full Customer Details */
$customer_query = $conn->query("SELECT * FROM customers WHERE id='$user_id'");
$customer_data = $customer_query->fetch_assoc();

$delivery_name = $customer_data['name'];
$delivery_phone = $customer_data['mobile'];
$delivery_address = $customer_data['address'];

/* ✅ Insert order with Live Date & Time */
$conn->query("INSERT INTO orders 
(order_number,
customer_id,
user_id,
customer_name,
customer_mobile,
customer_email,
customer_address,
total_amount,
delivery_name,
delivery_phone,
delivery_address,
payment_method,
payment_status,
order_status,
order_date)

VALUES
('$order_number',
'$user_id',
'$user_id',
'$delivery_name',
'$delivery_phone',
'$user_email',
'$delivery_address',
'$total',
'$delivery_name',
'$delivery_phone',
'$delivery_address',
'Cash On Delivery',
'Pending',
'pending',
'$current_datetime')");


$order_id = $conn->insert_id;

/* Insert order items */
for($i=0; $i<count($_POST['quantity']); $i++){

    $qty = (int)$_POST['quantity'][$i];
    $price = (float)$_POST['price'][$i];
    $item_id = $_POST['item_id'][$i];

   if($qty > 0){

    $item_query = $conn->query("SELECT item_name FROM menu_items WHERE id='$item_id'");
    $item_data = $item_query->fetch_assoc();
    $item_name = $item_data['item_name'];

    $conn->query("UPDATE orders 
    SET item_id='$item_id',
    menu_name='$item_name',
    quantity='$qty'
    WHERE id='$order_id'");

    $conn->query("INSERT INTO order_items 
    (order_id,item_name,price,quantity)
    VALUES ('$order_id','$item_name','$price','$qty')");
}
}

echo "<script>window.location='review_order.php?order_id=$order_id';</script>";
exit();
?>