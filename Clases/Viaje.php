<?php
    class Viaje{
        private $idViaje;
        private $destino;
        private $cantMaxViajes;
        private $objResponsable;//objeto
        private $importe;
        private $objEmpresa ;//objeto
        private $mensajeoperacion;
        
        public function __construct(){
            $this->idViaje = "";
            $this->destino = "";
            $this->cantMaxViajes = "";
            $this->objResponsable= new Responsable();
            $this->importe= "";
            $this->objEmpresa= new Empresa();
        }
        public function cargar($idV,$dest,$cantPas,$objResp,$objEmp,$imp){
            $this->setIdViaje($idV);
            $this->setDestino($dest);
            $this->setCantMaxPasajeros($cantPas);
            $this->setObjResponsable($objResp);
            $this->setObjEmpresa($objEmp);
            $this->setImporte($imp);
        }
        //mensaje de operacion para guardar los mensajes de error
        public function getmensajeoperacion(){
            return $this->mensajeoperacion ;
        }
        public function setmensajeoperacion($mensajeoperacion){
            $this->mensajeoperacion=$mensajeoperacion;
        }
        //metodos de acceso a los atributos
        public function getImporte(){
            return $this->importe;    
        }
        public function setImporte($imp){
            $this->importe=$imp;    
        }
        public function getIdViaje(){
            return $this->idViaje;    
        }
        public function getDestino(){
            return $this->destino;    
        }
        public function getCantMaxPasajeros(){
            return $this->cantMaxViajes;    
        }
        public function setIdViaje($codVia){
            $this->idViaje = $codVia;
        }
        public function setDestino($dest){
            $this->destino = $dest;
        }
        public function setCantMaxPasajeros($cantM){
            $this->cantMaxViajes = $cantM;
        }
        public function setObjResponsable($valor){
            $this->objResponsable = $valor;
        }
        public function getObjResponsable(){
            return $this->objResponsable;
        }
        public function setObjEmpresa($valor){
            $this->objEmpresa = $valor;
        }
        public function getObjEmpresa(){
            return $this->objEmpresa;
        }
        public function __toString(){
            $mensaje="  Codigo Viaje: ".$this->getIdViaje()."\n".
            "  Destino Viaje: ".$this->getDestino()."\n".
            "  Cantidad de maxima de pasajeros: ".$this->getCantMaxPasajeros()."\n".
            "  Importe: ".$this->getImporte()."\n".
            "  Id Empresa: ".$this->getObjEmpresa()->getIdEmpresa()."\n".//ver si escribo la empresa o solo el id!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            "  Numero Responsable: ".$this->getObjResponsable()->getNumeroEmpleado()."\n";//ver si escribo el responsable o solo el id!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            return $mensaje;
        }
        //funcion para insertar una Viaje a la base
        public function insertar(){
            $base=new BaseDatos();
            $resp= false;
            $consultaInsertar="INSERT INTO viaje( vdestino, vcantmaxpasajeros,idempresa,rnumeroempleado,vimporte) 
                    VALUES ('".$this->getDestino()."','".$this->getCantMaxPasajeros()."','".
                    $this->getObjEmpresa()->getIdempresa()."','".$this->getObjResponsable()->getNumeroEmpleado()."','".$this->getImporte()."')";
            if($base->Iniciar()){
                if($id = $base -> devuelveIDInsercion ($consultaInsertar)){
                    $this->setIdViaje($id);
                    $resp =  true;
                }else{
                    $this->setmensajeoperacion($base->getError());
                }
            }else{
                $this->setmensajeoperacion($base->getError());  
            }
            return $resp;
        }
        //funcion para eliminar una empresa de la base de datos
        public function eliminar(){
            $base=new BaseDatos();
            $resp=false;
            if($base->Iniciar()){
                $consultaBorra="DELETE FROM viaje WHERE idviaje=".$this->getIdViaje();
                if($base->Ejecutar($consultaBorra)){
                    $resp=  true;
                }else{
                    $this->setmensajeoperacion($base->getError());
                }
            }else{
                $this->setmensajeoperacion($base->getError());
            }
            return $resp; 
        }
         //funcion para modificar las Viaje
         public function modificar(){
            $resp =false; 
            $base=new BaseDatos();
            $consultaModifica="UPDATE viaje SET idviaje='".$this->getIdViaje()."',vdestino='".$this->getDestino().
            "',vcantmaxpasajeros='".$this->getCantMaxPasajeros()."',idempresa='".$this->getObjEmpresa()->getIdEmpresa().
            "',rnumeroempleado='".$this->getObjResponsable()->getNumeroEmpleado(). "',vimporte='".$this->getImporte().
            "' WHERE idviaje=". $this->getIdViaje();
            if($base->Iniciar()){
                if($base->Ejecutar($consultaModifica)){
                    $resp=  true;
                }else{
                    $this->setmensajeoperacion($base->getError());
                }
            }else{
                $this->setmensajeoperacion($base->getError());
            }
            return $resp;
        }
        //funcion para listar todos los elementos de la tabla Viaje
        public /*static*/ function listar($condicion=""){
            $arregloViaje = null;
            $base=new BaseDatos();
            $consultaViaje="Select * from viaje ";
            if ($condicion!=""){
                $consultaViaje=$consultaViaje.' where '.$condicion;
            }
            $consultaViaje.=" order by idviaje";
            //echo $consultaPersonas;
            if($base->Iniciar()){
                if($base->Ejecutar($consultaViaje)){				
                    $arregloViaje= array();
                    while($row2=$base->Registro()){
                        $IdVi=$row2['idviaje'];
                        $DesVi=$row2['vdestino'];
                        $CantPasVi=$row2['vcantmaxpasajeros'];
                        $ImpVi=$row2['vimporte'];
                        $ObjResponsable=new Responsable();
                        $ObjResponsable->buscar($row2['rnumeroempleado']);//busca el responsable y lo guarda 
                        $ObjEmpresa=new Empresa();
                        $ObjEmpresa->buscar($row2['idempresa']);//busca la empresa y la guarda

                        $via=new Viaje();
                        $via->cargar($IdVi,$DesVi,$CantPasVi,$ObjResponsable,$ObjEmpresa,$ImpVi);
                        array_push($arregloViaje,$via);
                    }
                }else{
                    $this->setmensajeoperacion($base->getError());
                }
            }else {
                $this->setmensajeoperacion($base->getError());
            }	
            return $arregloViaje;
        }
        //devuelve el viaje, seteandolo en el objeto desde donde es llamado
        public function buscar ($idViaje){
            $base = new BaseDatos();
            $consultaEmpresa = "Select * from viaje where idviaje=".$idViaje;
            $resp = false;
            if ($base -> Iniciar()){
                if ($base -> Ejecutar ($consultaEmpresa)){
                    if ($row2 = $base -> Registro()){					
                        $DesVi=$row2['vdestino'];
                        $CantPasVi=$row2['vcantmaxpasajeros'];
                        $ImpVi=$row2['vimporte'];
                        $ObjetoEmpresa= new Empresa();
                        $ObjetoEmpresa->buscar ($row2['idempresa']);
                        $ObjResponsable = new Responsable();
					    $ObjResponsable -> buscar ($row2['rnumeroempleado']);
                        $this->cargar($idViaje,$DesVi,$CantPasVi,$ObjResponsable,$ObjetoEmpresa,$ImpVi);

                        $resp = true;
                    }				
                }else{
                    $this -> setMensajeOperacion ($base->getError());
                }
            }else{
                $this -> setMensajeOperacion ($base->getError());	
            }		
            return $resp;
            }
    }

?>