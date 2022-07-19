<?php
session_start();
require('cn/cnt.php');

function generador()
{
    $fh = date("dis");
    $nram2 = mt_rand(1, 999);
    $idCmt = '';
    $id = $nram2 . $fh . $nram2;
    $id = $idCmt . '' . $id;
    $llave = 'CTZ' . str_shuffle($id);
    return $llave;
}

if (isset($_POST) && !empty($_SESSION["sess_cotizacion"])) {
    $query = '';
    $clave = generador();
    $nombre_cliente = mb_strtoupper($_REQUEST['nombre_cliente']);
    $telefono = $_REQUEST['telefono'];
    $correo = $_REQUEST['correo'];
    $direccion = ucwords($_REQUEST['direccion']);

    $total = 0;
    $total_articulos = 0;

    $tabla_cotizacion = "INSERT INTO cotizacion(clave, nombre_cliente, telefono, correo, direccion, fecha_cot, auxiliar) 
            VALUES('" . $clave . "', '" . $nombre_cliente . "', '" . $telefono . "', '" . $correo . "', 
            '" . $direccion . "', now(), '1');
            ";


    $tabla_producto_cotizacion = "";
    foreach ($_SESSION["sess_cotizacion"] as $keys => $values) {
        $codigo_producto = $values['codigo_producto'];
        $cantidad = $values['cantidad_producto'];
        $descripcion = $values['descripcion_producto'];
        $factor = $values['factor_producto'];
        $contenido = $values['contenido_producto'];
        $precio_unitario = $values['precio_unitario'];
        $sub_total = number_format($values['cantidad_producto'] * $values["precio_unitario"], 2);

        $total = $total + ($values['cantidad_producto'] * $values["precio_unitario"]);
        $total_articulos = count($_SESSION["sess_cotizacion"]);

        $tabla_producto_cotizacion .= "
            INSERT INTO producto_cotizacion(clave, codigoProducto, cantidad, descripcion, factor, contenido, precio_unitario, sub_total) 
            VALUES(
            '" . $clave . "',
            '" . $values["codigo_producto"]    . "',
            '" . $values["cantidad_producto"]    . "',
            '" . $values["descripcion_producto"]    . "',
            '" . $values["factor_producto"]    . "',
            '" . $values["contenido_producto"]    . "',
            '" . $values["precio_unitario"]    . "',
            '" . $sub_total    . "'); 
            ";
    }

    /* Esto verifica el sql esté correcto
    $query .= $nombre_cliente .'<br>' .$telefono.'<br>'.$correo.'<br>' .$direccion;
    $query .= '<br>' . $tabla_cotizacion;
    $output = array('mensaje' => $query);
    echo json_encode($output);
    */
    
    if (mysqli_query($Oxi, $tabla_cotizacion)) {        
        $idCotizacion = mysqli_insert_id($Oxi);
        mysqli_multi_query($Oxi, $tabla_producto_cotizacion);
        echo json_encode(array('lastId' => $idCotizacion, 'claveAfter' => $clave));
        unset($_SESSION["sess_cotizacion"]);
    } else {
        //echo json_encode(array('success' => 0));
        die('Error SQL: ' . mysqli_error($Oxi));
    }
    
}
