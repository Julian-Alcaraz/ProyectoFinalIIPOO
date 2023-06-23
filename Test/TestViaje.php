<?php
  include_once ("../Clases/BaseDatos.php");
  include_once '../Clases/Pasajero.php';
  include_once '../Clases/Viaje.php';
  include_once '../Clases/Empresa.php';
  include_once '../Clases/Responsable.php';



  //primero voy a permitir que ingrese, modifique o elimine una empresa
  /*despues eligiendo una empresa previamente creada, si existe,
   en caso contrario no va a poder, debera permitir crear un viaje,si y solo si 
   existe un responsable para ese viaje, en caso de no existir debera crearlo o no podra relaizar el viaje
   una vez tenga el viaje con su responsable podra crear los pasajeros
    solo existiendo viajes para venderles coon su responsable
    ESE ES MI TEST 
  */
  //FUNCIONES GENERALES
  function opcionesEmpresa(){
    echo"**************************************************************\n";
    echo "*Ingrese 1 si quiere INGRESAR una empresa\n";
    echo "*Ingrese 2 si quiere MODIFICAR una empresa\n";
    echo "*Ingrese 3 si quiere ELIMINAR una empresa\n";
    echo "*Ingrese 4 si quiere LISTAR empresas\n";
    echo "*Ingrese 5 si quiere TRABAJAR SOBRE LOS VIAJES de una empresa\n";
    echo "*Ingrese cualquier numero distinto para salir \n";
    $op = trim(fgets(STDIN));
    echo"**************************************************************\n";
    return $op;
  }
  //FUNCIONES EMPRESA
  function ingresarEmpresa(){
    $empresa=new Empresa();
    echo "Ingrese el Nombre de la empresa ";
    $nombreE=trim(fgets(STDIN));
    echo "Ingrese la direccion de la empresa ";
    $direccionE=trim(fgets(STDIN));
    $empresa->setNombre($nombreE);
    $empresa->setDireccion($direccionE);
    $empresa->insertar();
  }
  function eliminarEmpresa(){
    $emp=new Empresa();
    echo "Ingrese el ID de la empresa que desea eliminar\n";
    $idEli = trim(fgets(STDIN));
    $emp->setIdEmpresa($idEli);
    $arregloEmp=$emp->listar();
    $existeEmp=false;
    foreach($arregloEmp as $e){
      if($e->getIdEmpresa()==$idEli){
        $existeEmp=true;
      }
    }
    if($existeEmp){
      $emp->eliminar();
      echo "Empresa eliminada correctamente\n";
    }else{
      echo "ID ingresado no existente \n";
    }
  }
  function modificarEmpresa(){
    $emp= new Empresa();
    echo "Ingrese el ID de la empresa que desea modificar\n";
    $idMod = trim(fgets(STDIN));
    $emp->setIdEmpresa($idMod);
    $arregloEmp=$emp->listar();
    $existeEmp=false;
    foreach($arregloEmp as $e){
      if($e->getIdEmpresa()==$idMod){
        $existeEmp=true;
      }
    }
    if($existeEmp){
      echo "Ingrese el nombre\n";
      $nombreE=trim(fgets(STDIN));
      echo "Ingrese la direccion de la empresa\n";
      $direccionE=trim(fgets(STDIN));
      $emp->setNombre($nombreE);
      $emp->setDireccion($direccionE);
      $emp->modificar();
      echo "Empresa Modificada correctamente\n";
    }else{
      echo "ID ingresado no existente\n";
    }
  }
  function listarEmpresas(){
    $emp=new Empresa();
    $arregloEmp=$emp->listar();
    $cantEmp=1;
    foreach ($arregloEmp as $e){
      echo "Empresa ".$cantEmp."\n";
      echo $e."\n";
      $cantEmp++;
    }
  }
  do{
    $opcion=opcionesEmpresa();
    switch($opcion){
      case 1:
        ingresarEmpresa();
        break;
      case 2:
        modificarEmpresa();
        break;
      case 3:
        eliminarEmpresa();
        break;
      case 4:
        listarEmpresas();
        break;
      case 5:

        break;
      default: $opcion=-1;
        break;
    }
  }while($opcion!=-1)

?>