<?php
    include_once "BaseDatos.php";
    include_once "Teatro.php";
    class Funcion{
        private $idFuncion; 
        private $nombre;
        private $precio;
        private $horaInicio;
        private $duracion; 
        private $objTeatro;
        private $mensajeOperacion;

        public function __construct(){
            $this->idFuncion=0;
            $this->nombre="";
            $this->precio="";
            $this->horaInicio="";
            $this->duracion="";
            $this->objTeatro=null;
        }

        public function cargar($funcion){
            $this->setIdFuncion($funcion['idfuncion']);
            $this->setNombre($funcion['nombre']);
            $this->setPrecio($funcion['precio']);
            $this->setHoraInicio($funcion['horainicio']);
            $this->setDuracion($funcion['duracion']);
            $this->setObjTeatro($funcion['objteatro']);
        }

        public function getIdFuncion(){
            return $this->idFuncion;
        }
        public function getNombre(){
            return $this->nombre;
        }
        public function getPrecio(){
            return $this->precio;
        }
        public function getHoraInicio(){
            return $this->horaInicio;
        }
        public function getDuracion(){
            return $this->duracion;
        }
        public function getObjTeatro(){
            return $this->objTeatro;
        }

        public function getMensajeOperacion(){
            return $this->mensajeOperacion;
        }

        public function setIdFuncion($nId){
            $this->idFuncion=$nId;
        }
        public function setNombre($nNom){
            $this->nombre=$nNom;
        }
        public function setPrecio($nPre){
            $this->precio=$nPre;
        }
        public function setHoraInicio($nIni){
            $this->horaInicio=$nIni;
        }
        public function setDuracion($nDur){
            $this->duracion=$nDur;
        }
        public function setObjTeatro($nObj){
            $this->objTeatro=$nObj;
        }
        public function setMensajeOperacion($nMsj){
            $this->mensajeOperacion=$nMsj;
        }

        public function Buscar($id){
            $base=new BaseDatos();
            $consulta="Select * from funcion where idfuncion=".$id;
            $resp=false;
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    if($row2=$base->Registro()){
                        //Lo hice manual por un error
                        $objTeatro=new Teatro();
                        $objTeatro->Buscar($row2['idteatro'], FALSE);
                        $this->setIdFuncion($row2['idfuncion']);
                        $this->setNombre($row2['nombre']);
                        $this->setPrecio($row2['precio']);
                        $this->setHoraInicio($row2['horainicio']);
                        $this->setDuracion($row2['duracion']);
                        $this->setObjTeatro($objTeatro);                      
                        $resp=true;
                    }                
                } else { $this->setMensajeOperacion($base->getError()); }
            } else { $this->setMensajeOperacion($base->getError()); }		
            return $resp;
        }

        public function listar($condicion=""){
            $colFuncion=null;
            $base=new BaseDatos();
            $consulta="Select * from funcion ";
            if ($condicion!=""){
                $consulta.=" where ".$condicion;
            }
            $consulta.=" order by idfuncion ";
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    $colFuncion=array ();
                    while($row2=$base->Registro()){
                        $objFuncion=new Funcion();
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
            $consulta="INSERT INTO funcion(nombre,precio,horainicio,duracion,idteatro) VALUES ('".$this->getNombre()."',".$this->getPrecio().",'".$this->getHoraInicio()."',".$this->getDuracion().",".$this->getObjTeatro()->getIdTeatro().")";            
            if($base->Iniciar()){    
                if($id=$base->devuelveIDInsercion($consulta)){
                    $this->setIdFuncion($id);
                    $resp=true;    
                } else { $this->setMensajeOperacion($base->getError()); }    
            } else { $this->setMensajeOperacion($base->getError()); }
            return $resp;
        }

        public function modificar(){
            $resp=false; 
            $base=new BaseDatos();
            $consulta="UPDATE funcion SET idfuncion=".$this->getIdFuncion().",nombre='".$this->getNombre()."',precio=".$this->getPrecio().",horainicio='".$this->getHoraInicio()."',duracion=".$this->getDuracion().",idteatro=". $this->getObjTeatro()->getIdteatro()." WHERE idfuncion=".$this->getIdFuncion();
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    $resp=true;
                } else{ $this->setMensajeOperacion($base->getError()); }
            } else{ $this->setMensajeOperacion($base->getError()); }
            return $resp;
        }

        public function eliminar(){
            $base=new BaseDatos();
            $resp=false;
            if($base->Iniciar()){
                $consulta="DELETE FROM funcion WHERE idfuncion=".$this->getIdFuncion();
                if($base->Ejecutar($consulta)){
                    $resp=true;
                }else{ $this->setMensajeOperacion($base->getError()); }
            }else{ $this->setMensajeOperacion($base->getError()); }
            return $resp; 
        }

        //FUNCIONES
        public function darCosto(){
            return $this->getPrecio()*1.45;
        }

        public function calcularFin(){
            // Retorna el calculo de sumar el inicion con las duracion de la pelicula
            $fin = new DateTime($this->getHoraInicio()->format('Y-m-d H:i'));
            $fin->add(new DateInterval('PT'.$this->getDuracion()["minuto"].'M'));
            return $fin;
        }

        public function funcionPosible($otraFuncion){
            /***
             * Retorna un true en caso de que el horario de la funcion sea posible
             * Busca si coiciden las fechas de inicion y fin de ambas.
             * En caso de ser verdadero alguno, Comprueba si los horarios se tocan.
             */
            $iniA = $this->getHoraInicio();
            $iniB = $otraFuncion->getHoraInicio();
            $finA = $this->calcularFin();
            $finB = $otraFuncion->calcularFin();
            
            if (($iniA<$iniB && $finA>$finB) || ($iniA>$iniB && $finA<$finB)){  //Esta Condicion elimina dos errores que imagine
                $posible = FALSE;                                               //Primer es si la funcion comienza antes y termina despues de la otra funcion
            } else{                                                             //Segundo si la funcion comienza y termina durante la otra funcion
                if ($finA<$iniB){
                    $posible = TRUE;
                } elseif ($iniA>$finB){
                    $posible = TRUE;
                } else {
                    $posible = FALSE;
                }
            }
            return $posible;
        }

        public function __toString()
        {
            return "Id Funcion: ".$this->getIdFuncion(). 
            "\nFuncion: ".$this->getNombre().
            "\nPrecio: ".$this->getPrecio().
            "\nHora Inicio: ".$this->gethoraInicio().
            "\nDuracion: ".$this->getDuracion().
            "\nId Teatro: ".$this->getObjTeatro()->getIdTeatro();
        }
    }