<?php
session_start();
include 'db.php';

if(!isset($_SESSION['email'])){
header("Location: login.php");
exit();
}

$user_email = $_SESSION['email'];
$added = false;

if(isset($_GET['item_id'])){

$item_id = (int)$_GET['item_id'];

/* CHECK IF ALREADY EXISTS */
$check = $conn->query("
SELECT id FROM wishlist 
WHERE user_email='$user_email' 
AND item_id='$item_id'
");

if($check->num_rows == 0){
$conn->query("
INSERT INTO wishlist (user_email,item_id) 
VALUES ('$user_email','$item_id')
");
$added = true;
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Wishlist Update</title>
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
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:
linear-gradient(rgba(0,0,0,0.85),rgba(0,0,0,0.85)),
url("images/biryani-bg.jpg");
background-size:cover;
color:white;
overflow:hidden;
}

/* Glass Card */

.card{
background:rgba(0,0,0,0.6);
padding:50px 40px;
border-radius:20px;
text-align:center;
backdrop-filter:blur(15px);
border:1px solid #f4b40050;
box-shadow:0 0 40px rgba(0,0,0,0.6);
animation:fadeIn 0.6s ease;
}

.card h2{
margin-top:20px;
color:#f4b400;
}

.card p{
margin-top:10px;
color:#ddd;
}

/* Animated Heart */

.heart{
font-size:70px;
animation:pop 0.6s ease infinite alternate;
color:#ff4d6d;
}

@keyframes pop{
from{ transform:scale(1); }
to{ transform:scale(1.2); }
}

/* Sparkle Effect */

.sparkle{
position:absolute;
width:8px;
height:8px;
background:#f4b400;
border-radius:50%;
animation:explode 1s ease forwards;
}

@keyframes explode{
to{
transform:translate(var(--x),var(--y));
opacity:0;
}
}

/* Fade */

@keyframes fadeIn{
from{opacity:0; transform:translateY(20px);}
to{opacity:1; transform:translateY(0);}
}

</style>
</head>
<body>

<div class="card">
<div class="heart">
<?php echo $added ? "❤️" : "💛"; ?>
</div>

<h2>
<?php echo $added ? "Added to Wishlist!" : "Already in Wishlist"; ?>
</h2>

<p>Redirecting to menu...</p>
</div>

<script>

/* Sparkle Burst */
for(let i=0;i<25;i++){
let s=document.createElement("div");
s.className="sparkle";
s.style.left="50%";
s.style.top="45%";
s.style.setProperty("--x",(Math.random()*200-100)+"px");
s.style.setProperty("--y",(Math.random()*200-100)+"px");
document.body.appendChild(s);

setTimeout(()=>{ s.remove(); },1000);
}

/* Auto Redirect */
setTimeout(()=>{
window.location.href="menu.php";
},2000);

</script>

</body>
</html>