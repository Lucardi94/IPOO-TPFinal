<?php
    include_once "BaseDatos.php";
    include_once "Funcion.php";

    class FuncionMusical extends Funcion{
        private $director;
        private $cantidadPersonas;
        private $mensajeOperacion;

        public function __construct(){
            parent::__construct();
            $this->director="";
            $this->cantidadPersonas="";
        }

        public function cargar($funcion){
            parent::cargar($funcion);
            $this->setDirector($funcion['director']);
            $this->setCantidadPersonas($funcion['cantidadpersonas']);
        }

        public function getDirector(){
            return $this->director;
        }
        public function getCantidadPersonas(){
            return $this->cantidadPersonas;
        }
        public function getMensajeOperacion(){
            return $this->mensajeOperacion;
        }

        public function setDirector($nDir){
            $this->director=$nDir;
        }
        public function setCantidadPersonas($nCanPer){
            $this->cantidadPersonas=$nCanPer;
        }
        public function setMensajeOperacion($nMsj){
            $this->mensajeOperacion=$nMsj;
        }

        public function Buscar($id){
            $base=new BaseDatos();
            $consulta="SELECT * FROM funcionmusical WHERE idfuncion=".$id;
            $resp=false;
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    if($row2=$base->Registro()){
                        $funcion=$row2;
                        parent::Buscar($funcion['idfuncion']);
                        $this->setDirector($funcion['director']);
                        $this->setCantidadPersonas($funcion['cantidadpersonas']);
                        $resp=true;
                    }                
                } else { $this->setMensajeOperacion($base->getError()); }
            } else { $this->setMensajeOperacion($base->getError()); }		
            return $resp;
        }

        public function listar($condicion=""){
            $colFuncion=NULL;
            $base=new BaseDatos();
            $consulta="Select * from funcionmusical ";
            if ($condicion!=""){
                $consulta.=" where ".$condicion;
            }
            $consulta.=" order by idfuncion ";
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    $colFuncion=array ();	
                    while($row2=$base->Registro()){                                                
                        $objFuncion=new FuncionMusical();
                        $objFuncion->Buscar($row2['idfuncion']);
                        array_push($colFuncion,$objFuncion);
                    }                
                } else { $this->setMensajeOperacion($base->getError()); }
            } else { $this->setMensajeOperacion($base->getError()); }	
            return $colFuncion;
        }

        public function insertar(){
            $base=new BaseDatos();
            $resp=false;            
            if(parent::insertar()){
                $consulta="INSERT INTO funcionmusical(idfuncion,director,cantidadpersonas) VALUES (".parent::getIdFuncion().",'".$this->getDirector()."',".$this->getCantidadPersonas().")";
                if($base->Iniciar()){
                    if($base->Ejecutar($consulta)){
                        $resp=true;
                    } else { $this->setMensajeOperacion($base->getError()); }
                } else { $this->setMensajeOperacion($base->getError()); }
             }
            return $resp;
        }

        public function modificar(){
            $resp=false; 
            $base=new BaseDatos();
            if(parent::modificar()){
                $consulta="UPDATE funcionmusical SET director='".$this->getDirector()."', cantidadpersonas='".$this->getCantidadPersonas()."' WHERE idfuncion=". parent::getIdFuncion();
                if($base->Iniciar()){
                    if($base->Ejecutar($consulta)){
                        $resp=true;
                    } else { $this->setMensajeOperacion($base->getError()); }
                } else { $this->setMensajeOperacion($base->getError()); }
            }            
            return $resp;
        }

        public function eliminar(){
            $base=new BaseDatos();
            $resp=false;
            if($base->Iniciar()){
                $consulta="DELETE FROM funcionmusical WHERE idfuncion=".parent::getIdFuncion();
                if($base->Ejecutar($consulta)){
                    if(parent::eliminar()){
                        $resp=true;
                    }
                } else { $this->setMensajeOperacion($base->getError()); }
            } else { $this->setMensajeOperacion($base->getError()); }
            return $resp; 
        }

        //FUNCIONES

        public function darCosto(){
            return $this->getPrecio()*1.12;
        }

        public function __toString(){
            $text=parent::__toString();
            $text.="\nDirector: ".$this->getDirector().
            "\nCantidad de Personas en escenas: ".$this->getCantidadPersonas();
            return $text;
        }
    }