<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css"> 
    <link rel="stylesheet" type="text/css" href="css/css/all.min.css">
</head>

<!--este codigo se realiza para permitir mantenernos en la vista del usuario logueado cuando se presione el boton hacia atras y no redirija al inicio de sesion--> 
<?php 
session_start();//para usar las variables sesiones
if(!empty($_SESSION['us_tipo'])){//si existe una session activa me envia directamente al login controller, para que esta se encargue de enrutarla
   header  ('Location: controlador/LoginController.php');
}
else{
session_destroy();// en caso de que no haya una sesion en curso deben borrarse
?>
<body>
    <img class="wave" src="img/wave.png" alt="">
    <div class="contenedor">
        <div class="img">
            <img src="img/bg.svg" alt="">
        </div>
        <div class="contenindo-login">
            <form action="controlador/LoginController.php" method="post">
                <img src="img/logo.png" alt="">
                <h2>Farmacia</h2>
                <div class="input-div dni">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>DNI</h5>
                        <input type="text" name="user" class="input">
                    </div>
                </div>
                <div class="input-div pass">
                <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>contrasena</h5>
                        <input type="password" name="pass" class="input">
                    </div>
                </div>
                <a href="">Create warplace</a>
                <input type="submit" class="btn" values="Iniciar Sesion">
            </form>

        </div>
    </div>
</body>
<script src="js/login.js"></script>
</html>
<?php
 }
?>