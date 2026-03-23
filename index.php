<!DOCTYPE html>
<html>
<head>
<title>Biryani House</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
color:white;
background:#0f0f0f;
}

/* ================= HERO ================= */

.hero{
height:100vh;
background:
linear-gradient(rgba(0,0,0,0.75),rgba(0,0,0,0.75)),
url("images/biryani-bg.jpg");
background-size:cover;
background-position:center;
display:flex;
flex-direction:column;
justify-content:center;
padding:0 100px;
position:relative;
}

.top-bar{
position:absolute;
top:25px;
left:80px;
font-size:14px;
color:#ddd;
}

.admin-btn{
position:absolute;
top:20px;
right:80px;
padding:7px 18px;
border:1px solid #f4b400;
border-radius:25px;
text-decoration:none;
color:#f4b400;
font-size:13px;
transition:0.3s;
}

.admin-btn:hover{
background:#f4b400;
color:black;
}

/* ===== HERO CONTENT PREMIUM STYLE ===== */

.content{
max-width:650px;
}

.content h1{
font-family:'Playfair Display',serif;
font-size:54px;
line-height:65px;
margin-bottom:20px;
}

.content span{
color:#f4b400;
}

.tagline{
font-size:18px;
color:#ddd;
margin-bottom:25px;
}

.info-text{
font-size:15px;
color:#ccc;
line-height:1.7;
margin-bottom:35px;
max-width:600px;
}

/* ===== BUTTON STACK ===== */

.buttons{
display:flex;
flex-direction:column;
gap:14px;
max-width:220px;
}

.btn{
padding:12px 24px;
border-radius:30px;
text-decoration:none;
font-weight:600;
font-size:14px;
transition:0.3s;
text-align:center;
}

.primary{
background:#f4b400;
color:black;
}

.primary:hover{
transform:translateY(-3px);
}

.outline{
border:1px solid #ffffff55;
color:white;
}

.outline:hover{
background:white;
color:black;
}

/* ================= MID SECTION ================= */

.section{
padding:100px 80px;
text-align:center;
background:#111;
}

.section h2{
font-family:'Playfair Display',serif;
font-size:40px;
margin-bottom:20px;
}

.section p{
max-width:700px;
margin:0 auto;
color:#ccc;
line-height:1.6;
}

.features{
margin-top:60px;
display:flex;
justify-content:center;
gap:40px;
flex-wrap:wrap;
}

.feature-box{
background:#1b1b1b;
padding:30px;
border-radius:15px;
width:280px;
transition:0.3s;
}

.feature-box:hover{
transform:translateY(-6px);
}

.feature-box h3{
color:#f4b400;
margin-bottom:10px;
}

/* ================= FOOTER ================= */

.footer{
padding:40px;
text-align:center;
background:black;
color:#888;
font-size:14px;
}


<style>

/* ===== MOBILE RESPONSIVE ONLY ===== */

@media(max-width:900px){

.hero{
padding:90px 25px 60px;
text-align:center;
justify-content:center;
}

/* TOP INFO BAR */

.top-bar{
position:relative;
left:0;
top:0;
font-size:12px;
margin-bottom:25px;
}

/* ADMIN BUTTON */

.admin-btn{
position:relative;
right:0;
top:0;
display:inline-block;
margin-bottom:25px;
}

/* CONTENT CENTER */

.content{
margin:auto;
max-width:500px;
}

/* MAIN HEADING */

.content h1{
font-size:38px;
line-height:48px;
margin-bottom:15px;
}

/* TAGLINE */

.tagline{
font-size:15px;
margin-bottom:25px;
}

/* INFO TEXT LEFT STYLE MOBILE */

.info-text{
font-size:14px;
line-height:1.6;
text-align:left;
max-width:320px;
margin:0 auto 35px auto;
}

/* BUTTONS STACK */

.buttons{
display:flex;
flex-direction:column;
gap:15px;
align-items:center;
}

.btn{
width:220px;
text-align:center;
}

/* SECTION MOBILE */

.section{
padding:60px 25px;
}

.features{
flex-direction:column;
align-items:center;
gap:25px;
}

.feature-box{
width:100%;
max-width:320px;
}

}

/* SMALL SCREEN */

@media(max-width:400px){

.content h1{
font-size:32px;
line-height:42px;
}

.btn{
width:200px;
}

}

</style>
    
    
<!-- HERO -->
<div class="hero">

<div class="top-bar">
⭐ 4.8 Rating | 🚚 30 Min Delivery | 📍 DHULE
</div>

<a href="admin_login.php" class="admin-btn">Admin</a>

<div class="content">

<h1><span>Garva Biryani</span> Experience</h1>

<div class="tagline">
Premium Taste • Authentic Spices • Fast Delivery
</div>

<div class="info-text">

• Welcome to Biryani House – authentic taste in every bite.<br>

• Made with fresh spices and premium quality ingredients.<br>

• Hot and delicious biryani for a delightful meal experience.<br>

• Quality, taste, and hygiene are our top priorities.<br>

• Perfect place to enjoy biryani with family and friends.

</div>

<div class="buttons">
<a href="login.php" class="btn primary">View Menu</a>
<a href="login.php" class="btn outline">Login</a>
<a href="register.php" class="btn outline">Register</a>
</div>

</div>
</div>

<!-- ABOUT SECTION -->
<div class="section">
<h2>Why Choose Biryani House?</h2>
<p>We serve authentic royal biryani made with premium basmati rice and handpicked spices. Our chefs prepare every dish with passion to give you the best taste experience.</p>

<div class="features">
<div class="feature-box">
<h3>Premium Ingredients</h3>
<p>High quality rice and fresh spices.</p>
</div>

<div class="feature-box">
<h3>Fast Delivery</h3>
<p>Hot and fresh at your doorstep.</p>
</div>

<div class="feature-box">
<h3>Secure Ordering</h3>
<p>Safe and smooth checkout experience.</p>
</div>
</div>
</div>

<!-- FOOTER -->
<div class="footer">
© 2026 Biryani House | Premium Food Experience
</div>

</body>
</html>
