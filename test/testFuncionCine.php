<?php
    include_once "../orm/FuncionCine.php";

    // creo un obj Persona
	$objFuncion=new FuncionCine();

    //CARGAR()
    $objteatro=new Teatro();
    $objteatro->Buscar(2, FALSE);
	$funcion=array ('idfuncion'=>null,'nombre'=>'Jumanji','precio'=>100,'horainicio'=>'2020-01-01 10:10','duracion'=>90,'objteatro'=>$objteatro,'genero'=>'accion viejo','paisorigen'=>'Ghana');
    $objFuncion->cargar($funcion);

    // INSERTAR()
	if ($objFuncion->insertar()){
		echo "\nOP INSERCION EXITOSA";
	} else echo $obj_Persona->getmensajeoperacion();
    
    // MODIFICAR()
	$objFuncion->setNombre("Nombre Modificado");
	if ($objFuncion->modificar()){
        echo "\nOP MODIFICACION EXITOSA";	
	}else echo $objFuncion->getmensajeoperacion();
    
    // ELIMINAR()
    $objFuncion->Buscar(1132);
	if ($objFuncion->eliminar()){
		echo " \nOP ELIMINACION EXITOSA";
	} else echo $objFuncion->getmensajeoperacion();

    //LISTAR()
	$colFuncion =$objFuncion->listar();
	foreach ($colFuncion as $unaFuncion){	
		echo $unaFuncion.
        "\n-------------------------------------------------------\n";
	}

    //BUSCAR()
    echo "Seleccione el id de la funcion deseada ";
    if ($objFuncion->Buscar(trim(fgets(STDIN)))){
        echo $objFuncion;
    } else echo $objFuncion->getMensajeOperacion(); 