<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Biryani House</title>

<style>

/* Full Screen Splash */
body{
margin:0;
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(135deg,#ff9800,#ff5722);
overflow:hidden;
}

/* Logo */
.logo{
width:150px;
animation:logoAnim 3s ease forwards;
}

/* Animation */
@keyframes logoAnim{
0%{
transform:scale(0.6);
opacity:0;
}
40%{
transform:scale(1.2);
opacity:1;
}
70%{
transform:scale(1);
}
100%{
opacity:0;
transform:scale(0.9);
}
}

</style>
</head>

<body>

<img src="logo.png" class="logo">

<script>

/* 3 sec ke baad login page */
setTimeout(function(){
window.location="Index.php";
},3000);

</script>

</body>
</html>