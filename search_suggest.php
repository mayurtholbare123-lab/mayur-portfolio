<?php
include 'db.php';

$search = $_GET['query'];

$result = $conn->query("SELECT * FROM menu_items 
WHERE item_name LIKE '%$search%' LIMIT 5");

while($row=$result->fetch_assoc()){
echo "<div onclick=\"selectFood('".$row['item_name']."')\"
style='padding:10px;cursor:pointer;border-bottom:1px solid #eee;'>

🍔 ".$row['item_name']."

</div>";
}
?>