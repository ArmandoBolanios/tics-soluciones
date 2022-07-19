    <?php
    require('cn/cnt.php');
    if (isset($_POST['ventaCotizacion']) && !empty($_POST)) {
        $clave = $_REQUEST['clave'];
        $mostrar= '';
        $registro_venta = "";

        $venta2 =  $Oxi->query("SELECT DISTINCT productos.codigoProducto, productos.existencias, productos.precioUnitario, 
        productos.precioDeCompra, producto_cotizacion.cantidad, producto_cotizacion.codigoProducto, 
        producto_cotizacion.id_prod_ct, cotizacion.clave 
        FROM productos 
        INNER JOIN producto_cotizacion 
        ON productos.codigoProducto = producto_cotizacion.codigoProducto         
        INNER JOIN cotizacion ON cotizacion.clave = producto_cotizacion.clave 
        AND cotizacion.clave = '$clave' AND cotizacion.auxiliar = '1'
        ");
        while ($rows = mysqli_fetch_array($venta2)) {
            $codigoProducto = $rows["codigoProducto"];            
            $subUtilidad = (int)$rows["precioUnitario"] - (int)$rows["precioDeCompra"];
            $utilidad = (int)$subUtilidad * (int)$rows["cantidad"];
            $total = $rows["precioUnitario"] * $rows["cantidad"];
            $existenciasNuevas = (int)$rows["existencias"] - (int)$rows["cantidad"];

            // se hace insert de la tabla ventas1 para descontar de almacen
            $registro_venta .= "
            INSERT INTO ventas1(codigoArticulo,unidades,costoUnidades,total,fechaVenta,observaciones,utilidad) 
            VALUES(
            '" . $rows["codigoProducto"]    . "',
            '" . $rows["cantidad"]    . "',
            '" . $rows["precioUnitario"]    . "',
            '" . $total    . "',
            now(), 
            'VENTA POR COTIZACION',
            '" . $utilidad . "');
            
            UPDATE productos SET existencias='" . $existenciasNuevas . "' WHERE codigoProducto='" . $codigoProducto . "';
            UPDATE cotizacion SET auxiliar='0' WHERE clave='" . $clave . "';
            
            ";            
        }
        
        //$mostrar = $registro_venta;          

        $output = array('mostrar' => $mostrar);
        echo json_encode($output);
        mysqli_multi_query($Oxi, $registro_venta);
    }
