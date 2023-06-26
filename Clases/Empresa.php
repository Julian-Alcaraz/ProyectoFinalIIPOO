<?php 
    class Empresa{
        private $idEmpresa;
        private $nombre;
        private $direccion;
        private $mensajeoperacion;

        public function setIdEmpresa($valor){
            $this->idEmpresa=$valor;
        }
        public function getIdEmpresa(){
            return $this->idEmpresa;
        } 
        public function setNombre($valor){
            $this->nombre=$valor;
        }
        public function getNombre(){
            return $this->nombre;
        } 
        public function setDireccion($valor){
            $this->direccion=$valor;
        }
        public function getDireccion(){
            return $this->direccion;
        } 
        //mensaje de operacion para guardar los mensajes de error
        public function getmensajeoperacion(){
            return $this->mensajeoperacion ;
        }
        public function setmensajeoperacion($mensajeoperacion){
            $this->mensajeoperacion=$mensajeoperacion;
        }
        //constructor en vacio
        public function __construct(){
            $this->idEmpresa= null;
            $this->nombre= null;
            $this->direccion= null;
        }
        //funcion para guardar los valores de un objeto
        public function cargar($id,$nom,$dir){		
            $this->setIdEmpresa($id);
            $this->setNombre($nom);
            $this->setDireccion($dir);
        }

        public function __toString(){
            return "    Id Empresa: ".$this->getIdEmpresa()."\n".
                   "    Nombre: ".$this->getNombre()."\n".
                   "    Direccion: ".$this->getDireccion();
        }
        //funcion para insertar una empresa empresa a la base
        public function insertar(){
            $base=new BaseDatos();
            $resp= false;
            $consultaInsertar="INSERT INTO empresa(enombre, edireccion) 
                    VALUES ('".$this->getNombre()."','".$this->getDireccion()."')";
            if($base->Iniciar()){
                if ($id = $base -> devuelveIDInsercion ($consultaInsertar)){
                $this -> setIdEmpresa($id);
                $resp = true;
                }else{
                $this -> setmensajeoperacion($base->getError());
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
                $consultaBorra="DELETE FROM empresa WHERE idempresa=".$this->getIdEmpresa();
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
        //funcion para modificar las empresas
        public function modificar(){
            $resp =false; 
            $base=new BaseDatos();
            $consultaModifica="UPDATE empresa SET enombre='".$this->getNombre()."',edireccion='".$this->getDireccion()."' WHERE idempresa=". $this->getIdEmpresa();;
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
        //funcion para listar todos los elementos de la tabla empresa
        public /*static*/ function listar($condicion=""){
            $arregloEmpresa = null;
            $base=new BaseDatos();
            $consultaEmpresa="Select * from empresa ";
            if ($condicion!=""){
                $consultaEmpresa=$consultaEmpresa.' where '.$condicion;
            }
            $consultaEmpresa.=" order by idempresa ";
            //echo $consultaPersonas;
            if($base->Iniciar()){
                if($base->Ejecutar($consultaEmpresa)){				
                    $arregloEmpresa= array();
                    while($row2=$base->Registro()){
                        $IdEmp=$row2['idempresa'];
                        $NomEmp=$row2['enombre'];
                        $DirEmp=$row2['edireccion'];
                        $empre=new Empresa();
                        $empre->cargar($IdEmp,$NomEmp,$DirEmp);
                        array_push($arregloEmpresa,$empre);
                    }
                }else{
                    $this->setmensajeoperacion($base->getError());
                }
             }	else {
                     $this->setmensajeoperacion($base->getError());
                 
             }	
             return $arregloEmpresa;
        }
        public function buscar ($idEmpresa){
		$base = new BaseDatos();
		$consultaEmpresa = "Select * from empresa where idempresa=".$idEmpresa;
		$resp = false;
		if ($base -> Iniciar())
            {
		    	if ($base -> Ejecutar ($consultaEmpresa)){
		    		if ($row2 = $base -> Registro())
                    {					
		    		    $this -> setIdEmpresa ($idEmpresa);
		    			$this -> setNombre ($row2['enombre']);
		    			$this -> setDireccion ($row2['edireccion']);
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