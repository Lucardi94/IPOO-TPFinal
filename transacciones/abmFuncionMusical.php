<?php
    include_once "../orm/FuncionMusical.php";
    class abmFuncionMusical {
        public function insertarFuncion($funcion){
            $ObjTeatro=new Teatro();           
            $ObjTeatro->Buscar($funcion['objteatro']->getIdTeatro(),TRUE);
            $listObjTeatro=$ObjTeatro->getListaObjFuncion();
            $objFuncion=new FuncionMusical();
            $objFuncion->cargar($funcion);   
            if ($this->verificarHorario($listObjTeatro,$objFuncion)){
                if ($objFuncion->insertar()){
                    return "Funcion Creada";
                } else return "Error: ".$objFuncion->getMensajeOperacion();
            } else return "El horario no esta disponible";
        }

        public function modificarFuncion($objFuncion,$funcion){ 
            $ObjTeatro=new Teatro();           
            $ObjTeatro->Buscar($funcion['objteatro']->getIdTeatro(),TRUE);
            $listObjTeatro=$ObjTeatro->getListaObjFuncion();
            $funcion['idfuncion']=$objFuncion->getIdFuncion();
            $objFuncion->cargar($funcion);   
            if ($this->verificarHorario($listObjTeatro,$objFuncion)){            
                if ($objFuncion->modificar()){
                    return "Funcion Modificada";
                } else return "Error: ".$objFuncion->getMensajeOperacion();
            } else return "El horario no esta disponible";   
        }

        public function listarFuncion(){
            $objFuncion=new FuncionMusical();   
            $colFuncion =$objFuncion->listar();
            $txt="[FUNCIONES DE MUSICALES]".
            "\n-------------------------------------------------------\n";
	        foreach ($colFuncion as $unaFuncion){	
		        $txt.= $unaFuncion.
                "\n-------------------------------------------------------\n";
	        }
            return $txt;
        }

        public function eliminarFuncion($id){
            $objFuncion=new FuncionMusical();
            $objFuncion->Buscar($id);   
            if ($objFuncion->eliminar()){
                return "Funcion Eliminada";
            } else return "Error: ".$objFuncion->getMensajeOperacion();
        }

        public function buscarFuncion($id){
            $objFuncion=new FuncionMusical();   
            if ($objFuncion->Buscar($id)){
                return $objFuncion;
            } else return "Error: ".$objFuncion->getMensajeOperacion();
        }

        //FUNCIONES

        public function funcionPosible($objFuncion, $newFuncion){
            /***
             * Retorna un true en caso de que el horario de la funcion sea posible
             * Busca si coiciden las fechas de horaInicion y fin de ambas.
             * En caso de ser verdadero alguno, Comprueba si los horarios se tocan.
             */

            $iniA=new DateTime($objFuncion->gethoraInicio());
            $iniB=new DateTime($newFuncion->gethoraInicio());
            $finA=strtotime( '+ '.$objFuncion->getDuracion().'minute' ,strtotime($newFuncion->gethoraInicio()));
            $finB=strtotime( '+ '.$newFuncion->getDuracion().'minute' ,strtotime($objFuncion->gethoraInicio()));
            $finA=new DateTime($finA);
            $finB=new DateTime($finB);


            if (($iniA<$iniB && $finA>$finB) || ($iniA>$iniB && $finA<$finB)){  //Esta Condicion elimina dos errores que imagine
                $posible = FALSE;                                              //Primer es si la funcion comienza antes y termina despues de la otra funcion
            } else{                                                             //Segundo si la funcion comienza y termina durante la otra funcion
                if ($finA<$iniB){ $posible = TRUE;}
                elseif ($iniA>$finB){ $posible = TRUE; } 
                else { $posible = FALSE;}
            }
            return $posible;
        }

        public function verificarHorario($colFunciones ,$newFuncion){
            /***
             *  Retorna un true o false sino existe el lugar disponible.
             *  Recorre la lista de forma parcial hasta encontra que un horario no es posible.
             */
            $horarioDisponible = TRUE;
            $i=0;
            while ($i < count($colFunciones) && $horarioDisponible){
                $funcion = $colFunciones[$i];
                if ($this->funcionPosible($funcion, $newFuncion)){
                } else $horarioDisponible = FALSE;
                $i++;
            }
            return $horarioDisponible;
        }
        
        public function darCosto($id){
            $objFuncion=new FuncionMusical();   
            if ($objFuncion->Buscar($id)){
                return $objFuncion->getPrecio()*1.12;
            } else return "Error: ".$objFuncion->getMensajeOperacion();
        }
    }