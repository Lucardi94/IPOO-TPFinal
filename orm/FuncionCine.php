<?php
    include_once "BaseDatos.php";
    include_once "Funcion.php";
    class FuncionCine extends Funcion{
        private $genero;
        private $paisOrigen;
        private $mensajeOperacion;

        public function __construct(){
            parent::__construct();
            $this->genero="";
            $this->paisOrigen="";
        }

        public function cargar($funcion){
            parent::cargar($funcion);
            $this->setGenero($funcion['genero']);
            $this->setPaisOrigen($funcion['paisorigen']);
        }
        
        public function getGenero(){
            return $this->genero;
        }
        public function getPaisOrigen(){
            return $this->paisOrigen;
        }
        public function getMensajeOperacion(){
            return $this->mensajeOperacion;
        }
 
        public function setGenero($nGen){
            $this->genero=$nGen;
        }
        public function setPaisOrigen($nPaiOri){
            $this->paisOrigen=$nPaiOri;
        }
        public function setMensajeOperacion($nMsj){
            $this->mensajeOperacion=$nMsj;
        }

        public function Buscar($id){
            $base=new BaseDatos();
            $consulta="SELECT * FROM funcioncine WHERE idfuncion=".$id;
            $resp=false;
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    if($row2=$base->Registro()){
                        $funcion=$row2;
                        parent::Buscar($row2['idfuncion']);
                        $this->setGenero($funcion['genero']);
                        $this->setPaisOrigen($funcion['paisorigen']);
                        $resp=true;
                    }                
                } else { $this->setMensajeOperacion($base->getError()); }
            } else { $this->setMensajeOperacion($base->getError()); }		
            return $resp;
        }

        public function listar($condicion=""){
            $colFuncion=NULL;
            $base=new BaseDatos();
            $consulta="Select * from funcioncine ";
            if ($condicion!=""){
                $consulta.=" where ".$condicion;
            }
            $consulta.=" order by idfuncion ";
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    $colFuncion=array ();	
                    while($row2=$base->Registro()){                                                
                        $objFuncion=new FuncionCine();
                        $objFuncion->Buscar($row2['idfuncion']);
                        array_push($colFuncion,$objFuncion);
                    }                
                } else { $this->setMensajeOperacion($base->getError()); }
            } else { $this->setMensajeOperacion($base->getError()); }	
            return $colFuncion;
        }

        public function insertar(){
            $base=new BaseDatos();
            $resp= false;            
            if(parent::insertar()){
                $consulta="INSERT INTO funcioncine(idfuncion,genero,paisorigen) VALUES (".parent::getIdFuncion().",'".$this->getGenero()."','".$this->getPaisOrigen()."')";
                if($base->Iniciar()){
                    if($base->Ejecutar($consulta)){
                        $resp=true;
                    } else { $this->setMensajeOperacion($base->getError()); }
                } else { $this->setMensajeOperacion($base->getError()); }
            }
            return $resp;
        }

        public function modificar(){
            $resp =false; 
            $base=new BaseDatos();
            if(parent::modificar()){
                $consulta="UPDATE funcioncine SET genero='".$this->getGenero()."',paisorigen='".$this->getPaisOrigen()."' WHERE idfuncion=". parent::getIdFuncion();
                if($base->Iniciar()){
                    if($base->Ejecutar($consulta)){
                        $resp=true;
                    }else{ $this->setMensajeOperacion($base->getError()); }
                }else{ $this->setMensajeOperacion($base->getError()); }
            }            
            return $resp;
        }

        public function eliminar(){
            $base=new BaseDatos();
            $resp=false;
            if($base->Iniciar()){
                $consulta="DELETE FROM funcioncine WHERE idfuncion=".parent::getIdFuncion();
                if($base->Ejecutar($consulta)){
                    if(parent::eliminar()){
                        $resp=true;
                    }
                } else { $this->setMensajeOperacion($base->getError()); }
            } else { $this->setMensajeOperacion($base->getError()); }
            return $resp; 
        }

        public function __toString(){
            $text=parent::__toString();
            $text.="\nGenero: ".$this->getGenero().
            "\nPais de Origen: ".$this->getPaisOrigen();
            return $text;
        }
    }
