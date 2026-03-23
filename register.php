<?php
include 'db.php';

if(isset($_POST['register'])){

$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$address = $_POST['address'];
$password = $_POST['password'];

$conn->query("INSERT INTO customers (name,email,mobile,address,password)
VALUES ('$name','$email','$mobile','$address','$password')");

header("Location: login.php");
exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register |Garva Biryani</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Poppins,sans-serif;
}

/* Same Background As Login */

body{
height:100vh;

background:
linear-gradient(rgba(0,0,0,0.75),rgba(0,0,0,0.75)),
url("images/biryani-bg.jpg");

background-size:cover;
background-position:center;

display:flex;
align-items:center;
padding-left:80px;
color:white;
}

/* Same Golden Border Card */

.glass-card{
width:420px;

padding:40px 30px;

background:rgba(0,0,0,0.6);
backdrop-filter:blur(12px);

border-radius:20px;
border:2px solid #f4b400;

text-align:center;

box-shadow:0 0 30px rgba(0,0,0,0.5);
}

/* Inputs */

input{
width:100%;
padding:13px;
margin-top:15px;

border-radius:30px;
border:1px solid #ffffff30;

background:transparent;
color:white;
outline:none;
}

/* Button */

.order-btn{
width:100%;
padding:14px;
margin-top:25px;

border:none;
border-radius:30px;

background:#f4b400;
color:black;

font-weight:600;
cursor:pointer;
transition:0.3s;
}

.order-btn:hover{
transform:translateY(-3px);
}

/* Mobile */

@media(max-width:900px){

body{
justify-content:center;
padding:25px;
}

.glass-card{
width:100%;
max-width:420px;
}

}

</style>
</head>

<body>

<div class="glass-card">

<h2>Create Account</h2>
<p style="margin-bottom:20px;color:#ccc;">
Join Garva Biryani Family
</p>

<form method="POST">

<input type="text" name="name" placeholder="Full Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="text" name="mobile" placeholder="Mobile Number" required>

<input type="text" name="address" placeholder="Full Address" required>

<input type="password" name="password" placeholder="Password" required>

<button class="order-btn" name="register">
🚀 Register Now
</button>

<p style="margin-top:20px;font-size:14px;">
Already have account?
<a href="login.php" style="color:#f4b400;">Login</a>
</p>

</form>

</div>

</body>
</html>