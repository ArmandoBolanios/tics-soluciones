<?php
require('../cn/cnt.php');
if (isset($_POST["clave"])) {
    $query = '';
    $nombre_cliente = mb_strtoupper($_REQUEST['nombre_cliente']);
    $telefono = $_REQUEST['telefono'];
    $correo = $_REQUEST['correo'];
    $direccion = $_REQUEST['direccion'];
    $clave = $_REQUEST['clave'];

    $actualizacion = "UPDATE cotizacion SET nombre_cliente='$nombre_cliente', 
    telefono='$telefono', correo = '$correo', direccion = '$direccion' WHERE clave='$clave'";    
    mysqli_query($Oxi, $actualizacion);

    $cliente = "SELECT * FROM cotizacion WHERE clave = '$clave'  ORDER BY clave ASC LIMIT 1 ";
    $sql = $Oxi->query($cliente);
    while ($rows = $sql->fetch_array(MYSQLI_ASSOC)) {
        $query .= '
            <h3>'. $rows["nombre_cliente"].'</h3>
            <input type="hidden" value="'. $rows["telefono"].'">
            <input type="hidden" value="'. $rows["correo"].'">
            <input type="hidden" value="'. $rows["direccion"].'">
            <input type="hidden" value="'. $clave.'" id="clave">
            <input type="submit" class="btnArticulo" id="edit_cliente" value="cambiar datos">
            <input type="submit" class="btnArticulo" id="add_articulo" value="agregar más">
            ';
            // asignarlos a las variables globales para mostrarlos en el modal
            $nombre_cliente = $rows["nombre_cliente"];
            $telefono = $rows["telefono"];
            $correo = $rows["correo"];
            $direccion = $rows["direccion"];
    }
   
    $output = array('mensaje' => $query);
    echo json_encode($output);
}
