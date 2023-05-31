<?php

session_start();

$nivelacceso = "EMP";

$url = $_SERVER['REQUEST_URI'];
$url_array = explode("/", $url);
$vistaActiva = $url_array[count($url_array) -1];

$permisos = [
  "ADM" => ["habitaciones.php, alquiladas.php"],
  "EMP" =>["habitaciones.php"]
];

$autorizado = false;

$vistasPermitidas = $permisos[$nivelacceso];

foreach($vistasPermitidas as $item){
  if($item == $ $vistaActiva){
    $autorizado = true;
  }
}

if(!$autorizado){
  echo "<h1>Acceso restringido</h1>";
  exit();
}
?>