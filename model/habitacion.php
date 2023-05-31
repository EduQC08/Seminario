<?php

require_once 'conexion.php';

class Habitacion extends Conexion{
  private $conexion;

  public function __CONSTRUCT(){
    $this->conexion = parent::getConexion();
  }

  public function listarhabitaciones(){
   try{
    $consulta = $this->conexion->prepare("CALL listarhabitacion");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);
   } 
   catch(Exception $e){
    die($e->getMessage());
   }
  }

  public function estadoHabitacion(){
    try{
      $consulta = $this->conexion->prepare("CALL spu_mostrar_estado");
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){

      die($e->getMessage());
    }
  }
}