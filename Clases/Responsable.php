<?php 
    class Responsable{
        private $numeroEmpleado;
        private $numeroLicencia;
        private $nombre;
        private $apellido;

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

        public function __construct($emp,$lic,$nomb,$ape){
            $this->numeroEmpleado=$emp;
            $this->numeroLicencia=$lic;
            $this->nombre=$nomb;
            $this->apellido=$ape;
        }
        public function __toString(){
            return "     Numero Empleado: ".$this->getNumeroEmpleado().
            "\n     Numero Licencia: ".$this->getNumeroLicencia().
            "\n     Nombre: ".$this->getNombre().
            "\n     Apellido: ".$this->getApellido()."\n";
        }
        
    }
?>