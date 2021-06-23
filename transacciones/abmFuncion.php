<?php
    include_once "../orm/Funcion.php";
    class abmFuncion {

        public function insertarFuncion($funcion){
            $objFuncion=new Funcion();
            $objFuncion->cargar($funcion);   
            if ($objFuncion->insertar()){
                return "Funcion Creada";
            } else return "Error: ".$objFuncion->getMensajeOperacion();
        }

        public function modificarFuncion($id,$funcion){
            $objFuncion=new Funcion();
            $objFuncion->Buscar($id);   
            $objFuncion->cargar($funcion);            
            if ($objFuncion->modificar()){
                return "Funcion Modificada";
            } else return "Error: ".$objFuncion->getMensajeOperacion();
        }

        public function listarFuncion(){
            $objFuncion=new Funcion();   
            $colFuncion =$objFuncion->listar();
            $txt="[FUNCIONES]".
            "\n-------------------------------------------------------\n";
	        foreach ($colFuncion as $unaFuncion){	
		        $txt.= $unaFuncion.
                "\n-------------------------------------------------------\n";
	        }
            return $txt;
        }

        public function eliminarFuncion($id){
            $objFuncion=new Funcion();
            $objFuncion->Buscar($id);   
            if ($objFuncion->eliminar()){
                return "Funcion Eliminada";
            } else return "Error: ".$objFuncion->getMensajeOperacion();
        }

        public function buscarFuncion($id){
            $objFuncion=new Funcion();   
            if ($objFuncion->Buscar($id)){
                return $objFuncion;
            } else return "Error: ".$objFuncion->getMensajeOperacion();
        }

        //FUNCIONES
        public function darCosto($id){
            $objFuncion=new Funcion();   
            if ($objFuncion->Buscar($id)){
                return $objFuncion->getPrecio()*1.45;
            } else return "Error: ".$objFuncion->getMensajeOperacion();
        }
    }