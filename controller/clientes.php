<?php

require_once '../model/clientes.php';

if(isset($_POST['operacion'])){
  $clientes = new Clientes();

  if($_POST['operacion'] == 'listar'){
    $datos = $clientes->listarClientes();

    if($datos){
      echo json_encode($datos);
    }
  }

  if($_POST['operacion'] == 'registrar'){
    $datosGuardar = [
      "apellidos" => $_POST['apellidos'],      
      "nombres" => $_POST['nombres'],
      "tipo_documento" => $_POST['tipo_documento'],
      "num_documento" => $_POST['num_documento'],
      "telefono" => $_POST['telefono']      
    ];

    $respuesta = $clientes->registrarClientes($datosGuardar);
    echo json_encode($respuesta);
  }
}