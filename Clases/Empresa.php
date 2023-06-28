<?php 
    class Empresa{
        //atributo de empresa
        private $idEmpresa;
        private $nombre;
        private $direccion;
        private $mensajeoperacion;
        //metodos de acceso a los atribuos de empresa
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
        //funcion para guardar los valores de un objeto, setea todos los valores como si fuera construct
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
            if($base->Iniciar()){//inicia la conexion con la bd
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
            if($base->Iniciar()){//inicia la conexion
                $consultaBorra="DELETE FROM empresa WHERE idempresa=".$this->getIdEmpresa(); //creamos la consulta sql
                if($base->Ejecutar($consultaBorra)){//ejecutamos la consulta, realiza accion dependiendo si se ejeucta o no
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
            $consultaModifica="UPDATE empresa SET enombre='".$this->getNombre()."',edireccion='".$this->getDireccion().
                    "' WHERE idempresa=". $this->getIdEmpresa();//creamos consulta de update
            if($base->Iniciar()){//inicia la conexion con la bd
                if($base->Ejecutar($consultaModifica)){//ejecuta la consulta
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
            $consultaEmpresa.=" order by idempresa ";//termina de crear la consulta
            //echo $consultaPersonas;
            if($base->Iniciar()){//inicia la bd
                if($base->Ejecutar($consultaEmpresa)){//ejecuta la consulta creada				
                    $arregloEmpresa= array();//define el arreglo como array
                    while($row2=$base->Registro()){//trae el registro de la base de dato en la fila , hasta que no hayan mas
                        $IdEmp=$row2['idempresa'];
                        $NomEmp=$row2['enombre'];
                        $DirEmp=$row2['edireccion'];
                        $empre=new Empresa();//crea un objeto empresa
                        $empre->cargar($IdEmp,$NomEmp,$DirEmp);//setea los valores de la empresa
                        array_push($arregloEmpresa,$empre);//carga la empresa en el arreglo
                    }
                }else{
                    $this->setmensajeoperacion($base->getError());
                }
             }	else {
                     $this->setmensajeoperacion($base->getError());
                 
             }	
             return $arregloEmpresa;
        }
        //busca la empresa con ese id, y la setea en la empresa desde la que llaman el metodo
        public function buscar ($idEmpresa){
		    $base = new BaseDatos();
		    $consultaEmpresa = "Select * from empresa where idempresa=".$idEmpresa;//crea consulta
		    $resp = false;
		    if ($base -> Iniciar()){//inica la bd
		        if ($base->Ejecutar($consultaEmpresa)){//ejecuta la consulta
		        	if ($row2 = $base -> Registro()){	
		        		$NomEmp=$row2['enombre'];
		        		$DirEmp=$row2['edireccion'];
                        $this->cargar($idEmpresa,$NomEmp,$DirEmp);//setea los valores de la empresa

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