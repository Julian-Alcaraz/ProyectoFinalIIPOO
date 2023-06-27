<?php
    class Pasajero{
        private $dni;
        private $nombre;
        private $apellido;
        private $numeroTel;
        private $objetoViaje; //objeto
        private $mensajeoperacion;
       
        public function setNombre($valor){
            $this->nombre=$valor;
        }
        public function getNombre(){
            return $this->nombre;
        }
        public function setApellido($valor){
            $this->apellido=$valor;
        }
        public function getApellido(){
            return $this->apellido;
        } 
        public function setDni($valor){
            $this->dni=$valor;
        }
        public function getDni(){
            return $this->dni;
        }
        public function setNumeroTel($valor){
            $this->numeroTel=$valor;
        }
        public function getNumeroTel(){
            return $this->numeroTel;
        }
        public function setObjetoViaje($valor){
            $this->objetoViaje=$valor;
        }
        public function getObjetoViaje(){
            return $this->objetoViaje;
        }
        //mensaje de operacion para guardar los mensajes de error
        public function getmensajeoperacion(){
            return $this->mensajeoperacion ;
        }
        public function setmensajeoperacion($mensajeoperacion){
            $this->mensajeoperacion=$mensajeoperacion;
        }
        
        public function __construct(){
            $this->nombre= "";
            $this->apellido="";
            $this->dni= "";
            $this->numeroTel= "";
            $this->objetoViaje = new Viaje();
        }
        //funcion para guardar los valores de un objeto
        public function Cargar($dni,$nom,$ape,$tel,$objV){
            $this->setNombre($nom);
            $this->setApellido($ape);
            $this->setDni($dni);
            $this->setNumeroTel($tel);
            $this->setObjetoViaje($objV);
        } 
        public function __toString(){
            return "     Nombre: ".$this->getNombre().
            "\n     Apellido: ".$this->getApellido().
            "\n     Dni: ".$this->getDni().
            "\n     Numero Telefono: ".$this->getNumeroTel().
            "\n     ID Viaje: ".$this->getObjetoViaje()->getIdViaje();//ver si escribo el viaje o solo el id!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        }
        //funcion para insertar una pasajero a la base
        public function insertar(){
            $base=new BaseDatos();
            $resp= false;
            $consultaInsertar="INSERT INTO pasajero(pdocumento, pnombre, papellido,ptelefono,idviaje) 
                    VALUES (".$this->getDni().",'".$this->getNombre()."','".$this->getApellido()."','".$this->getNumeroTel()."','".$this->getObjetoViaje()->getIdViaje()."')";
            
            if($base->Iniciar()){
                if($base->Ejecutar($consultaInsertar)){
                    $resp=  true;
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
                $consultaBorra="DELETE FROM pasajero WHERE pdocumento=".$this->getDni();
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
         //funcion para modificar las pasajero
         public function modificar(){
            $resp =false; 
            $base=new BaseDatos();
            $consultaModifica="UPDATE pasajero SET pdocumento='".$this->getDni()."',pnombre='".$this->getNombre().
            "',papellido='".$this->getApellido()."',ptelefono='".$this->getNumeroTel()."',idviaje='".$this->getObjetoViaje()->getIdViaje().
            "' WHERE pdocumento=". $this->getDni();
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
        //funcion para listar todos los elementos de la tabla pasajero
        public /*static*/ function listar($condicion=""){
            $arregloPasajero = null;
            $base=new BaseDatos();
            $consultaPasajero="Select * from pasajero ";
            if ($condicion!=""){
                $consultaPasajero=$consultaPasajero.' where '.$condicion;
            }
            $consultaPasajero.=" order by pdocumento ";
            //echo $consultaPersonas;
            if($base->Iniciar()){
                if($base->Ejecutar($consultaPasajero)){				
                    $arregloPasajero= array();
                    while($row2=$base->Registro()){
                        $DocPa=$row2['pdocumento'];
                        $NomPa=$row2['pnombre'];
                        $ApePa=$row2['papellido'];
                        $TelPa=$row2['ptelefono'];
                        $objViaje  = new Viaje();
					    $objViaje -> buscar($row2['idviaje']);
                        
                        $pasa=new Pasajero();
                        $pasa->cargar($DocPa,$NomPa,$ApePa,$TelPa,$objViaje);
                        array_push($arregloPasajero,$pasa);
                    }
                }else{
                    $this->setmensajeoperacion($base->getError());
                }
            }else {
                $this->setmensajeoperacion($base->getError());
            }	
            return $arregloPasajero;
        }
        public function buscar ($dni){
            $base=new BaseDatos();
            $consultaPasajero ="Select * from pasajero where pdocumento=".$dni;
            $resp= false;
            if($base->Iniciar()){
                if($base->Ejecutar($consultaPasajero)){
                    if($row2=$base->Registro()){					
                        $this -> setDni ($dni);
                        $this -> setNombre ($row2['pnombre']);
                        $this -> setApellido ($row2['papellido']);
                        $this -> setNumeroTel ($row2['ptelefono']);
                        
                        $objViaje = new Viaje();
                        $objViaje -> buscar ($row2['idviaje']);
                        $this -> setObjetoViaje($objViaje);
                        $resp = true;
                    }				
                }else{
                    $this->setMensajeOperacion($base->getError());
                }
            }else{
                $this->setMensajeOperacion($base->getError());
            }		
            return $resp;
        }
    }
?>