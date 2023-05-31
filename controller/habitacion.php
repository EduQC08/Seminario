<?php

require_once '../model/habitacion.php';

if(isset($_POST['operacion'])){
  $habitacion = new Habitacion();

  if($_POST['operacion'] == 'listar'){
    $datos = $habitacion->listarhabitaciones();

    if($datos){
      echo json_encode($datos);
    }

    
  }
  if($_POST['operacion'] == 'listarestado'){
    $datos = $habitacion->estadoHabitacion();

    if($datos){
      echo json_encode($datos);
    }
  }

  
}