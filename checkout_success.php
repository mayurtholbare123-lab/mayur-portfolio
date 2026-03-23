<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Order Success</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="style.css">

<style>

/* ===== Background ===== */

body{
margin:0;
background:radial-gradient(circle at top,#0f172a,#000);
font-family:'Segoe UI',sans-serif;
overflow:hidden;
}

/* Full Overlay */
.success-overlay{
position:fixed;
top:0;
left:0;
width:100%;
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:rgba(0,0,0,0.6);
backdrop-filter:blur(6px);
}

/* Success Box Glow */
.success-box{
background:white;
padding:40px 35px;
border-radius:20px;
text-align:center;
position:relative;
z-index:5;
animation:boxFade 0.6s ease forwards, glowPulse 2s infinite alternate;
box-shadow:0 0 25px rgba(22,163,74,0.4);
}

@keyframes boxFade{
from{opacity:0; transform:scale(0.85);}
to{opacity:1; transform:scale(1);}
}

@keyframes glowPulse{
from{box-shadow:0 0 20px rgba(22,163,74,0.4);}
to{box-shadow:0 0 45px rgba(22,163,74,0.8);}
}

/* SVG Glow */
.phonepe-svg{
width:90px;
height:90px;
animation:popIn 0.6s ease forwards;
filter:drop-shadow(0 0 15px rgba(22,163,74,0.8));
}

@keyframes popIn{
from{transform:scale(0.6); opacity:0;}
to{transform:scale(1); opacity:1;}
}

.tick-mark{
fill:none;
stroke:#fff;
stroke-width:4;
stroke-linecap:round;
stroke-linejoin:round;
stroke-dasharray:50;
stroke-dashoffset:50;
animation:drawTick 0.6s 0.4s forwards;
}

@keyframes drawTick{
to{stroke-dashoffset:0;}
}

/* Text Glow */
h2{
animation:textGlow 1.5s infinite alternate;
}

@keyframes textGlow{
from{text-shadow:0 0 5px rgba(22,163,74,0.4);}
to{text-shadow:0 0 20px rgba(22,163,74,0.9);}
}

/* Floating Glow */
.glow{
position:absolute;
width:8px;
height:8px;
background:#16a34a;
border-radius:50%;
opacity:0.7;
animation:floatUp 4s linear infinite;
}

@keyframes floatUp{
0%{transform:translateY(0); opacity:0.8;}
100%{transform:translateY(-300px); opacity:0;}
}

/* ===== Light Explosion Sparkle ===== */

.sparkle{
position:absolute;
width:6px;
height:6px;
background:white;
border-radius:50%;
opacity:0;
animation:sparkleBurst 1s ease-out forwards;
}

@keyframes sparkleBurst{
0%{transform:scale(0); opacity:1;}
100%{transform:scale(4); opacity:0;}
}

/* ===== Mini Confetti ===== */

.confetti{
position:fixed;
width:8px;
height:8px;
background:gold;
top:0;
opacity:0.9;
animation:confettiFall 2s linear forwards;
}

@keyframes confettiFall{
0%{transform:translateY(-20px) rotate(0deg);}
100%{transform:translateY(100vh) rotate(360deg);}
}

</style>

</head>

<body>

<div class="success-overlay">

<div class="success-box" id="successBox">

<div class="phonepe-success">

<svg viewBox="0 0 52 52" class="phonepe-svg">
<circle cx="26" cy="26" r="22" fill="#16a34a"/>
<path class="tick-mark" d="M16 27 L23 34 L36 19"/>
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

<!-- Floating Glow -->
<div class="glow" style="left:20%; bottom:0; animation-delay:0s;"></div>
<div class="glow" style="left:40%; bottom:0; animation-delay:1s;"></div>
<div class="glow" style="left:60%; bottom:0; animation-delay:2s;"></div>
<div class="glow" style="left:75%; bottom:0; animation-delay:1.5s;"></div>

<script>

/* Redirect */
setTimeout(()=>{
window.location="menu.php";
},3000);

/* Mobile Vibration */
function mobileVibrate(){
try{
if(navigator.vibrate){
navigator.vibrate(200);
}
}catch(e){}
}

window.addEventListener("load", function(){
setTimeout(function(){
mobileVibrate();
createSparkle();
createConfettiBurst();
},800);
});

/* ===== Sparkle Explosion ===== */

function createSparkle(){
const box = document.getElementById("successBox");
for(let i=0;i<20;i++){
let s=document.createElement("div");
s.classList.add("sparkle");
s.style.left=Math.random()*100+"%";
s.style.top=Math.random()*100+"%";
box.appendChild(s);
setTimeout(()=>{s.remove();},1000);
}
}

/* ===== Mini Confetti Burst ===== */

function createConfettiBurst(){
for(let i=0;i<40;i++){
let c=document.createElement("div");
c.classList.add("confetti");
c.style.left=Math.random()*100+"%";
c.style.background=`hsl(${Math.random()*360},100%,50%)`;
document.body.appendChild(c);
setTimeout(()=>{c.remove();},2000);
}
}

</script>

</body>
</html>