<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>ARTICULOS - MODIFICACION/ACTUALIZACION</title>
	<link rel="stylesheet" href="estilos/estilos.css" />
</head>

<body bgcolor="#EBEBEB">
	<center><img src="banner2.png"><br /><br />

		<?php
		require('cn/cnt.php');
		if (isset($_POST['busquedaCodigo'])) {

			$codigo = $_REQUEST['busqueda'];

			$consultarDatos = "SELECT * FROM productos WHERE codigoProducto='$codigo' AND auxiliar=1";
			$dat = $Oxi->query($consultarDatos);
			$datRes = $dat->fetch_array(MYSQLI_ASSOC);
			if (($datRes['codigoProducto'])) {
		?>

				<h2>ARTICULO ENCONTRADO</h2>
				<form name="frmVenta" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
					<table width="100%" cellspacing="10" class="edit_products">
						<tr>
							<td width="50%">
								<table border="0" width="100%" cellspacing="1" cellpadding="5" bgcolor="#000000" />
						<tr>
							<td width="30%" bgcolor="#FFFFFF">ID PRODUCTO:</td>
							<td width="70%" bgcolor="#FFFFFF"><span><?php echo $datRes['idProducto']; ?></span>
								<input type="text" name="idProducto" value="<?php echo $datRes['idProducto']; ?>" hidden />
							</td>
						</tr>
						<tr>
							<td width="30%" bgcolor="#FFFFFF">CATEGORIA:</td>
							<td width="70%" bgcolor="#FFFFFF"><?php echo $datRes['categoria']; ?>
								<input type="hidden" name="categoria1" value="<?php echo $datRes['categoria']; ?>">
								<select name="categoria2" class="cajaBusqueda">
									<option value="SELECCIONE">SELECCIONE</option>
									<option value="PAPELERIA">PAPELERIA</option>
									<option value="ELECTRONICA">ELECTRONICA</option>
									<option value="ELECTRONICA/RECICLADOS">ELECTRONICA/RECICLADOS</option>
									<option value="COMPUTO/REFACCIONES">COMPUTO/REFACCIONES</option>
									<option value="COMPUTO/REFACCIONES/SEMINUEVOS">COMPUTO/REFACCIONES/SEMINUEVOS</option>
									<option value="ACCESORIOS COMPUTO">ACCESORIOS</option>
									<option value="CONSUMO/GOLOSINAS/BEBIDAS">CONSUMO/GOLOSINAS/BEBIDAS</option>
									<option value="OTROS">OTROS</option>
								</select>
							</td>
						</tr>
						<tr>
							<td width="30%" bgcolor="#FFF">PROPIETARIO:</td>
							<td width="100%" bgcolor="#FFF" class="edicionPropietario">
								<input type="hidden" name="propietario" value="<?php echo $datRes['propietario']; ?>" />
								<label><?php echo '<h3 class="advertencia">' . $datRes['propietario'] . '</h3>'; ?></label>
								<fieldset class="none">
									<label><input type="radio" name="propietario" id="estatus" value="Sin Factura"> Sin Factura</label>
									<label><input type="radio" name="propietario" id="estatus" value="Lilia"> Lilia</label>
									<label><input type="radio" name="propietario" id="estatus" value="Eduardo"> Eduardo</label>
								</fieldset>
							</td>
						</tr>
						<tr>
							<td width="30%" bgcolor="#FFFFFF">CODIGO PRODUCTO:</td>
							<td width="70%" bgcolor="#FFFFFF"><input type="text" name="codigoProducto" value="<?php echo $datRes['codigoProducto']; ?>" size="80" class="input_edit"></td>
						</tr>
						<tr>
							<td width="30%" bgcolor="#FFFFFF">NUMERO DE PARTE:</td>
							<td width="70%" bgcolor="#FFFFFF"><input type="text" name="numeroDeParte" value="<?php echo $datRes['noDeParte']; ?>" size="80"></td>
						</tr>
						<tr>
							<td width="30%" bgcolor="#FFFFFF">DESCRIPCION:</td>
							<td width="70%" bgcolor="#FFFFFF"><input type="text" name="descripcion" value="<?php echo $datRes['descripcion']; ?>" size="80"></td>
						</tr>
						<tr>
							<td width="30%" bgcolor="#FFFFFF">MARCA:</td>
							<td width="70%" bgcolor="#FFFFFF"><input type="text" name="marca" value="<?php echo $datRes['marca']; ?>" size="80"></td>
						</tr>
						<tr>
							<td width="30%" bgcolor="#FFFFFF">MODELO:</td>
							<td width="70%" bgcolor="#FFFFFF"><input type="text" name="modelo" value="<?php echo $datRes['modelo']; ?>" size="80"></td>
						</tr>
						<tr>
							<td width="30%" bgcolor="#FFFFFF">FACTOR:</td>
							<td width="70%" bgcolor="#FFFFFF"><input type="text" name="factor" value="<?php echo $datRes['factor']; ?>" size="80"></td>
						</tr>
						<tr>
							<td width="30%" bgcolor="#FFFFFF">CONTENIDO:</td>
							<td width="70%" bgcolor="#FFFFFF"><input type="text" name="contenido" value="<?php echo $datRes['contenido']; ?>" size="80"></td>
						</tr>
						<tr>
							<td width="30%" bgcolor="#FFFFFF">EXISTENCIAS:</td>
							<td width="70%" bgcolor="#FFFFFF"><input type="text" name="existencias" value="<?php echo $datRes['existencias']; ?>" size="80"></td>
						</tr>
						<tr width="60%">
							<td width="30%" bgcolor="#FFFFFF">PRECIO DE COMPRA:</td>
							<td width="7%"><input type="text" name="precioDeCompra" value="<?php echo $datRes['precioDeCompra']; ?>" size="80"></td>
						</tr>
						<tr>
							<td width="30%" bgcolor="#FFFFFF">PRECIO DE VENTA:</td>
							<td width="70%" bgcolor="#FFFFFF"><input type="text" name="precioDeVenta" value="<?php echo $datRes['precioUnitario']; ?>" size="80"></td>
						</tr>
						<tr>
							<td width="30%" bgcolor="#FFFFFF">OBSERVACIONES:</td>
							<td width="70%" bgcolor="#FF0000"><input type="text" name="observaciones" value="<?php echo $datRes['observaciones']; ?>" size="80"></td>
						</tr>
						<tr>
							<td width="30%" bgcolor="#FFFFFF">UBICACION:</td>
							<td width="70%" bgcolor="#FFFFFF"><input type="text" name="ubicacion" value="<?php echo $datRes['ubicacion']; ?>" size="80"></td>
						</tr>
						<tr>
							<td width="30%" bgcolor="#FFFFFF">FECHA DE COMPRA:</td>
							<td width="70%" bgcolor="#FFFFFF"><?php echo $datRes['fechaDeCompra']; ?></td>
						</tr>
						<tr>
							<td width="30%" bgcolor="#FFFFFF">IMAGEN:</td>
							<td width="70%" bgcolor="#FFFFFF">
								<img src="<?php echo $datRes['imagen']; ?>" alt="imagen" width="200px" height="200px" />
								<!--<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
								<input type="file" name="archivo" class="cajaBusqueda" accept="image/png, .jpeg, .jpg, image/gif" 
								 />-->
							</td>
						</tr>
						<tr>
							<td width="30%" bgcolor="#FFFFFF">FECHA DE REGISTRO:</td>
							<td width="70%" bgcolor="#FFFFFF"><?php echo $datRes['fechaDeRegistro']; ?></td>
						</tr>
					</table>
					</td>
					</tr>
					</table>
					<button type="submit" name="modificarRegistro" class="botonPersonalizado">TERMINAR MOFICIACION</button>
				</form>

		<?php

			} else {
				echo '<h2><spam color="RED">ARTICULO NO ENCONTRADO</spam></h2>';
			}
		} else if (isset($_POST['modificarRegistro'])) {

			$idProducto = $_REQUEST['idProducto'];
			$codigoProducto = $_REQUEST['codigoProducto'];
			$numeroDeParte = $_REQUEST['numeroDeParte'];
			$descripcion = $_REQUEST['descripcion'];
			$marca = $_REQUEST['marca'];
			$modelo = $_REQUEST['modelo'];
			$factor = $_REQUEST['factor'];
			$contenido = $_REQUEST['contenido'];
			$existencias = $_REQUEST['existencias'];
			$precioDeCompra = $_REQUEST['precioDeCompra'];
			$precioDeVenta = $_REQUEST['precioDeVenta'];
			$observaciones = $_REQUEST['observaciones'];
			$ubicacion = $_REQUEST['ubicacion'];
			$categoria1 = $_REQUEST['categoria1'];
			$categoria2 = $_REQUEST['categoria2'];
			$categoria = "";
			$propietario = $_REQUEST['propietario'];


			if ($categoria2 != "SELECCIONE") {
				$categoria = $categoria2;
			} else {
				$categoria = $categoria1;
			}


			$actualizarProducto = "UPDATE productos SET categoria='$categoria', propietario = '$propietario', 
			codigoProducto='$codigoProducto', noDeParte='$numeroDeParte', descripcion='$descripcion', 
			marca='$marca', modelo='$modelo', factor='$factor', contenido='$contenido', existencias='$existencias', 
			precioDeCompra='$precioDeCompra', precioUnitario='$precioDeVenta', observaciones='$observaciones', 
			ubicacion='$ubicacion' WHERE idProducto='$idProducto' ";
			
			$executarConsulta = $Oxi->query($actualizarProducto);

			echo '<h1>ARTICULO MODIFICADO CORRECTAMENTE</h1>';
		} else if (isset($_POST['busquedaCodigo'])) {
		} else if (isset($_POST['busquedaCodigo'])) {
		} else if (isset($_POST['registrarVenta'])) {

			$codigoProducto = $_REQUEST['codigoProducto'];
			$unidades = $_REQUEST['unidadesVender'];
			$costoUnidades = $_REQUEST['costoUnidades'];
			$existenciasActuales = $_REQUEST['existencias1'];
			$observaciones = $_REQUEST['observaciones'];
			$descripcion = $_REQUEST['descripcion'];
			$totalVenta = $unidades * $costoUnidades;
			$existenciasNuevas = $existenciasActuales - $unidades;

			$registrarVenta = "INSERT INTO ventas1(codigoArticulo,unidades,costoUnidades,total,fechaVenta,observaciones) VALUES ('$codigoProducto','$unidades','$costoUnidades','$totalVenta',now(),'$observaciones')";
			$Oxi->query($registrarVenta);
			// actualizar tabla de articulos 
			$actualizarDatos = "UPDATE productos SET existencias='$existenciasNuevas' WHERE codigoProducto='$codigoProducto'";
			$Oxi->query($actualizarDatos);

			echo '
		<center>

		<h3> Venta registrada CODIGO: <b>' . $codigoProducto . '</b> & DESCRIPCION: <b>' . $descripcion . '</b></h3><br/><br/><br/>
		

		';
		}

		?>

		<table name="tabla1" width="70%" border="0">
			<tr>
				<td width="50%">
					<center>
						<form name="frmVentas" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<label>CODIGO DE PRODUCTO: </label>
							<input type="text" name="busqueda" placeholder="Codigo del Articulo" class="cajaBusqueda" autofocus="on" required /></br><br />
							<button type="submit" name="busquedaCodigo" class="botonPersonalizado">BUSCAR</button>
						</form>
					</center>
				</td>
			</tr>
		</table>
		<br /><br /><br />
		<a href="index.php">Inicio</a>
</body>

</html>