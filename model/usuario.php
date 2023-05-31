<?php
require_once 'conexion.php';

class Usuario extends Conexion{
  private $acceso;

  //constructor
  public function __construct(){
    $this->acceso = parent::getConexion();
  }

  public function iniciarSesion($email =""){
    try{
      $consulta = $this->acceso->prepare("CALL spu_user_login(?)");
      $consulta->execute(array($email));

      return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    catch (Exception $e){
      die($e->getMessage());
    }
  }
  
  public function listarUsuarios(){
    try{
      //Preparamos la consulta
      $consulta = $this->acceso->prepare("CALL spu_listar_usuarios");
      //Ejecutamos la consulta
      $consulta->execute();

      //Presentaremos los datos obtenidos como ARRAY asociativo
      $tabla = $consulta->fetchAll(PDO::FETCH_ASSOC);
      //Retornamos los datos obtenidos
      return $tabla;
    }catch(Exception $e){
      die($e->getMessage());
    }
  }
}

?>