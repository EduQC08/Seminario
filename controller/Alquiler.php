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
    $datos = $alquiler->buscarHabitacion($_POST['numhabitacion']);
    echo json_encode($datos);
  }
}