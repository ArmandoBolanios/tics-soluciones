<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<title>REGISTRO DE MERCANCIAS</title>
			<link rel="stylesheet" href="estilos/estilos.css" />
		</head>
		<body>


				<center><img src="banner2.png"><br/><br/></center>

<?php
	require('cn/cnt.php'); 
	
		
	if (isset($_POST['busqueda'])) {

		$busquedaN = $_REQUEST['busquedanombre']; 

		$buscar = "SELECT * FROM  cliente_nuevo WHERE nombrecompleto LIKE '%$busquedaN%' ORDER BY idcliente";
		$dat = $Oxi->query($buscar); 
	?>
		

	<?php

		echo '
		<table border="0" width="100%" cellspacing="1" cellpadding="6" bordercolor="#336699" bgcolor="#336699">
			<tr bgcolor="#336699">
				<td>ID CLIENTE</td>
				<td>CODIGO CLIENTE</td>
				<td>NOMBRE COMPLETO</td>
				<td>TELEFONO</td>
				<td>OPCIONES</td>
			</tr>

		';
		$color=0;
		while($datRes = $dat->fetch_array(MYSQLI_ASSOC)) {
				if (($color%2)==0) {
					echo '<tr bgcolor="#EBEBEB">';
				} else {
					echo '<tr bgcolor="#FFFFFF">'; 
				}
				echo '
						<td>'.$datRes['idcliente'].'</td>
						<td>'.$datRes['codigocliente'].'</td>
						<td>'.$datRes['nombrecompleto'].'</td>
						<td>'.$datRes['telefono'].'</td>
						<td>
								<form name="frmVentas" method="post" action="'.$_SERVER['PHP_SELF'].'" ">
									<input type="hidden" name="codigocliente" value="'.$datRes['codigocliente'].'">
									<button type="submit" name="busquedaCodigo" >MOSTRAR</button>
								</form></center>
						</td>
					</tr>
				';
				$color++; 
		}

		echo '</table>';
		
	} else if (isset($_POST['busquedaCodigo'])) {

			$codigoCliente = $_REQUEST['codigocliente']; 

			// consultar tabla cliente 

			$sql = "SELECT idcliente, codigocliente, nombrecompleto, telefono from cliente_nuevo WHERE codigocliente='$codigoCliente'"; 
			$datos = $Oxi->query($sql); 
			$datosR = $datos->fetch_array(MYSQLI_ASSOC); 

			$idCliente = $datosR['idcliente']; 
			$codigoCliente = $datosR['codigocliente']; 
			$nombre = $datosR['nombrecompleto']; 
			$telefono = $datosR['telefono']; 


			echo '<h2>RESULTADOS</h2><br>';
			echo 'ID CLIENTE: <b>'.$idCliente.'</b><br/><br/>'; 
			echo 'CODIGO CLIENTE: <b>'.$codigoCliente.'</b><br/><br/>'; 
			echo 'NOMBRE COMPLETO: <b>'.$nombre.'</b><br/><br/>'; 
			echo 'TELEFONO: <b>'.$telefono.'</b><br/><br/>'; 


			echo '<h3>EQUIPOS ASOCIADOS AL CLIENTE</h3>'; 

			// consultar equipos asociaciones al cliente 

			$sqlequipos = "SELECT idequipo,codigocliente,descripcion,servicio,fechallegada,fechasalida,observaciones,COSTO from equipo_nuevo WHERE codigocliente= '$codigoCliente' ORDER BY idequipo"; 
			$dats = $Oxi->query($sqlequipos); 

			echo '
		<table border="0" width="100%" cellspacing="1" cellpadding="6" bordercolor="#336699" bgcolor="#336699">
			<tr bgcolor="#336699">
				<td>ID EQUIPO</td>
				<td width="80%">EQUIPO:</td>
				<td>COSTO</td>
			</tr>

		';
		$color=0;
		while($datRes = $dats->fetch_array(MYSQLI_ASSOC)) {
				if (($color%2)==0) {
					echo '<tr bgcolor="#EBEBEB">';
				} else {
					echo '<tr bgcolor="#FFFFFF">'; 
				}
				echo '
						<td>'.$datRes['idequipo'].'</td>
						<td>DESCRIPCION EQUIPO: <b>'.$datRes['descripcion'].'.</b> </br>SERVICIO REALIZADO: <b>'.$datRes['servicio'].'</b></br>OBSERVACIONES: <b>'.$datRes['observaciones'].'</b> </br>FECHA ENTRADA: <b>'.$datRes['fechallegada'].'</b> </br>FECHA SALIDA <b>'.$datRes['fechasalida'].'</b></td> 
						<td>'.$datRes['COSTO'].'</td>
											
					</tr>
				';
				$color++; 
		}

		echo '</table><br>';

		echo '<form name="frmVentas" method="post" action="'.$_SERVER['PHP_SELF'].'" ">
									<input type="hidden" name="codigoCliente" value="'.$codigoCliente.'">
									<button type="submit" name="agregarEquipo" >AGREGAR EQUIPO</button>
								</form><br><br><br>';

			echo '<hr color="#000000" size="5">';
	} else if  (isset($_POST['agregarEquipo'])) {

		$codigoCliente = $_REQUEST['codigoCliente'];
		?>

		<h1> AGREGAR EQUIPO A CLIENTE REGISTRADO</h1>
		<form name="santiagoApostol" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
			<label> CODIGO CLIENTE: </label>
			<input type="text" name="identificador" size="15" value="<?php echo ''.$codigoCliente ?>"/>
			<label> FECHA DE RECEPCION: </label>
			<input type="date" name="fechaLlegada" size="20"><br><br/>
							
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
				<button type="submit" name="equipoAsociado">REGISTRAR EQUIPO</button>
				<button type="reset" name="resetearFormulario">LIMPIAR FORMULARIO</button>
			</form>
		<?php

	} if (isset($_POST['equipoAsociado'])) {


		require('cn/cnt.php'); 

		$codigoCliente = $_REQUEST['identificador'];  // listo
		$fechaLlegada = $_REQUEST['fechaLlegada'];  // listo
		$fechaSalida = $_REQUEST['fechaSalida'];
		$servicio = strtoupper($_REQUEST['servicio']);
		$descripcionEquipo = $_REQUEST['descripcion'];
		$observaciones;
		$costo = $_REQUEST['costo']; 
		

		if (is_null($observaciones = $_REQUEST['observaciones'])) {
			$observaciones = "NO APLICA"; 
		}

		$observaciones = strtoupper($observaciones);  

		
	
		$descripcionEquipo = strtoupper($descripcionEquipo); 

		
	
		/*	$sql = "INSERT INTO equipos(codigoEquipo) VALUES('$codigoEquipo') "; */


		# REALIZAMOS LA INSERSION 


	$sql2 = "INSERT INTO equipo_nuevo (codigocliente,descripcion,servicio,fechallegada,fechasalida,observaciones,COSTO) VALUES ('$codigoCliente','$descripcionEquipo','$servicio','$fechaLlegada','$fechaSalida','$observaciones','$costo') ";

		$Oxi->query($sql2); 

		echo '<h2>Equipo Registrado Correctamente</h2>'; 

/* mostramos datos registrados listos para imprimir */

    echo '<P ALIGN="justify"><FONT FACE="tahoma" SIZE=3>';
	echo 'CODIGO CLIENTE: <b>'.$codigoCliente.'</b> <br/><br/> FECHA/HORA DE RECEPCION: <b>'.$fechaLlegada.'</b>';
	echo '<br/><br/>FECHA/HORA DE SALIDA: <b>'.$fechaSalida.'</b>';
		echo '<br/><br/>DESCRIPCION DEL EQUIPO: <b>'.$descripcionEquipo.'</b><br/>'; 
		 echo '<br/>SERVICIO: <b>'.$servicio.'</b>'; 
		echo '<br/><br/><br/>OBSERVACIONES: <b>'.$observaciones.'</b><br/>'; 
		
		echo '<hr> COSTO DEL SERVICIO: <b>$'.$costo.'</b> <br/><br/>';
		echo '<hr color="RED" size="5">';

	} 

?>

					<h1>BUSQUEDA DE CLIENTES</h1>
<table name="tabla1" width="80%" border="0" cellspacing="10" cellpadding="10">
	<tr>
		<td><center>
		<hr color="ORANGE" size="5"><br/><br/>
		<form name="frmVentas" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" ">
			<label><b>NOMBRE DEL CLIENTE: </b></label>
			<input type="text" name="busquedanombre" class="cajaBusqueda" autofocus="on" required /></br><br/>
			<button type="submit" name="busqueda" class="botonPersonalizado">BUSCAR</button>
		</form></center>
		<hr color="ORANGE" size="5">
	</td>


	</tr>
</table>
<br/><br/>
<a href="index.php"><h1>Inicio</h1></a>

</body>
</html>