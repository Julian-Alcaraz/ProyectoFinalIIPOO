<?php 
    class Responsable{
        private $numeroEmpleado;
        private $numeroLicencia;
        private $nombre;
        private $apellido;
        private $mensajeoperacion;
        
        //mensaje de operacion para guardar los mensajes de error
        public function getmensajeoperacion(){
            return $this->mensajeoperacion ;
        }
        public function setmensajeoperacion($mensajeoperacion){
            $this->mensajeoperacion=$mensajeoperacion;
        }
        //metodos propios
        public function setNumeroEmpleado($valor){
            $this->numeroEmpleado=$valor;
        }
        public function getNumeroEmpleado(){
            return $this->numeroEmpleado;
        }
        public function setNumeroLicencia($valor){
            $this->numeroLicencia=$valor;
        }
        public function getNumeroLicencia(){
            return $this->numeroLicencia;
        }
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

        public function __construct(){
            $this->numeroEmpleado= "";
            $this->numeroLicencia= "";
            $this->nombre= "";
            $this->apellido= "";
        }
        //funcion para guardar los valores de un objeto
        public function cargar($emp,$lic,$nomb,$ape){
            $this->setNumeroEmpleado($emp);
            $this->setNumeroLicencia($lic);
            $this->setNombre($nomb);
            $this->setApellido($ape);
        }
        public function __toString(){
            return "     Numero Empleado: ".$this->getNumeroEmpleado().
            "\n     Numero Licencia: ".$this->getNumeroLicencia().
            "\n     Nombre: ".$this->getNombre().
            "\n     Apellido: ".$this->getApellido()."\n";
        }
        //funcion para insertar una Responsable a la base
        public function insertar(){
            $base=new BaseDatos();
            $resp= false;
            $consultaInsertar="INSERT INTO responsable(numeroempleado,numerolicencia, rnombre,rapellido) 
                    VALUES (".$this->getNumeroEmpleado().",'".$this->getNumeroLicencia()."','".$this->getNombre()."','".$this->getApellido()."')";
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
        //funcion para eliminar una responsable de la base de datos
        public function eliminar(){
            $base=new BaseDatos();
            $resp=false;
            if($base->Iniciar()){
                $consultaBorra="DELETE FROM responsable WHERE numeroempleado=".$this->getNumeroEmpleado();
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
         //funcion para modificar las responsable
         public function modificar(){
            $resp =false; 
            $base=new BaseDatos();
            $consultaModifica="UPDATE responsable SET numeroempleado='".$this->getNumeroEmpleado()."',numerolicencia='".$this->getNumeroLicencia().
            "',rnombre='".$this->getNombre()."',rapellido='".$this->getApellido().
            "' WHERE numeroempleado=". $this->getNumeroEmpleado();
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
        //funcion para listar todos los elementos de la tabla Responsable
        public /*static*/ function listar($condicion=""){
            $arregloResponsable = null;
            $base=new BaseDatos();
            $consultaResponsable="Select * from responsable ";
            if ($condicion!=""){
                $consultaResponsable=$consultaResponsable.' where '.$condicion;
            }
            $consultaResponsable.=" order by rnombre ";
            //echo $consultaResponsable;
            if($base->Iniciar()){
                if($base->Ejecutar($consultaResponsable)){				
                    $arregloResponsable= array();
                    while($row2=$base->Registro()){
                        $NumRes=$row2['numeroempleado'];
                        $LicRes=$row2['numerolicencia'];
                        $NomRes=$row2['rnombre'];
                        $ApelRes=$row2['rapellido'];
                        $resp=new Responsable();
                        $resp->cargar($NumRes,$LicRes,$NomRes,$ApelRes);
                        array_push($arregloResponsable,$resp);
                    }
                }else{
                    $this->setmensajeoperacion($base->getError());
                }
            }else {
                $this->setmensajeoperacion($base->getError());
            }	
            return $arregloResponsable;
        }
    }
    
?>