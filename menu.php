<?php
session_start();
include 'db.php';

if(!isset($_SESSION['email'])){
header("Location: login.php");
exit();
}

$user_email = trim($_SESSION['email']);

$result = $conn->query("SELECT * FROM menu_items");
/* Category List */
$categories = $conn->query("SELECT DISTINCT category FROM menu_items");
$category = isset($_GET['category']) ? $_GET['category'] : '';

$query = "SELECT * FROM menu_items";

if(!empty($category)){
$category = mysqli_real_escape_string($conn,$category);
$query .= " WHERE category='$category'";
}

$result = $conn->query($query);

/* Category List */
$categories = $conn->query("SELECT DISTINCT category FROM menu_items");

/* Wishlist Count */
$countRes = $conn->query("
SELECT COUNT(id) as total 
FROM wishlist 
WHERE user_email='$user_email'
");

$wishlistCount = 0;
if($countRes && $countRes->num_rows > 0){
$countRow = $countRes->fetch_assoc();
$wishlistCount = (int)$countRow['total'];
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Garva Biryani - Menu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}

body{
background:linear-gradient(rgba(0,0,0,.88),rgba(0,0,0,.88)),
url("images/biryani-bg.jpg");
background-size:cover;
color:white;
}


/* NAVBAR PREMIUM GLASS STYLE */
.navbar{
position:sticky;
top:0;
display:flex;
justify-content:space-between;
align-items:center;
padding:18px 40px;

background:rgba(0,0,0,0.6);
backdrop-filter:blur(12px);
-webkit-backdrop-filter:blur(12px);

border-bottom:1px solid #f4b400;

z-index:1000;
}

.navbar h2{
color:#f4b400;
font-weight:700;
}

.navbar a{
color:white;
text-decoration:none;
margin-left:25px;
transition:0.3s;
font-weight:500;
}

.navbar a:hover{
color:#f4b400;
}

.wishlist-badge{
background:#f4b400;
color:black;
padding:2px 6px;
border-radius:50%;
font-size:11px;
margin-left:5px;
}

    /* CATEGORY BAR */

.category-bar{
display:flex;
flex-wrap:wrap;
gap:15px;
padding:0 40px 25px 40px;
justify-content:center;
}

.category-btn{
background:rgba(0,0,0,0.6);
border:1px solid #f4b40060;
color:white;
padding:8px 18px;
border-radius:25px;
cursor:pointer;
transition:0.3s;
backdrop-filter:blur(8px);
}

.category-btn:hover{
background:#f4b400;
color:black;
transform:scale(1.05);
}
    
/* VEG NONVEG SYMBOL */
.food-type{
display:flex;
align-items:center;
gap:6px;
margin-bottom:6px;
font-size:14px;
}
.veg-icon,.nonveg-icon{
width:14px;
height:14px;
border-radius:3px;
}
.veg-icon{
background:#1faa00;
border:2px solid #0d5302;
}
.nonveg-icon{
background:#d60000;
border:2px solid #6b0000;
}

/* MENU */
.menu-container{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
gap:25px;padding:40px;
}
.menu-card{
background:rgba(0,0,0,.6);
border-radius:20px;
border:1px solid #f4b40040;
overflow:hidden;
position:relative;
transition:.3s;
display:flex;
flex-direction:column;
}
.menu-card:hover{
transform:translateY(-6px);
box-shadow:0 0 20px #f4b40070;
}
.menu-card img{width:100%;height:200px;object-fit:cover;}
.card-content{padding:20px;}
.price{color:#f4b400;margin-bottom:15px;font-weight:600;}

/* ❤️ Wishlist Icon */
.wishlist-icon{
position:absolute;
top:15px;
right:15px;
background:black;
padding:8px;
border-radius:50%;
text-decoration:none;
font-size:18px;
transition:.3s;
}
.wishlist-icon:hover{
transform:scale(1.1);
}
.wishlist-icon.active{
color:red;
}

/* CART BUTTONS */
.add-btn{
background:#f4b400;border:none;color:black;
padding:10px 20px;border-radius:25px;
cursor:pointer;font-weight:600;
}
.cart-box{display:flex;gap:10px;margin-top:10px;}
.cart-box button{
border:none;width:34px;height:34px;
border-radius:8px;font-size:18px;
cursor:pointer;color:white;
}
.cart-box button:first-child{background:#dc2626;}
.cart-box button:last-child{background:#16a34a;}
.qty-input{
width:40px;text-align:center;
background:#222;color:white;
border:none;border-radius:6px;
}

/* FLOATING CART */
.floating-cart{
position:fixed;
bottom:90px;
right:25px;
background:#f4b400;
color:black;
padding:15px 22px;
border-radius:50px;
cursor:pointer;
font-weight:600;
z-index:999;
}
.floating-cart span{
background:black;color:#f4b400;
padding:2px 8px;border-radius:50%;
margin-left:6px;
}

/* POPUP CART */
.cart-popup{
position:fixed;
bottom:170px;
right:25px;
width:320px;
background:#111;
border:1px solid #f4b400;
border-radius:15px;
padding:20px;
display:none;
z-index:999;
}
.cart-popup h3{color:#f4b400;margin-bottom:10px;}
.cart-items{max-height:200px;overflow-y:auto;margin-bottom:10px;}
.popup-checkout{
width:100%;
background:#f4b400;
color:black;
border:none;
padding:10px;
border-radius:25px;
font-weight:600;
cursor:pointer;
margin-top:10px;
}

/* STICKY CHECKOUT */
.sticky-bar{
position:fixed;
bottom:0;
left:0;
right:0;
background:#000;
border-top:1px solid #f4b400;
display:none;
justify-content:space-between;
align-items:center;
padding:15px 30px;
z-index:998;
}
.order-btn{
background:#f4b400;
color:black;
border:none;
padding:12px 25px;
border-radius:30px;
font-weight:600;
cursor:pointer;
}
#liveTotal{
text-align:center;
font-size:22px;
color:#f4b400;
margin:20px 0;
}
</style>
</head>

<body>

<div class="navbar">
<h2>Garva Biryani</h2>
<div>
<a href="menu.php">Home</a>
<a href="wishlist.php">Wishlist
<span class="wishlist-badge"><?php echo $wishlistCount; ?></span>
</a>
<a href="order_history.php">Orders</a>
<a href="logout.php">Logout</a>
</div>
</div>

<h1 style="text-align:center;margin:30px 0;">🍽️ Order Your Favorite Food</h1>
    
    <!-- CATEGORY BAR START -->
<div class="category-bar">

<a href="menu.php" class="category-btn">🍽 All</a>

<?php while($cat=$categories->fetch_assoc()){ ?>

<a href="menu.php?category=<?php echo urlencode($cat['category']); ?>"
class="category-btn">

<?php echo $cat['category']; ?>

</a>

<?php } ?>

</div>
<!-- CATEGORY BAR END -->

<form action="order.php" method="POST">
<input type="hidden" name="total_amount" id="hiddenTotal" value="0">

<div class="menu-container">

<?php while($row=$result->fetch_assoc()){ 
$item_id = $row['id'];
$type = strtolower($row['food_type']); // 👈 veg/nonveg column

$checkWish = $conn->query("SELECT * FROM wishlist WHERE user_email='$user_email' AND item_id='$item_id'");
$isWishlisted = $checkWish->num_rows > 0;
?>

<div class="menu-card">

<a href="add_to_wishlist.php?item_id=<?php echo $item_id; ?>"
class="wishlist-icon <?php echo $isWishlisted ? 'active' : ''; ?>">
<?php echo $isWishlisted ? '❤️' : '🤍'; ?>
</a>

<img src="images/<?php echo $row['image']; ?>">

<div class="card-content">

<!-- VEG NONVEG DISPLAY -->
<div class="food-type">
<?php if($type == 'veg'){ ?>
<div class="veg-icon"></div> Veg
<?php } else { ?>
<div class="nonveg-icon"></div> Non-Veg
<?php } ?>
</div>

<h2><?php echo $row['item_name']; ?></h2>
<div class="price">₹<?php echo $row['price']; ?></div>

<input type="hidden" name="price[]" value="<?php echo $row['price']; ?>">
<input type="hidden" name="item_id[]" value="<?php echo $item_id; ?>">

<button type="button" class="add-btn" onclick="addItem(this)">ADD</button>

<div class="cart-box" style="display:none;">
<button type="button" onclick="decreaseQty(this)">-</button>
<input type="number" name="quantity[]" value="0" class="qty-input" readonly>
<button type="button" onclick="increaseQty(this)">+</button>
</div>

</div>
</div>

<?php } ?>
</div>

<h2 id="liveTotal">Total: ₹0</h2>

<div class="sticky-bar" id="stickyBar">
<span id="stickyTotal">Total: ₹0</span>
<button type="submit" name="place_order" class="order-btn">
Checkout →
</button>
</div>

<div class="floating-cart" onclick="toggleCart()">
🛒 <span id="cartCount">0</span>
</div>

<div class="cart-popup" id="cartPopup">
<h3>Your Cart</h3>
<div class="cart-items" id="cartItems">Cart Empty</div>
<strong id="popupTotal">Total: ₹0</strong>
<button type="submit" name="place_order" class="popup-checkout">
Checkout →
</button>
</div>

</form>

<script>

function addItem(btn){

let card = btn.closest(".menu-card");

btn.style.display="none";

let box = card.querySelector(".cart-box");
box.style.display="flex";

let input = box.querySelector(".qty-input");
input.value = 1;

updateCart();

}

function increaseQty(btn){

let box = btn.closest(".cart-box");
let input = box.querySelector(".qty-input");

input.value = parseInt(input.value) + 1;

updateCart();

}

function decreaseQty(btn){

let box = btn.closest(".cart-box");
let input = box.querySelector(".qty-input");

let value = parseInt(input.value);

if(value > 1){
input.value = value - 1;
}else{
box.style.display="none";
box.previousElementSibling.style.display="inline-block";
input.value = 0;
}

updateCart();

}

function updateCart(){

let total=0,count=0;

let qty=document.getElementsByName("quantity[]");
let price=document.getElementsByName("price[]");
let names=document.querySelectorAll(".menu-card h2");

let html="";

for(let i=0;i<qty.length;i++){

let q=parseInt(qty[i].value)||0;
let p=parseFloat(price[i].value)||0;

if(q>0){

total+=q*p;
count+=q;

html+=names[i].innerText+" x "+q+"<br>";

}

}

document.getElementById("liveTotal").innerHTML="Total: ₹"+total;
document.getElementById("hiddenTotal").value=total;

document.getElementById("cartCount").innerHTML=count;

document.getElementById("popupTotal").innerHTML="Total: ₹"+total;

document.getElementById("stickyTotal").innerHTML="Total: ₹"+total;

document.getElementById("cartItems").innerHTML=html || "Cart Empty";

document.getElementById("stickyBar").style.display = total>0 ? "flex":"none";

}

function toggleCart(){

let popup=document.getElementById("cartPopup");

popup.style.display = popup.style.display==="block" ? "none" : "block";

}

</script>

</body>
</html>