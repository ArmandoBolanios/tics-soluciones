<?php
require('dat.php'); 
$Oxi = new mysqli( $servidor, $usuario, $contrasena, $bDatos );
if ($Oxi->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $Oxi->connect_errno . ") " . $Oxi->connect_error;
}
?>

