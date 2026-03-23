<?php
session_start();
include 'db.php';

if(!isset($_SESSION['admin'])){
header("Location: admin_login.php");
exit();
}

/* Stats */
$total_orders = $conn->query("SELECT COUNT(*) as total FROM orders")
->fetch_assoc()['total'];

$total_revenue = $conn->query("SELECT SUM(total_amount) as revenue FROM orders")
->fetch_assoc()['revenue'];

$total_users = $conn->query("SELECT COUNT(*) as users FROM customers")
->fetch_assoc()['users'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard - Garva Biryani</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
transition:.3s ease;
}

body{
background:#0b0b0b;
color:#fff;
}

/* GOLD TEXT */
.gold{
color:#d4af37;
}

/* SIDEBAR */
.sidebar{
position:fixed;
left:0;
top:0;
bottom:0;
width:250px;
background:linear-gradient(180deg,#000,#111);
border-right:1px solid #d4af37;
padding:30px 20px;
}

.sidebar h2{
font-family:'Playfair Display',serif;
color:#d4af37;
margin-bottom:50px;
letter-spacing:2px;
}

.sidebar a{
display:block;
color:#fff;
text-decoration:none;
margin-bottom:18px;
padding:10px;
border-radius:6px;
font-weight:500;
}

.sidebar a:hover{
background:#d4af37;
color:#000;
}

/* MAIN */
.main{
margin-left:270px;
padding:40px;
animation:fadeIn .8s ease;
}

/* HEADER */
.header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:40px;
}

.header h1{
font-family:'Playfair Display',serif;
color:#d4af37;
letter-spacing:2px;
}

/* CARDS */
.cards{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(230px,1fr));
gap:25px;
margin-bottom:50px;
}

.card{
background:#111;
border:1px solid #d4af37;
padding:30px;
border-radius:12px;
box-shadow:0 0 25px rgba(212,175,55,.2);
text-align:center;
}

.card:hover{
transform:translateY(-8px);
box-shadow:0 0 40px rgba(212,175,55,.4);
}

.card h3{
color:#ccc;
margin-bottom:15px;
}

.card p{
font-size:34px;
font-weight:700;
color:#d4af37;
}

/* TABLE */
.table-container{
background:#111;
border:1px solid #d4af37;
border-radius:15px;
padding:25px;
box-shadow:0 0 35px rgba(212,175,55,.15);
}

.table-container h2{
color:#d4af37;
margin-bottom:20px;
font-family:'Playfair Display',serif;
}

.search-box{
margin-bottom:15px;
}

.search-box input{
padding:10px 15px;
width:260px;
background:#000;
border:1px solid #d4af37;
color:white;
border-radius:25px;
outline:none;
}

table{
width:100%;
border-collapse:collapse;
}

th{
background:#d4af37;
color:#000;
padding:12px;
}

td{
padding:12px;
border-bottom:1px solid #222;
text-align:center;
}

tr:hover{
background:#1a1a1a;
}

/* BADGE */
.badge{
padding:6px 14px;
border-radius:20px;
font-size:12px;
font-weight:500;
}

.pending{ background:#ff9800; }
.preparing{ background:#2196F3; }
.delivered{ background:#4CAF50; }

/* FORM */
select{
background:#000;
color:#d4af37;
border:1px solid #d4af37;
padding:5px;
border-radius:5px;
}

button{
background:#d4af37;
border:none;
padding:6px 12px;
color:#000;
border-radius:5px;
cursor:pointer;
font-weight:600;
}

button:hover{
background:#b9972f;
}

/* ANIMATION */
@keyframes fadeIn{
from{opacity:0; transform:translateY(20px);}
to{opacity:1; transform:translateY(0);}
}

/* MOBILE */
@media(max-width:768px){
.sidebar{
position:relative;
width:100%;
}
.main{
margin-left:0;
}
}

</style>
</head>

<body>

<div class="sidebar">
<h2>🍽 Garva Biryani</h2>
<a href="admin_dashboard.php">📊 Dashboard</a>
<a href="#">📦 Orders</a>
<a href="#">👥 Users</a>
<a href="#">📈 Reports</a>
<a href="logout.php">🚪 Logout</a>
</div>

<div class="main">

<div class="header">
<h1>Admin Dashboard</h1>
</div>

<div class="cards">

<div class="card">
<h3>Total Orders</h3>
<p><?php echo $total_orders; ?></p>
</div>

<div class="card">
<h3>Total Revenue</h3>
<p>₹<?php echo $total_revenue ? $total_revenue : 0; ?></p>
</div>

<div class="card">
<h3>Total Users</h3>
<p><?php echo $total_users; ?></p>
</div>

</div>

<div class="table-container">

<h2>All Orders</h2>

<div class="search-box">
<input type="text" id="searchInput" placeholder="Search Order...">
</div>

<table id="orderTable">

<tr>
<th>ID</th>
<th>Update</th>
<th>Name</th>
<th>Phone</th>
<th>Address</th>
<th>Item</th>
<th>Qty</th>
<th>Total</th>
<th>Status</th>
<th>Date</th>
</tr>

<?php
$orders = $conn->query("
SELECT 
    orders.id,
    orders.total_amount,
    orders.order_status,
    orders.order_date,
    orders.delivery_name,
    orders.delivery_phone,
    orders.delivery_address,
    order_items.item_name,
    order_items.quantity
FROM orders
LEFT JOIN order_items ON orders.id = order_items.order_id
ORDER BY orders.id DESC
");

while($row=$orders->fetch_assoc()){
$status = $row['order_status'] ?? 'pending';
?>

<tr>
<td><?php echo $row['id']; ?></td>

<td>
<form method="POST" action="update_status.php">
<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
<select name="status">
<option value="pending" <?php if($status=='pending') echo 'selected'; ?>>Pending</option>
<option value="preparing" <?php if($status=='preparing') echo 'selected'; ?>>Preparing</option>
<option value="delivered" <?php if($status=='delivered') echo 'selected'; ?>>Delivered</option>
</select>
<button type="submit">✔</button>
</form>
</td>

<td><?php echo $row['delivery_name']; ?></td>
<td><?php echo $row['delivery_phone']; ?></td>
<td><?php echo $row['delivery_address']; ?></td>
<td><?php echo $row['item_name'] ?? 'N/A'; ?></td>
<td><?php echo $row['quantity']; ?></td>
<td>₹<?php echo $row['total_amount']; ?></td>

<td>
<span class="badge <?php echo $status; ?>">
<?php echo ucfirst($status); ?>
</span>
</td>

<td><?php echo $row['order_date']; ?></td>

</tr>

<?php } ?>

</table>
</div>
</div>

<script>
document.getElementById("searchInput").addEventListener("keyup", function() {
let filter = this.value.toUpperCase();
let rows = document.querySelectorAll("#orderTable tr");
rows.forEach((row,i)=>{
if(i===0) return;
let text = row.innerText.toUpperCase();
row.style.display = text.includes(filter) ? "" : "none";
});
});
</script>

</body>
</html>