<?php
    include_once "BaseDatos.php";
    include_once "Funcion.php";
    class FuncionTeatro extends Funcion{
        private $mensajeOperacion;

        public function __construct(){
            parent::__construct();
        }

        public function cargar($funcion){
            parent::cargar($funcion);
        }

        public function getMensajeOperacion(){
            return $this->mensajeOperacion;
        }
        public function setMensajeOperacion($nMsj){
            $this->mensajeOperacion = $nMsj;
        }        

        public function Buscar($id){
            $base=new BaseDatos();
            $consulta="SELECT * FROM funcionteatro WHERE idfuncion=".$id;
            $resp=false;
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    if($row2=$base->Registro()){
                        parent::Buscar($row2['idfuncion']);
                        $resp=true;
                    }                
                } else { $this->setMensajeOperacion($base->getError()); }
            } else { $this->setMensajeOperacion($base->getError()); }		
            return $resp;
        }

        public function listar($condicion=""){
            $colFuncion=NULL;
            $base=new BaseDatos();
            $consulta="Select * from funcionteatro ";
            if ($condicion!=""){
                $consulta.=" WHERE ".$condicion;
            } 
            $consulta.=" order by idfuncion ";
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){	
                    $colFuncion=array ();
                    while($row2=$base->Registro()){                                                
                        $objFuncion=new FuncionTeatro();
                        $objFuncion->Buscar($row2['idfuncion']);;
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
                $consulta="INSERT INTO funcionteatro(idfuncion) VALUES (".parent::getIdFuncion().")";
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
                //$consulta="UPDATE funcionteatro SET idfuncion=".parent::getIdFuncion()." WHERE idfuncion=". parent::getIdFuncion();
                //if($base->Iniciar()){
                    //if($base->Ejecutar($consulta)){
                        $resp=true;
                    //}else{ $this->setMensajeOperacion($base->getError()); }
                //}else{ $this->setMensajeOperacion($base->getError()); }
            }            
            return $resp;
        }

        public function eliminar(){
            $base=new BaseDatos();
            $resp=false;
            if($base->Iniciar()){
                $consulta="DELETE FROM funcionteatro WHERE idfuncion=".parent::getIdFuncion();
                if($base->Ejecutar($consulta)){
                    if(parent::eliminar()){
                        $resp=true;
                    }
                } else { $this->setMensajeOperacion($base->getError()); }
            } else { $this->setMensajeOperacion($base->getError()); }
            return $resp; 
        }
    }