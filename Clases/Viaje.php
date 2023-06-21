
<?php
    class Viaje{
        private $idViaje;
        private $destino;
        private $cantMaxPasajeros;
        private $pasajeros=[];//nose si va segun enunciado si, segun bd no
        private $responsable;
        private $importe;
        private $idEmpresa //objeto


        public function __construct($codVia,$dest,$cantM,$arregloPasajeros,$resp,$imp){
            $this->idViaje = $codVia;
            $this->destino = $dest;
            $this->cantMaxPasajeros = $cantM;
            $this->pasajeros = $arregloPasajeros;
            $this->responsable=$resp;
            $this->importe=$imp;
        }
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
            return $this->cantMaxPasajeros;    
        }
        public function getPasajeros(){
            return $this->pasajeros;
        }
        public function setIdViaje($codVia){
            $this->idViaje = $codVia;
        }
        public function setDestino($dest){
            $this->destino = $dest;
        }
        public function setCantMaxPasajeros($cantM){
            $this->cantMaxPasajeros = $cantM;
        }
        public function setPasajeros($arregloPasajeros){
            $this->pasajeros = $arregloPasajeros;
        }
        public function setResponsable($valor){
            $this->responsable = $valor;
        }
        public function getResponsable(){
            return $this->responsable;
        }
        public function __toString(){
            $mensaje="  Codigo Viaje: ".$this->getIdViaje()."\n".
            "  Destino Viaje: ".$this->getDestino()."\n".
            "  Cantidad de pasajeros: ".$this->getCantMaxPasajeros()."\n".
            "  Importe: ".$this->getImporte()."\n".
            "  Pasajeros: \n";
            for($h=0;$h<($this->getCantMaxPasajeros());$h++){
                $mensaje=$mensaje."\nPasajero ".($h+1)."\n".($this->getPasajeros()[$h]);
            }
            $mensaje=$mensaje."\nResponsable del Viaje \n".$this->getResponsable()."\n";
            return $mensaje;
        }
    }

?>