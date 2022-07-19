<img src="banner2.png">
<hr>

<?php

// Desarrollador: Eduardo Cruz Romero
// Correo Electronico: eduar14_cr@hotmail.com
// Sitio Web: www.tics-tlapa.com
// Fecha de creacion:  19-09-2019
// Fecha de ultima modificacion: 19-11-2018
	
	require('cn/cnt.php'); 
	

	if (isset($_POST['BuscarEquipo'])) {

			$noEquipo = $_REQUEST['noEquipo'];

			$consultarEquipo = "SELECT * FROM equipo WHERE noEquipo = '$noEquipo'"; 

			if($result=$Oxi->query($consultarEquipo)) {
				$resultado = $result->fetch_array(MYSQLI_ASSOC)
				// EQUIPO ENCONTRADO CORRECTAMENTE 
?>
				<table border="0" width="100%" cellspacing="10" cellpadding="10">
					<tr>
						<td width="30%">
							<h2>Datos del Equipo: </h2>
							<b>Id Equipo:</b><?php echo ''.$resultado['idEquipo']; ?><br/><br/>
							<b>NO DE EQUIPO:</b><?php echo ''.$resultado['noEquipo']; ?><br/><br/>
							<b>MARCA:</b><?php echo ''.$resultado['marca']; ?><br/><br/>
							<b>MODELO:</b><?php echo ''.$resultado['modelo']; ?><br/><br/>
							<b>NO DE SERIE:</b><?php echo ''.$resultado['noSerie']; ?><br/><br/>
							<b>DESCRIPCION GENERAL:</b><?php echo ''.$resultado['descripcionGeneral']; ?><br/><br/>
							<b>FOTO:</b><br/><img src="<?php echo ''.$resultado['foto']; ?>" width="200px" height="250px"><br/><br/>
						</td>
						<td width="60%"><?php echo'<iframe name="contenedorPiezas" width="100%" height="500px" src="piezasDeEquipos.php?noEquipo='.$noEquipo.'"></iframe>'; ?></td>
					</tr>
				</table>
		
<?php 
			}
		} else {

?>
			<table border="1" width="100%">
	<tr>
		<td width="40%">

<h2>Registrar Piezas de Equipos/Reutilizar</h2>
<form name="registrar equipo" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<label>No Equipo a Buscar:</label>
	<input type="text" name="noEquipo" size="50">
	<br/><br/>
	<input type="button" name="button" id="button" value="Enviar" onclick="document.getElementById('marco').src='tupagina.php?variable='+document.getElementById('dato').value;" />
	<button type="submit" name="BuscarEquipo" onclick="document.getElementById('marco').src='piezasDeEquipos.php?noEquipo='+document.getElementById('dato').value;">Buscar Equipo</button>
</form>
<a href="index.php">Inicio</a> | <a href="equipo.php">Volver a Reistrar Equipos</a> | <a href="equiposregistrados.php">Ver Equipos Registrados</a>
</td>
		<td width="60%"><iframe name="contenedorPiezas" width="100%" height="500px" src="blanco.php">
		</iframe></td>
	</tr>
</table>

				
<?php						
	}

?>

	<a href="index.php">Inicio</a> | <a href="equipo.php">Volver a Reistrar Equipos</a> | <a href="equiposregistrados.php">Ver Equipos Registrados</a>



