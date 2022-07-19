<?php
error_reporting(0);

	if (isset($_POST['RegistrarEquipo'])) {


		require('cn/cnt.php'); 

		$codigoCliente = $_REQUEST['identificador'];  // listo
		$fechaLlegada = $_REQUEST['fechaLlegada'];  // listo
		$fechaSalida = $_REQUEST['fechaSalida'];
		$nombreCliente = $_REQUEST['nombre'];  
		$telefonoCliente  = $_REQUEST['telefono'];
		$servicio = strtoupper($_REQUEST['servicio']);
		$descripcionEquipo = $_REQUEST['descripcion'];
		$observaciones;
		$costo = $_REQUEST['costo']; 
		

		if (is_null($observaciones = $_REQUEST['observaciones'])) {
			$observaciones = "NO APLICA"; 
		}
		$observaciones = strtoupper($observaciones);  

		
		$nombreCliente = strtoupper($nombreCliente); 
		$descripcionEquipo = strtoupper($descripcionEquipo); 

		
	
		/*	$sql = "INSERT INTO equipos(codigoEquipo) VALUES('$codigoEquipo') "; */


		# REALIZAMOS LA INSERSION 

	$sql  = "INSERT INTO cliente_nuevo (codigocliente,nombrecompleto,telefono) VALUES ('$codigoCliente','$nombreCliente','$telefonoCliente') ";

		$Oxi->query($sql); 

	$sql2 = "INSERT INTO equipo_nuevo (codigocliente,descripcion,servicio,fechallegada,fechasalida,observaciones,COSTO) VALUES ('$codigoCliente','$descripcionEquipo','$servicio','$fechaLlegada','$fechaSalida','$observaciones','$costo') ";

		$Oxi->query($sql2); 

		echo '<h2>Equipo Registrado Correctamente</h2>'; 

/* mostramos datos registrados listos para imprimir */

    echo '<P ALIGN="justify"><FONT FACE="tahoma" SIZE=3>';
	echo 'CODIGO CLIENTE: <b>'.$codigoCliente.'</b> <br/><br/> FECHA/HORA DE RECEPCION: <b>'.$fechaLlegada.'</b>';
	echo '<br/><br/>FECHA/HORA DE SALIDA: <b>'.$fechaSalida.'</b>';
	echo '<br/><br/>DATOS DE CLIENTE:<br/><br>Cliente: <b>'.$nombreCliente.'</b> | TELEFONO: <b>'.$telefonoCliente.'</b><hr>'; 
	echo '<br/><br/>DESCRIPCION DEL EQUIPO: <b>'.$descripcionEquipo.'</b><br/>'; 
		 echo '<br/>SERVICIO: <b>'.$servicio.'</b>'; 
		echo '<br/><br/><br/>OBSERVACIONES: <b>'.$observaciones.'</b><br/>'; 
		
		echo '<hr> COSTO DEL SERVICIO: <b>$'.$costo.'</b> <br/><br/>';


	} else {

		$idEquipo = date("Ymdsi");
		$fechaRecepcion = Date("Y/m/d h:i:s");

?>

<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="estilos/estilos.css" />
	</head>
	<body>
		<h1> REGISTRO DE CLIENTES Y EQUIPOS</h1>
		<form name="santiagoApostol" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
			<label> CODIGO CLIENTE: </label>
			<input type="text" name="identificador" size="15" value="<?php echo ''.$idEquipo ?>"/>
			<label> FECHA DE RECEPCION: </label>
			<input type="date" name="fechaLlegada" size="20"><br><br/>
						
			<label> NOMBRE CLIENTE: </label>
			<input type="text" name="nombre" size="50" required />
			<label> TELEFONO: </label>
			<input type="text" name="telefono" size="20" required /><br><br>
			<label> DESCRIPCION DEL EQUIPO: </label>
			<input type="text" name="descripcion" size="100" required /><br><br/>
			
			<label>SERVICIO:</label><br/>
			<textarea name="servicio" rows="3" cols="120"></textarea><br/><br/>
			<label> COSTO: </label>
			<input type="text" name="costo" size="100" required /><br><br/>
			<label>OBSERVACIONES:</label><br/>
			<textarea name="observaciones" rows="3" cols="120"></textarea><br/><br/>
			<label> FECHA DE SALIDA: </label>
			<input type="date" name="fechaSalida" size="20"><br><br/>
				<br/><br/><br/>
				<button type="submit" name="RegistrarEquipo">REGISTRAR EQUIPO</button>
				<button type="reset" name="resetearFormulario">LIMPIAR FORMULARIO</button>
			</form>
	</body>
</html>



<?php

}
?>


<br/>
	<a href="index.php">Inicio</a>
</br>