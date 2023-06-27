<?php
include_once ("../Clases/BaseDatos.php");
include_once '../Clases/Pasajero.php';
include_once '../Clases/Viaje.php';
include_once '../Clases/Empresa.php';
include_once '../Clases/Responsable.php';
$pas=new Pasajero();
    $arregloPas=$pas->listar();
    $cantPas=1;
    foreach ($arregloPas as $p){
      $p->buscar($p->getDni());
      echo "Pasajero ".$cantPas."\n";
      echo $p."\n";
      $cantPas++;}
?>