<?php
include './Clases/Pasajero.php';
include './Clases/Viaje.php';
include './Clases/Empresa.php';
include './Clases/Responsable.php';



//primero voy a permitir que ingrese, modifique o elimine una empresa
/*despues eligiendo una empresa previamente creada, si existe,
 en caso contrario no va a poder, debera permitir crear un viaje,si y solo si 
 existe un responsable para ese viaje, en caso de no existir debera crearlo o no podra relaizar el viaje
 una vez tenga el viaje con su responsable podra crear los pasajeros
  solo existiendo viajes para venderles coon su responsable
  ESE ES MI TEST 
*/
function opcionesEmpresa(){
  echo"**************************************************\n";
  echo "Ingrese 1 si quiere INGRESAR una empresa\n";
  echo "Ingrese 2 si quiere MODIFICAR una empresa\n";
  echo "Ingrese 3 si quiere ELIMINAR una empresa\n";
  echo "Ingrese 4 si quiere TRABAJAR SOBRE LOS VIAJES de una empresa\n";
  echo "Ingrese cualquier numero distinto para salir ";
  echo"**************************************************\n";
  $op = trim(fgets(STDIN));
  return $op;
}

do{
  $opcion=opcionesEmpresa();
}while($opcion!=-1)

?>