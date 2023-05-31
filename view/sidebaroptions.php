<?php

$permiso = $_SESSION['login']['nivelacceso'];

$optiones = [];


switch($permiso){
  case "ADM":
    $optiones = [
      ["menu" => "Habitaciones", "url" => "hotel.php?view=habitaciones.php"],
      ["menu" => "Alquiladas", "url" => "hotel.php?view=alquiladas.php"]

    ];
    break;
    case "EMP":
      $optiones = [
        ["menu" => "Habitaciones", "url" => "hotel.php?view=habitaciones.php"],
      ];


}

foreach ($optiones as $item){
  echo "
  <li class='nav-item'>
  <a class='nav-link' href='{$item['url']}'>
      <i class='fas fa-fw fa-chart-area'></i>
      <span>{$item['menu']}</span></a>
</li>
  ";
}

?>