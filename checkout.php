<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Order Success</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="style.css">

</head>

<body>

<div class="success-overlay">

<div class="success-box">

<div class="phonepe-success">

<svg viewBox="0 0 52 52" class="phonepe-svg">

<circle cx="26" cy="26" r="22" fill="#16a34a"/>

<path class="tick-mark"
d="M16 27 L23 34 L36 19"/>

</svg>

</div>

<h2 style="color:#16a34a;font-size:18px;margin-top:15px;">
Order Successful 🎉
</h2>

<p style="font-size:14px;margin-top:8px;color:#555;">
Your food is preparing 🍽️
</p>

<audio id="successSound" autoplay>
<source src="success.mp3" type="audio/mpeg">
</audio>

</div>

</div>

<script>
setTimeout(()=>{
window.location="menu.php";
},3000);
</script>

    <script>

/* ⭐ Mobile Vibration Force Sync */

function mobileVibrate(){

try{

if(navigator.vibrate){

navigator.vibrate(200);

}

}catch(e){}

}

/* Run vibration after animation load */

window.addEventListener("load", function(){

setTimeout(function(){

mobileVibrate();

},800);

});

</script>
</body>
</html>