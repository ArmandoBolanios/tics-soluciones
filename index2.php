<?php
// Armando Bolaños
// Modificación inicial: 17/Sept/2021

require('cn/cnt.php');


if (isset($_POST['nuevoRegistro'])) {

	$categoria = $_REQUEST['categoria'];
	$codigoDeProducto = $_REQUEST['codigoDeProducto'];
	$noDeParte = $_REQUEST['noDeParte'];
	$descripcion = $_REQUEST['descripcion'];
	$marca = $_REQUEST['marca'];
	$modelo = $_REQUEST['modelo'];
	$factor = $_REQUEST['factor'];
	$contenido = $_REQUEST['contenido'];
	$existencias = $_REQUEST['existencias'];
	$precioDeCompra = $_REQUEST['precioDeCompra'];
	$precioUnitario = $_REQUEST['precioUnitario'];
	$observaciones = $_REQUEST['observaciones'];
	$ubicacion = $_REQUEST['ubicacion'];
	$fechaDeCompra = $_REQUEST['fechaDeCompra'];

	$prefijo = substr(md5(uniqid(rand())), 0, 6);
	$mran = rand(1, 10000);
	$dir_subida = 'archivos/';
	$fichero_subido = $dir_subida . '' . $prefijo . basename($_FILES['archivo']['name']);
	$propietario = $_REQUEST['propietario'];

	echo '<pre>';
	if (move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido)) {
		echo "El fichero es válido y se subió con éxito.\n";
	} else {
		echo "¡Posible ataque de subida de ficheros!\n";
	}


	$status = "";

	$insReg = "INSERT INTO productos(categoria, codigoProducto,noDeParte,descripcion, marca, modelo, factor,contenido,existencias,precioDeCompra,precioUnitario,observaciones,ubicacion, fechaDeCompra,imagen,propietario,fechaDeRegistro,auxiliar) 
				VALUES ('$categoria', '$codigoDeProducto', '$noDeParte', '$descripcion', 
						'$marca', '$modelo', '$factor', '$contenido', '$existencias', '$precioDeCompra', '$precioUnitario', '$observaciones', '$ubicacion', '$fechaDeCompra','$fichero_subido', '$propietario', now(), 1) ";

	if ($Oxi->query($insReg)) {
		echo '
			<img src="banner.png">
				<hr>
			Registro insertado bien';

		echo '<a href="index.php"><br/><br/><br/><b>Regresar</b></a>';
	} else {
		echo 'No hay conexion a la base de datos';
		echo '<a href="index.php"><br/><br/><br/><b>Regresar</b></a>';
	}
} else {

?>
	<!DOCTYPE html>
	<html>

	<head>
		<meta charset="utf-8">
		<title>REGISTRO DE MERCANCIAS</title>
		<link rel="stylesheet" href="estilos/estilos.css" />
	</head>

	<body bgcolor="#EBEBEB">



		<div id="contenedorPrincipal">
			<img src="banner.png">
			<hr>
			<nav>
				<a href="index.php" class="linksMenus">REGISTRO DE PRODUCTOS</a> |
				<a href="ventas.php" class="linksMenus">VENTAS</a> |
				<a href="ventas_hoy.php" class="linksMenus">INFORME VENTAS</a> |
				<a href="modificar.php" class="linksMenus">EDITAR PRODUCTOS</a> |
				<a href="productos.php" class="linksMenus">LISTA DE PRODUCTOS</a> |
				<a href="cliente_nuevo.php" class="linksMenus">RECEPCION DE EQUIPOS PC/LAPTOP</a>
				<hr>
				<a href="equipo.php" class="linksMenus">REFACCIONES/PIEZAS DE EQUIPOS</a> |
				<a href="equipo.php" class="linksMenus">COMPONENTES RECICLADOS</a> |
				<a href="equipo.php" class="linksMenus">GASTOS DEL LOCAL</a> |
				<a href="equipo.php" class="linksMenus">APERTURA CAJA</a> |
				<a href="equipo.php" class="linksMenus">CIERRE CAJA</a>

				<hr>

			</nav>
			<section>
				<section>
					<h1> REGISTRO DE MERCANCIAS</h1>
					<form name="frmRegistro" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
						<fieldset>
							<legend>Opciones de Factura</legend>
							<label><input type="radio" name="propietario" id="estatus" value="Sin Factura" required> Sin Factura</label>
							<label><input type="radio" name="propietario" id="estatus" value="Lilia" required> Lilia</label>
							<label><input type="radio" name="propietario" id="estatus" value="Eduardo" required> Eduardo</label>
						</fieldset>

						<label>CATEGORIA:</label>
						<select name="categoria" class="cajaBusqueda">
							<option value="PAPELERIA">PAPELERIA</option>
							<option value="ELECTRONICA">ELECTRONICA</option>
							<option value="ELECTRONICA/RECICLADOS">ELECTRONICA/RECICLADOS</option>
							<option value="COMPUTO/REFACCIONES">COMPUTO/REFACCIONES</option>
							<option value="COMPUTO/REFACCIONES/SEMINUEVOS">COMPUTO/REFACCIONES/SEMINUEVOS</option>
							<option value="ACCESORIOS COMPUTO">ACCESORIOS</option>
							<option value="CONSUMO/GOLOSINAS/BEBIDAS">CONSUMO/GOLOSINAS/BEBIDAS</option>
							<option value="OTROS">OTROS</option>
						</select><br /><br />

						<label>CODIGO DE PRODUCTO: </label>
						<input type="text" name="codigoDeProducto" class="cajaBusqueda" required />
						<label># DE PARTE: </label>
						<input type="text" name="noDeParte" class="cajaBusqueda" required /><br /><br />
						<label>DESCRIPCION:</label>
						<input type="text" name="descripcion" class="cajaBusqueda" size="60" required /><br /><br />
						<label>MARCA:</label>
						<input type="text" name="marca" class="cajaBusqueda" required />
						<label>MODELO:</label>
						<input type="text" name="modelo" class="cajaBusqueda" required />
						<label>FACTOR:</label>
						<select name="factor" class="cajaBusqueda">
							<option value="PIEZA">PIEZA</option>
							<option value="FRASCO">FRASCO</option>
							<option value="CAJA">CAJA</option>
							<option value="KIT">KIT</option>
							<option value="COMBO">COMBO</option>
							<option value="BOLSA">BOLSA</option>
							<option value="PLIEGO">PLIEGO</option>
							<option value="BOTELLA">BOTELLA</option>
							<option value="UNIDAD">UNIDAD</option>
							<option value="CAPSULA">CAPSULA</option>
							<option value="HOJA">HOJA</option>
						</select><br /><br />
						<label>CONTENIDO:</label>
						<input type="text" name="contenido" class="cajaBusqueda" required />
						<label>EXISTENCIAS:</label>
						<input type="text" name="existencias" class="cajaBusqueda" required /><br /><br />
						<label>PRECIO DE COMPRA:</label>
						<input type="text" name="precioDeCompra" class="cajaBusqueda" required>
						<label>PRECIO DE VENTA:</label>
						<input type="text" name="precioUnitario" class="cajaBusqueda" required /><br /><br />
						<label>OBSERVACIONES:</label>
						<input type="text" name="observaciones" class="cajaBusqueda" size="50" required /><br /><br />
						<label>UBICACION:</label>
						<input type="text" name="ubicacion" class="cajaBusqueda" required />
						<label>FECHA DE COMPRA:</label>
						<input type="date" name="fechaDeCompra" class="cajaBusqueda" required />
						<label>IMAGEN:</label>
						<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
						<input type="file" name="archivo" class="cajaBusqueda" accept="image/png, .jpeg, .jpg, image/gif" required /><br /><br />
						<button type="submit" name="nuevoRegistro" class="botonPersonalizado">REGISTRAR PRODUCTO</button>

					</form>
				</section>
			</section>
			<footer>
			</footer>
			<hr>
		</div>
	</body>

	</html>

<?php

}

?>