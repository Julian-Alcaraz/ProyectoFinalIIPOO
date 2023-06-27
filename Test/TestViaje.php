<?php
  include_once ("../Clases/BaseDatos.php");
  include_once '../Clases/Pasajero.php';
  include_once '../Clases/Viaje.php';
  include_once '../Clases/Empresa.php';
  include_once '../Clases/Responsable.php';

  /*checklist 
  FUNCIONA Responsable ingresar HECHO , modificar(HECHO) ,eliminar (HECHO), listar(HECHO) 
  Empresas ingresar HECHO,modificar HECHO,  eliminar (HECHO)  , listar HECHO  
  Viajes ingresar HECHO , modificar(HECHO),   eliminar(HECHO)   , listar(HECHO)
  Pasajeros ingresar(HECHO)), modificar(HECHO) ,eliminar (HECHO), listar (HECHO)
  */
  //
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
    echo"**************************************************************\n";
    $opc = trim(fgets(STDIN));
    return $opc;
  }
  function opcionesViaje(){
    echo"**************************************************************\n";
    echo "    ***Ingrese 1 si quiere INGRESAR un viaje\n";
    echo "    ***Ingrese 2 si quiere MODIFICAR un viaje\n";
    echo "    ***Ingrese 3 si quiere ELIMINAR un viaje\n";
    echo "    ***Ingrese 4 si quiere LISTAR viajes\n";
    echo "    ***Ingrese cualquier numero distinto para volver atras\n";
    echo"**************************************************************\n";
    $opV = trim(fgets(STDIN));
    
    return $opV;
  }
  function opcionesResponsable(){
    echo"**************************************************************\n";
    echo "    ***Ingrese 1 si quiere INGRESAR un Responsable\n";
    echo "    ***Ingrese 2 si quiere MODIFICAR un Responsable\n";
    echo "    ***Ingrese 3 si quiere ELIMINAR un Responsable\n";
    echo "    ***Ingrese 4 si quiere LISTAR Responsables\n";
    echo "    ***Ingrese cualquier numero distinto para volver atras\n";
    echo"**************************************************************\n";
    $opR = trim(fgets(STDIN));
    return $opR;
  }
  function opcionesPasajeros(){
    echo"**************************************************************\n";
    echo "    ***Ingrese 1 si quiere INGRESAR un Pasajeros\n";
    echo "    ***Ingrese 2 si quiere MODIFICAR un Pasajeros\n";
    echo "    ***Ingrese 3 si quiere ELIMINAR un Pasajeros\n";
    echo "    ***Ingrese 4 si quiere LISTAR Pasajeros\n";
    echo "    ***Ingrese cualquier numero distinto para volver atras\n";
    echo"**************************************************************\n";
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
      $viaje=new Viaje;
      $condicion= "idempresa =".$idEli;
      $arregloViajes= $viaje->listar($condicion);// raro lo de la condicon, tengo que testear
      if($arregloViajes!=[]){
        foreach($arregloViajes as $v){
          $pas=new Pasajero();
          $arregloPasajero=$pas->listar();
          if($arregloPasajero!=[]){
            foreach ($arregloPasajero as $p){//recorro todos los pasajeros
              $p->buscar($p->getDni());
              if($p->getObjetoViaje()->getIdViaje()==$v->getIdViaje()){
                $p->eliminar();//borro los pasajeros que tiene el id de ese viaje
              }
            } 
          }//una vez borrado todo
          $v->eliminar();
        }
        echo "Elimino los Viajes de la empresa juntos a los pasajeros de cada viaje";
      }
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
  function existeViaje($idV,$idEmp){
    $via= new Viaje();
    $via->setIdViaje($idV);
    $arregloVia=$via->listar();
    $existencia=false;
    foreach($arregloVia as $v){
      $v->buscar($v->getIdViaje());
      if($v->getObjEmpresa()->getIdEmpresa()==$idEmp && $v->getIdViaje()==$idV){
        $existencia=true;
      }
    }
    return $existencia;
  }
  function devolverViaje($id){
    $via= new Viaje();
    $via->setIdViaje($id);
    $arregloVia=$via->listar();
    foreach($arregloVia as $v){
      if($v->getIdViaje()==$id){
        $via=$v;
      }
    }
    return $via;
  }
  function ingresarViaje($idE){
    echo "Ingrese el Numero del responsable ";
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
  function modificarViaje($numEmpresa){
    $via= new Viaje();
    echo "Ingrese el ID del viaje que desea modificar\n";
    $idMod = trim(fgets(STDIN));
    $via->setIdViaje($idMod);
    $existeVia=existeViaje($idMod,$numEmpresa);
    if($existeVia){
      echo "Ingrese el destino\n";
      $destinoV=trim(fgets(STDIN));
      echo "Ingrese la cantidad de pasajeros maxima\n";
      $cantPasV=trim(fgets(STDIN));
      echo "Ingrese el importe del viaje\n";
      $importeV=trim(fgets(STDIN));
      do{
        echo "Ingrese el numero del representante";
        $numeroRepreV=trim(fgets(STDIN));
        $esta=true;
        if(existeResponsable($numeroRepreV)){
          $esta=false;
          $responsableV=devolverResponsable($numeroRepreV);
        }else{
          echo "No existe el representante, ingrese un numero correcto";
        }
      }while($esta);
      $empresaV=devolverEmpresa($numEmpresa);
      $via->setDestino($destinoV);
      $via->setCantMaxPasajeros($cantPasV);
      $via->setObjEmpresa($empresaV);
      $via->setObjResponsable($responsableV);
      $via->setImporte($importeV);
      $via->modificar();
      echo "Viaje Modificado correctamente\n";
    }else{
      echo "ID ingresado no existente\n";
    }
  }
  function listarViajes($idE){
    $via=new Viaje();
    $arregloVia=$via->listar();
    $cantVia=1;
    foreach ($arregloVia as $v){
      $v->buscar($v->getIdViaje());
      if($v->getObjEmpresa()->getIdEmpresa()==$idE){
        echo "Viaje ".$cantVia."\n";
        echo $v."\n";
        $cantVia++;
      }
    }
  }
  function eliminarViaje($numEmp){
    $via=new Viaje();
    echo "Ingrese el numero de viaje que desea eliminar";
    $idViaje=trim(fgets(STDIN));
    if(existeViaje($idViaje,$numEmp)){
      $viajeEliminar=devolverViaje($idViaje);
      //tengo que eliminar todos los pasajeros de ese viaje
      $pas=new Pasajero();
      $arregloPasajero=$pas->listar();
      if($arregloPasajero!=[]){
        foreach ($arregloPasajero as $p){//recorro todos los pasajeros
          $p->buscar($p->getDni());
          if($p->getObjetoViaje()->getIdViaje()==$idViaje){
            $p->eliminar();//borro los pasajeros que tiene el id de ese viaje
          }
        }
      }
      //una vez eliminado todos los pasajeros elimino el viaje tranquilamente
      $viajeEliminar->eliminar();
      echo "Viaje eliminado correctamente\n";
    }else{
      echo "\nViaje no existente\n";
    }

  }
 
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
  function modificarResponsable(){
    $res= new Responsable();
    echo "Ingrese el Numero del responsable que  desea modificar\n";
    $idMod = trim(fgets(STDIN));
    $res->setNumeroEmpleado($idMod);
    $existeRes=existeResponsable($idMod);
    if($existeRes){
      echo "Ingrese el numero licencia\n";
      $numeroLicR=trim(fgets(STDIN));
      echo "Ingrese el nombre\n";
      $nombreR=trim(fgets(STDIN));
      echo "Ingrese el apellido\n";
      $apellidoR=trim(fgets(STDIN));
      $res->setNumeroLicencia($numeroLicR);
      $res->setNombre($nombreR);
      $res->setApellido($apellidoR);
      $res->modificar();
      echo "Empresa Modificada correctamente\n";
    }else{
      echo "ID ingresado no existente\n";
    }
  }
  function eliminarResponsable(){
    $res=new Responsable();
    echo "Ingrese el NUMERO de responsable que desea eliminar\n";
    $idEli = trim(fgets(STDIN));
    $res->setNumeroEmpleado($idEli); 
    $existeRes=existeResponsable($idEli);
    if($existeRes){
      $res->eliminar();
      echo "Responsable eliminado correctamente\n";
    }else{
      echo "Numero ingresado no existente\n";
    }
  }
  function listarResponsables(){
    $res=new Responsable();
    $arregloRes=$res->listar();
    $cantRes=1;
    foreach ($arregloRes as $r){
      echo "Resposanble ".$cantRes."\n";
      echo $r."\n";
      $cantRes++;
    }
  }

  //FUNCIONES PASAJEROS
  function ingresarPasajero($numEmp){
    $pasa= new Pasajero;
    //verificar que el numero no este ingresado
    $maximaOcupacion=false;
    do{
      echo "Ingresar numero documento ";
      $documento=trim(fgets(STDIN));
      $Esta=existePasajero($documento);
      if($Esta){
        echo"Pasajero ya ingresado, Ingrese otra vez el documento\n";
      }
    }while($Esta);
    echo "Ingresar nombre ";
    $nombreP=trim(fgets(STDIN));
    echo "Ingresar apellido ";
    $apellidoP=trim(fgets(STDIN));
    echo "Ingresar telefono ";
    $telefonoP=trim(fgets(STDIN));
    do{
      echo "Ingresar ID Viaje ";
      $idViaje=trim(fgets(STDIN));
      $esta=true;
      if(existeViaje($idViaje,$numEmp)){
        //en caso de existir verificar que no se exedan la cantidad de pasajeros

        $esta=false;
        $viaje=devolverViaje($idViaje);
        $cantMaxPasajeros=$viaje->getCantMaxPasajeros();
        $idV=$viaje->getIdViaje();
        $condicion="idviaje=".$idV;
        $coleccionPasajeros=$pasa->listar($condicion);
        $pasajesOcupados=count($coleccionPasajeros);
        if($pasajesOcupados>=$cantMaxPasajeros){
          $maximaOcupacion=true;
        }
      }else{
        echo "No existe el viaje, ingrese un numero correcto\n";
      }
    }while($esta);
    if($maximaOcupacion){
      echo "Lo sentimos el pasajero no puede ser ingresado,el viaje esta en su maxima ocupacion\n";
    }else{
      $pasa->setDni($documento);
      $pasa->setNombre($nombreP);
      $pasa->setApellido($apellidoP);
      $pasa->setNumeroTel($telefonoP);
      $pasa->setObjetoViaje($viaje);
      echo "Viaje pasajero correctamente\n";
      $pasa->insertar();
    }
  }
  function modificarPasajero($numEmp){
    $pas= new Pasajero();
    echo "Ingrese el Numero de documento que  desea modificar\n";
    $doc = trim(fgets(STDIN));
    $pas->setDni($doc);
    $existePas=existePasajero($doc);
    if($existePas){
      echo "Ingresar numero documento ";
      $documento=trim(fgets(STDIN));
      echo "Ingresar nombre ";
      $nombreP=trim(fgets(STDIN));
      echo "Ingresar apellido ";
      $apellidoP=trim(fgets(STDIN));
      echo "Ingresar telefono ";
      $telefonoP=trim(fgets(STDIN));
      do{
        echo "Ingresar ID Viaje ";
        $idViaje=trim(fgets(STDIN));
        $esta=true;
        if(existeViaje($idViaje,$numEmp)){
          $esta=false;
          $viaje=devolverViaje($idViaje);
        }else{
          echo "No existe el viaje, ingrese un numero correcto";
        }
      }while($esta);
      $pas->setDni($documento);
      $pas->setNombre($nombreP);
      $pas->setApellido($apellidoP);
      $pas->setNumeroTel($telefonoP);
      $pas->setObjetoViaje($viaje);
      $pas->modificar();
      echo "Empresa Modificada correctamente\n";
    }else{
      echo "ID ingresado no existente\n";
    }
  }
  function eliminarPasajero(){
    $pas=new Pasajero();
    echo "Ingrese el NUMERO de DOCUMENTO que desea eliminar\n";
    $doc = trim(fgets(STDIN));
    $pas->setDni($doc); 
    $existePas=existePasajero($doc);
    if($existePas){
      $pas->eliminar();
      echo "Responsable eliminado correctamente\n";
    }else{
      echo "Numero ingresado no existente\n";
    }
  }
  function listarPasajeros($numEmp){
    $pas=new Pasajero();
    $arregloPas=$pas->listar();
    $cantPas=1;
    foreach ($arregloPas as $p){
      $p->buscar($p->getDni());
      $viaje=new Viaje();
      $viaje->buscar($p->getObjetoViaje()->getIdViaje());
      if($viaje->getObjEmpresa()->getIdEmpresa()==$numEmp){//solo lista los pasajeros de esa empresa
      echo "Pasajero ".$cantPas."\n";
      echo $p."\n";
      $cantPas++;
      }
    }
  }
  function existePasajero($doc){
    $pas= new Pasajero();
    $pas->setDni($doc);
    $arregloPas=$pas->listar();
    $existencia=false;
    foreach($arregloPas as $p){
      if($p->getDni()==$doc){
        $existencia=true;
      }
    }
    return $existencia;
  }
  function devolverPasajero($doc){
    $pas= new Pasajero();
    $pas->setDni($doc);
    $arregloPas=$pas->listar();
    foreach($arregloPas as $p){
      if($p->getDni()==$doc){
        $pas=$p;
      }
    }
    return $pas;
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
                        modificarViaje($numEmp);
                        break;
                      case 3:
                        eliminarViaje($numEmp);
                        break;
                      case 4:
                        listarViajes($numEmp);
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
                      modificarPasajero($numEmp);
                      break;
                    case 3:
                      eliminarPasajero();
                      break;
                    case 4:
                      listarPasajeros($numEmp);
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