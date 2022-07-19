<?php
error_reporting(0);

	if (isset($_POST['RegistrarEquipo'])) {


		require('cn/cnt.php'); 

		$codigoEquipo = $_REQUEST['identificador'];  // listo
		$fechaLlegada = $_REQUEST['fechallegada'];  // listo
		$recibe = $_REQUEST['recibe']; 
		$nombreCliente = $_REQUEST['nombre'];  
		$telefonoCliente  = $_REQUEST['telefono'];
		$descripcionEquipo = $_REQUEST['descripcionEquipo'];
		$computadoraEscritorio; 
		$equipoPortatil;
		$impresora;
		$otroEquipo; 
		$observaciones;
		$contrasenia;
		$mantenimientoPreventivo;
		$mantenimientoCorrectivo; 
		
		if (is_null($computadoraEscritorio = $_REQUEST['e1'])) {
			$computadoraEscritorio = "NO";
			//echo $computadoraEscritorio;  
		} else  {
			$computadoraEscritorio = "SI"; 
			//echo $computadoraEscritorio; 
		}
		
		if (is_null($equipoPortatil = $_REQUEST['e2'])) { 
			$equipoPortatil = "NO"; 
		} else  {
			$equipoPortatil = "SI"; 
		}

		if(is_null($impresora = $_REQUEST['e3'])) {
			$impresora = "SI";
		} else {
			$impresora = "NO"; 
		}

		if (is_null($otroEquipo = $_REQUEST['e4'])) {
			$otroEquipo = "NO APLICA"; 
		} 
		$otroEquipo = strtoupper($otroEquipo); 

		if (is_null($observaciones = $_REQUEST['observaciones'])) {
			$observaciones = "NO APLICA"; 
		}
		$observaciones = strtoupper($observaciones);  

		if (is_null($contrasenia = $_REQUEST['contrasena'])) {
			$contrasenia = "NO APLICA"; 
		} 

		if (is_null($mantenimientoPreventivo = $_REQUEST['s1'])) {
			$mantenimientoPreventivo = "NO";
		} else {
			$mantenimientoPreventivo = "SI"; 
		}

		if (is_null($mantenimientoCorrectivo = $_REQUEST['s2'])) {
			$mantenimientoCorrectivo = "NO"; 
		} else {
			$mantenimientoCorrectivo = "SI"; 
		}

		if (is_null($formateoConRespaldo = $_REQUEST['s3'])) {
			$formateoConRespaldo = "NO"; 
		} else {
			$formateoConRespaldo = "SI"; 
		}

		if (is_null($formateoSinRespaldo = $_REQUEST['s4'])) {
			$formateoSinRespaldo = "NO";
		} else {
			$formateoSinRespaldo = "SI"; 
		}

		if (is_null($otroServicio = $_REQUEST['s5'])) {
			$otroServicio = "NO APLICA";
		} 

		$otroServicio = strtoupper($otroServicio); 

		if (is_null($respaldoUno = $_REQUEST['r2'])) {
			$respaldoUno = "NO"; 
		} else {
			$respaldoUno = "SI"; 
		}

		if (is_null($respaldoDos = $_REQUEST['r3'])) {
			$respaldoDos = "NO"; 
		} else {
			$respaldoDos = "SI"; 
		}
		
		if (is_null($respaldoTres = $_REQUEST['r4'])) {
			$respaldoTres = "NO"; 
		} else {
			$respaldoTres = "SI"; 
		}

		if (is_null($sinRespaldo = $_REQUEST['r1'])) {
			$sinRespaldo = "NO";
		} else {
			$sinRespaldo = "SI"; 
		}

		if (is_null($raton = $_REQUEST['raton'])) {
			$raton = "NO";
		} else {
			$raton = "SI"; 
		}

		if (is_null($teclado = $_REQUEST['teclado'])) {
			$teclado = "NO";
		} else {
			$teclado = "SI"; 
		}

		if (is_null($cable = $_REQUEST['cable'])) {
			$cable = "NO"; 
		} else {
			$cable = "SI"; 
		}

		if (is_null($cargador = $_REQUEST['cargador'])) {
			$cargador = "NO"; 
		} else  {
			$cargador = "SI"; 
		}

		if (is_null($adaptador = $_REQUEST['adaptador'])) {
			$adaptador = "NO";
		} else {
			$adaptador = "SI"; 
		}

		if (is_null($funda = $_REQUEST['funda'])) {
			$funda = "NO";
		} else  {
			$funda = "SI"; 
		}

		if (is_null($mochila = $_REQUEST['mochila'])) {
			$mochila = "NO"; 
		} else {
			$mochila = "SI"; 
		}

		if (is_null($otroAditamento = $_REQUEST['otroaditamento'])) {
			$otroAditamento = "NO APLICA"; 
		} else {

			$otroAditamento = strtoupper($_REQUEST['otroaditamento']);
		}

		if (($refacciones = $_REQUEST['refacciones']) == 2) {

			$refaccion1 = "NO APLICA"; 
			$costoRefaccion1 = 0.0;
			$refaccion2 = "NO APLICA"; 
			$costoRefaccion2 = 0.0;
			$refaccion3 = "NO APLICA"; 
			$costoRefaccion3 = 0.0;
		}  else {

			if (is_null($refaccion1 = $_REQUEST['refaccion1'])) {
				$refaccion1 = "NO APLICA"; 
				$costoRefaccion1 = 0.0;
			} else {
				$refaccion1 = strtoupper($_REQUEST['refaccion1']); 
				if (($costoRefaccion1 = $_REQUEST['costorefaccion1']) < 0) {
					$costoRefaccion1 = 0; 
				}
			}

			if (is_null($refaccion2 = $_REQUEST['refaccion2'])) {
				$refaccion2 = "NO APLICA"; 
				$costoRefaccion2 = 0.0;
			} else {
				$refaccion2 = strtoupper($_REQUEST['refaccion2']); 
				if (($costoRefaccion2 = $_REQUEST['costorefaccion2']) < 0) {
					$costoRefaccion2 = 0; 
				}
			}

			if (is_null($refaccion3 = $_REQUEST['refaccion3'])) {
				$refaccion3 = "NO APLICA"; 
				$costoRefaccion3 = 0.0;
			} else {
				$refaccion3 = strtoupper($_REQUEST['refaccion3']); 
				if (($costoRefaccion3 = $_REQUEST['costorefaccion3']) < 0) {
					$costoRefaccion3 = 0; 
				}
			}

			
		}

		if (is_null($costoServicio = $_REQUEST['costoServicio'])) {
			$costoServicio = 0; 
		} else {
			if ($costoServicio < 0) {
				$costoServicio = 0; 
			}
		}

		if (is_null($anticipo = $_REQUEST['anticipo'])) {
			$anticipo = 0; 
		} else {
			if ($anticipo < 0) {
				$anticipo = 0;
			}
		}

		if (is_null ($resta = $_REQUEST['resta'])) {
			$resta = 0; 
		} else {
			if ($resta < 0) {
				$resta = 0;
			}
		}

		if (is_null($informacionAdicional = $_REQUEST['informacionAdicional'])) {
			$informacionAdicional = "NO APLICA"; 
		} else {
			$informacionAdicional = strtoupper($_REQUEST['informacionAdicional']);
		}


		$recibe = strtoupper($recibe); 
		$nombreCliente = strtoupper($nombreCliente); 
		$descripcionEquipo = strtoupper($descripcionEquipo); 

		
	

		/*	$sql = "INSERT INTO equipos(codigoEquipo) VALUES('$codigoEquipo') "; */


		# REALIZAMOS LA INSERSION 

	$sql  = "INSERT INTO equipos (codigoEquipo, recibe, identificador, fecha, nombre, telefono, descripcionEquipo, tipoE1, tipoE2, tipoE3, tipoE4, observaciones, contrasena, tipoS1, tipoS2, tipoS3, tipoS4, tipoS5, respaldo1, respaldo2, respaldo3, sinRespaldo, raton, teclado, cable, cargador, adaptador, funda, mochila, otro, refacciones, tipoR1, tipoR11, tipoR2, tipoR22, tipoR3, tipoR33, costo, anticipo, resto, adicional, fechaSalida, seguimiento, auxiliar3, auxiliar4) VALUES ('$codigoEquipo','$recibe','$codigoEquipo','$fechaLlegada','$nombreCliente','$telefonoCliente','$descripcionEquipo','$computadoraEscritorio','$equipoPortatil','$impresora','$otroEquipo','$observaciones','$contrasenia','$mantenimientoPreventivo','$mantenimientoCorrectivo','$formateoConRespaldo','$formateoSinRespaldo','$otroServicio','$respaldoUno','$respaldoDos','$respaldoTres','$sinRespaldo','$raton','$teclado','$cable','$cargador','$adaptador','$funda','$mochila','$otroAditamento','$refacciones','$refaccion1','$costoRefaccion1','$refaccion2','$costoRefaccion2','$refaccion3','$costoRefaccion3','$costoServicio','$anticipo','$resta','$informacionAdicional','$fechaLlegada',1,1,'5') ";

		$Oxi->query($sql); 

		echo '<h2>Equipo Registrado Correctamente</h2>'; 

/* mostramos datos registrados listos para imprimir */

    echo '<P ALIGN="justify"><FONT FACE="tahoma" SIZE=2>';
	echo 'CODIGO DE EQUIPO: <b>'.$codigoEquipo.'</b> | FECHA/HORA DE RECEPCION: <b>'.$fechaLlegada.' </b>| RECIBE:  <b>'.$recibe.'</b><hr>';
	echo 'DATOS DE CLIENTE:<br>Cliente: <b>'.$nombreCliente.'</b> | TELEFONO: <b>'.$telefonoCliente.'</b><hr>'; 
	echo 'DESCRIPCION DEL EQUIPO: <b>'.$descripcionEquipo.'</b><br/>'; 
		echo '<br>COMPUTADORA DE ESCRITORIO: <b>'.$computadoraEscritorio.'</b> | EQUIPO PORTATIL: <b>'.$equipoPortatil.'</b>'.' | IMPRESORA: <b>'.$impresora.'</b>'; 
		echo ' | OTRO: <b>'.$otroEquipo.'</b>'; 
		echo '<br/>OBSERVACIONES: <b>'.$observaciones.'</b>'; 
		echo ' | CONTRASEÑA: <b>'.$contrasenia.'</b><hr>'; 
		echo 'TIPO DE SERVICIO:<br/> MANTENIMIENTO PREVENTIVO: <b>'.$mantenimientoPreventivo.'</b> | MANTENIMIENTO CORRECTIVO: <b>'.$mantenimientoCorrectivo.'</b>'; 
		echo ' | FORMATEO CON RESPALDO: <b>'.$formateoConRespaldo.'</b> | FORMATEO SIN RESPALDO: <b>'.$formateoSinRespaldo.'</b> | OTRO SERVICIO: <b>'.$otroServicio.'</b>';
		echo '<br> RESPALDO: <br> DE 0 A 20 GB: <b>'.$respaldoUno.'</b> | DE 21 A 30 GB: <b>'.$respaldoDos.'</b> | MAS DE 30 GB: <b>'.$respaldoTres.'</b> | SIN RESPALDO: <b>'.$sinRespaldo.'</b>';
		echo '<br> ADITAMENTO: <br> RATON: <b>'.$raton.'</b> | TECLADO: <b>'.$teclado.'</b> | CABLE: <b>'.$cable.'</b> | CARGADOR: <b>'.$cargador.'</b> | ADAPTADOR: <b>'.$adaptador.'</b> |  FUNDA: <b>'.$funda.'</b> | MOCHILA: <b>'.$mochila.'</b> | OTRO ADITAMENTO: <b>'.$otroAditamento.'</b>';
		echo '<br>REFACCIONES: <br> NECESITA REFACCIONES: <b>'.$refacciones.'</b>';
		echo '<br>REFACCION 1: <b>'.$refaccion1.'</b> | COSTO DE REFACCION 1: <b>$'.$costoRefaccion1.'</b>';
		echo '<br>REFACCION 2: <b>'.$refaccion2.'</b> | COSTO DE REFACCION 2: <b>$'.$costoRefaccion2.'</b>';
		echo '<br>REFACCION 3: <b>'.$refaccion3.'</b> | COSTO DE REFACCION 3: <b>$'.$costoRefaccion3.'</b>';
		echo '<hr> COSTO DEL SERVICIO: <b>$'.$costoServicio.'</b> | ANTICIPO: <b>$'.$anticipo.'</b> | RESTA: <b>$'.$resta.'</b><br/><br/>';
		echo 'INFORMACION ADICIONAL: <b>'.$informacionAdicional.'</b><hr>';
		echo '<center><img src="banner.png"></center>';	
		echo 'CODIGO DE EQUIPO: <b>'.$codigoEquipo.'</b> | FECHA/HORA DE RECEPCION: <b>'.$fechaLlegada.' </b>| RECIBE:  <b>'.$recibe.'</b><hr>';
		echo 'DATOS DE CLIENTE:<br>Cliente: <b>'.$nombreCliente.'</b> | TELEFONO: <b>'.$telefonoCliente.'</b> | DESCRIPCION DEL EQUIPO: <b>'.$descripcionEquipo.'</b><br/> | ANTICIPO: <b>$'.$anticipo.'</b>'; 
		echo '</font><font face="tahoma" size=1><hr>Domicilio: AÑORVE #93 COL. SAN FRANCISCO, TLAPA DE COMONFORT, GRO., (FRENTE A LA JURISDICCION 04 / LOCAL VERDE). TELEFONO CELULAR: 757 121 2338<br/>';
		echo 'Visita nuestro sitio web: www.tics-tlapa.com | Facebook: Soporte Tics Tlapa | Youtube: Soluciones Tics Tlapa | Correo Electronico: soporte@tics-tlapa.com<br/>';
		echo 'TIEMPO DE ENTREGA: DE 48 A 72 HORAS, SOLO DIAS HABILES. NO APLICA PARA EQUIPOS QUE REQUIEREN CAMBIO DE PIEZAS.';


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
		<h1> RECEPCION DE EQUIPOS</h1>
		<form name="santiagoApostol" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
			<label> ID EQUIPO: </label>
			<input type="text" name="identificador" size="15" value="<?php echo ''.$idEquipo ?>"/>
			<label> FECHA DE RECEPCION: </label>
			<input type="text" name="fechallegada" size="20" value="<?php echo ''.$fechaRecepcion ?>"><br><br/>
			<label>	RECIBE: </label>
			<input type="text" name="recibe" size="50" required autofocus /> <br/><br/>
			
			<label> A NOMBRE DE: </label>
			<input type="text" name="nombre" size="50" required />
			<label> TELEFONO: </label>
			<input type="text" name="telefono" size="20" required /><br><br>
			<label> DESCRIPCION DEL EQUIPO: </label>
			<input type="text" name="descripcionEquipo" size="100" required /><br><br/>
			<label> <b>TIPO DE EQUIPO:</b>  </label>
			<input type="checkbox" name="e1"> COMPUTADORA DE ESCRITORIO |
			<input type="checkbox" name="e2"> EQUIPO PORTATIL |
			<input type="checkbox" name="e3"> IMPRESORA |
			<label>OTRO: </label>
			<input type="text" name="e4" size="50"><br/><br/>
			<label>OBSERVACIONES:</label><br/>
			<textarea name="observaciones" rows="3" cols="120"></textarea><br/><br/>
			<label>EL EQUIPO TIENE CONTRASEÑA:</label>
			<input type="text" name="contrasena" size="25"><br/><br/>
			<table border="0" width="100%">
				<tr>
					<td valign="top">
						<label>TIPO DE SERVICIO:</label><br/>
						<input type="checkbox" name="s1"> MANTENIMIENTO PREVENTIVO<br/>
						<input type="checkbox" name="s2"> MANTENIMIENTO CORRECTIVO<br/>
						<input type="checkbox" name="s3"> FORMATEO CON RESPALDO<br/>
						<input type="checkbox" name="s4"> FORMATEO SIN RESPALDO<br/>
						<label> OTRO TIPO DE SERVICIO: </label><input type="text" name="s5" size="40"></br><br/> 
					</td>
					<td valign="top">
						<label>RESPALDO: </label><br/>
						<input type="checkbox" name="r1">SIN RESPALDO <br/>
						<input type="checkbox" name="r2"> DE 0 A 20 GB DE INFORMACION<br/>
						<input type="checkbox" name="r3"> DE 21 A 30 GB DE INFORMACION<br/>
						<input type="checkbox" name="r4"> MAS DE 30 GB DE INFORMACION<br/><br/>
						
					</td>
					<td valign="top">
						<label> ADITAMENTOS:</label><br/>
						<input type="checkbox" name="raton"> RATON<br/>
						<input type="checkbox" name="teclado"> TECLADO<br/>
						<input type="checkbox" name="cable"> CABLE DE CORRIENTE<br/>
						<input type="checkbox" name="cargador"> CARGADOR / ELIMINADOR<br/>
						<input type="checkbox" name="adaptador"> ADAPTADOR DE CLAVIJA<br/>
						<input type="checkbox" name="funda"> FUNDA / ESTUCHE<br/>
						<input type="checkbox" name="mochila"> MOCHILA / MALETA<br/>
						<label>OTRO: </label><input type="text" name="otroaditamento" size="50">

					</td>
				</table>
				<br>
				<label>REFACCIONES:</label>
				<input type="radio" name="refacciones" value="1"> SI
				<input type="radio" name="refacciones" value="2"> NO<br/><br/>
				<label>REFACCION 1:</label>
				<input type="text" name="refaccion1" size="50">
				<label>COSTO: $</label>
				<input type="text" name="costorefaccion1"><br/><br/>
				<label>REFACCION 2:</label>
				<input type="text" name="refaccion2" size="50">
				<label>COSTO: $</label>
				<input type="text" name="costorefaccion2"><br/><br/>
				<label>REFACCION 3:</label>
				<input type="text" name="refaccion3" size="50">
				<label>COSTO: $</label>
				<input type="text" name="costorefaccion3">
				<br/><br/>
				<label>COSTO DEL SERVICIO: $</label>
				<input type="text" name="costoServicio">
				<label>ANTICIPO: $</label>
				<input type="text" name="anticipo">
				<label>RESTA: $</label>
				<input type="text" name="resta">
				<br/><br/><br/>
				<label>INFORMACION ADICIONAL:</label>
				<textarea name="informacionAdicional" rows="3" cols="120"></textarea>
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