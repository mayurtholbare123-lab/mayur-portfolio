<?php
session_start();
include 'db.php';

if(!isset($_SESSION['email'])){
header("Location: login.php");
exit();
}

$order_id = $_GET['order_id'];

$email = $_SESSION['email'];
$user = $conn->query("SELECT * FROM customers WHERE email='$email'");
$data = $user->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Delivery Details</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
font-family:Segoe UI;
background:#f5f5f5;
padding:20px;
}

.card{
background:white;
padding:20px;
border-radius:15px;
box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

input{
width:100%;
padding:10px;
margin-bottom:15px;
border:1px solid #ccc;
border-radius:8px;
}

button{
background:#111;
color:white;
padding:12px;
width:100%;
border:none;
border-radius:10px;
cursor:pointer;
}
</style>
</head>

<body>

<h2>Edit Delivery Details</h2>

<div class="card">

<form action="update_details.php" method="POST">

<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">

<label>Name</label>
<input type="text" name="name" value="<?php echo $data['name']; ?>" required>

<label>Phone</label>
<input type="text" name="phone" value="<?php echo $data['phone']; ?>" required>

<label>Address</label>
<input type="text" name="address" value="<?php echo $data['address']; ?>" required>

<button type="submit">Save & Go Back</button>

</form>

</div>

</body>
</html>