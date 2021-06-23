<?php
    include_once "../orm/Teatro.php";
    include_once "../orm/Funcion.php";    
    include_once "../orm/FuncionCine.php";
    include_once "../orm/FuncionMusical.php";
    include_once "../orm/FuncionTeatro.php";
    
    class abmTeatro {
        public function insertarTeatro($teatro){
            $objTeatro=new Teatro();
            $teatro['idteatro']=NULL;
            $teatro['listafuncion']=array ();
            $objTeatro->cargar($teatro);   
            if ($objTeatro->insertar()){
                return "Teatro Creado";
            } else return "Error: ".$objTeatro->getMensajeOperacion()."\n";;
        }

        public function modificarTeatro($id,$teatro){
            $objTeatro=new Teatro();
            $objTeatro->Buscar($id, FALSE);   
            $objTeatro->setNombre($teatro['nombre']);               
            $objTeatro->setDireccion($teatro['direccion']);             
            if ($objTeatro->modificar()){
                return "Teatro modificado";
            } else return "Error: ".$objTeatro->getMensajeOperacion();
        }

        public function listarTeatro(){
            $objTeatro=new Teatro();   
            $colTeatro=$objTeatro->listar();
            $txt="[TEATROS]".
            "\n-------------------------------------------------------\n";
	        foreach ($colTeatro as $unTeatro){	
		        $txt.= $unTeatro.
                "\n-------------------------------------------------------\n";
	        }
            return $txt;
        }

        public function eliminarTeatro($id){
            $objTeatro=new Teatro();
            $objTeatro->Buscar($id, TRUE);
            $colFunciones=$objTeatro->getListaObjFuncion();
            $borro=TRUE;            
            $txt="";
            $i=0;
            while (count($colFunciones)>$i){
                $funcion=$colFunciones[$i];
                $i++;
                if (!$funcion->eliminar()){
                    $borro=FALSE;
                } else $txt.="/n".$funcion->getMensajeOperacion();
            }
            if ($borro){
                $objTeatro->eliminar();
                $txt="Teatro eliminado";
            } $txt.= $objTeatro->getMensajeOperacion();
            return $txt;
        }

        public function buscarTeatro($id){
            $objTeatro=new Teatro();   
            if ($objTeatro->Buscar($id, TRUE)){
                return $objTeatro;
            } else return FALSE;
        }

        //FUNCIONES     
        public function darCostoMensual($id, $mes){
            $ambFuncionC = new abmFuncionCine();
            $ambFuncionM = new abmFuncionMusical();
            $ambFuncionT = new abmFuncionTeatro();
            $objTeatro=new Teatro();   
            if ($objTeatro->Buscar($id, TRUE)){
                $colFunciones = $objTeatro->getListaObjFuncion();
                $costoMensual = 0;
                if (count($colFunciones)>0){
                    foreach ($colFunciones as $funcion){
                        $inicio=new DateTime($funcion->getHoraInicio());
                        if ($inicio->format('m') == $mes){
                            $idFuncion=$funcion->getIdFuncion();
                            if (is_float($costo=$ambFuncionC->darCosto($idFuncion))) { $costoMensual+=$costo;} 
                            elseif (is_float($costo=$ambFuncionT->darCosto($idFuncion))){ $costoMensual+=$costo;} 
                            elseif (is_float($costo=$ambFuncionM->darCosto($idFuncion))){ $costoMensual+=$costo;}
                        }
                    }
                }
                return "COSTO MENSUAL: ".$costoMensual."$\n";
            } else return "ID de Teatro no valido\n";
        }
    }