<?php

require_once 'conexion.php';

class Alquiler  extends Conexion{
  private $conexion;

  public function __CONSTRUCT(){
    $this->conexion = parent::getConexion();
  }

  public function listarAlquiler(){
    try{
      $consulta = $this->conexion->prepare("CALL spu_alquiler_listar()");
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
    die($e->getMessage());
    }
  }
  public function buscarHabitacion($numhabitacion){
    try{
      $consulta = $this->conexion->prepare("CALL spu_alquiler_buscar(?)");
      $consulta->execute(array($numhabitacion));

      return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }
}