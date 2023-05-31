<?php

require_once 'conexion.php';

class Clientes extends Conexion{
  private $conexion;

  public function __CONSTRUCT(){
    $this->conexion = parent::getConexion();
  }

  public function listarClientes(){
    try{
      $consulta = $this->conexion->prepare("CALL spu_clientes_listar");
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function registrarClientes($datos = []){
    $respuesta = [
      "status" => false,
      "message" => ""
    ];
    try{
      $consulta = $this->conexion->prepare("CALL spu_registrar_cliente(?,?,?,?,?)");
      $respuesta["status"] = $consulta->execute(
        array(
          $datos["apellidos"],
          $datos["nombres"],
          $datos["tipo_documento"],
          $datos["num_documento"],
          $datos["telefono"]
          
        )
        );
    }
    catch(Exception $e){
      $respuesta["message"] = "No se ha podido completar el proceso. Codigo error". $e->getCode();
    }
    return $respuesta;
  }
}