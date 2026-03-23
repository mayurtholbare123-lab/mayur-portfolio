<?php
session_start();
include 'db.php';

if(isset($_POST['login'])){

$username = trim($_POST['username']);
$password = trim($_POST['password']);

if(!empty($username) && !empty($password)){

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){

        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit();

    }else{
        $error = "Invalid Admin Login";
    }

}else{
    $error = "Please fill all fields";
}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login | Garva Biryani</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Poppins,sans-serif;
}

/* Same Background As Login/Register */

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

/* Golden Border Glass Card */

.glass-card{
width:380px;

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

/* Mobile Responsive */

@media(max-width:900px){

body{
justify-content:center;
padding:25px;
}

.glass-card{
width:100%;
max-width:400px;
}

}

</style>
</head>

<body>

<div class="glass-card">

<h2>🔐 Admin Login</h2>
<p style="margin-bottom:20px;color:#ccc;">
Garva Biryani Management Panel
</p>

<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">

<input type="text" name="username" placeholder="Admin Username" required>

<input type="password" name="password" placeholder="Admin Password" required>

<button class="order-btn" name="login">
Login Admin
</button>

</form>

</div>

</body>
</html>