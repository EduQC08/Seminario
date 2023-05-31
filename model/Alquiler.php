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

  public function actualizar ($datos = []){
    $respuesta = [
      "status " => false,
      "message" => ""
    ];
    try{
      $consulta = $this->conexion->prepare("CALL pagoactivar(?,?,?)");
      $respuesta["status"] = $consulta->execute(
        array(
          $datos["idalquiler"],
          $datos["horasalida"],
          $datos["pago"]
        )
        );
    }
    catch(Exception $e){
      $respuesta["message"] = "No se ah podido completar el proceso. Codigo error";
    }
    return $respuesta;
  }

  public function RegistrarAlquiler($datos = []){
    try{
      $consulta = $this->conexion->prepare("INSERT INTO alquiler (idhabitacion, idcliente, idusuario, pago) values (?,?,?,?)");
      $consulta->execute(array(
          $datos["idhabitacion"],
          $datos["idcliente"],
          $datos["idusuario"],
          $datos["pago"]
        ));
      }
      catch(Exception $e){
        $respuesta["message"] = "no se ha podido completar la operacion";
      }
    return $respuesta;
  }
}