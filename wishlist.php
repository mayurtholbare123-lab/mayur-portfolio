<?php
session_start();
include 'db.php';

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['email'];

/* REMOVE ITEM */
if(isset($_GET['remove'])){
    $remove_id = (int)$_GET['remove'];
    $conn->query("DELETE FROM wishlist WHERE id='$remove_id'");
    header("Location: wishlist.php");
    exit();
}

$items = $conn->query("
SELECT wishlist.id as wish_id, menu_items.*
FROM wishlist
JOIN menu_items ON wishlist.item_id = menu_items.id
WHERE wishlist.user_email='$user_email'
");

$count = $items->num_rows;
?>

<!DOCTYPE html>
<html>
<head>
<title>My Wishlist</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:
linear-gradient(rgba(0,0,0,0.85),rgba(0,0,0,0.85)),
url("images/biryani-bg.jpg");
background-size:cover;
background-position:center;
color:white;
overflow-x:hidden;
}

/* ===== Floating Glow Particles ===== */

.particle{
position:fixed;
width:6px;
height:6px;
background:#f4b400;
border-radius:50%;
opacity:0.6;
animation:float 8s linear infinite;
}

@keyframes float{
from{transform:translateY(100vh);}
to{transform:translateY(-10vh);}
}

/* ===== Container ===== */

.container{
width:90%;
max-width:1100px;
margin:auto;
padding:60px 0;
}

/* ===== Heading ===== */

.heading{
text-align:center;
margin-bottom:40px;
}

.heading h2{
font-size:32px;
background:linear-gradient(45deg,#f4b400,#ff6b00);
-webkit-background-clip:text;
color:transparent;
font-weight:700;
}

.badge{
background:#f4b400;
color:black;
padding:4px 10px;
border-radius:20px;
font-size:14px;
margin-left:8px;
}

/* ===== Card ===== */

.card{
background:rgba(255,255,255,0.05);
backdrop-filter:blur(12px);
padding:20px;
border-radius:20px;
border:1px solid rgba(244,180,0,0.3);
box-shadow:0 10px 30px rgba(0,0,0,0.5);
margin-bottom:25px;
display:flex;
justify-content:space-between;
align-items:center;
transition:0.4s;
position:relative;
animation:fadeUp 0.6s ease;
}

.card:hover{
transform:translateY(-8px);
box-shadow:0 0 25px rgba(244,180,0,0.6);
}

@keyframes fadeUp{
from{opacity:0; transform:translateY(20px);}
to{opacity:1; transform:translateY(0);}
}

.card img{
width:95px;
height:95px;
border-radius:15px;
object-fit:cover;
box-shadow:0 8px 20px rgba(0,0,0,0.4);
}

.card h4{
font-size:18px;
margin-bottom:5px;
}

.price{
color:#f4b400;
font-weight:600;
}

/* ===== Remove Button ===== */

.remove{
background:linear-gradient(45deg,#dc2626,#b91c1c);
color:white;
padding:10px 18px;
border-radius:30px;
text-decoration:none;
font-size:13px;
font-weight:600;
transition:0.3s;
box-shadow:0 8px 20px rgba(220,38,38,0.4);
}

.remove:hover{
transform:scale(1.1);
box-shadow:0 12px 25px rgba(220,38,38,0.6);
}

/* ===== Empty Section ===== */

.empty{
text-align:center;
margin-top:80px;
animation:fadeUp 0.8s ease;
}

.empty-icon{
font-size:70px;
animation:heartbeat 1.5s infinite;
}

@keyframes heartbeat{
0%,100%{transform:scale(1);}
50%{transform:scale(1.15);}
}

/* ===== Back Button ===== */

.back-btn{
display:inline-block;
margin-top:30px;
padding:12px 25px;
background:#f4b400;
color:black;
border-radius:30px;
text-decoration:none;
font-weight:600;
transition:0.3s;
}

.back-btn:hover{
transform:scale(1.05);
}

/* ===== Responsive ===== */

@media(max-width:768px){
.card{
flex-direction:column;
gap:15px;
text-align:center;
}
}

</style>
</head>

<body>

<!-- Floating particles -->
<?php for($i=0;$i<25;$i++){ ?>
<div class="particle" style="left:<?php echo rand(0,100); ?>%; animation-duration:<?php echo rand(5,12); ?>s;"></div>
<?php } ?>

<div class="container">

<div class="heading">
<h2>❤️ My Wishlist <span class="badge"><?php echo $count; ?></span></h2>
</div>

<?php if($count == 0){ ?>

<div class="empty">
<div class="empty-icon">💔</div>
<h3>Your Wishlist is Empty</h3>
<p style="color:#ccc;margin-top:10px;">Add your favorite biryani items now 🍽️</p>
<a href="menu.php" class="back-btn">Browse Menu</a>
</div>

<?php } ?>

<?php while($row=$items->fetch_assoc()){ ?>

<div class="card">

<img src="images/<?php echo $row['image']; ?>">

<div>
<h4>🍗 <?php echo $row['item_name']; ?></h4>
<p class="price">₹<?php echo $row['price']; ?></p>
</div>

<a class="remove" href="wishlist.php?remove=<?php echo $row['wish_id']; ?>">
🗑 Remove
</a>

</div>

<?php } ?>

</div>

</body>
</html>