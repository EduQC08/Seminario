<?php

require_once '../model/Alquiler.php';

if(isset($_POST['operacion'])){

  $alquiler = new Alquiler();

  if($_POST['operacion'] == 'listar'){

    $datos = $alquiler->listarAlquiler();

    if($datos){
      echo json_encode($datos);
    }
  }

  if ($_POST['operacion'] == 'buscar'){
    $datos = $alquiler->buscarHabitacion($_POST['idhabitacion']);
    echo json_encode($datos);
  }

  if($_POST['operacion'] == 'actualizar'){
    $datosActualizar = [
      "idalquiler" => $_POST['idalquiler'],
      "horasalida" => $_POST['horasalida'],
      "pago"       => $_POST['pago']
    ];
    $respuesta = $alquiler->actualizar($datosActualizar);
    echo json_encode($respuesta);
  }

  if($_POST['operacion'] == 'registrar'){
    $datos = [
      "idhabitacion"              => $_POST['idhabitacion'],
      "idcliente"                 => $_POST['idcliente'],
      "idusuario"                 => $_POST['idusuario'],
      "pago"                      => $_POST['pago']

      
    ];
     $alquiler->RegistrarAlquiler($datos);
    echo json_encode($respuesta); 
  }

  
  
}