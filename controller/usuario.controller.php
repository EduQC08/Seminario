<?php
session_start(); //apertura o tambien hereda el manejo de variables de sesión

//Configuracion de la zona horaria
//date_default_timezone_set('America/Lima');
date_default_timezone_set('America/Lima');

//invocando mi modelo
require_once '../model/usuario.php';

//$usuario = new Usuario();
//si existe una operacion (inencion del usuario)
if(isset($_GET['operacion'])){

  //isntnacia de la clase usuario
  $usuario = new Usuario();
  if($_GET['operacion'] == 'destroy'){
    session_destroy(); // elimina session
    session_unset(); //libera recursos
    header('Location:../index.php');
    }
  
  //si la operacion es listar
  if($_GET['operacion'] == 'listar'){
    //Ejecutamos el metodo y guardamos el resultado
    $datos = $usuario->listarUsuarios();

    if($datos){
      echo json_encode($datos);
    }
  }
  

  if($_GET['operacion'] =='iniciarSesion'){
    //Arreglo asociativo
    $acceso =[
      "login"       => false,
      "nombre"     => "",
      "apellidos"   => "",
      "nivelacceso" => "",
      "mensaje"     => ""
    ];

    $data = $usuario->iniciarSesion($_GET['correo']);
    $claveIngresada = $_GET['clave'];  //no esta encriptada
    
    


    if($data){
      if(password_verify($claveIngresada, $data['clave'])){

        //regitrar datos de acceso
        $acceso["login"] = true;
        $acceso["nombre"]=$data["nombre"];
        $acceso["apellidos"] = $data["apellidos"];
        $acceso["correo"]=$data['correo'];
        $acceso["nivelacceso"]= $data['nivelacceso'];
       
       
      
      }else{
        $acceso["mensaje"] = "Error en la contraseña";
      }
    }else{
      $acceso["mensaje"] = "Usuario no encontrado";
    }
    //asignar el arreglo $acceso a la sesión
    $_SESSION['seguridad'] = $acceso;
    $_SESSION['inicio'] = date('h:i:s A');
    $_SESSION['fecha'] = date('y-m-d');
    $_SESSION['navegador'] = 'Google Chrome';
    //...Otras variables de sesión ...

    //enviar el objeto $acceso a la vista
    echo json_encode($acceso);
  } //fin operacion = iniciarSeseion

}
?>