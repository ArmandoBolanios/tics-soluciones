<?php
require('../cn/cnt.php');

if (isset($_POST["producto_id"])) {
    $tabla = '';
    $totalCotizacion = '';
    $idArticulo = $_POST["producto_id"];
    $clave = $_POST["clave"];

    $tabla .= '
    <table class = "table2">
        <thead>
            <tr>
                <th>codigo</th>
                <th>Descripcion</th>
                <th>factor</th>
                <th>contenido</th>
                <th>existencias</th>
                <th>p. unitario</th>
                <th>cantidad</th>
                <th>subtotal</th>
                <th>#</th>
            </tr>
        </thead>        
    ';
    /* ------------------------------------------------------------------------------------------------------------- */
    if ($_POST["action"] == "eliminar") {
        $eliminacion = "DELETE FROM producto_cotizacion WHERE codigoProducto = '$idArticulo'";
        mysqli_query($Oxi, $eliminacion);
    }
    /* ------------------------------------------------------------------------------------------------------------- */
    if ($_POST["action"] == "cambiar_cantidad") {
        $codigoProducto = $_REQUEST['producto_id']; //CHECAR ESTO SI SE ESTA USANDO?
        $cantidad = $_REQUEST['quantity'];
        $precio_unitario = $_POST["precio_unitario"];

        $total = $precio_unitario * $cantidad;
        $total2 = $precio_unitario * 1;

        $verificar = $Oxi->query("SELECT existencias, codigoProducto FROM productos WHERE codigoProducto = '$idArticulo'");

        $actualizacion = "UPDATE producto_cotizacion SET cantidad='$cantidad', sub_total='$total' WHERE 
        codigoProducto='$idArticulo'";

        $actualizacion2 = "UPDATE producto_cotizacion SET cantidad='1', sub_total='$total2' WHERE 
        codigoProducto='$idArticulo'";

        while ($rows = mysqli_fetch_array($verificar)) {
            $almacen = $rows['existencias'];
            if ($almacen < $cantidad) {
                mysqli_query($Oxi, $actualizacion2);
            } else if ($almacen >= $cantidad) {
                mysqli_query($Oxi, $actualizacion);
            }
        }
    }
    /* ------------------------------------------------------------------------------------------------------------- */
    if ($_POST["action"] == "add") {
        $agregacion = "";
        $codigo_producto = $_POST["codigo_producto"];
        $descripcion_producto = $_POST['descripcion_producto'];
        $factor_producto = $_POST['factor_producto'];
        $contenido_producto = $_POST['contenido_producto'];
        $existencias_producto = $_POST['existencias_producto'];
        $precio_unitario = $_POST['precio_unitario'];
        $cantidad = $_POST['cantidad_producto'];

        $sub_total1 = $precio_unitario * $cantidad;

        $almacen = 0;
        $cantidad_cotizacion_pendiente = 0;
        $suma_cantidad = 0;
        $subtotal_principal = 0;
        $total1 = $precio_unitario * 1;
        // ---------------------------------- existe ? ---------------------------------------------------------------------------        
        $existe = "SELECT producto_cotizacion.clave, producto_cotizacion.codigoProducto 
        FROM producto_cotizacion INNER JOIN cotizacion ON producto_cotizacion.clave = cotizacion.clave 
        AND producto_cotizacion.codigoProducto = '$codigo_producto'
        AND producto_cotizacion.clave = '$clave'";
        $expresion = mysqli_query($Oxi, $existe) or die('err');
        // -------------------------------- verifica stock de productos ---------------------------------------------------------- 
        // hacer una unión de estas dos tablas, y así verificar el stock      
        $avanzada = $Oxi->query("SELECT DISTINCT productos.existencias, productos.codigoProducto, producto_cotizacion.cantidad, 
        producto_cotizacion.codigoProducto, producto_cotizacion.id_prod_ct, cotizacion.clave 
        FROM productos 
        INNER JOIN producto_cotizacion 
        ON productos.codigoProducto = producto_cotizacion.codigoProducto 
        AND producto_cotizacion.codigoProducto='$codigo_producto' 
        INNER JOIN cotizacion ON cotizacion.clave = producto_cotizacion.clave 
        AND cotizacion.clave = '$clave' AND cotizacion.auxiliar = '1';
        ");
        // calculando la cantidad que hay que sacar del almacen
        while ($rows = mysqli_fetch_array($avanzada)) {
            $almacen = $rows['existencias'];
            $cantidad_cotizacion_pendiente = $rows['cantidad'];
            $suma_cantidad = $cantidad_cotizacion_pendiente + $cantidad;
            if ($almacen > $suma_cantidad) {
                $subtotal_principal = $suma_cantidad * $precio_unitario;
            }
        }

        // --------------------------------- agregar! ----------------------------------------------------------------------------
        $agregacion .= "
        INSERT INTO producto_cotizacion(clave, codigoProducto, cantidad, descripcion, factor, contenido, precio_unitario, sub_total) 
        VALUES(
            '" . $clave . "',
            '" . $codigo_producto . "',
            '" . $cantidad . "',
            '" . $descripcion_producto . "',
            '" . $factor_producto . "',
            '" . $contenido_producto . "',
            '" . $precio_unitario . "',
            '" . $sub_total1 . "');
        ";

        // -------------------------------- actualiza los registros --------------------------------------------------------------
        $query1 = "UPDATE producto_cotizacion SET cantidad='1', sub_total='$total1' WHERE codigoProducto='$codigo_producto'";
        $query2 = "UPDATE producto_cotizacion SET cantidad='$suma_cantidad', sub_total='$subtotal_principal' WHERE codigoProducto='$codigo_producto'";

        // ----------------------------------------------------------------------------------------------------------------------
        // si existe, se hace la actualizacion, verificando que no sobrepase el stock en almacén 
        if (mysqli_num_rows($expresion) > 0) {
            // verificando stock
            if ($almacen < $suma_cantidad) {
                // query1
                mysqli_query($Oxi, $query1);
            } else if ($almacen >= $suma_cantidad) {
                // query2
                mysqli_query($Oxi, $query2);
            }
        } else {
            // hace nuevo registro en caso de que no exista el articulo
            mysqli_multi_query($Oxi, $agregacion);
        }
    }
    /* ------------------------------------------------------------------------------------------------------------- */
    $cantidadArticulos = 0;
    $articulos = "SELECT DISTINCT 
    productos.existencias,         
    producto_cotizacion.clave, producto_cotizacion.codigoProducto,
    producto_cotizacion.cantidad, producto_cotizacion.descripcion,
    producto_cotizacion.factor, producto_cotizacion.contenido,
    producto_cotizacion.precio_unitario, producto_cotizacion.sub_total
    FROM producto_cotizacion
    INNER JOIN productos    
    ON productos.codigoProducto = producto_cotizacion.codigoProducto 
    INNER JOIN cotizacion 
    ON cotizacion.clave = producto_cotizacion.clave 
    AND cotizacion.clave = '$clave' AND cotizacion.auxiliar = '1';";
    $suma_total = 0;
    /* Muestra la tabla actualizada */
    $sql_cotizacion = $Oxi->query($articulos);
    while ($fila = $sql_cotizacion->fetch_array(MYSQLI_ASSOC)) {
        $tabla .= '
        <tbody>
            <tr>
            <td>' . $fila["codigoProducto"] . '</td>
            <input type="hidden" value="' . $clave . '" id="clave">
            <td>' . $fila["descripcion"] . '</td>
            <td>' . $fila["factor"] . '</td>
            <td>' . $fila["contenido"] . '</td>
            <td>' . $fila["existencias"] . '</td>
            <td>' . $fila["precio_unitario"] . '</td>
            <input type="hidden" id="precio' . $fila["codigoProducto"] . '" value="' . $fila["precio_unitario"] . '" name="precio_unitario">
            <td>
                <input type="text" name="quantity[]" id="quantity' . $fila["codigoProducto"] . '" value="' . $fila["cantidad"] . '" 
                class="cantidad quantity" data-producto_id="' . $fila["codigoProducto"] . '" autocomplete="off">               
            </td>
            <td>$' . number_format($fila['cantidad'] * $fila['precio_unitario'], 2) . '
            </td>
            <td><a class="delete" id="' . $fila["codigoProducto"] . '">Eliminar</a></td>
            </tr>
        ';
        $suma_total = $suma_total + ($fila['cantidad'] * $fila["precio_unitario"]);
        $cantidadArticulos = $cantidadArticulos + $fila['cantidad'];
    }
    $tabla .= '                
        </tbody>
    </table>';

    if ($cantidadArticulos > 0) {
        $totalCotizacion .= '
        <div class="totalFooter">
            <h3>Total $' . number_format($suma_total, 2) . '</h3>            
        </div>
        <div class="totalFooter">
            <input type="submit" class="btnVentaCotizacion" name="VentaCotizacion" value="REALIZAR VENTA">
        </div>';
    } else {
        $totalCotizacion .= '
        <div class="totalCotizacion">
            <div class="totalFooter">
                <p class="advertencia">Debe agregar articulos a su cotización</p>
            </div>
        </div>
        ';
    }


    $output = array('tabla' => $tabla, 'totalCotizacion' => $totalCotizacion);
    echo json_encode($output);
}
