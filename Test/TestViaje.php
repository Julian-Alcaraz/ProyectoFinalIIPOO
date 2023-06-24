<?php
  include_once ("../Clases/BaseDatos.php");
  include_once '../Clases/Pasajero.php';
  include_once '../Clases/Viaje.php';
  include_once '../Clases/Empresa.php';
  include_once '../Clases/Responsable.php';

  /*checklist 
  (ingresar,modificar, eliminar, listar empresas) HECHO
  ingresar HECHO , modificar, eliminar, listar viajes
  ingresar HECHO , modificar ,elimar , listar Responsable
  ingresar, modificar ,eliminar , listar pasajeros
  */

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
    echo "*Ingrese 5 si quiere TRABAJAR SOBRE una empresa\n";
    echo "*Ingrese cualquier numero distinto para salir \n";
    $op = trim(fgets(STDIN));
    echo"**************************************************************\n";
    return $op;
  }
  function opcionesGeneral(){
    echo"**************************************************************\n";
    echo "  **Ingrese 1 si quiere TRABAJAR SOBRE LOS VIAJES\n";
    echo "  **Ingrese 2 si quiere TRABAJAR SOBRE LOS PASAJEROS\n";
    echo "  **Ingrese 3 si quiere TRABAJAR SOBRE LOS RESPONSABLES\n";
    echo "  **Ingrese 4 para volver al menu de empresas\n";
    echo "  **Ingrese cualquier numero distinto para salir de la APP \n";
    $opc = trim(fgets(STDIN));
    echo"**************************************************************\n";
    return $opc;
  }
  function opcionesViaje(){
    echo "    ***Ingrese 1 si quiere INGRESAR un viaje\n";
    echo "    ***Ingrese 2 si quiere MODIFICAR un viaje\n";
    echo "    ***Ingrese 3 si quiere ELIMINAR un viaje\n";
    echo "    ***Ingrese 4 si quiere LISTAR viajes\n";
    echo "    ***Ingrese cualquier numero distinto para volver atras\n";

    $opV = trim(fgets(STDIN));
    return $opV;
  }
  function opcionesResponsable(){
    echo "    ***Ingrese 1 si quiere INGRESAR un Responsable\n";
    echo "    ***Ingrese 2 si quiere MODIFICAR un Responsable\n";
    echo "    ***Ingrese 3 si quiere ELIMINAR un Responsable\n";
    echo "    ***Ingrese 4 si quiere LISTAR Responsables\n";
    echo "    ***Ingrese cualquier numero distinto para volver atras\n";
    $opR = trim(fgets(STDIN));
    return $opR;
  }
  function opcionesPasajeros(){
    echo "    ***Ingrese 1 si quiere INGRESAR un Pasajeros\n";
    echo "    ***Ingrese 2 si quiere MODIFICAR un Pasajeros\n";
    echo "    ***Ingrese 3 si quiere ELIMINAR un Pasajeros\n";
    echo "    ***Ingrese 4 si quiere LISTAR Pasajeros\n";
    echo "    ***Ingrese cualquier numero distinto para volver atras\n";
    $opP = trim(fgets(STDIN));
    return $opP;
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
    $existeEmp=existeEmpresa($idEli);
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
    $existeEmp=existeEmpresa($idMod);
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
  function devolverEmpresa($idE){
    $emp= new Empresa();
    $emp->setIdEmpresa($idE);
    $arregloEmp=$emp->listar();
    foreach($arregloEmp as $e){
      if($e->getIdEmpresa()==$idE){
        $emp=$e;
      }
    }
    return $emp;
  }
  function existeEmpresa($idE){
    $emp= new Empresa();
    $emp->setIdEmpresa($idE);
    $arregloEmp=$emp->listar();
    $existencia=false;
    foreach($arregloEmp as $e){
      if($e->getIdEmpresa()==$idE){
        $existencia=true;
      }
    }
    return $existencia;
  }
  // FUNCIONES VIAJE
  function ingresarViaje($idE){
    echo "Ingrese el Id del responsable ";
    $numeroRes=trim(FGETS(STDIN));

    if(existeResponsable($numeroRes)){
      $viaje=new Viaje();
      echo "Ingrese el Destino del viaje ";
      $destinoV=trim(fgets(STDIN));
      echo "Ingrese la Cantidad Maxima de pasajeros del viaje ";
      $cantMaxPasajerosV=trim(fgets(STDIN));
      $empresaV=devolverEmpresa($idE);
      echo "Ingrese el Importe del viaje ";
      $importeV=trim(fgets(STDIN));
      $responsableV=devolverResponsable($numeroRes);

      $viaje->setDestino($destinoV);
      $viaje->setCantMaxPasajeros($cantMaxPasajerosV);
      $viaje->setObjResponsable($responsableV);
      $viaje->setObjEmpresa($empresaV);
      $viaje->setImporte($importeV);

      $viaje->insertar();
    }else{
      echo "El Responsable ingresado no existe\n";
      echo "Cargue un responsable o igrese el codigo correcto\n";
    }
  }
  function modificarViaje(){}
  function eliminarViaje(){}
  function listarViajes(){}

  //FUNCIONES RESPONSABLE
  function existeResponsable($numR){
    $res= new Responsable();
    $res->setNumeroEmpleado($numR);
    $arregloRes=$res->listar();
    $existencia=false;
    foreach($arregloRes as $r){
      if($r->getNumeroEmpleado()==$numR){
        $existencia=true;
      }
    }
    return $existencia;
  }
  function devolverResponsable($numR){
    $res= new Responsable();
    $res->setNumeroEmpleado($numR);
    $arregloRes=$res->listar();
    foreach($arregloRes as $r){
      if($r->getNumeroEmpleado()==$numR){
        $res=$r;
      }
    }
    return $res;
  }
  function ingresarResponsable(){
    $respon= new Responsable;
    echo "Ingresar numero Licencia ";
    $numeroLic=trim(fgets(STDIN));
    echo "Ingresar nombre ";
    $nombreR=trim(fgets(STDIN));
    echo "Ingresar apellido ";
    $apellidoR=trim(fgets(STDIN));
    $respon->setNumeroLicencia($numeroLic);
    $respon->setNombre($nombreR);
    $respon->setApellido($apellidoR);
    $respon->insertar();
  }
  function modificarResponsable(){}
  function eliminarResponsable(){}
  function listarResponsables(){}
  //FUNCIONES PASAJEROS
  function ingresarPasajero(){}
  function modificarPasajero(){}
  function eliminarPasajero(){}
  function listarPasajeros(){}
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
        $emp= new Empresa();
        echo "Ingrese el numero de empresa con la cual quiere trabajar\n";
        $numEmp=trim(fgets(STDIN));
        $existeEmp=existeEmpresa($numEmp);
        if($existeEmp){
          do{
            $opcionG=opcionesGeneral();
            switch($opcionG){
              case 1://viajes
                  do{
                    $opcionV=opcionesViaje();
                    switch($opcionV){
                      case 1:
                        ingresarViaje($numEmp);
                        break;
                      case 2: 
                        modificarViaje();
                        break;
                      case 3:
                        eliminarViaje();
                        break;
                      case 4:
                        listarViajes();
                        break;
                      default:
                        $opcionV=-3;
                        break;
                    }
                  }while($opcionV!=-3);
                break;
              case 2://pasajeros
                do{
                  $opcionP=opcionesPasajeros();
                  switch($opcionP){
                    case 1:
                      ingresarPasajero($numEmp);
                      break;
                    case 2: 
                      modificarPasajero();
                      break;
                    case 3:
                      eliminarPasajero();
                      break;
                    case 4:
                      listarPasajeros();
                      break;
                    default:
                      $opcionP=-3;
                      break;
                  }
                }while($opcionP!=-3);
                break;
              case 3://responsable
                do{
                  $opcionR=opcionesResponsable();
                  switch($opcionR){
                    case 1:
                      ingresarResponsable($numEmp);
                      break;
                    case 2: 
                      modificarResponsable();
                      break;
                    case 3:
                      eliminarResponsable();
                      break;
                    case 4:
                      listarResponsables();
                      break;
                    default:
                      $opcionR=-3;
                      break;
                  }
                }while($opcionR!=-3);
                break;
              case 4:
                $opcionG=-2;
                break;
              default:
                $opcion=-1;
                $opcionG=-2;
                break;
              }         
            }while($opcionG!=-2);
          }else{
            echo "ID ingresado no existente\n";
          }
        break;
      default: $opcion=-1;
        break;
    }
  }while($opcion!=-1);

?>