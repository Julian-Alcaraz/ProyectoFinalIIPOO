<?php
    class Pasajero{
        private $dni;
        private $nombre;
        private $apellido;
        private $numeroTel;
        private $objetoViaje; //objeto
       
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
        
        public function __construct($name,$apell,$doc,$tel,$viaje){
            $this->nombre=$name;
            $this->apellido=$apell;
            $this->dni=$doc;
            $this->numeroTel=$tel;
            $this->objetoViaje=$viaje;
        }
        public function __toString(){
            return "     Nombre: ".$this->getNombre().
            "\n     Apellido: ".$this->getApellido().
            "\n     Dni: ".$this->getDni().
            "\n     Numero Telefono: ".$this->getNumeroTel().
            "\n     ID Viaje: ".$this->getObjetoViaje();
        }
    }
?>