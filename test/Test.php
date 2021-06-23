<?php 
        include_once "../orm/BaseDatos.php";
        include_once "../orm/Funcion.php";
        include_once "../orm/FuncionCine.php";
        include_once "../orm/FuncionMusical.php";
        include_once "../orm/FuncionTeatro.php";        
        include_once "../orm/Teatro.php";        
        include_once "../transacciones/abmFuncion.php";
        include_once "../transacciones/abmFuncionCine.php";
        include_once "../transacciones/abmFuncionMusical.php";
        include_once "../transacciones/abmFuncionTeatro.php";
        include_once "../transacciones/abmTeatro.php";
        
        $abmTeatro=new abmTeatro();
        $abmFuncion=new abmFuncion();
        $abmFuncionCine=new abmFuncionCine();
        $abmFuncionMusical=new abmFuncionMusical();        
        $abmFuncionTeatro=new abmFuncionTeatro(); 

        
        function menuPrincipal(){
            return "----------------------------------------".
            "\n[Menu Principal] Seleccione la opcion".
            "\n1. Administrar teatros".
            "\n2. Administrar Funciones".           
            "\n3. Costo de funcion".
            "\n4. Costo mensual".
            "\ne. Para salir ".
            "\n---------------------------------------- ";
        }

        function menuAdministrarTeatro(){
            return "----------------------------------------".
            "\n[Administrar Teatro] Seleccione la opcion".
            "\n1. Listar Teatros".
            "\n2. Ingresar Teatro".
            "\n3. Modificar Teatro".
            "\n4. Eliminar Teatro".
            "\n---------------------------------------- ";
        }        

        function menuAdministrarFuncion(){
            return "----------------------------------------".
            "\n[Administrar Funcion] Seleccione la opcion".
            "\n1. Listar Funciones".
            "\n2. Ingresar Funcion".
            "\n3. Modificar Funcion".
            "\n4. Eliminar Funcion".
            "\n---------------------------------------- ";
        }

        function menuDarCostoFunciones(){
            return  "----------------------------------------".
            "\n[Listar Funciones] Seleccione la opcion".
            "\n1. Costo funcion Cine".
            "\n2. Costo funcion Musical".
            "\n3. Costo funcion Teatro".
            "\n---------------------------------------- ";
        }

        function IngresarDatosTeatro(){
           echo "----------------------------------------".
            "\n[Datos Teatro] Ingrese nombre, minutos de duracion, \n";
            $modificacion= array ('nombre'=>trim(fgets(STDIN)), 'direccion'=>trim(fgets(STDIN)));
            echo "----------------------------------------\n";
            return $modificacion;
        }

        function menuListarFunciones(){
            return  "----------------------------------------".
            "\n[Listar Funciones] Seleccione la opcion".
            "\n1. Listar Funciones Cine".
            "\n2. Listar Funciones Musical".
            "\n3. Listar Funciones Teatro".
            "\n4. Listar todas las Funciones".
            "\n---------------------------------------- ";
        } 

        function menuModificarFunciones(){
            return  "----------------------------------------".
            "\n[Listar Funciones] Seleccione la opcion".
            "\n1. Modificar funcion Cine".
            "\n2. Modificar funcion Musical".
            "\n3. Modificar funcion Teatro".
            "\n---------------------------------------- ";
        } 
        
        function menuIngresarFunciones(){
            return  "----------------------------------------".
            "\n[Listar Funciones] Seleccione la opcion".
            "\n1. Ingresar funcion Cine".
            "\n2. Ingresar funcion Musical".
            "\n3. Ingresar funcion Teatro".
            "\n---------------------------------------- ";
        }

        function menuEliminarFunciones(){
            return  "----------------------------------------".
            "\n[Listar Funciones] Seleccione la opcion".
            "\n1. Eliminar funcion Cine".
            "\n2. Eliminar funcion Musical".
            "\n3. Eliminar funcion Teatro".
            "\n---------------------------------------- ";
        }

        function IngresarDatosFuncionCine(){
            $abmTeatro=new abmTeatro();
            echo "----------------------------------------".
            $modificacion['idfuncion']=NULL;
            echo "\n[Datos Funcion]\nIngrese nombre ";
            $modificacion['nombre']=trim(fgets(STDIN));
            echo "Ingrese precio ";
            $modificacion['precio']=trim(fgets(STDIN));
            echo "Igrese AÑO / MES / DIA / HORA / MINUTO ";
            $a = trim(fgets(STDIN));
            $m = trim(fgets(STDIN));
            $d = trim(fgets(STDIN));
            $h = trim(fgets(STDIN));
            $i = trim(fgets(STDIN));
            $modificacion['horainicio'] ="".$a."-".$m."-".$d." ".$h.":".$i."";
            echo "Ingrese duracion ";
            $modificacion['duracion']=trim(fgets(STDIN));
            echo "Ingrese genero ";
            $modificacion['genero']=trim(fgets(STDIN));
            echo "Ingrese pais de origen ";
            $modificacion['paisorigen']=trim(fgets(STDIN));
            echo "Ingrese id teatro ";
            $id = trim(fgets(STDIN));
            if ($objTeatro=$abmTeatro->buscarTeatro($id)){
                $modificacion['objteatro']=$objTeatro;
                return $modificacion;
            } else echo "ERROR: ID no valido\n";
            echo "----------------------------------------\n";
        }

        function IngresarDatosFuncionMusical(){
            $abmTeatro=new abmTeatro();
            echo "----------------------------------------".
            $modificacion['idfuncion']=NULL;
            echo "\n[Datos Funcion]\nIngrese nombre ";
            $modificacion['nombre']=trim(fgets(STDIN));
            echo "Ingrese precio ";
            $modificacion['precio']=trim(fgets(STDIN));
            echo "Igrese AÑO / MES / DIA / HORA / MINUTO ";
            $a = trim(fgets(STDIN));
            $m = trim(fgets(STDIN));
            $d = trim(fgets(STDIN));
            $h = trim(fgets(STDIN));
            $i = trim(fgets(STDIN));
            $modificacion['horainicio'] ="".$a."-".$m."-".$d." ".$h.":".$i."";
            echo "Ingrese duracion ";
            $modificacion['duracion']=trim(fgets(STDIN));
            echo "Ingrese director ";
            $modificacion['director']=trim(fgets(STDIN));
            echo "Ingrese cantidad de personas en escena ";
            $modificacion['cantidadpersonas']=trim(fgets(STDIN));
            echo "Ingrese id teatro ";
            $id = trim(fgets(STDIN));
            if ($objTeatro=$abmTeatro->buscarTeatro($id)){
                $modificacion['objteatro']=$objTeatro;
                return $modificacion;
            } else echo "ERROR: ID no valido\n";
            echo "----------------------------------------\n";
        }

        function IngresarDatosFuncionTeatro(){
            $abmTeatro=new abmTeatro();
            echo "----------------------------------------".
            $modificacion['idfuncion']=NULL;
            echo "\n[Datos Funcion]\nIngrese nombre ";
            $modificacion['nombre']=trim(fgets(STDIN));
            echo "Ingrese precio ";
            $modificacion['precio']=trim(fgets(STDIN));
            echo "Igrese AÑO / MES / DIA / HORA / MINUTO ";
            $a = trim(fgets(STDIN));
            $m = trim(fgets(STDIN));
            $d = trim(fgets(STDIN));
            $h = trim(fgets(STDIN));
            $i = trim(fgets(STDIN));
            $modificacion['horainicio'] ="".$a."-".$m."-".$d." ".$h.":".$i."";
            echo "Ingrese duracion ";
            $modificacion['duracion']=trim(fgets(STDIN));
            echo "Ingrese id teatro ";
            $id = trim(fgets(STDIN));
            if ($objTeatro=$abmTeatro->buscarTeatro($id)){
                $modificacion['objteatro']=$objTeatro;
                return $modificacion;
            } else echo "ERROR: ID no valido\n";
            echo "----------------------------------------\n";
        }
        
        do {
            echo menuPrincipal();
            $opc = trim(fgets(STDIN));            
            switch ($opc){
                case 1: 
                    echo menuAdministrarTeatro();
                    $opcDos=trim(fgets(STDIN));
                    switch ($opcDos) {
                        case 1: echo $abmTeatro->listarTeatro();
                        break;
                        case 2: 
                            $modificacion=IngresarDatosTeatro();
                            echo $abmTeatro->insertarTeatro($modificacion)."\n";
                        break;
                        case 3:
                            echo "Ingrese id teatro ";
                            $id = trim(fgets(STDIN));
                            if ($objTeatro=$abmTeatro->buscarTeatro($id)){
                                $modificacion=IngresarDatosTeatro();
                                echo $abmTeatro->modificarTeatro($objTeatro->getIdTeatro(),$modificacion)."\n";
                            } else echo "ERROR: ID no valido\n";
                        break;
                        case 4:
                            echo "Ingrese id teatro ";
                            $id = trim(fgets(STDIN));
                            if ($objTeatro=$abmTeatro->buscarTeatro($id)){
                                echo $abmTeatro->eliminarTeatro($objTeatro->getIdTeatro())."\n";
                            } else echo "ERROR: ID no valido\n";
                        break;
                        default: echo "OPCION NO VALIDA\n"; 
                    }                   
                break;
                case 2: 
                    echo menuAdministrarFuncion();
                    $opcDos = trim(fgets(STDIN));
                    switch($opcDos){
                        case 1: 
                            echo menuListarFunciones();                            
                            $opcTres = trim(fgets(STDIN));
                            switch ($opcTres){
                                case 1: echo $abmFuncionCine->listarFuncion();
                                break;
                                case 2: echo $abmFuncionMusical->listarFuncion();
                                break;
                                case 3: echo $abmFuncionTeatro->listarFuncion();
                                break;
                                case 4: echo $abmFuncion->listarFuncion();
                                break;
                                default: echo "OPCION NO VALIDA\n";
                            }
                        break;                            
                        case 2: 
                            echo menuIngresarFunciones();                            
                            $opcTres = trim(fgets(STDIN));
                            switch ($opcTres){
                                case 1: 
                                    $modificacion=IngresarDatosFuncionCine();
                                    echo $abmFuncionCine->insertarFuncion($modificacion)."\n";
                                break;
                                case 2: 
                                    $modificacion=IngresarDatosFuncionMusical();
                                    echo $abmFuncionMusical->insertarFuncion($modificacion)."\n";
                                break;
                                case 3: 
                                    $modificacion=IngresarDatosFuncionTeatro();
                                    echo $abmFuncionTeatro->insertarFuncion($modificacion)."\n";
                                break;
                                default: echo "OPCION NO VALIDA\n";
                            }
                        break;
                        case 3: 
                            echo menuModificarFunciones();                            
                            $opcTres = trim(fgets(STDIN));
                            switch ($opcTres){
                                case 1: 
                                    echo "Ingrese id funcion ";
                                    $id = trim(fgets(STDIN));
                                    if ($objFuncion=$abmFuncionCine->buscarFuncion($id)){
                                        $modificacion=IngresarDatosFuncionCine();
                                        echo $abmFuncionCine->modificarFuncion($objFuncion,$modificacion)."\n";
                                    } else echo "ERROR: ID no valido\n";
                                break;
                                case 2: 
                                    echo "Ingrese id funcion ";
                                    $id = trim(fgets(STDIN));
                                    if ($objFuncion=$abmFuncionMusical->buscarFuncion($id)){
                                        $modificacion=IngresarDatosFuncionMusical();
                                        echo $abmFuncionMusical->modificarFuncion($objFuncion,$modificacion)."\n";
                                    } else echo "ERROR: ID no valido\n";
                                break;
                                case 3: 
                                    echo "Ingrese id funcion ";
                                    $id = trim(fgets(STDIN));
                                    if ($objFuncion=$abmFuncionTeatro->buscarFuncion($id)){
                                        $modificacion=IngresarDatosFuncionTeatro();
                                        echo $abmFuncionTeatro->modificarFuncion($objFuncion,$modificacion)."\n";
                                    } else echo "ERROR: ID no valido\n";
                                break;
                                default: echo "OPCION NO VALIDA\n";
                            }
                        break;
                        case 4: 
                            echo menuEliminarFunciones();                            
                            $opcTres = trim(fgets(STDIN));
                            switch ($opcTres){
                                case 1: 
                                    echo "Ingrese id funcion ";
                                    $id = trim(fgets(STDIN));
                                    if ($objFuncion=$abmFuncionCine->buscarFuncion($id)){
                                        echo $abmFuncionCine->eliminarFuncion($objFuncion->getIdFuncion())."\n";
                                    } else echo "ERROR: ID no valido\n";
                                break;
                                case 2: 
                                    echo "Ingrese id funcion ";
                                    $id = trim(fgets(STDIN));
                                    if ($objFuncion=$abmFuncionMusical->buscarFuncion($id)){
                                        echo $abmFuncionMusical->eliminarFuncion($objFuncion->getIdFuncion())."\n";
                                    } else echo "ERROR: ID no valido\n";
                                break;
                                case 3: 
                                    echo "Ingrese id funcion ";
                                    $id = trim(fgets(STDIN));
                                    if ($objFuncion=$abmFuncionTeatro->buscarFuncion($id)){
                                        echo $abmFuncionTeatro->eliminarFuncion($objFuncion->getIdFuncion())."\n";
                                    } else echo "ERROR: ID no valido\n";
                                break;
                                default: echo "OPCION NO VALIDA\n";
                            }
                        break;
                        default: echo "OPCION NO VALIDA\n";
                    }
                break;
                case 3:
                    echo menuDarCostoFunciones();
                    $opcDos=trim(fgets(STDIN));
                    switch ($opcDos){
                        case 1: 
                            echo "Ingrese id funcion ";
                            $id = trim(fgets(STDIN));
                            echo "COSTO ".$abmFuncionCine->darCosto($id)."$\n";
                        break;
                        case 2: 
                            echo "Ingrese id funcion ";
                            $id = trim(fgets(STDIN));
                            echo "COSTO ".$abmFuncionMusical->darCosto($id)."$\n";
                        break;
                        case 3: 
                            echo "Ingrese id funcion ";
                            $id = trim(fgets(STDIN));
                            echo "COSTO ".$abmFuncionTeatro->darCosto($id)."$\n";
                        break;
                        default: echo "OPCION NO VALIDA\n";
                    }
                break;
                case 4:
                    echo "Ingrese id teatro y mes ";
                    $id = trim(fgets(STDIN));
                    $mes = trim(fgets(STDIN));                    
                    echo $abmTeatro->darCostoMensual($id, $mes);
                break;
                case "e":
                break;
                default: echo "OPCION NO VALIDA\n";                
            }
        } while ($opc!="e");