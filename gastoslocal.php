<?php 

 require('cn/cnt.php'); 



	if(isset($_POST['guardarGasto'])) {
 

		$conceptoGasto = $_REQUEST['conceptoGasto'];
		$totalGasto = $_REQUEST['totalGasto']; 
		
		$conceptoGasto = strtoupper($conceptoGasto); 

		$gasto = "INSERT INTO gastos(concepto,total,fecha,auxiliar) VALUES ('$conceptoGasto','$totalGasto',now(),1)"; 
		
		$Oxi->query($gasto);

		echo '<h2>GASTO insertado correctamente....</h2>'; 
		echo '<meta http-equiv="refresh" content="1;url=index.php">';
		 


	}  else {


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
				<a href="index2.php" class="linksMenus">REGISTRO DE PRODUCTOS</a> |
				<a href="ventas.php" class="linksMenus">VENTAS</a> |
				<a href="ventashoy.php" class="linksMenus">INFORME VENTAS</a> |
				<a href="modificar.php" class="linksMenus">EDITAR PRODUCTOS</a> |
				<a href="productos.php" class="linksMenus">LISTA DE PRODUCTOS</a> |
				<a href="recepcionEquipos.php" class="linksMenus">RECEPCION DE EQUIPOS PC/LAPTOP</a> <hr>
				<a href="equipo.php" class="linksMenus">REFACCIONES/PIEZAS DE EQUIPOS</a> |
				<a href="equipo.php" class="linksMenus">COMPONENTES RECICLADOS</a>  |
				<a href="gastoslocal.php" class="linksMenus">GASTOS DEL LOCAL</a>  |
				<a href="equipo.php" class="linksMenus">APERTURA CAJA</a> |
				<a href="equipo.php" class="linksMenus">CIERRE CAJA</a>

				<hr>
				
			</nav>
			<section>
				<?php 

					// CONSULTAR CAJA 
					$hoy = date('Y-m-d');
					echo '<h2>GASTOS DEL LOCAL HOY: '.$hoy.'<p/><h2>';


				?> 

					<form name="frmGasto" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<label>Concepto del Gasto:</label>
						<input type="text" name="conceptoGasto" size="60" required/><br/>
						<label>Total del Gasto:</label>
						<input type="numero" name="totalGasto" required /></br>
						<button name="guardarGasto" type="submit">GUARDAR GASTO</button>
					</form><br/><br/><br/>

					
				
				
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