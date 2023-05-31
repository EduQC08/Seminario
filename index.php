<?php
session_start();

//Si el usario ya tiene una sesión activa ... entonces no debe estar aqui!!!
if(isset($_SESSION['seguridad'])){
  if($_SESSION['seguridad']['login']){
    header('Location:view/hotel.html');
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="./styles.css">

  <!--Bootstrap 5-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>
<body  >
 
<div class="container">
    <div class="login-container">
      <h1>Iniciar sesión</h1>
      <form class="login-form" action="" method="post">
        <div class="form-group">
          <label for="username">Nombre de usuario</label>
          <input type="text" id="email" name="username" required>
        </div>
        <div class="form-group">
          <text>Contarseña</text>
          <input type="password" id="password" name="password" required>
        </div>
        <input type="submit" value="Iniciar sesión" id="iniciar-sesion">
      </form>
    </div>
  </div>
  <!--jquery-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

  <script>
    $(document).ready(function (){

      function login(){
        const datos= {
        "operacion"     : "iniciarSesion",
        "correo" : $("#email").val(),
        "clave"         : $("#password").val()
        };

        $.ajax({
        url: './controller/usuario.controller.php',
        type: 'GET',
        data: datos,
        dataType: 'JSON',
        success: function (result){
            if (result.login){
            alert(`Bienvenido: ${result.nombre} ${result.apellidos} `);
            window.location.href = `./view/hotel.php`;
            }else{
            alert(result.mensaje);
            }
        }
        });
      }

      $("#iniciar-sesion").click(login);

      $("#password").keypress(function (evt){
        if(evt.keyCode == 13){
          login();
        }
      });

    });
  </script>
  
</body>
</html>