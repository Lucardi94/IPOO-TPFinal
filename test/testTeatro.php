<?php
    include_once "../orm/Teatro.php";

    // creo un obj Persona
	$objTeatro=new Teatro();

    //CARGAR()
	$teatro=array ('idteatro'=>null,'nombre'=>'Persa','direccion'=>'Amaranto Suarez 1114','listafuncion'=>array ());
    $objTeatro->cargar($teatro);
	echo $objTeatro;

    // INSERTAR()
	if ($objTeatro->insertar()){
		echo "\nOP INSERCION EXITOSA";
	} else echo $objTeatro->getmensajeoperacion();
    
    // MODIFICAR()
	$objTeatro->setNombre("Nombre Modificado");
	if ($objTeatro->modificar()){
        echo "\nOP MODIFICACION EXITOSA";	
	}else echo $objTeatro->getmensajeoperacion();
    
    //ELIMINAR()
	if ($objTeatro->eliminar()){
		echo " \nOP ELIMINACION EXITOSA";
	} else echo $objTeatro->getmensajeoperacion();

    //LISTAR()
	/*$colTeatro =$objTeatro->listar();
	foreach ($colTeatro as $unTeatro){	
		echo $unTeatro.
        "\n-------------------------------------------------------\n";
	}*/

	//BUSCAR()
    echo "Seleccione el id de la funcion deseada ";
    if ($objTeatro->Buscar(trim(fgets(STDIN)),TRUE)){
    	if ($objTeatro->eliminar()){
		echo "\n".$objTeatro."\nELIMINADO";
		} else echo $objTeatro->getmensajeoperacion();
    } else echo $objFuncion->getMensajeOperacion();