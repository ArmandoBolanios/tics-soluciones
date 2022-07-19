<img src="banner2.png">
<hr>

<?php

// Desarrollador: Eduardo Cruz Romero
// Correo Electronico: eduar14_cr@hotmail.com
// Sitio Web: www.tics-tlapa.com
// Fecha de creacion:  19-09-2019
// Fecha de ultima modificacion: 19-11-2018
	

	require('cn/cnt.php'); 
	

	if (isset($_POST['GuardarEquipo'])) {

			$noEquipo = $_REQUEST['noEquipo'];
			$marca = $_REQUEST['marca'];
			$modelo = $_REQUEST['modelo'];
			$noSerie = $_REQUEST['noSerie']; 
			$descripcion = $_REQUEST['descripcion']; 


			$prefijo = substr(md5(uniqid(rand())),0,6);
			$mran = rand(1,10000);
			$dir_subida = 'equipos/';
			$fichero_subido = $dir_subida.''.$prefijo.basename($_FILES['archivo']['name']);

		echo '<pre>';
			if (move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido)) {
			    echo "El fichero es válido y se subió con éxito.\n";
			} else {
			    echo "¡Posible ataque de subida de ficheros!\n";
			}

			$insertarRegistro = "INSERT INTO equipo(noEquipo,marca,modelo,noSerie,descripcionGeneral,foto) VALUES('$noEquipo','$marca','$modelo','$noSerie','$descripcion','$fichero_subido') "; 

			if($Oxi->query($insertarRegistro)) {
			echo '
			
			Registro insertado bien';

			echo '<a href="equipo.php"><br/><br/><br/><b>Regresar</b></a>';
		} else {
			echo 'Registro no insertado'; 
			echo '<a href="equipo.php"><br/><br/><br/><b>Regresar</b></a>';
		}


	} else {



?>

<h2>Registro de Equipos/Piezas</h2>
<form name="registrar equipo" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" >
	<label>No Equipo:</label>
	<input type="text" name="noEquipo" size="50" value="<?php echo date('Ymdhis'); echo rand(1,1000); ?>">
	<br/><br/>
	<label>Marca:</label>
	<input type="text" name="marca" size="50">
	<br/><br/>
	<label>Modelo:</label>
	<input type="text" name="modelo" size="50">
	<br/><br/>
	<label>No Serie:</label>
	<input type="text" name="noSerie" size="50">
	<br/><br/>
	<label>Descripcion General:</label><br>
	<textarea  rows="4" cols="60" name="descripcion">Hola...</textarea>
	<br/><br/>
	<label>foto:</label>
	<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
	<input type="file" name="archivo" accept="image/png, .jpeg, .jpg, image/gif" required /><br /><br/>
	<br/><br/>
	<button type="submit" name="GuardarEquipo">Guardar Equipo</button>
</form>
<a href="index.php">Inicio</a> | <a href="registrarPiezas.php">Registrar Piezas</a> | <a href="equiposregistrados.php">Ver Equipos Registrados</a>

<?php

}

?>