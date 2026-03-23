<?php
include 'db.php';

if(isset($_POST['id']) && isset($_POST['status'])){

    $id = intval($_POST['id']);
    $status = strtolower($_POST['status']);

    $allowed = ['pending','preparing','delivered'];

    if(in_array($status,$allowed)){

        $stmt = $conn->prepare("UPDATE orders 
                                SET order_status=? 
                                WHERE id=?");

        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
    }
}

header("Location: admin_dashboard.php");
exit();
?>