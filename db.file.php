<?php
$conn = new mysqli(
"sql100.infinityfree.com",
"your_username",
"your_password",
"your_database_name"
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>