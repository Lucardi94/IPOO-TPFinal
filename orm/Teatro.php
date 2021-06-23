<?php
    include_once "BaseDatos.php";
    include_once "FuncionCine.php";
    include_once "FuncionMusical.php";
    include_once "FuncionTeatro.php";
    class Teatro{
        private $idTeatro;
        private $nombre;
        private $direccion;
        private $listaObjFuncion;
        private $mensajeOperacion;


        public function __construct(){
            $this->idTeatro=NULL;
            $this->nombre="";
            $this->direccion="";
            $this->listaObjFuncion="";
        }

        public function cargar($funcion){
            $this->setIdTeatro($funcion['idteatro']);
            $this->setNombre($funcion['nombre']);
            $this->setDireccion($funcion['direccion']);
            $this->setListaObjFuncion($funcion['listafuncion']);
        }

        public function getIdTeatro(){
            return $this->idTeatro;
        }
        public function getNombre(){
            return $this->nombre;
        }
        public function getDireccion(){
            return $this->direccion;
        }
        public function getListaObjFuncion(){
            return $this->listaObjFuncion;
        }
        public function getMensajeOperacion(){
            return $this->mensajeOperacion;
        }

        public function setIdTeatro($nId){
            $this->idTeatro=$nId;
        }
        public function setNombre($nom){
            $this->nombre=$nom;
        }
        public function setDireccion($dir){
            $this->direccion=$dir;
        }
        public function setListaObjFuncion($lisOF){
            $this->listaObjFuncion=$lisOF;
        }
        public function setMensajeOperacion($nMsj){
            $this->mensajeOperacion=$nMsj;
        }

        public function Buscar($id,$bool){
            $base=new BaseDatos();
            $consulta="Select * from teatro where idteatro=".$id;
            $resp=false;
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    if($row2=$base->Registro()){
                        $coleccion=array ();
                        if ($bool){                     
                            $objCine=new FuncionCine();
                            $objMusical=new FuncionMusical();
                            $objTeatro=new FuncionTeatro();
                            $listaTemp=array_merge($objCine->listar(), $objMusical->listar(), $objTeatro->listar());
                            for ($i=0; $i<count($listaTemp); $i++){
                                $funcion=$listaTemp[$i];
                                if ($funcion->getObjTeatro()->getIdTeatro() == $id){
                                    array_push($coleccion, $funcion);
                                }
                            }
                        }                      
                        $row2['listafuncion']=$coleccion;
                        $this->cargar($row2);
                        $resp=true;
                    }                
                } else { $this->setMensajeOperacion($base->getError()); }
            } else { $this->setMensajeOperacion($base->getError()); }		
            return $resp;
        }	
        
    
        public function listar($condicion=""){
            $colTeatro=NULL;
            $base=new BaseDatos();
            $consulta="Select * from teatro ";
            if ($condicion!=""){
                $consulta.=' where '.$condicion;
            }
            $consulta.=" order by idteatro ";
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    $colTeatro=array ();
                    while($row2=$base->Registro()){                        
                        $objTeatro=new Teatro();
                        $objTeatro->Buscar($row2['idteatro'], TRUE);
                        array_push($colTeatro,$objTeatro);
                    }                
                } else { $this->setMensajeOperacion($base->getError()); }
            } else { $this->setMensajeOperacion($base->getError()); }	
            return $colTeatro;
        }

        public function insertar(){
            $base=new BaseDatos();
            $resp=false;
            $consulta="INSERT INTO teatro(nombre,direccion) VALUES ('".$this->getNombre()."','".$this->getDireccion()."')";            
            if($base->Iniciar()){    
                if($id=$base->devuelveIDInsercion($consulta)){
                    $this->setIdTeatro($id);
                    $resp=true;    
                } else { $this->setMensajeOperacion($base->getError()); }    
            } else { $this->setMensajeOperacion($base->getError()); }
            return $resp;
        }
        
        public function modificar(){
            $resp=false; 
            $base=new BaseDatos();
            $consulta="UPDATE teatro SET nombre='".$this->getNombre()."', direccion='".$this->getDireccion()."' WHERE idteatro=".$this->getIdTeatro();
            if($base->Iniciar()){
                if($base->Ejecutar($consulta)){
                    $resp= true;
                } else{ $this->setMensajeOperacion($base->getError()); }
            } else{ $this->setMensajeOperacion($base->getError()); }
            return $resp;
        }
        
        public function eliminar(){
            $base=new BaseDatos();
            $resp=false;
            if($base->Iniciar()){
                $consulta="DELETE FROM teatro WHERE idteatro=".$this->getIdTeatro();
                if($base->Ejecutar($consulta)){
                    $resp=true;
                }else{ $this->setMensajeOperacion($base->getError()); }
            }else{ $this->setMensajeOperacion($base->getError()); }
            return $resp; 
        }

        //FUNCIONES

        public function verificarHorario($otraFuncion){
            /***
             *  Retorna un true o false sino existe el lugar disponible.
             *  Recorre la lista de forma parcial hasta encontra que un horario no es posible.
             */
            
            $horarioDisponible = TRUE;
            $listaFuncion = $this->getListaObjFuncion();
            $i=0;
            while ($i < count($listaFuncion) && $horarioDisponible){
                $funcion = $listaFuncion[$i];
                if (!$funcion->funcionPosible($otraFuncion)){
                    $horarioDisponible = FALSE;
                }
                $i++;
            }
            return $horarioDisponible;
        }

        public function cargarFucion($funcion){
            /***
             *  Retorna un true o false si pudo cargar una funcion a la lista.
             *  Pide datos por teclado y verifica el horario es posible.
             */
            echo "[Nueva Funcion]\nIngrese nombre ";
            $nom = trim(fgets(STDIN));
            echo "Ingrese precio ";
            $pre = trim(fgets(STDIN));
            echo "Igrese AÑO / MES / DIA / HORA / MINUTO ";
            $a = trim(fgets(STDIN));
            $m = trim(fgets(STDIN));
            $d = trim(fgets(STDIN));
            $h = trim(fgets(STDIN));
            $i = trim(fgets(STDIN));
            $ini = new DateTime(''.$a.'-'.$m.'-'.$d.' '.$h.':'.$i.'');
            echo "Duracion; minutos";
            $dur = trim(fgets(STDIN));
           
            if ($this->verificarHorario($funcion)){
                $listaFunciones = $this->getListaObjFuncion();
                array_push($listaFunciones, $funcion);
                return TRUE;
            }else return FALSE;     
        }

        public function mostrarFunciones(){
            if ( count($this->getListaObjFuncion()) == 0){
                $txt= "Sin funciones";
            } else {
                $txt="FUNCIONES: ";
                foreach ($this->getListaObjFuncion() as $funcion){
                    $txt.="\n - ".$funcion->getNombre()."";
                }
            }
            return $txt;
        }

        public function __toString(){
            return "id: ".$this->getIdTeatro().
            "\nTeatro: ".$this->getNombre().
            "\nDireccion: ".$this->getDireccion().
            "\n".$this->mostrarFunciones();
        }

    }