<?php
session_start();
include 'db.php';

if(isset($_POST['login'])){

$username = trim($_POST['username']);
$password = trim($_POST['password']);

if(!empty($username) && !empty($password)){

    // Prepared Statement (SQL Injection Safe)
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
<title>Admin Login</title>
<link rel="stylesheet" href="style.css">
</head>

<body class="hero">

<div class="glass-card">

<h2>🔐 Admin Login</h2>

<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">

<input type="text" name="username" placeholder="Admin Username" required>

<input type="password" name="password" placeholder="Admin Password" required>

<br><br>

<button class="order-btn" name="login">
Login Admin
</button>

</form>

</div>

</body>
</html>