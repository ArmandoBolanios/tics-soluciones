<center><img src="banner2.png"><br/><br/><br/>

<?php

require('cn/cnt.php'); 

$consultarDatos = "SELECT * FROM productos";
$dat = $Oxi->query($consultarDatos); 
$precioCompra=0;
$unidades=0;
$subtotal = 0;
$total = 0;

echo '<table border="0" cellspacing="1" cellpadding="2" bordercolor="#336699" bgcolor="#336699">
			<tr>
				<td>ID</td>
				<td>COD.ART</td>
				<td>DESCRIPCION</td>
				<td>CONT</td>
				<td>EXIS</td>
				<td>P.VENT</td>
				<td>UBIC</td>
				<td>MODIFICAR</td>
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
				<td>'.$datRes['idProducto'].'</td>
				<td>'.$datRes['codigoProducto'].'</td>
				<td>'.$datRes['descripcion'].' ('.$datRes['categoria'].')</td>
				<td>'.$datRes['contenido'].'</td>
				'; 
				if ($datRes['existencias']<=5) {
					echo '<td bgcolor="#FF0000">'.$datRes['existencias'].'</td>';
				} else {
					echo '<td>'.$datRes['existencias'].'</td>';
				}
	echo '
				
				
				<td>'.$datRes['precioUnitario'].'</td>
				<td>'.$datRes['ubicacion'].'</td>
				<td>
					<form name="frmVentas" method="post" action="modificar.php">
					<input type="hidden" name="busqueda" value="'.$datRes['codigoProducto'].'"/>
					<button type="submit" name="busquedaCodigo">MODIFICAR</button>
					</form></td>
			</tr>
				'; 

				$subtotal = $datRes['existencias'] * $datRes['precioDeCompra']; 
				$total = $total+$subtotal;
$color++;
} 


echo $total;

?>
</table>
<a href="index.php"><h1>Inicio</h1></a>